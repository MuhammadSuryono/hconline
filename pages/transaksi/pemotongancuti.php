<?php
$servername = "localhost";
$username = "adam";
$password = "Ad@mMR1db";
$dbname = "db_cuti";

error_reporting(0);

    // membuat koneksi
    $koneksi = new mysqli($servername, $username, $password, $dbname);

    // melakukan pengecekan koneksi
    if ($koneksi->connect_error) {
        die("Connection failed: " . $koneksi->connect_error);
    }

    if($_POST['nip'] && $_POST['nama']) {
        $id = $_POST['nip'];
        $waktu = $_POST['nip'];
        ?>



      <?php } 
    $koneksi->close();
?>
