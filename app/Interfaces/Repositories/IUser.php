<?php

namespace App\Interfaces\Repositories;

interface IUser extends ICrud
{
    public function getAllWithAccounts(int $paginate): \Illuminate\Contracts\Pagination\LengthAwarePaginator;
}
