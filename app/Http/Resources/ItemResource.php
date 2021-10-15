<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
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
     * Return `Item` results in a specific format
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->resource->getKey(),
            'barcode' => $this->resource->barcode,
            'name' => $this->resource->name,
            'description' => $this->resource->description,
            'price' => new PriceResource($this->Price),
        ];
    }

    /**
     * @param  mixed  $resource
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public static function collection($resource): AnonymousResourceCollection
    {
        // Eager load prices to avoid n+1 problem
        $resource->loadMissing([
            'Price',
        ]);
        return parent::collection($resource);
    }
}
