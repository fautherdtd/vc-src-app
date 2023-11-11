<?php

namespace App\Http\Resources;

use App\Http\Controllers\Helpers\Images;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PageResource extends JsonResource
{
    use Images;

    public function toArray(Request $request)
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'body' => $this->body,
            'seo_title' => $this->seo_title,
            'seo_description' => $this->seo_description,
            'images' => $this->gallery(),
        ];
    }

    /**
     * @return array
     */
    protected function gallery(): array
    {
        foreach ($this->attachment('gallery')->get() as $value) {
            $gallery[] = $this->getUrl($value);
        }
        return $gallery;
    }
}
