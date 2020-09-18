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
    public function updateDeletedJT($request,$kode)
    {
        $datalama   = jenis_tukang::find($kode);
        $datalama->gaji_pokok=$request->gaji;
        $datalama->status_delete_jt=0;
        $datalama->save();
    }
    public function cekNamaTidakKembar($nama,$kode)
    {
        $result = jenis_tukang::where('nama_jenis', $nama)
                ->where('kode_mandor',session()->get('kode'))
                ->where('kode_jenis',"<>",$kode)
                ->where('status_delete_jt',0)
                ->get();
        return count($result);
    }
    public function insertJenis(Request $request)
    {
        $this->nama_jenis = $request->name;
        $this->gaji_pokok = $request->gaji;
        $this->kode_mandor = session()->get('kode');
        $this->status_delete_jt=0;
        $this->save();
    }
    public function nameToCode($jenis)
    {
        return $this::where('nama_jenis', $jenis)
            ->where('kode_mandor',session()->get('kode'))
            ->pluck('kode_jenis');
    }
    public function nameToGaji($jenis)
    {
        return $this::where('nama_jenis', $jenis)
            ->where('kode_mandor',session()->get('kode'))
            ->pluck('gaji_pokok');
    }
    public function codetoName($kode)
    {
        return $this::where('kode_jenis', $kode)
            ->pluck('nama_jenis');
    }
    public function cekJenisTukangDeleted($jenis)
    {
        $result = jenis_tukang::where('nama_jenis', $jenis)
                ->where('status_delete_jt',1)
                ->where('kode_mandor',session()->get('kode'))
                ->get();
        return count($result);
    }
    public function cekKodeTukangDeleted($jenis)
    {
        return  $this::where('nama_jenis', $jenis)
                ->where('status_delete_jt',1)
                ->where('kode_mandor',session()->get('kode'))
                ->pluck('kode_jenis');
    }
    public function rollbackJenis($id)
    {
        $datalama   = jenis_tukang::find($id);
        $datalama->status_delete_jt=0;
        $datalama->save();
    }
    public function softDelete($id)
    {
        $m = new jenis_tukang();
        $m = $this->find($id);
        $m->status_delete_jt = 1;
        $m->save();
    }
    public function harddelete($kodeini)
    {
        $res=$this::where('kode_jenis',$kodeini)->delete();
    }

}
