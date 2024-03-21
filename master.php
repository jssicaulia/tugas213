<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Perawatan</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #cce6ff;
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
            background-color: #ffffcc;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: left;
            margin-bottom: 20px;
        }

        table {
            width: 80%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #002b80;
            color: white;
            text_align: center;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
            text-align: center;
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
            background-color: #002b80;
            color: #fff;
            cursor: pointer;
            margin-top: 10px;
        }

        .action-buttons {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .edit-button,
        .delete-button,
        .spesifikasi-button,
        .perawatan-button {
            background-color: #002b80;
            color: #fff;
            padding: 5px;
            border: none;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <?php
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "db_perawatan";

    $conn = new mysqli($host, $username, $password, $database);

    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nama = $_POST['nama'];
        $kelas = $_POST['kelas'];
        $ruangan = $_POST['no_ruangan'];

        $sql = "INSERT INTO tb_ruangan (nama, kelas, no_ruangan) VALUES ('$nama', '$kelas', '$ruangan')";

        if ($conn->query($sql) === TRUE) {
            echo "Data berhasil disimpan ke dalam tabel tb_ruangan.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    $result = $conn->query("SELECT * FROM tb_ruangan");

    $conn->close();
    ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <h2>FORM PERAWATAN</h2>
        <label for="nama">Nama: <input type="text" name="nama" required></label>
        <label for="kelas">Kelas: <input type="text" name="kelas" required></label>
        <label for="ruangan">No. Ruangan: <input type="int" name="no_ruangan" required></label>
        <input type="submit" value="Submit">
    </form>

    <table>
        <tr>
            <th>Nama</th>
            <th>Kelas</th>
            <th>No. Ruangan</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) : ?>
            <tr>
                <td><?php echo $row['nama']; ?></td>
                <td><?php echo $row['kelas']; ?></td>
                <td><?php echo $row['no_ruangan']; ?></td>
                <td class="action-buttons">
                    <form action="edit.php" method="get">
                        <input type="hidden" name="id" value="<?php echo $row['no_ruangan']; ?>">
                        <button type="submit" class="edit-button">Edit</button>
                    </form>

                    <form action="delete.php" method="get">
                        <input type="hidden" name="id" value="<?php echo $row['no_ruangan']; ?>">
                        <button type="submit" class="delete-button">Delete</button>
                    </form>

                    <form action="spesifikasi.php" method="get">
                        <input type="hidden" name="id" value="<?php echo $row['no_ruangan']; ?>">
                        <button type="submit" class="spesifikasi-button">Spesifikasi</button>
                    </form>

                    <form action="perawatan.php" method="get" >
                        <input type="hidden" name="id" value="<?php echo $row['no_ruangan']; ?>">
                        <button type="submit" class="perawatan-button">Perawatan</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>

</html>
