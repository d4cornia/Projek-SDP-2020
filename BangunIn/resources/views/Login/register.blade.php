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
    <title>Bangunin</title>
</head>
<body class="hold-transition sidebar-mini">
    <div class="content">
        <div class="card col-md-4-sm-12 " style="width: 40vw;margin: auto; margin-top: 20vh;box-shadow: 5px 5px 5px rgba(0,0,0,0.4);">
            <div class="card-header">
                <h3 style="text-align: center">Register Akun</h3>
            </div>
            <form action="/register" class="form-horizontal" method="post">
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
                </div>
                <div class="form-group row">
                    <div class="col-sm-12 p-4">
                        <input type="submit" class="col-sm-12 btn btn-dark" style="margin: auto;" name="btnRegister" value="Register Akun">
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

@if(isset($error)){{--gagal register--}}
    <script>
        swal("Gagal Login!", "{{$error}}", "error");
    </script>
@endif
