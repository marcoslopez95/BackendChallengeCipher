<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use League\CommonMark\Node\Block\Document;

class ProductResource extends JsonResource
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
            'description'=>$this->resource->description,
            'cost'=>$this->resource->cost,
            'price'=>$this->resource->price,
            'image'=> $this->whenLoaded(
                relationship:'image',
                value: fn() => $this->image
        )
        ];
    }
}
