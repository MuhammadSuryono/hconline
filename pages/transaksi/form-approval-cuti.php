<section class="content-header">
    <h1>Form Approval<small>Cuti</small></h1>
    <ol class="breadcrumb">
        <li><a href="home-hrd.php"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="active">Approval Cuti</li>
    </ol>
</section>
<div class="register-box">
<?php
	if (isset($_GET['no_cuti']) AND ($_GET['nip']) AND ($_GET['jml_hari']) AND ($_GET['jenis'])) {
	$no_cuti	= $_GET['no_cuti'];
	$nip 		= $_GET['nip'];
	$jml_hari 	= $_GET['jml_hari'];
	$jenis	 	= $_GET['jenis'];
	}
	else{
		die ("Error. No ID Selected! ");
	}
	echo "<div class='register-logo'><b>Approval</b> Cuti!</div>
		<div class='register-box-body'>
			<p>Silahkan tentukan status persetujuan untuk permohonan cuti No. <b>$no_cuti</b></p>
			<div class='row'>
				<div class='col-xs-1'></div>
				<div class='col-xs-5'>
					<div class='box-body box-profile'>
						<a class='btn btn-primary btn-block' href='home-hrd.php?page=approved-cuti&no_cuti=$no_cuti&nip=$nip&jml_hari=$jml_hari&jenis=$jenis'>Approved</a>
					</div>
				</div>
				<div class='col-xs-5'>
					<div class='box-body box-profile'>
						<a class='btn btn-warning btn-block' href='home-hrd.php?page=not-approved-cuti&no_cuti=$no_cuti'>Not Approved</a>
					</div>
				</div>
				<div class='col-xs-1'></div>
			</div>
		</div>";
?>
</div>
