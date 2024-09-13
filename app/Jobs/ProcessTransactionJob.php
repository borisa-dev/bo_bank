<?php

namespace App\Jobs;

use App\Enums\TransactionStatusEnum;
use App\Events\Transaction\TransactionProcessedSuccessfully;
use App\Events\Transaction\TransactionProcessedWithError;
use App\Interfaces\Repositories\IAccount;
use App\Interfaces\Repositories\ITransaction;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class ProcessTransactionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public ITransaction $transaction;
    public IAccount     $account;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public $transactionId,
    )
    {
        $this->transaction = app(ITransaction::class);
        $this->account = app(IAccount::class);
    }

    /**
     * Handles the transaction processing by updating the status of the transaction,
     * adjusting the sender's and receiver's account balances, and broadcasting
     * the success or failure of the transaction.
     *
     * This method performs the following steps:
     * - Starts a database transaction.
     * - Updates the transaction status to "DONE".
     * - Deducts the transaction amount from the sender's account and resets the frozen amount.
     * - Adds the transaction amount to the receiver's account.
     * - Commits the database transaction if successful.
     * - If an exception occurs, rolls back the transaction and updates the transaction
     *   status to "CANCELLED".
     * - Broadcasts a success event on successful completion, or an error event if an
     *   exception occurs.
     *
     * @return void
     * @throws \Exception If any error occurs during the transaction process.
     */
    public function handle(): void
    {
        try {
            DB::beginTransaction();
            $transaction = $this->transaction->update($this->transactionId, [
                'status' => TransactionStatusEnum::DONE->value,
            ]);

            $sender = $this->account->fundAccountByAccountNumber($transaction->sender_account_number);
            $sender->update([
                'amount'        => $sender->amount - $transaction->amount,
                'frozen_amount' => 0,
            ]);

            $receiver = $this->account->fundAccountByAccountNumber($transaction->receiver_account_number);
            $receiver->update([
                'amount' => $receiver->amount + $transaction->amount,
            ]);
            DB::commit();
            broadcast(new TransactionProcessedSuccessfully($this->transactionId));
        } catch (\Exception $e) {
            DB::rollBack();
            $this->transaction->update($this->transactionId, [
                'status' => TransactionStatusEnum::CANCELLED->value,
            ]);
            broadcast(new TransactionProcessedWithError($this->transactionId, $e->getMessage()));
        }
    }
}
