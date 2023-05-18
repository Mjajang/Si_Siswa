<?php

use JetBrains\PhpStorm\Internal\ReturnTypeContract;

session_start();

if (!isset($_SESSION["login"])) {
    header("Location: login.php");

    exit;
}

require 'functions.php';

if (isset($_POST["submit-ortu"])) {
    if (edit_ortu($_POST) > 0) {
        echo "<script>alert('Data gagal ditambahkan!');</script>";
    } else {
        echo "<script>alert('Data berhasil ditambahkan!'); document.location.href='siswa.php';</script>";
    }
}

if (isset($_POST["submit"])) {
    if (edit($_POST) == 0) {
        echo "<script>alert('Data berhasil diedit!'); document.location.href='siswa.php';</script>";
    } else {
        echo "<script>alert('Data gagal diedit!');</script>";
    }
}

$id = $_GET["id"];

$ortu = mysqli_query($conn, "SELECT * FROM orang_tua_siswa WHERE id_siswa = $id");
$siswa = query("SELECT * FROM siswa WHERE id = $id")[0];
$kelas = query("SELECT * FROM kelas ORDER BY nmkelas ASC");


$result = mysqli_fetch_assoc($ortu);

if (isset($result['id_siswa'])) {
    $id_siswa = $result['id_siswa'];
    $ket = $result['keterangan'];
    $nmortu = $result['nama'];
    $pekerjaan = $result['pekerjaan'];
    $no_hp = $result['no_hp'];
} else {
    $iAyah = mysqli_query($conn, "INSERT INTO orang_tua_siswa (nama, keterangan, pekerjaan, no_hp, id_siswa)
    VALUES ('Data Orang tua belum dientry', 'ayah', 'Data Orang tua belum dientry', 'Data Orang tua belum dientry', '$id')");
    $iIbu = mysqli_query($conn, "INSERT INTO orang_tua_siswa (nama, keterangan, pekerjaan, no_hp, id_siswa)
    VALUES ('Data Orang tua belum dientry', 'ibu', 'Data Orang tua belum dientry', 'Data Orang tua belum dientry', '$id')");

    mysqli_query($conn, $iAyah);
    mysqli_query($conn, $iIbu);
}

$test = mysqli_query($conn, "SELECT * FROM `orang_tua_siswa` WHERE id_siswa = $id AND keterangan = 'ayah';");
$test2 = mysqli_query($conn, "SELECT * FROM `orang_tua_siswa` WHERE id_siswa = $id AND keterangan = 'ibu';");

$testA = mysqli_fetch_assoc($test);
$testI = mysqli_fetch_assoc($test2);

if (isset($testA['nama'], $testA['pekerjaan'], $testA['no_hp'])) {
    $nmAyah = $testA['nama'];
    $pkAyah = $testA['pekerjaan'];
    $hpAyah = $testA['no_hp'];
} else {
    $nmAyah = "Data Orang tua belum dientry";
    $pkAyah = "Data Orang tua belum dientry";
    $hpAyah = "Data Orang tua belum dientry";

    $nmIbu = "Data Orang tua belum dientry";
    $pkIbu = "Data Orang tua belum dientry";
    $hpIbu = "Data Orang tua belum dientry";
}

if (isset($testI['nama'], $testI['pekerjaan'], $testI['no_hp'])) {
    $nmIbu = $testI['nama'];
    $pkIbu = $testI['pekerjaan'];
    $hpIbu = $testI['no_hp'];
} else {
    $nmIbu = "Data Orang tua belum dientry";
    $pkIbu = "Data Orang tua belum dientry";
    $hpIbu = "Data Orang tua belum dientry";
}




?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit data siswa</title>
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
        <h2>Edit data siswa</h2>
    </main>
    <div class="position-relative">
        <div class="position-absolute  top-0 start-50 translate-middle-x" style="background-color: #dfdbdb; padding:20px; border-radius:10px;">
            <div class="row">
                <div class="col">
                    <form action="" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?= $siswa["id"]; ?>">
                        <input type="hidden" name="fotolama" value="<?= $siswa["foto"]; ?>">
                        <h3 style="color:grey;">Data Siswa</h3>
                        <div class="mb-3">
                            <label for="nis" class="form-label">NIS: </label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="nis" value="<?= $siswa["nis"];  ?>" aria-label="Username" aria-describedby="basic-addon1">
                            </div>


                            <label for="nama" class="form-label">Nama: </label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="nama" value="<?= $siswa["nama"]; ?>" aria-label="Username" aria-describedby="basic-addon1">
                            </div>


                            <!-- <label for="alamat" class="form-label">Alamat: </label> -->
                            <!-- <div class="input-group">
                        <input type="text" class="form-control" name="alamat"  placeholder="Alamat" aria-label="Username" aria-describedby="basic-addon1">
                    </div> -->

                            <label for="alamat" class="form-label">Alamat: </label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="alamat" value="<?= $siswa["alamat"]; ?>" aria-label="Username" aria-describedby="basic-addon1">
                            </div>



                            <label for="email" class="form-label">Email: </label>
                            <div class="input-group">
                                <input type="email" class="form-control" name="email" value="<?= $siswa["email"]; ?>" aria-label="Username" aria-describedby="basic-addon1">
                            </div>


                            <label for="id_kelas" class="form-label">Kelas:</label>

                            <select class="form-select" name="id_kelas" id="id_kelas">
                                <?php foreach ($kelas as $namakelas) : ?>
                                    <option <?= $siswa['id_kelas'] == $namakelas["id"] ? 'selected' : '' ?> value="<?= $namakelas["id"]; ?>"><?= $namakelas["nmkelas"]; ?></option>
                                <?php endforeach; ?>
                            </select>



                            <label for="foto" class="form-label mt-3">Foto: </label>
                            <img src="img/<?= $siswa["foto"] ?>" alt="" width="100" style="display: block; border-radius:10px;">
                            <input class="form-control mt-3" type="file" name="foto" id="foto" style="cursor: pointer;">


                            <input type="hidden" name="id_siswa" value="<?= $id_siswa; ?>">
                            <h3 style="color:grey; margin-top:20px">Data Orang tua </h3>
                            <div class="mb-3">
                                <label for="nmAyah" class="form-label">Nama Ayah: <span class="req">*</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control" value=" <?= $nmAyah === null ? "Data Orang tua belum dientry" : $nmAyah ?>" name="nmAyah" placeholder="Nama Ayah" aria-label="Username" aria-describedby="basic-addon1">
                                </div>

                                <label for="pkortu" class="form-label">Pekerjaan: <span class="req">*</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="pkAyah" value="<?= $pkAyah === null ? "Data Orang tua belum dientry" : $pkAyah  ?>" aria-label="Username" aria-describedby="basic-addon1">
                                </div>

                                <label for="hportu" class="form-label">No HP: <span class="req">*</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="hpAyah" value="<?= $hpAyah === null ? "Data Orang tua belum dientry" : $hpAyah ?>" aria-label="Username" aria-describedby="basic-addon1">
                                </div>


                                <label for="nmIbu" class="form-label">Nama Ibu: <span class="req">*</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control" value="<?= $nmIbu === null ? "Data Orang tua belum dientry" : $nmIbu ?>" name="nmIbu" aria-label="Username" aria-describedby="basic-addon1">
                                </div>

                                <label for="pkortu" class="form-label">Pekerjaan: <span class="req">*</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="pkIbu" value="<?= $pkIbu === null ? "Data Orang tua belum dientry" : $pkIbu ?>" aria-label="Username" aria-describedby="basic-addon1">
                                </div>

                                <label for="hportu" class="form-label">No HP: <span class="req">*</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="hpIbu" value="<?= $hpIbu === null ? "Data Orang tua belum dientry" : $hpIbu ?>" aria-label="Username" aria-describedby="basic-addon1">
                                </div>
                            </div>
                            <!-- <div class="d-grid gap-2 d-md-block">
                        <button type="submit" name="submit-ortu" class="btn btn-primary" style="cursor: pointer;">Edit Data Ortu</button>
                    </div> -->

                            <div class="d-grid gap-2 d-md-block">
                                <button type="submit" name="submit" class="btn btn-primary">Edit Data</button>
                                <a href="siswa.php" class="btn btn-dark">Batal</a>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- <div class="col-sm-6">
            <form action="" method="post" enctype="multipart/form-data">

            </form>
        </div> -->
            </div>
        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>