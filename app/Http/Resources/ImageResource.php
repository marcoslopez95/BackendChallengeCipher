<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use League\CommonMark\Node\Block\Document;

class ImageResource extends JsonResource
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
            'imageable_type'=>$this->resource->imageable_type,
            'imageable_id'=>$this->resource->imageable_id,
            'path'=>$this->resource->path,
            'name'=>$this->resource->name,
            'extension'=>$this->resource->extension,
            'description'=>$this->resource->description,
        ];
    }
}
