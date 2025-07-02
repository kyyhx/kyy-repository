<?php
include 'koneksi.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Cek token CSRF
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Akses tidak sah! Token CSRF tidak cocok.");
    }

    // Ambil dan sanitasi input
    $username = htmlspecialchars(trim($_POST['username']), ENT_QUOTES, 'UTF-8');
    $email    = htmlspecialchars(trim($_POST['email']), ENT_QUOTES, 'UTF-8');
    $password = $_POST['password'];

    // Validasi server-side (opsional tambahan)
    if (empty($username) || empty($email) || empty($password)) {
        die("Semua field wajib diisi!");
    }

    // Enkripsi password
    $passwordHash = password_hash($password, PASSWORD_BCRYPT);

    // Query menggunakan prepared statement
    $stmt = $koneksi->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    if (!$stmt) {
        die("Query error: " . $koneksi->error);
    }

    $stmt->bind_param("sss", $username, $email, $passwordHash);

    try {
        $stmt->execute();
        header("Location: success.php");
    } catch (mysqli_sql_exception $e) {
        echo "Pendaftaran gagal: " . $e->getMessage();
    }

    $stmt->close();
}
?>
