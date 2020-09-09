<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pembayaran_bon_tukang extends Model
{
    //
    protected $table = "pembayaran_bon_tukangs";
    protected $primaryKey = 'kode_pembayaran_bon';
    public  $timestamps = false;
    public  $incrementing = true;

    public function insertByr($request,$tanggal)
    {
        $this->kode_mandor=session()->get('kode');
        $this->tanggal_pembayaran_bon=$tanggal;
        $this->save();
    }
    public function getMaxKode(){
        return $this::max('kode_pembayaran_bon');
    }
}
