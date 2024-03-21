<?php
include "koneksi.php";

$host = 'localhost';
$username = 'root';
$password = '';
$database = 'db_perawatan';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $no_ruangan_perawatan = isset($_POST['no_ruangan']) ? $_POST['no_ruangan'] : '';
    $tanggal = isset($_POST['tanggal']) ? htmlspecialchars($_POST['tanggal']) : '';
    $no_pc = isset($_POST['no_pc']) ? htmlspecialchars($_POST['no_pc']) : '';
    $servis = isset($_POST['servis']) ? htmlspecialchars($_POST['servis']) : '';
    $sparepart = isset($_POST['sparepart']) ? htmlspecialchars($_POST['sparepart']) : '';

    $paraf_filename = '';
    if (isset($_FILES['paraf']) && $_FILES['paraf']['error'] == 0) {
        $paraf_filename = 'paraf_' . time() . '_' . $_FILES['paraf']['name'];
        $paraf_destination = 'paraf/' . $paraf_filename;

        if (!file_exists('paraf/')) {
            mkdir('paraf/', 0777, true);
        }

        if (move_uploaded_file($_FILES['paraf']['tmp_name'], $paraf_destination)) {
            echo "File uploaded successfully.";
        } else {
            echo "Error uploading file.";
        }
    }

    $queryPerawatan = $conn->prepare("INSERT INTO tb_perawatan (tanggal, no_ruangan, no_pc, servis, sparepart, paraf) VALUES (?, ?, ?, ?, ?, ?)");
    $queryPerawatan->bind_param("ssssss", $tanggal, $no_ruangan_perawatan, $no_pc, $servis, $sparepart, $paraf_filename);

    if ($queryPerawatan->execute()) {
        echo "Data perawatan berhasil disimpan.";
    } else {
        echo "Error inserting perawatan: " . $queryPerawatan->error;
    }

    $queryPerawatan->close();
}
$conn->close();
?>
