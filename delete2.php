<?php
include "koneksi.php";
$noedit = ($_POST)['no'];

$update = "DELETE FROM tb_perawatan where no='$noedit'";
$hasil = mysqli_query($conn, $update);
if($hasil)
{
    echo "Proses delete data BERHASIL";
}
else
{
    echo "Proses delete data GAGAL" ;
}
?>