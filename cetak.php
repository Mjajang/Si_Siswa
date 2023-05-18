<?php
include_once('lib/fpdf185/fpdf.php');
include 'functions.php';

$sql = $conn->query("SELECT id_kelas, siswa.id as 'id', nis, nama, alamat, email, kelas.nmkelas as 'nama_kelas' FROM `siswa` LEFT JOIN kelas ON siswa.id_kelas = kelas.id");

$pdf = new FPDF();
$pdf->AddPage('L', 'A4');
$pdf->SetFont('Arial', 'B', 16);


$pdf->Cell(120);
$pdf->Cell(30, 10, 'Data Siswa');

$pdf->Cell(10, 7, '', 0, 1);
$pdf->Ln(10);

$pdf->Cell(20);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(10, 6, 'No', 1, 0);
$pdf->Cell(25, 6, 'NIS', 1, 0);
$pdf->Cell(40, 6, 'NAMA SISWA', 1, 0);
$pdf->Cell(60, 6, 'ALAMAT', 1, 0);
$pdf->Cell(55, 6, 'EMAIL', 1, 0);
$pdf->Cell(20, 6, 'KELAS', 1, 1);
$pdf->SetFont('Arial', '', 10);
$i = 1;
while ($data = $sql->fetch_assoc()) {
  // $mahasiswa = mysqli_query($connect, "select * from akta");
  // while ($row = mysqli_fetch_array($mahasiswa)){
  $pdf->Cell(20);
  $pdf->Cell(10, 10, $i, 1, 0, 'C');
  $pdf->Cell(25, 10, $data['nis'], 1, 0);
  $pdf->Cell(40, 10, $data['nama'], 1, 0);
  $pdf->Cell(60, 10, $data['alamat'], 1, 0);
  $pdf->Cell(55, 10, $data['email'], 1, 0);
  $pdf->Cell(20, 10, $data['nama_kelas'], 1, 1);
  $i++;
}
$pdf->Output();
