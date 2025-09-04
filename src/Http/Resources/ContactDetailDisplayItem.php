<?php

namespace Companue\Contacts\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContactDetailDisplayItem extends JsonResource
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
            'detail_title' => $this->detail_title,
            'address' => $this->address,
            'postal_code' => $this->postal_code,
            'phone_number' => $this->phone_number,
            'mobile_number' => $this->mobile_number,
            'is_primary' => $this->is_primary,
        ];
    }
}
