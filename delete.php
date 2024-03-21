<?php
include "koneksi.php"; // Sesuaikan dengan file koneksi yang Anda miliki

$host = 'localhost';
$username = 'root';
$password = '';
$database = 'db_perawatan';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM tb_ruangan WHERE no_ruangan='$id'";

    if ($conn->query($sql) === TRUE) {
        echo "Data berhasil dihapus";
    } else {
        echo "Error in SQL query: " . $sql . "<br>Error details: " . $conn->error;
    }
} else {
    echo "Permintaan tidak valid";
}

$conn->close();
?>
