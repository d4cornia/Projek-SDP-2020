<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class mandorController extends Controller
{
    public function index()
    {
        return view('mandor.navbar')->with(['title' => 'Mandor']);
    }
}
