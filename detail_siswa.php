<?php

session_start();

if (!isset($_SESSION["login"])) {
  header("Location: login.php");

  exit;
}

require_once "functions.php";

$id = $_GET["id"];

$siswa = mysqli_query($conn, "SELECT siswa.id_kelas as 'kelas_id', kelas.id as 'id_kelass', orang_tua_siswa.id_siswa, orang_tua_siswa.nama as 'nmortu', orang_tua_siswa.keterangan as 'ket', orang_tua_siswa.pekerjaan as 'pekerjaan', orang_tua_siswa.no_hp as 'no_hp', siswa.id as 'id', siswa.nis, siswa.nama, siswa.alamat, siswa.email,  siswa.foto, kelas.nmkelas as 'nama_kelas' FROM `siswa` 
LEFT JOIN kelas ON siswa.id_kelas = kelas.id
LEFT JOIN orang_tua_siswa ON siswa.id = orang_tua_siswa.id_siswa
WHERE siswa.id = $id");

$result = mysqli_fetch_assoc($siswa);
$ket = $result['ket'];
$nmortu = $result['nmortu'];
$pekerjaan = $result['pekerjaan'];
$no_hp = $result['no_hp'];
$kelas_id = $result['kelas_id'];
$id_kelas = $result['id_kelass'];

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


if ($result['id_siswa'] === null) {
  $nmAyah = "Data Orang tua belum dientry";
  $pkAyah = "Data Orang tua belum dientry";
  $hpAyah = "Data Orang tua belum dientry";

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
  <title>Detail Siswa</title>

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
    <h2>Detail Siswa</h2>
  </main>
  <div class="container">
    <div class="row d-flex justify-content-center">
      <div class="col-lg-5 p-4" style="background-color: #dfdbdb; border-radius:10px;">
        <h4 class="text-secondary">Data Diri</h4>
        <ul class="list-group list-group-flush">
          <li class="list-group-item px-0 d-flex justify-content-between" style="background-color: #dfdbdb">
            <p>NIS</p>
            <p><?= $result['nis']; ?></p>
          </li>
          <li class="list-group-item px-0 d-flex justify-content-between" style="background-color: #dfdbdb">
            <p>Nama</p>
            <p><?= $result['nama']; ?></p>
          </li>
          <li class="list-group-item px-0 d-flex justify-content-between" style="background-color: #dfdbdb">
            <p>Alamat</p>
            <p style="margin-left: 20px;"><?= $result['alamat']; ?></p>
          </li>
          <li class="list-group-item px-0 d-flex justify-content-between" style="background-color: #dfdbdb">
            <p>Email</p>
            <p><?= $result['email'] === '' ? 'Belum memiliki email' : $result['email'] ?></p>
          </li>
          <h4 class="mt-3 text-secondary">Data Kelas</h4>
          <li class="list-group-item px-0 d-flex justify-content-between" style="background-color: #dfdbdb">
            <p>Kelas</p>
            <p><?= $kelas_id !=  $id_kelas ? 'Kelas belum ada' : $result['nama_kelas']; ?></p>
          </li>
          <h4 class="mt-3 text-secondary">Data Orang tua</h4>
          <li class="list-group-item px-0 d-flex justify-content-between" style="background-color: #dfdbdb">
            <p>Nama ayah</p>
            <p><?= $nmAyah === null ? "Data Orang tua belum dientry" : $nmAyah ?></p>
          </li>
          <li class="list-group-item px-0 d-flex justify-content-between" style="background-color: #dfdbdb">
            <p>Pekerjaan ayah</p>
            <p><?= $pkAyah === null ? "Data Orang tua belum dientry" : $pkAyah  ?></p>
          </li>
          <li class="list-group-item px-0 d-flex justify-content-between" style="background-color: #dfdbdb">
            <p>No HP </p>
            <p><?= $hpAyah === null ? "Data Orang tua belum dientry" : $hpAyah ?></p>
          </li>
          <li class="list-group-item px-0 d-flex justify-content-between mt-3" style="background-color: #dfdbdb">
            <p>Nama ibu</p>
            <p><?= $nmIbu === null ? "Data Orang tua belum dientry" : $nmIbu ?></p>
          </li>
          <li class="list-group-item px-0 d-flex justify-content-between" style="background-color: #dfdbdb">
            <p>Pekerjaan ibu</p>
            <p><?= $pkIbu === null ? "Data Orang tua belum dientry" : $pkIbu  ?></p>
          </li>
          <li class="list-group-item px-0 d-flex justify-content-between" style="background-color: #dfdbdb">
            <p>No HP </p>
            <p><?= $hpIbu === null ? "Data Orang tua belum dientry" : $hpIbu ?></p>
          </li>
          <h4 class="mt-3 text-secondary">Lainnya</h4>
          <li class="list-group-item px-0 d-flex justify-content-between" style="background-color: #dfdbdb">
            <p>Foto</p>
            <img src="img/<?= $result["foto"] ?>" alt="" width="200" style="border-radius: 10px;">
          </li>
          <li type="none"><a href="siswa.php" class="btn btn-dark mt-3">Kembali</a></li>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>