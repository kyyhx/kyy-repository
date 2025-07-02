<?php
include "koneksi.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $file = $_FILES['gambar'];
    $maxSize = 1 * 1024 * 1024;
    $allowedExt = ['jpg', 'jpeg', 'png'];
    $uploadDir = 'uploads/full/';
    $thumbDir = 'uploads/thumbs/';

    if ($file['error'] !== 0) {
        die("Terjadi kesalahan saat upload.");
    }

    if ($file['size'] > $maxSize) {
        die("Ukuran file maksimal 1MB.");
    }

    $fileInfo = pathinfo($file['name']);
    $ext = strtolower($fileInfo['extension']);
    if (!in_array($ext, $allowedExt)) {
        die("Hanya file JPG, JPEG, dan PNG yang diperbolehkan.");
    }

    $mime = mime_content_type($file['tmp_name']);
    if (!in_array($mime, ['image/jpeg', 'image/png'])) {
        die("Tipe MIME tidak sesuai.");
    }

    $newName = uniqid() . '.' . $ext;
    $fullPath = $uploadDir . $newName;
    $thumbPath = $thumbDir . $newName;

    move_uploaded_file($file['tmp_name'], $fullPath);

    list($width, $height) = getimagesize($fullPath);
    $newWidth = 200;
    $newHeight = floor($height * ($newWidth / $width));
    $thumbImg = imagecreatetruecolor($newWidth, $newHeight);

    if ($ext == 'jpg' || $ext == 'jpeg') {
        $srcImg = imagecreatefromjpeg($fullPath);
    } else {
        $srcImg = imagecreatefrompng($fullPath);
    }

    imagecopyresampled($thumbImg, $srcImg, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
    imagejpeg($thumbImg, $thumbPath, 80);

    $stmt = $conn->prepare("INSERT INTO gambar (filename, filepath, thumbpath, width, height) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssii", $newName, $fullPath, $thumbPath, $width, $height);
    $stmt->execute();

    echo "Upload berhasil! <a href='galeri.php'>Lihat Galeri</a>";
}
?>

<form method="post" enctype="multipart/form-data">
    <label>Pilih Gambar (max 1MB):</label>
    <input type="file" name="gambar" required>
    <button type="submit">Upload</button>
</form>
