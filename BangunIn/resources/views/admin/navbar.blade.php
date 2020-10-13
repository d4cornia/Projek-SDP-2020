@extends('layout.layout')

@section('side-navbar')
    <img class="mx-auto" style="padding-left: 4vh" width="80%" src="/assets/logo_perusahaan/{{session()->get('lgperusahaan')}}">
    <h4 class="judul pt-3">{{session()->get('nmperusahaan')}}</h4>
    <hr>
    <div class="btn-group nav-side">
        <button type="button" class="btn btn-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Welcome,<br>{{session()->get('nama')}}
        </button>
        <div class="dropdown-menu">
            {{--Dropdown --}}
            <a class="dropdown-item" href="/logout">Log Out</a>
        </div>
    </div>
    <div class="btn-group nav-side">
        <button type="button" class="btn btn-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Toko Bangunan
        </button>
        <div class="dropdown-menu">

            <a class="dropdown-item" href="/admin/tambahToko">Tambah Toko Bangunan</a>
            <a class="dropdown-item" href="/admin/lihatToko">Lihat Toko Bangunan</a>
            <a class="dropdown-item" href="/admin/inputBahan">Input Bahan Bangunan</a>
            <a class="dropdown-item" href="/admin/vpembelianNota">Input Pembelian Bahan</a>
        </div>
    </div>

@endsection

