<?php

namespace Companue\Contacts\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DropdownContactCategoryItem extends JsonResource
{
    public function toArray($request)
    {
        return [
            'value' => $this->slug,
            'label' => __('contacts::contact_categories.' . $this->title),
        ];
    }
}
