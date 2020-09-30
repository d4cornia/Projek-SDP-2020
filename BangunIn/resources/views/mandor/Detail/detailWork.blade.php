@extends('mandor.navbar')

@section('content')
<h1 id="judul">Ubah Data Pekerjaan</h1>
<form method="POST" action="/kontraktor/updWork" class="option needs-validation" novalidate>
    @csrf
    <div class="option padd">
        <h3>Pekerjaan Khusus</h3>
        <div class="option table-responsive">
            <table id="tabel-spWork" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Keterangan Pekerjaan Khusus</th>
                        <th scope="col">Total Bahan</th>
                        <th scope="col">Total Jasa</th>
                        <th scope="col">Total Keseluruhan</th>
                    </tr>
                </thead>
                <tbody id="">
                    @isset($listSpWork)
                        @foreach ($listSpWork as $item)
                                <tr style="color: #6c757d; background-color: #fff; border-color: #fff;">
                                    <th scope="row">{{$loop->iteration}}</th>
                                    <td>{{$item->keterangan_pk}}</td>
                                    <td>{{$item->total_bahan}}</td>
                                    <td>{{$item->total_jasa}}</td>
                                    <td>{{$item->total_keseluruhan}}</td>
                                </tr>
                        @endforeach
                    @endisset
                    @isset($listSpWork)
                        @foreach ($listDelSpWork as $item)
                                <tr style="color: #fff; background-color: #6c757d; border-color: #6c757d;">
                                    <th scope="row">{{$loop->iteration}}</th>
                                    <td>{{$item->keterangan_pk}}</td>
                                    <td>{{$item->total_bahan}}</td>
                                    <td>{{$item->total_jasa}}</td>
                                    <td>{{$item->total_keseluruhan}}</td>
                                    <td>
                                        <a href="/kontraktor/rollbackSpWork/{{encrypt($item->kode_pk)}}" class="btn btn-info">Kembalikan</a>
                                    </td>
                                </tr>
                        @endforeach
                    @endisset
                </tbody>
                <tfoot>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Keterangan Pekerjaan Khusus</th>
                        <th scope="col">Total Bahan</th>
                        <th scope="col">Total Jasa</th>
                        <th scope="col">Total Keseluruhan</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <hr class="option">

    @if(session()->get('status')=="mandor"&&$status==1)
        <div class="col-12">
            <label class="mb-2">Bukti Project Selesai</label>
            <div id="carouselExampleFade" class="carousel slide carousel-fade" data-ride="carousel" style="width: ">
                <div class="carousel-inner">
                    @php $i=0; @endphp
                    @foreach ($listFoto as $item)
                        @if($i==0)
                            <div class="carousel-item active">
                                <img src="/assets/bukti_pekerjaan/{{$item->nama_foto}}" class="d-block w-100" alt="...">
                            </div>
                        @else
                            <div class="carousel-item">
                                <img src="/assets/bukti_pekerjaan/{{$item->nama_foto}}" class="d-block w-100" alt="...">
                            </div>

                        @endif
                        @php $i++; @endphp
                    @endforeach
                </div>
                <a class="carousel-control-prev" href="#carouselExampleFade" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only" style="color: black">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleFade" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
    @endif

    <div class="form-group">
        <label for="name">Nama Perkejaan</label>
        <input type="text" class="form-control" name="name" id="name" value="{{$work[0]['nama_pekerjaan']}}">
        @error('name')
            <div class="err">
                {{$message}}
            </div>
        @enderror
    </div>
    <div class="form-group">
        <label for="kc">Nama Client</label>
        <div class="my-1">
            <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name="kc" id="kc">
                <option selected>-</option>
                @foreach ($listClient as $item)
                    <option value="{{$item['kode_client']}}" @if ($item['kode_client'] == $work[0]['kode_client'])
                        selected
                    @endif>{{$item['nama_client']}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="km">Nama Mandor</label>
        <div class="my-1">
            <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name="km" id="km">
                <option selected>-</option>
                @foreach ($listMandor as $item)
                    <option value="{{$item['kode_mandor']}}" @if ($item['kode_mandor'] == $work[0]['kode_mandor'])
                    selected
                @endif>{{$item['nama_mandor'].' - '.$item['username_mandor']}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="ka">Nama Admin</label>
        <div class="my-1">
            <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name="ka" id="ka">
                <option selected>-</option>
                @foreach ($listAdmin as $item)
                    <option value="{{$item['kode_admin']}}" @if ($item['kode_admin'] == $work[0]['kode_admin'])
                    selected
                @endif>{{$item['nama_admin'].' - '.$item['username_admin']}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="address">Alamat</label>
        <input type="text" class="form-control" name="address" id="address" value="{{$work[0]['alamat_pekerjaan']}}">
        @error('address')
            <div class="err">
                {{$message}}
            </div>
        @enderror
    </div>
    <div class="form-group">
        <label for="specAgreement">Perjanjian Khusus</label>
        <textarea class="form-control" name="specAgreement" id="specAgreement" rows="8" disabled>{{$work[0]['perjanjian_khusus']}}</textarea>
    </div>
    <div class="form-group">
        <label for="inlineRadio1" class="">Jenis Pekerjaan</label>
        <span class="col-6">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="type" id="inlineRadio1" value="0" @if ($work[0]['jenis_pekerjaan'] == '0')
                    checked
                @endif disabled>
                <label class="form-check-label" for="inlineRadio1">Harga Fix Di Depan</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="type" id="inlineRadio2" value="1"@if ($work[0]['jenis_pekerjaan'] == '1')
                    checked
                @endif disabled>
                <label class="form-check-label" for="inlineRadio2">Komisi</label>
            </div>
        </span>
    </div>
    <div class="form-group">
        <label for="dealPrice">Harga Deal</label>
        <input type="number" class="form-control" name="dealPrice" id="dealPrice" value="{{$work[0]['harga_deal']}}" id="dealPrice" disabled>
        @error('dealPrice')
            <div class="err">
                {{$message}}
            </div>
        @enderror
    </div>
    <input type="hidden" name="id" value="{{ $work[0]['kode_pekerjaan'] }}">
    @if($status==0)
        <a href="/mandor/lihatPekerjaan" class="btn btn-secondary">Kembali </a>
        <a href="/mandor/sProject/{{encrypt($work[0]['id_pekerjaan'])}}" class="btn btn-danger">Selesaikan</a>
    @else
        <a href="/mandor/lihatHistoryPekerjaan" class="btn btn-secondary">Kembali</a>
    @endif
</form>
    <script>
        $('#judul').html('Detail Pekerjaan');
        $('.form-control').attr('disabled',"");
        $('.custom-select').attr('disabled',"");
    </script>
@endsection
