<?php

namespace App\Interfaces\Repositories;

use App\Models\Account;

interface IAccount extends ICrud
{
    /**
     * @param string $accountNumber
     * @return Account|null
     */
    public function fundAccountByAccountNumber(string $accountNumber): null|Account;

    /**
     * @param string $accountNumber
     * @param array  $data
     * @return mixed
     */
    public function updateByNumber(string $accountNumber, array $data);
}
