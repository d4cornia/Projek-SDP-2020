@extends('tukang.navbar')

@section('content')
    <h1>Konfirmasi Dana Tukang</h1>
    <hr>
        <form action="/tukang/confirmDana" method="post">
            @csrf
            <div class="table-responsive">
                <table id="tabel-history" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th scope="col">Pekerjaan</th>
                        <th scope="col">Jumlah</th>
                        <th scope="col">Nominal</th>
                    </tr>
                </thead>
                <tbody id="">
                    @isset($totalAbsen)
                        <tr>
                            <td>Absen</td>
                            <td>{{$countAbsen}}</td>
                            <td style="color: green;">+{{$totalAbsen}}</td>
                        </tr>
                        <tr>
                            @isset($pekerjaanKhusus)

                            @endisset
                            <td>Pekerjaan Khusus</td>
                            <td>{{$pekerjaanKhusus}}</td>
                            <td style="color: green;">+{{$totalPekerjaanKhusus}}</td>
                        </tr>
                        <tr>
                            @isset($ongkos_lembur)
                                <td>Ongkos Lembur</td>
                                <td>{{$pekerjaanKhusus}}</td>
                                <td style="color: green;">+{{$ongkos_lembur}}</td>
                            @endisset

                        </tr>
                        <tr>
                            @isset($totalBonTukang)
                                <td>Bon Tukang</td>
                                <td>{{$jumlahBon}}</td>
                                <td style="color: red;">-{{$totalBonTukang}}</td>
                            @endisset
                        </tr>
                    @endisset
                </tbody>
                </table>
            </div>
        <h2 style="float:right">Total Gaji : Rp. {{number_format($totalGajiDapat)}}</h2>
        </form>
    {{-- <script>
        $(document).ready(function() {
            $("#tabel-history").DataTable();
    } );
    </script> --}}
@endsection
