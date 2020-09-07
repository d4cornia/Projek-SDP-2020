<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pembayaran_client extends Model
{
    public $timestamps = false;
    //
    public function insertPembayaran($data)
    {
        $this->kode_pekerjaan = $data['pekerjaan_kode'];
        $this->kode_client = $data['client_kode'];
        $this->tanggal_pembayan_client = $data['waktu'];
        $this->jumlah_pembayaran_client = $data['total'];
        $this->save();
    }
}
