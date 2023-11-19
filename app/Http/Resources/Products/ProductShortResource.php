<?php

namespace App\Http\Resources\Products;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Controllers\Helpers\Images;

class ProductShortResource extends JsonResource
{
    use Images;

    public function toArray(Request $request)
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'name' => $this->name,
            'price' => $this->price,
            'compound' => mb_strimwidth($this->compound, 0, 45, ".."),
            'image' => $this->getUrl($this->attachment('preview')->first()),
            'is_active' => $this->is_active
        ];
    }
}
