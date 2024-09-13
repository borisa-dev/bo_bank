<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('transaction-status', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
