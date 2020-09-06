<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class administrator extends Model
{
    protected $table = "administrators";
    protected $primaryKey = 'kode_admin';

    public function CekLogin($username, $password)
    {
        //cek login Kontraktor

        $result = administrator::where('username_admin', $username)
            ->where('password_admin', $password)
            ->get();
        return $result;
    }

    public function cekAdmin($username)
    {
        //cek apakah user sudah terpakai atau belum
        $result = administrator::where('username_mandor', $username)
            ->get();
        return count($result);
    }

    public function insertMandor(Request $request)
    {
        $this->kode_kontraktor = session()->get('kode');
        $this->nama_admin = $request->input('name');
        $this->no_hp_admin = $request->input('no');
        $this->username_admin = $request->input('username');
        $this->email_admin = $request->input('email');
        $this->password_admin = $request->input('pass');
        $this->save();
    }

    public function nameToCode($username)
    {
        return $this::where('username_admin', $username)
            ->pluck('kode_admin');
    }
}