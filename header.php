<?php include('config.php'); ?>
<!doctype html>
<html lang="et">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <title>TIETO</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">TIETO</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link text-info" href="/tieto/Tieto/index.php">| Avaleht |</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link text-info" href="/tieto/Tieto/admin/index.php">| Admin |</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link text-info dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        | Grupid |
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="index.php">Ettevõtted</a>
                            <?php
                                $paring = 'SELECT * FROM grupid';
                                $valjund = mysqli_query($yhendus, $paring);
                                while($rida = mysqli_fetch_row($valjund)){
                                    echo '<a class="dropdown-item" href="?grupp='.$rida[0].'">'.$rida[1].'</a>';
                                }
                            ?>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div style="background: url(https://wallpaper.dog/large/20467118.jpg) no-repeat center center; background-size: cover;" class="jumbotron text-white">
        <div class="container py-5 text-center">
            <h1 class="display-4 font-weight-bold">TIETO</h1>
            <p class="font-italic mb-0">ITS23</p>
            <a href="https://bootstrapious.com" class="text-white"></a>
        </div>
    </div>
    <div class="container">
