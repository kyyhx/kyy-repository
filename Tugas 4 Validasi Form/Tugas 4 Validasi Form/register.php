<?php include 'config.php'; ?>
<!DOCTYPE html>
<html>
<head>
  <title>Form Pendaftaran Aman</title>
  <script>
    function validateForm() {
      const username = document.forms["regForm"]["username"].value;
      const email = document.forms["regForm"]["email"].value;
      const password = document.forms["regForm"]["password"].value;

      if (username === "" || email === "" || password === "") {
        alert("Semua field wajib diisi!");
        return false;
      }

      const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailPattern.test(email)) {
        alert("Format email tidak valid!");
        return false;
      }

      return true;
    }
  </script>
</head>
<body>
  <h2>Form Pendaftaran Aman</h2>
  <form name="regForm" action="proses_register.php" method="POST" onsubmit="return validateForm();">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
    Username: <input type="text" name="username"><br><br>
    Email: <input type="email" name="email"><br><br>
    Password: <input type="password" name="password"><br><br>
    <button type="submit">Daftar</button>
  </form>
</body>
</html>
