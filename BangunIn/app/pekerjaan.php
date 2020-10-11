<?php

namespace App;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class pekerjaan extends Model
{
    protected $primaryKey = 'kode_pekerjaan';
    public  $timestamps = false;

    public function getAllWork()
    {
        return $this->all();
    }

    public function getWork($id)
    {
        return $this::where('kode_pekerjaan', $id)->get();
    }

    public function cekWorkname($name)
    {
        //cek apakah user sudah terpakai atau belum
        $result = pekerjaan::where('nama_pekerjaan', $name)
            ->where('status_delete_pekerjaan', 0) // masih aktif
            ->get();
        if (count($result) > 0) {
            return false;
        }
        return true;
    }

    public function getDataPekerjaan()
    {
        $data = pekerjaan::select('*')->get();
        $nama = [];
        foreach ($data as $key) {
            $nama[] = client::where('kode_client', $key['kode_client'])->pluck('nama_client');
        }
        $final = ['data' => $data, 'nama' => $nama];
        return $final;
    }

    public function insertWork(Request $request, $kc, $ka, $km)
    {
        DB::beginTransaction();
        try {
            $dealPrice = 0;
            if ($request->has('dealPrice')) {
                $dealPrice = $request->input('dealPrice');
            }
            $this->kode_kontraktor = session()->get('kode');
            $this->kode_client = $kc[0];
            $this->kode_admin = $ka[0];
            $this->kode_mandor = $km[0];
            $this->nama_pekerjaan = $request->input('name');
            $this->alamat_pekerjaan = $request->input('address');
            $this->perjanjian_khusus = $request->input('specAgreement');
            $this->jenis_pekerjaan = $request->input('type'); // 0 = dp, 1 = komisi
            $this->harga_deal = $dealPrice;
            $this->status_selesai = '0';
            $this->status_lunas = '0';
            $this->status_delete_pekerjaan = '0';
            $this->save();
            $kode = $this::where('nama_pekerjaan', $request->input('name'))->pluck('kode_pekerjaan');

            // detail
            if (session()->get('listSpWork') !== null) {
                foreach (session()->get('listSpWork') as $item) {
                    $pk = new pekerjaan_khusus();
                    $pk->kode_pekerjaan = $kode[0];
                    $pk->keterangan_pk = $item['ketPK'];
                    $pk->membutuhkan_bahan = '0';
                    $pk->total_bahan = 0;
                    $pk->total_jasa = $item['sumJasa'];
                    $pk->total_keseluruhan = $item['sumJasa'];
                    $pk->status_delete_pk = 0;
                    $pk->save();
                }
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
        }
    }

    public function updateWork(Request $request)
    {
        $p = $this->find($request->id);
        $p->kode_client = $request->input('kc');
        $p->kode_admin = $request->input('ka');
        $p->kode_mandor = $request->input('km');
        $p->nama_pekerjaan = $request->input('name');
        $p->alamat_pekerjaan = $request->input('address');
        $p->save();
    }

    public function softDeleteWork($id)
    {
        $p = $this->find($id);
        $p->status_delete_pekerjaan = 1;
        $p->save();
    }
    public function finishWork($id)
    {
        $p = $this->find($id);
        $p->status_selesai = 1;
        $p->save();
    }

    public function hardDelete($name)
    {
        $pk = new pekerjaan_khusus();
        $kode = $this::where('nama_pekerjaan', $name)->pluck('kode_pekerjaan')->first();
        $pk->where('kode_pekerjaan', $kode)->get()->each->delete();
        $this->where('nama_pekerjaan', $name)->get()->each->delete(); // jika ada maka delete
    }

    public function rollback($id)
    {
        $p = $this->find($id);
        $p->status_delete_pekerjaan = 0;
        $p->save();
    }

    public function selectJenis($value)
    {
        return $this::where('kode_pekerjaan', $value)->pluck('jenis_pekerjaan');
    }

    public function selectPekerjaanFix()
    {
        $kodeKontraktor = session()->get('kode');
        return $this::where('jenis_pekerjaan', 0)
            ->where('kode_kontraktor', $kodeKontraktor)
            ->where('status_lunas', 0)
            ->where('status_delete_pekerjaan', 0)
            ->get();
    }

    public function selectPekerjaan($value)
    {
        return $this::where('jenis_pekerjaan', 0)
            ->where('kode_pekerjaan', $value)
            ->get();
    }

    public function updateLunas($value)
    {
        $p = $this->find($value);
        $p->status_lunas = 1;
        $p->save();
    }

    public function getTotalHarga($kode, $jenis)
    {
        return $this::where('kode_pekerjaan', $kode)
            ->where('jenis_pekerjaan', $jenis)
            ->pluck('harga_deal');
    }

    public function updateLunasKomisi($value)
    {
        $p = $this->find($value);
        $p->status_lunas = 1;
        $p->save();
    }
    public function batalLunasKomisi($value)
    {
        $p = $this->find($value);
        $p->status_lunas = 0;
        $p->save();
    }
}
