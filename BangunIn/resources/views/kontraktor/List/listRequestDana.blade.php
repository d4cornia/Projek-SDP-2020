@extends('kontraktor.navbar')

@section('content')
    <h1>List Request Dana</h1>
    <br>
    @if (count($listReq) > 0)
        <div class="table-responsive">
            <table id="tabel-req" class="table table-bordered table-striped">
              <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Mandor</th>
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
                        @foreach ($listMandor as $item2)
                            @if ($item2->kode_mandor==$item->kode_mandor)
                                <td>{{$item2->nama_mandor}}</td>
                            @endif
                        @endforeach
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
                            <a href="/kontraktor/konfirmasiRequest/{{$item->id_permintaan_uang}}" class="btn btn-success">Detail</a>
                        </td>
                    </tr>
                @endforeach
              </tbody>
              <tfoot>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Mandor</th>
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
