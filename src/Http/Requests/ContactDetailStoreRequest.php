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
            'detail_title'  => 'nullable|string|max:255',
            'address'       => 'required|string',
            'postal_code'   => ['nullable', 'digits:10'],
            'phone_number'  => ['nullable', 'regex:/^(\d{8}|0\d{10})$/'],
            'mobile_number' => ['nullable', 'regex:/^0\d{10}$/'],
            'is_primary'    => 'boolean',
        ];
    }
}
