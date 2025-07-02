<?php
$host     = "localhost";    
$user     = "root";         
$password = "";             
$database = "crud_db"; 

// membuat koneksi
$koneksi = mysqli_connect($host, $user, $password, $database);

// cek koneksi
if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>
