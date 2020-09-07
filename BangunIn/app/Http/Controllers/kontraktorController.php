<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\mandor;
use App\administrator;
use App\client;
use App\kontraktor;
use App\pekerjaan;
use App\pekerjaan_khusus;

class kontraktorController extends Controller
{
    public function index()
    {

        return view('kontraktor.navbar');
    }


    //Client
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

    public function indexListMandor()
    {
        $m = new mandor();
        $data = [
            'title' => 'List Mandor',
            'listMandor' => $m->where('kode_kontraktor', session()->get('kode'))->get()
        ];
        return view('kontraktor.List.listMandor', $data);
    }

    public function storeMandor(Request $request)
    {
        // validation form -> ada yang kosong / salah ga, kasi warning di form
        $request->validate([
            'name' => 'required|alpha',
            'no' => 'required|numeric',
            'username' => 'required',
            'email' => 'required',
            'pass' => 'required'
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



    // Admin
    public function indexRegisterAdmin()
    {
        return view('kontraktor.Creation.RegisterAdmin', ['title' => 'Tambah Admin']);
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

    public function storeAdmin(Request $request)
    {
        // validation form -> ada yang kosong / salah ga, kasi warning di form
        $request->validate([
            'name' => 'required|alpha',
            'no' => 'required|numeric',
            'username' => 'required',
            'email' => 'required',
            'pass' => 'required'
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



    // pekerjaan
    public function indexListWork()
    {
        $p = new pekerjaan();
        $data = [
            'title' => 'Detail Pekerjaan',
            'listWork' => $p->where('kode_kontraktor', session()->get('kode'))->get()
        ];
        return view('kontraktor.List.listWork', $data);
    }

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

    public function indexDetailWork($id)
    {
        $p = new pekerjaan();
        $data = [
            'title' => 'Detail Pekerjaan',
            'work' => $p->getWork($id)
        ];
        return view('kontraktor.Detail.detailWork', $data);
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
            'title' => 'Register Mandor',
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



    // pekerjaan khusus
    public function indexSpecialWork()
    {
        $data = [
            'title' => 'Pekerjaan Khusus',
            'listSpWork' => null
        ];
        return view('kontraktor.List.listSpecialWork', $data);
    }

    public function searchListSpecialWork(Request $req)
    {
        $req->validate(
            [
                'search' => ['reqiured']
            ],
            [
                'search.required' => 'Kolom search harus di isi'
            ]
        );

        $pk = new pekerjaan_khusus();
        $data = [
            'title' => 'Pekerjaan Khusus',
            'listSpWork' => $pk->where('kode_pekerjaan', $req->search)->get()
        ];
        return view('kontraktor.List.listSpecialWork', $data);
    }


    public function indexAddSpecialWork()
    {
        $data = [
            'title' => 'Tambah Pekerjaan'
        ];
        return view('kontraktor.Creation.tambahPekerjaanKhusus', $data);
    }
}
