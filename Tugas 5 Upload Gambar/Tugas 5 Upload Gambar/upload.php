<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $file = $_FILES['gambar'];
    $allowed = ['jpg', 'jpeg', 'png', 'gif'];
    $max_size = 2 * 1024 * 1024; // 2 MB

    $file_name = basename($file['name']);
    $file_tmp  = $file['tmp_name'];
    $file_size = $file['size'];
    $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    // Validasi: apakah file gambar
    $check = getimagesize($file_tmp);
    if ($check === false) {
        echo "File bukan gambar.";
        exit;
    }

    // Validasi ekstensi file
    if (!in_array($ext, $allowed)) {
        echo "Hanya file JPG, JPEG, PNG & GIF yang diperbolehkan.";
        exit;
    }

    // Validasi ukuran file
    if ($file_size > $max_size) {
        echo "Ukuran file terlalu besar. Maksimum 2MB.";
        exit;
    }

    // Validasi MIME
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $file_tmp);
    if (!in_array($mime, ['image/jpeg', 'image/png', 'image/gif'])) {
        echo "Tipe MIME tidak sesuai.";
        exit;
    }

    // Buat folder jika belum ada
    if (!is_dir('uploads')) mkdir('uploads', 0777, true);
    if (!is_dir('uploads/resized')) mkdir('uploads/resized', 0777, true);
    if (!is_dir('uploads/thumbs')) mkdir('uploads/thumbs', 0777, true);

    // Simpan file asli ke folder uploads/
    $newname = uniqid() . '.' . $ext;
    $filepath = 'uploads/' . $newname;
    move_uploaded_file($file_tmp, $filepath);

    // Ambil ukuran asli
    list($width, $height) = getimagesize($filepath);

    // Buat image resource dari file
    switch ($ext) {
        case 'jpg':
        case 'jpeg':
            $src = imagecreatefromjpeg($filepath);
            break;
        case 'png':
            $src = @imagecreatefrompng($filepath); // suppress warning iCCP
            break;
        case 'gif':
            $src = imagecreatefromgif($filepath);
            break;
        default:
            echo "Format tidak didukung.";
            exit;
    }

    // Resize image (500px lebar)
    $new_width = 500;
    $new_height = floor($height * ($new_width / $width));
    $resized = imagecreatetruecolor($new_width, $new_height);
    imagecopyresampled($resized, $src, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
    $resized_path = 'uploads/resized/' . $newname;
    imagejpeg($resized, $resized_path, 80); // compression

    // Buat thumbnail (150px lebar)
    $thumb_width = 150;
    $thumb_height = floor($height * ($thumb_width / $width));
    $thumb = imagecreatetruecolor($thumb_width, $thumb_height);
    imagecopyresampled($thumb, $src, 0, 0, 0, 0, $thumb_width, $thumb_height, $width, $height);
    $thumb_path = 'uploads/thumbs/' . $newname;
    imagejpeg($thumb, $thumb_path, 80);

    // Simpan ke database
    $stmt = $conn->prepare("INSERT INTO gambar (filename, filepath, thumbpath, width, height) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssii", $file_name, $resized_path, $thumb_path, $width, $height);
    $stmt->execute();

    echo "Upload berhasil. <a href='galeri.php'>Lihat Galeri</a>";
}
?>

<!-- Form Upload -->
<!DOCTYPE html>
<html>
<head>
    <title>Upload Gambar</title>
</head>
<body>
    <h2>Upload Gambar</h2>
    <form method="post" enctype="multipart/form-data">
        Pilih gambar: <input type="file" name="gambar" required><br><br>
        <input type="submit" value="Upload">
    </form>
</body>
</html>
