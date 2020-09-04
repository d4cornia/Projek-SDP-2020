<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$title}}</title>
    <style>
        .container{
            margin: 17% 0 0 35%;
            width: 28%;
            height: 100%;
            border: 1px solid black;
            border-radius: 25px;
        }
        .row{
            margin: 25px;
            flex-wrap: nowrap;
        }
        .badge{
            width: 200px;
            height: 100px;
            padding-top: 30px;
            font-size: 2rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col">
                <a href="/rMandor" class="badge badge-success">Mandor</a>
            </div>
            <div class="col">
                <a href="/rAdmin" class="badge badge-warning">Admin</a>
            </div>
        </div>
    </div>
</body>
</html>
