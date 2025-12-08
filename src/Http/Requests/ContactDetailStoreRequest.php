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

            'address'       => [
                'nullable',
                'string',
                'required_with:postal_code',
                'required_without_all:phone_number,mobile_number'
            ],

            'postal_code'   => [
                'nullable',
                'digits:10',
            ],

            'phone_number'  => [
                'nullable',
                'regex:/^(\d{8}|0\d{10})$/',
                'required_without_all:address,mobile_number'
            ],

            'mobile_number' => [
                'nullable',
                'regex:/^0\d{10}$/',
                'required_without_all:address,phone_number'
            ],

            'is_primary'    => 'boolean',
        ];
    }

    public function messages()
{
    return [
        'address.required_without_all'       => __('validation.one_required'),
        'phone_number.required_without_all'  => __('validation.one_required'),
        'mobile_number.required_without_all' => __('validation.one_required'),
    ];
}
}
