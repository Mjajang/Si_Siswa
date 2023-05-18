<?php
include 'functions.php';
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Reader\Xml\Style\Font;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

$styleJudul = [
  'font' => [
    'color' => [
      'rgb' => 'FFFFFF'
    ],
    'bold' => true,
    'size' => 12
  ],
  'fill' => [
    'fillType' =>  fill::FILL_SOLID,
    'startColor' => [
      'rgb' => 'e74c3c'
    ]
  ],
  'alignment' => [
    'horizontal' => Alignment::HORIZONTAL_CENTER
  ]

];

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$spreadsheet->getActiveSheet()
  ->setCellValue('A1', "Daftar Siswa");
$spreadsheet->getActiveSheet()
  ->mergeCells("A1:G1");
$spreadsheet->getActiveSheet()
  ->getStyle('A1')
  ->getFont()
  ->setSize(20);
$spreadsheet->getActiveSheet()
  ->getStyle('A1')
  ->getAlignment()
  ->setHorizontal(Alignment::HORIZONTAL_CENTER);

foreach (range('B', 'F') as $width) {
  $spreadsheet->getActiveSheet()->getColumnDimension($width)->setAutoSize(true);
}

$spreadsheet->getActiveSheet()
  ->setCellValue('A2', 'No')
  ->setCellValue('B2', 'NIS')
  ->setCellValue('C2', 'NAMA')
  ->setCellValue('D2', 'ALAMAT')
  ->setCellValue('E2', 'EMAIL')
  ->setCellValue('F2', 'KELAS');

$spreadsheet->getActiveSheet()
  ->getStyle('A2:F2')
  ->applyFromArray($styleJudul);

$data = mysqli_query($conn, "SELECT kelas.id as kelas_id,  id_kelas, siswa.id as 'id', nis, nama, alamat, email, kelas.nmkelas as 'nama_kelas' FROM `siswa` 
LEFT JOIN kelas ON siswa.id_kelas = kelas.id ");

$i = 3;
$no = 1;
foreach ($data as $row) {
  $spreadsheet->getActiveSheet()
    ->setCellValue('A' . $i, $no++)
    ->setCellValue('B' . $i, $row["nis"])
    ->setCellValue('C' . $i, $row["nama"])
    ->setCellValue('D' . $i, $row["alamat"])
    ->setCellValue('E' . $i, $row["email"])
    ->setCellValue('F' . $i, $row["nama_kelas"]);
  $i++;
}



$writer = new Xlsx($spreadsheet);
$writer->save('Data-Siswa.xlsx');
echo "<script>window.location = 'Data-Siswa.xlsx'</script>";
