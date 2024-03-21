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

// Fungsi untuk menghapus data berdasarkan id
if (isset($_GET['delete'])) {
    $idToDelete = $_GET['delete'];
    $deleteSql = "DELETE FROM tb_spesifik WHERE no_pc='$idToDelete'";

    if ($conn->query($deleteSql) === TRUE) {
        echo "Data berhasil dihapus.";
    } else {
        echo "Error: " . $deleteSql . "<br>" . $conn->error;
    }
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

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Spesifikasi</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #cce6ff;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
        }

        h2 {
            margin: 0;
            font-size: 24px;
        }

        form {
            background-color: #ffffcc;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-size: 16px;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }

        input[type="submit"] {
            background-color: #002b80;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        table {
            border-collapse: collapse;
            width: 80%;
            margin-top: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
            text-align: left;
        }

        th,
        td {
            padding: 8px;
        }

        th {
            background-color: #002b80;
            color: white;
        }
    </style>
</head>

<body>
    <form action="proses_formulir2.php" method="post">
        <h2>SPESIFIKASI PC</h2>
        <center>
            <?php
            $resultPerawatan = $conn->query("SELECT * FROM tb_perawatan");

            if ($resultPerawatan !== false) {
                if ($resultPerawatan->num_rows > 0) {
                    echo '<div class="perawatan-info">';
                    echo '<label for="no_pc">Data Perawatan:</label>';
                    echo '<select id="no_pc" name="no_pc">';
                    while ($rowPerawatan = $resultPerawatan->fetch_assoc()) {
                        echo '<option value="' . $rowPerawatan['no_pc'] . '">';
                        echo $rowPerawatan['tanggal'] . ' - ' . $rowPerawatan['no_ruangan'] . ' - ' . $rowPerawatan['no_pc'] . ' - ' . $rowPerawatan['servis'];
                        echo '</option>';
                    }
                    echo '</select>';
                    echo '</div>';
                } else {
                    echo 'Tidak ada data.';
                }
            } else {
                echo 'Error saat mengambil data dari tb_perawatan.';
            }
            ?>
        </center>

        <label for="no_pc">No PC:</label>
        <input type="int" id="selected_perawatan" name="no_pc">

        <label for="processor">Processor:</label>
        <input type="text" name="processor" required><br>

        <label for="ram">RAM:</label>
        <input type="text" name="ram" required><br>

        <label for="hardisk">Hardisk:</label>
        <input type="text" name="hardisk" required><br>

        <label for="monitor">Monitor:</label>
        <input type="text" name="monitor" required><br>

        <label for="graphic">Graphic:</label>
        <input type="text" name="graphic" required><br>

        <label for="mouse">Mouse:</label>
        <input type="text" name="mouse" required><br>

        <label for="keyboard">Keyboard:</label>
        <input type="text" name="keyboard" required><br>

        <input type="submit" value="Submit">
    </form>

    <?php
    $result = $conn->query("SELECT tb_spesifik.*, tb_perawatan.* FROM tb_spesifik LEFT JOIN tb_perawatan ON tb_spesifik.no_pc = tb_perawatan.no_pc");

    if ($result->num_rows > 0) {
        echo "<table>
                <tr>
                    <th>No PC</th>
                    <th>Processor</th>
                    <th>RAM</th>
                    <th>Hardisk</th>
                    <th>Monitor</th>
                    <th>Graphic</th>
                    <th>Mouse</th>
                    <th>Keyboard</th>
                    <th>Action</th>
                </tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['no_pc']}</td>
                    <td>{$row['processor']}</td>
                    <td>{$row['ram']}</td>
                    <td>{$row['hardisk']}</td>
                    <td>{$row['monitor']}</td>
                    <td>{$row['graphic']}</td>
                    <td>{$row['mouse']}</td>
                    <td>{$row['keyboard']}</td>
                    <td>
                        <a href='spesifikasi.php?delete={$row['no_pc']}'>Delete</a>
                        <!-- Link ke halaman edit bisa ditambahkan di sini -->
                    </td>
                </tr>";
        }
        echo "</table>";
    } else {
        echo "Tidak ada data.";
    }

    $conn->close();
    ?>

    <script>
        document.getElementById('no_pc').addEventListener('change', function () {
            document.getElementById('selected_perawatan').value = this.value;
        });
    </script>

</body>

</html>
