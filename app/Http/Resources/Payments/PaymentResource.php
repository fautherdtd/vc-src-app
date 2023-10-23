<?php

namespace App\Http\Resources\Payments;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'label' => $this->label,
            'method' => $this->method
        ];
    }
}
