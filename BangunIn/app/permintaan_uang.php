<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class permintaan_uang extends Model
{
    //
    protected $primaryKey = 'id_permintaan_uang';
    public $timestamps = false;
    public  $incrementing = true;

    public function insertheader($kodemandor,$tanggal,$totaldet,$totalbon,$totalsistem,$realtotal,$keterangan)
    {
        $this->kode_mandor=$kodemandor;
        $this->tanggal_permintaan_uang=$tanggal;
        $this->total_detail=$totaldet;
        $this->total_bon=$totalbon;
        $this->total_sistem=$totalsistem;
        $this->real_total=$realtotal;
        $this->keterangan=$keterangan;
        $this->konfirmasi_kontraktor_telah_transfer="0";
        $this->bukti_trf_req=null;
        $this->save();
    }
    public function getMaxKode(){
        return $this::max('id_permintaan_uang');
    }

    public function getDataPembayaranTukang($kodemandor,$kodetukang)
    {
        $users = DB::table('permintaan_uangs')
        ->join('detail_permintaan_uangs', 'permintaan_uangs.id_permintaan_uang', '=', 'detail_permintaan_uangs.id_permintaan_uang')
        ->join('mandors','permintaan_uangs.kode_mandor','=','mandors.kode_mandor')
        ->join('pekerjaans','pekerjaans.kode_pekerjaan','=','detail_permintaan_uangs.kode_pekerjaan')
        ->join('tukangs','mandors.kode_mandor','=','tukangs.kode_mandor')
        ->where('mandors.kode_mandor','=',$kodemandor)
        ->where('tukangs.kode_tukang','=',$kodetukang)
        ->get();
        return $users;
    }
}
