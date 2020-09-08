@extends('kontraktor.navbar')

@section('content')
    @if (count($listMandor) > 0)
        <div class="table-responsive">
            <table id="tabel-mandor" class="table table-bordered table-striped">
              <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Username</th>
                    <th scope="col">Nama Mandor</th>
                    <th scope="col">Nomor HP</th>
                    <th scope="col">Email</th>
                    <th scope="col">Aksi</th>
                </tr>
              </thead>
              <tbody id="">
                @foreach ($listMandor as $item)
                        <tr>
                            <th scope="row">{{$loop->iteration}}</th>
                            <td>{{$item->username_mandor}}</td>
                            <td>{{$item->nama_mandor}}</td>
                            <td>{{$item->no_hp_mandor}}</td>
                            <td>{{$item->email_mandor}}</td>
                            <td>
                                <a href="/kontraktor/detMandor/{{encrypt($item->kode_mandor)}}" class="btn btn-success">Detail</a>
                                <a href="/kontraktor/delMandor/{{encrypt($item->kode_mandor)}}" class="btn btn-danger">Hapus</a>
                            </td>
                        </tr>
                    @endforeach
              </tbody>
              <tfoot>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Username</th>
                    <th scope="col">Nama Mandor</th>
                    <th scope="col">Nomor HP</th>
                    <th scope="col">Email</th>
                    <th scope="col">Aksi</th>
                </tr>
              </tfoot>
            </table>
            </div>
    @else
        <h1>Tidak Ada Mandor!</h1>
    @endif
    <script>
        $(document).ready(function() {
            $("#tabel-mandor").DataTable();
    } );
    </script>
@endsection
