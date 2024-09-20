<?php

namespace App\Repositories;

use App\Interfaces\Repositories\IAccount;
use App\Models\Account;
use App\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Builder;

class AccountRepository implements IAccount
{
    use CrudTrait;

    public function getModel(): Builder
    {
        return Account::query();
    }

    public function fundAccountByAccountNumber(string $accountNumber): null|Account
    {
        return $this->getModel()->where('account_number', '=', $accountNumber)->firstOrFail();
    }

    public function updateByNumber(string $accountNumber, array $data): Account
    {
        $account = $this->fundAccountByAccountNumber($accountNumber);
        $account->fill($data)->save();
        return $account;
    }

}
