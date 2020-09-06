<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class kontraktor extends Model
{
    protected $table = "kontraktors";
    protected $primaryKey = 'kode_kontraktor';
    public  $timestamps = false;
    public  $incrementing = true;

    public function CekLogin($username, $password)
    {
        //cek login Kontraktor
        $result = kontraktor::where('username_kontraktor', $username)
            ->where('password_kontraktor', $password)
            ->get();
        return $result;
    }

    public function CekUsername($username)
    {
        //cek apakah user sudah terpakai atau belum
        $result = kontraktor::where('username_kontraktor', $username)
            ->get();
        return $result;
    }

    public function TambahKontraktor($username, $password, $nama, $email, $nomer)
    {
        //tambah akun kontraktor baru
        $insert = new kontraktor();
        $insert->username_kontraktor = $username;
        $insert->password_kontraktor = $password;
        $insert->nama_kontraktor     = $nama;
        $insert->email_kontraktor    = $email;
        $insert->no_hp_kontraktor    = $nomer;
        $insert->save();
    }
}
