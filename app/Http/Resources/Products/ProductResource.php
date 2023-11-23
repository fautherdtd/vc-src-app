<?php

namespace App\Http\Resources\Products;

use App\Http\Controllers\Helpers\Images;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    use Images;

    public function toArray(Request $request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'chars' => $this->chars,
            'price' => $this->price,
            'description' => $this->description,
            'compound' => $this->compound,
            'category' => $this->category,
            'image' => $this->getUrl($this->attachment('preview')->first()),
            'gallery' => $this->gallery(),
            'modify' => $this->modify,
            'seo_title' => $this->seo_title,
            'seo_description' => $this->seo_description,
            'is_active' => $this->is_active,
        ];
    }

    /**
     * @return array
     */
    protected function gallery(): array
    {
        $gallery = [
            $this->getUrl($this->attachment('preview')->first())
        ];
        foreach ($this->attachment('gallery')->get() as $value) {
            $gallery[] = $this->getUrl($value);
        }
        return $gallery;
    }
}
