@extends('kontraktor.navbar')

@section('content')
<form method="POST" action="/kontraktor/submitAddWork" class="needs-validation" novalidate>
    @csrf
    <div class="form-group">
        <label for="name">Nama Perkejaan</label>
        <input type="text" class="form-control" name="name" id="name" value="{{$work[0]['nama_pekerjaan']}}">
        @error('name')
            <div class="err">
                {{$message}}
            </div>
        @enderror
    </div>
    <div class="form-group">
        <label for="kc">Nama Client</label>
        <div class="my-1">
            <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name="kc" id="kc">
                <option selected>-</option>
                @foreach ($listClient as $item)
                    <option value="{{$item['kode_client']}}" @if ($item['kode_client'] == $work[0]['kode_client'])
                        selected
                    @endif>{{$item['nama_client']}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="km">Nama Mandor</label>
        <div class="my-1">
            <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name="km" id="km">
                <option selected>-</option>
                @foreach ($listMandor as $item)
                    <option value="{{$item['kode_mandor']}}" @if ($item['kode_mandor'] == $work[0]['kode_mandor'])
                    selected
                @endif>{{$item['nama_mandor'].' - '.$item['username_mandor']}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="ka">Nama Admin</label>
        <div class="my-1">
            <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name="ka" id="ka">
                <option selected>-</option>
                @foreach ($listAdmin as $item)
                    <option value="{{$item['kode_admin']}}" @if ($item['kode_admin'] == $work[0]['kode_admin'])
                    selected
                @endif>{{$item['nama_admin'].' - '.$item['username_admin']}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="address">Alamat</label>
        <input type="text" class="form-control" name="address" id="address" value="{{$work[0]['alamat_pekerjaan']}}">
        @error('address')
            <div class="err">
                {{$message}}
            </div>
        @enderror
    </div>
    <div class="form-group">
        <label for="specAgreement">Perjanjian Khusus</label>
        <textarea class="form-control" name="specAgreement" id="specAgreement" value="{{$work[0]['perjanjian_khusus']}}" rows="8"></textarea>
    </div>
    <div class="form-group">
        <label for="inlineRadio1" class="">Jenis Pekerjaan</label>
        <span class="col-6">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="type" id="inlineRadio1" value="0" @if ($work[0]['jenis_pekerjaan'] == '0')
                    checked
                @endif>
                <label class="form-check-label" for="inlineRadio1">Harga Fix Di Depan</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="type" id="inlineRadio2" value="1"@if ($work[0]['jenis_pekerjaan'] == '1')
                checked
            @endif>
                <label class="form-check-label" for="inlineRadio2">Komisi</label>
            </div>
        </span>
    </div>
    <div class="form-group">
        <label for="dealPrice">Harga Deal</label>
        <input type="number" class="form-control" name="dealPrice" id="dealPrice" value="{{$work[0]['harga_deal']}}" id="pass">
        @error('dealPrice')
            <div class="err">
                {{$message}}
            </div>
        @enderror
    </div>
    <input type="hidden" name="id" value="{{ $work[0]['kode_pekerjaan'] }}">
    <button type="submit" class="btn btn-primary">Ubah</button>
</form>
@endsection
