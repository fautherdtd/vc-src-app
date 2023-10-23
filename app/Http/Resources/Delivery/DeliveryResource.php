<?php

namespace App\Http\Resources\Delivery;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DeliveryResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'label' => $this->label,
            'method' => $this->method
        ];
    }
}
