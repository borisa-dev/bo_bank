<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserAndAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user1 = User::create([
            'name'              => 'User 1',
            'email'             => 'user1@gmail.com',
            'password'          => '12345678',
            'date_of_birth'     => Carbon::create(1987, 5, 12),
            'email_verified_at' => Carbon::now(),
        ]);
        Account::create([
            'account_number' => Str::random(32),
            'user_id'        => $user1->id,
            'amount'         => 1000.55,
        ]);
        $user2 = User::create([
            'name'              => 'User 2',
            'email'             => 'user2@gmail.com',
            'password'          => '87654321',
            'date_of_birth'     => Carbon::create(1990, 1, 1),
            'email_verified_at' => Carbon::now(),
        ]);
        Account::create([
            'account_number' => Str::random(32),
            'user_id'        => $user2->id,
            'amount'         => 1100.33,
        ]);
    }
}
