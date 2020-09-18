@extends('mandor.navbar')

@section('content')
    @if (count($listBon) > 0)
        <div class="table-responsive">
            <table id="tabel-bon" class="table table-bordered table-striped">
              <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal Pengajuan</th>
                    <th>Jumlah Bon</th>
                    <th>Sisa Bon</th>
                    <th>Keterangan</th>
                    <th>Action</th>
                </tr>
              </thead>
              <tbody id="">
                @foreach ($listBon as $item)
                        <tr>
                            <th scope="row">{{$loop->iteration}}</th>
                            <td>{{$item->tanggal_pengajuan}}</td>
                            <td>Rp. {{number_format($item->jumlah_bon)}}</td>
                            <td>Rp. {{number_format($item->sisa_bon)}}</td>
                            <td>{{$item->keterangan_bon}}</td>
                            <td>
                                <a href="/mandor/detBayar/{{$item->kode_bon}}" class="btn btn-info">Detail Pembayaran</a>
                            </td>
                        </tr>
                    @endforeach
              </tbody>
              <tfoot>
                <tr>
                    <th>No</th>
                    <th>Tanggal Pengajuan</th>
                    <th>Jumlah Bon</th>
                    <th>Sisa Bon</th>
                    <th>Keterangan</th>
                    <th>Action</th>
                </tr>
              </tfoot>
            </table>
            </div>
    @else
        <h1>Tidak Ada Bon!</h1>
    @endif
    <script>
        $(document).ready(function() {
            $("#tabel-bon").DataTable();
    } );
    </script>
@endsection

