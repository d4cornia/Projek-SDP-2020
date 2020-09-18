<?php

namespace App\Rules;

use App\tukang;
use Illuminate\Contracts\Validation\Rule;

class pwdlamabeda implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($kodetukang)
    {
        //
        $this->kode=$kodetukang;
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
            return false;
        }
        else{
            return true;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Kata Sandi Baru harus berbeda dengan Kata Sandi Lama';
    }
}
