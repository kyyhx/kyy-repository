<?php
include "koneksi.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
 $username = $_POST["username"];
 $password = password_hash($_POST["password"],
PASSWORD_DEFAULT); // Hash password
 $stmt = $conn->prepare("INSERT INTO users (username, password)
VALUES (?, ?)");
 $stmt->bind_param("ss", $username, $password);

 if ($stmt->execute()) {
 echo "Registrasi berhasil!";
 } else {
 echo "Gagal mendaftar!";
 }
 $stmt->close();
 $conn->close();
}
?>
<form method="POST">
 Username: <input type="text" name="username" required>
 Password: <input type="password" name="password" required>
 <button type="submit">Daftar</button>
</form>