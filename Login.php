<?php
session_start();
include "koneksi.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
 $username = $_POST["username"];
 $password = $_POST["password"];
 $stmt = $conn->prepare("SELECT id, password FROM users WHERE
username = ?");
 $stmt->bind_param("s", $username);
 $stmt->execute();
 $result = $stmt->get_result();
 if ($result->num_rows === 1) {
 $user = $result->fetch_assoc();
 if (password_verify($password, $user["password"])) {
 $_SESSION["user_id"] = $user["id"]; // Simpan session
 header("Location: dashboard.php");
 exit();
 } else {
 echo "Password salah!";
 }
 } else {
 echo "Username tidak ditemukan!";
 }
 $stmt->close();
 $conn->close();
}
?>
<form method="POST">
 Username: <input type="text" name="username" required>
 Password: <input type="password" name="password" required>
 <button type="submit">Login</button>
</form>
 4. Membuat Dashboard yang Hanya