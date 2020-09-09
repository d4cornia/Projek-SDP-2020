<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class pekerjaan_khusus extends Model
{
    protected $primaryKey = 'kode_pk';
    public  $timestamps = false;

    public function insertPekerjaanKhusus(Request $req)
    {
        $this->kode_pekerjaan = $req->work;
        $this->keterangan_pk = $req->ketPK;
        $this->membutuhkan_bahan = '0';
        $this->total_bahan = 0;
        $this->total_jasa = $req->sumJasa;
        $this->total_keseluruhan = $req->sumJasa;
        $this->save();
    }

    public function updatePekerjaanKhusus(Request $req)
    {
        $pk = $this->find($req->id);
        $pk->kode_pekerjaan = $req->work;
        $pk->keterangan_pk = $req->ketPK;
        $pk->membutuhkan_bahan = '0';
        $pk->total_bahan = 0;
        $pk->total_jasa = $req->sumJasa;
        $pk->total_keseluruhan = $req->sumJasa;
        $pk->save();
    }
}
