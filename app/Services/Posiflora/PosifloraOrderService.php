<?php

namespace App\Services\Posiflora;

use App\Models\PosifloraOrder;

class PosifloraOrderService
{
    public function storeIfNotExists(array $orderData): ?PosifloraOrder
    {
        return PosifloraOrder::firstOrCreate(
            ['external_uid' => $orderData['external_uid']],
            [
                'docNo' => $orderData['docNo'],
                'amount' => $orderData['amount'],
                'status' => 'new',
            ]
        );
    }
}
