<section class="content-header">
    <h1>Input<small>Data Cuti Dispensasi</small></h1>
    <ol class="breadcrumb">
        <li><a href="home-hrd.php"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="active">Input Data Cuti Dispensasi</li>
    </ol>
</section>
<div class="register-box">
<?php
  include "dist/koneksi.php";
	if ($_POST['save'] == "save") {
	$username		= $_POST['nip'];
  $tanggal    = $_POST['tanggal'];
  $project    = $_POST['project'];
  $keterangan = $_POST['keterangan'];
  $jumlahcuti = $_POST['jumlahcuti'];


    $carinamanya = mysql_query("SELECT * FROM tb_user WHERE id_user='$username'");
    $cn = mysql_fetch_array($carinamanya);
    $namanya = $cn['nama_user'];

    $caritanggal = mysql_query("SELECT * FROM historydispensasi WHERE tanggal='$tanggal' AND username='$username'");

    if (mysql_num_rows($caritanggal) > 0){
      echo "<div class='register-logo'><b>Input Data</b> Gagal!</div>
				<div class='register-box-body'>
					<p>Input Data Cuti Dispensasi Gagal.</p>
          <p>Cuti dispensasi telah ada di tanggal <b>$tanggal</b> atas nama <b>$namanya</b>, Silahkah cek di data cuti dispensasi.</p>
					<div class='row'>
						<div class='col-xs-8'></div>
						<div class='col-xs-4'>
							<button type='button' onclick=location.href='home-hrd.php?page=form-input-data-cuti-tahunan' class='btn btn-danger btn-block btn-flat'>Next >></button>
						</div>
					</div>
				</div>";
    }
    else{
      $insertdispen = mysql_query("INSERT INTO historydispensasi (username,tanggal,project,keterangan,jumlahcuti) VALUES ('$username','$tanggal','$project','$keterangan','$jumlahcuti')");
      $updatedispen = mysql_query("UPDATE tb_pegawai SET hak_cuti_dispensasi = hak_cuti_dispensasi + '$jumlahcuti' WHERE nip='$username'");

      echo "<div class='register-logo'><b>Input Data</b> Berhasil!</div>
				<div class='register-box-body'>
					<p>Input Data Cuti Dispensasi Berhasil.</p>
					<div class='row'>
						<div class='col-xs-8'></div>
						<div class='col-xs-4'>
							<button type='button' onclick=location.href='home-hrd.php?page=form-input-data-cuti-tahunan' class='btn btn-danger btn-block btn-flat'>Next >></button>
						</div>
					</div>
				</div>";
    }

		// $updateHak = "UPDATE tb_pegawai SET hak_cuti_dispensasi= $hak_cuti_dispensasi WHERE nip='$nip'";
		// $query = mysql_query ($updateHak);
    //
		// if($query){
		// 	echo "<div class='register-logo'><b>Input Data</b> Successful!</div>
		// 		<div class='register-box-body'>
		// 			<p>Input Data Cuti Dispensasi Berhasil.</p>
		// 			<div class='row'>
		// 				<div class='col-xs-8'></div>
		// 				<div class='col-xs-4'>
		// 					<button type='button' onclick=location.href='home-hrd.php?page=form-input-data-cuti-tahunan' class='btn btn-danger btn-block btn-flat'>Next >></button>
		// 				</div>
		// 			</div>
		// 		</div>";
		// }
		// else {
		// 	echo "<div class='register-logo'><b>Oops!</b> 404 Error Server.</div>";
		// }

  }
?>
</div>
