@extends('kontraktor.navbar')

@section('content')

{{-- {{dd($listDataClient)}} --}}
{{-- {{dd($listDataPekerjaan)}} --}}
<form method="POST" action="" class="needs-validation" novalidate>
    @csrf
    <div class="form-group">
        <label for="exampleInputEmail1">Nama Client</label>
        {{-- <input type="text" class="form-control" name="nameClient" value="" required> --}}
        <select name="" id="" class="form-control">
            @foreach ($listDataClient as $item)
        <option value="{{$item->kode_client}}"> {{$item->kode_client}} - {{$item->nama_client}}</option>
            @endforeach
        </select>
        <div class="invalid-feedback">
            Kolom nama belum di isi!
        </div>
        @error('nameClient')
        <div class="err">
            {{$message}}
        </div>
        @enderror
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Pekerjaan</label>
        {{-- <input type="text" class="form-control" name="handphoneNumber" value="" required> --}}
        <select name="" id="" class="form-control">
            @foreach ($listDataPekerjaan as $item)
        <option value="{{$item->kode_pekerjaan}}">{{$item->kode_pekerjaan}} - {{$item->nama_pekerjaan}}</option>
            @endforeach
        </select>
        <div class="invalid-feedback">
            Kolom nomor telepon belum di isi!
        </div>
        @error('handphoneNumber')
        <div class="err">
            {{$message}}
        </div>
        @enderror
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Waktu Pembayaran</label>
        <input type="date" id="birthdaytime" name="birthdaytime" class="form-control">
        <div class="invalid-feedback">
            Kolom nomor telepon belum di isi!
        </div>
        @error('handphoneNumber')
        <div class="err">
            {{$message}}
        </div>
        @enderror
    </div>

    <div class="form-group">
        <label for="exampleInputEmail1">Total</label>
        <input type="text" class="form-control" name="handphoneNumber" value="" required>
        <div class="invalid-feedback">
            Kolom nomor telepon belum di isi!
        </div>
        @error('handphoneNumber')
        <div class="err">
            {{$message}}
        </div>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">Tambah</button>
</form>
@endsection
