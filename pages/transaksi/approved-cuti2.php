<?php

include "dist/koneksi.php";

$no_cuti	= $_GET['no_cuti'];
$nip = $_GET['nip'];
$jml_hari = $_GET['jml_hari'];

$selecthak=mysql_query("SELECT hak_cuti_tahunan,hak_cuti_tahunlalu,hak_cuti_dispensasi FROM tb_pegawai WHERE nip='$nip'");
$hak = mysql_fetch_assoc($selecthak);

$selcut = mysql_query("SELECT jenis FROM tb_mohoncuti WHERE no_cuti = '$no_cuti'");
$jc = mysql_fetch_assoc($selcut);
$jenis = $jc['jenis'];

$haktahunini = $hak['hak_cuti_tahunan'];
$haktahunlalu = $hak['hak_cuti_tahunlalu'];
$hakcutidispensasi = $hak['hak_cuti_dispensasi'];
$totalhak = $haktahunini + $haktahunlalu;

    $update      = mysql_query("UPDATE `tb_mohoncuti` SET `persetujuan`='Disetujui(Manager)' WHERE `no_cuti`='$no_cuti'");

    $updaterange = mysql_query("UPDATE `daterange_cuti` SET `persetujuan`='Disetujui(Manager)' WHERE `no_cuti`='$no_cuti'");


    if($jenis == 'Cuti Dispensasi'){

     $cd = mysql_query("UPDATE tb_pegawai SET hak_cuti_dispensasi= (hak_cuti_dispensasi - $jml_hari) WHERE nip='$nip'");

     $jarak = TRUE;

   }else{
     $jarak = TRUE;
   }


            // else if($jml_hari <= $haktahunlalu) {
            //
            //   $kurang=mysql_query("UPDATE tb_pegawai SET hak_cuti_tahunlalu= (hak_cuti_tahunlalu - $jml_hari) WHERE nip='$nip'");
            //
            //   $jarak = TRUE;
            //
            //
            // }

            // else if($haktahunlalu <= 0.00){
            //
            //   $kuranghak = mysql_query("UPDATE tb_pegawai SET hak_cuti_tahunan= (hak_cuti_tahunan - $jml_hari) WHERE nip='$nip'");
            //
            //   $jarak = TRUE;
            //
            // }

            // else if($jml_hari >= $haktahunlalu){

            // $kurang=mysql_query("UPDATE tb_pegawai SET hak_cuti_tahunlalu= (hak_cuti_tahunlalu - $jml_hari) WHERE nip='$nip'");
            //
            // $selectagain=mysql_query("SELECT hak_cuti_tahunlalu FROM tb_pegawai WHERE nip='$nip'");
            // $hasil = mysql_fetch_assoc($selectagain);
            //
            // $hasilakhir = $hasil['hak_cuti_tahunlalu'] + $jml_hari;
            //
            // $kuranginlagi=mysql_query("UPDATE tb_pegawai SET hak_cuti_tahunan= (hak_cuti_tahunan - $hasilakhir) WHERE nip='$nip'");
            //
            // $updatenol=mysql_query("UPDATE tb_pegawai SET hak_cuti_tahunlalu=0.00 WHERE nip='$nip'");

            //   $hasilnya = $totalhak - $jml_hari;
            //
            //   $updateti = mysql_query("UPDATE tb_pegawai SET hak_cuti_tahunan='$hasilnya' WHERE nip='$nip'");
            //
            //   $updateth = mysql_query("UPDATE tb_pegawai SET hak_cuti_tahunlalu=0.00 WHERE nip='$nip'");
            //
            //   $jarak = TRUE;
            // }


   if ($jarak == TRUE)
   {
     echo "<div class='register-logo'><b>Cuti Berhasil Setujui</b></div>
      <div class='box box-primary'>
        <div class='register-box-body'>
          <p>Cuti dengan nomor $no_cuti telah disetujui!!.</p>
          <div class='row'>
            <div class='col-xs-8'></div>
            <div class='col-xs-4'>
              <button type='button' onclick=location.href='home-manager.php?page=pre-approval-cuti2' class='btn btn-block btn-warning'>Back</button>
            </div>
          </div>
        </div>
      </div>";
    }

?>
