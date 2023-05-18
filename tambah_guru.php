<?php

session_start();

if (!isset($_SESSION["login"])) {
    header("Location: login.php");

    exit;
}

require 'functions.php';


$kelas = query("SELECT * FROM kelas ORDER BY nmkelas ASC");
$siswa = query("SELECT * FROM siswa");
foreach ($siswa as $id) {
    $id_siswa = $id["id"];
}

// if (isset($_POST["submit-ortu"])) {
//     if (tambah_ortu($_POST) > 0) {
//         echo "<script>alert('Data berhasil ditambahkan!'); document.location.href='siswa.php';</script>";
//     } else {
//         echo "<script>alert('Data gagal ditambahkan!');</script>";
//     }
// }
//$nip = $_POST["nip"];

if (isset($_POST["submit"])) {
    if (tambah_guru($_POST) > 0) {
        echo "<script>alert('Data berhasil ditambahkan!'); document.location.href='guru.php';</script>";
        // mysqli_query($conn, "INSERT INTO guru (nip) VALUES('$nip')");
    } else {
        echo "<script>alert('Data gagal ditambahkan!');</script>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah data siswa</title>

    <link rel="stylesheet" href="style.css">
    <link href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css' rel='stylesheet' type='text/css'>
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
        <h2 class="hsiswa">Tambah data guru</h2>
    </main>


    <div class="position-relative">
        <div class="position-absolute  top-0 start-50 translate-middle-x" style="background-color: #dfdbdb; padding:20px; border-radius:10px;">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <form action="" method="post" enctype="multipart/form-data">
                            <h3 style="color:grey;">Data Guru</h3>
                            <div class="mb-3">
                                <label for="nip" class="form-label">NIP: </label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="nip" placeholder="Nip" aria-label="Username" aria-describedby="basic-addon1">
                                </div>


                                <label for="nama" class="form-label">Nama: </label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="nama" placeholder="Nama" aria-label="Username" aria-describedby="basic-addon1">
                                </div>

                                <label for="umur" class="form-label">Umur: </label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="umur" placeholder="Umur" aria-label="Username" aria-describedby="basic-addon1">
                                </div>

                                <label for="telp" class="form-label">Telepone: </label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="telp" placeholder="Telepone" aria-label="Username" aria-describedby="basic-addon1">
                                </div>

                                <!-- <label for="alamat" class="form-label">Alamat: </label> -->
                                <!-- <div class="input-group">
                        <input type="text" class="form-control" name="alamat"  placeholder="Alamat" aria-label="Username" aria-describedby="basic-addon1">
                    </div> -->

                                <label for="alamat" class="form-label">Alamat: </label>
                                <div class="input-group">
                                    <textarea class="form-control" aria-label="With textarea" name="alamat" placeholder="Alamat"></textarea>
                                </div>



                                <label for="thn_masuk" class="form-label mt-3">Tahun masuk: </label>
                                <div class="input-group date">
                                    <input type="text" placeholder="dd/mm/yyyy" class="form-control" autocomplete="off" data-date-format="mm/dd/yyyy" name="thn_masuk" id='datepicker' data-provide="datepicker">
                                </div>


                                <label for="status_guru" class="form-label mt-3">Status guru:</label>

                                <select class="form-select" name="status_guru" id="status_guru">
                                    <option value="honorer">Honorer</option>
                                    <option value="tetap">Tetap</option>
                                </select>



                                <label for="foto" class="form-label mt-3">Foto: </label>
                                <input class="form-control" type="file" name="foto" id="foto" style="cursor: pointer;">

                                <div class="d-grid gap-2 d-md-block mt-4">
                                    <button type="submit" name="submit" class="btn btn-primary" style="cursor: pointer;">Tambah Data</button>
                                    <a href="guru.php" class="btn btn-dark">Batal</a>
                                </div>
                            </div>
                        </form>

                    </div>

                    <!-- <div class="col-sm-6">
                <form action="" method="post" enctype="multipart/form-data">
                   

                    <div class="d-grid gap-2 d-md-block">
                        <button type="submit" name="submit-ortu" class="btn btn-primary" style="cursor: pointer;">Tambah Data Ortu</button>
                        <a href="siswa.php" class="btn btn-dark">Batal</a>
                    </div>
                </form>
            </div> -->
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js' type='text/javascript'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js' type='text/javascript'></script>
    <!-- Script -->
    <script type="text/javascript">
        $(document).ready(function() {
            $('#datepicker').datepicker();
        });
    </script>
    <script>
        var btnEmail = document.getElementById("btnemail");

        function addemail() {
            var email = document.getElementById("addemail");
            var lemail = document.getElementById("lemail");
            email.style = "display: block";
            lemail.style = "display: block";
        }
        btnEmail.addEventListener("click", addemail);
    </script>
</body>

</html>