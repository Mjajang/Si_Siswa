<?php
session_start();

if (!isset($_SESSION["login"])) {
  header("Location: login.php");

  exit;
}

require 'functions.php';
$jadwal_mapel = query("SELECT jadwal_mapel.id as 'id', mapel.id as 'mapel_id', guru.id as 'guru_id', kelas.id as 'kelas_id',
mapel.nm_mapel as 'nm_mapel', guru.nama as 'nm_guru', kelas.nmkelas as 'nm_kelas', time_format(jp_start, '%H:%i') as 'jp_start', time_format(jp_end, '%H:%i') as 'jp_end'
FROM jadwal_mapel 
INNER JOIN mapel ON jadwal_mapel.id_mapel = mapel.id 
INNER JOIN guru ON jadwal_mapel.id_guru = guru.id 
INNER JOIN kelas ON jadwal_mapel.id_kelas = kelas.id ORDER BY id DESC");



?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data Jadwal Mata pelajaran</title>
  <link rel="stylesheet" href="style.css">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
      <div class="logo">
        <a class="navbar-brand" href="index.php">Si_Siswa</a>
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
          <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Si_siswa</h5>
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
  <main>
    <h2>Jadwal Mata Pelajaran</h2>
  </main>
  <a href="tambah_jadwal_mapel.php" class="btn btn-primary" id="addkelas" style="margin-left: 13px;">Tambah jadwal mata pelajaran</a>


  <div class="table-responsive mt-3">
    <table class="table table-striped table-hover">
      <thead class="table-dark">
        <tr>
          <th>No</th>
          <th>Aksi</th>
          <th>Mata pelajaran</th>
          <th>Guru</th>
          <th>Kelas</th>
          <th>Jam Pelajaran</th>
        </tr>
      </thead>
      <tbody>
        <?php $i = 1; ?>
        <?php foreach ($jadwal_mapel as $row) : ?>
          <tr class="align-middle">
            <td><?= $i; ?></td>
            <td>
              <a href="detail_jadwal_mapel.php?id=<?= $row["id"] ?>" class="btn btn-primary btn-sm">Lihat</a> |
              <a href="edit_jadwal_mapel.php?id=<?= $row["id"]; ?>" class="btn btn-warning btn-sm" style="color: white;">Edit</a> |
              <a href="hapus_jadwal_mapel.php?id=<?= $row["id"]; ?>" onclick="return confirm('yakin dihapus?');" class="btn btn-danger btn-sm">Hapus</a>
            </td>
            <td><?= $row["nm_mapel"] ?></td>
            <td><?= $row["nm_guru"] ?></td>
            <td><?= $row["nm_kelas"] ?></td>
            <td><?= $row["jp_start"] ?> - <?= $row["jp_end"] ?></td>
          </tr>
          <?php $i++; ?>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>