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

    public function TambahKontraktor($username, $password, $nama, $email, $nomer,$nmperusahaan,$noperusahaan,$alperusahaan,$nmlogo)
    {
        //tambah akun kontraktor baru
        $insert = new kontraktor();
        $insert->username_kontraktor = $username;
        $insert->password_kontraktor = $password;
        $insert->nama_kontraktor     = $nama;
        $insert->email_kontraktor    = $email;
        $insert->no_hp_kontraktor    = $nomer;
        $insert->nama_perusahaan    = $nmperusahaan;
        $insert->logo_perusahaan    = $nmlogo;
        $insert->nomer_perusahaan    = $noperusahaan;
        $insert->alamat_perusahaan    = $alperusahaan;
        $insert->save();
    }
    public function nameToCode($username)
    {
        return $this::where('username_kontraktor', $username)
                     ->pluck('kode_kontraktor');
    }
    public function updateProfilePerusahaan($nmperusahaan,$noperusahaan,$alperusahaan,$nmlogo)
    {
        $k = new kontraktor();
        $k = $this->find(session()->get('kode'));
        $k->nama_perusahaan = $nmperusahaan;
        $k->alamat_perusahaan = $alperusahaan;
        $k->nomer_perusahaan = $noperusahaan;
        if($nmlogo!="")$k->logo_perusahaan = $nmlogo;
        $k->save();
    }
}
