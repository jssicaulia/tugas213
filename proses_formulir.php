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
    // Update 'tb_ruangan'
    $nama_ruangan = isset($_POST['nama']) ? htmlspecialchars($_POST['nama']) : '';
    $kelas = isset($_POST['kelas']) ? htmlspecialchars($_POST['kelas']) : '';
    $no_ruangan = isset($_POST['no_ruangan']) ? htmlspecialchars($_POST['no_ruangan']) : '';
    
    $sqlUpdateRuangan = $conn->prepare("UPDATE tb_ruangan SET nama=?, kelas=? WHERE no_ruangan=?");
    $sqlUpdateRuangan->bind_param("ssi", $nama_ruangan, $kelas, $no_ruangan);

    if ($sqlUpdateRuangan->execute()) {
        echo "Data ruangan berhasil diupdate";
    } else {
        echo "Error updating ruangan: " . $sqlUpdateRuangan->error;
    }
    
    $sqlUpdateRuangan->close();
}
$conn->close();
?>
