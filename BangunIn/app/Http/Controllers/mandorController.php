<?php

namespace App\Http\Controllers;

use App\absen_tukang;
use App\jenis_tukang;
use App\fotopekerjaan;
use App\pekerjaan_khusus;
use App\client;
use App\mandor;
use App\kontraktor;
use App\administrator;
use App\bon_tukang;
use App\bukti_pembelian_mandor;
use App\memiliki_detail_bon;
use App\pekerjaan;
use App\pembayaran_bon_tukang;
use App\pk_dana;
use App\Rules\cbDetBon;
use App\Rules\cbJenis;
use App\Rules\cbRequired;
use App\Rules\cbTukang;
use App\Rules\cekKembarUpdateJenis;
use App\Rules\cekMaksimalBayar;
use App\Rules\cekPwdLama;
use App\Rules\CekPwdMandor;
use App\Rules\konfirmasiPwd;
use App\Rules\pwdlamabeda;
use App\tukang;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class mandorController extends Controller
{
    public function index()
    {
        return view('mandor.navbar');
    }

    // assign pekerjaan khusus

    public function indexSpecWork()
    {
        $p = new pekerjaan();
        $data = [
            'title' => 'Pekerjaan Khusus',
            'listWork' => $p->where('kode_mandor', session()->get('kode'))
                ->where('status_delete_pekerjaan', 0)
                ->get(),
            'listSpWork' => null
        ];
        return view('mandor.List.listSpecialWork', $data);
    }

    public function searchSpWork(Request $req)
    {
        $p = new pekerjaan();
        $pk = new pekerjaan_khusus();
        $t = new tukang();

        $validator = FacadesValidator::make($req->all(), [
            'work' => [new cbRequired()]
        ]);

        if ($validator->fails()) {
            return redirect('/mandor/indexSpWork')
                ->withErrors($validator)
                ->withInput();
        }
        $data = [
            'title' => 'List Pekerjaan Khusus',
            'listWork' => $p->where('kode_mandor', session()->get('kode'))
                ->where('status_delete_pekerjaan', 0)
                ->get(),
            'listSpWork' => $pk->where('kode_pekerjaan', $req->work)
                ->where('status_delete_pk', 0)
                // ->where('id_detail_permintaan_uang', '<>', null)
                ->get(),
            'listTukang' => $t->where('kode_mandor', session()->get('kode'))
                ->get(),
            'current' => $p->find($req->work),
            'mode' => 1
        ];
        // dd($data['listSpWork'][0]->pk_dana);
        session()->put('kode_p', $req->work);
        session()->put('listWork', $data['listWork']);
        session()->put('listSpWork', $data['listSpWork']);
        session()->put('listTukang', $data['listTukang']);
        session()->put('current', $data['current']);
        return view('mandor.List.listSpecialWork', $data);
    }

    public function editSpWork(Request $req)
    {
        $req->validate([
            'work' => [new cbRequired()]
        ]);
        $data = [
            'title' => 'List Pekerjaan Khusus',
            'listWork' => session()->get('listWork'),
            'listSpWork' => session()->get('listSpWork'),
            'listTukang' => session()->get('listTukang'),
            'current' => session()->get('current'),
            'mode' => 2
        ];
        return view('mandor.List.listSpecialWork', $data);
    }

    public function assign(Request $req)
    {
        // dd($req->input());
        $pk = new pekerjaan_khusus();
        $ctr = 0;
        $temp = null;
        foreach ($req->id as $item) {
            $flag = true;
            if ($req->status !== null) {
                foreach ($req->status as $val) {
                    if ($req->id[$val] == $item) {
                        $flag = false; // index yang dicentang
                    }
                }
            }
            if ($flag) {
                $temp[] = $item; // index yang tidak dicentang
            }
        }
        // dd($temp);
        if ($temp !== null) {
            foreach ($temp as $item) {
                $pk->donePk($item, 0);
            }
        }

        // pekerjaan yang selesai (checked)
        if ($req->status !== null) {
            foreach ($req->status as $item) {
                if ($req->tukang[$item] != "-") {
                    $pk->donePk($req->id[$item], 1);
                } else {
                    session()->put('err', 'Ada pekerjaan khusus yang diselesaikan tanpa tukang!');
                    return redirect('/mandor/indexSpWork');
                }
            }
        }
        foreach ($req->tukang as $tuk) {
            if ($tuk != "-") {
                $pk->assign($req->id[$ctr], $tuk);
            } else {
                $pk->assign($req->id[$ctr], null);
            }
            $ctr++;
        }


        $files = $req->file('bukti_dana');
        if ($files !== null) {
            foreach ($files as $file) {
                $fileName[] = $file->getClientOriginalName();
                $file->move(public_path('/assets/bukti_dana_pk/'),  $file->getClientOriginalName());
            }

            $ctr = 0;
            foreach ($req->type_file as $item) {
                $pkd = new pk_dana();
                $pkd->insert($req->id[$item], $fileName[$ctr], $req->dana[$item]);
                $ctr++;
            }
        }

        $pkd = new pk_dana();
        $ctr = 0;
        if ($req->idpkd !== null) {
            foreach ($req->idpkd as $item) {
                $pkd->updateJumlah($req->dana[$req->upd[$ctr]], $item);
                $ctr++;
            }
        }
        session()->put('upd', 'Berhasil mengubah data!');
        return redirect('/mandor/indexSpWork');
    }

    public function ieditBuktiTsf($kode)
    {
        $pkd = new pk_dana();
        $data = [
            'pk_dana' => $pkd->where('kode_pk_dana', $kode)->get()->first()
        ];
        // dd($data);
        return view('mandor.Detail.detailEditBuktiTsf', $data);
    }

    public function confirmEditBukti(Request $req)
    {
        $pkd = new pk_dana();

        $file = $req->file('buktiBaru');
        $fileName = $file->getClientOriginalName();
        $file->move(public_path('/assets/bukti_dana_pk/'),  $file->getClientOriginalName());

        $pkd->updateBuktiBaru($req->kode_pk_dana, $fileName);

        session()->put('upd', 'Berhasil mengubah data!');
        return redirect('/mandor/backToEditSpWork');
    }

    public function backToEditSpWork()
    {
        $p = new pekerjaan();
        $pk = new pekerjaan_khusus();
        $t = new tukang();
        $data = [
            'title' => 'List Pekerjaan Khusus',
            'listWork' => $p->where('kode_mandor', session()->get('kode'))
                ->where('status_delete_pekerjaan', 0)
                ->get(),
            'listSpWork' => $pk->where('kode_pekerjaan', session()->get('kode_p'))
                ->where('status_delete_pk', 0)
                // ->where('id_detail_permintaan_uang', '<>', null)
                ->get(),
            'listTukang' => $t->where('kode_mandor', session()->get('kode'))
                ->get(),
            'current' => $p->find(session()->get('kode_p')),
            'mode' => 2
        ];
        return view('mandor.List.listSpecialWork', $data);
    }


    // nota pembelian bahan

    public function menuNota()
    {
        $b = new pekerjaan();
        $data = [
            'listPekerjaan' => $b->listDataPekerjaanMandor()
        ];
        return view('mandor.Creation.inputNota', $data);
    }

    public function indexList()
    {
        $bpm = new bukti_pembelian_mandor();
        $data = [
            'listNota' => $bpm->listNota()
        ];
        return view('mandor.List.listNotaPembelianBahan', $data);
    }

    public function inputNota(Request $req)
    {
        $req->validate([
            'bukti' => 'required',
            'bukti.*' => 'mimes:jpeg,png,jpg,gif,svg',
            'work' => [new cbRequired]
        ], [
            'bukti.required' => 'Tolong masukkan bukti gambar!'
        ]);
        $files = $req->file('bukti');
        foreach ($files as $file) {
            $fileName =  $file->getClientOriginalName();
            $file->move(public_path('/assets/nota_beli/'),  $file->getClientOriginalName());
            session()->put('bukti', $fileName);
            $bpm = new bukti_pembelian_mandor();
            $bpm->insert($req);
            session()->forget('bukti');
        }

        $b = new pekerjaan();
        $data = [
            'listPekerjaan' => $b->listDataPekerjaanMandor(),
            'succInputNota' => 'Berhasil menginputkan nota pembelian!'
        ];
        return view('mandor.Creation.inputNota', $data);
    }

    public function deleteNotaPembelian($id)
    {
        $bpm = new bukti_pembelian_mandor();
        $bpm->deleteNota(decrypt($id));

        $data = [
            'listNota' => $bpm->listNota(),
            'del' => 'Berhasil menghapus nota pembelian bahan!'
        ];
        return view('mandor.List.listNotaPembelianBahan', $data);
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
            'listDelJenisTukangs' => $jt->where('kode_mandor', session()->get('kode'))->where('status_delete_jt', 1)->get(),
            'error' => 10
        ];
        return view('mandor.Deleted.deletedJenisTukang', $data);
    }
    public function storeJenisTukang(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string',
                'gaji' => 'required|numeric|gte:0',
            ],
            [
                'name.string' => 'Kolom nama hanya bisa di isi huruf!',
                'gaji.gte' => 'Gaji Pokok harus >= 0'
            ]
        );
        $jt = new jenis_tukang();
        $data = [
            'title' => 'Tambah Jenis Tukang',
            'error' => 0
        ];
        if ($jt->cekJenis($request->input('name')) == 0) {
            $jt->insertJenis($request);
            //return redirect('/mandor/submitRegJenisTukang');
            return view('mandor.Creation.tambahJenisTukang', $data);
        } else {
            if ($jt->cekJenisTukangDeleted($request->input('name')) == 1) {
                //ada tapi udah kedelete,maka dipulihkan
                //dd("masuk");
                $kode = $jt->cekKodeTukangDeleted($request->input('name'));
                $kode = substr($kode, 1);
                $kode = substr($kode, 0, strlen($kode) - 1);
                //dd($kode);
                $jt->updateDeletedJT($request, $kode);
                return view('mandor.Creation.tambahJenisTukang', $data);
            } else {
                $data['error'] = 5; //nama jenis sdh ada
            }
            return view('mandor.Creation.tambahJenisTukang', $data);
        }
    }
    public function lihatJenisTukang()
    {
        $jt = new jenis_tukang();
        $data = [
            'title' => 'List Jenis Tukang',
            'listJenisTukangs' => $jt->where('kode_mandor', session()->get('kode'))->where('status_delete_jt', 0)->get()
        ];
        return view('mandor.List.listJenisTukang', $data);
    }
    public function lihatdeletedJenis()
    {
        $jt = new jenis_tukang();
        $data = [
            'title' => 'List Jenis Tukang',
            'listDelJenisTukangs' => $jt->where('kode_mandor', session()->get('kode'))->where('status_delete_jt', 1)->get()
        ];
        return view('mandor.Deleted.deletedJenisTukang', $data);
    }
    public function detailjenis($id)
    {
        $jt = new jenis_tukang();
        $nama = $jt->getNamaJenis($id);
        $nama = substr($nama, 2);
        $nama = substr($nama, 0, strlen($nama) - 2);
        $gaji = $jt->getGaji($id);
        $gaji = substr($gaji, 1);
        $gaji = substr($gaji, 0, strlen($gaji) - 1);
        $data = [
            'title' => 'Detail Jenis',
            'nama' => $nama,
            'gaji' => $gaji,
            'kodejenis' => $id
        ];
        return view('mandor.Detail.detailJenis', $data);
    }
    public function updateJenisTukang(Request $request)
    {
        $jt = new jenis_tukang();
        $kode = $request->kodejenis;
        //dd($kode);

        $request->validate(
            [
                'name' => [new cekKembarUpdateJenis($kode), 'required', 'string'],
                'gaji' => 'required|numeric|gte:0',
            ],
            [
                'name.required' => 'Kolom nama belum diisi',
                'name.string' => 'Kolom nama hanya bisa di isi huruf!',
                'gaji.gte' => 'Gaji Pokok harus >= 0'
            ]
        );
        if ($jt->cekJenisTukangDeleted($request->input('name')) == 1) {
            //ada tapi udah kedelete,maka dipulihkan
            //dd("masuk");
            $kodeini = $kode;
            //dd($kodeini);
            $jt->softDelete($kodeini);
            $kode = $jt->cekKodeTukangDeleted($request->input('name'));
            $kode = substr($kode, 1);
            $kode = substr($kode, 0, strlen($kode) - 1);
            //dd($kode);
            $jt->updateDeletedJT($request, $kode);
            $t = new tukang();
            $t->updateJenisLama($kodeini, $kode);
            $data = [
                'title' => 'List Jenis Tukang',
                'listJenisTukangs' => $jt->where('kode_mandor', session()->get('kode'))->where('status_delete_jt', 0)->get(),
                'error' => 10
            ];
            return view('mandor.List.listJenisTukang', $data);
        } else {
            $jt->updateJenis($request, $kode);
            $data = [
                'title' => 'List Jenis Tukang',
                'listJenisTukangs' => $jt->where('kode_mandor', session()->get('kode'))->where('status_delete_jt', 0)->get()
            ];
            return view('mandor.List.listJenisTukang', $data);
        }
    }
    public function deleteJenis($id)
    {
        $m = new jenis_tukang();
        $m->softDelete($id);
        $data = [
            'title' => 'List Jenis Tukang',
            'listJenisTukangs' => $m->where('kode_mandor', session()->get('kode'))->where('status_delete_jt', 0)->get()
        ];
        return view('mandor.List.listJenisTukang', $data);
        //return redirect('mandor/lihatJenisTukang');
    }

    //tukang
    public function tambahTukang()
    {
        $jt = new jenis_tukang();
        $data = [
            'title' => 'Register Tukang',
            'listJenis' => $jt->where('kode_mandor', session()->get('kode'))->where('status_delete_jt', 0)->get()
        ];
        return view("mandor.Creation.tambahTukang", ['title' => 'Tambah Tukang'], $data);
    }
    public function storeTukang(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'no' => 'required|numeric',
            'username' => 'required',
            'email' => 'required',
            'pass' => 'required',
            'gaji' => 'required|numeric|gte:0',
            'cpwd' => new konfirmasiPwd($request->pass)
        ], [
            'name.string' => 'Kolom nama hanya bisa di isi huruf!',
            'gaji.gte' => 'Gaji Pokok harus >= 0',
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
            'listJenis' => $jt->where('kode_mandor', session()->get('kode'))->where('status_delete_jt', 0)->get()
        ];
        if (count($jt->nameToCode($jenis)) == 0) {
            $data['error'] = 6; // 6 = belum pilih jenis tukang
        } else if (count($m->nameToCode($un)) != 0) {
            $data['error'] = 1; //username sdh terpakai
        } else if (count($a->nameToCode($un)) != 0) {
            $data['error'] = 1;
        } else if (count($k->nameToCode($un)) != 0) {
            $data['error'] = 1;
        } else if (count($tukang->nameToCode($un)) != 0) {
            $data['error'] = 1;
        }
        if ($data['error'] == 6 || $data['error'] == 1) {
            return view('mandor.Creation.tambahTukang', $data);
        } else {

            $kj = $jt->nameToCode($jenis);
            $kj = substr($kj, 1);
            $kj = substr($kj, 0, strlen($kj) - 1);
            $tukang->insertTukang($request, $kj);
            //return redirect('/mandor/submitRegTukang');
            return view('mandor.Creation.tambahTukang', $data);
        }
    }
    public function lihatTukang()
    {
        $t = new tukang();
        $jt = new jenis_tukang();
        $bon = new bon_tukang();
        $data = [
            'title' => 'List Tukang',
            'listTukang' => $t->where('kode_mandor', session()->get('kode'))->where('status_delete_tukang', 0)->get(),
            'listJenis' => $jt->get(),
            'listBon' => $bon->where('status_lunas', 0)->get()
        ];
        return view('mandor.List.listTukang', $data);
    }
    public function lihatdeletedTukang()
    {
        $t = new tukang();
        $jt = new jenis_tukang();
        $bon = new bon_tukang();
        $data = [
            'title' => 'List Tukang',
            'listTukang' => $t->where('kode_mandor', session()->get('kode'))->where('status_delete_tukang', 1)->get(),
            'listJenis' => $jt->get()
        ];
        return view('mandor.Deleted.deletedTukang', $data);
    }
    public function rollbackTukang($id)
    {
        $t = new tukang();
        $t->rollbackTukang($id);

        $jt = new jenis_tukang();
        $bon = new bon_tukang();
        $data = [
            'title' => 'List Tukang',
            'listTukang' => $t->where('kode_mandor', session()->get('kode'))->where('status_delete_tukang', 1)->get(),
            'listJenis' => $jt->get()
        ];
        return view('mandor.Deleted.deletedTukang', $data);
    }
    public function detailtukang($id)
    {
        $jt = new jenis_tukang();
        $tk = new tukang();

        $kodejenis = $tk->getKodeJenis($id);
        $kodejenis = substr($kodejenis, 1);
        $kodejenis = substr($kodejenis, 0, strlen($kodejenis) - 1);

        $namajenis = $jt->codetoName($kodejenis);
        $namajenis = substr($namajenis, 2);
        $namajenis = substr($namajenis, 0, strlen($namajenis) - 2);

        $nama = $tk->getNamaTukang($id);
        $nama = substr($nama, 2);
        $nama = substr($nama, 0, strlen($nama) - 2);

        $un = $tk->kodeToNama($id);
        $un = substr($un, 2);
        $un = substr($un, 0, strlen($un) - 2);

        $nohp = $tk->getNo($id);
        $nohp = substr($nohp, 2);
        $nohp = substr($nohp, 0, strlen($nohp) - 2);

        $email = $tk->getEmail($id);
        $email = substr($email, 2);
        $email = substr($email, 0, strlen($email) - 2);

        $gaji = $tk->getGaji($id);
        $gaji = substr($gaji, 1);
        $gaji = substr($gaji, 0, strlen($gaji) - 1);

        $password = $tk->getPassword($id);
        $password = substr($password, 2);
        $password = substr($password, 0, strlen($password) - 2);
        //echo $namajenis;
        //dd($namajenis);
        $data = [
            'kodetukang' => $id,
            'title' => 'Detail Tukang',
            'kodejenistukang' => $namajenis,
            'gajitukang' => $gaji,
            'namatukang' => $nama,
            'usernametukang' => $un,
            'notelptukang' => $nohp,
            'emailtukang' => $email,
            'passwordtukang' => $password,
            'listJenis' => $jt->where('kode_mandor', session()->get('kode'))->where('status_delete_jt', 0)->get()
        ];
        //dd($data);
        return view('mandor.Detail.detailTukang', $data);
    }

    public function deleteTukang($id)
    {
        $t = new tukang();
        $bon = new bon_tukang();
        if ($bon->cekMasihadaBon($id) == 0) {

            $t->softDelete($id);
            $jt = new jenis_tukang();
            $bon = new bon_tukang();
            $data = [
                'title' => 'List Tukang',
                'listTukang' => $t->where('kode_mandor', session()->get('kode'))->where('status_delete_tukang', 0)->get(),
                'listJenis' => $jt->get(),
                'listBon' => $bon->where('status_lunas', 0)->get()
            ];
            return view('mandor.List.listTukang', $data);
        } else {
            $jt = new jenis_tukang();
            $bon = new bon_tukang();
            $data = [
                'title' => 'List Tukang',
                'listTukang' => $t->where('kode_mandor', session()->get('kode'))->where('status_delete_tukang', 0)->get(),
                'listJenis' => $jt->get(),
                'listBon' => $bon->where('status_lunas', 0)->get(),
                'error' => 14
            ];
            return view('mandor.List.listTukang', $data);
        }
    }

    public function updateTukang(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'no' => 'required|numeric',
            'username' => 'required',
            'email' => 'required',
            'gaji' => 'required|numeric|gte:0',
        ], [
            'name.string' => 'Kolom nama hanya bisa di isi huruf!',
            'gaji.gte' => 'Gaji Pokok harus >= 0',
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
            'listJenis' => $jt->where('kode_mandor', session()->get('kode'))->where('status_delete_jt', 0)->get()
        ];
        if (count($jt->nameToCode($jenis)) == 0) {
            $data['error'] = 6; // 6 = belum pilih jenis tukang
            return view('mandor.Creation.tambahTukang', $data);
        } else {
            $kj = $jt->nameToCode($jenis);
            $kj = substr($kj, 1);
            $kj = substr($kj, 0, strlen($kj) - 1);
            $tukang->updateTukang($request, $kj);
            $t = new tukang();
            $jt = new jenis_tukang();
            $bon = new bon_tukang();
            $data = [
                'title' => 'List Tukang',
                'listTukang' => $t->where('kode_mandor', session()->get('kode'))->where('status_delete_tukang', 0)->get(),
                'listJenis' => $jt->get(),
                'listBon' => $bon->where('status_lunas', 0)->get()
            ];
            return view('mandor.List.listTukang', $data);
        }
    }
    public function gantiPass($id)
    {
        $data = [
            'title' => 'Update Password Tukang',
            'kodetukang' => $id
        ];
        return view('mandor.Detail.updatePassTukang', $data);
    }
    public function storeGantiPass(Request $request)
    {
        $kodetukang = $request->kodetukang;
        $kodemandor = $request->session()->get('kode');
        $mandor = new mandor();
        $pass = $mandor->getPassword($kodemandor);
        $pass = substr($pass, 2);
        $pass = substr($pass, 0, strlen($pass) - 2);
        //dd($pass);
        //dd($kodetukang);
        $request->validate([
            'passlama' => ['required', new CekPwdMandor($pass)],
            'passbaru' => ['required', new pwdlamabeda($kodetukang)],
            'cpassbaru' => ['required', new konfirmasiPwd($request->passbaru)]
        ], [
            'passlama.required' => 'Kolom kata sandi mandor belum diisi!',
            'passbaru.required' => 'Kata sandi baru belum diisi!',
            'cpassbaru.required' => 'Konfirmasi Kata Sandi baru belum diisi!'
        ]);
        $t = new tukang();
        $t->gantiPwd($kodetukang, $request);
        $jt = new jenis_tukang();
        $bon = new bon_tukang();
        $data = [
            'title' => 'List Tukang',
            'listTukang' => $t->where('kode_mandor', session()->get('kode'))->where('status_delete_tukang', 0)->get(),
            'listJenis' => $jt->get(),
            'listBon' => $bon->where('status_lunas', 0)->get(),
            'error' => 11
        ];
        return view('mandor.List.listTukang', $data);
    }
    //bon
    public function tambahBon()
    {
        $t = new tukang();
        $jt = new jenis_tukang();
        $data = [
            'title' => 'Register Bon',
            'listTukang' => $t->where('kode_mandor', session()->get('kode'))->where('status_delete_tukang', 0)->get(),
            'listJenis' => $jt->where('kode_mandor', session()->get('kode'))->where('status_delete_jt', 0)->get()
        ];
        return view("mandor.Creation.tambahBon", ['title' => 'Tambah Bon'], $data);
    }
    public function tambahBonTukangX($id)
    {
        //dd($id);
        $tukang = new tukang();
        $nama = $tukang->codetoName($id);
        $nama = substr($nama, 2);
        $nama = substr($nama, 0, strlen($nama) - 2);
        //dd($nama);
        $data = [
            'title' => 'Register Bon Khusus',
            'nama' => $nama,
            'kode' => $id
        ];
        return view("mandor.Creation.tambahBonKhusus", ['title' => 'Tambah Bon'], $data);
    }
    public function storeBon(Request $request)
    {
        $request->validate([
            'tanggal' => 'required',
            'jumlah' => 'required|numeric|gte:0',
            'keteranganbon' => 'required'
        ], [
            'jumlah.gte' => 'Jumlah Bon harus >= 0'
        ]);

        $nama = $request->nm;
        $arr = explode("-", $nama);
        $tukangpicked = $arr[0];

        $jt = new jenis_tukang();
        $tukang = new tukang();
        $data = [
            'title' => 'Register Bon',
            'error' => 0, // 0 = success,
            'listTukang' => $tukang->where('kode_mandor', session()->get('kode'))->where('status_delete_tukang', 0)->get(),
            'listJenis' => $jt->where('kode_mandor', session()->get('kode'))->where('status_delete_jt', 0)->get()
        ];
        if (count($tukang->nameToCode($tukangpicked)) == 0) {
            $data['error'] = 7; // 7 = belum pilih tukang
            return view('mandor.Creation.tambahBon', $data);
        } else {
            $kt = $tukang->nameToCode($tukangpicked);
            $kt = substr($kt, 1);
            $kt = substr($kt, 0, strlen($kt) - 1);
            $bon = new bon_tukang();
            $bon->insertBon($request, $kt);
            return view('mandor.Creation.tambahBon', $data);
        }
    }
    public function storeBonKhusus(Request $request)
    {
        $request->validate([
            'tanggal' => 'required',
            'jumlah' => 'required|numeric|gte:0',
            'keteranganbon' => 'required'
        ], [
            'jumlah.gte' => 'Jumlah Bon harus >= 0'
        ]);

        $kode = $request->kodetkg;

        $bon = new bon_tukang();
        $bon->insertBon($request, $kode);

        $t = new tukang();
        $nama = $t->kodeToNama($kode);
        $nama = substr($nama, 2);
        $nama = substr($nama, 0, strlen($nama) - 2);
        $data = [
            'title' => 'List Bon',
            'listBon' => $bon->where('status_lunas', 0)->where('kode_tukang', $kode)->where('status_delete_bon', 0)->get(),
            'nama' => $nama,
            'kode' => $kode,
            'error' => 12
        ];
        return view('mandor.List.listBonTukang', $data);
        //return redirect("/mandor/lihatBonTukang/".$kode);

    }
    public function lihatBon()
    {
        $mandor = new mandor();
        $kodemandor = session()->get('kode');
        $namamandor = $mandor->codetoName(session()->get('kode'));
        $namamandor = substr($namamandor, 2);
        $namamandor = substr($namamandor, 0, strlen($namamandor) - 2);
        $t = new tukang();
        $jt = new jenis_tukang();
        $bon = new bon_tukang();
        $data = [
            'title' => 'List Bon',
            'listTukang' => $t->where('kode_mandor', session()->get('kode'))->where('status_delete_tukang', 0)->get(),
            'listJenis' => $jt->where('kode_mandor', session()->get('kode'))->where('status_delete_jt', 0)->get(),
            'listBon' => $bon->where('status_lunas', 0)->where('status_delete_bon', 0)->get(),
            'mandor' => $namamandor
        ];
        return view('mandor.List.listBon', $data);
    }
    public function lihatBonTukang($id)
    {
        $bon = new bon_tukang();
        $t = new tukang();
        $nama = $t->codetoName($id);
        $nama = substr($nama, 2);
        $nama = substr($nama, 0, strlen($nama) - 2);
        $data = [
            'title' => 'List Bon',
            'listBon' => $bon->where('status_lunas', 0)->where('kode_tukang', $id)->where('status_delete_bon', 0)->get(),
            'nama' => $nama,
            'kode' => $id
        ];
        return view('mandor.List.listBonTukang', $data);
    }
    public function cekBonTukang($id)
    {
        $bon = new bon_tukang();
        $t = new tukang();
        $nama = $t->codetoName($id);
        $nama = substr($nama, 2);
        $nama = substr($nama, 0, strlen($nama) - 2);
        $data = [
            'title' => 'List Bon',
            'listBon' => $bon->where('status_lunas', 0)->where('kode_tukang', $id)->where('status_delete_bon', 0)->get(),
            'nama' => $nama,
            'kode' => $id
        ];
        return view('mandor.List.cekBonTukang', $data);
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
        $mandor = new mandor();
        $kodemandor = session()->get('kode');
        $namamandor = $mandor->codetoName(session()->get('kode'));
        $namamandor = substr($namamandor, 2);
        $namamandor = substr($namamandor, 0, strlen($namamandor) - 2);
        $arrbon = [];
        if (session()->has('listbyr')) {
            $arrbon = json_decode(session()->get('listbyr'));
        }
        if (session()->has('jumtotal')) {
            $jumtotal = json_decode(session()->get('jumtotal'));
        } else {
            $jumtotal = 0;
        }
        $data = [
            'title' => 'Register Bayar Bon',
            'listTukang' => $t->where('kode_mandor', session()->get('kode'))->where('status_delete_tukang', 0)->get(),
            'listJenis' => $jt->where('kode_mandor', session()->get('kode'))->where('status_delete_jt', 0)->get(),
            'listBon' => $bon->where('status_lunas', '0')->where('status_delete_bon', 0)->get(),
            'listBayar' => json_encode($arrbon),
            'mandor' => $namamandor,
            'jumtotal' => $jumtotal
        ];
        session()->put('listbyr', json_encode($arrbon));
        session()->put('jumtotal', json_encode($jumtotal));
        return view("mandor.Creation.tambahPembayaranBon", ['title' => 'Register Bayar Bon'], $data);
    }

    public function fetch(Request $request)
    {
        $value = $request->get('value');

        $bon = new bon_tukang();
        $data = $bon->where('status_lunas', '0')
            ->where('kode_tukang', $value)
            ->where('status_delete_bon', '0')
            ->get();
        $output = "<option value=''>-</option>";
        foreach ($data as $row) {
            $output .= "<option value='" . $row->kode_bon . "'>" . $row->keterangan_bon . " ~ " . $row->sisa_bon . "</option>";
        }
        echo $output;
    }
    public function fetchgaji(Request $request)
    {
        $value = $request->get('value');

        $jt = new jenis_tukang();
        $gaji = $jt->nameToGaji($value);
        echo $gaji;
    }
    public function tambahBayar(Request $request)
    {
        $kdbon = $request->detailbon;
        if ($kdbon != '') {
            $request->validate(
                [
                    'nm' => [new cbTukang()],
                    'detailbon' => [new cbDetBon(), 'bail'],
                    'jumlahbyr' => ['required', 'numeric', new cekMaksimalBayar($kdbon), 'gte:0'],
                ],
                [
                    'jumlahbyr.gte' => 'Jumlah Bayar harus >= 0'
                ]
            );

            $kode_tukang = $request->nm;
            $jumlah = $request->jumlahbyr;

            $tukang = new tukang();
            $bon = new bon_tukang();

            $arrbyr = json_decode(session()->get('listbyr'));
            $nmtkg = $tukang->kodeToNama($kode_tukang);
            $ket = $bon->kodetoKet($kdbon);

            $nama = $nmtkg[0];
            $ktg = $ket[0];
            $ada = -1;
            if (session()->get('jumtotal')) {
                $jumtotal = session()->get('jumtotal');
            } else {
                $jumtotal = 0;
            }
            foreach ($arrbyr as $row) {
                if ($row->kode_bon == $kdbon) {
                    $ada = 1;
                    $jumsblm = $row->jumlah_bayar;
                    $jumsblm += $jumlah;
                    $row->jumlah_bayar = $jumsblm;
                    $jumtotal += $jumlah;
                }
            }
            if ($ada == -1) {
                $baru = array(
                    "nama_tukang" => $nama,
                    "kode_bon" => $kdbon,
                    "keterangan" => $ktg,
                    "jumlah_bayar" => $jumlah
                );
                $jumtotal += $jumlah;
                array_push($arrbyr, $baru);
            }

            //dd($jumtotal);
            $t = new tukang();
            $jt = new jenis_tukang();
            $data = [
                'title' => 'Register Bayar Bon',
                'listTukang' => $t->where('kode_mandor', session()->get('kode'))->where('status_delete_tukang', 0)->get(),
                'listJenis' => $jt->where('kode_mandor', session()->get('kode'))->where('status_delete_jt', 0)->get(),
                'listBon' => $bon->where('status_lunas', '0')->where('status_delete_bon', 0)->get(),
                'listBayar' => json_encode($arrbyr),
                'jumtotal' => $jumtotal
            ];
            session()->put('listbyr', json_encode($arrbyr));
            session()->put('jumtotal', $jumtotal);
            //return view("mandor.Creation.tambahPembayaranBon", ['title' => 'Register Bayar Bon'],$data);
            return redirect('/mandor/tambahPembayaranBon');
        } else {
            $request->validate([
                'nm' => [new cbTukang()],
                'detailbon' => [new cbDetBon(), 'bail'],
            ]);

            $kode_tukang = $request->nm;
            $jumlah = $request->jumlahbyr;

            $tukang = new tukang();
            $bon = new bon_tukang();

            $arrbyr = json_decode(session()->get('listbyr'));
            $nmtkg = $tukang->kodeToNama($kode_tukang);
            $ket = $bon->kodetoKet($kdbon);

            $nama = $nmtkg[0];
            $ktg = $ket[0];
            $ada = -1;
            if (session()->get('jumtotal')) {
                $jumtotal = session()->get('jumtotal');
            } else {
                $jumtotal = 0;
            }
            foreach ($arrbyr as $row) {
                if ($row->kode_bon == $kdbon) {
                    $ada = 1;
                    $jumsblm = $row->jumlah_bayar;
                    $jumsblm += $jumlah;
                    $row->jumlah_bayar = $jumsblm;
                    $jumtotal += $jumlah;
                }
            }
            if ($ada == -1) {
                $baru = array(
                    "nama_tukang" => $nama,
                    "kode_bon" => $kdbon,
                    "keterangan" => $ktg,
                    "jumlah_bayar" => $jumlah
                );
                $jumtotal += $jumlah;
                array_push($arrbyr, $baru);
            }

            //dd($jumtotal);
            $t = new tukang();
            $jt = new jenis_tukang();
            $data = [
                'title' => 'Register Bayar Bon',
                'listTukang' => $t->where('kode_mandor', session()->get('kode'))->where('status_delete_tukang', 0)->get(),
                'listJenis' => $jt->where('kode_mandor', session()->get('kode'))->where('status_delete_jt', 0)->get(),
                'listBon' => $bon->where('status_lunas', '0')->where('status_delete_bon', 0)->get(),
                'listBayar' => json_encode($arrbyr),
                'jumtotal' => $jumtotal
            ];
            session()->put('listbyr', json_encode($arrbyr));
            session()->put('jumtotal', $jumtotal);
            //return view("mandor.Creation.tambahPembayaranBon", ['title' => 'Register Bayar Bon'],$data);
            return redirect('/mandor/tambahPembayaranBon');
        }
    }
    public function tambahBayarKhusus(Request $request)
    {
        //dd("masuk");
        $kodebon = $request->kodebon;
        //dd($kodebon);
        $request->validate(
            [
                'jumlah' => ['required', 'numeric', new cekMaksimalBayar($kodebon), 'gte:0'],
            ],
            [
                'jumlah.gte' => 'Jumlah Bayar harus >= 0'
            ]
        );
        //dd("pass");

        $byr = new pembayaran_bon_tukang();
        $tanggal = date("Y-m-d");
        $byr->insertByr($request, $tanggal);
        $kodemax = $byr->getMaxKode();

        $bon = new bon_tukang();
        $jumlah = $request->jumlah;
        $det = new memiliki_detail_bon();
        $det->insertDetail($kodebon, $kodemax, $jumlah);
        $bon->kurangi($jumlah, $kodebon);
        $jumlah = $bon->where('kode_bon', $kodebon)->pluck('sisa_bon');
        $jumlah = substr($jumlah, 1);
        $jumlah = substr($jumlah, 0, strlen($jumlah) - 1);
        if ($jumlah != 0) {
            return $this->detailPembayaranBon($kodebon);
        } else {
            $bon = new bon_tukang();
            $id = $bon->where('kode_bon', $kodebon)->pluck('kode_tukang');
            $id = substr($id, 1);
            $id = substr($id, 0, strlen($id) - 1);
            $t = new tukang();
            $nama = $t->codetoName($id);
            $nama = substr($nama, 2);
            $nama = substr($nama, 0, strlen($nama) - 2);
            $data = [
                'title' => 'List Bon',
                'listBon' => $bon->where('status_lunas', 0)->where('kode_tukang', $id)->where('status_delete_bon', 0)->get(),
                'nama' => $nama,
                'kode' => $id,
                'error' => 13
            ];
            return view('mandor.List.listBonTukang', $data);
        }
    }
    public function detailPembayaranBon($id)
    {
        $kode = $id;
        $mandor = new mandor();
        $kodemandor = session()->get('kode');
        $namamandor = $mandor->codetoName(session()->get('kode'));
        $namamandor = substr($namamandor, 2);
        $namamandor = substr($namamandor, 0, strlen($namamandor) - 2);
        $mbon = new memiliki_detail_bon();
        $bon = new bon_tukang();
        $t = new tukang();
        $bons = $bon->where('kode_bon', $kode)->pluck('kode_tukang');
        $bons = substr($bons, 1);
        $bons = substr($bons, 0, strlen($bons) - 1);
        $namatukang = $t->codetoName($bons);
        $namatukang = substr($namatukang, 2);
        $namatukang = substr($namatukang, 0, strlen($namatukang) - 2);
        $pb = new pembayaran_bon_tukang();
        $data = [
            'title' => 'Detail Pembayaran Bon',
            'bon' => $bon->where('kode_bon', $kode)->get(),
            'listBayar' => $mbon->where('kode_bon', $kode)->get(),
            'listKodeBayar' => $pb->get(),
            'mandor' => $namamandor,
            'tukang' => $namatukang,
            'kode' => $bons,
            'kdbon' => $id
        ];
        return view("mandor.List.listPembayaranBon", ['title' => 'Detail Pembayaran Bon'], $data);
    }
    public function batalBayar(Request $request)
    {
        $mandor = new mandor();
        $kodemandor = session()->get('kode');
        $namamandor = $mandor->codetoName(session()->get('kode'));
        $namamandor = substr($namamandor, 2);
        $namamandor = substr($namamandor, 0, strlen($namamandor) - 2);
        $kode = $request->kodeku;
        //dd($kode);
        $arrbyr = json_decode(session()->get('listbyr'));
        $jumtotal = json_decode(session()->get('jumtotal'));
        $ctr = 0;
        $posisiketemu = -1;
        $minusjum = 0;
        foreach ($arrbyr as $row) {
            if ($row->kode_bon == $kode) {
                $posisiketemu = $ctr;
                $minusjum = $row->jumlah_bayar;
            }
            $ctr++;
        }
        array_splice($arrbyr, $posisiketemu, 1);
        $jumtotal -= $minusjum;
        $t = new tukang();
        $jt = new jenis_tukang();
        $bon = new bon_tukang();
        $data = [
            'title' => 'Register Bayar Bon',
            'listTukang' => $t->where('kode_mandor', session()->get('kode'))->where('status_delete_tukang', 0)->get(),
            'listJenis' => $jt->where('kode_mandor', session()->get('kode'))->where('status_delete_jt', 0)->get(),
            'listBon' => $bon->where('status_lunas', '0')->where('status_delete_bon', 0)->get(),
            'listBayar' => json_encode($arrbyr),
            'jumtotal' => $jumtotal,
            'mandor' => $namamandor
        ];
        session()->put('listbyr', json_encode($arrbyr));
        session()->put('jumtotal', $jumtotal);
        return view("mandor.Creation.tambahPembayaranBon", ['title' => 'Register Bayar Bon'], $data);
        //return redirect('/mandor/tambahPembayaranBon');
    }
    public function simpanPembayaran(Request $request)
    {
        $mandor = new mandor();
        $kodemandor = session()->get('kode');
        $namamandor = $mandor->codetoName(session()->get('kode'));
        $namamandor = substr($namamandor, 2);
        $namamandor = substr($namamandor, 0, strlen($namamandor) - 2);
        $byr = new pembayaran_bon_tukang();
        $tanggal = date("Y-m-d");
        $byr->insertByr($request, $tanggal);

        $kodemax = $byr->getMaxKode();


        $bon = new bon_tukang();

        $arrbyr = json_decode(session()->get('listbyr'));
        foreach ($arrbyr as $row) {
            $kode_bon = $row->kode_bon;
            $jumlah = $row->jumlah_bayar;
            $det = new memiliki_detail_bon();
            $det->insertDetail($kode_bon, $kodemax, $jumlah);
            $bon->kurangi($jumlah, $kode_bon);
        }
        $t = new tukang();
        $jt = new jenis_tukang();
        $arrbyr = [];
        $data = [
            'title' => 'Register Bayar Bon',
            'listTukang' => $t->where('kode_mandor', session()->get('kode'))->where('status_delete_tukang', 0)->get(),
            'listJenis' => $jt->where('kode_mandor', session()->get('kode'))->where('status_delete_jt', 0)->get(),
            'listBon' => $bon->where('status_lunas', '0')->where('status_delete_bon', 0)->get(),
            'listBayar' => json_encode($arrbyr),
            'error' => 0,
            'mandor' => $namamandor
        ];
        session()->put('listbyr', json_encode($arrbyr));
        session()->put('jumtotal', 0);
        return $this->afterSimpan();
        //return view("mandor.Creation.tambahPembayaranBon", ['title' => 'Register Bayar Bon'],$data);
    }
    public function rincianPembayaran()
    {
        $pb = new pembayaran_bon_tukang();
        $listBayar = $pb->where('kode_mandor', session()->get('kode'))->get();
        $md = new memiliki_detail_bon();
        $detBayar = $md->get();

        $arrtgl = [];
        foreach ($listBayar as $item) {
            $tgl = $item->tanggal_pembayaran_bon;
            $tgl = substr($tgl, 8) . "-" . substr($tgl, 5, 2) . "-" . substr($tgl, 0, 4);
            $ada = false;
            for ($i = 0; $i < count($arrtgl); $i++) {
                if ($tgl == $arrtgl[$i]['tanggal']) {
                    //dd('masuk');
                    $totalsebelum = $arrtgl[$i]['total'];
                    $tambahan = 0;
                    foreach ($detBayar as $item2) {
                        if ($item2->kode_pembayaran_bon == $item->kode_pembayaran_bon) {
                            $tambahan += $item2->jumlah_pembayaran_bon;
                        }
                    }
                    $totalfix = $totalsebelum + $tambahan;
                    $arrtgl[$i]['total'] = $totalfix;
                    $ada = true;
                }
            }
            if ($ada == false) {
                $total = 0;
                foreach ($detBayar as $item2) {
                    if ($item2->kode_pembayaran_bon == $item->kode_pembayaran_bon) {
                        $total += $item2->jumlah_pembayaran_bon;
                    }
                }
                $baru = array(
                    'tanggal' => $tgl,
                    'total' => $total
                );
                array_push($arrtgl, $baru);
            }
        }
        $arrbon = [];
        for ($i = 0; $i < count($arrtgl); $i++) {
            foreach ($listBayar as $item) {
                $tgl = $item->tanggal_pembayaran_bon;
                $tgl = substr($tgl, 8) . "-" . substr($tgl, 5, 2) . "-" . substr($tgl, 0, 4);
                if ($tgl == $arrtgl[$i]['tanggal']) {
                    foreach ($detBayar as $item2) {
                        if ($item->kode_pembayaran_bon == $item2->kode_pembayaran_bon) {
                            $ada = -1;
                            for ($k = 0; $k < count($arrbon); $k++) {
                                if ($arrbon[$k]['tanggal'] == $tgl) {
                                    $kodebon = $item2->kode_bon;
                                    if ($kodebon == $arrbon[$k]['kode_bon']) {
                                        $ada = $k;
                                    }
                                }
                            }
                            if ($ada == -1) {
                                $baru = array(
                                    'tanggal' => $tgl,
                                    'kode_bon' => $item2->kode_bon,
                                    'jumlah' => $item2->jumlah_pembayaran_bon
                                );
                                array_push($arrbon, $baru);
                            } else {
                                $jumlama = $arrbon[$ada]['jumlah'];
                                $jumbaru = $item2->jumlah_pembayaran_bon;
                                $arrbon[$ada]['jumlah'] = $jumlama + $jumbaru;
                            }
                        }
                    }
                }
            }
        }
        $mandor = new mandor();
        $kodemandor = session()->get('kode');
        $namamandor = $mandor->codetoName(session()->get('kode'));
        $namamandor = substr($namamandor, 2);
        $namamandor = substr($namamandor, 0, strlen($namamandor) - 2);
        $t = new tukang();
        $listTukang = $t->get();
        $b = new bon_tukang();
        $listBon = $b->get();
        $data = [
            'arrtgl' => json_encode($arrtgl),
            'mandor' => $namamandor,
            'arrbon' => json_encode($arrbon),
            'listTukang' => $listTukang,
            'listBon' => $listBon
        ];
        return view("mandor.List.listDetBayar", ['title' => 'Detail Pembayaran Bon'], $data);
    }
    public function afterSimpan()
    {
        $tanggalbayar = date("Y-m-d");
        $pb = new pembayaran_bon_tukang();
        $listBayar = $pb->where('kode_mandor', session()->get('kode'))->where('tanggal_pembayaran_bon', $tanggalbayar)->get();
        $md = new memiliki_detail_bon();
        $detBayar = $md->get();

        $arrtgl = [];
        foreach ($listBayar as $item) {
            $tgl = $item->tanggal_pembayaran_bon;
            $tgl = substr($tgl, 8) . "-" . substr($tgl, 5, 2) . "-" . substr($tgl, 0, 4);
            $ada = false;
            for ($i = 0; $i < count($arrtgl); $i++) {
                if ($tgl == $arrtgl[$i]['tanggal']) {
                    //dd('masuk');
                    $totalsebelum = $arrtgl[$i]['total'];
                    $tambahan = 0;
                    foreach ($detBayar as $item2) {
                        if ($item2->kode_pembayaran_bon == $item->kode_pembayaran_bon) {
                            $tambahan += $item2->jumlah_pembayaran_bon;
                        }
                    }
                    $totalfix = $totalsebelum + $tambahan;
                    $arrtgl[$i]['total'] = $totalfix;
                    $ada = true;
                }
            }
            if ($ada == false) {
                $total = 0;
                foreach ($detBayar as $item2) {
                    if ($item2->kode_pembayaran_bon == $item->kode_pembayaran_bon) {
                        $total += $item2->jumlah_pembayaran_bon;
                    }
                }
                $baru = array(
                    'tanggal' => $tgl,
                    'total' => $total
                );
                array_push($arrtgl, $baru);
            }
        }
        $arrbon = [];
        for ($i = 0; $i < count($arrtgl); $i++) {
            foreach ($listBayar as $item) {
                $tgl = $item->tanggal_pembayaran_bon;
                $tgl = substr($tgl, 8) . "-" . substr($tgl, 5, 2) . "-" . substr($tgl, 0, 4);
                if ($tgl == $arrtgl[$i]['tanggal']) {
                    foreach ($detBayar as $item2) {
                        if ($item->kode_pembayaran_bon == $item2->kode_pembayaran_bon) {
                            $ada = -1;
                            for ($k = 0; $k < count($arrbon); $k++) {
                                if ($arrbon[$k]['tanggal'] == $tgl) {
                                    $kodebon = $item2->kode_bon;
                                    if ($kodebon == $arrbon[$k]['kode_bon']) {
                                        $ada = $k;
                                    }
                                }
                            }
                            if ($ada == -1) {
                                $baru = array(
                                    'tanggal' => $tgl,
                                    'kode_bon' => $item2->kode_bon,
                                    'jumlah' => $item2->jumlah_pembayaran_bon
                                );
                                array_push($arrbon, $baru);
                            } else {
                                $jumlama = $arrbon[$ada]['jumlah'];
                                $jumbaru = $item2->jumlah_pembayaran_bon;
                                $arrbon[$ada]['jumlah'] = $jumlama + $jumbaru;
                            }
                        }
                    }
                }
            }
        }
        $mandor = new mandor();
        $kodemandor = session()->get('kode');
        $namamandor = $mandor->codetoName(session()->get('kode'));
        $namamandor = substr($namamandor, 2);
        $namamandor = substr($namamandor, 0, strlen($namamandor) - 2);
        $t = new tukang();
        $listTukang = $t->get();
        $b = new bon_tukang();
        $listBon = $b->get();
        $data = [
            'arrtgl' => json_encode($arrtgl),
            'mandor' => $namamandor,
            'arrbon' => json_encode($arrbon),
            'listTukang' => $listTukang,
            'listBon' => $listBon
        ];
        return view("mandor.List.listDetBayar", ['title' => 'Detail Pembayaran Bon'], $data);
    }
    public function filterRincianBon(Request $request)
    {
        $tanggalbayar = $request->tanggalbayar;
        $pb = new pembayaran_bon_tukang();
        $listBayar = $pb->where('kode_mandor', session()->get('kode'))->where('tanggal_pembayaran_bon', $tanggalbayar)->get();
        $md = new memiliki_detail_bon();
        $detBayar = $md->get();

        $arrtgl = [];
        foreach ($listBayar as $item) {
            $tgl = $item->tanggal_pembayaran_bon;
            $tgl = substr($tgl, 8) . "-" . substr($tgl, 5, 2) . "-" . substr($tgl, 0, 4);
            $ada = false;
            for ($i = 0; $i < count($arrtgl); $i++) {
                if ($tgl == $arrtgl[$i]['tanggal']) {
                    //dd('masuk');
                    $totalsebelum = $arrtgl[$i]['total'];
                    $tambahan = 0;
                    foreach ($detBayar as $item2) {
                        if ($item2->kode_pembayaran_bon == $item->kode_pembayaran_bon) {
                            $tambahan += $item2->jumlah_pembayaran_bon;
                        }
                    }
                    $totalfix = $totalsebelum + $tambahan;
                    $arrtgl[$i]['total'] = $totalfix;
                    $ada = true;
                }
            }
            if ($ada == false) {
                $total = 0;
                foreach ($detBayar as $item2) {
                    if ($item2->kode_pembayaran_bon == $item->kode_pembayaran_bon) {
                        $total += $item2->jumlah_pembayaran_bon;
                    }
                }
                $baru = array(
                    'tanggal' => $tgl,
                    'total' => $total
                );
                array_push($arrtgl, $baru);
            }
        }
        $arrbon = [];
        for ($i = 0; $i < count($arrtgl); $i++) {
            foreach ($listBayar as $item) {
                $tgl = $item->tanggal_pembayaran_bon;
                $tgl = substr($tgl, 8) . "-" . substr($tgl, 5, 2) . "-" . substr($tgl, 0, 4);
                if ($tgl == $arrtgl[$i]['tanggal']) {
                    foreach ($detBayar as $item2) {
                        if ($item->kode_pembayaran_bon == $item2->kode_pembayaran_bon) {
                            $ada = -1;
                            for ($k = 0; $k < count($arrbon); $k++) {
                                if ($arrbon[$k]['tanggal'] == $tgl) {
                                    $kodebon = $item2->kode_bon;
                                    if ($kodebon == $arrbon[$k]['kode_bon']) {
                                        $ada = $k;
                                    }
                                }
                            }
                            if ($ada == -1) {
                                $baru = array(
                                    'tanggal' => $tgl,
                                    'kode_bon' => $item2->kode_bon,
                                    'jumlah' => $item2->jumlah_pembayaran_bon
                                );
                                array_push($arrbon, $baru);
                            } else {
                                $jumlama = $arrbon[$ada]['jumlah'];
                                $jumbaru = $item2->jumlah_pembayaran_bon;
                                $arrbon[$ada]['jumlah'] = $jumlama + $jumbaru;
                            }
                        }
                    }
                }
            }
        }
        $mandor = new mandor();
        $kodemandor = session()->get('kode');
        $namamandor = $mandor->codetoName(session()->get('kode'));
        $namamandor = substr($namamandor, 2);
        $namamandor = substr($namamandor, 0, strlen($namamandor) - 2);
        $t = new tukang();
        $listTukang = $t->get();
        $b = new bon_tukang();
        $listBon = $b->get();
        $data = [
            'arrtgl' => json_encode($arrtgl),
            'mandor' => $namamandor,
            'arrbon' => json_encode($arrbon),
            'listTukang' => $listTukang,
            'listBon' => $listBon
        ];
        return view("mandor.List.listDetBayar", ['title' => 'Detail Pembayaran Bon'], $data);
    }
    //pekerjaan
    public function lihatPekerjaan()
    {
        $pekerjaan = new pekerjaan();
        $pekerjaan = $pekerjaan->where('kode_mandor', session()->get('kode'))
            ->where('status_selesai', 0)
            ->get();
        $param["pekerjaan"] = $pekerjaan;
        return view('mandor.List.listPekerjaan')->with($param);
    }
    public function lihatHistoryPekerjaan()
    {


        $pekerjaan = new pekerjaan();
        $pekerjaan = $pekerjaan->where('kode_mandor', session()->get('kode'))
            ->where('status_selesai', 1)
            ->get();
        $param["pekerjaan"] = $pekerjaan;

        return view('mandor.List.listHistoryPekerjaan')->with($param);
    }
    public function selesaiProject($id)
    {
        $param["id"] = $id;
        return view('mandor.Detail.selesaiProject')->with($param);
    }
    public function finishWork(Request $req)
    {
        $id = decrypt($req->id);
        $pekerjaan = new pekerjaan();
        $pekerjaan->finishWork($id);
        $files = $req->file('bukti');
        $f = new fotopekerjaan();
        foreach ($files as $file) {
            $name = $file->getClientOriginalName();
            $f->uploadFoto($name, $id);
            $file->move(public_path('\assets\bukti_pekerjaan'), $file->getClientOriginalName());
        }
        $param["pesan"] = "Project sudah selesai!";
        return redirect('/mandor/lihatPekerjaan')->with($param);
    }
    public function detailWork($id)
    {
        $f = new fotopekerjaan();
        $p = new pekerjaan();
        $pk = new pekerjaan_khusus();
        $c = new client();
        $m = new mandor();
        $a = new administrator();
        $pekerjaan = new pekerjaan();
        $pekerjaan = $pekerjaan->where('kode_pekerjaan', decrypt($id))
            ->get();
        $data = [
            'title' => 'Detail Pekerjaan',
            'work' => $p->getWork(decrypt($id)),
            'listClient' => $c->where('kode_kontraktor', session()->get('kode'))
                ->where('status_delete_client', 0)
                ->get(),
            'listMandor' => $m->where('kode_kontraktor', session()->get('kode'))
                ->where('status_delete_mandor', 0)
                ->get(),
            'listAdmin' => $a->where('kode_kontraktor', session()->get('kode'))
                ->where('status_delete_admin', 0)
                ->get(),
            'listSpWork' => $pk->where('kode_pekerjaan', decrypt($id))
                ->where('status_delete_pk', 0)
                ->get(),
            'listDelSpWork' => $pk->where('kode_pekerjaan', decrypt($id))
                ->where('status_delete_pk', 1)
                ->get(),
            'listFoto' => $f->where('kode_pekerjaan', decrypt($id))
                ->get(),
            'status' => $pekerjaan[0]->status_selesai
        ];
        session()->put('listSpWorkAwal', $pk->where('kode_pekerjaan', decrypt($id))
            ->get());
        return view('mandor.Detail.detailWork', $data);
    }
}
