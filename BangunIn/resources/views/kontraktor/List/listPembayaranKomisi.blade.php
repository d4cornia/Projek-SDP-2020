@extends('kontraktor.navbar')

@section('content')
<div class="tombol" style="float:right">
    <a href="/kontraktor/show" class="btn btn-primary">Tambah Pembayaran</a>
</div>
<br><br>
    @if (count($listDataKomisi) > 0)

        <div class="table-responsive">
            <table id="tabel-komisi" class="table table-bordered table-striped">
              <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Pekerjaan</th>
                    <th>Tanggal Pembayaran</th>
                    <th>Jumlah Pembayaran</th>
                    <th>Status Lunas</th>
                    <th>Aksi</th>
                </tr>
              </thead>
              <tbody id="">
                @foreach ($listDataKomisi as $item)
                        <tr>
                            <th scope="row">{{$loop->iteration}}</th>
                            <td>{{$item->nama_pekerjaan}}</td>
                            <td>{{$item->tanggal_pembayan_client}}</td>
                            <td>{{$item->jumlah_pembayaran_client}}</td>
                            @if ($item->status_lunas < 1)
                                <td>Belum Lunas</td>
                            @else
                                <td>Lunas</td>
                            @endif
                            <td>
                                <a href="/kontraktor/setujui/{{encrypt($item->kode_pekerjaan)}}" class="btn btn-success" value="{{$item->kode_pekerjaan}}" id="btnAcc">Setujui Lunas</a>
                                <a href="/kontraktor/batal/{{encrypt($item->kode_pekerjaan)}}" class="btn btn-danger delete">Batal</a>
                            </td>
                        </tr>
                    @endforeach
              </tbody>
              <tfoot>
                <tr>
                    <th>No</th>
                    <th>Nama Pekerjaan</th>
                    <th>Tanggal Pembayaran</th>
                    <th>Jumlah Pembayaran</th>
                    <th>Status Lunas</th>
                    <th>Aksi</th>
                </tr>
              </tfoot>
            </table>
            </div>
    @else
        <h1>Tidak Ada Pembayaran Komisi!</h1>
    @endif
    <script>
        $(document).ready(function() {
            $("#tabel-komisi").DataTable();
    } );
    </script>
@endsection

