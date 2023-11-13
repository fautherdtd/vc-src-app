<?php

namespace App\Http\Resources\Postcards;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostcardsResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return PostcardResource::collection($this->resource);
    }
}
