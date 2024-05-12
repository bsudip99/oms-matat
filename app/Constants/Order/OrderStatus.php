<?php

namespace App\Constants\Order;

enum OrderStatus: string
{
    case PENDING = 'pending';
    case PROCESSING = 'processing';
    case ON_HOLD  = 'on_hold';
    case COMPLETED = 'completed';
    case CANCELLED= 'cancelled';
    case REFUNDED = 'refunded';
    case FAILED= 'failed';
    case TRASH= 'trash';
}
