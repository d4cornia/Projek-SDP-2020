@extends('layout.layout')
@section('side-navbar')
<h2 class="judul">Bangun.in</h2>
<hr class="w-25 text-center">

<div class="btn-group nav-side">
    <button type="button" class="btn btn-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Tukang
    </button>
    <div class="dropdown-menu">
        {{--Dropdown Admin--}}
    <a class="dropdown-item" href="#">Absen</a>
    <a class="dropdown-item" href="#">Konfirmasi Gaji</a>
    </div>
</div>
@endsection

