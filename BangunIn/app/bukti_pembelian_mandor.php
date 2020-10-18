<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class bukti_pembelian_mandor extends Model
{
    protected $primaryKey = 'id_bukti';
    public $timestamps = false;
    public  $incrementing = true;

    public function selesaiInput($id,$idPembelihan)
    {
        $bukti = $this->find($id);
        $bukti->status_input=1;
        $bukti->id_pembelian=$idPembelihan;
        $bukti->save();
    }
}
