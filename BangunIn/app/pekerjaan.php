<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class pekerjaan extends Model
{
    protected $primaryKey = 'kode_pekerjaan';

    public function getWork($id)
    {
        return $this::where('id', $id)->get();
    }

    public function cekWorkname($name)
    {
        //cek apakah user sudah terpakai atau belum
        $result = pekerjaan::where('nama_pekerjaan', $name)
            ->get();
        return count($result);
    }


    public function insertWork(Request $request, $kc, $ka, $km)
    {
        $this->kode_kontraktor = session()->get('kode');
        $this->kode_client = $kc;
        $this->kode_admin = $ka;
        $this->kode_mandor = $km;
        $this->nama_pekerjaan = $request->input('name');
        $this->alamat_pekerjaan = $request->input('address');
        $this->perjanjian_khusus = $request->input('specAgreement');
        $this->jenis_pekerjaan = $request->input('type'); // 0 = dp, 1 = komisi
        $this->harga_deal = $request->input('dealPrice');
        $this->status_selesai = '0';
        $this->save();
    }
}
