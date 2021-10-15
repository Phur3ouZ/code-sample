<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PriceResource extends JsonResource
{
    /**
     * Define inputs as `Price` model to allow IDE to use `Price` specific functions
     *
     * @var \App\Models\Price
     */
    public $resource;

    /**
     * Return `Price` results in a specific format
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->resource->getKey(),
            'amount' => round($this->resource->amount * config('currency.rate'), 2),
            'currency' => config('currency.request'),
        ];
    }
}
