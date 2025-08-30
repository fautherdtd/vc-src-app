<?php

namespace App\Http\Controllers\Helpers;

use Illuminate\Support\Facades\Storage;
use Orchid\Attachment\Models\Attachment;

trait Images
{
    /**
     * @param Attachment|null $attachment
     * @return string
     */
    public function getUrl(Attachment $attachment = null): string
    {
        if (is_null($attachment)) {
            return 'https://avatars.mds.yandex.net/get-tycoon/6283051/2a0000018bb8ee8143b8a38ebea0307ea3b0/priority-headline-logo-square';
        }
        return Storage::disk('public')->url($attachment->path . $attachment->name . '.' . $attachment->extension);
    }
}
