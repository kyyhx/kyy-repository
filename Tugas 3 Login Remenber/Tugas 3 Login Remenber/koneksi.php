<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "loginregister"; // pastikan ini sesuai dengan database kamu

// Buat koneksi
$conn = new mysqli($host, $user, $pass, $db);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
