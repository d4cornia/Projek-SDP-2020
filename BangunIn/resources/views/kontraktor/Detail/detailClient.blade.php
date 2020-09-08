@extends('kontraktor.navbar')

@section('content')

<h2>Detail Client</h2>
<form method="POST" action="/kontraktor/update" class="needs-validation" novalidate>
    @csrf
    <div class="form-group">
        <input type="hidden" name="idClient" value="{{$dataClient[0]['kode_client']}}">
        <label for="exampleInputEmail1">Nama Client</label>
        <input type="text" class="form-control" name="nameClient" value="{{$dataClient[0]['nama_client']}}">
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
        <label for="exampleInputEmail1">No Telepon</label>
        <input type="text" class="form-control" name="handphoneNumber" value="{{$dataClient[0]['no_hp_client']}}">
        <div class="invalid-feedback">
            Kolom nomor telepon belum di isi!
        </div>
        @error('handphoneNumber')
        <div class="err">
            {{$message}}
        </div>
        @enderror
    </div>

    <button type="submit" class="btn btn-success">Update</button>
</form>
@endsection
