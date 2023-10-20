<?php

namespace App\Http\Controllers\Helpers;

use Orchid\Attachment\Models\Attachment;

trait Images
{
    /**
     * @param array $data
     * @return string
     */
    public function getUrl(Attachment $attachment): string
    {
        return public_path() . $attachment->path . $attachment->name . '.' . $attachment->extension;
    }
}
