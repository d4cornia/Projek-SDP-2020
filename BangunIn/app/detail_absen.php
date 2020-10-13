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

    public function getNotConfirm($kode_header)
    {
        $t = new tukang();
        $tukangs = $t->where('kode_mandor', session()->get('kode'))->get(); // semua tukang dengan mandor ini
        $nc = null;
        foreach ($tukangs as $item) {
            if (count($this->where('kode_tukang', $item['kode_tukang'])
                ->where('kode_absen_harians', $kode_header)
                ->get()) == 0) {
                $nc[] = $item;
            }
        }
        return $nc;
    }
}
