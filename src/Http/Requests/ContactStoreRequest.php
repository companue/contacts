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

            // Accept an array of contact_details
            'contact_details' => 'array',
            'contact_details.*.detail_title' => 'required|string|max:255',
            'contact_details.*.address' => 'required|string|max:255',
            'contact_details.*.postal_code' => 'nullable|string|max:20',
            'contact_details.*.phone_number' => 'nullable|string|max:20',
            'contact_details.*.mobile_number' => 'nullable|string|max:20',
            'contact_details.*.is_primary' => 'boolean',
        ];
    }
}
