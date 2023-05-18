<?php
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: login.php");

    exit;
}

require 'functions.php';
$siswa = query("SELECT * FROM siswa ORDER BY id DESC");
$jmlsiswa = query("SELECT COUNT(id) AS jml_siswa FROM siswa");
$jmlkelas = query("SELECT COUNT(id) AS jml_kelas FROM kelas");
$jmlguru = query("SELECT COUNT(id) AS jml_guru FROM guru");

foreach ($jmlsiswa as $Jsiswa) {
    $Jsiswa  = $Jsiswa["jml_siswa"];
}

foreach ($jmlkelas as $Jkelas) {
    $Jkelas  = $Jkelas["jml_kelas"];
}

foreach ($jmlguru as $Jguru) {
    $Jguru  = $Jguru["jml_guru"];
}

date_default_timezone_set("Asia/Jakarta");
$h =  date("H");
$halo = "";
if ($h >= 6 && $h < 12) {
    $halo = "Selamat pagi, " . $_SESSION["username"];
} elseif ($h >= 12 && $h < 18) {
    $halo = "Selamat siang, " . $_SESSION["username"];
} else {
    $halo = "Selamat malam, " . $_SESSION["username"];
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Informasi Siswa</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container" style="margin-left: 23px;">
            <div class="logo">
                <a class="navbar-brand" href="index.php">Si siswa</a>
            </div>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Data-data
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="siswa.php?q=">Data Siswa</a></li>
                            <li><a class="dropdown-item" href="kelas.php">Data Kelas</a></li>
                            <li><a class="dropdown-item" href="guru.php">Data Guru</a></li>
                            <li><a class="dropdown-item" href="mapel.php">Data Mata Pelajaran</a></li>
                            <li><a class="dropdown-item" href="jadwal_mapel.php">Jadwal Mata Pelajaran</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Si siswa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul>
                        <li class="nav-item" type="none">
                            <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                        </li>
                        <li class="dropdown" type="none">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Data-data
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="siswa.php?q=">Data Siswa</a></li>
                                <li><a class="dropdown-item" href="kelas.php">Data Kelas</a></li>
                                <li><a class="dropdown-item" href="guru.php">Data Guru</a></li>
                                <li><a class="dropdown-item" href="mapel.php">Data Mata Pelajaran</a></li>
                                <li><a class="dropdown-item" href="jadwal_mapel.php">Jadwal Mata Pelajaran</a></li>
                            </ul>
                        </li>
                        <li type="none" style="margin-top: 150px;">

                            <a href="logout.php" class="btn btn-danger" id="logout-mobile">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <a href="logout.php" class="btn btn-danger" id="logout" style="margin-right: 20px;">Logout</a>
    </nav>
    <div class="container-fluid mt-5">
        <div class="row" style="margin-left: 13px; margin-right: 13px;">
            <div class="col-12">
                <h1>Sistem Informasi Siswa</h1>
                <p style="font-weight: bold;"><?php echo ($halo) ?></p>
                <p class="lp-p">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec lobortis lorem eu dolor mollis, eu consectetur lorem euismod. Nam interdum vestibulum ex, eget euismod libero volutpat ac. Nulla facilisi. Sed imperdiet, lacus sed laoreet fringilla, metus arcu lacinia justo, ut vestibulum leo dolor ac turpis. Sed euismod laoreet magna, vel sollicitudin enim suscipit a. Aliquam auctor tellus eget lacus tempor malesuada. Nullam viverra elementum metus, nec faucibus neque.</p>
            </div>
            <div class="col-12">
                <div class="card d-inline-block" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Jumlah Siswa</h5>
                        <p class="card-text"><?= $Jsiswa ?></p>
                    </div>
                </div>
                <div class="card d-inline-block mt-3" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Jumlah Kelas</h5>
                        <p class="card-text"><?= $Jkelas ?></p>
                    </div>
                </div>
                <div class="card d-inline-block mt-3" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Jumlah Guru</h5>
                        <p class="card-text"><?= $Jguru ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- <div class="container">
        <div class="row">
            <div class="col-10" style="height: 500px; background-color: blue">

            </div>
            <div class="col-2" style="height: 500px; background-color: black">

            </div>
            <div class="col-2" style="height: 500px; background-color: black">

            </div>
        </div>
    </div> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>