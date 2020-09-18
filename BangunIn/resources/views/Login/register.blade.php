@empty($nm)
    @php
    $nm ="";
    $no ="";
    @endphp
@endempty
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <style>
        body{
            background-image: url('./assets/login/773752.jpg');
        }
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300&display=swap" rel="stylesheet">
    <title>Bangunin</title>
    <link rel="icon"
      type="image/png"
      href="assets/homepage/logo.png">
</head>
<body class="hold-transition sidebar-mini">
    <div class="content">
        <div class="card col-md-4-sm-12 " style="width: 40vw;margin: auto; margin-top: 2vh;box-shadow: 5px 5px 5px rgba(0,0,0,0.4);">
            <div class="card-header">
                <h3 style="text-align: center">Register Akun</h3>
            </div>
            <form action="/register" class="form-horizontal" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputEmail3" class="col-sm-12 col-form-label">Username</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="username" placeholder="username" name="username" required>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputPassword3" class="col-sm-12 col-form-label">Password</label>
                            <div class="col-sm-12">
                                <input type="password" class="form-control" id="password" placeholder="Password" name="password" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputEmail3" class="col-sm-12 col-form-label">Nama Lengkap</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="nama" placeholder="Nama Lengkap" name="nama" required>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputPassword3" class="col-sm-12 col-form-label">Nomer Telephone</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="nomer" placeholder="Nomer Telephone" name="nomer" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="form-group col-md-12">
                            <label for="inputPassword3" class="col-sm-12 col-form-label">Email</label>
                            <div class="col-sm-12">
                                <input type="email" class="form-control" id="email" placeholder="email" name="email" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputEmail3" class="col-sm-12 col-form-label">Nama Perushaan</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="nama" placeholder="Nama Perusahaaan" name="nmperusahaan" value="{{$nm}}" required>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputPassword3" class="col-sm-12 col-form-label">Nomer Telephone Perushaan</label>
                            <div class="col-sm-12">
                            <input type="text" class="form-control" id="nomer" placeholder="Nomer Telephone Perusahaan" name="noperusahaan" value="{{$no}}" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row" style="margin-bottom:5px">
                        <div class="form-group col-md-12">
                            <label for="inputPassword3" class="col-sm-12 col-form-label">Alamat Perusahaan</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="email" placeholder="Alamat Perusahaan" name="alperusahaan" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="form-group col-md-12">
                            <label for="inputPassword3" class="col-sm-12 col-form-label">Logo Perusahaan</label>
                                <div class="custom-file">
                                    <div class="col-12">

                                        <input type="file" class="custom-file-input" id="inputGroupFile04" name="logo" aria-describedby="inputGroupFileAddon04">
                                        <label class="custom-file-label" for="inputGroupFile04" required>Choose file</label>
                                    </div>
                                </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-12 p-4">
                            <input type="submit" class="col-sm-12 btn btn-dark" style="margin: auto;" name="btnRegister" value="Register Akun">
                        </div>
                    </div>
                </div>


            </form>

        </div>
        <div class="card col-md-4-sm-12  p-4 mt-4" style="width: 40vw;margin: auto;box-shadow: 5px 5px 5px rgba(0,0,0,0.4);">
            <div class="row">
                <div class="col-6 my-auto mx-auto ">
                        <h6 class="text-center my-auto">Kembali Ke Home</h6>
                </div>
                <div class="col-6 text-center">
                        <a href="/"><button class="btn btn-info w-100">Kembali</button></a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<script>
    $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
</script>
@if(isset($error)){{--gagal register--}}
    <script>
        swal("Gagal Login!", "{{$error}}", "error");
    </script>
@endif
