<?php

namespace App\Http\Resources\Products;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductsResources extends JsonResource
{
    public function toArray(Request $request)
    {
        return ProductShortResource::collection($this->resource);
    }
}
