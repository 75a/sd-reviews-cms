<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'header' => $this->header,
            'rating' => $this->rating,
            'main_content' => $this->main_content,
            'is_published' => $this->is_published,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'attributes' => $this->reviewAttributes,
            'ratings' => $this->ratings,
            'comments' => $this->comments
        ];
    }
}
