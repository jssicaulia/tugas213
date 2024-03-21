<?php
include "koneksi.php";

$host = "localhost";
$username = "root";
$password = "";
$database = "db_perawatan";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $no_pc = $_POST['no_pc'];
    $processor = $_POST['processor'];
    $ram = $_POST['ram'];
    $hardisk = $_POST['hardisk'];
    $monitor = $_POST['monitor'];
    $graphic = $_POST['graphic'];
    $mouse = $_POST['mouse'];
    $keyboard = $_POST['keyboard'];

    $sql = "INSERT INTO tb_spesifik (no_pc, processor, ram, hardisk, monitor, graphic, mouse, keyboard) 
            VALUES ('$no_pc', '$processor', '$ram', '$hardisk', '$monitor', '$graphic', '$mouse', '$keyboard')";

    if ($conn->query($sql) === TRUE) {
        echo "Data berhasil disimpan.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
