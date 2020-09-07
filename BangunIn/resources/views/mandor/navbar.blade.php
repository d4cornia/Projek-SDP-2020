@extends('layout.layout')
@section('side-navbar')
<h2 class="judul">Bangun.in</h2>
<hr class="w-25 text-center">
<div class="btn-group nav-side">
    <button type="button" class="btn btn-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Jenis Tukang
    </button>
    <div class="dropdown-menu">
        <a class="dropdown-item" href="/mandor/lihatJenisTukang">Lihat Jenis Tukang</a>
        <a class="dropdown-item" href="/mandor/tambahJenisTukang">Tambah Jenis Tukang</a>
    </div>
</div>
<div class="btn-group nav-side">
    <button type="button" class="btn btn-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Tukang
    </button>
    <div class="dropdown-menu">
        <a class="dropdown-item" href="/mandor/lihatTukang">Lihat Tukang</a>
        <a class="dropdown-item" href="/mandor/tambahTukang">Tambah Tukang</a>
        <a class="dropdown-item" href="/mandor/tambahBon">Tambah Bon</a>
    </div>
</div>
@endsection
