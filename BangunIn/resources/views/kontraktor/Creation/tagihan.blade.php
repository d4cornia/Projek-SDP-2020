@extends('kontraktor.navbar')

@section('content')
<form method="POST" action="/kontraktor/submitTagihan" class="needs-validation" novalidate>
    @csrf
    <div class="form-group">
        <label for="exampleInputEmail1">Pekerjaan</label>
        {{-- <input type="text" class="form-control" name="handphoneNumber" value="" required> --}}
        <select name="pekerjaan" id="" class="form-control">
            @foreach ($listDataPekerjaanFix as $item)
                <option value="{{$item->kode_pekerjaan}}">{{$item->nama_pekerjaan}}</option>
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
    <input type="hidden" name="kodejenis" class="kodejenis">
    <div class="form-group">
        <label for="exampleInputEmail1">Tanggal Tagihan</label>
        <input type="date" id="birthdaytime" name="waktuTagihan" class="form-control">
        <div class="invalid-feedback">
            Kolom nomor telepon belum di isi!
        </div>
        @error('waktuTagihan')
        <div class="err">
            {{$message}}
        </div>
        @enderror
    </div>

    <div class="form-group">
        <label for="exampleInputEmail1">Jumlah Tagihan</label>
        <input type="text" class="form-control" name="jumlah" value="" required>
        <div class="invalid-feedback">
            Kolom nomor telepon belum di isi!
        </div>
        @error('jumlah')
        <div class="err">
            {{$message}}
        </div>
        @enderror
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Sisa Tagihan</label>
        <input type="text" class="form-control" name="sisa" value="" required>
        <div class="invalid-feedback">
            Kolom nomor telepon belum di isi!
        </div>
        @error('sisa')
        <div class="err">
            {{$message}}
        </div>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">Tambah</button>
</form>
<script>

</script>
@endsection
