@extends('kontraktor.navbar')

@section('content')
    @if (count($listWork) > 0)
        <div class="table-responsive">
            <table id="tabel-work" class="table table-bordered table-striped">
              <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama Pekerjaan</th>
                    <th scope="col">Alamat</th>
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
                            <td>{{$item->status_selesai}}</td>
                            <td>
                                <a href="/kontraktor/detWork/{{$item->kode_pekerjaan}}" class="btn btn-success">Detail</a>
                                <a href="/kontraktor/delWork/{{$item->kode_pekerjaan}}" class="btn btn-danger">Hapus</a>
                            </td>
                        </tr>
                @endforeach
              </tbody>
              <tfoot>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama Pekerjaan</th>
                    <th scope="col">Alamat</th>
                    <th scope="col">Status</th>
                    <th scope="col">Aksi</th>
                </tr>
              </tfoot>
            </table>
            </div>
    @else
        <h1>Tidak Ada Pekerjaan!</h1>
    @endif
    <script>
        $(document).ready(function() {
            $("#tabel-work").DataTable();
    } );
    </script>
@endsection
