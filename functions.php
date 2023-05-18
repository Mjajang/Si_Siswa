<?php
define('LHOST', '127.0.0.1');
define('LUSER', 'root');
define('LPASS', '');

define('DB', 'si_siswa-3');

$conn = mysqli_connect(LHOST, LUSER, LPASS, DB);

function query($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    return $rows;
}


function tambah_ortu($ortu)
{
    global $conn;

    $nmAyah = htmlspecialchars($ortu["nmAyah"]);
    $pkAyah = htmlspecialchars($ortu["pkAyah"]);
    $hpAyah = htmlspecialchars($ortu["hpAyah"]);
    $nmIbu = htmlspecialchars($ortu["nmIbu"]);
    $pkIbu = htmlspecialchars($ortu["pkIbu"]);
    $hpIbu = htmlspecialchars($ortu["hpIbu"]);
    $id_siswa = htmlspecialchars($ortu["id_siswa"]);

    // $qValidasi = mysqli_query($conn, "SELECT orang_tua_siswa.nama, orang_tua_siswa.keterangan, orang_tua_siswa.pekerjaan, orang_tua_siswa.no_hp, orang_tua_siswa.id_siswa as 'id_siswa', siswa.id as 'siswa_id', siswa.nama
    //         FROM orang_tua_siswa 
    //         INNER JOIN siswa ON siswa.id = orang_tua_siswa.id_siswa 
    //         WHERE orang_tua_siswa.id_kelas = siswa.id");
    // foreach ($qValidasi as $validasiSiswa) {
    //     if ($validasiSiswa['id_siswa'] != $validasiSiswa['siswa_id']) {
    //         $id_siswa =  "Siswa belum ada";
    //     } else {
    //         $id_siswa = $id_siswa;
    //     }
    // }


    $qAyah = "INSERT INTO orang_tua_siswa(nama,keterangan,pekerjaan,no_hp,id_siswa) VALUES ('$nmAyah','ayah','$pkAyah','$hpAyah','$id_siswa')";
    $qIbu = "INSERT INTO orang_tua_siswa(nama,keterangan,pekerjaan,no_hp,id_siswa) VALUES ('$nmIbu','ibu','$pkIbu','$hpIbu','$id_siswa')";

    mysqli_query($conn, $qAyah);
    mysqli_query($conn, $qIbu);

    return mysqli_affected_rows($conn);
}

function tambah_jadwal_mapel($j)
{
    global $conn;
    $mapel = $j["mapel"];
    $guru = $j["guru"];
    $kelas = $j["kelas"];
    $jp_start = $j["jp_start"];
    $jp_end = $j["jp_end"];


    // jajang mengajar mapel A di kelas X, jajang tidak boleh mengajar mapel A di kelas XI
    // yang dibutuhkan : 1. id guru, 2. tingkatan, 3. mapel

    // query untuk cari tingkatan pada guru yg bersangkutan
    // SELECT kelas.tingkat FROM jadwal_mapel
    // INNER JOIN kelas ON jadwal_mapel.id_kelas = kelas.id
    // WHERE id_guru = 9

    // query untuk get tingkatan berdasarkan id kelas
    // SELECT tingkat FROM kelas WHERE id = 19


    // silahkan bandingke

    $id_Kelas = mysqli_query($conn, "SELECT * FROM kelas WHERE tingkat = $kelas");

    foreach ($id_Kelas as $key) {
        $kelas = $key['id'];
        if ($key['tingkat'] == 2) {
            echo "<script>alert('guru dengan mapel sama tidak boleh beda tingkat kelas')</script>";
            return false;
        }
    }

    $query = "INSERT INTO jadwal_mapel(id_mapel, id_guru, id_kelas, jp_start, jp_end) VALUES('$mapel', '$guru', '$kelas', '$jp_start', '$jp_end')";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function tambah_mapel($m)
{
    global $conn;
    $nm_mapel = $m["nm_mapel"];

    $query = "INSERT INTO mapel(nm_mapel) VALUES ('$nm_mapel')";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function tambah_guru($d)
{
    global $conn;
    $nip = $d["nip"];
    $nama = htmlspecialchars($d["nama"]);
    $umur = htmlspecialchars($d["umur"]);
    $telp = htmlspecialchars($d["telp"]);
    $alamat = htmlspecialchars($d["alamat"]);
    $thn_masuk = htmlspecialchars($d["thn_masuk"]);
    $status_guru = htmlspecialchars($d["status_guru"]);


    $foto = upload();
    if (!$foto) {
        return false;
    }

    $query = "INSERT INTO guru (nip, nama, umur, telp, alamat, thn_masuk, status_guru, foto) VALUES('$nip', '$nama', '$umur', '$telp', '$alamat', '$thn_masuk', '$status_guru', '$foto' )";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function tambah($data)
{
    global $conn;

    $nis = htmlspecialchars($data["nis"]);
    $nama = htmlspecialchars($data["nama"]);
    $alamat = htmlspecialchars($data["alamat"]);
    $email = htmlspecialchars($data["email"]);
    $id_kelas = htmlspecialchars($data["id_kelas"]);

    $nmAyah = htmlspecialchars($data["nmAyah"]);
    $pkAyah = htmlspecialchars($data["pkAyah"]);
    $hpAyah = htmlspecialchars($data["hpAyah"]);
    $nmIbu = htmlspecialchars($data["nmIbu"]);
    $pkIbu = htmlspecialchars($data["pkIbu"]);
    $hpIbu = htmlspecialchars($data["hpIbu"]);


    $result = mysqli_query($conn, "SELECT nis FROM siswa WHERE nis = '$nis'");
    if (mysqli_fetch_assoc($result)) {
        echo "<script> alert('Nis siswa sudah terdaftar!')</script>";
        return false;
    }

    $foto = upload();
    if (!$foto) {
        return false;
    }

    if ($email === '') {
        $email = '';
    }

    $queryKelas = mysqli_query($conn, "SELECT kelas.id as 'kelas_id', id_kelas, siswa.id as 'id', nis, nama, alamat, email,  foto, kelas.nmkelas as 'nama_kelas' FROM `siswa` LEFT JOIN kelas ON siswa.id_kelas = kelas.id");
    foreach ($queryKelas as $validasiKelas) {
        if ($validasiKelas['kelas_id'] != $validasiKelas['id_kelas']) {
            $id_kelas =  "Kelas belum ada";
        } else {
            $id_kelas = $id_kelas;
        }
    }


    $query = "INSERT INTO siswa(nis, nama, alamat, email, id_kelas, foto) VALUES('$nis', '$nama', '$alamat', '$email', '$id_kelas', '$foto')";

    mysqli_query($conn, $query);

    $id_siswa = mysqli_insert_id($conn);

    $qAyah = "INSERT INTO orang_tua_siswa(nama,keterangan,pekerjaan,no_hp,id_siswa) VALUES ('$nmAyah','ayah','$pkAyah','$hpAyah','$id_siswa')";
    $qIbu = "INSERT INTO orang_tua_siswa(nama,keterangan,pekerjaan,no_hp,id_siswa) VALUES ('$nmIbu','ibu','$pkIbu','$hpIbu','$id_siswa')";

    mysqli_query($conn, $qAyah);
    mysqli_query($conn, $qIbu);


    return mysqli_affected_rows($conn);
}

function upload()
{
    global $conn;

    $namafile = $_FILES['foto']['name'];
    $ukuranfile = $_FILES['foto']['size'];
    $error = $_FILES['foto']['error'];
    $tmpname = $_FILES['foto']['tmp_name'];

    if ($error === 4) {
        echo "<script>alert('Pilih foto dulu!')</script>";
        return false;
    }

    // ekstensi gambar
    $ekstensigambarvalid = ['jpg', 'jpeg', 'png'];
    $ekstensigambar = explode('.', $namafile);
    $ekstensigambar = strtolower(end($ekstensigambar));

    if (!in_array($ekstensigambar, $ekstensigambarvalid)) {
        echo "<script>alert('Upload foto dengan ekstensi jpg, jpeg, png!'); document.location.href='siswa.php';</script>";
        return false;
    }

    // ukuran gambar
    if ($ukuranfile > 3000000) {
        echo "<script>alert('Ukuran foto lebih dari 3 Mb!')</script>";
        return false;
    }

    // generate foto name
    $generatename = uniqid();
    $generatename .= '.';
    $generatename .= $ekstensigambar;

    // valid upload
    move_uploaded_file($tmpname, 'img/' . $generatename);
    return $generatename;
}

function tambah_kelas($data)
{
    global $conn;

    $nmkelas = htmlspecialchars($data["nmkelas"]);


    $result = mysqli_query($conn, "SELECT nmkelas FROM kelas WHERE nmkelas = '$nmkelas'");

    if (mysqli_fetch_assoc($result)) {
        echo "<script> alert('nama kelas sudah terdaftar!')</script>";
        return false;
    }

    $query = "INSERT INTO kelas (nmkelas)VALUES('$nmkelas')";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function hapus($id)
{
    global $conn;

    // get foto siswa by id
    $foto_siswa = query("SELECT foto FROM siswa WHERE id = $id")[0];
    $foto_siswa = $foto_siswa['foto'];

    // delete old foto siswa
    unlink('img/' . $foto_siswa);

    // delete data siswa
    mysqli_query($conn, "DELETE FROM siswa WHERE id = $id");

    return mysqli_affected_rows($conn);
}

function hapus_guru($id)
{
    global $conn;

    // delete data ortu
    mysqli_query($conn, "DELETE FROM guru WHERE id = $id");

    return mysqli_affected_rows($conn);
}

function hapus_kelas($id)
{
    global $conn;
    mysqli_query($conn, "DELETE FROM kelas WHERE id = $id ");

    return mysqli_affected_rows($conn);
}

function hapus_mapel($mp_id)
{
    global $conn;
    mysqli_query($conn, "DELETE FROM mapel WHERE id = $mp_id ");

    return mysqli_affected_rows($conn);
}

function hapus_jadwal_mapel($id)
{
    global $conn;
    mysqli_query($conn, "DELETE FROM jadwal_mapel WHERE id = $id ");

    return mysqli_affected_rows($conn);
}

function edit_guru($e)
{
    global $conn;

    $id = $e["id"];
    $nip = htmlspecialchars($e["nip"]);
    $nama = htmlspecialchars($e["nama"]);
    $umur = htmlspecialchars($e["umur"]);
    $telp = htmlspecialchars($e["telp"]);
    $alamat = htmlspecialchars($e["alamat"]);
    $thn_masuk = htmlspecialchars($e["thn_masuk"]);
    $status_guru = htmlspecialchars($e["status_guru"]);
    $fotolama = htmlspecialchars($e["fotolama"]);

    if ($_FILES['foto']['error'] === 4) {
        $foto = $fotolama;
    } else {
        $foto = upload();
        unlink('img/' . $fotolama);
    }

    $query = "UPDATE guru SET nip = '$nip', nama = '$nama', umur = '$umur', telp = '$telp', alamat = '$alamat', thn_masuk = '$thn_masuk', status_guru = '$status_guru', foto = '$foto' WHERE id = $id ";

    mysqli_query($conn, $query);

    return mysqli_errno($conn);
}

function edit($data)
{
    global $conn;


    $id = $data["id"];
    $nis = htmlspecialchars($data["nis"]);
    $nama = htmlspecialchars($data["nama"]);
    $alamat = htmlspecialchars($data["alamat"]);
    $email = htmlspecialchars($data["email"]);
    $kelas = htmlspecialchars($data["id_kelas"]);
    $fotolama = htmlspecialchars($data["fotolama"]);

    $nmAyah = htmlspecialchars($data["nmAyah"]);
    $pkAyah = htmlspecialchars($data["pkAyah"]);
    $hpAyah = htmlspecialchars($data["hpAyah"]);
    $nmIbu = htmlspecialchars($data["nmIbu"]);
    $pkIbu = htmlspecialchars($data["pkIbu"]);
    $hpIbu = htmlspecialchars($data["hpIbu"]);

    if ($_FILES['foto']['error'] === 4) {
        $foto = $fotolama;
    } else {
        $foto = upload();
        unlink('img/' . $fotolama);
    }

    if ($email === '') {
        $email = "Belum memiliki email";
    }

    $query = "UPDATE siswa SET nis = '$nis', nama = '$nama', alamat = '$alamat', email = '$email', id_kelas = '$kelas', foto = '$foto' WHERE id = $id ";
    $qAyah = "UPDATE orang_tua_siswa SET nama = '$nmAyah', pekerjaan = '$pkAyah', no_hp='$hpAyah' WHERE id_siswa = '$id' AND keterangan = 'ayah'";
    $qIbu = "UPDATE orang_tua_siswa SET nama = '$nmIbu', pekerjaan = '$pkIbu', no_hp='$hpIbu' WHERE id_siswa = '$id' AND keterangan = 'ibu'";

    // disini kita punya 2 data siswa 
    // 1. id 1 nama jajang nis 20
    // 2. id 2 nama agung nis 21

    // 1. kasus pertama : kita hanya ubah nama, tapi nis masih yg lama yaitu 20 dan id = 1
    // eksekusi kueri (jajang) :

    // apakah ada nis = 20 yg id nya != 1? // false

    // 2. kasus kedua : kita ubah nama dan kita ubah juga nis yg lama yaitu 20 menjadi 21 (jajang) :

    // apakah ada nis = 21 yg id nya != 1 // true

    $result = mysqli_query($conn, "SELECT nis FROM siswa WHERE nis = '$nis' AND id <> '$id'");

    if (mysqli_num_rows($result) > 0) {
        echo "<script>alert('Nis siswa sudah ada!');</script>";
        return mysqli_affected_rows($conn);
    }

    mysqli_query($conn, $qAyah);
    mysqli_query($conn, $qIbu);
    mysqli_query($conn, $query);

    return mysqli_errno($conn);

    //return mysqli_affected_rows($conn);
}

function edit_ortu($eortu)
{
    global $conn;

    $id = $eortu["id_siswa"];
    $nmAyah = htmlspecialchars($eortu["nmAyah"]);
    $pkAyah = htmlspecialchars($eortu["pkAyah"]);
    $hpAyah = htmlspecialchars($eortu["hpAyah"]);
    $nmIbu = htmlspecialchars($eortu["nmIbu"]);
    $pkIbu = htmlspecialchars($eortu["pkIbu"]);
    $hpIbu = htmlspecialchars($eortu["hpIbu"]);


    $query = "UPDATE orang_tua_siswa SET nama = '$nmAyah', pekerjaan = '$pkAyah', no_hp='$hpAyah' WHERE id_siswa = '$id' AND keterangan = 'ayah'";
    $query1 = "UPDATE orang_tua_siswa SET nama = '$nmIbu', pekerjaan = '$pkIbu', no_hp='$hpIbu' WHERE id_siswa = '$id' AND keterangan = 'ibu'";


    mysqli_query($conn, $query);
    mysqli_query($conn, $query1);

    return mysqli_errno($conn);
}

function edit_mapel($p)
{
    global $conn;

    $id = $p["id"];
    $nm_mapel = htmlspecialchars($p["nm_mapel"]);
    $result = mysqli_query($conn, "SELECT nm_mapel FROM mapel WHERE nm_mapel = '$nm_mapel'");
    if (mysqli_fetch_assoc($result)) {
        echo "<script> alert('nama mata pelajaran sudah terdaftar!')</script>";
        return false;
    }
    $query = "UPDATE mapel SET nm_mapel = '$nm_mapel' WHERE id = $id ";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function edit_kelas($data)
{
    global $conn;

    $id = $data["id"];
    $nmkelas = htmlspecialchars($data["nmkelas"]);
    $result = mysqli_query($conn, "SELECT nmkelas FROM kelas WHERE nmkelas = '$nmkelas'");
    if (mysqli_fetch_assoc($result)) {
        echo "<script> alert('nama kelas sudah terdaftar!')</script>";
        return false;
    }
    $query = "UPDATE kelas SET nmkelas = '$nmkelas' WHERE id = $id ";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

// function cari($keyword)
// {
//     //$query = "SELECT * FROM siswa WHERE nama LIKE '%$keyword%'";
//     $query = "SELECT kelas.id as kelas_id,  id_kelas, siswa.id as 'id', nis, nama, alamat, email,  foto, kelas.nmkelas as 'nama_kelas' FROM `siswa` 
//     LEFT JOIN kelas ON siswa.id_kelas = kelas.id 
//     WHERE siswa.nama LIKE '%$keyword%' OR kelas.nmkelas LIKE  '%$keyword%' OR siswa.nis LIKE  '%$keyword%' OR siswa.alamat LIKE  '%$keyword%' OR siswa.email LIKE  '%$keyword%' OR siswa.Ayah LIKE '%$keyword%' LIMIT $awalData, $jmlDataPerhalaman ";
//     return query($query);
// }

// function filters($filters)
// {
//     //$query = "SELECT * FROM siswa WHERE nama LIKE '%$keyword%'";
//     $query = "SELECT id_kelas, siswa.id as 'id', nis, nama, alamat, ortu, email,  foto, kelas.nmkelas as 'nama_kelas' FROM `siswa` 
//     LEFT JOIN kelas ON siswa.id_kelas = kelas.id 
//     WHERE id_kelas =  $filters";
//     $filters = intval($_GET['filters']);

//     $sql = "SELECT * FROM siswa WHERE id_kelas = '" . $filters . "'";
//     return query($query);
// }
