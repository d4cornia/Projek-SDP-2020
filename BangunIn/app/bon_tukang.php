<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class bon_tukang extends Model
{
    //
    protected $table = "bon_tukangs";
    protected $primaryKey = 'kode_bon';
    public  $timestamps = false;
    public  $incrementing = true;

    public function insertBon($request,$kodetk)
    {
        $this->kode_tukang = $kodetk;
        $this->tanggal_pengajuan = $request->tanggal;
        $this->jumlah_bon=$request->jumlah;
        $this->status_lunas=0;//0 = belum lunas
        $this->keterangan_bon=$request->keteranganbon;
        $this->save();
    }
}
