@extends('mandor.navbar')

@section('content')
    <h1>History Pekerjaan Selesai</h1>
    <div class="option text-right" style="margin-left:60%">
        <a class="btn btn-primary"  href="/mandor/lihatPekerjaan">Lihat Pekerjaan Aktif</a>
    </div>
    <br>
    @if (count($pekerjaan) > 0)
        <div class="table-responsive">
            <table id="tabel-jenis" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama Pekerjaan</th>
                    <th scope="col">Alamat</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody id="">
                @foreach ($pekerjaan as $item)
                    <tr>
                        <th scope="row">{{$loop->iteration}}</th>
                        <td>{{$item->nama_pekerjaan}}</td>
                        <td>{{$item->alamat_pekerjaan}}</td>
                        <td>
                            <a href="/mandor/detWork/{{encrypt($item->kode_pekerjaan)}}" class="btn btn-warning">Detail</a>

                        </td>
                    </tr>
                    @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama Pekerjaan</th>
                    <th scope="col">Alamat</th>
                    <th scope="col">Aksi</th>
                </tr>
            </tfoot>
            </table>
            </div>

    @else
        <h4>Tidak Ada Pekerjaan Selesai!</h4>
    @endif
<script>
    $(document).ready(function() {
        $("#tabel-jenis").DataTable();
} );
</script>
@endsection
