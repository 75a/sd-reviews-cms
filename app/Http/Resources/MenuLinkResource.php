<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MenuLinkResource extends JsonResource
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
            'menu_name' => $this->menu_name,
            'label' => $this->label,
            'url' => $this->url,
            'zindex' => $this->zindex,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
