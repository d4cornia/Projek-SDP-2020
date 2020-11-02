<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class bahan_bangunan extends Model
{
    protected $table = "bahan_bangunans";
    protected $primaryKey = 'id_bahan';
    public  $timestamps = false;
    public  $incrementing = true;

    public function addBahan($idKerjasama,$nmbahan,$harga_satuan)
    {
        $bb =bahan_bangunan::where('nama_bahan','=',$nmbahan)->where('id_kerjasama',$idKerjasama)->where('status_delete_bb',0)->get();
        if(count($bb)>0){
            $bahan  = $this->find($bb[0]["id_bahan"]);
            $bahan->harga_satuan = $harga_satuan;
            $bahan->save();
        }
        else{
            $bahan  = new bahan_bangunan();
            $bahan->id_kerjasama = $idKerjasama;
            $bahan->nama_bahan = $nmbahan;
            $bahan->harga_satuan = $harga_satuan;
            $bahan->status_delete_bb = 0;
            $bahan->save();
            return $bahan->id;
        }

    }

    public function deleteBahan($id)
    {
        $bahan  = $this->find($id);
        $bahan->status_delete_bb = 1;
        $bahan->save();
    }

    public function editBahan($id,$nama,$harga)
    {
        $bahan  = $this->find($id);
        $bahan->nama_bahan = $nama;
        $bahan->harga_satuan = $harga;
        $bahan->save();
    }
}
