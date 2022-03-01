<?php
    $servername = "localhost";
    $username = "adam";
    $password = "Ad@mMR1db";
    $dbname = "db_cuti";

    // membuat koneksi
    $koneksi = new mysqli($servername, $username, $password, $dbname);

    // melakukan pengecekan koneksi
    if ($koneksi->connect_error) {
        die("Connection failed: " . $koneksi->connect_error);
    }

    if($_POST['username']) {

    $username = $_POST['username'];

    echo $username;

    ?>



    <?php } }
    $koneksi->close();
    ?>
