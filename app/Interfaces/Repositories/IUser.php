<?php

namespace App\Interfaces\Repositories;

interface IUser extends ICrud
{
    /**
     * @param int $paginate
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAllWithAccounts(int $paginate): \Illuminate\Contracts\Pagination\LengthAwarePaginator;
}
