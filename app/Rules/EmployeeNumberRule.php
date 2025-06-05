<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class EmployeeNumberRule implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return is_string($value) && preg_match('/^\d+$/', $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The Employee Number must be a number.';
    }
}