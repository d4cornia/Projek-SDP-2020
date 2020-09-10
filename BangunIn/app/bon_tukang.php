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
        $this->sisa_bon=$request->jumlah;
        $this->status_delete_bon=0;
        $this->save();
    }
    public function kurangi($jumlah,$kode_bon)
    {
        $datalama   = bon_tukang::find($kode_bon);
        $jumlahlalu = $datalama->sisa_bon;
        $datalama->sisa_bon=$jumlahlalu-$jumlah;
        $temp = $jumlahlalu-$jumlah;
        if($temp==0){
            $datalama->status_lunas=1;
        }
        $datalama->save();
    }
    public function cekMaxBayar($jumlahtotal,$kd)
    {
        $datalama   = bon_tukang::find($kd);
        $jum = $datalama->sisa_bon;
        if($jumlahtotal>$jum){
            return 0;
        }
        else{
            return 1;
        }
    }
    public function kodetoKet($kode)
    {
        return $this::where('kode_bon', $kode)
            ->pluck('keterangan_bon');
    }
}
