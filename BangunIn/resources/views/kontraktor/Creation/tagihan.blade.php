@extends('kontraktor.navbar')

@section('content')
<form method="POST" action="/kontraktor/submitTagihan" class="needs-validation" novalidate>
    @csrf

    <div class="option padd">
        <h3>List Tagihan</h3>
        <div class="option table-responsive">
            <table id="tabel-spWork" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Tagihan ke</th>
                        <th scope="col">Pekerjaan</th>
                        <th scope="col">Tanggal Tagihan</th>
                        <th scope="col">Jumlah Tagihan</th>
                        <th scope="col">Sisa Tagihan</th>
                    </tr>
                </thead>
                <tbody id="">

                </tbody>
                <tfoot>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Tagihan ke</th>
                        <th scope="col">Pekerjaan</th>
                        <th scope="col">Tanggal Tagihan</th>
                        <th scope="col">Jumlah Tagihan</th>
                        <th scope="col">Sisa Tagihan</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
<br>
    <div class="form-group">
        <label for="exampleInputEmail1">Tagihan ke :</label>
        <input type="text" class="form-control" name="keterangan" value="" required>
        <div class="invalid-feedback">
            Kolom tagihan belum diisi!
        </div>
        @error('keterangan')
        <div class="err">
            {{$message}}
        </div>
        @enderror
    </div>
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

    <button type="submit" class="btn btn-primary">Tambah</button>
</form>
<script>

</script>
@endsection
