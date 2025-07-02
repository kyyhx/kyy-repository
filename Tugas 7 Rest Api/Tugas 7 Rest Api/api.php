<?php
header("Content-Type: application/json");
require 'db.php';

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        $sql = "SELECT * FROM mahasiswa";
        $result = $koneksi->query($sql);
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        echo json_encode($data);
        break;

    case 'POST':
        $input = json_decode(file_get_contents("php://input"), true);
        $nama = $input['nama'];
        $nim = $input['nim'];
        $jurusan = $input['jurusan'];
        $sql = "INSERT INTO mahasiswa (nim, nama, jurusan) VALUES ('$nim', '$nama', '$jurusan')";
        
        if ($koneksi->query($sql)) {
            echo json_encode(['status' => true, 'message' => 'Data berhasil ditambahkan']);
        } else {
            http_response_code(500);
            echo json_encode(['status' => false, 'message' => 'Gagal menambahkan data']);
        }
        break;

case 'PUT':
    $input = json_decode(file_get_contents("php://input"), true);

    if (isset($input['id']) && isset($input['nama']) && isset($input['nim']) && isset($input['jurusan'])) {
        $id = intval($input['id']);
        $nama = $input['nama'];
        $nim = $input['nim'];
        $jurusan = $input['jurusan'];
        
        $sql = "UPDATE mahasiswa SET nama='$nama', nim='$nim', jurusan='$jurusan' WHERE id=$id";
        
        if ($koneksi->query($sql)) {
            echo json_encode(['status' => true, 'message' => 'Data berhasil diubah']);
        } else {
            http_response_code(500);
            echo json_encode(['status' => false, 'message' => 'Gagal mengubah data']);
        }
    } else {
        http_response_code(400);
        echo json_encode(['status' => false, 'message' => 'Data tidak lengkap untuk update']);
    }
    break;


    case 'DELETE':
        $input = json_decode(file_get_contents("php://input"), true);
        if (isset($input['id'])) {
            $id = intval($input['id']);
            $sql = "DELETE FROM mahasiswa WHERE id=$id";
            
            if ($koneksi->query($sql)) {
                echo json_encode(['status' => true, 'message' => 'Data berhasil dihapus']);
            } else {
                http_response_code(500);
                echo json_encode(['status' => false, 'message' => 'Gagal menghapus data']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['status' => false, 'message' => 'ID tidak diberikan']);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(['error' => 'Method Not Allowed']);
        break;
}
?>
