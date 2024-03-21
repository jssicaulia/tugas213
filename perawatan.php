<?php
include "koneksi.php";

$tanggal = $servis = $sparepart = $paraf = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = htmlspecialchars($_POST['no']);
    $tanggal = htmlspecialchars($_POST['tanggal']);
    $servis = htmlspecialchars($_POST['servis']);
    $sparepart = htmlspecialchars($_POST['sparepart']);

    $paraf_filename = '';
    if (isset($_FILES['paraf']) && $_FILES['paraf']['error'] == 0) {
        $paraf_filename = 'paraf_' . time() . '_' . $_FILES['paraf']['name'];
        $paraf_destination = '/paraf/' . $paraf_filename;
        move_uploaded_file($_FILES['paraf']['tmp_name'], $paraf_destination);
    }

    $query = "INSERT INTO tb_perawatan (no, tanggal, servis, sparepart, paraf) 
          VALUES ('$id', '$tanggal', '$servis', '$sparepart', '$paraf_filename')";

    if ($conn->query($query) === TRUE) {
        echo "Data berhasil disimpan.";
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }
}

$resultRuangan = $conn->query("SELECT * FROM tb_ruangan");
$conn->close();
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #cce6ff;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #ffffcc;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input,
        textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #002b80;
            color: #fff;
            cursor: pointer;
        }

        input[type="file"] {
            margin-top: 5px;
        }

        .ruangan-info {
            margin-top: 20px;
        }

        table {
            background-color: white;
            padding: 20px;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 5px;
        }
    </style>
    <title>Formulir Servis</title>
</head>

<body>

    <div class="container">
        <h2>KARTU PERAWATAN FORMULIR PERSONAL COMPUTER (PC)</h2>
        <center><?php
            if ($resultRuangan !== false) {
                if ($resultRuangan->num_rows > 0) {
                    echo '<div class="ruangan-info">';
                    echo '<label for="ruangan">Pilih Ruangan:</label>';
                    echo '<select id="ruangan" name="ruangan">';
                    while ($rowRuangan = $resultRuangan->fetch_assoc()) {
                        echo '<option value="' . $rowRuangan['no_ruangan'] . '">';
                        echo $rowRuangan['nama'] . ' - ' . $rowRuangan['kelas'] . ' - ' . $rowRuangan['no_ruangan'];
                        echo '</option>';
                    }
                    echo '</select>';
                    echo '</div>';
                } else {
                    echo 'Tidak ada data ruangan.';
                }
            } else {
                echo 'Error saat mengambil data dari tb_ruangan.';
            }
    ?></center>

        <form action="proses_formulir1.php" method="post" enctype="multipart/form-data">

            <label for="tanggal">Tanggal:</label>
            <input type="date" id="tanggal" name="tanggal" required>

            <label for="no_pc">No PC:</label>
            <input type="int" id="no_pc" name="no_pc" required>

            <label for="servis">Servis/Perawatan:</label>
            <textarea id="servis" name="servis" rows="4" required></textarea>

            <label for="sparepart">Penggantian Sparepart:</label>
            <textarea id="sparepart" name="sparepart" rows="4" required></textarea>

            <label for="paraf">Paraf:</label>
            <input type="file" id="paraf" name="paraf" accept="/paraf/*" required>

            <input type="submit" value="Submit">
        </form>
    </div>

    <center>
        <?php
        $host = 'localhost';
        $username = 'root';
        $password = '';
        $database = 'db_perawatan';
        $conn = new mysqli($host, $username, $password, $database);

        $result = $conn->query("SELECT * FROM tb_perawatan");

        if ($result !== false && $result->num_rows > 0) {
            echo '<table >';
            echo '<thead><tr><th>Tanggal</th><th> No.Ruangan</th><th>No.PC </th><th>Servis/Perawatan</th><th>Penggantian Sparepart</th><th>Paraf</th></tr></thead>';
            echo '<tbody>';
            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $row['tanggal'] . '</td>';
                echo '<td>' . $row['no_ruangan'] . '</td>';
                echo '<td>' . $row['no_pc'] . '</td>';
                echo '<td>' . $row['servis'] . '</td>';
                echo '<td>' . $row['sparepart'] . '</td>';
                echo '<td>' . $row['paraf'] . '</td>';
                echo '</tr>';
            }
            echo '</tbody></table>';
        } else {
            echo 'Tidak ada data.';
        }
        ?>
    </center>

    <h2>Update</h2>
    <form method="post">
        <label for="tanggal">Tanggal:</label>
        <input type="date" name="tanggal" required><br>

        <label for="no_pc">No. PC:</label>
        <input type="int" name="no_pc" required><br>

        <label for="servis">Servis/Perawatan:</label>
        <input type="text" name="servis" required><br>

        <label for="sparepart">Penggantian Sparepart:</label>
        <input type="text" name="sparepart" required><br>

        <label for="paraf">Paraf:</label>
        <input type="text" name="paraf" required><br>
        <br>

        <input type="submit" value="Update">
    </form>

    <script>
        document.getElementById('ruangan').addEventListener('change', function () {
            document.getElementById('selected_ruangan').value = this.value;
        });
    </script>
    <h2>Delete</h2>
    <form method="post" action="delete2.php">
        <label for="no">No PC:</label>
        <input type="text" name="no" required><br>
        <input type="submit" value="Delete">
    </form>

</body>

</html>
