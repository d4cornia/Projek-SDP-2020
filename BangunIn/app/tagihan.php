<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class tagihan extends Model
{
    protected $primaryKey = 'id_tagihan';
    public  $timestamps = false;

    public function insertTagihan($data)
    {
        $this->kode_pekerjaan = $data['pekerjaan_kode'];
        $this->keterangan = $data['keterangan'];
        $this->tanggal_tagihan = $data['waktu'];
        $this->jumlah_tagihan = $data['jumlah'];
        $this->status_lunas = 0;
        $this->sisa_tagihan = $data['sisa'];
        $this->save();
    }

    public function getSisaTagihan($kode_pekerjaan, $idTagihan)
    {
        return $this::where('kode_pekerjaan', $kode_pekerjaan)
                    ->where('id_tagihan', $idTagihan)->pluck('sisa_tagihan');
    }

    public function updateTagihan($sisaBaru,$idtagihan)
    {
        $c = $this->find($idtagihan);
        if($sisaBaru <= 0)
        {
            $c->sisa_tagihan = $sisaBaru;
            $c->status_lunas = 1;
        }
        else{
            $c->sisa_tagihan = $sisaBaru;
        }
        $c->save();

    }

    public function getDataTagihan()
    {
        $users = DB::table('tagihans')
        ->join('pekerjaans', 'tagihans.kode_pekerjaan', '=', 'pekerjaans.kode_pekerjaan')
        ->select('tagihans.id_tagihan', 'pekerjaans.nama_pekerjaan', 'tagihans.tanggal_tagihan','tagihans.jumlah_tagihan','tagihans.sisa_tagihan')
        ->get();
        return $users;
    }

    public function getTagihan($value)
    {
        return tagihan::where('kode_pekerjaan',$value)->get();


    }

}
