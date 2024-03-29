@extends('kontraktor.navbar')

@section('content')
<h1>Ubah Data Mandor</h1>
<form method="POST" action="/kontraktor/updMandor" class="needs-validation" novalidate>
    @csrf
    <div class="form-group">
        <label for="exampleInputEmail1">Nama Mandor</label>
        <input type="text" class="form-control" name="name" value="{{$mandor[0]['nama_mandor']}}">
        @error('name')
        <div class="err">
            {{$message}}
        </div>
        @enderror
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">No Telepon</label>
        <input type="text" class="form-control" name="no" value="{{$mandor[0]['no_hp_mandor']}}">
        <div class="invalid-feedback">
        </div>
        @error('no')
        <div class="err">
            {{$message}}
        </div>
        @enderror
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Nama Pengguna</label>
        <input type="text" class="form-control" name="username" value="{{$mandor[0]['username_mandor']}}" disabled>
        @error('username')
        <div class="err">
            {{$message}}
        </div>
        @enderror
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Alamat E-mail</label>
        <input type="email" class="form-control" name="email" value="{{$mandor[0]['email_mandor']}}" id="email" aria-describedby="emailHelp">
        @error('email')
        <div class="err">
            {{$message}}
        </div>
        @enderror
    </div>
    <div class="form-group">
        <label for="salary">Gaji Mandor</label>
        <input type="number" class="form-control" name="salary" value="{{$mandor[0]['gaji_mandor']}}" id="salary">
        @error('salary')
            <div class="err">
                {{$message}}
            </div>
        @enderror
    </div>
    <input type="hidden" name="id" value="{{$mandor[0]['kode_mandor']}}">
    <a href="/kontraktor/lMandor" class="btn btn-secondary">Kembali</a>
    <button type="submit" class="btn btn-primary">Ubah</button>
    <a href="/kontraktor/updPass/{{encrypt($mandor[0]['username_mandor'])}}/updPassMandor" class="btn btn-warning">Ubah Kata Sandi Mandor</a>
</form>
@endsection
