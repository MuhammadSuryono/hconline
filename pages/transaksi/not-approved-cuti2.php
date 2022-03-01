<?php

include "dist/koneksi.php";

$no_cuti	= $_GET['no_cuti'];

// $update=mysql_query("UPDATE `tb_mohoncuti` SET `persetujuan`='Tidak Disetujui(Manager)' WHERE `no_cuti`='$no_cuti'");
$update=mysql_query("UPDATE `tb_mohoncuti` SET `persetujuan`='Tidak Disetujui(Manager)', `cutisesudah` = `cutisebelum` WHERE `no_cuti`='$no_cuti'");

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
        echo "<script> document.location.href='home-manager.php?page=alasan2&code=$no_cuti'; </script>";
    }else{
        echo "GAGAL";
    }

?>
