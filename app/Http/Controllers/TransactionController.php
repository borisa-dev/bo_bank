<?php

namespace App\Http\Controllers;

use App\Http\Requests\Transaction\SendTransactionRequest;
use App\Interfaces\Repositories\ITransaction;
use Symfony\Component\HttpFoundation\Response;

class TransactionController extends Controller
{
    public function __construct(
        public ITransaction $transaction
    )
    {
    }

    public function sendMoney(SendTransactionRequest $request)
    {
        try {
            $this->transaction->create($request->all());
            return response()->json(['success' => 'Transaction in progress'])->setStatusCode(Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()
                ->json(['message' => $th->getMessage()])
                ->setStatusCode(Response::HTTP_BAD_REQUEST);
        }
    }
}
