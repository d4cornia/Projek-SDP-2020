<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class pekerjaan_khusus extends Model
{
    protected $primaryKey = 'kode_pk';
    public  $timestamps = false;


    public function getSpWork($id)
    {
        return $this::where('kode_pk', $id)->get();
    }

    public function findKodePekerjaan($id)
    {
        return $this::where('kode_pk', $id)->pluck('kode_pekerjaan');
    }

    public function insertPekerjaanKhusus(Request $req)
    {
        $this->kode_pekerjaan = $req->kode;
        $this->membutuhkan_bahan = '0';
        $this->total_bahan = 0;
        $this->keterangan_pk = $req->ketPK;
        $this->total_jasa = $req->sumJasa;
        $this->total_keseluruhan = ($req->sumJasa + $this->total_bahan);
        $this->status_delete_pk = 0;
        $this->save();
    }

    public function updatePekerjaanKhusus(Request $req)
    {
        $pk = $this->find($req->id);
        $pk->keterangan_pk = $req->ketPK;
        $pk->total_jasa = $req->sumJasa;
        $pk->total_keseluruhan = ($req->sumJasa + $pk->total_bahan);
        $pk->save();
    }

    public function softDeletePekerjaanKhusus($id)
    {
        $pk = $this->find($id);
        $pk->status_delete_pk = 1;
        $pk->save();
    }

    public function rollbackSpWork($id)
    {
        $pk = $this->find($id);
        $pk->status_delete_pk = 0;
        $pk->save();
    }

    public function revert()
    {
        foreach (session()->get('listSpWorkAwal') as $item) {
            $pk = $this->find($item['kode_pk']);
            $pk->keterangan_pk = $item['keterangan_pk'];
            $pk->total_jasa = $item['total_jasa'];
            $pk->total_keseluruhan = $item['total_keseluruhan'];
            $pk->status_delete_pk = $item['status_delete_pk'];
            $pk->save();
        }
    }
}
