<section class="content-header">
    <h1>Input<small>Data Lembur Weekend</small></h1>
    <ol class="breadcrumb">
        <li><a href="home-hrd.php"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="active">Input Data Lembur Weekend</li>
    </ol>
</section>
<div class="register-box">
<?php
  include "dist/koneksi.php";
	if ($_POST['save'] == "save") {

    foreach ($_POST['username'] as $key) {

      $username     = $key;
      $tanggal      = $_POST['tanggal'];
      $project      = $_POST['project'];
      $keterangan   = $_POST['keterangan'];
      $manager      = $_SESSION['id_user'];

      $cekdululah = mysql_query("SELECT * FROM lemburweekend WHERE tanggal='$tanggal' AND username='$username'");

      if ($_SESSION['hak_akses'] == 'HRD'){
        $home = "home-hrd.php";
      }else{
        $home = "home-manager.php";
      }

      if (mysql_num_rows($cekdululah) > 0){
        echo "<div class='register-logo'><b>Input Lembur Weekend</b> Gagal!</div>
  				<div class='register-box-body'>
  					<p>Input Lembur Weeekend Gagal.</p>
            <p>Sudah ada assign lembur pada tanggal $tanggal.</p>
  					<div class='row'>
  						<div class='col-xs-8'></div>
  						<div class='col-xs-4'>
  							<button type='button' onclick=location.href='$home?page=form-lembur-weekend' class='btn btn-danger btn-block btn-flat'>Next >></button>
  						</div>
  					</div>
  				</div>";
      }else{

        $insertnya = mysql_query("INSERT INTO lemburweekend (username,tanggal,project,keterangan,manager) VALUES ('$username','$tanggal','$project','$keterangan','$manager')");

      }
    }

    echo "<div class='register-logo'><b>Input Lembur Weekend</b> Berhasil!</div>
      <div class='register-box-body'>
        <p>Assign Lembur Weekend Berhasil.</p>
        <div class='row'>
          <div class='col-xs-8'></div>
          <div class='col-xs-4'>
            <button type='button' onclick=location.href='$home?page=form-lembur-weekend' class='btn btn-danger btn-block btn-flat'>Next >></button>
          </div>
        </div>
      </div>";

  }
?>
</div>
