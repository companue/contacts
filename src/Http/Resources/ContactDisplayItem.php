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
        // Handle type as comma-separated list and translate
        $typeList = [];
        $typeTranslated = [];
        if (!empty($this->type)) {
            $typeList = array_map('trim', explode(',', $this->type));
            $typeTranslated = array_map(function ($type) {
                return __("contacts::contact_types." . $type);
            }, $typeList);
        }

        return [
            'id' => $this->id,
            'label' => $this->label,
            // 'type' => $typeList,
            'type' => $typeTranslated,
            'category' => $this->category ? __("contacts::contact_categories." . $this->category) : null,
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
