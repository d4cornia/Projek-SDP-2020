<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class jenis_tukang extends Model
{
    //
    protected $primaryKey = 'kode_jenis';
    public  $timestamps = false;
    public  $incrementing = true;

    public function cekJenis($namaJenis)
    {
        $result = jenis_tukang::where('nama_jenis', $namaJenis)
                ->where('kode_mandor',session()->get('kode'))
                ->get();
        return count($result);
    }
    public function insertJenis(Request $request)
    {
        $this->nama_jenis = $request->name;
        $this->gaji_pokok = $request->gaji;
        $this->kode_mandor = session()->get('kode');
        $this->save();
    }
}
