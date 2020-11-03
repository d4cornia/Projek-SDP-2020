<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class memiliki_detail_bon extends Model
{
    protected $table = "memiliki_detail_bons";
    protected $primaryKey = 'kode_pembayaran_bon';
    public  $timestamps = false;
    public  $incrementing = true;

    public function insertDetail($kodebon, $kode_bayar, $jumlah)
    {
        $this->kode_bon = $kodebon;
        $this->kode_pembayaran_bon = $kode_bayar;
        $this->jumlah_pembayaran_bon = $jumlah;
        $this->save();
    }

    public function getDetailBon($kodepembayaranbon)
    {
        return $this::where('kode_pembayaran_bon', $kodepembayaranbon)->get();
    }
}
