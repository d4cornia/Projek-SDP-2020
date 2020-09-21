<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class fotopekerjaan extends Model
{
    protected $primaryKey = 'id_foto';
    public  $timestamps = false;
    public  $incrementing = true;

    public function uploadFoto($foto,$id)
    {
        $nm = strval($foto);
        $foto = new fotopekerjaan();
        $foto->increment('id_foto');
        $foto->nama_foto = $nm;
        $foto->kode_pekerjaan = $id;
        $foto->save();

    }
    public function getFoto()
    {
        $foto = new fotopekerjaan();
        $foto = $foto->get();
        return $foto;
    }
}
