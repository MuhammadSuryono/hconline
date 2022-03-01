<section class="content-header">
    <h1>Upload<small>Video</small></h1>
    <ol class="breadcrumb">
        <li><a href="home-pegawai.php"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="active">Upload Video</li>
    </ol>
</section>
<div class="register-box">
<?php

	include "dist/koneksi.php";

	if (isset($_POST['submit'])) {
  date_default_timezone_set("Asia/Bangkok");
  $tanggalnya = date("Y-m-d");
  $nama_gambar=$_FILES['video'] ['name'];
  $lokasi=$_FILES['video'] ['tmp_name']; // Menyiapkan tempat nemapung gambar yang diupload
  $lokasitujuan="./video"; // Menguplaod gambar kedalam folder ./image
  $upload=move_uploaded_file($lokasi,$lokasitujuan."/".$nama_gambar);

  $insert = mysql_query("INSERT INTO video (tanggalupload,file) VALUES ('$tanggalnya','$nama_gambar')");


  if ($insert){

    echo "<div class='register-logo'><b>Upload Video Sukses!</b>.</div>
      <div class='box box-primary'>
        <div class='register-box-body'>
          <p>Upload Video Sukses, video yang akan di play adalah video yang terakhir di upload .</p>
          <div class='row'>
            <div class='col-xs-8'></div>
            <div class='col-xs-4'>
              <button type='button' onclick=location.href='home-admin.php?page=upload-video' class='btn btn-block btn-warning'>Next</button>
            </div>
          </div>
        </div>
      </div>";

  }
  else{
    echo "<div class='register-logo'><b>Upload Video GAGAL!</b>.</div>
      <div class='box box-primary'>
        <div class='register-box-body'>
          <p>Upload Video GAGAL, harap upload ulang .</p>
          <div class='row'>
            <div class='col-xs-8'></div>
            <div class='col-xs-4'>
              <button type='button' onclick=location.href='home-admin.php?page=upload-video' class='btn btn-block btn-warning'>Next</button>
            </div>
          </div>
        </div>
      </div>";
  }
}
?>
</div>
