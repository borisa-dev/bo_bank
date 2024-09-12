<?php

namespace App\Enums;

enum TransactionStatusEnum: int
{
    case PENDING   = 1;
    case DONE      = 2;
    case CANCELLED = 3;
}
