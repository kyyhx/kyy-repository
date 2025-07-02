<?php
include "koneksi.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST["username"];
  $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
  $role = $_POST["role"];

  $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
  $stmt->bind_param("sss", $username, $password, $role);

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
  Username: <input type="text" name="username" required><br>
  Password: <input type="password" name="password" required><br>
  Role:
  <select name="role">
    <option value="user">User</option>
    <option value="admin">Admin</option>
  </select><br>
  <button type="submit">Daftar</button>
</form>
