<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class cekNpass implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if ($value != session()->get('tempPass')) {
            return true;
        }
        session()->forget('tempPass');
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Kata sandi lama tidak boleh sama dengan kata sandi baru';
    }
}
