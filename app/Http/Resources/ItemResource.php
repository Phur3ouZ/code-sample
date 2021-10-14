<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
{
    /**
     * Define inputs as `Item` model to allow IDE to use `Item` specific functions
     *
     * @var \App\Models\Item
     */
    public $resource;

    /**
     * Return `item` results in a specific format
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return $this->resource->toArray();
    }
}
