<?php

namespace App\Http\Controllers\Helpers;

use Illuminate\Support\Facades\Storage;
use Orchid\Attachment\Models\Attachment;

trait Images
{
    /**
     * @param array $data
     * @return string
     */
    public function getUrl(Attachment $attachment): string
    {
        return Storage::disk('public')->url($attachment->path . $attachment->name . '.' . $attachment->extension);
    }
}
