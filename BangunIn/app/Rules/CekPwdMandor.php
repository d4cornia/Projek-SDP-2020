<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CekPwdMandor implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($kode)
    {
        //
        $this->pas = $kode;
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
        //
        if($value==$this->pas){
            return true;
        }
        else{
            return false;
        }

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Password Mandor tidak sesuai';
    }
}
