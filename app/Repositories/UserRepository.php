<?php

namespace App\Repositories;

use App\Interfaces\Repositories\IUser;
use App\Models\User;
use App\Traits\CrudTrait;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class UserRepository implements IUser
{
    use CrudTrait;

    public function getModel(): Builder
    {
        return User::query();
    }

    /**
     * @param int $paginate
     * @return LengthAwarePaginator
     */
    public function getAllWithAccounts(int $paginate = 20): LengthAwarePaginator
    {
        return $this->getModel()
            ->with('accounts')
            ->paginate($paginate);
    }
}
