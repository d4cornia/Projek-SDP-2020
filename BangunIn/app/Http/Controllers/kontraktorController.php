<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\mandor;
use App\administrator;
use App\client;
use App\kontraktor;
use App\pekerjaan;
use App\pekerjaan_khusus;
use App\pembayaran_client;
use App\tukang;
use App\Rules\cbAdmin;
use App\Rules\cbClient;
use App\Rules\cbMandor;
use App\Rules\cbRequired;
use App\Rules\cekCpass;
use App\Rules\cekNpass;
use App\Rules\cekNamaWork;
use Barryvdh\DomPDF\Facade as PDF;
use App\tagihan;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class kontraktorController extends Controller
{
    public function index()
    {
        return view('kontraktor.navbar');
    }

    public function updatePassword($username, $path)
    {
        $obj = null;
        if ($path == "updPassAdmin") {
            $bef = 'detAdmin';
            $obj = new administrator();
            $old = $obj::where('username_admin', decrypt($username))->pluck('password_admin');
            $kode = $obj::where('username_admin', decrypt($username))->pluck('kode_admin');
        } else if ($path == "updPassMandor") {
            $bef = 'detMandor';
            $obj = new mandor();
            $old = $obj::where('username_mandor', decrypt($username))->pluck('password_mandor');
            $kode = $obj::where('username_mandor', decrypt($username))->pluck('kode_mandor');
        }

        $data = [
            'title' => 'Ubah Kata Sandi',
            'oldPass' => $old[0],
            'username' => decrypt($username),
            'path' => $path,
            'bef' => $bef,
            'kode' => $kode[0]
        ];
        return view('kontraktor.Detail.changePass', $data);
    }

    // Kontraktor

    public function showProfilePerusahaan()
    {
        $k = new kontraktor();
        $k = $k->where('kode_kontraktor', session()->get('kode'))
            ->get();
        $param["nama"] = $k[0]->nama_perusahaan;
        $param["nomer"] = $k[0]->nomer_perusahaan;
        $param["alamat"] = $k[0]->alamat_perusahaan;
        return view('kontraktor.Detail.detailProfile')->with($param);
    }

    public function updateProfilePerusahaan(Request $req)
    {
        $noperusahaan = $req->noperusahaan;
        $nmperusahaan = $req->nmperusahaan;
        $alperusahaan = $req->alperusahaan;
        $logo = $req->file('logo');
        if ($logo != null) {
            $nmlogo = $logo->getClientOriginalName();
            $logo->move(public_path('\assets\logo_perusahaan'), $nmlogo);
            session()->put('lgperusahaan', $nmlogo);
        } else {
            $nmlogo = "";
        }
        $k = new kontraktor();
        $k->updateProfilePerusahaan($nmperusahaan, $noperusahaan, $alperusahaan, $nmlogo);
        session()->put('nmperusahaan', $nmperusahaan);
        $param["upd"] = "Data Perusahaan Telah Di ubah";
        return view('kontraktor.navbar')->with($param);
    }

    //Client

    public function batalSetujui($id)
    {
        $b = new pekerjaan();
        $d = new pembayaran_client();
        $data = $b->batalLunasKomisi(decrypt($id));
        $data = [
            'title' => 'Setujui',
            'listDataKomisi' => $d->getListKomisi()
        ];
        return view('kontraktor.List.listPembayaranKomisi', $data);
    }

    public function setujuiKomisi($id)
    {
        $b = new pekerjaan();
        $d = new pembayaran_client();
        $data = $b->updateLunasKomisi(decrypt($id));
        $data = [
            'title' => 'Setujui',
            'listDataKomisi' => $d->getListKomisi()
        ];
        return view('kontraktor.List.listPembayaranKomisi', $data);
    }

    public function showListKomisi()
    {
        $c = new pembayaran_client();
        $data = [
            'title' => 'List Pembayaran Komisi',
            'listDataKomisi' => $c->getListKomisi()
        ];
        return view('kontraktor.List.listPembayaranKomisi', $data);
    }

    public function tambahTagihanDenganKode($kode_pekerjaan)
    {
        $c = new pekerjaan();
        $data = [
            'title' => 'Detail Tagihan',
            'listDataPekerjaanFix' => $c->selectPekerjaan($kode_pekerjaan)
        ];
        return view('kontraktor.Creation.tagihan', $data);
    }

    public function listDeleteClient()
    {
        $b = new client();
        $data = [
            'title' => 'List Delete Client',
            'listDataDeleteClient' => $b->getHapusClient()
        ];
        return view('kontraktor.List.listDeleteClient', $data);
    }

    public function fetch(Request $request)
    {
        session()->forget('listSpWork');
        $value = $request->get('value');
        // echo $value;
        $pekerjaan = new pekerjaan();
        $data = $pekerjaan->where('kode_client', $value)
            ->get();
        $output = "<option value=''>-</option>";
        foreach ($data as $row) {
            $output .= "<option value='" . $row->kode_pekerjaan . "'>" . $row->nama_pekerjaan . "</option>";
        }
        echo $output;
    }

    public function toDetailClient($id)
    {
        // dd(decrypt($id));
        $c = new client();
        $data = [
            'title' => 'Detail Client',
            'dataClient' => $c->dataToUpdate(decrypt($id))
        ];
        return view('kontraktor.Detail.detailClient', $data);
    }

    public function updateClient(Request $req)
    {
        $update = new client();
        // $idtemp = $req->input('idClient');
        $req->validate([
            'nameClient' => 'required|string',
            'handphoneNumber' => 'required|numeric'
        ], [
            'nameClient.required' => 'Kolom nama belum di isi!',
            'nameClient.string' => 'Kolom nama hanya bisa di isi huruf!',
            'handphoneNumber.required' => 'Kolom nomor telepon belum di isi!',
            'handphoneNumber.numeric' => 'Kolom nomor telepon harus diisi angka!'
        ]);
        $update->updateClient($req);

        $data = [
            'title' => 'List Client',
            'listClients' => $update->where('kode_kontraktor', session()->get('kode'))
                ->where('status_delete_client', 0)->get()
        ];
        // dd($data);
        return view('kontraktor.List.listClient', $data);
    }

    public function restoreClient($id)
    {
        $b = new client();
        $b->restore(decrypt($id));
        $data = [
            'title' => 'Restore Client',
            'listClients' => $b->where('kode_kontraktor', session()->get('kode'))
                ->where('status_delete_client', 0)->get(),
            'del' => 'Berhasil restore data Client'
        ];
        return view('kontraktor.List.listClient', $data);
    }

    public function deleteClient($id)
    {
        $c = new client();
        $c->softDelete(decrypt($id));
        $data = [
            'title' => 'Delete Client',
            'listClients' => $c->where('kode_kontraktor', session()->get('kode'))
                ->where('status_delete_client', 0)->get(),
            'del' => 'Berhasil menghapus data Client'
        ];
        return view('kontraktor.List.listClient', $data);
    }

    public function pembayaranClient()
    {
        session()->forget('listSpWork');
        $r = new client();
        $p = new pekerjaan();
        $data = [
            'listDataClient' => $r->getNamaClient(),
            'listDataPekerjaan' => $p->getDataPekerjaan()
        ];

        return view('kontraktor.Creation.tambahPembayaranClient', $data);
    }

    public function showPembayaranForm()
    {
        $b = new client();
        $data = [
            'listNamaClient' => $b->getDataClient()
        ];
        return view('kontraktor.Creation.inputPembayaran', $data);
    }

    public function getKode(Request $request)
    {
        $value = $request->get('value');
        $b = new tagihan();
        $data = $b->getTagihan($value);
        $output = "<option value=''>-</option>";
        foreach ($data as $row) {
            $output .= "<option value='" . $row->id_tagihan . "'>" . "Tagihan ke - " . $row->keterangan . "</option>";
        }
        echo $output;
    }

    public function cekTagihan(Request $request)
    {
        $value = $request->get('value');
        $b = new tagihan();
        $index = $b->searchTagihanKe($value);
        echo $index;
    }

    public function menuTagihan()
    {
        $b = new pekerjaan();
        $data = [
            "title" => "Input Tagihan",
            "listDataPekerjaanFix" => $b->selectPekerjaanFix()
        ];
        return view('kontraktor.Creation.tagihan', $data);
    }

    public function storeTagihan(Request $req)
    {
        $req->validate([
            'keterangan' => 'required',
            'pekerjaan' => 'required',
            'waktuTagihan' => 'required',
            'jumlah' => 'required|numeric'
        ], [
            'pekerjaan.required' => 'Harus pilih pekerjaan!',
            'waktuPembayaran.required' => 'Pilih tanggal pembayaran!',
            'jumlah.required' => 'Jumlah harus diisi!',
            'jumlah.numeric' => 'Jumlah harus diisi angka!'
        ]);
        $pe = new pekerjaan();
        $data = [
            'keterangan' => $req->input('keterangan'),
            'pekerjaan_kode' => $req->input('pekerjaan'),
            'waktu' => $req->input('waktuTagihan'),
            'jumlah' => $req->input('jumlah'),
            'sisa' => $req->input('jumlah'),
            "listDataPekerjaanFix" => $pe->selectPekerjaanFix(),
            'error' => 15
        ];
        $b = new tagihan();
        $b->insertTagihan($data);
        return view('kontraktor.Creation.tagihan', $data);
    }

    public function hapusTagihan($id)
    {
        $c = new tagihan();
        $cekTagihan = $c->cekKodeTagihan(decrypt($id));
        // dd($cekTagihan);
        if ($cekTagihan == false) {
            $c->deleteTagihan(decrypt($id));
            $data = [
                'title' => 'Delete Tagihan',
                'listDataTagihan' => $c->getDataTagihan()
            ];
            return view('kontraktor.List.listTagihan', $data);
        } else {
            $data = [
                'title' => 'Delete Tagihan',
                'listDataTagihan' => $c->getDataTagihan(),
                'error' => 18
            ];
            return view('kontraktor.List.listTagihan', $data);
        }
    }

    public function showListTagihan()
    {
        $b = new tagihan();
        $data = [
            'title' => 'Data Tagihan',
            'listDataTagihan' => $b->getDataTagihan()
        ];
        return view('kontraktor.List.listTagihan', $data);
    }

    public function bayar(Request $req)
    {
        $jenis = $req->input('radio');
        $get = $req->input('pekerjaan');
        $uang = $req->input('total');
        $idtagihan = $req->input('tagihan');
        if ($jenis == 0) {
            $req->validate([
                'pekerjaan' => 'required',
                'namaClient' => 'required|string',
                'waktuPembayaran' => 'required',
                'total' => 'required|numeric'
            ], [
                'pekerjaan.required' => 'Harus pilih pekerjaan!',
                'namaClient.required' => 'Pilih nama client!',
                'namaClient.string' => 'Kolom nama hanya bisa di isi huruf!',
                'waktuPembayaran.required' => 'Pilih tanggal pembayaran!',
                'total.required' => 'Total harus diisi!',
                'total.numeric' => 'Total harus diisi angka!'
            ]);
            $client = new client();
            $data = [
                'pekerjaan_kode' => $req->input('pekerjaan'),
                'id_tagihan' => $idtagihan,
                'client_kode' => $req->input('namaClient'),
                'waktu' => $req->input('waktuPembayaran'),
                'total' => $req->input('total'),
                'listNamaClient' => $client->getDataClient(),
                'error' => 16
            ];
            $b = new pembayaran_client();
            $d = new pekerjaan();
            $jenisP = 0;
            $tempPembayaran = $b->insertPembayaran($data);
            // dd($tempPembayaran);
            $cek = $b->getSumPembayaran($get);
            $jumlah_bayar = intval($cek);
            $harga_deal = $d->getTotalHarga($get, $jenisP);
            foreach ($harga_deal as $item) {
                if ($jumlah_bayar >= $item) {
                    $d->updateLunas($get);
                }
            }
            $c = new tagihan();
            $sisa = $c->getSisaTagihan($get, $idtagihan);

            foreach ($sisa as $value) {
                $sisaBaru = $value - $uang;
                $c->updateTagihan($sisaBaru, $idtagihan);
            }
            $w = new pembayaran_client();
            $tmp = $w->find($tempPembayaran->kode_pembayaran_client);
            $data = [
                'buktiPembayaran' => $tmp
            ];

            $pdf = PDF::loadView('kontraktor.Report.report_pembayaran_client', $data)->setPaper('a5', 'landscape');
            return $pdf->stream();
        } else {
            $b = new client();
            $req->validate([
                'pekerjaan' => 'required',
                'namaClient' => 'required|string',
                'waktuPembayaran' => 'required',
                'total' => 'required|numeric'
            ], [
                'pekerjaan.required' => 'Harus pilih pekerjaan!',
                'namaClient.required' => 'Pilih nama client!',
                'namaClient.string' => 'Kolom nama hanya bisa di isi huruf!',
                'waktuPembayaran.required' => 'Pilih tanggal pembayaran!',
                'total.required' => 'Total harus diisi!',
                'total.numeric' => 'Total harus diisi angka!'
            ]);

            $data = [
                'pekerjaan_kode' => $req->input('pekerjaan'),
                'id_tagihan' => 0,
                'client_kode' => $req->input('namaClient'),
                'waktu' => $req->input('waktuPembayaran'),
                'total' => $req->input('total'),
                'listNamaClient' => $b->getDataClient(),
                'error' => 17
            ];

            $b = new pembayaran_client();
            $tempPembayaran = $b->insertPembayaran($data);
            $w = new pembayaran_client();
            $tmp = $w->find($tempPembayaran->kode_pembayaran_client);
            $data = [
                'buktiPembayaran' => $tmp
            ];

            $pdf = PDF::loadView('kontraktor.Report.report_pembayaran_client', $data)->setPaper('a5', 'landscape');
            return $pdf->stream();
        }
    }

    public function addClient()
    {
        session()->forget('listSpWork');
        return view("kontraktor.Creation.tambahClient", ['title' => 'Tambah Client']);
    }

    public function storeClient(Request $request)
    {
        session()->forget('listSpWork');
        $request->validate([
            'nameClient' => 'required|string',
            'handphoneNumber' => 'required|numeric'
        ], [
            'nameClient.required' => 'Kolom nama belum di isi!',
            'nameClient.string' => 'Kolom nama hanya bisa di isi huruf!',
            'handphoneNumber.required' => 'Kolom nomor telepon belum di isi!',
            'handphoneNumber.numeric' => 'Kolom nomor telepon harus diisi angka!'
        ]);
        $client = new client();
        $data = [
            'title' => 'Tambah Client',
            'error' => 0
        ];
        if ($client->cekClient($request->input('nameClient')) == 0) {
            $client->insertClient($request);
            return view('kontraktor.Creation.tambahClient', $data);
        } else {
            $data['error'] = 1;
        }
    }

    public function indexListClient()
    {
        session()->forget('listSpWork');
        $listClient = new client();
        $data = [
            'title' => 'List Admin',
            'listClients' => $listClient->where('kode_kontraktor', session()->get('kode'))
                ->where('status_delete_client', 0)->get()
        ];
        return view('kontraktor.List.listClient', $data);
    }

    public function listPembayaranClient()
    {
        session()->forget('listSpWork');
        $l = new pembayaran_client();
        $data = [
            'title' => 'List Pembayaran Client',
            'listDataPembayaranClient' => $l->getDataPembayaran()
        ];
        return view('kontraktor.List.listPembayaranClient', $data);
    }

    public function generateBuktiPembayaran(Request $request)
    {
        $idPc = $request->input('id_pembayaran');
        $w = new pembayaran_client();
        $tmp = $w->find($idPc);

        $data = [
            'buktiPembayaran' => $tmp
        ];

        $pdf = PDF::loadView('kontraktor.Report.report_pembayaran_client', $data)->setPaper('a5', 'landscape');
        return $pdf->stream();
    }

    // Mandor
    public function indexRegisterMandor()
    {
        session()->forget('listSpWork');
        return view('kontraktor.Creation.RegisterMandor', ['title' => 'Tambah Mandor']);
    }

    public function storeMandor(Request $request)
    {
        session()->put('tempPass', $request->pass);
        // validation form -> ada yang kosong / salah ga, kasi warning di form
        $request->validate([
            'name' => 'required|string',
            'no' => 'required|numeric',
            'username' => 'required',
            'email' => 'required',
            'salary' => 'required|numeric',
            'pass' => 'required',
            'cpass' => [new cekCpass()]
        ], [
            'name.string' => 'Kolom nama hanya bisa di isi huruf!',
            'salary.numeric' => 'Kolom gaji admin hanya bisa di isi dengan angka (0-9)!',
            'salary.required' => 'Kolom gaji admin wajib di isi!'
        ]);

        $m = new mandor();
        // validation database -> sudah kepake ato belom kolom sesuatu
        if ($m->cekMandor($request->input('username'))) {
            $m->insertMandor($request); // saving

            $data = [
                'title' => 'Tambah Mandor',
                'succ' => 'Berhasil Menambahkan Mandor',
                'error' => 0 // 0 = success
            ];
            return view('kontraktor.Creation.RegisterMandor', $data);
        } else {
            $data = [
                'title' => 'Tambah Mandor',
                'bef' => $request->input(),
                'error' => 1 // 1 = error, username sudah terpakai
            ];
            return view('kontraktor.Creation.RegisterMandor', $data);
        }
    }

    public function indexListMandor()
    {
        $m = new mandor();
        $data = [
            'title' => 'List Mandor',
            'listMandor' => $m->where('kode_kontraktor', session()->get('kode'))
                ->where('status_delete_mandor', 0)
                ->get()
        ];
        return view('kontraktor.List.listMandor', $data);
    }

    public function detailMandor($id)
    {
        $m = new mandor();
        $data = [
            'title' => 'Detail Mandor',
            'mandor' => $m->getMandor(decrypt($id))
        ];
        return view('kontraktor.Detail.detailMandor', $data);
    }

    public function updateMandor(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'name' => 'required|string',
            'no' => 'required|numeric',
            'email' => 'required',
            'salary' => 'required|numeric'
        ], [
            'name.required' => 'Kolom nama belum di isi!',
            'name.string' => 'Kolom nama hanya bisa di isi huruf!',
            'no.required' => 'Kolom nomor telepon belum di isi!',
            'no.numeric' => 'Kolom nomor hanya bisa di isi angka!',
            'email.required' => 'Kolom alamat e-mail belum di isi!',
            'salary.numeric' => 'Kolom gaji mandor hanya bisa di isi dengan angka (0-9)!',
            'salary.required' => 'Kolom gaji mandor wajib di isi!',
        ]);

        if ($validator->fails()) {
            return redirect('/kontraktor/detMandor/' . encrypt($req->id))
                ->withErrors($validator)
                ->withInput();
        }
        $m = new mandor();
        $m->updateMandor($req);

        $data = [
            'title' => 'List Mandor',
            'listMandor' => $m->where('kode_kontraktor', session()->get('kode'))
                ->where('status_delete_mandor', 0)
                ->get(),
            'upd' => 'Berhasil mengubah data mandor'
        ];
        return view('kontraktor.List.listMandor', $data);
    }

    public function updatePassMandor(Request $req)
    {
        session()->put('tempPass', $req->npass);
        $req->validate([
            'pass' => [new cekNpass(), 'required'],
            'npass' => 'required',
            'cpass' => [new cekCpass(), 'required']
        ], [
            'pass.required' => 'Kolom kata sandi belum di isi!',
            'npass.required' => 'Kolom kata sandi baru belum di isi!',
            'cpass.required' => 'Kolom konfirmasi kata sandi baru belum di isi!'
        ]);
        $m = new mandor();
        $m->updatePassMandor($req);

        $data = [
            'title' => 'Detail Mandor',
            'mandor' => $m->where('username_mandor', $req->username)->get(),
            'upd' => 'Berhasil mengubah password mandor'
        ];
        return view('kontraktor.Detail.detailMandor', $data);
    }

    public function deleteMandor($id)
    {
        $m = new mandor();
        if ($m->cekDelete(decrypt($id))) {
            $m->softDeleteMandor(decrypt($id));
            $data = [
                'title' => 'List Mandor',
                'listMandor' => $m->where('kode_kontraktor', session()->get('kode'))
                    ->where('status_delete_mandor', 0)->get(),
                'del' => 'Berhasil menghapus data mandor'
            ];
            return view('kontraktor.List.listMandor', $data);
        }

        $data = [
            'title' => 'List Mandor',
            'listMandor' => $m->where('kode_kontraktor', session()->get('kode'))
                ->where('status_delete_mandor', 0)->get(),
            'fail' => 'Data mandor masih digunakan di suatu pekerjaan'
        ];
        return view('kontraktor.List.listMandor', $data);
    }

    public function listDeletedMandor()
    {
        $m = new mandor();
        $data = [
            'title' => 'List Mandor',
            'listDelMandor' => $m->where('kode_kontraktor', session()->get('kode'))
                ->where('status_delete_mandor', 1)
                ->get()
        ];
        return view('kontraktor.Deleted.deletedMandor', $data);
    }

    public function rollbackMandor($id)
    {
        $m = new mandor();
        $m->rollback(decrypt($id));

        $data = [
            'title' => 'List Mandor',
            'listDelMandor' => $m->where('kode_kontraktor', session()->get('kode'))
                ->where('status_delete_mandor', 1)
                ->get(),
            'roll' => 'Berhasil mengembalikan Mandor!'
        ];
        return view('kontraktor.Deleted.deletedMandor', $data);
    }

    // Admin

    public function indexRegisterAdmin()
    {
        session()->forget('listSpWork');
        return view('kontraktor.Creation.RegisterAdmin', ['title' => 'Tambah Admin']);
    }

    public function storeAdmin(Request $request)
    {
        session()->put('tempPass', $request->pass);
        // validation form -> ada yang kosong / salah ga, kasi warning di form
        $request->validate([
            'name' => 'required|string',
            'no' => 'required|numeric',
            'username' => 'required',
            'email' => 'required',
            'salary' => 'required|numeric',
            'pass' => 'required',
            'cpass' => [new cekCpass()]
        ], [
            'name.string' => 'Kolom nama hanya bisa di isi huruf!',
            'salary.numeric' => 'Kolom gaji admin hanya bisa di isi dengan angka (0-9)!',
            'salary.required' => 'Kolom gaji admin wajib di isi!',
        ]);

        $a = new administrator();
        // validation database -> sudah kepake ato belom kolom sesuatu
        if ($a->cekAdmin($request->input('username'))) {
            $a->insertAdmin($request); // saving

            $data = [
                'title' => 'Tambah Admin',
                'succ' => 'Berhasil Menambahkan Admin',
                'error' => 0 // 0 = success
            ];
            return view('kontraktor.Creation.RegisterAdmin', $data);
        } else {
            $data = [
                'title' => 'Tambah Admin',
                'bef' => $request->input(),
                'error' => 1 // 1 = error, username sudah terpakai
            ];
            return view('kontraktor.Creation.RegisterAdmin', $data);
        }
    }

    public function indexListAdmin()
    {
        $a = new administrator();
        $data = [
            'title' => 'List Admin',
            'listAdmin' => $a->where('kode_kontraktor', session()->get('kode'))
                ->where('status_delete_admin', 0)
                ->get()
        ];
        return view('kontraktor.List.listAdmin', $data);
    }

    public function detailAdmin($id)
    {
        $a = new administrator();
        $data = [
            'title' => 'Detail Admin',
            'admin' => $a->getAdmin(decrypt($id))
        ];
        return view('kontraktor.Detail.detailAdmin', $data);
    }

    public function updateAdmin(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'name' => ['required', 'string'],
            'no' => 'required|numeric',
            'email' => 'required',
            'salary' => 'numeric|required'
        ], [
            'name.required' => 'Kolom nama belum di isi!',
            'name.string' => 'Kolom nama hanya bisa di isi huruf!',
            'no.required' => 'Kolom nomor telepon belum di isi!',
            'no.numeric' => 'Kolom nomor hanya bisa di isi angka!',
            'email.required' => 'Kolom alamat e-mail belum di isi!',
            'salary.numeric' => 'Kolom gaji admin hanya bisa di isi dengan angka (0-9)!',
            'salary.required' => 'Kolom gaji admin wajib di isi!'
        ]);

        if ($validator->fails()) {
            return redirect('/kontraktor/detAdmin/' . encrypt($req->id))
                ->withErrors($validator)
                ->withInput();
        }
        $a = new administrator();
        $a->updateAdmin($req);

        $data = [
            'title' => 'List Admin',
            'listAdmin' => $a->where('kode_kontraktor', session()->get('kode'))
                ->where('status_delete_admin', 0)
                ->get(),
            'upd' => 'Berhasil mengubah data admin'
        ];
        return view('kontraktor.List.listAdmin', $data);
    }

    public function updatePassAdmin(Request $req)
    {
        session()->put('tempPass', $req->npass);
        $req->validate([
            'pass' =>  [new cekNpass(), 'required'],
            'npass' => 'required',
            'cpass' => [new cekCpass(), 'required']
        ], [
            'pass.required' => 'Kolom kata sandi belum di isi!',
            'npass.required' => 'Kolom kata sandi baru belum di isi!',
            'cpass.required' => 'Kolom konfirmasi kata sandi baru di isi!'
        ]);
        $a = new administrator();
        $a->updatePassAdmin($req);

        $data = [
            'title' => 'Detail Admin',
            'admin' => $a->where('username_admin', $req->username)->get(),
            'upd' => 'Berhasil mengubah password admin'
        ];
        return view('kontraktor.Detail.detailAdmin', $data);
    }

    public function deleteAdmin($id)
    {
        $a = new administrator();
        if ($a->cekDelete(decrypt($id))) {
            $a->softDeleteAdmin(decrypt($id));

            $data = [
                'title' => 'List Admin',
                'listAdmin' => $a->where('kode_kontraktor', session()->get('kode'))
                    ->where('status_delete_admin', 0)->get(),
                'del' => 'Berhasil menghapus data admin'
            ];
            return view('kontraktor.List.listAdmin', $data);
        }

        $data = [
            'title' => 'List Admin',
            'listAdmin' => $a->where('kode_kontraktor', session()->get('kode'))
                ->where('status_delete_admin', 0)->get(),
            'fail' => 'Data admin masih digunakan di suatu pekerjaan'
        ];
        return view('kontraktor.List.listAdmin', $data);
    }

    public function listDeletedAdmin()
    {
        $a = new administrator();
        $data = [
            'title' => 'List Admin',
            'listDelAdmin' => $a->where('kode_kontraktor', session()->get('kode'))
                ->where('status_delete_admin', 1)
                ->get()
        ];
        return view('kontraktor.Deleted.deletedAdmin', $data);
    }

    public function rollbackAdmin($id)
    {
        $a = new administrator();
        $a->rollback(decrypt($id));

        $data = [
            'title' => 'List Admin',
            'listDelAdmin' => $a->where('kode_kontraktor', session()->get('kode'))
                ->where('status_delete_Admin', 1)
                ->get(),
            'roll' => 'Berhasil mengembalikan Admin!'
        ];
        return view('kontraktor.Deleted.deletedAdmin', $data);
    }




    // Pekerjaan

    public function indexAddWork()
    {
        $c = new client();
        $m = new mandor();
        $a = new administrator();

        $data = [
            'title' => 'Tambah Pekerjaan',
            'listClient' => $c->where('kode_kontraktor', session()->get('kode'))
                ->where('status_delete_client', 0)
                ->pluck('nama_client'),
            'listMandor' => $m->where('kode_kontraktor', session()->get('kode'))
                ->where('status_delete_mandor', 0)
                ->get(),
            'listAdmin' => $a->where('kode_kontraktor', session()->get('kode'))
                ->where('status_delete_admin', 0)
                ->get(),
            'listSpWork' => session()->get('listSpWork')
        ];
        return view('kontraktor.Creation.tambahPekerjaan', $data);
    }

    public function storeWork(Request $request)
    {
        $p = new pekerjaan();
        $c = new client();
        $m = new mandor();
        $a = new administrator();
        if (isset($request->addWork)) { // commit add work
            if ($request->type == "0") { // fix didepan
                $validator = Validator::make($request->all(), [
                    //'name' => ['required', 'string', new cekNamaWork()],
                    'name' => ['required', 'string'], // validation database -> sudah kepake belum namanya di pekerjaan yang aktif
                    'address' => 'required',
                    'dealPrice' => 'required|numeric'
                ], [
                    'name.required' => 'Kolom nama perkejaan belum di isi!',
                    'name.string' => 'Kolom nama perkejaan hanya bisa di isi huruf!',
                    'address.required' => 'Kolom alamat belum di isi!',
                    'dealPrice.required' => 'Kolom harga deal belum di isi!',
                    'dealPrice.numeric' => 'Kolom harga deal hanya bisa berisi angka (0-9)!'
                ]);

                if ($validator->fails()) {
                    return redirect('/kontraktor/aWork')
                        ->withErrors($validator)
                        ->withInput();
                }
            } else { // komisi
                $validator = Validator::make($request->all(), [
                    //'name' => ['required', 'string', new cekNamaWork()],
                    'name' => ['required', 'string'], // validation database -> sudah kepake belum namanya di pekerjaan yang aktif
                    'address' => 'required'
                ], [
                    'name.required' => 'Kolom nama perkejaan belum di isi!',
                    'name.string' => 'Kolom nama perkejaan hanya bisa di isi huruf!',
                    'address.required' => 'Kolom alamat belum di isi!',
                ]);

                if ($validator->fails()) {
                    return redirect('/kontraktor/aWork')
                        ->withErrors($validator)
                        ->withInput();
                }
            }
            $nc = $request->input('nc');
            $na = $request->input('na');
            $nm = $request->input('nm');

            $data = [
                'error' => 0
            ];
            if (count($c->nameToCode($nc)) == 0) {
                $data['error'] = 3; // 3 = error kolom client
            } else if (count($m->nameToCode($nm)) == 0) {
                $data['error'] = 4; // 4 = error kolom mandor
            } else if (count($a->nameToCode($na)) == 0) {
                $data['error'] = 2; // 2 = error kolom admin
            }
            if ($data['error'] == 2 || $data['error'] == 3 || $data['error'] == 4) {
                return view('kontraktor.Creation.tambahPekerjaan', $data);
            }
            if ($data['error'] == 0) {
                $p->insertWork($request, $c->nameToCode($nc), $a->nameToCode($na), $m->nameToCode($nm)); // saving
                session()->forget('listSpWork');
                session()->forget('listSpWorkAwal');
                $data = [
                    'title' => 'Tambah Pekerjaan',
                    'error' => 0, // 0 = success,
                    'listClient' => $c->where('kode_kontraktor', session()->get('kode'))
                        ->where('status_delete_client', 0)
                        ->pluck('nama_client'),
                    'listMandor' => $m->where('kode_kontraktor', session()->get('kode'))
                        ->where('status_delete_mandor', 0)
                        ->get(),
                    'listAdmin' => $a->where('kode_kontraktor', session()->get('kode'))
                        ->where('status_delete_admin', 0)
                        ->get(),
                    'listSpWork' => null
                ];
                return view('kontraktor.Creation.tambahPekerjaan', $data);
            } else {
                // nama pekerjaan kembar
                $data = [
                    'title' => 'Tambah Pekerjaan',
                    'error' => 1, // 0 = success,
                    'listClient' => $c->where('kode_kontraktor', session()->get('kode'))
                        ->where('status_delete_client', 0)
                        ->pluck('nama_client'),
                    'listMandor' => $m->where('kode_kontraktor', session()->get('kode'))
                        ->where('status_delete_mandor', 0)
                        ->get(),
                    'listAdmin' => $a->where('kode_kontraktor', session()->get('kode'))
                        ->where('status_delete_admin', 0)
                        ->get(),
                    'listSpWork' => session()->get('listSpWork'),
                    'bef' => $request->input()
                ];
                return view('kontraktor.Creation.tambahPekerjaan', $data);
            }
        } else if (isset($request->addSpWork)) { // add row table
            $newRow = session()->get('listSpWork');
            $validator = Validator::make($request->all(), [
                'ketPK' => 'required',
                'sumJasa' => 'required|numeric|bail'
            ], [
                'ketPK.required' => 'Kolom Keterangan Pekerjaan Wajib Di isi!',
                'sumJasa.required' => 'Kolom ongkos kerja wajib di isi!',
                'sumJasa.numeric' => 'Kolom ongkos kerja harus di isi dengan angka (0-9)!'
            ]);

            if ($validator->fails()) {
                return redirect('/kontraktor/aWork')
                    ->withErrors($validator)
                    ->withInput();
            }
            $newRow[] = [
                'ketPK' => $request->ketPK,
                'sumJasa' => $request->sumJasa
            ];
            session()->put('listSpWork', $newRow);
            $temp = $request->input();
            if ($request->has('dealPrice')) {
                $data = [
                    'title' => 'Tambah Pekerjaan',
                    'listClient' => $c->where('kode_kontraktor', session()->get('kode'))
                        ->where('status_delete_client', 0)
                        ->pluck('nama_client'),
                    'listMandor' => $m->where('kode_kontraktor', session()->get('kode'))
                        ->where('status_delete_mandor', 0)
                        ->get(),
                    'listAdmin' => $a->where('kode_kontraktor', session()->get('kode'))
                        ->where('status_delete_admin', 0)
                        ->get(),
                    'listSpWork' => session()->get('listSpWork'),
                    'bef' => $temp
                ];
            } else {
                $temp['dealPrice'] = 0;
                $data = [
                    'title' => 'Tambah Pekerjaan',
                    'listClient' => $c->where('kode_kontraktor', session()->get('kode'))
                        ->where('status_delete_client', 0)
                        ->pluck('nama_client'),
                    'listMandor' => $m->where('kode_kontraktor', session()->get('kode'))
                        ->where('status_delete_mandor', 0)
                        ->get(),
                    'listAdmin' => $a->where('kode_kontraktor', session()->get('kode'))
                        ->where('status_delete_admin', 0)
                        ->get(),
                    'listSpWork' => session()->get('listSpWork'),
                    'bef' => $temp
                ];
            }
            session()->put('input', $temp);
            return view('kontraktor.Creation.tambahPekerjaan', $data);
        }
    }

    public function deleteRowSpWork($id)
    {
        $newRow = session()->get('listSpWork');
        array_splice($newRow, decrypt($id) - 1, 1);
        session()->put('listSpWork', $newRow);

        $c = new client();
        $m = new mandor();
        $a = new administrator();
        $data = [
            'title' => 'Tambah Pekerjaan',
            'listClient' => $c->where('kode_kontraktor', session()->get('kode'))
                ->where('status_delete_client', 0)
                ->pluck('nama_client'),
            'listMandor' => $m->where('kode_kontraktor', session()->get('kode'))
                ->where('status_delete_mandor', 0)
                ->get(),
            'listAdmin' => $a->where('kode_kontraktor', session()->get('kode'))
                ->where('status_delete_admin', 0)
                ->get(),
            'listSpWork' => session()->get('listSpWork'),
            'bef' => session()->get('input')
        ];
        return view('kontraktor.Creation.tambahPekerjaan', $data);
    }

    public function indexListWork()
    {
        if (session()->get('listSpWorkAwal') !== null) {
            $pk = new pekerjaan_khusus();
            $pk->revert();
        }
        session()->forget('listSpWork');
        $p = new pekerjaan();
        $data = [
            'title' => 'List Pekerjaan',
            'listWork' => $p->where('kode_kontraktor', session()->get('kode'))
                ->where('status_delete_pekerjaan', 0)
                ->get()
        ];
        return view('kontraktor.List.listWork', $data);
    }

    public function detailWork($id)
    {
        $p = new pekerjaan();
        $pk = new pekerjaan_khusus();
        $c = new client();
        $m = new mandor();
        $a = new administrator();
        $b = new tagihan();
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
            'listTagihan' => $b->getTagihanAll(decrypt($id))
        ];
        session()->put('listSpWorkAwal', $pk->where('kode_pekerjaan', decrypt($id))
            ->get());
        return view('kontraktor.Detail.detailWork', $data);
    }

    public function updateWork(Request $req)
    {
        $p = new pekerjaan();
        $validator = Validator::make($req->all(), [
            'name' => 'required|string',
            'kc' => [new cbClient()],
            'km' => [new cbMandor()],
            'ka' => [new cbAdmin()],
            'address' => 'required'
        ], [
            'name.required' => 'Kolom nama perkejaan belum di isi!',
            'name.string' => 'Kolom nama hanya bisa di isi huruf!',
            'address.required' => 'Kolom alamat perkejaan belum di isi!'
        ]);

        if ($validator->fails()) {
            return redirect('/kontraktor/detWork/' . encrypt($req->id))
                ->withErrors($validator)
                ->withInput();
        }
        $p->updateWork($req);

        $data = [
            'title' => 'List Pekerjaan',
            'listWork' => $p->where('kode_kontraktor', session()->get('kode'))
                ->where('status_delete_pekerjaan', 0)
                ->get(),
            'upd' => 'Berhasil mengubah data pekerjaan'
        ];
        session()->forget('listSpWorkAwal');
        return view('kontraktor.List.listWork', $data);
    }

    public function deleteWork($id)
    {
        $p = new pekerjaan();
        $p->softDeleteWork(decrypt($id));

        $data = [
            'title' => 'List Pekerjaan',
            'listWork' => $p->where('kode_kontraktor', session()->get('kode'))
                ->where('status_delete_pekerjaan', 0)->get(),
            'del' => 'Berhasil menghapus data pekerjaan'
        ];
        return view('kontraktor.List.listWork', $data);
    }

    public function listDeletedWork()
    {
        $p = new pekerjaan();
        $data = [
            'title' => 'List Pekerjaan',
            'listDelWork' => $p->where('kode_kontraktor', session()->get('kode'))
                ->where('status_delete_pekerjaan', 1)
                ->get()
        ];
        return view('kontraktor.Deleted.deletedWork', $data);
    }

    public function rollbackWork($id)
    {
        $p = new pekerjaan();
        $p->rollback(decrypt($id));

        $data = [
            'title' => 'List Pekerjaan',
            'listDelWork' => $p->where('kode_kontraktor', session()->get('kode'))
                ->where('status_delete_pekerjaan', 1)
                ->get(),
            'roll' => 'Berhasil mengembalikan Pekerjaan!'
        ];
        return view('kontraktor.Deleted.deletedWork', $data);
    }

    // Pekerjaan Khusus rangkap Pekerjaan

    public function detailSpecialWork($id)
    {
        $pk = new pekerjaan_khusus();
        $data = [
            'title' => 'Detail Pekerjaan Khusus',
            'spWork' => $pk->getSpWork(decrypt($id)),
            'code' => '0'
        ];
        return view('kontraktor.Detail.detailPekerjaanKhusus', $data);
    }

    public function updateSpecialWork(Request $req)
    {
        if ($req->code == 0) {
            $pk = new pekerjaan_khusus();
            $p = new pekerjaan();
            $c = new client();
            $m = new mandor();
            $a = new administrator();
            $b = new tagihan();
            $req->validate([
                'work' => [new cbRequired()],
                'ketPK' => 'required',
                'sumJasa' => 'required|numeric|bail'
            ], [
                'ketPK.required' => 'Kolom Keterangan Pekerjaan Wajib Di isi!',
                'sumJasa.required' => 'Kolom ongkos kerja wajib di isi!',
                'sumJasa.numeric' => 'Kolom ongkos kerja harus di isi dengan angka (0-9)!'
            ]);
            $pk->updatePekerjaanKhusus($req);

            $kodeP = $pk->findKodePekerjaan($req->id);
            $data = [
                'title' => 'Detail Pekerjaan',
                'work' => $p->getWork($kodeP[0]),
                'listClient' => $c->where('kode_kontraktor', session()->get('kode'))
                    ->where('status_delete_client', 0)
                    ->get(),
                'listMandor' => $m->where('kode_kontraktor', session()->get('kode'))
                    ->where('status_delete_mandor', 0)
                    ->get(),
                'listAdmin' => $a->where('kode_kontraktor', session()->get('kode'))
                    ->where('status_delete_admin', 0)
                    ->get(),
                'listSpWork' => $pk->where('kode_pekerjaan', $kodeP[0])
                    ->where('status_delete_pk', 0)
                    ->get(),
                'listDelSpWork' => $pk->where('kode_pekerjaan', $kodeP[0])
                    ->where('status_delete_pk', 1)
                    ->get(),
                'listTagihan' => $b->getTagihan($kodeP[0])
            ];
            return view('kontraktor.Detail.detailWork', $data);
        } else if ($req->code == 1) { // yang pekerjaan khusus menu sendiri
            $validator = Validator::make($req->all(), [
                'work' => [new cbRequired()],
                'ketPK' => 'required',
                'sumJasa' => 'required|numeric|bail'
            ], [
                'ketPK.required' => 'Kolom Keterangan Pekerjaan Wajib Di isi!',
                'sumJasa.required' => 'Kolom ongkos kerja wajib di isi!',
                'sumJasa.numeric' => 'Kolom ongkos kerja harus di isi dengan angka (0-9)!'
            ]);

            if ($validator->fails()) {
                return redirect('/kontraktor/detSpWorkMenu/' . encrypt($req->id))
                    ->withErrors($validator)
                    ->withInput();
            }
            $p = new pekerjaan();
            $pk = new pekerjaan_khusus();
            $b = new tagihan();
            $kodeP = $pk->findKodePekerjaan($req->id);
            $pk->updatePekerjaanKhusus($req);
            $data = [
                'title' => 'Pekerjaan Khusus',
                'listWork' => $p->where('kode_kontraktor', session()->get('kode'))
                    ->where('status_delete_pekerjaan', 0)
                    ->get(),
                'listSpWork' => $pk->where('kode_pekerjaan', $kodeP)
                    ->where('status_delete_pk', 0)
                    ->get(),
                'current' => [
                    'kode_pekerjaan' => $kodeP[0]
                ],
                'listTagihan' => $b->getTagihan($kodeP[0])
            ];
            return view('kontraktor.List.listSpecialWork', $data);
        }
    }

    public function deleteSpecialWork($id)
    {
        $pk = new pekerjaan_khusus();
        $p = new pekerjaan();
        $c = new client();
        $m = new mandor();
        $a = new administrator();
        $b = new tagihan();
        $pk->softDeletePekerjaanKhusus(decrypt($id));

        $kodeP = $pk->findKodePekerjaan(decrypt($id));
        $data = [
            'title' => 'Detail Pekerjaan',
            'work' => $p->getWork($kodeP[0]),
            'listClient' => $c->where('kode_kontraktor', session()->get('kode'))
                ->where('status_delete_client', 0)
                ->get(),
            'listMandor' => $m->where('kode_kontraktor', session()->get('kode'))
                ->where('status_delete_mandor', 0)
                ->get(),
            'listAdmin' => $a->where('kode_kontraktor', session()->get('kode'))
                ->where('status_delete_admin', 0)
                ->get(),
            'listSpWork' => $pk->where('kode_pekerjaan', $kodeP[0])
                ->where('status_delete_pk', 0)
                ->get(),
            'listDelSpWork' => $pk->where('kode_pekerjaan', $kodeP[0])
                ->where('status_delete_pk', 1)
                ->get(),
            'listTagihan' => $b->getTagihan(decrypt($id))
        ];
        return view('kontraktor.Detail.detailWork', $data);
    }

    public function rollbackSpecialWork($id)
    {
        $pk = new pekerjaan_khusus();
        $p = new pekerjaan();
        $c = new client();
        $m = new mandor();
        $a = new administrator();
        $b = new tagihan();
        $pk->rollbackSpWork(decrypt($id));

        $kodeP = $pk->findKodePekerjaan(decrypt($id));
        $data = [
            'title' => 'Detail Pekerjaan',
            'work' => $p->getWork($kodeP[0]),
            'listClient' => $c->where('kode_kontraktor', session()->get('kode'))
                ->where('status_delete_client', 0)
                ->get(),
            'listMandor' => $m->where('kode_kontraktor', session()->get('kode'))
                ->where('status_delete_mandor', 0)
                ->get(),
            'listAdmin' => $a->where('kode_kontraktor', session()->get('kode'))
                ->where('status_delete_admin', 0)
                ->get(),
            'listSpWork' => $pk->where('kode_pekerjaan', $kodeP[0])
                ->where('status_delete_pk', 0)
                ->get(),
            'listDelSpWork' => $pk->where('kode_pekerjaan', $kodeP[0])
                ->where('status_delete_pk', 1)
                ->get(),
            'listTagihan' => $b->getTagihan(decrypt($id))
        ];
        return view('kontraktor.Detail.detailWork', $data);
    }

    // Pekerjaan khusus

    public function indexSpecialWork()
    {
        session()->forget('listSpWork');
        $p = new pekerjaan();
        $data = [
            'title' => 'Pekerjaan Khusus',
            'listWork' => $p->where('kode_kontraktor', session()->get('kode'))
                ->where('status_delete_pekerjaan', 0)
                ->get(),
            'listSpWork' => null
        ];
        return view('kontraktor.List.listSpecialWork', $data);
    }

    public function indexSpecialWorkParam($id)
    {
        session()->forget('listSpWork');
        $p = new pekerjaan();
        $pk = new pekerjaan_khusus();
        $data = [
            'title' => 'Pekerjaan Khusus',
            'listWork' => $p->where('kode_kontraktor', session()->get('kode'))
                ->where('status_delete_pekerjaan', 0)
                ->get(),
            'listSpWork' => $pk->where('kode_pekerjaan', decrypt($id))
                ->where('status_delete_pk', 0)
                ->get(),
            'current' => $p->find(decrypt($id))
        ];
        return view('kontraktor.List.listSpecialWork', $data);
    }

    public function searchListSpecialWork(Request $req)
    {
        $p = new pekerjaan();
        $pk = new pekerjaan_khusus();

        $validator = Validator::make($req->all(), [
            'work' => [new cbRequired]
        ]);

        if ($validator->fails()) {
            return redirect('/kontraktor/iSpWork')
                ->withErrors($validator)
                ->withInput();
        }

        $data = [
            'title' => 'List Pekerjaan Khusus',
            'listWork' => $p->where('kode_kontraktor', session()->get('kode'))
                ->where('status_delete_pekerjaan', 0)
                ->get(),
            'listSpWork' => $pk->where('kode_pekerjaan', $req->work)
                ->where('status_delete_pk', 0)
                ->get(),
            'current' => $p->find($req->work)
        ];
        return view('kontraktor.List.listSpecialWork', $data);
    }

    public function indexAddSpecialWork($kode_pekerjaan)
    {
        $p = new pekerjaan();
        $data = [
            'title' => 'Tambah Pekerjaan Khusus',
            'listWork' => $p->where('kode_kontraktor', session()->get('kode'))
                ->where('status_delete_pekerjaan', 0)
                ->get(),
            'work' => $p->where('kode_kontraktor', session()->get('kode'))
                ->where('kode_pekerjaan', $kode_pekerjaan)
                ->where('status_delete_pekerjaan', 0)
                ->get()
        ];
        return view('kontraktor.Creation.tambahPekerjaanKhusus', $data);
    }

    public function storeSpecialWork(Request $req)
    {
        $req->validate([
            'kode' => [new cbRequired()],
            'ketPK' => 'required',
            'sumJasa' => 'required|numeric|bail'
        ], [
            'ketPK.required' => 'Kolom Keterangan Pekerjaan Wajib Di isi!',
            'sumJasa.required' => 'Kolom ongkos kerja wajib di isi!',
            'sumJasa.numeric' => 'Kolom ongkos kerja harus di isi dengan angka (0-9)!'
        ]);
        $pk = new pekerjaan_khusus();
        $pk->insertPekerjaanKhusus($req);

        $p = new pekerjaan();
        $data = [
            'title' => 'Tambah Pekerjaan Khusus',
            'listWork' => $p->where('kode_kontraktor', session()->get('kode'))
                ->where('status_delete_pekerjaan', 0)
                ->get(),
            'work' => $p->where('kode_kontraktor', session()->get('kode'))
                ->where('kode_pekerjaan', $req->kode_pekerjaan)
                ->where('status_delete_pekerjaan', 0)
                ->get(),
            'error' => 0
        ];
        return view('kontraktor.Creation.tambahPekerjaanKhusus', $data);
    }

    public function listDeletedSpecialWork($id)
    {
        $pk = new pekerjaan_khusus();
        $p = new pekerjaan();
        $data = [
            'title' => 'Pekerjaan Khusus',
            'listDelSpWork' => $pk->where('kode_pekerjaan', $id)
                ->where('status_delete_pk', 1)->get(),
            'kode_pekerjaan' => $id,
            'listWork' => $p->where('kode_kontraktor', session()->get('kode'))
                ->where('status_delete_pekerjaan', 0)
                ->get()
        ];
        return view('kontraktor.Deleted.deletedSpecialWork', $data);
    }

    public function detailSpecialWorkMenu($id)
    {
        $pk = new pekerjaan_khusus();
        $data = [
            'title' => 'Detail Pekerjaan Khusus',
            'spWork' => $pk->getSpWork(decrypt($id)),
            'code' => 1
        ];
        return view('kontraktor.Detail.detailPekerjaanKhusus', $data);
    }

    public function deleteSpecialWorkMenu($id)
    {
        $p = new pekerjaan();
        $pk = new pekerjaan_khusus();
        $pk->softDeletePekerjaanKhusus(decrypt($id));

        $kodeP = $pk->findKodePekerjaan(decrypt($id));

        $data = [
            'title' => 'List Pekerjaan Khusus',
            'listWork' => $p->where('kode_kontraktor', session()->get('kode'))
                ->where('status_delete_pekerjaan', 0)
                ->get(),
            'listSpWork' => $pk->where('kode_pekerjaan', $kodeP[0])
                ->where('status_delete_pk', 0)
                ->get(),
            'current' => $p->find($kodeP[0]),
            'del' => 'Berhasil menghapus data pekerjaan khusus!'
        ];
        return view('kontraktor.List.listSpecialWork', $data);
    }

    public function rollbackSpecialWorkMenu($id)
    {
        $pk = new pekerjaan_khusus();
        $p = new pekerjaan();
        $pk->rollbackSpWork(decrypt($id));

        $kodeP = $pk->findKodePekerjaan(decrypt($id));
        $data = [
            'title' => 'Pekerjaan Khusus',
            'listDelSpWork' => $pk->where('kode_pekerjaan', $kodeP[0])
                ->where('status_delete_pk', 1)->get(),
            'id' => $kodeP[0],
            'listWork' => $p->where('kode_kontraktor', session()->get('kode'))
                ->where('status_delete_pekerjaan', 0)
                ->get(),
            'roll' => 'Berhasil Mengembalikan Data Pekerjaan Khusus!'
        ];
        return view('kontraktor.Deleted.deletedSpecialWork', $data);
    }
}
