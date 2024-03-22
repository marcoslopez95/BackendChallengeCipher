<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use League\CommonMark\Node\Block\Document;

class CurrencyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->resource->id,
            'name'=>$this->resource->name,
            'abbreviation'=>$this->resource->abbreviation,
            'symbol'=>$this->resource->symbol,
            'exchange'=>$this->resource->exchange,
            'principal'=>$this->resource->principal,
        ];
    }
}
