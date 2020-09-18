<?php

namespace App\Rules;

use App\tukang;
use Illuminate\Contracts\Validation\Rule;

class cekPwdLama implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($kode)
    {
        //
        $this->kode=$kode;
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
        $t = new tukang();
        $pwd = $t->getPassword($this->kode);
        $pwd=substr($pwd,2);
        $pwd=substr($pwd,0,strlen($pwd)-2);
        if($pwd==$value){
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
        return 'Password lama tidak sesuai';
    }
}
