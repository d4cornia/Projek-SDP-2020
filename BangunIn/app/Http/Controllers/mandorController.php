<?php

namespace App\Http\Controllers;

use App\jenis_tukang;
use App\mandor;
use App\kontraktor;
use App\administrator;
use App\bon_tukang;
use App\memiliki_detail_bon;
use App\pembayaran_bon_tukang;
use App\Rules\cbDetBon;
use App\Rules\cbJenis;
use App\Rules\cbTukang;
use App\Rules\cekMaksimalBayar;
use App\tukang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
class mandorController extends Controller
{
    public function index()
    {
        return view('mandor.navbar');
    }

    //jenistukang
    public function tambahJenisTukang()
    {
        return view("mandor.Creation.tambahJenisTukang", ['title' => 'Tambah Jenis Tukang']);
    }
    public function rollbackJenisTukang($id)
    {
        $jt = new jenis_tukang();
        $jt->rollbackJenis($id);

        $jt = new jenis_tukang();
        $data = [
            'title' => 'List Jenis Tukang',
            'listDelJenisTukangs' => $jt->where('kode_mandor', session()->get('kode'))->where('status_delete_jt',1)->get(),
            'error'=>10
        ];
        return view('mandor.Deleted.deletedJenisTukang', $data);
    }
    public function storeJenisTukang(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'gaji' => 'required|numeric|gte:0',
        ],
        [
            'name.string' => 'Kolom nama hanya bisa di isi huruf!',
            'gaji.gte'=>'Gaji Pokok harus >= 0'
        ]);
        $jt = new jenis_tukang();
        $data = [
            'title' => 'Tambah Jenis Tukang',
            'error' => 0
        ];
        if ($jt->cekJenis($request->input('name')) == 0) {
            $jt->insertJenis($request);
            //return redirect('/mandor/submitRegJenisTukang');
            return view('mandor.Creation.tambahJenisTukang',$data);
        } else {
            if($jt->cekJenisTukangDeleted($request->input('name'))==1){
                //ada tapi udah kedelete,maka dipulihkan
                //dd("masuk");
                $kode = $jt->cekKodeTukangDeleted($request->input('name'));
                $kode= substr($kode,1);
                $kode=substr($kode,0,strlen($kode)-1);
                //dd($kode);
                $jt->updateDeletedJT($request,$kode);
                return view('mandor.Creation.tambahJenisTukang',$data);
            }
            else{
                $data['error'] = 5; //nama jenis sdh ada
            }
            return view('mandor.Creation.tambahJenisTukang',$data);
        }
    }
    public function lihatJenisTukang()
    {
        $jt = new jenis_tukang();
        $data = [
            'title' => 'List Jenis Tukang',
            'listJenisTukangs' => $jt->where('kode_mandor', session()->get('kode'))->where('status_delete_jt',0)->get()
        ];
        return view('mandor.List.listJenisTukang', $data);
    }
    public function lihatdeletedJenis()
    {
        $jt = new jenis_tukang();
        $data = [
            'title' => 'List Jenis Tukang',
            'listDelJenisTukangs' => $jt->where('kode_mandor', session()->get('kode'))->where('status_delete_jt',1)->get()
        ];
        return view('mandor.Deleted.deletedJenisTukang', $data);
    }
    public function detailjenis($id)
    {
        $jt = new jenis_tukang();
        $nama = $jt->getNamaJenis($id);
        $nama= substr($nama,2);
        $nama=substr($nama,0,strlen($nama)-2);
        $gaji = $jt->getGaji($id);
        $gaji = substr($gaji,1);
        $gaji=substr($gaji,0,strlen($gaji)-1);
        $data = [
            'title' => 'Detail Jenis',
            'nama' => $nama,
            'gaji' => $gaji,
            'kodejenis'=>$id
        ];
        return view('mandor.Detail.detailJenis', $data);
    }
    public function updateJenisTukang(Request $request)
    {
        $kode=$request->kodejenis;
        $request->validate([
            'name' => 'required|string',
            'gaji' => 'required|numeric|gte:0',
        ],
        [
            'name.string' => 'Kolom nama hanya bisa di isi huruf!',
            'gaji.gte'=>'Gaji Pokok harus >= 0'
        ]);
        $jt = new jenis_tukang();
        $jt->updateJenis($request,$kode);
        $data = [
            'title' => 'List Jenis Tukang',
            'listJenisTukangs' => $jt->where('kode_mandor', session()->get('kode'))->where('status_delete_jt',0)->get()
        ];
        return view('mandor.List.listJenisTukang', $data);
    }
    public function deleteJenis($id)
    {
        $m = new jenis_tukang();
        $m->softDelete($id);
        $data = [
            'title' => 'List Jenis Tukang',
            'listJenisTukangs' => $m->where('kode_mandor', session()->get('kode'))->where('status_delete_jt',0)->get()
        ];
        return view('mandor.List.listJenisTukang', $data);
        //return redirect('mandor/lihatJenisTukang');
    }

    //tukang
    public function tambahTukang(){
        $jt = new jenis_tukang();
        $data = [
            'title' => 'Register Tukang',
            'listJenis' => $jt->where('kode_mandor', session()->get('kode'))->where('status_delete_jt',0)->get()
        ];
        return view("mandor.Creation.tambahTukang", ['title' => 'Tambah Tukang'],$data);
    }
    public function storeTukang(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'no' => 'required|numeric',
            'username' => 'required',
            'email' => 'required',
            'pass' => 'required',
            'gaji'=>'required|numeric|gte:0'
        ],[
            'name.string' => 'Kolom nama hanya bisa di isi huruf!',
            'gaji.gte'=>'Gaji Pokok harus >= 0'
        ]);
        $jenis = $request->jenis;
        $un = $request->username;

        $jt = new jenis_tukang();
        $m = new mandor();
        $a = new administrator();
        $k = new kontraktor();
        $tukang = new tukang();
        $data = [
            'title' => 'Register Tukang',
            'error' => 0, // 0 = success,
            'listJenis' => $jt->where('kode_mandor', session()->get('kode'))->where('status_delete_jt',0)->get()
        ];
        if (count($jt->nameToCode($jenis)) == 0) {
            $data['error'] = 6; // 6 = belum pilih jenis tukang
        } else if (count($m->nameToCode($un)) != 0 ) {
            $data['error'] = 1; //username sdh terpakai
        } else if (count($a->nameToCode($un)) != 0 ) {
            $data['error'] = 1;
        } else if (count($k->nameToCode($un)) != 0 ) {
            $data['error'] = 1;
        } else if (count($tukang->nameToCode($un)) != 0){
            $data['error'] = 1;
        }
        if ($data['error'] == 6 || $data['error'] == 1) {
            return view('mandor.Creation.tambahTukang', $data);
        }
        else{

            $kj = $jt->nameToCode($jenis);
            $kj = substr($kj,1);
            $kj = substr($kj,0,strlen($kj)-1);
            $tukang->insertTukang($request,$kj);
            //return redirect('/mandor/submitRegTukang');
            return view('mandor.Creation.tambahTukang', $data);
        }
    }
    public function lihatTukang()
    {
        $t = new tukang();
        $jt = new jenis_tukang();
        $data = [
            'title' => 'List Tukang',
            'listTukang' => $t->where('kode_mandor', session()->get('kode'))->where('status_delete_tukang',0)->get(),
            'listJenis' => $jt->where('kode_mandor', session()->get('kode'))->where('status_delete_jt',0)->get()
        ];
        return view('mandor.List.listTukang', $data);
    }
    public function detailtukang($id)
    {
        $jt = new jenis_tukang();
        $tk = new tukang();

        $kodejenis = $tk->getKodeJenis($id);
        $kodejenis = substr($kodejenis,1);
        $kodejenis=substr($kodejenis,0,strlen($kodejenis)-1);

        $namajenis=$jt->codetoName($kodejenis);
        $namajenis= substr($namajenis,2);
        $namajenis=substr($namajenis,0,strlen($namajenis)-2);

        $nama = $tk->getNamaTukang($id);
        $nama= substr($nama,2);
        $nama=substr($nama,0,strlen($nama)-2);

        $un = $tk->kodeToNama($id);
        $un= substr($un,2);
        $un=substr($un,0,strlen($un)-2);

        $nohp = $tk->getNo($id);
        $nohp= substr($nohp,2);
        $nohp=substr($nohp,0,strlen($nohp)-2);

        $email = $tk->getEmail($id);
        $email= substr($email,2);
        $email=substr($email,0,strlen($email)-2);

        $gaji = $tk->getGaji($id);
        $gaji = substr($gaji,1);
        $gaji=substr($gaji,0,strlen($gaji)-1);

        $password = $tk->getPassword($id);
        $password= substr($password,2);
        $password=substr($password,0,strlen($password)-2);
        //echo $namajenis;
        //dd($namajenis);
        $data = [
            'kodetukang'=>$id,
            'title' => 'Detail Tukang',
            'kodejenistukang' => $namajenis,
            'gajitukang' => $gaji,
            'namatukang'=>$nama,
            'usernametukang'=>$un,
            'notelptukang'=>$nohp,
            'emailtukang'=>$email,
            'passwordtukang'=>$password,
            'listJenis' => $jt->where('kode_mandor', session()->get('kode'))->where('status_delete_jt',0)->get()
        ];
        //dd($data);
        return view('mandor.Detail.detailTukang', $data);
    }

    public function deleteTukang($id)
    {
        $t = new tukang();
        $t->softDelete($id);
        //return redirect('mandor/lihatTukang');
    }

    public function updateTukang(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'no' => 'required|numeric',
            'username' => 'required',
            'email' => 'required',
            'pass' => 'required',
            'gaji'=>'required|numeric|gte:0'
        ],[
            'name.string' => 'Kolom nama hanya bisa di isi huruf!',
            'gaji.gte'=>'Gaji Pokok harus >= 0'
        ]);
        $jenis = $request->jenis;
        $un = $request->username;

        $t = new tukang();
        $jt = new jenis_tukang();
        $m = new mandor();
        $a = new administrator();
        $k = new kontraktor();
        $tukang = new tukang();
        $data = [
            'title' => 'Register Tukang',
            'error' => 9, // 0 = success,
            'listJenis' => $jt->where('kode_mandor', session()->get('kode'))->where('status_delete_jt',0)->get(),
            'listTukang' => $t->where('kode_mandor', session()->get('kode'))->where('status_delete_tukang',0)->get()
        ];
        if (count($jt->nameToCode($jenis)) == 0) {
            $data['error'] = 8; // 8 = belum pilih jenis tukang
        }
        if ($data['error'] == 8) {
            return view('mandor.List.listTukang', $data);
        }
        else{
            $kj = $jt->nameToCode($jenis);
            $kj = substr($kj,1);
            $kj = substr($kj,0,strlen($kj)-1);
            $tukang->updateTukang($request,$kj);
            $data = [
                'title' => 'List Tukang',
                'listTukang' => $t->where('kode_mandor', session()->get('kode'))->where('status_delete_tukang',0)->get(),
                'listJenis' => $jt->where('kode_mandor', session()->get('kode'))->where('status_delete_jt',0)->get()
            ];
            return view('mandor.List.listTukang', $data);
        }
    }

    //bon
    public function tambahBon()
    {
        $t = new tukang();
        $jt = new jenis_tukang();
        $data = [
            'title' => 'Register Bon',
            'listTukang' => $t->where('kode_mandor', session()->get('kode'))->where('status_delete_tukang',0)->get(),
            'listJenis' => $jt->where('kode_mandor', session()->get('kode'))->where('status_delete_jt',0)->get()
        ];
        return view("mandor.Creation.tambahBon", ['title' => 'Tambah Bon'],$data);
    }

    public function storeBon(Request $request){
        $request->validate([
            'tanggal' =>'required',
            'jumlah' => 'required|numeric|gte:0',
            'keteranganbon' => 'required'
        ],[
            'jumlah.gte'=>'Jumlah Bon harus >= 0'
        ]);

        $nama = $request->nm;
        $arr = explode("-",$nama);
        $tukangpicked = $arr[0];

        $jt = new jenis_tukang();
        $tukang = new tukang();
        $data = [
            'title' => 'Register Bon',
            'error' => 0, // 0 = success,
            'listTukang' => $tukang->where('kode_mandor', session()->get('kode'))->where('status_delete_tukang',0)->get(),
            'listJenis' => $jt->where('kode_mandor', session()->get('kode'))->where('status_delete_jt',0)->get()
        ];
        if (count($tukang->nameToCode($tukangpicked)) == 0) {
            $data['error'] = 7; // 7 = belum pilih tukang
            return view('mandor.Creation.tambahBon', $data);
        }
        else{
            $kt = $tukang->nameToCode($tukangpicked);
            $kt = substr($kt,1);
            $kt = substr($kt,0,strlen($kt)-1);
            $bon = new bon_tukang();
            $bon->insertBon($request,$kt);
            return view('mandor.Creation.tambahBon', $data);
        }
    }
    public function lihatBon()
    {
        $t = new tukang();
        $jt = new jenis_tukang();
        $bon = new bon_tukang();
        $data = [
            'title' => 'List Bon',
            'listTukang' => $t->where('kode_mandor', session()->get('kode'))->where('status_delete_tukang',0)->get(),
            'listJenis' => $jt->where('kode_mandor', session()->get('kode'))->where('status_delete_jt',0)->get(),
            'listBon' => $bon->where('status_lunas',0)->where('status_delete_bon',0)->get()
        ];
        return view('mandor.List.listBon', $data);
    }

    public function deleteBon($id)
    {
        $b = new bon_tukang();
        $b->softDelete($id);
        return redirect('mandor/lihatBon');
    }

    //bayarbon
    public function bayarBon()
    {
        $t = new tukang();
        $jt = new jenis_tukang();
        $bon = new bon_tukang();
        $arrbon=[];
        if(session()->has('listbyr')){
            $arrbon=json_decode(session()->get('listbyr'));
        }
        $data = [
            'title' => 'Register Bayar Bon',
            'listTukang' => $t->where('kode_mandor', session()->get('kode'))->where('status_delete_tukang',0)->get(),
            'listJenis' => $jt->where('kode_mandor', session()->get('kode'))->where('status_delete_jt',0)->get(),
            'listBon' => $bon->where('status_lunas','0')->where('status_delete_bon',0)->get(),
            'listBayar' => json_encode($arrbon)
        ];
        session()->put('listbyr', json_encode($arrbon));
        return view("mandor.Creation.tambahPembayaranBon", ['title' => 'Register Bayar Bon'],$data);
    }

    public function fetch(Request $request){
        $value = $request->get('value');

        $bon = new bon_tukang();
        $data = $bon->where('status_lunas','0')
                    ->where('kode_tukang',$value)
                    ->where('status_delete_bon','0')
                    ->get();
        $output = "<option value=''>-</option>";
        foreach($data as $row){
            $output.= "<option value='".$row->kode_bon."'>".$row->keterangan_bon." ~ ".$row->sisa_bon."</option>";
        }
        echo $output;
    }
    public function tambahBayar(Request $request)
    {
        $kdbon = $request->detailbon;
        $request->validate([
            'nm'=>[new cbTukang()],
            'detailbon'=>[new cbDetBon(),'bail'],
            'jumlahbyr' => ['required','numeric',new cekMaksimalBayar($kdbon),'gte:0'],
        ],
        [
            'jumlahbyr.gte'=>'Jumlah Bayar harus >= 0'
        ]);
        $kode_tukang = $request->nm;
        $jumlah = $request->jumlahbyr;

        $tukang = new tukang();
        $bon = new bon_tukang();

        $arrbyr = json_decode(session()->get('listbyr'));
        $nmtkg = $tukang->kodeToNama($kode_tukang);
        $ket = $bon->kodetoKet($kdbon);

        $nama=$nmtkg[0];
        $ktg = $ket[0];
        $ada=-1;
        foreach($arrbyr as $row){
            if($row->kode_bon == $kdbon){
                $ada=1;
                $jumsblm = $row->jumlah_bayar;
                $jumsblm+=$jumlah;
                $row->jumlah_bayar=$jumsblm;
            }
        }
        if($ada==-1){
            $baru = array(
                "nama_tukang"=>$nama,
                "kode_bon"=>$kdbon,
                "keterangan"=>$ktg,
                "jumlah_bayar"=>$jumlah
            );
            array_push($arrbyr,$baru);
        }

        $t = new tukang();
        $jt = new jenis_tukang();
        $data = [
            'title' => 'Register Bayar Bon',
            'listTukang' => $t->where('kode_mandor', session()->get('kode'))->where('status_delete_tukang',0)->get(),
            'listJenis' => $jt->where('kode_mandor', session()->get('kode'))->where('status_delete_jt',0)->get(),
            'listBon' => $bon->where('status_lunas','0')->where('status_delete_bon',0)->get(),
            'listBayar' => json_encode($arrbyr)
        ];
        session()->put('listbyr', json_encode($arrbyr));
        //return view("mandor.Creation.tambahPembayaranBon", ['title' => 'Register Bayar Bon'],$data);
        return redirect('/mandor/tambahPembayaranBon');
    }
    public function batalBayar(Request $request)
    {
        $kode = $request->kodeku;
        //dd($kode);
        $arrbyr = json_decode(session()->get('listbyr'));
        $ctr=0;
        $posisiketemu=-1;
        foreach($arrbyr as $row){
            if($row->kode_bon == $kode){
                $posisiketemu=$ctr;
            }
            $ctr++;
        }
        array_splice($arrbyr,$posisiketemu,1);

        $t = new tukang();
        $jt = new jenis_tukang();
        $bon = new bon_tukang();
        $data = [
            'title' => 'Register Bayar Bon',
            'listTukang' => $t->where('kode_mandor', session()->get('kode'))->where('status_delete_tukang',0)->get(),
            'listJenis' => $jt->where('kode_mandor', session()->get('kode'))->where('status_delete_jt',0)->get(),
            'listBon' => $bon->where('status_lunas','0')->where('status_delete_bon',0)->get(),
            'listBayar' => json_encode($arrbyr)
        ];
        session()->put('listbyr', json_encode($arrbyr));
        return view("mandor.Creation.tambahPembayaranBon", ['title' => 'Register Bayar Bon'],$data);
        //return redirect('/mandor/tambahPembayaranBon');
    }
    public function simpanPembayaran(Request $request)
    {
        $byr = new pembayaran_bon_tukang();
        $tanggal = date("Y-m-d");
        $byr->insertByr($request,$tanggal);

        $kodemax = $byr->getMaxKode();


        $bon = new bon_tukang();

        $arrbyr = json_decode(session()->get('listbyr'));
        foreach($arrbyr as $row){
            $kode_bon = $row->kode_bon;
            $jumlah = $row->jumlah_bayar;
            $det = new memiliki_detail_bon();
            $det->insertDetail($kode_bon,$kodemax,$jumlah);
            $bon->kurangi($jumlah,$kode_bon);
        }
        $t = new tukang();
        $jt = new jenis_tukang();
        $arrbyr=[];
        $data = [
            'title' => 'Register Bayar Bon',
            'listTukang' => $t->where('kode_mandor', session()->get('kode'))->where('status_delete_tukang',0)->get(),
            'listJenis' => $jt->where('kode_mandor', session()->get('kode'))->where('status_delete_jt',0)->get(),
            'listBon' => $bon->where('status_lunas','0')->where('status_delete_bon',0)->get(),
            'listBayar' => json_encode($arrbyr),
            'error'=>0
        ];
        session()->put('listbyr', json_encode($arrbyr));
        return view("mandor.Creation.tambahPembayaranBon", ['title' => 'Register Bayar Bon'],$data);
        //return redirect('/mandor/tambahPembayaranBon');
    }
}
