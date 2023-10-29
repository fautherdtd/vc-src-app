<?php

namespace App\Http\Resources\FAQ;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FAQResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content
        ];
    }
}
