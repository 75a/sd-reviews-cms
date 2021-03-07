<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WidgetResource extends JsonResource
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
            'aaaaa' => $this->aaaaaaaaaa,
            'aaaaa' => $this->aaaaaaaaaa,
            'aaaaa' => $this->aaaaaaaaaa,
            'aaaaa' => $this->aaaaaaaaaa,
            'aaaaa' => $this->aaaaaaaaaa,
            'aaaaa' => $this->aaaaaaaaaa,
            'aaaaa' => $this->aaaaaaaaaa,
            'aaaaa' => $this->aaaaaaaaaa,
            'aaaaa' => $this->aaaaaaaaaa,
            'aaaaa' => $this->aaaaaaaaaa,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
