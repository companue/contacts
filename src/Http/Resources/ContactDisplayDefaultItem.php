<?php

namespace Companue\Contacts\Http\Resources;

class ContactDisplayDefaultItem extends ContactItem
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = parent::toArray($request);
        // Override or add fields specific to default detail with null checks
        $data['address'] = $this->default_detail ? $this->default_detail->address : "-";
        $data['postal_code'] = $this->default_detail ? $this->default_detail->postal_code : "-";
        $data['phone_number'] = $this->default_detail ? $this->default_detail->phone_number : "-";
        $data['mobile_number'] = $this->default_detail ? $this->default_detail->mobile_number : "-";

        return $data;
    }
}
