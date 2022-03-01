<section class="content-header">
   <h1>MRI Cuti Online<small>Dashboard</small></h1>
    <ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i>Dashboard</a></li>
    </ol>
</section>
<?php
	include "dist/koneksi.php";
	$Year = date('Y');
	$dateFirst = $Year."-01-01";

	$cuti=mysql_query("SELECT * FROM tb_mohoncuti WHERE dari >= '$dateFirst'");
	// $jmlcuti = mysql_num_rows($cuti);

	$approve=mysql_query("SELECT * FROM tb_mohoncuti WHERE ((persetujuan='Disetujui(Direksi)' OR persetujuan='Disetujui(Manager)') AND dari >= '$dateFirst')");
	$jmlapprove = mysql_num_rows($approve);

	$wait=mysql_query("SELECT * FROM tb_mohoncuti WHERE ((persetujuan=''  AND jml_hari >= '1') OR (hak_akses='Manager' AND persetujuan='')) AND dari >= '$dateFirst'");
	$jmlwait = mysql_num_rows($wait);

	$jmlcuti = $jmlapprove + $jmlwait;

	$pegawai=mysql_query("SELECT * FROM tb_pegawai");
	$jmlpegawai = mysql_num_rows($pegawai);
?>
<section class="content">
    <div class="row">
		<div class="col-lg-3 col-xs-6">
			<div class="small-box bg-aqua">
				<div class="inner">
					<h3><?=$jmlcuti?></h3>
					<p>Total Cuti</p>
				</div>
				<div class="icon">
					<i class="ion ion-bag"></i>
				</div>
				<p class="small-box-footer">Cuti <i class="fa fa-arrow-circle-right"></i></p>
			</div>
        </div>
        <div class="col-lg-3 col-xs-6">
			<div class="small-box bg-green">
				<div class="inner">
					<h3><?=$jmlapprove?></h3>
					<p>Total Approve</p>
				</div>
				<div class="icon">
					<i class="ion ion-person"></i>
				</div>
				<p class="small-box-footer">Approval <i class="fa fa-arrow-circle-right"></i></p>
			</div>
        </div>
        <div class="col-lg-3 col-xs-6">
			<div class="small-box bg-yellow">
				<div class="inner">
					<h3><?=$jmlwait?></h3>
					<p>Total Waiting</p>
				</div>
				<div class="icon">
					<i class="ion ion-person"></i>
				</div>
				<p class="small-box-footer">Approval <i class="fa fa-arrow-circle-right"></i></p>
			</div>
        </div>
        <div class="col-lg-3 col-xs-6">
			<div class="small-box bg-red">
				<div class="inner">
					<h3><?=$jmlpegawai?></h3>
					<p>Total Pegawai</p>
				</div>
				<div class="icon">
					<i class="ion ion-person-add"></i>
				</div>
				<p class="small-box-footer">Pegawai <i class="fa fa-arrow-circle-right"></i></p>
			</div>
        </div>
    </div>
</section>
