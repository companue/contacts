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
            'label' => 'required_without:name_firstname|string|max:255',
            'name_firstname' => 'required_without:label|string|max:255',
            'type' => 'required|string|max:50',
            'category' => 'nullable|string|max:50',
            'title' => 'nullable|string|max:255',
            'brand_lastname' => 'nullable|string|max:255',
            'national_code' => 'nullable|digits:10|unique:contacts,national_code',
            'creator_id' => 'nullable|integer',

            // Accept an array of contact_details
            'contact_details' => 'array',
            'contact_details.*.detail_title' => 'nullable|string|max:255',
            'contact_details.*.address' => 'required|string',
            'contact_details.*.postal_code' => ['nullable', 'digits:10'],
            'contact_details.*.phone_number' => ['nullable', 'regex:/^(\d{8}|0\d{10})$/'],
            'contact_details.*.mobile_number' => ['nullable', 'regex:/^0\d{10}$/'],
            'contact_details.*.is_primary' => 'boolean',
        ];
    }
}
