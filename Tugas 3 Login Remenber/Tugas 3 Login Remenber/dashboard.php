<?php
session_start();

// Jika session belum ada, cek cookie
if (!isset($_SESSION["user_id"])) {
  if (isset($_COOKIE["user_id"])) {
    $_SESSION["user_id"] = $_COOKIE["user_id"];
    $_SESSION["role"] = $_COOKIE["role"];
  } else {
    header("Location: login.php");
    exit();
  }
}
?>

<h2>Selamat datang di Dashboard!</h2>
<p>Role Anda: <?php echo $_SESSION["role"]; ?></p>

<?php if ($_SESSION["role"] == "admin"): ?>
  <p>Ini tampilan admin</p>
<?php else: ?>
  <p>Ini tampilan user biasa</p>
<?php endif; ?>

<a href="logout.php">Logout</a>
