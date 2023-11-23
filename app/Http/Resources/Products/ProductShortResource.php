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
//            'image' => $this->getUrl($this->attachment('preview')->first()),
            'image' => "https://valscvetov.ru/storage/2023/10/17/2ae581daf9cbc1639c51f6666af87da72e2da5d7.jpg",
            'is_active' => $this->is_active,
            'is_deactivation' => $this->category->is_deactivation,
        ];
    }
}
