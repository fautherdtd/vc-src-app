<?php

namespace App\Enums;

enum PaymentStatuses: string
{
    case True = 'Оплачен';
    case False = 'Не оплачен';
}
