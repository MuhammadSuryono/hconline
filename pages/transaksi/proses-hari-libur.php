<section class="content-header">
    <h1>Input<small>Data Hari Libur & Cuti Bersama</small></h1>
    <ol class="breadcrumb">
        <li><a href="home-admin.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Input Hari Libur & Cuti Bersama</li>
    </ol>
</section>
<div class="register-box">
<?php
	if ($_POST['save'] == "save") {
	$tanggal	  = $_POST['tanggal'];
	$keterangan  = $_POST['keterangan'];

	include "dist/koneksi.php";
  $insertLibur	= mysql_query("INSERT INTO kalender (tanggal,jenis,keterangan) VALUES ('$tanggal','L','$keterangan')");


		if($insertLibur){
			echo "<div class='register-logo'><b>Input Data Hari Libur & Cuti Bersama</b> Successful!</div>
				<div class='register-box-body'>
					<p>Input Data Hari Libur & Cuti Bersama Berhasil.</p>
					<div class='row'>
						<div class='col-xs-8'></div>
						<div class='col-xs-4'>
							<button type='button' onclick=location.href='home-hrd.php?page=data-hari-libur' class='btn btn-danger btn-block btn-flat'>Next >></button>
						</div>
					</div>
				</div>";
		}
		else {
			echo "<div class='register-logo'><b>Oops!</b> 404 Error Server.</div>";
		}

	}
?>
</div>
