<?php

namespace App\Providers;

use App\Interfaces\Repositories\IAccount;
use App\Interfaces\Repositories\ITransaction;
use App\Interfaces\Repositories\IUser;
use App\Repositories\AccountRepository;
use App\Repositories\TransactionRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class DiServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->app->bind(IUser::class, UserRepository::class);
        $this->app->bind(IAccount::class, AccountRepository::class);
        $this->app->bind(ITransaction::class, TransactionRepository::class);
    }
}
