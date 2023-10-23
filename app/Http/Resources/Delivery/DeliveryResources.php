<?php

namespace App\Http\Resources\Delivery;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DeliveryResources extends JsonResource
{
    public function toArray(Request $request)
    {
        return DeliveryResource::collection($this->resource);
    }
}
