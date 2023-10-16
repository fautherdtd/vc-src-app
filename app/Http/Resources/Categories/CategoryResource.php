<?php

namespace App\Http\Resources\Categories;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'name' => $this->name,
            'slug' => $this->slug,
            'position' => $this->position,
            'seo_title' => $this->seo_title,
            'seo_description' => $this->seo_description
        ];
    }
}
