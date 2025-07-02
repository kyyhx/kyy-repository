<?php
session_start();
session_destroy();

// Hapus cookie juga
setcookie("user_id", "", time() - 3600);
setcookie("role", "", time() - 3600);

header("Location: login.php");
exit();
?>
