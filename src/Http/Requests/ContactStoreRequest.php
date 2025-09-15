<?php

namespace Companue\Contacts\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

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
            'national_code' => [
                'nullable',
            ],
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

    public function withValidator($validator)
    {
        // Ensure the locale is set to the parent app's locale
        app()->setLocale(config('app.locale'));
        $validator->after(function ($validator) {
            $category = $this->input('category');
            $nationalCode = $this->input('national_code');
            $contactId = optional($this->route('contact'))->id ?? $this->route('contact') ?? $this->route('id');
            if ($nationalCode) {
                if ($category === 'legal' && !preg_match('/^\d{11}$/', $nationalCode)) {
                    $validator->errors()->add('national_code', __('contacts::validation.national_code_legal'));
                }
                if ($category === 'real' && !preg_match('/^\d{10}$/', $nationalCode)) {
                    $validator->errors()->add('national_code', __('contacts::validation.national_code_real'));
                }
                // Custom unique check for national_code
                $query = DB::table('contacts')->where('national_code', $nationalCode);
                if ($contactId) {
                    $query->where('id', '!=', $contactId);
                }
                if ($query->exists()) {
                    $attribute = $category === 'legal' ? __('contacts::validation.attributes.national_code_legal') : __('contacts::validation.attributes.national_code_real');
                    $validator->errors()->add('national_code', __('contacts::validation.unique', ['attribute' => $attribute]));
                }
            }
        });
    }
}
