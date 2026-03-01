<?php

namespace App\Enums;

enum OrderStatus: string
{
    case Pending = 'pending';
    case Processing = 'processing';
    case Cancelled = 'cancelled';
    case Refunded = 'refunded';
}
