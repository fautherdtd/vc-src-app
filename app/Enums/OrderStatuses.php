<?php

namespace App\Enums;

enum OrderStatuses: string
{
    case New = 'Новый';
    case Processing = 'На оформлении';
    case Shipped = 'Доставляется';
    case Delivered = 'Доставлен';
    case Cancelled = 'Отменен';
}
