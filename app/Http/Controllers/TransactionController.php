<?php

namespace App\Http\Controllers;

use App\Http\Requests\Transaction\SendTransactionRequest;
use App\Interfaces\Repositories\IAccount;
use App\Interfaces\Repositories\ITransaction;
use App\Jobs\ProcessTransactionJob;
use Symfony\Component\HttpFoundation\Response;

class TransactionController extends Controller
{
    public function __construct(
        public ITransaction $transaction,
        public IAccount     $account,
    )
    {
    }

    public function sendMoney(SendTransactionRequest $request)
    {
        try {
            $transaction = $this->transaction->create($request->validated());
            $this->account->updateByNumber($request->sender_account_number, [
                'frozen_amount' => $request->amount
            ]);
            ProcessTransactionJob::dispatch($transaction->id);
            return response()->json(['success' => 'Transaction in progress'])->setStatusCode(Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()
                ->json(['message' => $th->getMessage()])
                ->setStatusCode(Response::HTTP_BAD_REQUEST);
        }
    }
}
