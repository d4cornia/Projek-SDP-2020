@extends('mandor.navbar')

@section('content')
    <h1>List Request Dana</h1>
    <div class="option" style="float:right;">
        <a class="btn btn-primary"  href="/mandor/requestDana">Tambah Request Dana</a>
    </div>
    <br>
    @if (count($listReq) > 0)
        <div class="table-responsive">
            <table id="tabel-req" class="table table-bordered table-striped">
              <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Tanggal Permintaan Uang</th>
                    <th scope="col">Total Yang Di Request</th>
                    <th scope="col">Status</th>
                    <th scope="col">Aksi</th>
                </tr>
              </thead>
              <tbody id="">
                @foreach ($listReq as $item)
                    <tr>
                        <th scope="row">{{$loop->iteration}}</th>
                        <td>{{$item->tanggal_permintaan_uang}}</td>
                        <td>Rp {{number_format($item->real_total)}}</td>
                        <td>
                            @if ($item->konfirmasi_kontraktor_telah_transfer==1)
                                Sudah Ditransfer
                            @else
                                Belum Ditransfer
                            @endif

                        </td>
                        <td>
                            <a href="/mandor/detReq/{{$item->id_permintaan_uang}}" class="btn btn-success">Detail</a>
                        </td>
                    </tr>
                @endforeach
              </tbody>
              <tfoot>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Tanggal Permintaan Uang</th>
                    <th scope="col">Total Yang Di Request</th>
                    <th scope="col">Status</th>
                    <th scope="col">Aksi</th>
                </tr>
              </tfoot>
            </table>
            </div>
    @else
        <h1>Tidak Ada Request!</h1>
    @endif
    <script>
        $(document).ready(function() {
            $("#tabel-req").DataTable();
    } );
    </script>
@endsection
