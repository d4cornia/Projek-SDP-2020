@extends('layout.layout')

@section('side-navbar')
    <h2 class="judul">Bangun.in</h2>
    <hr class="w-25 text-center">
    <div class="btn-group nav-side">
        <button type="button" class="btn btn-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Client
        </button>
        <div class="dropdown-menu">
            {{--Dropdown Client--}}
        <a class="dropdown-item" href="#">Tambah Client</a>
        </div>
    </div>

    <div class="btn-group nav-side">
        <button type="button" class="btn btn-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Pekerjaan
        </button>
        <div class="dropdown-menu">
            {{--Dropdown Pekerjaan--}}
        <a class="dropdown-item" href="#">Tambah Pekerjaan</a>
        </div>
    </div>

    <div class="btn-group nav-side">
        <button type="button" class="btn btn-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Mandor
        </button>
        <div class="dropdown-menu">
            {{--Dropdown Mandor--}}
        <a class="dropdown-item" href="/kontraktor/rMandor">Tambah Mandor</a>
        </div>
    </div>

    <div class="btn-group nav-side">
        <button type="button" class="btn btn-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Admin
        </button>
        <div class="dropdown-menu">
            {{--Dropdown Admin--}}
        <a class="dropdown-item" href="/kontraktor/rAdmin">Tambah Admin</a>
        </div>
    </div>
@endsection

