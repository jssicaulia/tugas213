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

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];

    $result = $conn->query("SELECT * FROM tb_ruangan WHERE no_ruangan='$id'");

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nama = $row['nama'];
        $kelas = $row['kelas'];
        $ruangan = $row['no_ruangan'];
    } else {
        echo "Data tidak ditemukan";
        exit;
    }
} else {
    echo "Permintaan tidak valid";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $nama = $_POST['nama'];
    $kelas = $_POST['kelas'];
    $ruangan = $_POST['no_ruangan'];

    $sql = "UPDATE tb_ruangan SET nama='$nama', kelas='$kelas' WHERE no_ruangan='$ruangan'";

    if ($conn->query($sql) === TRUE) {
        echo "Data berhasil diperbarui";
    } else {
        echo "Error in SQL query: " . $sql . "<br>Error details: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data</title>
    <style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f2f2f2;
        color: #333;
        margin: 0;
        padding: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100vh;
    }

    form {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        width: 300px;
        text-align: left;
        margin-bottom: 20px;
    }

    label {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin: 10px 0;
        color: #555;
    }

    input {
        width: calc(100% - 10px);
        padding: 8px;
        box-sizing: border-box;
        border: 1px solid #ccc;
        border-radius: 4px;
        background-color: #f8f8f8;
        color: #333;
    }

    input[type="submit"] {
        background-color: #4CAF50;
        color: #fff;
        cursor: pointer;
        margin-top: 10px;
    }

    input[type="submit"]:hover {
        background-color: #45a049;
    }

    h2 {
        color: #333;
        margin-bottom: 20px;
    }

    </style>
</head>

<body>
    <h2>Edit Data</h2>
    <form action="proses_formulir.php" method="post">
    <input type="hidden" name="id" value="<?php echo $row['no_ruangan']; ?>">
    <label for="nama">Nama: <input type="text" name="nama" value="<?php echo $row['nama']; ?>" required></label>
    <label for="kelas">Kelas: <input type="text" name="kelas" value="<?php echo $row['kelas']; ?>" required></label>
    <label for="ruangan">No. Ruangan: <input type="int" name="no_ruangan" value="<?php echo $row['no_ruangan']; ?>" required></label>
    <input type="submit" value="Submit">
</form>
</body>

</html>
