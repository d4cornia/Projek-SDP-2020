<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class client extends Model
{
    protected $primaryKey = 'kode_client';
    public  $timestamps = false;
    public  $incrementing = true;

    public function nameToCode($name)
    {
        return $this::where('nama_client', $name)
            ->pluck('kode_client');
    }

    public function cekClient($namaClient)
    {
        $result = client::where('nama_client', $namaClient)
            ->get();
        return count($result);
    }

    public function insertClient(Request $request)
    {
        $this->kode_kontraktor = session()->get('kode');
        $this->nama_client = $request->nameClient;
        $this->no_hp_client = $request->handphoneNumber;
        $this->save();
    }
}
