<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Galeri Gambar</title>
    <style>
        .gallery { display: flex; flex-wrap: wrap; gap: 15px; }
        .gallery-item { border: 1px solid #ccc; padding: 10px; text-align: center; width: 220px; }
        img { width: 200px; height: auto; }
    </style>
</head>
<body>

<h2>Galeri Gambar</h2>
<div class="gallery">
<?php
$sql = "SELECT * FROM gambar ORDER BY uploaded_at DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<div class='gallery-item'>";
        echo "<img src='" . $row['thumbpath'] . "' alt='Thumbnail'>";
        echo "<p>Ukuran: {$row['width']}x{$row['height']}</p>";
        echo "<p><a href='" . $row['filepath'] . "' target='_blank'>Lihat Asli</a></p>";
        echo "</div>";
    }
} else {
    echo "<p>Belum ada gambar.</p>";
}
$conn->close();
?>
</div>

</body>
</html>
