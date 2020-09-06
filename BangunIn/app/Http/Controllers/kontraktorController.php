<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\mandor;
use App\administrator;

class kontraktorController extends Controller
{
    public function index()
    {
        return view('kontraktor.navbar');
    }

    public function indexRegisterMandor()
    {
        return view('kontraktor.RegisterMandor', ['title' => 'Register Mandor']);
    }

    public function indexRegisterAdmin()
    {
        return view('kontraktor.RegisterAdmin', ['title' => 'Register Admin']);
    }

    public function storeMandor(Request $request)
    {
        $m = new mandor();
        // validation form -> ada yang kosong / salah ga, kasi warning di form
        // validation database -> sudah kepake ato belom kolom sesuatu

        $m->nama_mandor = $request->input('name');
        $m->no_hp_mandor = $request->input('no');
        $m->username_mandor = $request->input('username');
        $m->email_mandor = $request->input('email');
        $m->password_mandor = $request->input('pass');
        $m->save();
    }

    public function storeAdmin(Request $request)
    {
        $a = new administrator();
        // validation form -> ada yang kosong / salah ga, kasi warning di form
        // validation database -> sudah kepake ato belom kolom sesuatu

        $a->nama_admin = $request->input('name');
        $a->no_hp_admin = $request->input('no');
        $a->username_admin = $request->input('username');
        $a->email_admin = $request->input('email');
        $a->password_admin = $request->input('pass');
        $a->save();
    }

}
