<?php

namespace App\Enum;

enum OrderStatusEnum: string
{
    case PAID = 'paid';
    case UNPAID = 'unpaid';
    case CANCELED = 'canceled';
}
