<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pk_memakai_bahan extends Model
{
    protected $primaryKey = 'id_pk_memakai_bahan';
    public $timestamps = false;
    public  $incrementing = true;

    public function insert($id,$id_pembelihan)
    {
        $pk = new pk_memakai_bahan();
        $pk->id_pembelian = $id_pembelihan;
        $pk->kode_pk = $id;
        $pk->save();
    }
}
