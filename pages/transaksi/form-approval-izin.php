<section class="content-header">
    <h1>Form Approval<small>Izin</small></h1>
    <ol class="breadcrumb">
        <li><a href="home-hrd.php"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="active">Approval Izin</li>
    </ol>
</section>
<div class="register-box">

<?php
  error_reporting(0);
	if (isset($_GET['no']) AND ($_GET['nip']) AND ($_GET['jml_hari']) AND ($_GET['jenis'])) {
	$no_cuti	= $_GET['no'];
	$nip 		= $_GET['nip'];
	$jml_hari 	= $_GET['jml_hari'];
	$jenis	 	= $_GET['jenis'];
	}
	else{
		die ("Error. No ID Selected! ");
	}
	echo "<div class='register-logo'><b>Approval</b> Izin!</div>
		<div class='register-box-body'>
			<p>Silahkan tentukan status persetujuan untuk permohonan Izin ini</p>
			<div class='row'>
				<div class='col-xs-1'></div>
				<div class='col-xs-5'>
					<div class='box-body box-profile'>
						<a class='btn btn-primary btn-block' href='home-manager.php?page=approved-izin&no=$no_cuti&nip=$nip&jml_hari=$jml_hari&jenis=$jenis'>Approved</a>
					</div>
				</div>
				<div class='col-xs-5'>
					<div class='box-body box-profile'>
						<a class='btn btn-warning btn-block' href='home-manager.php?page=not-approved-izin&no=$no_cuti'>Not Approved</a>
					</div>
				</div>
				<div class='col-xs-1'></div>
			</div>
		</div>";
?>
</div>
