<section class="content-header">
    <h1>Input<small>Data Izin Backdate</small></h1>
    <ol class="breadcrumb">
        <li><a href="home-hrd.php"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="active">Input Data Cuti Tahunan</li>
    </ol>
</section>
<div class="register-box">
<?php
	if ($_POST['save'] == "save") {
	$nip				= $_POST['nip'];

		if (empty($_POST['nip'])) {
		echo "<div class='register-logo'><b>Oops!</b> Data Tidak Lengkap.</div>
			<div class='box box-primary'>
				<div class='register-box-body'>
					<p>Harap periksa kembali dan pastikan data yang Anda masukan lengkap dan benar.</p>
					<div class='row'>
						<div class='col-xs-8'></div>
						<div class='col-xs-4'>
							<button type='button' onclick=location.href='home-hrd.php?page=form-input-data-cuti-tahunan' class='btn btn-block btn-warning'>Back</button>
						</div>
					</div>
				</div>
			</div>";
		}

		else{
		include "dist/koneksi.php";
		$updatebackdate = "UPDATE tb_user SET izinbackdate = 1 WHERE nip='$nip'";
		$query = mysql_query ($updatebackdate);

		if($query){
			echo "<div class='register-logo'><b>Input Backdate</b> Successful!</div>
				<div class='register-box-body'>
					<p>Sekarang karyawan bisa input izin/cuti backdate.</p>
					<div class='row'>
						<div class='col-xs-8'></div>
						<div class='col-xs-4'>
							<button type='button' onclick=location.href='home-hrd.php?page=form-input-data-cuti-tahunan' class='btn btn-danger btn-block btn-flat'>Next >></button>
						</div>
					</div>
				</div>";
		}
			else {
				echo "<div class='register-logo'><b>Oops!</b> 404 Error Server.</div>";
			}
		}
	}
?>
</div>
