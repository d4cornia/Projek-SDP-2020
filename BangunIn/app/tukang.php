<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class tukang extends Model
{
    protected $table = "tukangs";
    protected $primaryKey = 'kode_tukang';
    public  $timestamps = false;
    public  $incrementing = true;

    public function CekLogin($username,$password)
    {
        //cek login tukang

        $result = tukang::where('username_tukang',$username)
                        ->where('password_tukang',$password)
                        ->get();
        return $result;
    }
    public function insertTukang($request,$kode_jenis)
    {
        $this->kode_jenis = $kode_jenis;
        $this->kode_mandor = session()->get('kode');
        $this->nama_tukang = $request->name;
        $this->username_tukang=$request->username;
        $this->no_hp_tukang=$request->no;
        $this->email_tukang=$request->email;
        $this->password_tukang=$request->pass;
        $this->gaji_pokok_tukang=$request->gaji;
        $this->save();
    }
    public function updateTukang($request,$kode_jenis)
    {
        $kode= $request->kodetukang;
        $datalama   = tukang::find($kode);

        $datalama->kode_jenis=$kode_jenis;
        $datalama->nama_tukang = $request->name;
        $datalama->no_hp_tukang=$request->no;
        $datalama->email_tukang=$request->email;
        $datalama->password_tukang=$request->pass;
        $datalama->gaji_pokok_tukang=$request->gaji;
        $datalama->save();
    }
    public function nameToCode($username)
    {
        return $this::where('username_tukang', $username)
            ->pluck('kode_tukang');
    }
    public function kodeToNama($kode)
    {
        return $this::where('kode_tukang', $kode)
            ->pluck('username_tukang');
    }
    public function getKodeJenis($id)
    {
        return $this::where('kode_tukang', $id)
            ->pluck('kode_jenis');
    }
    public function getNamaTukang($id)
    {
        return $this::where('kode_tukang', $id)
            ->pluck('nama_tukang');
    }

    public function getNo($id)
    {
        return $this::where('kode_tukang', $id)
            ->pluck('no_hp_tukang');
    }
    public function getEmail($id)
    {
        return $this::where('kode_tukang', $id)
            ->pluck('email_tukang');
    }
    public function getGaji($id)
    {
        return $this::where('kode_tukang', $id)
            ->pluck('gaji_pokok_tukang');
    }
    public function getPassword($id)
    {
        return $this::where('kode_tukang', $id)
            ->pluck('password_tukang');
    }
}
