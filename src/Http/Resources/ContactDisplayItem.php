<?php

namespace Companue\Contacts\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContactDisplayItem extends JsonResource
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
            'label' => $this->label,
            'type' => $this->type,
            'category' => $this->category,
            'title' => $this->title,
            'name_firstname' => $this->name_firstname,
            'brand_lastname' => $this->brand_lastname,
            'national_code' => $this->national_code,
            'creator_id' => $this->creator_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            // Add more fields as needed
        ];
    }
}
