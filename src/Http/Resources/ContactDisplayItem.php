<?php

namespace Companue\Contacts\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Companue\Contacts\Http\Resources\ContactDetailDisplayItem;
use Companue\Contacts\Models\ContactCategory;
use Companue\Contacts\Models\ContactTitle;
use Companue\Contacts\Models\ContactType;

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
        // return parent::toArray($request);

        // Handle type as comma-separated list and translate
        $typeList = [];
        $typeTranslated = [];
        if (!empty($this->type)) {
            $typeList = array_map('trim', explode(',', $this->type));
            $typeTranslated = array_map(function ($slug) {
                $typeModel = ContactType::where('slug', $slug)->first();
                if ($typeModel) {
                    // Use translation if available, fallback to title
                    return __("contacts::contact_types." . $typeModel->title);
                }
                return $slug;
            }, $typeList);
        }

        return [
            'id' => $this->id,
            'label' => $this->label,
            // 'type' => $typeList,
            'type' => $typeTranslated,
            'category' => $this->category ? __("contacts::contact_categories." . ContactCategory::where('slug', $this->category)->sole()->title) : null,
            'title' => ($title = ContactTitle::find($this->title)) ? $title->title : null,
            'name_firstname' => $this->name_firstname,
            'brand_lastname' => $this->brand_lastname,
            'national_code' => $this->national_code,
            'is_incomplete' => $this->is_incomplete,
            'has_details' => $this->has_details,
            'creator_id' => $this->creator_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            '_resource' => ContactItem::make($this),
            // 'details' => ContactDetailDisplayItem::collection($this->details),
        ];
    }
}
