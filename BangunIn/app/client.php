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

    public function getNamaClient()
    {
        $data = client::select('*')->get();
        return $data;
    }

    public function dataToUpdate($id)
    {
        return client::where('kode_client',$id)->get();
    }

    public function updateClient(Request $req)
    {
        $b = $this->find($req->input('idClient'));
        $b->nama_client = $req->input('nameClient');
        $b->no_hp_client = $req->input('handphoneNumber');
        $b->save();
    }

    public function insertClient(Request $request)
    {
        $this->kode_kontraktor = session()->get('kode');
        $this->nama_client = $request->nameClient;
        $this->no_hp_client = $request->handphoneNumber;
        $this->status_delete_client=0;
        $this->save();
    }

    public function getDataClient()
    {
        $data = client::select('*')->get();
        return $data;
    }
}
