<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class administrator extends Model
{
    protected $table = "administrators";
    protected $primaryKey = 'kode_admin';
    public  $timestamps = false;

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
        $result = administrator::where('username_admin', $username)
            ->get();
        return count($result);
    }

    public function nameToCode($username)
    {
        return $this::where('username_admin', $username)
            ->pluck('kode_admin');
    }

    public function getAdmin($id)
    {
        return $this::where('kode_admin', $id)->get();
    }

    public function insertAdmin(Request $request)
    {
        $this->kode_kontraktor = session()->get('kode');
        $this->nama_admin = $request->input('name');
        $this->no_hp_admin = $request->input('no');
        $this->username_admin = $request->input('username');
        $this->email_admin = $request->input('email');
        $this->gaji_admin = $request->input('salary');
        $this->password_admin = $request->input('pass');
        $this->status_delete_admin = 0;
        $this->save();
    }

    public function updateAdmin(Request $request)
    {
        $a = $this->find($request->id);
        $a->nama_admin = $request->input('name');
        $a->no_hp_admin = $request->input('no');
        $a->username_admin = $request->input('username');
        $a->email_admin = $request->input('email');
        $a->gaji_admin = $request->input('salary');
        $a->password_admin = $request->input('pass');
        $a->save();
    }

    public function softDeleteAdmin($id)
    {
        $m = $this->find($id);
        $m->status_delete_admin = 1;
        $m->save();
    }
}
