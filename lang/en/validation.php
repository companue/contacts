<?php

return [
    'national_code_legal' => 'National code must be exactly 11 digits for legal category.',
    'national_code_real' => 'National code must be exactly 10 digits for real category.',
    'unique' => 'The :attribute has already been taken.',
    // Add more custom messages as needed


    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
        'contact' => [
            'digits' => 'تعداد ارقام شماره تلفن باید ۱۱ رقم باشد',
            'email' => 'نشانی ایمیل معتبر نیست'
        ],
    ],
];
