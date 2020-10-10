<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class absen_tukang extends Model
{
    protected $table = "bukti_absens";
    protected $primaryKey = 'kode_absen';
    public  $timestamps = false;
    public  $incrementing = true;

    public function getAllMyHist($id)
    {
        return $this->where('kode_tukang', $id)->get();
    }

    public function doneAbsen($id)
    {
        if (count($this->where('kode_tukang', $id)->where('tanggal_absen', date("d-m-Y"))->get()) > 0) {
            return false;
        }
        return true;
    }

    public function insert(Request $req)
    {
        $this->kode_tukang = decrypt($req->kode_tukang);
        $this->tanggal_absen = date("d-m-Y");
        $this->bukti_foto_absen = session()->get('bukti');
        $this->ongkos_lembur = 0;
        $this->konfirmasi_absen = '0';
        // dd($this);
        $this->save();
    }

    public function filterTanggalAbsen($tanggal)
    {
        $kode_mandor = session()->get('kode');
        $users = DB::table('bukti_absens')
        ->join('tukangs', 'bukti_absens.kode_tukang', '=', 'tukangs.kode_tukang')
        ->join('jenis_tukangs', 'tukangs.kode_jenis','=','jenis_tukangs.kode_jenis')
        ->where('bukti_absens.tanggal_absen','=',$tanggal)
        ->where('tukangs.kode_mandor','=',$kode_mandor)
        ->where('bukti_absens.konfirmasi_absen','=',0)
        ->get();
        return $users;
    }

    public function acceptAbsen($kode_absen)
    {
        $c = $this->find($kode_absen);
        $c->konfirmasi_absen = 1;
        $c->save();
    }

    public function insertAbsenHeader()
    {

    }

    public function insertAbsenDetail()
    {

    }
}
