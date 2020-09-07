<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class pekerjaan extends Model
{
    protected $primaryKey = 'kode_pekerjaan';
    public  $timestamps = false;

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

    public function getDataPekerjaan()
    {
        $data = pekerjaan::select('*')->get();
        $nama = [];
        foreach ($data as $key) {
            $nama[] = client::where('kode_client',$key['kode_client'])->pluck('nama_client');
        }
        $final = ['data' => $data, 'nama' => $nama];
        return $final;
    }

    public function insertWork(Request $request, $kc, $ka, $km)
    {
        $this->kode_kontraktor = session()->get('kode');
        $this->kode_client = $kc[0];
        $this->kode_admin = $ka[0];
        $this->kode_mandor = $km[0];
        $this->nama_pekerjaan = $request->input('name');
        $this->alamat_pekerjaan = $request->input('address');
        $this->perjanjian_khusus = $request->input('specAgreement');
        $this->jenis_pekerjaan = $request->input('type'); // 0 = dp, 1 = komisi
        $this->harga_deal = $request->input('dealPrice');
        $this->status_selesai = '0';
        $this->save();
    }
}
