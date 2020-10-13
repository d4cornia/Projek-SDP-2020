@extends('mandor.navbar')

@section('content')
<style>
    img {
      border: 1px solid #ddd; /* Gray border */
      border-radius: 4px;  /* Rounded border */
      padding: 5px; /* Some padding */
      width: 120px; /* Set a small width */
      height: 100px;
    }

    /* Add a hover effect (blue shadow) */
    img:hover {
      box-shadow: 0 0 2px 1px rgba(0, 140, 186, 0.5);
    }
</style>

<script>
    function disable(ctr) {
        var checkbox = document.getElementById("c" + ctr);
        if(checkbox.checked == true){
            document.getElementById("cb" + ctr).disabled = false;
            document.getElementById("k" + ctr).disabled = false;
            document.getElementById("o" + ctr).disabled = false;
        }else{
            document.getElementById("cb" + ctr).disabled = true;
            document.getElementById("k" + ctr).disabled = true;
            document.getElementById("o" + ctr).disabled = true;
        }
    }
</script>

@isset($kon)
<div class="kon"  id="kon">
    {{$kon}}
</div>
@endisset
    <h1>Absen Tukang</h1>
    <br>
    <div style="width:100%">
        <form action="/mandor/filterAbsen" method="post">
            @csrf
            <label for="exampleInputEmail1" style="float:left;margin-top:1%;"><h6>Tanggal Absen</h6></label>
            <input type="date" class="form-control" name="tanggalabsen" value="" style='width:20%;float:left;margin-left:2%' required>&nbsp;
            <button type='submit' class="btn btn-primary" style="float:left;margin-left:2%">Lihat Absen</button>
        </form>
    </div>
    <br><br>
@isset($hid)
    @if ($hid == '0')
        @isset($listFilterAbsen)
        <form action="/mandor/konfirmasiAbsen" method="post">
            @csrf
            <div class="table-responsive">
                <table id="tabel-tukang" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama Tukang</th>
                        <th scope="col">Pekerjaan</th>
                        <th scope="col">Jenis Tukang</th>
                        <th scope="col">Ongkos Lembur</th>
                        <th scope="col">Tanggal Absen</th>
                        <th scope="col">Bukti</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody id="">
                    @if (count($listFilterAbsen) > 0)
                            @foreach ($listFilterAbsen as $item)
                                <tr>
                                    <th scope="row">{{++$ctr}}</th>
                                    <td>{{$item->nama_tukang}}</td>
                                    <td>
                                        <select name="kode_pekerjaan[]" id="cb{{$ctr}}">
                                            <option value="-">-</option>
                                            @foreach ($listWork as $work)
                                                <option value="{{$work['kode_pekerjaan']}}">{{$work['nama_pekerjaan']}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>{{$item->nama_jenis}}</td>
                                    <td><input type="number" name="ongkos[]" value="" id="o{{$ctr}}"></td>
                                    <td>{{$item->tanggal_absen}}</td>
                                    <td style=""><a target="_blank" href="/assets/absen_tukang/{{$item->bukti_foto_absen}}" alt="/assets/no_pic">
                                        <img src="/assets/absen_tukang/{{$item->bukti_foto_absen}}"  alt="/assets/no_pic">
                                    </a></td>
                                    <td><input style="width: 25%; margin: auto" name="status[]" value="{{$item->kode_absen}}" class="form-control" type="checkbox" name="" id="c{{$ctr}}" checked onclick="disable({{$ctr}})"></td>
                                    <input type="hidden" name="kode_tukang[]" value="{{$item->kode_tukang}}" id="k{{$ctr}}">
                                </tr>
                            @endforeach
                    @endif
                    @if ($tukang_telat !== null)
                        @foreach ($tukang_telat as $item)  {{-- tukang yang tidak absen --}}
                        <tr>
                            <th scope="row">{{++$ctr}}</th>
                            <td>{{$item['nama_tukang']}}</td>
                            <td>
                                <select name="kode_pekerjaan[]" id="cb{{$ctr}}" disabled>
                                    <option value="-">-</option>
                                    @foreach ($listWork as $work)
                                        <option value="{{$work['kode_pekerjaan']}}">{{$work['nama_pekerjaan']}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>{{$item['jenis_tukang']}}</td>
                            <td><input type="number" name="ongkos[]" value="" id="o{{$ctr}}" disabled></td>
                            <td>-</td>
                            <td>-</td>
                            <td>
                                <input style="width: 25%; margin: auto" name="status[]" value="-1" class="form-control" type="checkbox" name="" id="c{{$ctr}}" onclick="disable({{$ctr}})">
                            </td>
                            <input type="hidden" name="kode_tukang[]" value="{{$item['kode_tukang']}}" id="k{{$ctr}}" disabled>
                        </tr>
                        @endforeach
                    @endif
                </tbody>
                <tfoot>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama Tukang</th>
                        <th scope="col">Pekerjaan</th>
                        <th scope="col">Jenis Tukang</th>
                        <th scope="col">Ongkos Lembur</th>
                        <th scope="col">Tanggal Absen</th>
                        <th scope="col">Bukti</th>
                        <th scope="col">Status</th>
                    </tr>
                </tfoot>
                </table>
                </div>
                <div class="button" style="float:right">
                    <input type="hidden" name="tgl" value="{{$tgl}}">
                    <input type="submit" value="Konfirmasi" class="btn btn-success">
                </div>
        </form>
        @endisset
    @else
    <h4>Absen yang dikonfirmasi</h4>
    <div class="table-responsive">
        <table id="tabel-tukang" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Nama Tukang</th>
                <th scope="col">Pekerjaan</th>
                <th scope="col">Jenis Tukang</th>
                <th scope="col">Tanggal Absen</th>
                <th scope="col">Bukti</th>
            </tr>
        </thead>
        <tbody id="">
            @if ($list !== null)
                @foreach ($list as $item)
                    <tr>
                        <th scope="row">{{++$ctr}}</th>
                        <td>{{$item['nama_tukang']}}</td>
                        <td>
                            <select name="kode_pekerjaan[]" id="cb{{$ctr}}" disabled>
                                <option value="{{$item['kode_pekerjaan']}}">{{$item['nama_pekerjaan']}}</option>
                            </select>
                        </td>
                        <td>{{$item['jenis_tukang']}}</td>
                        <td>{{$item['tanggal_absen']}}</td>
                        <td>@if ($item['bukti'] === null)
                            <a target="_blank" href="/assets/default_tukang.png" alt="/assets/default_tukang.png">
                                <img src="/assets/default_tukang.png" alt="/assets/default_tukang.png">
                            </a>
                            @else
                            <a target="_blank" href="/assets/absen_tukang/{{$item['bukti']}}" alt="/assets/default_tukang.png">
                                <img src="/assets/absen_tukang/{{$item['bukti']}}" alt="/assets/default_tukang.png">
                            </a>
                        @endif</td>
                        <input type="hidden" name="kode_tukang[]" value="{{$item['kode_tukang']}}" id="k{{$ctr}}" disabled>
                    </tr>
                @endforeach
            @endif
        </tbody>
        <tfoot>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Nama Tukang</th>
                <th scope="col">Pekerjaan</th>
                <th scope="col">Jenis Tukang</th>
                <th scope="col">Tanggal Absen</th>
                <th scope="col">Bukti</th>
            </tr>
        </tfoot>
        </table>
    </div>

    <br><br>
    <h4>Absen yang tidak dikonfirmasi</h4>
    <div class="table-responsive">
        <table id="tabel-tukang" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Nama Tukang</th>
                <th scope="col">Jenis Tukang</th>
                <th scope="col">Tanggal Absen</th>
                <th scope="col">Bukti</th>
            </tr>
        </thead>
        <tbody id="">
            @if ($nc !== null)
                @foreach ($nc as $item)
                    <tr>
                        <th scope="row">{{$loop->iteration}}</th>
                        <td>{{$item['nama_tukang']}}</td>
                        <td>{{$item['jenis_tukang']}}</td>
                        <td>-</td>
                        <td>-</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
        <tfoot>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Nama Tukang</th>
                <th scope="col">Jenis Tukang</th>
                <th scope="col">Tanggal Absen</th>
                <th scope="col">Bukti</th>
            </tr>
        </tfoot>
        </table>
    </div>
    @endif
@endisset

    <script>
        $(document).ready(function() {
            $("#tabel-bon").DataTable();
    } );
    </script>
@endsection

