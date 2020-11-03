<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class pekerjaan_khusus extends Model
{
    protected $primaryKey = 'kode_pk';
    public  $timestamps = false;


    public function pk_dana()
    {
        return $this->hasOne(pk_dana::class, 'kode_pk');
    }

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
        $this->kode_tukang = null;
        $this->status_selesai = 0;
        $this->status_delete_pk = 0;
        $this->id_detail_permintaan_uang = null;
        $this->save();

        $p = new pekerjaan();
        $p->updateHargaDeal($req->kode);
    }

    public function updatePekerjaanKhusus(Request $req)
    {
        $pk = $this->find($req->id);
        $pk->keterangan_pk = $req->ketPK;
        $pk->total_jasa = $req->sumJasa;
        $pk->total_keseluruhan = ($req->sumJasa + $pk->total_bahan);
        $pk->save();

        $p = new pekerjaan();
        $p->updateHargaDeal($pk->kode_pekerjaan);
    }

    public function softDeletePekerjaanKhusus($id)
    {
        $pk = $this->find($id);
        $pk->status_delete_pk = 1;
        $pk->save();

        $p = new pekerjaan();
        $p->updateHargaDeal($pk->kode_pekerjaan);
    }

    public function rollbackSpWork($id)
    {
        $pk = $this->find($id);
        $pk->status_delete_pk = 0;
        $pk->save();

        $p = new pekerjaan();
        $p->updateHargaDeal($pk->kode_pekerjaan);
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

            $p = new pekerjaan();
            $p->updateHargaDeal($pk->kode_pekerjaan);
        }
    }

    public function PembelihanBahan($id, $harga)
    {
        $p = $this->find($id);
        $p->membutuhkan_bahan = 1;
        $p->total_bahan = $p->total_bahan + $harga;
        $p->total_keseluruhan = $p->total_bahan + $p->total_jasa;
        $p->save();

        $w = new pekerjaan();
        $w->updateHargaDeal($p->kode_pekerjaan);
    }

    public function getPK($id)
    {
        $data = pekerjaan_khusus::join('pembelians', 'pembelians.id_kerjasama', $id)
            ->join('pekerjaans as pp', 'pp.kode_pekerjaan', 'pembelians.kode_pekerjaan')
            ->where('pekerjaan_khususes.kode_pekerjaan', 'pp.kode_pekerjaan')
            ->where('pekerjaan_khususes.membutuhkan_bahan', 1)
            ->join('pk_memakai_bahans as pk', 'pk.kode_pk', 'pekerjaan_khususes.kode_pk')
            ->join('pembelians as p', 'p.id_pembelian', 'pk.id_pembelian')->get();
        return $data;
    }

    public function assign($id, $kode_tukang)
    {
        $p = $this->find($id);
        $p->kode_tukang = $kode_tukang;
        $p->save();
    }

    public function donePk($id, $status)
    {
        $p = $this->find($id);
        $p->status_selesai = $status;
        $p->save();
    }

    public function getPekerjaanKhususTukang($kodetukang)
    {
        return $this::where('kode_tukang', $kodetukang)->get();
    }
}
