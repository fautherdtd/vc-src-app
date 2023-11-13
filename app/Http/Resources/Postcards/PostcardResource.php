<?php

namespace App\Http\Resources\Postcards;

use App\Http\Controllers\Helpers\Images;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostcardResource extends JsonResource
{
    use Images;

    public function toArray(Request $request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'images' => $this->images()
        ];
    }


    /**
     * @return array
     */
    protected function images(): array
    {
        $gallery = [];
        foreach ($this->attachment('postcards')->get() as $value) {
            $gallery[] = $this->getUrl($value);
        }
        return $gallery;
    }
}
