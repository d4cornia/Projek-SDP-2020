@extends('kontraktor.navbar')

{{-- {{dd($listDataPembayaranClient)}} --}}
@section('content')
    @if (count($listDataPembayaranClient) > 0)
        <div class="table-responsive">
            <table id="tabel-client" class="table table-bordered table-striped">
              <thead>
                <tr>
                    <th>No</th>
                    <th>Pekerjaan</th>
                    <th>Client</th>
                    <th>Tanggal Pembayaran</th>
                    <th>Jumlah Pembayaran</th>
                    <th>Action</th>
                </tr>
              </thead>
              <tbody id="">
                @foreach ($listDataPembayaranClient as $item)
                        <tr>
                        <th scope="row">{{$loop->iteration}}</th>
                            <td>{{$item->nama_pekerjaan}}</td>
                            <td>{{$item->nama_client}}</td>
                            <td>{{$item->tanggal_pembayan_client}}</td>
                            <td>Rp. {{number_format($item->jumlah_pembayaran_client)}}</td>
                            <td>
                                <a href="/kontraktor/detClient/" class="btn btn-success">Detail</a>
                                {{-- <a href="/kontraktor/delClient/" class="btn btn-danger delete">Hapus</a> --}}
                            </td>
                        </tr>
                    @endforeach
              </tbody>
              <tfoot>
                <tr>
                    <th>No</th>
                    <th>Pekerjaan</th>
                    <th>Client</th>
                    <th>Tanggal Pembayaran</th>
                    <th>Jumlah Pembayaran</th>
                    <th>Action</th>
                </tr>
              </tfoot>
            </table>
            </div>
    @else
        <h1>Tidak Ada Pembayaran Client!</h1>
    @endif
    <script>
        $(document).ready(function() {
            $("#tabel-client").DataTable();
    } );
    </script>
@endsection

