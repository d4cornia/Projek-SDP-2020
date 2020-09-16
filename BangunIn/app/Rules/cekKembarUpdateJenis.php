<?php

namespace App\Rules;

use App\jenis_tukang;
use Illuminate\Contracts\Validation\Rule;

class cekKembarUpdateJenis implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($kode)
    {
        //
        $this->kj =$kode;
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
        $jt = new jenis_tukang();
        $jum = $jt->cekNamaTidakKembar($value,$this->kj);
        if($jum==0){
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
        return 'Nama Tersebut telah Terdaftar';
    }
}
