<?php

namespace Companue\Contacts\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Companue\Contacts\Http\Resources\ContactDetailDisplayItem;
use Companue\Contacts\Models\ContactTitle;

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
            'type' => __("contacts::terms." . $this->type),
            'category' => $this->category ? __("contacts::terms." . $this->category) : null,
            'title' => ($title = ContactTitle::find($this->title)) ? $title->title : null,
            'name_firstname' => $this->name_firstname,
            'brand_lastname' => $this->brand_lastname,
            'national_code' => $this->national_code,
            'creator_id' => $this->creator_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'details' => ContactDetailDisplayItem::collection($this->details),
        ];
    }
}
