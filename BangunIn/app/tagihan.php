<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tagihan extends Model
{
    protected $primaryKey = 'id_tagihan';
    public  $timestamps = false;

    public function insertTagihan($data)
    {
        $this->kode_pekerjaan = $data['pekerjaan_kode'];
        $this->tanggal_tagihan = $data['waktu'];
        $this->jumlah_tagihan = $data['jumlah'];
        $this->sisa_tagihan = $data['sisa'];
        $this->save();
    }

    public function getSisaTagihan($kode_pekerjaan)
    {
        return $this::where('kode_pekerjaan', $kode_pekerjaan)->pluck('sisa_tagihan');
    }

    public function updateTagihan($kode_pekerjaan,$sisaBaru)
    {
        $c = $this->find($kode_pekerjaan);
        $c->sisa_tagihan = $sisaBaru;
        $c->save();
    }

    public function getDataTagihan()
    {
        return tagihan::select('*')->get();
    }
}
