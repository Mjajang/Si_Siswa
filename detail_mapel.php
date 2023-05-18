<?php

session_start();

if (!isset($_SESSION["login"])) {
  header("Location: login.php");

  exit;
}

require_once "functions.php";

$id = $_GET["id"];

$mapel = query("SELECT  * FROM mapel
WHERE id = $id")[0];
$jml_guru = query("SELECT  COUNT(jadwal_mapel.id_guru) as jml_guru FROM `jadwal_mapel` 
LEFT JOIN mapel ON jadwal_mapel.id_guru = mapel.id
WHERE jadwal_mapel.id_mapel = $id")[0];


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detail mata pelajaran</title>

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

  <div class="container">
    <main>
      <h2>Detail Mata Pelajaran</h2>
    </main>

    <div class="row d-flex justify-content-center">
      <div class="col-lg-5 p-4" style="background-color: #dfdbdb; border-radius:10px;">
        <h4 class="text-secondary">Mata Pelajaran</h4>
        <ul class="list-group list-group-flush">
          <li class="list-group-item px-0 d-flex justify-content-between" style="background-color: #dfdbdb">
            <p>Mata Pelajaran</p>
            <p><?= $mapel['nm_mapel']; ?></p>
          </li>
          <h4 class="mt-3 text-secondary">Jumlah Guru Pengampu</h4>
          <li class="list-group-item px-0 d-flex justify-content-between" style="background-color: #dfdbdb">
            <p>Jumlah Guru Pengampu</p>
            <p> <?= $jml_guru['jml_guru']; ?></p>
          </li>
          <li type="none"><a href="mapel.php" class="btn btn-dark mt-3">Kembali</a></li>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>