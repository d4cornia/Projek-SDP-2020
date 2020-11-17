<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class detail_absen extends Model
{
    protected $primaryKey = 'kode_detail';
    public  $timestamps = false;
    public  $incrementing = true;

    public function insertDetail($kodeAH, $kodeB, $kodeT, $ongkos)
    {
        $this->kode_absen_harians = $kodeAH;
        $this->kode_absen = $kodeB;
        $this->kode_tukang = $kodeT;
        $this->ongkos_lembur = $ongkos;
        $this->save();
    }

    public function getDetail($kode)
    {
        return $this->where('kode_absen_harians', $kode)
            ->get();
    }

    public function getOngkosLembur($kodetukang)
    {
        return $this::where('kode_tukang', $kodetukang)->get();
    }

    public function buktiAbsen()
    {
        return $this->belongsTo(absen_tukang::class, 'kode_absen');
    }
}
