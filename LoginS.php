<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
 $username = $_POST["username"];
 $password = $_POST["password"];

 if ($username == "admin" && $password == "1234") {
 $_SESSION["username"] = $username;

 if (isset($_POST["remember"])) {
 setcookie("username", $username, time() + (86400 * 7), "/");
 }

 header("Location: dashboard.php");
 exit();
 } else {
 echo "Login gagal!";
 }
}
?>
<form method="POST">
 Username: <input type="text" name="username" required><br>
 Password: <input type="password" name="password" required><br>
 <input type="checkbox" name="remember"> Remember Me<br>
 <button type="submit">Login</button>
</form>
