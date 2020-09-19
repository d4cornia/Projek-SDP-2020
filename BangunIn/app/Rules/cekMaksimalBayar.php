<?php

namespace App\Rules;

use App\bon_tukang;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Session;

class cekMaksimalBayar implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($patokan)
    {
        //
        $this->patokan=$patokan;
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
        $bon = new bon_tukang();
        if(session()->has('listbyt')){
            $arrbyr = json_decode(session()->get('listbyr'));
        }
        else{
            $arrbyr=[];
        }

        $jum=0;
        foreach($arrbyr as $row){
            if($row->kode_bon==$this->patokan){
                $jum=$row->jumlah_bayar;
            }
        }

        $jumlahtotal = $jum+$value;
        //dd($jumlahtotal);
        return $bon->cekMaxBayar($jumlahtotal,$this->patokan)===1;
        if($bon->cekMaxBayar($jumlahtotal,$this->patokan)==1){
            return true;
        }
        dd($bon->cekMaxBayar($jumlahtotal,$this->patokan));
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Jumlah Pembayaran melebihi sisa bon.';
    }
}
