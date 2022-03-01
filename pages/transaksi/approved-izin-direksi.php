<?php

include "dist/koneksi.php";

$no         = $_GET['no'];
$nip        = $_GET['nip'];
$jml_hari   = $_GET['jml_hari'];
$jenis      = $_GET['jenis'];

  $selecthak = mysql_query("SELECT hak_cuti_tahunan,hak_cuti_tahunlalu FROM tb_pegawai WHERE nip='$nip'");
  $hak = mysql_fetch_assoc($selecthak);

$haktahunini  = $hak['hak_cuti_tahunan'];
$haktahunlalu = $hak['hak_cuti_tahunlalu'];
$totalhak     = $haktahunini + $haktahunlalu;

$update1 = mysql_query("UPDATE tb_izin SET persetujuan='Disetujui(Direksi)' WHERE no='$no'");
$update2 = mysql_query("UPDATE daterange_izin SET persetujuan='Disetujui(Direksi)' WHERE no_izin='$no'");

// if ($jenis == "Sakit Tanpa Surat Dokter"){
//
//         if ($workingDays < $haktahunlalu){
//
//           $potong = mysql_query("UPDATE tb_pegawai SET hak_cuti_tahunlalu= (hak_cuti_tahunlalu - $workingDays) WHERE nip='$nip'");
//
//           $jarak = TRUE;
//
//         }
//
//         else if($haktahunlalu == 0.00){
//
//           $kuranghak= mysql_query("UPDATE tb_pegawai SET hak_cuti_tahunan= (hak_cuti_tahunan - $workingDays) WHERE nip='$nip'");
//
//           $jarak= TRUE;
//
//         }
//
//         else if($workingDays > $haktahunlalu){
//
//         $kurang = mysql_query("UPDATE tb_pegawai SET hak_cuti_tahunlalu= (hak_cuti_tahunlalu - $workingDays) WHERE nip='$nip'");
//
//         $selectagain=mysql_query("SELECT hak_cuti_tahunlalu FROM tb_pegawai WHERE nip='$nip'");
//         $hasil = mysql_fetch_assoc($selectagain);
//
//         $hasilakhir = $hasil['hak_cuti_tahunlalu'] + $workingDays;
//
//         $kuranginlagi=mysql_query("UPDATE tb_pegawai SET hak_cuti_tahunan= (hak_cuti_tahunan - $hasilakhir) WHERE nip='$nip'");
//
//         $updatenol=mysql_query("UPDATE tb_pegawai SET hak_cuti_tahunlalu=0.00 WHERE nip='$nip'");
//
//         $jarak = TRUE;
//
//         }
//
// }
//
//
// else if ($jenis == "Datang Telat Lebih Dari 2 Jam" || $jenis == "Pulang Lebih Cepat Lebih Dari 2 Jam") {
//
//         $stgh = 0.50;
//
//         if ($stgh < $haktahunlalu){
//
//         $potong2 =mysql_query("UPDATE tb_pegawai SET hak_cuti_tahunlalu= (hak_cuti_tahunlalu - $stgh) WHERE nip='$nip'");
//
//           $jarak = TRUE;
//         }
//
//         else if($haktahunlalu == 0.00){
//
//         $kuranghak2= mysql_query("UPDATE tb_pegawai SET hak_cuti_tahunan= (hak_cuti_tahunan - $stgh) WHERE nip='$nip'");
//
//         $jarak= TRUE;
//
//         }
//
//         else if($stgh > $haktahunlalu){
//
//         $kurang2=mysql_query("UPDATE tb_pegawai SET hak_cuti_tahunlalu= (hak_cuti_tahunlalu - $stgh) WHERE nip='$nip'");
//
//         $selectagain2=mysql_query("SELECT hak_cuti_tahunlalu FROM tb_pegawai WHERE nip='$nip'");
//         $hasil2 = mysql_fetch_assoc($selectagain2);
//
//         $hasilakhir2 = $hasil2['hak_cuti_tahunlalu'] + $stgh;
//
//         $kuranginlagi2=mysql_query("UPDATE tb_pegawai SET hak_cuti_tahunan= (hak_cuti_tahunan - $hasilakhir2) WHERE nip='$nip'");
//
//         $updatenol2=mysql_query("UPDATE tb_pegawai SET hak_cuti_tahunlalu=0.00 WHERE nip='$nip'");
//
//         $jarak = TRUE;
//
//         }
//
// }
//
// else {
//
//     $jarak = TRUE;
//
// }


// if ($jarak == TRUE)
if ($update1 && $update2)
{
  echo "<script> document.location.href='home-hrd.php'; </script>";
}

?>
