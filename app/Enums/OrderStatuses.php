<?php

namespace App\Enums;

enum OrderStatuses: string
{
    case New = 'Новый';
    case Processing = 'На оформлении';
    case Shipped = 'Доставляется';
    case Delivered = 'Доставлен';
    case Cancelled = 'Отменен';

    public static function fromName(string $name): string
    {
        foreach (self::cases() as $status) {
            if (ucwords($name) === $status->name ){
                return $status->value;
            }
        }
        throw new \ValueError("$name is not a valid backing value for enum " . self::class );
    }
}
