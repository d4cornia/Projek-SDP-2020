@extends('mandor.navbar')

@section('content')
    <h1>Tukang</h1>
    <hr>
    <div class="col-12 text-right">
        <a class="btn btn-primary"  href="/mandor/tambahTukang">Tambah Tukang</a>
        <a class="btn btn-secondary" href="/mandor/lihatTukangTerhapus">Lihat Tukang Yang Dihapus</a>
    </div>
    <br>
    @if (count($listTukang) > 0)
        <div class="table-responsive">
            <table id="tabel-tukang" class="table table-bordered table-striped">
              <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama Tukang</th>
                    <th scope="col">Jenis Tukang</th>
                    <th scope="col">Gaji</th>
                    <th scope="col">Nomor HP</th>
                    <th scope="col">Bon</th>
                    <th scope="col">Aksi</th>
                </tr>
              </thead>
              <tbody id="">
                @foreach ($listTukang as $item)
                    <tr>
                        <th scope="row">{{$loop->iteration}}</th>
                        <td>{{$item->nama_tukang}}</td>
                        @foreach ($listJenis as $item2)
                            @if ($item->kode_jenis == $item2->kode_jenis)
                                <td>{{$item2->nama_jenis}}</td>
                            @endif
                        @endforeach
                        <td>Rp. {{number_format($item->gaji_pokok_tukang)}}</td>
                        <td>{{$item->no_hp_tukang}}</td>
                        @php
                            $jumbon=0;
                        @endphp
                        @foreach ($listBon as $bon)
                            @if ($bon->kode_tukang==$item->kode_tukang)
                                @php
                                    $jumbon+=$bon->sisa_bon;
                                @endphp
                            @endif
                        @endforeach
                        <td>@php echo "Rp.". number_format($jumbon);@endphp</td>
                        <td>
                            <a href="/mandor/detTukang/{{$item->kode_tukang}}" class="btn btn-success">Detail Tukang</a>
                            <a href="/mandor/lihatBonTukang/{{$item->kode_tukang}}" class="btn btn-info">Detail Bon</a>
                            <a href="/mandor/delTukang/{{$item->kode_tukang}}" onclick="return confirm('Apakah Yakin di Hapus?')" class="btn btn-danger">Hapus</a>
                        </td>
                    </tr>
                @endforeach
              </tbody>
              <tfoot>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama Tukang</th>
                    <th scope="col">Jenis Tukang</th>
                    <th scope="col">Gaji</th>
                    <th scope="col">Nomor HP</th>
                    <th scope="col">Bon</th>
                    <th scope="col">Aksi</th>
                </tr>
              </tfoot>
            </table>
            </div>
    @else
        <h1>Tidak Ada Tukang!</h1>
    @endif
    <script>
        $(document).ready(function() {
            $("#tabel-tukang").DataTable();
    } );
    </script>
@endsection
