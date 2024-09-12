<?php

namespace App\Interfaces\Repositories;

use App\Models\Account;

interface IAccount extends ICrud
{
    public function fundAccountByAccountNumber(string $accountNumber): null|Account;


    public function updateByNumber(string $accountNumber, array $data);
}
