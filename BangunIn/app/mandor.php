<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class mandor extends Model
{
    protected $table = "mandors";
    protected $primaryKey = 'kode_mandor';

    public function CekLogin($username, $password)
    {
        //cek login Mandor

        $result = mandor::where('username_mandor', $username)
            ->where('password_mandor', $password)
            ->get();
        return $result;
    }

    public function cekMandor($username)
    {
        //cek apakah user sudah terpakai atau belum
        $result = mandor::where('username_mandor', $username)
            ->get();
        return count($result);
    }

    public function insertMandor(Request $request)
    {
        $this->kode_kontraktor = session()->get('kode');
        $this->nama_mandor = $request->input('name');
        $this->no_hp_mandor = $request->input('no');
        $this->username_mandor = $request->input('username');
        $this->email_mandor = $request->input('email');
        $this->password_mandor = $request->input('pass');
        $this->save();
    }

    public function nameToCode($username)
    {
        return $this::where('username_mandor', $username)
            ->pluck('kode_mandor');
    }
}