<?php

namespace App\Http\Controllers;

use App\administrator;
use Illuminate\Http\Request;
use App\mandor;

class registerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Register.index', ['title' => 'Register']);
    }

    public function indexRegisterMandor()
    {
        return view('Register.Mandor.index', ['title' => 'Register Mandor']);
    }

    public function indexRegisterAdmin()
    {
        return view('Register.Admin.index', ['title' => 'Register Admin']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
