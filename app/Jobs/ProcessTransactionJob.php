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
     * Execute the job.
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
