@extends('kontraktor.navbar')

{{-- {{dd($listDataPembayaranClient)}} --}}
@section('content')
    @if (count($listDataPembayaranClient) > 0)
        <h1>Daftar Pembayaran Client</h1>
        <hr>
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
                                <form action="/kontraktor/generateBukti" method="POST">
                                    @csrf
                                    <input type="hidden" name="id_pembayaran" value="{{$item->kode_pembayaran_client}}">
                                    <input type="submit" value="Generate Bukti" class="btn btn-secondary">
                                </form>
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
        <hr>
    @endif
    <script>
        $(document).ready(function() {
            $("#tabel-client").DataTable();
    } );
    </script>
@endsection

