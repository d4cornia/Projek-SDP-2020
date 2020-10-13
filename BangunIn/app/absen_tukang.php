<?php

namespace App;

use Exception;
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
            return true;
        }
        return false;
    }

    public function getBukti($id)
    {
        return $this->where('kode_absen', $id)->pluck('bukti_foto_absen');
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
            ->join('jenis_tukangs', 'tukangs.kode_jenis', '=', 'jenis_tukangs.kode_jenis')
            ->where('bukti_absens.tanggal_absen', '=', $tanggal)
            ->where('tukangs.kode_mandor', '=', $kode_mandor)
            ->where('bukti_absens.konfirmasi_absen', '=', 0)
            ->get();
        return $users;
    }

    public function tukangTelat($tanggal)
    {
        $t = new tukang();
        $tukangs = $t->where('kode_mandor', session()->get('kode'))->get(); // semua tukang dengan mandor ini
        $data = null;
        foreach ($tukangs as $item) {
            if (count($this->where('kode_tukang', $item['kode_tukang'])
                ->where('tanggal_absen', $tanggal)->get()) == 0) { // yang telat berarti tidak ada di tabel bukti absen pada hari itu
                $data[] = $item;
            }
        }
        return $data;
    }

    public function acceptAbsen($kode_absen, $ongkos)
    {
        $c = $this->find($kode_absen);
        $c->konfirmasi_absen = 1;
        $c->ongkos_lembur = $ongkos;
        $c->save();
    }

    public function insertAbsen(Request $req, $tanggal)
    {
        DB::beginTransaction();
        try {
            //Header
            $works = $req->input('kode_pekerjaan');
            $tukangs = $req->input('kode_tukang');
            foreach ($works as $workCode) {
                $ah = new absen_harian();
                $ah->insertHeader($workCode, $tanggal);
            }

            //Detail
            $ctr = 0;
            $ah = new absen_harian();
            $data = $req->input('status');
            foreach ($data as $item) {
                $da = new detail_absen();
                $temp = $ah->getKodeHeader($works[$ctr], $tanggal); // get kode header sesuai dengan pekerjaan dan tanggal
                if ($item == "-1") { // telat, detail ada tpi bukti g ada
                    $da->insertDetail($temp[0], null, $tukangs[$ctr]);
                } else {
                    $da->insertDetail($temp[0], $item, $tukangs[$ctr]);
                }
                $ctr++;
            }

            //Update
            $ongkos = $req->input('ongkos');
            // dd($ongkos);
            $ctr = 0;
            foreach ($data as $item) {
                if ($item != '-1') {
                    $this->acceptAbsen($item, $ongkos[$ctr]);
                }
                $ctr++;
            }
            DB::commit();
        } catch (Exception $e) {
            echo $e->getMessage();
            DB::rollback();
        }
    }
}
