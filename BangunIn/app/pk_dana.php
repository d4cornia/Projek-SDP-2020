<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pk_dana extends Model
{
    protected $table = "pk_danas";
    protected $primaryKey = 'kode_pk_dana';
    public  $timestamps = false;


    public function insert($kode_pk, $bukti, $nom)
    {
        $this->kode_pk = $kode_pk;
        $this->bukti_tsf_dana = $bukti;
        $this->dana = $nom;
        $this->save();
    }

    public function updateJumlah($nom, $id)
    {
        $pkd = $this->find($id);
        $pkd->dana = $nom;
        $pkd->save();
    }

    public function getDanaPK($kodepk)
    {
        return $this::where('kode_pk', $kodepk)->get();
    }
}
