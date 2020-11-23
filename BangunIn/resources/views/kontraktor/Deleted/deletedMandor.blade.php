@extends('kontraktor.navbar')

@section('content')
    @if (count($listDelMandor) > 0)
        <h1>Daftar Mandor</h1>
        <hr>
        <div class="table-responsive">
            <table id="tabel-mandor" class="table table-bordered table-striped">
              <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Username</th>
                    <th scope="col">Nama Mandor</th>
                    <th scope="col">Nomor HP</th>
                    <th scope="col">Email</th>
                    <th scope="col">Gaji Mandor</th>
                    <th scope="col">Aksi</th>
                </tr>
              </thead>
              <tbody id="">
                @foreach ($listDelMandor as $item)
                        <tr>
                            <th scope="row">{{$loop->iteration}}</th>
                            <td>{{$item->username_mandor}}</td>
                            <td>{{$item->nama_mandor}}</td>
                            <td>{{$item->no_hp_mandor}}</td>
                            <td>{{$item->email_mandor}}</td>
                            <td>Rp. {{number_format($item->gaji_mandor)}}</td>
                            <td>
                                <a href="/kontraktor/rollbackMandor/{{encrypt($item->kode_mandor)}}" class="btn btn-info">Pulihkan</a>
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
                    <th scope="col">Gaji Mandor</th>
                    <th scope="col">Aksi</th>
                </tr>
              </tfoot>
            </table>
            </div>
            <div class="option">
                <a class="btn btn-secondary" href="/kontraktor/lMandor">Kembali</a>
            </div>
    @else
        <h1>Tidak Ada Mandor Yang Dihapus!</h1>
        <div class="option">
            <a class="btn btn-secondary" href="/kontraktor/lMandor">Kembali</a>
        </div>
    @endif
    <script>
        $(document).ready(function() {
            $("#tabel-mandor").DataTable();
    } );
    </script>
@endsection
