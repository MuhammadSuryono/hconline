<?php

include "dist/koneksi.php";

$no	= $_GET['no'];

$update=mysql_query("UPDATE `tb_izin` SET `persetujuan`='Tidak Disetujui(Direksi)' , `cutisesudah` = `cutisebelum` WHERE `no`='$no'");

$ambil = mysql_query("SELECT * FROM tb_izin WHERE `no`='$no'");
$data = mysql_fetch_array($ambil);

$tambah = $data['jml_hari'];
$nip = $data['nip'];
$jenis = $data['jenis'];

if ($jenis == "Sakit Tanpa Surat Dokter" || $jenis == "Datang Telat Lebih Dari 2 Jam" || $jenis == "Pulang Lebih Cepat Lebih Dari 2 Jam") {
	$update_pegawai=mysql_query("UPDATE tb_pegawai SET hak_cuti_tahunan = (hak_cuti_tahunan + $tambah) WHERE nip='$nip'");
}


    if ($update)
    {
        echo "<script> document.location.href='home-hrd.php'; </script>";
    }else{
        echo "GAGAL";
    }

?>
