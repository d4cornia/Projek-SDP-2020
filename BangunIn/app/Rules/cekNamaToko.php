<?php

namespace App\Rules;

use App\toko_bangunan;
use Illuminate\Contracts\Validation\Rule;

class cekNamaToko implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($al)
    {
        //
        $this->alamat=$al;
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
        $toko = new toko_bangunan();
        $listToko = $toko->where('nama_toko',$value)->get();
        if(count($listToko)==0){
            return true;
        }
        else{
            $listToko = $toko->where('nama_toko',$value)->pluck('alamat_toko');
            $ada=0;
            for($i=0;$i<count($listToko);$i++){
                if($listToko[$i]==$this->alamat){
                    $ada=1;
                }
            }
            if($ada==1){
                return false;
            }
            else{
                return true;
            }
        }

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Toko ini telah terdaftar';
    }
}
