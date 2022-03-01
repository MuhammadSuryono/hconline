<!-- <section class="content-header">
    <h1>Not Approved<small>Cuti</small></h1>
    <ol class="breadcrumb">
        <li><a href="home-hrd.php"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="active">Not Approved Cuti</li>
    </ol>
</section>
<div class="register-box">
	<div class='register-logo'><b>Approved</b> Cuti!</div>
	<div class='register-box-body'>
		<p>MAAF, PROSES INI HANYA DAPAT BERJALAN DI APLIKASI VERSI PRO, SILAHKAN HUBUNGI ADMIN RajaPutraMedia.Com</p>
		<div class='row'>
			<div class='col-xs-8'></div>
			<div class='col-xs-4'>
				<div class='box-body box-profile'>
					<a class='btn btn-primary btn-block' href='home-hrd.php?page=pre-approval-cuti'>OK</a>
				</div>
			</div>
		</div>
	</div>
</div> -->


<?php

include "dist/koneksi.php";

$no_cuti	= $_GET['no_cuti'];

$update=mysql_query("UPDATE `tb_mohoncuti` SET `persetujuan`='Tidak Disetujui(Direksi)', `cutisesudah` = `cutisebelum` WHERE `no_cuti`='$no_cuti'");

$ambil = mysql_query("SELECT * FROM tb_mohoncuti WHERE `no_cuti`='$no_cuti'");
$data = mysql_fetch_array($ambil);

$tambah = $data['jml_hari'];
$nip = $data['nip'];
$jenis = $data['jenis'];

if ($jenis == 'Tahunan') {
	$update_pegawai=mysql_query("UPDATE tb_pegawai SET hak_cuti_tahunan = (hak_cuti_tahunan + $tambah) WHERE nip='$nip'");
} else if ($jenis == 'Tahun Lalu') {
	$update_pegawai=mysql_query("UPDATE tb_pegawai SET hak_cuti_tahunlalu = (hak_cuti_tahunlalu + $tambah) WHERE nip='$nip'");
}

    if ($update)
    {
        echo "<script> document.location.href='home-hrd.php?page=alasan&code=$no_cuti'; </script>";
    }else{
        echo "GAGAL";
    }

?>
