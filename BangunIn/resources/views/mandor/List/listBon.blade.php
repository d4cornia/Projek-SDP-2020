@extends('mandor.navbar')

@section('content')
    @if (count($listBon) > 0)
        <div class="table-responsive">
            <table id="tabel-bon" class="table table-bordered table-striped">
              <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Tukang</th>
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
                            @foreach ($listTukang as $item2)
                                @foreach ($listJenis as $item3)
                                    @if ($item->kode_tukang==$item2->kode_tukang)
                                        @if ($item2->kode_jenis==$item3->kode_jenis)
                                        <td>{{$item2->nama_tukang}} - {{$item3->nama_jenis}}</td>
                                        @endif
                                    @endif
                                @endforeach
                            @endforeach
                            <td>{{$item->tanggal_pengajuan}}</td>
                            <td>{{$item->jumlah_bon}}</td>
                            <td>{{$item->sisa_bon}}</td>
                            <td>{{$item->keterangan_bon}}</td>
                            <td>
                                <a href="/mandor/delBon/{{$item->kode_bon}}" onclick="return confirm('Apakah Yakin di Hapus?')" class="btn btn-danger">Hapus</a>
                            </td>
                        </tr>
                    @endforeach
              </tbody>
              <tfoot>
                <tr>
                    <<th>No</th>
                    <th>Nama Tukang</th>
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

