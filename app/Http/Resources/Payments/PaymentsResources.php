<?php

namespace App\Http\Resources\Payments;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentsResources extends JsonResource
{
    public function toArray(Request $request)
    {
        return PaymentResource::collection($this->resource);
    }
}
