<?php
$conn = new mysqli("localhost","root","","tugaspraktek");
if ($conn->connect_error){
    die("koneksi gagal:".
    $conn->connect_error);
}
?>