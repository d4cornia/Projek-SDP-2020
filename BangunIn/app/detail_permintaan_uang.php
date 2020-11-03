<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class detail_permintaan_uang extends Model
{
    //
    protected $primaryKey = 'id_detail_permintaan_uang';
    public $timestamps = false;
    public  $incrementing = true;

    public function insertdetail($kodemax,$kodepekerjaan,$totalnota,$totalgaji,$totalpk,$subtotal,$pk)
    {
        $this->id_permintaan_uang=$kodemax;
        $this->kode_pekerjaan=$kodepekerjaan;
        $this->claim_nota_pembelian=$totalnota;
        $this->total_gaji_tukang=$totalgaji;
        $this->total_pk=$totalpk;
        $this->subtotal=$subtotal;
        $pekerjaankhusus = $pk;

        $this->save();

        $maxkode = $this->getMaxKode();
        if($pekerjaankhusus!=null){
            for($i=0;$i<count($pekerjaankhusus);$i++){
                $pek = new pekerjaan_khusus();
                $mypk = $pek->where('kode_pk',$pekerjaankhusus[$i])->get()[0];
                $mypk->id_detail_permintaan_uang=$maxkode;
                $mypk->save();
            }
        }
    }
    public function getMaxKode(){
        return $this::max('id_detail_permintaan_uang');
    }

}
