<?php

namespace App\Http\Resources\Categories;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoriesResources extends JsonResource
{
    public function toArray(Request $request)
    {
        return CategoryResource::collection($this->resource);
    }
}
