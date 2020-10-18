<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class bukti_pembelian_mandor extends Model
{
    protected $primaryKey = 'id_bukti';
    public $timestamps = false;
    public  $incrementing = true;

    public function listNota()
    {
        $p = new pekerjaan();
        $pem = new pembelian();
        $filter = null;
        $notas = $this->where('status_delete_bukti', '0')->get();
        $pembelian = $pem->where('status_request_dana', '0')->get();
        foreach ($pembelian as $item) {
            foreach ($notas as $nota) {
                if ($item['id_bukti'] == $nota['id_bukti']) {
                    $filter[] = $nota;
                }
            }
        }
        $pembelian = $pem->get();
        foreach ($notas as $nota) {
            $flag = true;
            foreach ($pembelian as $item) {
                if ($item['id_bukti'] == $nota['id_bukti']) {
                    $flag = false;
                }
            }
            if ($flag) {
                $filter[] = $nota;
            }
        }
        if ($filter !== null) {
            foreach ($filter as $item) {
                $item['nama_pekerjaan'] = $p->where('kode_pekerjaan', $item['kode_pekerjaan'])->pluck('nama_pekerjaan')->first();
            }
        }
        // dd($filter);
        return $filter;
    }

    public function insert(Request $req)
    {
        $this->kode_mandor = session()->get('kode');
        $this->kode_pekerjaan = $req->work;
        $this->file_bukti = session()->get('bukti');
        $this->status_input = '0';
        $this->status_delete_bukti = '0';
        $this->save();
    }

    public function deleteNota($id)
    {
        $bpm = $this->find($id);
        $bpm->status_delete_bukti = '1';
        $bpm->save();
    }

    public function selesaiInput($id, $idPembelihan)
    {
        $bukti = $this->find($id);
        $bukti->status_input = 1;
        $bukti->id_pembelian = $idPembelihan;
        $bukti->save();
    }
}
