<?php
include 'config.php';
$id = $_GET['id'];

$result = mysqli_query($koneksi, "SELECT * FROM users WHERE id = $id");
$row = mysqli_fetch_assoc($result);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $passw = $_POST['passw'];

    mysqli_query($koneksi, "UPDATE users SET name='$name', email='$email', passw='$passw' WHERE id = $id");
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html>
<body>
    <h2>Edit Pengguna</h2>
    <form method="POST">
        Nama: <input type="text" name="name" value="<?= $row['name'] ?>" required><br>
        Email: <input type="email" name="email" value="<?= $row['email'] ?>" required><br>
        Password: <input type="password" name="passw" value="<?= $row['passw'] ?>" required><br>
        <button type="submit">Update</button>
    </form>
</body>
</html>
