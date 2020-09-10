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
use App\Rules\cbAdmin;
use App\Rules\cbClient;
use App\Rules\cbMandor;
use App\Rules\cbRequired;

class kontraktorController extends Controller
{
    public function index()
    {

        return view('kontraktor.navbar');
    }


    //Client
    public function fetch(Request $request)
    {
        $value = $request->get('value');
        // echo $value;
        $pekerjaan = new pekerjaan();
        $data = $pekerjaan->where('kode_client',$value)
                    ->get();
        $output = "<option value=''>-</option>";
        foreach($data as $row){
            $output.= "<option value='".$row->kode_pekerjaan."'>".$row->nama_pekerjaan."</option>";
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
        return view('kontraktor.Detail.detailClient',$data);
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
            'listClients' => $update->where('kode_kontraktor', session()->get('kode'))->get()
        ];
        // dd($data);
        return view('kontraktor.List.listClient', $data);

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

    public function showPembayaranForm()
    {
        $b = new client();
        $data = [
            'listNamaClient' => $b->getDataClient()
        ];
        return view('kontraktor.Creation.inputPembayaran',$data);
    }

    public function bayar(Request $req)
    {
        $pekerjaan_kode = $req->input('pekerjaan');
        $client_kode = $req->input('namaClient');
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
            'no' => 'required|numeric',
            'username' => 'required',
            'email' => 'required',
            'salary' => 'required|numeric',
            'pass' => 'required'
        ], [
            'name.string' => 'Kolom nama hanya bisa di isi huruf!',
            'salary.numeric' => 'Kolom gaji admin hanya bisa di isi dengan angka (0-9)!',
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
        // dd($data);
        return view('kontraktor.Detail.detailMandor', $data);

    }

    public function updateMandor(Request $req)
    {
        $req->validate([
            'name' => 'required|string',
            'no' => 'required|numeric',
            'username' => 'required',
            'email' => 'required',
            'salary' => 'required|numeric',
            'pass' => 'required'
        ], [
            'name.required' => 'Kolom nama belum di isi!',
            'name.string' => 'Kolom nama hanya bisa di isi huruf!',
            'no.required' => 'Kolom nomor telepon belum di isi!',
            'no.numeric' => 'Kolom nomor hanya bisa di isi angka!',
            'username.required' => 'Kolom nama pengguna belum di isi!',
            'email.required' => 'Kolom alamat e-mail belum di isi!',
            'salary.numeric' => 'Kolom gaji admin hanya bisa di isi dengan angka (0-9)!',
            'salary.required' => 'Kolom gaji admin wajib di isi!',
            'pass.required' => 'Kolom kata sandi belum di isi!'
        ]);
        $m = new mandor();
        $m->updateMandor($req);

        $data = [
            'title' => 'List Mandor',
            'listMandor' => $m->where('kode_kontraktor', session()->get('kode'))->get(),
            'upd' => 'Berhasil mengubah data mandor'
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
            'no' => 'required|numeric',
            'username' => 'required',
            'email' => 'required',
            'salary' => 'required|numeric',
            'pass' => 'required'
        ], [
            'name.string' => 'Kolom nama hanya bisa di isi huruf!',
            'salary.numeric' => 'Kolom gaji admin hanya bisa di isi dengan angka (0-9)!',
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
            'no' => 'required|',
            'username' => 'required',
            'email' => 'required',
            'salary' => 'required|numeric',
            'pass' => 'required'
        ], [
            'name.required' => 'Kolom nama belum di isi!',
            'name.string' => 'Kolom nama hanya bisa di isi huruf!',
            'no.required' => 'Kolom nomor telepon belum di isi!',
            'no.numeric' => 'Kolom nomor hanya bisa di isi angka!',
            'username.required' => 'Kolom nama pengguna belum di isi!',
            'email.required' => 'Kolom alamat e-mail belum di isi!',
            'salary.numeric' => 'Kolom gaji admin hanya bisa di isi dengan angka (0-9)!',
            'salary.required' => 'Kolom gaji admin wajib di isi!',
            'pass.required' => 'Kolom kata sandi belum di isi!'
        ]);
        $a = new administrator();
        $a->updateAdmin($req);

        $data = [
            'title' => 'List Admin',
            'listAdmin' => $a->where('kode_kontraktor', session()->get('kode'))->get(),
            'upd' => 'Berhasil mengubah data admin'
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
            'name' => 'required|string',
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
        $c = new client();
        $m = new mandor();
        $a = new administrator();
        $data = [
            'title' => 'Detail Pekerjaan',
            'work' => $p->getWork(decrypt($id)),
            'listClient' => $c->where('kode_kontraktor', session()->get('kode'))->get(),
            'listMandor' => $m->where('kode_kontraktor', session()->get('kode'))->get(),
            'listAdmin' => $a->where('kode_kontraktor', session()->get('kode'))->get()
        ];
        return view('kontraktor.Detail.detailWork', $data);
    }

    public function updateWork(Request $req)
    {
        $req->validate([
            'name' => 'required|string',
            'kc' => [new cbClient()],
            'km' => [new cbMandor()],
            'ka' => [new cbAdmin()],
            'address' => 'required',
            'dealPrice' => 'required|numeric'
        ], [
            'name.required' => 'Kolom nama perkejaan belum di isi!',
            'name.string' => 'Kolom nama hanya bisa di isi huruf!',
            'address.required' => 'Kolom alamat perkejaan belum di isi!',
            'dealPrice.required' => 'Kolom harga deal perkejaan belum di isi!',
            'dealPrice.numeric' => 'Kolom Harga Deal harus berisi Angka (0-9)!',
        ]);
        $p = new pekerjaan();
        $p->updateWork($req);

        $data = [
            'title' => 'List Pekerjaan',
            'listWork' => $p->where('kode_kontraktor', session()->get('kode'))->get(),
            'upd' => 'Berhasil mengubah data pekerjaan'
        ];
        return view('kontraktor.List.listWork', $data);
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
            'title' => 'List Pekerjaan Khusus',
            'listWork' => $p->where('kode_kontraktor', session()->get('kode'))->get(),
            'listSpWork' => $pk->where('kode_pekerjaan', $req->work)->get()
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
            'listWork' => $p->where('kode_kontraktor', session()->get('kode'))->get(),
            'error' => 0
        ];
        return view('kontraktor.Creation.tambahPekerjaanKhusus', $data);
    }

    public function detailSpecialWork($id)
    {
        $p = new pekerjaan();
        $pk = new pekerjaan();
        $data = [
            'title' => 'Detail Pekerjaan Khusus',
            'listWork' => $p->where('kode_kontraktor', session()->get('kode'))->get(),
            'spWork' => $pk->getWork(decrypt($id)),
        ];
        return view('kontraktor.Detail.detailPekerjaanKhusus', $data);
    }

    public function updateSpecialWork(Request $req)
    {
        $req->validate([
            'work' => [new cbRequired()],
            'ketPK' => 'required',
            'sumJasa' => 'required|numeric|bail'
        ], [
            'ketPK.required' => 'Kolom Keterangan Pekerjaan Wajib Di isi!',
            'sumJasa.required' => 'Kolom ongkos kerja wajib di isi!',
            'sumJasa.numeric' => 'Kolom ongkos kerja harus di isi dengan angka (0-9)!'
        ]);
        $pk = new pekerjaan_khusus();
        // UPDATE FIELD APA AJA TANYA MONICA
        $pk->updatePekerjaanKhusus($req);

        $p = new pekerjaan();
        $data = [
            'title' => 'List Pekerjaan Khusus',
            'listWork' => $p->where('kode_kontraktor', session()->get('kode'))->get(),
            'listSpWork' => null,
            'upd' => 'Berhasil mengubah data pekerjaan khusus!'
        ];
        return view('kontraktor.List.listSpecialWork', $data);
    }
}
