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
    <title>BangunIn</title>
    <link rel="icon"
      type="image/png"
      href="assets/homepage/logo.png">
</head>
<body class="hold-transition sidebar-mini">
    <div class="content">
        <div class="card col-md-4-sm-12 mb-2 p-2" style="width: 30vw;margin: auto; margin-top: 20vh;box-shadow: 5px 5px 5px rgba(0,0,0,0.4);">
            <div class="card-header">
                <h3 style="text-align: center">Login</h3>
            </div>
            <form action="/login?stat={{$stat}}" class="form-horizontal" method="post">
                @csrf
                <div class="card-body">
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-12 col-form-label">Username</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="username" placeholder="username" name="username">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword3" class="col-sm-12 col-form-label">Password</label>
                        <div class="col-sm-12">
                            <input type="password" class="form-control" id="password" placeholder="Password" name="password">
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="col-sm-12 btn btn-primary" style="margin: auto;">Sign in</button>
                </div>
            </form>
        </div>
        <div class="card col-md-4-sm-12  p-4" style="width: 30vw;margin: auto;box-shadow: 5px 5px 5px rgba(0,0,0,0.4);">
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

@if(isset($error)){{--gagal login--}}
    <script>
        swal("Gagal Login!", "{{$error}}", "error");
    </script>
@endif
@if(isset($berhasil)){{--berhasil register--}}
    test
    <script>
        swal("Register Berhasil!", "{{$berhasil}}", "success");
    </script>
@endif
