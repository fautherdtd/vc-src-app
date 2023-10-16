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
//        dd($this->attachment('preview')->first());
        return [
            'id' => $this->id,
            'name' => $this->name,
            'chars' => $this->chars,
            'price' => $this->price,
            'compound' => $this->compound,
            'image' => $this->getUrl($this->attachment('preview')->first())
        ];
    }
}
