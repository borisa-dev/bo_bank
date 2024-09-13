<?php

namespace App\Repositories;

use App\Interfaces\Repositories\ITransaction;
use App\Models\Account;
use App\Models\Transaction;
use App\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Builder;

class TransactionRepository implements ITransaction
{
    use CrudTrait;

    /**
     * @return Builder
     */
    public function getModel(): Builder
    {
        return Transaction::query();
    }
}
