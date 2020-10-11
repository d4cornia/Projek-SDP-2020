<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class toko_bangunan extends Model
{
    //
    protected $primaryKey = 'id_kerjasama';
    public  $timestamps = false;
    public  $incrementing = true;
    public function insertToko(Request $request,$kodekontraktor)
    {
        $this->nama_toko = $request->name;
        $this->alamat_toko = $request->alamat;
        $this->no_hp_toko = $request->telepon;
        $this->kode_kontraktor=$kodekontraktor;
        $this->status_delete_tb=0;
        $this->save();
    }
    public function updateToko(Request $request,$kode){
        $datalama   = toko_bangunan::find($kode);
        $datalama->no_hp_toko=$request->telepon;
        $datalama->save();
    }

}
