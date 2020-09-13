@extends('layout.layout')
@section('side-navbar')
<h2 class="judul">Bangun.in</h2>
<hr class="w-25 text-center">
<div class="btn-group nav-side">
    <button type="button" class="btn btn-link dropdown-toggle text-left" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Welcome,<br>{{session()->get('nama')}}
    </button>
    <div class="dropdown-menu">
        {{--Dropdown Client--}}
        <a class="dropdown-item" href="/logout">Log Out</a>
    </div>
</div>
<div class="btn-group nav-side">
    <button type="button" class="btn btn-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Tukang
    </button>
    <div class="dropdown-menu">
        {{--Dropdown Tukang--}}
        <a class="dropdown-item" href="#"></a>
    </div>
</div>
@endsection
