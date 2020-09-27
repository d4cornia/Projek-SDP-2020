@extends('kontraktor.navbar')

@section('content')
    @if (count($listWork) > 0)
        <h1>Daftar Pekerjaan</h1>
        <div class="option" style="float: right; margin:5px 0px 40px 0px;">
            <a class="btn btn-primary" href="/kontraktor/aWork">Tambah Pekerjaan</a>
            <a class="btn btn-secondary" href="/kontraktor/sDelWork">Lihat Pekerjaan Yang Dihapus</a>
        </div>
        <div class="table-responsive">
            <table id="tabel-work" class="table table-bordered table-striped">
              <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama Pekerjaan</th>
                    <th scope="col">Alamat</th>
                    <th scope="col">Persetujuan Harga Awal</th>
                    <th scope="col">Status</th>
                    <th scope="col">Aksi</th>
                </tr>
              </thead>
              <tbody id="">
                @foreach ($listWork as $item)
                        <tr>
                            <th scope="row">{{$loop->iteration}}</th>
                            <td>{{$item->nama_pekerjaan}}</td>
                            <td>{{$item->alamat_pekerjaan}}</td>
                            <td>Rp. {{number_format($item->harga_deal)}}</td>
                            <td>@if ($item->status_selesai == '1')
                                Selesai
                                @else
                                Belum Selesai
                            @endif</td>
                            <td>
                                <a href="/kontraktor/detWork/{{encrypt($item->kode_pekerjaan)}}" class="btn btn-success">Detail</a>
                                <a href="/kontraktor/delWork/{{encrypt($item->kode_pekerjaan)}}" class="btn btn-danger">Hapus</a>
                            </td>
                        </tr>
                @endforeach
              </tbody>
              <tfoot>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama Pekerjaan</th>
                    <th scope="col">Alamat</th>
                    <th scope="col">Persetujuan Harga Awal</th>
                    <th scope="col">Status</th>
                    <th scope="col">Aksi</th>
                </tr>
              </tfoot>
            </table>
            </div>
    @else
        <h1>Tidak Ada Pekerjaan!</h1>
        <div class="option">
            <a class="btn btn-primary" href="/kontraktor/aWork">Tambah Pekerjaan</a>
            <a class="btn btn-secondary" href="/kontraktor/sDelWork">Lihat Pekerjaan Yang Dihapus</a>
        </div>
    @endif
    <script>
        $(document).ready(function() {
            $("#tabel-work").DataTable();
    } );
    </script>
@endsection
