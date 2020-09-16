<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\pekerjaan;

class cekNamaWork implements Rule
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
        $p = new pekerjaan();
        if ($p->cekWorkname($value) == 0) {
            return true;
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Nama Pekerjaan Telah Dipakai';
    }
}
