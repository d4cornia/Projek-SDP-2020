@extends('tukang.navbar')

@section('content')
    <h1>Konfirmasi Dana Tukang</h1>
    <hr>
        <form action="/tukang/confirmAbsen" method="post">
            @csrf
            <div class="table-responsive">
                <table id="tabel-history" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Pekerjaan</th>
                        <th scope="col">Mandor</th>
                        <th scope="col">Gaji Tukang</th>
                    </tr>
                </thead>
                <tbody id="">

                </tbody>
                <tfoot>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Pekerjaan</th>
                        <th scope="col">Mandor</th>
                        <th scope="col">Gaji Tukang</th>
                    </tr>
                </tfoot>
                </table>
            </div>
    <script>
        $(document).ready(function() {
            $("#tabel-history").DataTable();
    } );
    </script>
@endsection
