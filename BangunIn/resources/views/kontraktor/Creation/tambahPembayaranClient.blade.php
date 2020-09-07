@extends('kontraktor.navbar')

@section('content')

{{-- {{dd($listDataClient)}} --}}
{{-- {{dd($listDataPekerjaan)}} --}}

<form method="POST" action="/kontraktor/submitPembayaran" class="needs-validation" novalidate>
    @csrf
    <div class="form-group">
        <label for="exampleInputEmail1">Pekerjaan</label>
        {{-- <input type="text" class="form-control" name="handphoneNumber" value="" required> --}}
        <select name="pekerjaan" id="" class="form-control">
            @foreach ($listDataPekerjaan['data'] as $item)
        <option value="{{$item->kode_pekerjaan.$item->kode_client}}">{{$listDataPekerjaan['nama'][$loop->index][0]}} - {{$item->nama_pekerjaan}}</option>
            @endforeach
        </select>
        <div class="invalid-feedback">
            Kolom nomor telepon belum di isi!
        </div>
        @error('pekerjaan')
        <div class="err">
            {{$message}}
        </div>
        @enderror
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Waktu Pembayaran</label>
        <input type="date" id="birthdaytime" name="waktuPembayaran" class="form-control">
        <div class="invalid-feedback">
            Kolom nomor telepon belum di isi!
        </div>
        @error('waktuPembayaran')
        <div class="err">
            {{$message}}
        </div>
        @enderror
    </div>

    <div class="form-group">
        <label for="exampleInputEmail1">Total</label>
        <input type="text" class="form-control" name="total" value="" required>
        <div class="invalid-feedback">
            Kolom nomor telepon belum di isi!
        </div>
        @error('total')
        <div class="err">
            {{$message}}
        </div>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">Tambah</button>
</form>
@endsection
