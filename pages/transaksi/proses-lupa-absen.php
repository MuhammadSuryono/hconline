<?php
if (isset($_POST['save'])){

$usermanager = $_POST['usermanager'];
$username    = $_POST['username'];
$keterangan  = $_POST['keterangan'];
$tanggal     = $_POST['tanggal'];
$jammasuk    = $_POST['jammasuk'];
$jamkeluar   = $_POST['jamkeluar'];
$temp = explode(".", $_FILES["gambar"]["name"]);
$newfilename = round(microtime(true)) . '.' . end($temp);
move_uploaded_file($_FILES["gambar"]["tmp_name"], "./uploads/lupaabsen" . $newfilename);

$masuknya  = $tanggal.' '.$jammasuk;
$keluarnya = $tanggal.' '.$jamkeluar;

  $cariidabsen = mysql_query("SELECT id_absen FROM tb_user WHERE id_user='$username'");
  $ca = mysql_fetch_array($cariidabsen);
  $id_absen = $ca['id_absen'];

  $insertkelupa = mysql_query("INSERT INTO koreksiabsen (username,id_absen,usermanager,keterangan,tanggal,jammasuk,jamkeluar,gambar)
                                            VALUES ('$username','$id_absen','$usermanager','$keterangan','$tanggal','$masuknya','$keluarnya','$newfilename')");

  $insertkelupatext = "INSERT INTO koreksiabsen (username,id_absen,usermanager,keterangan,tanggal,jammasuk,jamkeluar,gambar)
                                            VALUES ('$username','$id_absen','$usermanager','$keterangan','$tanggal','$masuknya','$keluarnya','$newfilename')";

  if($insertkelupa){
    echo "<div class='register-logo'><b>Input Form Koreksi Absen Sukses!</b>.</div>
      <div class='box box-primary'>
        <div class='register-box-body'>
          <p>Form koreksi absen berhasil di input.</p>
          <div class='row'>
            <div class='col-xs-8'></div>
            <div class='col-xs-4'>
              <button type='button' onclick=location.href='home-manager.php?page=history-izin-pegawai' class='btn btn-block btn-warning'>Next</button>
            </div>
          </div>
        </div>
      </div>";
  }else{
    echo "<div class='register-logo'><b>Input Form Koreksi Absen GAGAL!</b>.</div>
      <div class='box box-primary'>
        <div class='register-box-body'>
          <p>Terjadi kesalahan. Harap coba lagi!!</p>
          <div class='row'>
            <div class='col-xs-8'></div>
            <div class='col-xs-4'>
              <button type='button' onclick=location.href='home-manager.php?page=history-izin-pegawai' class='btn btn-block btn-warning'>Next</button>
            </div>
          </div>
        </div>
      </div>";

  }



}

?>
