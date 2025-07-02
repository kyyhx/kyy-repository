<?php
include 'config.php';
$id = $_GET['id'];
$koneksi->query("DELETE FROM users WHERE id=$id");
header("Location: index.php");
?>
