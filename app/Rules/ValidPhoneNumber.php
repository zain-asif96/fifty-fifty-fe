<?php

namespace App\Rules;

use App\Classes\Twilio;
use Illuminate\Contracts\Validation\InvokableRule;

class ValidPhoneNumber implements InvokableRule
{
    /**
     * Run the validation rule.
     *
     * @param string $attribute
     * @param mixed $value
     * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {
        $length = strlen($value);

        if ($length < 7) {
            return $fail('The :attribute field is not a valid phone number');
        }

        if (app()->environment() !== 'production') return;

        if (!Twilio::validatePhoneNumber($value)) {
            return $fail('The :attribute field is not a valid phone number');
        }
    }
}
