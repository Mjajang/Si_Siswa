<?php
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: login.php");

    exit;
}

require 'functions.php';

$_GET['q'] = '';
if (isset($_GET['q'])) {
    $cari = $_GET['q'];
    $_SESSION['q'] = $cari;
} else {
    $cari = $_SESSION['q'];
}





$guru = mysqli_query($conn, "SELECT * FROM `guru`");

// Pagination
$jmlDataPerhalaman = 5;
$jmlData = mysqli_num_rows($guru);
$jmlHalaman = ceil($jmlData / $jmlDataPerhalaman);
$halamanAktif = (isset($_GET["p"])) ? $_GET["p"] : 1;
$awalData = ($jmlDataPerhalaman * $halamanAktif) - $jmlDataPerhalaman;

$jmllink = 3;
if ($halamanAktif > $jmllink) {
    $start_number = $halamanAktif - $jmllink;
} else {
    $start_number = 1;
}

if ($halamanAktif < ($jmlHalaman - $jmllink)) {
    $end_number = $halamanAktif + $jmllink;
} else {
    $end_number = $jmlHalaman;
}

$guru_perhalaman = mysqli_query($conn, "SELECT guru.id as 'id', nip, nama, umur, telp, alamat, thn_masuk, status_guru, foto FROM `guru` 
WHERE nip LIKE '%$cari%' OR nama LIKE  '%$cari%' 
OR umur LIKE  '%$cari%' 
OR telp LIKE  '%$cari%' 
OR alamat LIKE  '%$cari%'
OR status_guru LIKE  '%$cari%' 
ORDER BY id DESC
LIMIT $awalData, $jmlDataPerhalaman ");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Guru</title>
    <link rel="stylesheet" href="style.css">
    <script src="js/jquery-3.6.4.min.js"></script>
    <script src="js/script.js"></script>
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
        <h2>Data Guru</h2>
    </main>
    <div class="d-grid gap-2 d-md-block" style="margin-left: 13px;">
        <a href="tambah_guru.php" class="btn btn-primary">Tambah data guru</a>
    </div>
    <nav class="navbar mt-3" style="background-color: white;">
        <div class="container-fluid">
            <form class="d-flex" method="get" role="search">
                <input name="q" class="form-control me-2" type="search" placeholder="Cari data guru.." aria-label="Search" value="<?php echo $cari; ?>">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
        </div>
    </nav>


    <div class="pagination mt-3" id="halaman">
        <!-- Pagination -->
        <?php if ($halamanAktif > 1) : ?>
            <a class="prev" href="?p=<?= $halamanAktif - 1; ?>">&laquo;</a>
        <?php endif; ?>

        <?php for ($i = $start_number; $i <= $end_number; $i++) : ?>
            <?php if ($i == $halamanAktif) : ?>
                <a class="page" style="font-weight: bold;" href="?p=<?= $i; ?>"><?= $i; ?></a>
            <?php else : ?>
                <a class="page" href="?p=<?= $i; ?>"><?= $i; ?></a>
            <?php endif; ?>
        <?php endfor; ?>

        <?php if ($halamanAktif < $jmlHalaman) : ?>
            <a class="next" href="?p=<?= $halamanAktif + 1; ?>">&raquo;</a>
        <?php endif; ?>

    </div>
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">NIP</th>
                    <th scope="col">Aksi</th>
                    <th scope="col">Foto</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Umur</th>
                    <th scope="col">Telepone</th>
                    <th scope="col">Alamat</th>
                    <th scope="col">Tahun masuk</th>
                    <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1 + $awalData; ?>
                <?php foreach ($guru_perhalaman as $row) : ?>
                    <tr class="align-middle">
                        <td style="font-weight: bold;" scope="row"><?= $i; ?></td>
                        <td scope="row"><?= $row["nip"] ?></td>
                        <td scope="row">
                            <a href="detail_guru.php?id=<?= $row["id"]; ?>" class="btn btn-primary btn-sm mt-2" style="width:63px;">Lihat</a> <span class="pemisahBtn ">|</span>
                            <a href="edit_guru.php?id=<?= $row["id"]; ?>" class="btn btn-warning btn-sm mt-2" style="color: white; width:63px;">Edit</a> <span class="pemisahBtn ">|</span>
                            <a href="hapus_guru.php?id=<?= $row["id"]; ?>" onclick="return confirm('yakin dihapus?');" class="btn btn-danger btn-sm mt-2">Hapus</a>
                        </td>
                        <td scope="row"><img class="rounded" src="img/<?= $row["foto"]; ?>" width="50" height="55" alt=""></td>
                        <td scope="row"><?= $row["nama"] ?></td>
                        <td scope="row"><?= $row["umur"] ?></td>
                        <td scope="row"><?= $row["telp"] ?></td>
                        <td scope="row">
                            <?= strlen($row["alamat"]) > 30 ? substr($row["alamat"], 0, 30) . "<a class='btn ' data-bs-container='body' data-bs-toggle='popover' data-bs-placement='bottom' data-bs-content='Alamat'>
  ...
</a>" : $row["alamat"] ?></td>
                        <td scope="row"><?= $row["thn_masuk"] ?></td>
                        <td scope="row"><?= $row["status_guru"] ?></td>

                    </tr>
                    <?php $i++; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script>
        const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]')
        const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl))
    </script>
</body>

</html>