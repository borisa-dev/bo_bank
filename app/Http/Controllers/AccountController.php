<?php

namespace App\Http\Controllers;

use App\Http\Requests\Account\UpAccountRequest;
use App\Interfaces\Repositories\IAccount;
use Symfony\Component\HttpFoundation\Response;

class AccountController extends Controller
{

    public function __construct(public IAccount $account)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function upBalance(UpAccountRequest $request, string $accountNumber)
    {
       try {
            $this->account->updateByNumber($accountNumber, $request->validated());
            return response()->json(['success' => 'ok'])->setStatusCode(Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()
                ->json(['message' => $th->getMessage()])
                ->setStatusCode(Response::HTTP_BAD_REQUEST);
        }
    }
}
