<?php

namespace App\Http\Resources\Categories;

use App\Http\Controllers\Helpers\Images;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    use Images;

    public function toArray(Request $request)
    {
        return [
            'name' => $this->name,
            'slug' => $this->slug,
            'position' => $this->position,
            'seo_title' => $this->seo_title,
            'seo_description' => $this->seo_description,
            'image' => $this->getUrl($this->attachment('preview')->first())
        ];
    }
}
