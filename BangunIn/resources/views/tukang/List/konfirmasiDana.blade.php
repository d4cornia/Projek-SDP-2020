@extends('tukang.navbar')

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
    <h1>Konfirmasi Penerimaan Dana</h1>
    <hr>
        <div class="table-responsive">
            <table id="tabel-history" class="table table-bordered table-striped">
              <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama Pekerjaan</th>
                    <th scope="col">Mandor</th>
                    <th scope="col">Gaji</th>
                </tr>
              </thead>
              <tbody id="">
                @isset($listDataKonfirmasi)
                    @foreach ($listDataKonfirmasi as $item)
                        <tr>
                            <th scope="row">{{$loop->iteration}}</th>
                            <td>{{$item->nama_pekerjaan}}</td>
                            <td>{{$item->nama_mandor}}</td>
                            <td>Rp. {{number_format($item->real_total)}}</td>
                        </tr>
                    @endforeach
                @endisset
              </tbody>
              <tfoot>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama Pekerjaan</th>
                    <th scope="col">Mandor</th>
                    <th scope="col">Gaji</th>
                </tr>
              </tfoot>
            </table>
        </div>
    <script>
        $(document).ready(function() {
            $("#tabel-history").DataTable();
    } );
    </script>
@endsection
