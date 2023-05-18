<?php

session_start();

if (!isset($_SESSION["login"])) {
    header("Location: login.php");

    exit;
}

require 'functions.php';
$kelas = query("SELECT * FROM kelas");
$guru = query("SELECT * FROM guru");
$siswa = query("SELECT * FROM siswa");
$mapel = query("SELECT * FROM mapel");


// // $dGuru = isset($_POST["guru"]);
// // $dMapel = isset($_POST["mapel"]);
// // $dKelas = isset($_POST["kelas"]);

// // if ($dGuru) {
// //     $dGuru = $dGuru;
// //     if ($dMapel) {
// //         $dMapel = $dMapel;
// //     }
// // } else   if ($dKelas === 19 || $dKelas === 20) {
// //     echo "<script> alert('Guru dan MAPEL yang sama tidak boleh mengajar di kelas yang beda tingkat!')</script>";
// //     return false;
// }


if (isset($_POST["submit"])) {
    if (tambah_jadwal_mapel($_POST) > 0) {
        echo "<script>alert('Data berhasil ditambahkan!'); document.location.href='jadwal_mapel.php';</script>";
    } else {
        echo "
        <script>
            alert('Data gagal ditambahkan!'); 
        </script>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah jadwal mata pelajaran</title>
    <link rel="stylesheet" href="style.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
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
                            <li><a class="dropdown-item" href="siswa.php">Data Siswa</a></li>
                            <li><a class="dropdown-item" href="kelas.php">Data Kelas</a></li>
                            <li><a class="dropdown-item" href="guru.php">Data Guru</a></li>
                            <li><a class="dropdown-item" href="mapel.php">Data Mata Pelajaran</a></li>
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
                                <li><a class="dropdown-item" href="siswa.php">Data Siswa</a></li>
                                <li><a class="dropdown-item" href="kelas.php">Data Kelas</a></li>
                                <li><a class="dropdown-item" href="guru.php">Data Guru</a></li>
                                <li><a class="dropdown-item" href="mapel.php">Data Mata Pelajaran</a></li>
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
    <main>
        <h2>Tambah jadwal mata pelajaran</h2>
    </main>
    <div class="position-relative">
        <div class="position-absolute  top-0 start-50 translate-middle-x" style="background-color: #dfdbdb; padding:20px; border-radius:10px;">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <form action="" method="post">
                            <div class="mb-3">
                                <label for="mapel" class="form-label mt-3">mata pelajaran:</label>

                                <select class="form-select" name="mapel" id="mapel">
                                    <?php foreach ($mapel as $mapel) : ?>
                                        <option value="<?= $mapel['id'] ?>"><?= $mapel['nm_mapel'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <label for="guru" class="form-label mt-3">Guru:</label>

                                <select class="form-select" name="guru" id="guru">
                                    <?php foreach ($guru as $guru) : ?>
                                        <option value="<?= $guru['id'] ?>"><?= $guru['nama'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <label for="kelas" class="form-label mt-3">Kelas:</label>

                                <select class="form-select" name="kelas" id="kelas">
                                    <?php foreach ($kelas as $namakelas) : ?>
                                        <option value="<?= $namakelas["tingkat"]; ?>"> <?= $namakelas["nmkelas"]; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <label for="jp_start" class="form-label mt-3">Jam pelajaran: </label>
                                <div class="input-group">
                                    <input class="form-control" type="time" name="jp_start" required><span class="pt-1 px-3">sampai</span>
                                    <input class="form-control" type="time" name="jp_end" required>
                                </div>
                            </div>
                            <button style="cursor: pointer;" type="submit" name="submit" class="btn btn-primary">Tambah Data</button>
                            <a href="jadwal_mapel.php" class="btn btn-dark">Batal</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>