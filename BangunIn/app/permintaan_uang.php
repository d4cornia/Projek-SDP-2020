<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class permintaan_uang extends Model
{
    //
    protected $primaryKey = 'id_permintaan_uang';
    public $timestamps = false;
    public  $incrementing = true;

    public function insertheader($kodemandor,$tanggal,$totaldet,$totalbon,$totalsistem,$realtotal,$keterangan)
    {
        $this->kode_mandor=$kodemandor;
        $this->tanggal_permintaan_uang=$tanggal;
        $this->total_detail=$totaldet;
        $this->total_bon=$totalbon;
        $this->total_sistem=$totalsistem;
        $this->real_total=$realtotal;
        $this->keterangan=$keterangan;
        $this->konfirmasi_kontraktor_telah_transfer="0";
        $this->bukti_trf_req=null;
        $this->save();
    }
    public function getMaxKode(){
        return $this::max('id_permintaan_uang');
    }
}
