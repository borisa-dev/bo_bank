<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::apiResource('users', UserController::class)->only(['index', 'update']);
Route::put('accounts/{number}', [AccountController::class, 'upBalance']);
Route::post('transactions/send', [TransactionController::class, 'sendMoney']);
