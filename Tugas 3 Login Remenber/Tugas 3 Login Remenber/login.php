<?php
session_start();
include "koneksi.php"; // Pastikan file ini ada dan benar

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST["username"];
  $password = $_POST["password"];
  $remember = isset($_POST["remember"]);

  $stmt = $conn->prepare("SELECT id, password, role FROM users WHERE username = ?");
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    if (password_verify($password, $user["password"])) {
      $_SESSION["user_id"] = $user["id"];
      $_SESSION["role"] = $user["role"];

      if ($remember) {
        setcookie("user_id", $user["id"], time() + (86400 * 7));
        setcookie("role", $user["role"], time() + (86400 * 7));
      }

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
  Username: <input type="text" name="username" required><br>
  Password: <input type="password" name="password" required><br>
  <label><input type="checkbox" name="remember"> Remember Me</label><br>
  <button type="submit">Login</button>
</form>
