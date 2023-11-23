<?php

namespace App\Http\Resources\Banners;

use App\Http\Controllers\Helpers\Images;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BannerResource extends JsonResource
{
    use Images;

    public function toArray(Request $request)
    {
        return [
            'id' => $this->id,
            'src' => $this->getUrl($this->attachment('preview')->first()),
            'link' => $this->link
        ];
    }
}
