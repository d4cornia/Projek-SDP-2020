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
    @if ($listNota !== null && count($listNota) > 0)
        <h1>Daftar Pekerjaan</h1>
        <hr>
        <div class="option" style="float: right; margin:5px 0px 40px 0px;">
            <a class="btn btn-primary" href="/mandor/menuNota">Input Nota Pembelian</a>
        </div>
        <div class="table-responsive">
            <table id="tabel-work" class="table table-bordered table-striped">
              <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama Pekerjaan</th>
                    <th scope="col">Bukti</th>
                    <th scope="col">Aksi</th>
                </tr>
              </thead>
              <tbody id="">
                @foreach ($listNota as $item)
                        <tr>
                            <th scope="row">{{$loop->iteration}}</th>
                            <td>{{$item->nama_pekerjaan}}</td>
                            <td>
                                <a target="_blank" href="/assets/nota_pembelian_bahan_mandor/{{$item->file_bukti}}" alt="{{$item->file_bukti}}">
                                    <img src="/assets/nota_beli/{{$item->file_bukti}}"  alt="{{$item->file_bukti}}">
                                </a>
                            </td>
                            <td>
                                <a href="/mandor/delNota/{{encrypt($item->id_bukti)}}" class="btn btn-danger">Hapus</a>
                            </td>
                        </tr>
                @endforeach
              </tbody>
              <tfoot>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama Pekerjaan</th>
                    <th scope="col">Bukti</th>
                    <th scope="col">Aksi</th>
                </tr>
              </tfoot>
            </table>
            </div>
    @else
        <h1>Tidak Ada Nota Pembelian Bahan!</h1>
        <div class="option">
            <a class="btn btn-primary" href="/mandor/menuNota">Input Nota Pembelian</a>
        </div>
    @endif
    <script>
        $(document).ready(function() {
            $("#tabel-work").DataTable();
    } );
    </script>
@endsection
