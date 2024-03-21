<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=\, initial-scale=1.0">
    <title></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <div class="row row-cols-1 row-cols-md-4 g-4">
        <?php
            include "koneksi.php";
            
            $sql = "SELECT no_ruangan, COUNT(no_pc) as jml_pc FROM tb_perawatan GROUP BY no_ruangan";
            $show = mysqli_query($conn, $sql);
            while ($e = mysqli_fetch_array($show)){
        ?>
        <div class="col">
            <div class="card h-100">  
                <div class="card-body">
                    <h5 class="card-title">Ruang <?= $e['no_ruangan'] ?></h5>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Jumlah PC : <?= $e['jml_pc'] ?></li>
                </ul>
                <div class="card-body">
                    <a href="ruangan.php?id=<?= $e['no_ruangan'] ?>" class="btn btn-info">Ruangan</a>
                </div>
            </div>
        </div>
        <?php
            }
        ?>
    </div>
</body>
</html>