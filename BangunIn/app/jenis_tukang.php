<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class jenis_tukang extends Model
{
    //
    protected $primaryKey = 'kode_jenis';
    public  $timestamps = false;
    public  $incrementing = true;

    public function getNamaJenis($id)
    {
        return $this::where('kode_jenis', $id)
            ->pluck('nama_jenis');
    }
    public function getGaji($id)
    {
        return $this::where('kode_jenis', $id)
            ->pluck('gaji_pokok');
    }
    public function cekJenis($namaJenis)
    {
        $result = jenis_tukang::where('nama_jenis', $namaJenis)
                ->where('kode_mandor',session()->get('kode'))
                ->get();
        return count($result);
    }
    public function updateJenis($request,$kode){
        $datalama   = jenis_tukang::find($kode);
        $datalama->nama_jenis=$request->name;
        $datalama->gaji_pokok=$request->gaji;
        $datalama->save();
    }
    public function insertJenis(Request $request)
    {
        $this->nama_jenis = $request->name;
        $this->gaji_pokok = $request->gaji;
        $this->kode_mandor = session()->get('kode');
        $this->save();
    }
    public function nameToCode($jenis)
    {
        return $this::where('nama_jenis', $jenis)
            ->pluck('kode_jenis');
    }
}
