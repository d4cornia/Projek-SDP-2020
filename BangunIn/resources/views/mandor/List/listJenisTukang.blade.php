@extends('mandor.navbar')

@section('content')
    <h1>Jenis Tukang</h1>
    <div class="option" style="margin-left:60%">
        <a class="btn btn-primary"  href="/mandor/tambahJenisTukang">Tambah Jenis Tukang</a>
        <a class="btn btn-secondary" href="/mandor/lihatJenisTerhapus">Lihat Jenis Tukang Yang Dihapus</a>
    </div>
    <br>
    @if (count($listJenisTukangs) > 0)
        <div class="table-responsive">
            <table id="tabel-jenis" class="table table-bordered table-striped">
              <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Jenis</th>
                    <th>Gaji Pokok</th>
                    <th>Action</th>
                </tr>
              </thead>
              <tbody id="">
                @foreach ($listJenisTukangs as $item)
                        <tr>
                            <th scope="row">{{$loop->iteration}}</th>
                            <td>{{$item->nama_jenis}}</td>
                            <td align="right">Rp. {{number_format($item->gaji_pokok)}}</td>
                            <td>
                                <a href="/mandor/detjenis/{{$item->kode_jenis}}" class="btn btn-success">Detail</a>
                                <a href="/mandor/deljenis/{{$item->kode_jenis}}" onclick="return confirm('Apakah Yakin di Hapus?')" class="btn btn-danger">Hapus</a>
                            </td>
                        </tr>
                    @endforeach
              </tbody>
              <tfoot>
                <tr>
                    <th>No</th>
                    <th>Nama Jenis</th>
                    <th>Gaji Pokok</th>
                    <th>Action</th>
                </tr>
              </tfoot>
            </table>
            </div>

    @else
        <h4>Tidak Ada Jenis Tukang!</h4>
    @endif
    <script>
        $(document).ready(function() {
            $("#tabel-jenis").DataTable();
    } );
    </script>
@endsection

