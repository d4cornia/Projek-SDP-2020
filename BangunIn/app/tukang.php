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
    public function nameToCode($username)
    {
        return $this::where('username_tukang', $username)
            ->pluck('kode_tukang');
    }
}
