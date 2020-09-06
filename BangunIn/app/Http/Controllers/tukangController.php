<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class tukangController extends Controller
{
    public function index()
    {
        return view('tukang.navbar')->with(['title' => 'Tukang']);
    }
}
