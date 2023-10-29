<?php

namespace App\Http\Resources\FAQ;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FAQResources extends JsonResource
{
    public function toArray(Request $request)
    {
        return FAQResource::collection($this->resource);
    }
}
