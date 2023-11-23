<?php

namespace App\Http\Controllers;

use App\Http\Resources\Banners\BannerResource;
use App\Models\Banners;

class BannerController extends Controller
{
    /**
     * @return BannerResource|null
     */
    public function getBanner(): ?BannerResource
    {
        $model = Banners::where([
            ['type', 'modal'],
            ['is_active', true]
        ])->first();
        if ($model !== null) {
            return new BannerResource($model);
        }
        return null;
    }
}
