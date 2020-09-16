@extends('kontraktor.navbar')

@section('content')
<h1>Ubah Pekerjaan Khusus</h1>
<form method="POST" action="/kontraktor/updSpWork" novalidate>
    @csrf
    <div class="form-group">
        <label for="ketPK">Keterangan Perkejaan Khusus</label>
        <textarea class="form-control" name="ketPK" id="ketPK" rows="10">{{$spWork[0]['keterangan_pk']}}</textarea>
        @error('ketPK')
            <div class="err">
                {{$message}}
            </div>
        @enderror
    </div>
    <div class="form-group">
        <label for="sumJasa">Ongkos Kerja</label>
        <input type="number" class="form-control" name="sumJasa" id="sumJasa" value="{{$spWork[0]['total_jasa']}}">
        @error('sumJasa')
            <div class="err">
                {{$message}}
            </div>
        @enderror
    </div>
    <input type="hidden" name="id" value="{{$spWork[0]['kode_pk']}}">
    <input type="hidden" name="code" value="{{$code}}">
    <button type="submit" class="btn btn-primary">Ubah</button>
</form>
@endsection
