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
use App\Rules\cbRequired;

class kontraktorController extends Controller
{
    public function index()
    {

        return view('kontraktor.navbar');
    }


    //Client

    public function toDetailClient(Request $req)
    {
        $temp = $req->id;
        dd($temp);
    }

    public function pembayaranClient()
    {
        $r = new client();
        $p = new pekerjaan();
        // $data_client = $r->getNamaClient();
        $data = [
            'listDataClient' => $r->getNamaClient(),
            'listDataPekerjaan' => $p->getDataPekerjaan()
        ];

        return view('kontraktor.Creation.tambahPembayaranClient', $data);
    }

    public function bayar(Request $req)
    {
        $kode = $req->input('pekerjaan');
        $pekerjaan_kode = substr($kode, 0, 1);
        $client_kode = substr($kode, 1);
        $waktu = $req->input('waktuPembayaran');
        $jumlah = $req->input('total');
        $data = [
            'pekerjaan_kode' => $pekerjaan_kode,
            'client_kode' => $client_kode,
            'waktu' => $waktu,
            'total' => $jumlah
        ];
        $b = new pembayaran_client();
        $b->insertPembayaran($data);
    }

    public function addClient()
    {
        return view("kontraktor.Creation.tambahClient", ['title' => 'Tambah Client']);
    }

    public function storeClient(Request $request)
    {
        // $request->validate([
        //     'nameClient' => 'required',
        //     'handhoneNumber' => 'required'
        // ]);
        $client = new client();
        $data = [
            'title' => 'Tambah Client',
            'error' => 0
        ];
        if ($client->cekClient($request->input('nameClient')) == 0) {
            $client->insertClient($request);
            return view('kontraktor.Creation.tambahClient');
        } else {
            $data['error'] = 1;
        }
    }

    public function indexListClient()
    {
        $listClient = new client();
        $data = [
            'title' => 'List Admin',
            'listClients' => $listClient->where('kode_kontraktor', session()->get('kode'))->get()
        ];
        return view('kontraktor.List.listClient', $data);
    }



    // Mandor
    public function indexRegisterMandor()
    {
        return view('kontraktor.Creation.RegisterMandor', ['title' => 'Tambah Mandor']);
    }

    public function storeMandor(Request $request)
    {
        // validation form -> ada yang kosong / salah ga, kasi warning di form
        $request->validate([
            'name' => 'required|string',
            'no' => 'required|integer',
            'username' => 'required',
            'email' => 'required',
            'salary' => 'required|integer',
            'pass' => 'required'
        ], [
            'salary.integer' => 'Kolom gaji admin hanya bisa di isi dengan angka (0-9)!',
            'salary.required' => 'Kolom gaji admin wajib di isi!'
        ]);

        $m = new mandor();
        $data = [
            'title' => 'Tambah Mandor',
            'error' => 0 // 0 = success
        ];
        // validation database -> sudah kepake ato belom kolom sesuatu
        if ($m->cekMandor($request->input('username')) == 0) {
            $m->insertMandor($request); // saving
            return view('kontraktor.Creation.RegisterMandor', $data);
        } else {
            $data['error'] = 1; // 1 = error username sudah dipakai
            return view('kontraktor.Creation.RegisterMandor', $data);
        }
    }

    public function indexListMandor()
    {
        $m = new mandor();
        $data = [
            'title' => 'List Mandor',
            'listMandor' => $m->where('kode_kontraktor', session()->get('kode'))->get()
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
        $req->validate([
            'name' => 'required|string',
            'no' => 'required|integer',
            'username' => 'required',
            'email' => 'required',
            'salary' => 'required|integer',
            'pass' => 'required'
        ], [
            'name.required' => 'Kolom nama belum di isi!',
            'name.string' => 'Kolom nama hanya bisa di isi huruf!',
            'no.required' => 'Kolom nomor telepon belum di isi!',
            'no.integer' => 'Kolom nomor hanya bisa di isi angka!',
            'username.required' => 'Kolom nama pengguna belum di isi!',
            'email.required' => 'Kolom alamat e-mail belum di isi!',
            'salary.integer' => 'Kolom gaji admin hanya bisa di isi dengan angka (0-9)!',
            'salary.required' => 'Kolom gaji admin wajib di isi!',
            'pass.required' => 'Kolom kata sandi belum di isi!'
        ]);
        $m = new mandor();
        $m->updateMandor($req);

        $data = [
            'title' => 'List Mandor',
            'listMandor' => $m->where('kode_kontraktor', session()->get('kode'))->get()
        ];
        return view('kontraktor.List.listMandor', $data);
    }



    // Admin

    public function indexRegisterAdmin()
    {
        return view('kontraktor.Creation.RegisterAdmin', ['title' => 'Tambah Admin']);
    }

    public function storeAdmin(Request $request)
    {
        // validation form -> ada yang kosong / salah ga, kasi warning di form
        $request->validate([
            'name' => 'required|string',
            'no' => 'required|integer',
            'username' => 'required',
            'email' => 'required',
            'salary' => 'required|integer',
            'pass' => 'required'
        ], [
            'salary.integer' => 'Kolom gaji admin hanya bisa di isi dengan angka (0-9)!',
            'salary.required' => 'Kolom gaji admin wajib di isi!',
        ]);

        $a = new administrator();
        $data = [
            'title' => 'Tambah Admin',
            'error' => 0
        ];
        // validation database -> sudah kepake ato belom kolom sesuatu
        if ($a->cekAdmin($request->input('username')) == 0) {
            $a->insertAdmin($request); // saving
            return view('kontraktor.Creation.RegisterAdmin', $data);
        } else {
            $data['error'] = 1; // 1 = error username sudah dipakai
            return view('kontraktor.Creation.RegisterAdmin', $data);
        }
    }

    public function indexListAdmin()
    {
        $a = new administrator();
        $data = [
            'title' => 'List Admin',
            'listAdmin' => $a->where('kode_kontraktor', session()->get('kode'))->get()
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
        $req->validate([
            'name' => 'required|string',
            'no' => 'required|integer',
            'username' => 'required',
            'email' => 'required',
            'salary' => 'required|integer',
            'pass' => 'required'
        ], [
            'name.required' => 'Kolom nama belum di isi!',
            'name.string' => 'Kolom nama hanya bisa di isi huruf!',
            'no.required' => 'Kolom nomor telepon belum di isi!',
            'no.integer' => 'Kolom nomor hanya bisa di isi angka!',
            'username.required' => 'Kolom nama pengguna belum di isi!',
            'email.required' => 'Kolom alamat e-mail belum di isi!',
            'salary.integer' => 'Kolom gaji admin hanya bisa di isi dengan angka (0-9)!',
            'salary.required' => 'Kolom gaji admin wajib di isi!',
            'pass.required' => 'Kolom kata sandi belum di isi!'
        ]);
        $a = new administrator();
        $a->updateAdmin($req);

        $data = [
            'title' => 'List Admin',
            'listAdmin' => $a->where('kode_kontraktor', session()->get('kode'))->get()
        ];
        return view('kontraktor.List.listAdmin', $data);
    }




    // Pekerjaan

    public function indexAddWork()
    {
        $c = new client();
        $m = new mandor();
        $a = new administrator();
        $data = [
            'title' => 'Tambah Pekerjaan',
            'listClient' => $c->where('kode_kontraktor', session()->get('kode'))->pluck('nama_client'),
            'listMandor' => $m->where('kode_kontraktor', session()->get('kode'))->get(),
            'listAdmin' => $a->where('kode_kontraktor', session()->get('kode'))->get()
        ];
        return view('kontraktor.Creation.tambahPekerjaan', $data);
    }

    public function storeWork(Request $request)
    {
        // validation form -> ada yang kosong / salah ga, kasi warning di form
        $request->validate([
            'name' => 'required|alpha',
            'address' => 'required',
            'dealPrice' => 'required|numeric'
        ]);
        $nc = $request->input('nc');
        $na = $request->input('na');
        $nm = $request->input('nm');

        $p = new pekerjaan();
        $c = new client();
        $m = new mandor();
        $a = new administrator();
        $data = [
            'title' => 'Tambah Pekerjaan',
            'error' => 0, // 0 = success
            'listClient' => $c->where('kode_kontraktor', session()->get('kode'))->pluck('nama_client'),
            'listMandor' => $m->where('kode_kontraktor', session()->get('kode'))->get(),
            'listAdmin' => $a->where('kode_kontraktor', session()->get('kode'))->get()
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
        // validation database -> sudah kepake ato belom kolom sesuatu
        if ($p->cekWorkname($request->input('name')) == 0 && $data['error'] == 0) {
            $p->insertWork($request, $c->nameToCode($nc), $a->nameToCode($na), $m->nameToCode($nm)); // saving
            return view('kontraktor.Creation.tambahPekerjaan', $data);
        } else {
            $data['error'] = 1; // 1 = error nama pekerjaan sudah dipakai
            return view('kontraktor.Creation.tambahPekerjaan', $data);
        }
    }

    public function indexListWork()
    {
        $p = new pekerjaan();
        $data = [
            'title' => 'List Pekerjaan',
            'listWork' => $p->where('kode_kontraktor', session()->get('kode'))->get()
        ];
        return view('kontraktor.List.listWork', $data);
    }

    public function detailWork($id)
    {
        $p = new pekerjaan();
        $data = [
            'title' => 'Detail Pekerjaan',
            'work' => $p->getWork($id)
        ];
        return view('kontraktor.Detail.detailWork', $data);
    }



    // Pekerjaan khusus

    public function indexSpecialWork()
    {
        $p = new pekerjaan();
        $data = [
            'title' => 'Pekerjaan Khusus',
            'listWork' => $p->where('kode_kontraktor', session()->get('kode'))->get(),
            'listSpWork' => null
        ];
        return view('kontraktor.List.listSpecialWork', $data);
    }

    public function searchListSpecialWork(Request $req)
    {
        $p = new pekerjaan();
        $pk = new pekerjaan_khusus();
        $data = [
            'title' => 'Pekerjaan Khusus',
            'listWork' => $p->where('kode_kontraktor', session()->get('kode'))->get(),
            'listSpWork' => $pk->where('kode_pekerjaan', $req->search)->get()
        ];
        return view('kontraktor.List.listSpecialWork', $data);
    }

    public function indexAddSpecialWork()
    {
        $p = new pekerjaan();
        $data = [
            'title' => 'Tambah Pekerjaan Khusus',
            'listWork' => $p->where('kode_kontraktor', session()->get('kode'))->get()
        ];
        return view('kontraktor.Creation.tambahPekerjaanKhusus', $data);
    }

    public function storeSpecialWork(Request $req)
    {
        $req->validate([
            'work' => [new cbRequired()],
            'ketPK' => 'required',
            'sumJasa' => 'required|integer|bail'
        ], [
            'ketPK.required' => 'Kolom Keterangan Pekerjaan Wajib Di isi!',
            'sumJasa.required' => 'Kolom ongkos kerja wajib di isi!',
            'sumJasa.integer' => 'Kolom ongkos kerja harus di isi dengan angka (0-9)!'
        ]);
        $pk = new pekerjaan_khusus();
        $pk->insertPekerjaanKhusus($req);

        $p = new pekerjaan();
        $data = [
            'title' => 'Tambah Pekerjaan Khusus',
            'listWork' => $p->where('kode_kontraktor', session()->get('kode'))->get()
        ];
        return view('kontraktor.Creation.tambahPekerjaanKhusus', $data);
    }
}
