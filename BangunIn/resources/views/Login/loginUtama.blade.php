<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <style>
        body{
            background-image: url('./assets/773752.jpg');
        }
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
</head>
<body class="hold-transition sidebar-mini">
    <div class="content">
        <div class="card col-md-4-sm-12 " style="width: 30vw;margin: auto; margin-top: 20vh;box-shadow: 5px 5px 5px rgba(0,0,0,0.4);">
            <div class="card-header">
                <h3 style="text-align: center">Login</h3>
            </div>
            <form action="" class="form-horizontal" method="post">
                <div class="card-body">
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-12 col-form-label">Email</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="username" placeholder="NRP" name="username">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword3" class="col-sm-12 col-form-label">Password</label>
                        <div class="col-sm-12">
                            <input type="password" class="form-control" id="pass" placeholder="Password" name="pass">
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="col-sm-12 btn btn-primary" style="margin: auto;">Sign in</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
