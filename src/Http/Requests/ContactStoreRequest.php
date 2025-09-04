<?php

namespace Companue\Contacts\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'label' => 'required|string|max:255',
            'type' => 'required|string|max:50',
            'category' => 'required|string|max:50',
            'title' => 'nullable|string|max:255',
            'name_firstname' => 'nullable|string|max:255',
            'brand_lastname' => 'nullable|string|max:255',
            'national_code' => 'nullable|string|max:20|unique:contacts,national_code',
            'creator_id' => 'nullable|integer',
        ];
    }
}
