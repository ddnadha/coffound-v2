<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\InvokableRule;

class PhoneNumber implements InvokableRule
{
    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {
        if (!str_starts_with($value, '08')) $fail('No Telepon harus dimulai dengan 08...');
        if (!ctype_digit($value)) $fail('No Telepon hanya boleh berupa angka');
    }
}
