<?php
$koneksi = new mysqli("localhost", "root", "", "kampus");

$keyword = isset($_GET['keyword']) ? $koneksi->real_escape_string($_GET['keyword']) : '';

$sql = "SELECT id, nim, nama, jurusan FROM mahasiswa 
        WHERE nim LIKE '%$keyword%' OR nama LIKE '%$keyword%'";

$result = $koneksi->query($sql);
$data = [];

while ($row = $result->fetch_assoc()) {
  $data[] = $row;
}

header('Content-Type: application/json');
echo json_encode($data);
?>
