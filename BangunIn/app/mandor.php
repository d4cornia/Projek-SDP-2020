<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class mandor extends Model
{
    protected $table = "mandors";
    public  $timestamps = false;
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
        $result = mandor::where('username_mandor', $username)->get();
        $total = count($result);
        $result = administrator::where('username_admin', $username)->get();
        $total += count($result);
        if ($total == 0) {
            return true;
        }
        return false;
    }

    public function nameToCode($username)
    {
        return $this::where('username_mandor', $username)
            ->pluck('kode_mandor');
    }

    public function getMandor($id)
    {
        return $this::where('kode_mandor', $id)->get();
    }

    public function insertMandor(Request $request)
    {
        $this->kode_kontraktor = session()->get('kode');
        $this->nama_mandor = $request->input('name');
        $this->no_hp_mandor = $request->input('no');
        $this->username_mandor = $request->input('username');
        $this->email_mandor = $request->input('email');
        $this->gaji_mandor = $request->input('salary');
        $this->password_mandor = $request->input('pass');
        $this->status_delete_mandor = 0;
        $this->save();
    }

    public function updateMandor(Request $request)
    {
        $m = $this->find($request->id);
        $m->nama_mandor = $request->input('name');
        $m->no_hp_mandor = $request->input('no');
        $m->email_mandor = $request->input('email');
        $m->gaji_mandor = $request->input('salary');
        $m->save();
    }

    public function updatePassMandor(Request $request)
    {
        $m = $this->where('username_mandor', $request->username)->get();
        $m[0]->password_mandor = $request->input('npass');
        $m[0]->save();
    }

    public function softDeleteMandor($id)
    {
        $m = $this->find($id);
        $m->status_delete_mandor = 1;
        $m->save();
    }

    public function rollback($id)
    {
        $m = $this->find($id);
        $m->status_delete_mandor = 0;
        $m->save();
    }
}
