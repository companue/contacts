<?php

namespace Companue\Contacts\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactDetailStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'contact_id'    => 'required|integer|exists:contacts,id',
            'detail_title'  => 'required|string|max:255',
            'address'       => 'required|string|max:255',
            'postal_code'   => 'nullable|string|max:20',
            'phone_number'  => 'nullable|string|max:20',
            'mobile_number' => 'nullable|string|max:20',
            'is_primary'    => 'boolean',
        ];
    }
}
