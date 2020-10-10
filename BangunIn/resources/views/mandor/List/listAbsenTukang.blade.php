@extends('mandor.navbar')

@section('content')
<style>
    img {
      border: 1px solid #ddd; /* Gray border */
      border-radius: 4px;  /* Rounded border */
      padding: 5px; /* Some padding */
      width: 120px; /* Set a small width */
      height: 100px;
    }

    /* Add a hover effect (blue shadow) */
    img:hover {
      box-shadow: 0 0 2px 1px rgba(0, 140, 186, 0.5);
    }
</style>
    <h1>Absen Tukang</h1>
    <br>
    <div style="width:100%">
        <form action="/mandor/filterAbsen" method="post">
            @csrf
            <label for="exampleInputEmail1" style="float:left;margin-top:1%;"><h6>Tanggal Absen</h6></label>
            <input type="date" class="form-control" name="tanggalabsen" value="" style='width:20%;float:left;margin-left:2%' required>&nbsp;
            <button type='submit' class="btn btn-primary" style="float:left;margin-left:2%">Lihat Absen</button>
        </form>
    </div><br><br>
    @isset($listFilterAbsen)
    @if (count($listFilterAbsen) > 0)
    <form action="/mandor/konfirmasiAbsen" method="post">
        @csrf
        <div class="table-responsive">
            <table id="tabel-tukang" class="table table-bordered table-striped">
              <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama Tukang</th>
                    <th scope="col">Jenis Tukang</th>
                    <th scope="col">Tanggal Absen</th>
                    <th scope="col">Aksi</th>
                    <th scope="col">Status</th>
                </tr>
              </thead>
              <tbody id="">
                @foreach ($listFilterAbsen as $item)
                    <tr>
                        <th scope="row">{{$loop->iteration}}</th>
                        <td>{{$item->nama_tukang}}</td>
                        <td>{{$item->nama_jenis}}</td>
                        <td>{{$item->tanggal_absen}}</td>
                        <td style=""><a target="_blank" href="/assets/absen_tukang/{{$item->bukti_foto_absen}}" alt="/assets/no_pic">
                            <img src="/assets/absen_tukang/{{$item->bukti_foto_absen}}"  alt="/assets/no_pic">
                          </a></td>
                        <td><input style="width: 25%; margin: auto" name="status[]" value="{{$item->kode_absen}}" class="form-control" type="checkbox" name="" id=""></td>
                    </tr>
                @endforeach
              </tbody>
              <tfoot>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama Tukang</th>
                    <th scope="col">Jenis Tukang</th>
                    <th scope="col">Tanggal Absen</th>
                    <th scope="col">Aksi</th>
                    <th scope="col">Status</th>
                </tr>
              </tfoot>
            </table>
            </div>
            <div class="button" style="float:right">
                <input type="submit" value="Konfirmasi" class="btn btn-success">
            </div>
    </form>


    @else
        <h2>Tidak ada list absen!</h2>
    @endif
    @endisset


    <script>
        $(document).ready(function() {
            $("#tabel-bon").DataTable();
    } );
    </script>
@endsection

