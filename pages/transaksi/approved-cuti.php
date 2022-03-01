<!-- <section class="content-header">
    <h1>Approved<small>Cuti</small></h1>
    <ol class="breadcrumb">
        <li><a href="home-hrd.php"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="active">Approved Cuti</li>
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
</div>

-->

 <?php

 include "dist/koneksi.php";

 $no_cuti	= $_GET['no_cuti'];
 $nip = $_GET['nip'];
 $jml_hari = $_GET['jml_hari'];
 $jenis = $_GET['jenis'];

 $selecthak=mysql_query("SELECT hak_cuti_tahunan,hak_cuti_tahunlalu,hak_cuti_dispensasi FROM tb_pegawai WHERE nip='$nip'");
 $hak = mysql_fetch_assoc($selecthak);

 $haktahunini = $hak['hak_cuti_tahunan'];
 $haktahunlalu = $hak['hak_cuti_tahunlalu'];
 $hakcutidispensasi = $hak['hak_cuti_dispensasi'];
 $totalhak = $haktahunini + $haktahunlalu;


$update=mysql_query("UPDATE `tb_mohoncuti` SET `persetujuan`='Disetujui(Direksi)' WHERE `no_cuti`='$no_cuti'");

$update=mysql_query("UPDATE `daterange_cuti` SET `persetujuan`='Disetujui(Direksi)' WHERE `no_cuti`='$no_cuti'");

     if($jenis == 'Cuti Dispensasi'){

       $cd = mysql_query("UPDATE tb_pegawai SET hak_cuti_dispensasi= (hak_cuti_dispensasi - $jml_hari) WHERE nip='$nip'");

       $jarak = TRUE;

     }
     else{
       $jarak = TRUE;
     }

             // if($jenis == 'Cuti Dispensasi'){
             //
             //  $cd = mysql_query("UPDATE tb_pegawai SET hak_cuti_dispensasi= (hak_cuti_dispensasi - $jml_hari) WHERE nip='$nip'");
             //
             //  $jarak = TRUE;
             //
             // }
             //
             //  else if($jml_hari <= $haktahunlalu) {
             //
             //    $kurang=mysql_query("UPDATE tb_pegawai SET hak_cuti_tahunlalu= (hak_cuti_tahunlalu - $jml_hari) WHERE nip='$nip'");
             //
             //    $jarak = TRUE;
             //
             //
             //  }
             //
             //  else if($haktahunlalu <= 0.00){
             //
             //    $kuranghak = mysql_query("UPDATE tb_pegawai SET hak_cuti_tahunan= (hak_cuti_tahunan - $jml_hari) WHERE nip='$nip'");
             //
             //    $jarak = TRUE;
             //
             //  }
             //
             //  else if($jml_hari >= $haktahunlalu){
             //
             //    // $kurang=mysql_query("UPDATE tb_pegawai SET hak_cuti_tahunlalu= (hak_cuti_tahunlalu - $jml_hari) WHERE nip='$nip'");
             //    //
             //    // $selectagain=mysql_query("SELECT hak_cuti_tahunlalu FROM tb_pegawai WHERE nip='$nip'");
             //    // $hasil = mysql_fetch_assoc($selectagain);
             //    //
             //    // $hasilakhir = $hasil['hak_cuti_tahunlalu'] + $jml_hari;
             //    //
             //    // $kuranginlagi=mysql_query("UPDATE tb_pegawai SET hak_cuti_tahunan= (hak_cuti_tahunan - $hasilakhir) WHERE nip='$nip'");
             //    //
             //    // $updatenol=mysql_query("UPDATE tb_pegawai SET hak_cuti_tahunlalu=0.00 WHERE nip='$nip'");
             //
             //    $hasilnya = $totalhak - $jml_hari;
             //
             //    $updateti = mysql_query("UPDATE tb_pegawai SET hak_cuti_tahunan='$hasilnya' WHERE nip='$nip'");
             //
             //    $updateth = mysql_query("UPDATE tb_pegawai SET hak_cuti_tahunlalu=0.00 WHERE nip='$nip'");
             //
             //    $jarak = TRUE;
             //  }
             //
             //  else{
             //
             //    $jarak = TRUE;
             //
             //  }

    if ($jarak == TRUE)

    {
      echo "<div class='register-logo'><b>Cuti Berhasil Setujui</b></div>
       <div class='box box-primary'>
         <div class='register-box-body'>
           <p>Cuti dengan nomor $no_cuti telah disetujui!!.</p>
           <div class='row'>
             <div class='col-xs-8'></div>
             <div class='col-xs-4'>
               <button type='button' onclick=location.href='home-hrd.php?page=pre-approval-cuti' class='btn btn-block btn-warning'>Back</button>
             </div>
           </div>
         </div>
       </div>";
     }

?>
