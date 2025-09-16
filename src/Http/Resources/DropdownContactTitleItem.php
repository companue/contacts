<?php

namespace Companue\Contacts\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DropdownContactTitleItem extends JsonResource
{
    public function toArray($request)
    {
        return [
            'value' => $this->id,
            'label' =>  $this->title,
        ];
    }
}
