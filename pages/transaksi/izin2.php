<section class="content-header">
    <h1>Permohonan<small>Izin</small></h1>
    <ol class="breadcrumb">
        <li><a href="home-pegawai.php"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="active">Permohonan Izin</li>
    </ol>
</section>
<div class="register-box">
<?php
  error_reporting(0);
	include "dist/koneksi.php";
	$nip		=$_SESSION['id_user'];
  $nama   =$_SESSION['nama_user'];
  $divisi =$_SESSION['divisi'];
	$tgl		=date('Y-m-d');


	if ($_POST['save'] == "save") {

    function kdauto($tabel, $inisial){
      $struktur   = mysql_query("SELECT * FROM $tabel");
      $field      = mysql_field_name($struktur,0);
      $panjang    = mysql_field_len($struktur,0);
      $qry  = mysql_query("SELECT max(".$field.") FROM ".$tabel);
      $row  = mysql_fetch_array($qry);
      if ($row[0]=="") {
      $angka=0;
      }
      else {
      $angka= substr($row[0], strlen($inisial));
      }
      $angka++;
      $angka      =strval($angka);
      $tmp  ="";
      for($i=1; $i<=($panjang-strlen($inisial)-strlen($angka)); $i++) {
      $tmp=$tmp."0";
      }
      return $inisial.$tmp.$angka;
    }

  $no	=kdauto("tb_izin","");
	$daritgl	=$_POST['dari'];
	$sampaitgl	=$_POST['sampai'];
  $jenis=$_POST['jenis'];
  $nama_gambar=$_FILES['gambar'] ['name'];
  $lokasi=$_FILES['gambar'] ['tmp_name']; // Menyiapkan tempat nemapung gambar yang diupload
  $lokasitujuan="./izin"; // Menguplaod gambar kedalam folder ./image
  $upload=move_uploaded_file($lokasi,$lokasitujuan."/".$nama_gambar);

  //get current month for example
  function number_of_working_days($startDate, $endDate)
  {
      $workingDays = 0;
      $startTimestamp = strtotime($startDate);
      $endTimestamp = strtotime($endDate);
      for ($i = $startTimestamp; $i <= $endTimestamp; $i = $i + (60 * 60 * 24)) {
          if (date("N", $i) <= 5) $workingDays = $workingDays + 1;
      }
      return $workingDays;
  }

  $startDate = $daritgl;
  $endDate = $sampaitgl;
  if ($jenis == "Datang Telat Lebih Dari 2 Jam" || $jenis == "Pulang Lebih Cepat Lebih Dari 2 Jam"){
  $workingDays = 0.5;
  }else{
  $workingDays = number_of_working_days($startDate, $endDate);
  }


  $caricuti = mysql_query("SELECT * FROM tb_pegawai WHERE nip='$nip'");
  $carcut = mysql_fetch_assoc($caricuti);
  $hak_cuti_tahunan     = $carcut['hak_cuti_tahunan'];
  $hak_cuti_tahunlalu   = $carcut['hak_cuti_tahunlalu'];
  $hak_cuti_dispensasi  = $carcut['hak_cuti_dispensasi'];
  $hakcutifinal         = $hak_cuti_tahunan + $hak_cuti_tahunlalu;


	// if (empty($_POST['dari']) || empty($_POST['sampai']) || empty($_POST['jenis'])) {
	// 	echo "<div class='register-logo'><b>Oops!</b> Data Tidak Lengkap.</div>
	// 		<div class='box box-primary'>
	// 			<div class='register-box-body'>
	// 				<p>Harap periksa kembali dan pastikan data yang Anda masukan lengkap dan benar</p>
	// 				<div class='row'>
	// 					<div class='col-xs-8'></div>
	// 					<div class='col-xs-4'>
	// 						<button type='button' onclick=location.href='home-pegawai.php?page=form-izin' class='btn btn-block btn-warning'>Back</button>
	// 					</div>
	// 				</div>
	// 			</div>
	// 		</div>";
	// }
  // else{

  if ($jenis == "Sakit Dengan Surat Dokter" || $jenis == "Dinas" || $jenis == "Tugas" || $jenis == "Datang Telat Kurang Dari 2 Jam" || $jenis == "Pulang Lebih Cepat Kurang Dari 2 Jam"){

    $insert =mysql_query("INSERT INTO tb_izin (no,nip,nama,divisi,tgl,dari,sampai,jml_hari,jenis,gambar)
                          VALUES ('$no','$nip','$nama','$divisi','$tgl','$daritgl','$sampaitgl','$workingDays','$jenis','$nama_gambar')");

                          $selecthak= mysql_query("SELECT hak_cuti_tahunan,hak_cuti_tahunlalu FROM tb_pegawai WHERE nip='$nip'");
                          $hak = mysql_fetch_assoc($selecthak);
                          $haktahunlalu = $hak['hak_cuti_tahunlalu'];
                          $haktahunini = $hak['hak_cuti_tahunan'];

  //jika sudah berhasil
  }
  else
  {
    if ($hakcutifinal <= $workingDays){
      echo "<div class='register-logo'><b>Oops!</b> Sisa Cuti Tidak Mencukupi.</div>
        <div class='box box-primary'>
          <div class='register-box-body'>
            <p>Sisa Cuti Tidak Mencukupi, Harap Hubungi Manager Divisi Terkait Untuk Pengajuan Unpaid Leave</p>
            <div class='row'>
              <div class='col-xs-8'></div>
              <div class='col-xs-4'>
                <button type='button' onclick=location.href='home-pegawai2.php?page=form-izin2' class='btn btn-block btn-warning'>Back</button>
              </div>
            </div>
          </div>
        </div>";
      }
      else{

        $insert =mysql_query("INSERT INTO tb_izin (no,nip,nama,divisi,tgl,dari,sampai,jml_hari,jenis,gambar)
                              VALUES ('$no','$nip','$nama','$divisi','$tgl','$daritgl','$sampaitgl','$workingDays','$jenis','$nama_gambar')");

                              $selecthak= mysql_query("SELECT hak_cuti_tahunan,hak_cuti_tahunlalu FROM tb_pegawai WHERE nip='$nip'");
                              $hak = mysql_fetch_assoc($selecthak);
                              $haktahunlalu = $hak['hak_cuti_tahunlalu'];
                              $haktahunini = $hak['hak_cuti_tahunan'];
      }
  }

  //}

  if ($insert){

  if ($jenis == "Sakit Tanpa Surat Dokter"){

    //   $jml = $haktahunlalu-$workingDays;
    //   if ($jml<0) {
    //     $potong = mysql_query("UPDATE tb_pegawai SET hak_cuti_tahunlalu= 0.00, hak_cuti_tahunan = (hak_cuti_tahunan - $jml) WHERE nip='$nip'");
    //   }
    //   else {
    //     $potong = mysql_query("UPDATE tb_pegawai SET hak_cuti_tahunlalu= $jml WHERE nip='$nip'");
    //   }
    //   $jarak = TRUE;
    // }

    if ($workingDays < $haktahunlalu){

      $potong = mysql_query("UPDATE tb_pegawai SET hak_cuti_tahunlalu= (hak_cuti_tahunlalu - $workingDays) WHERE nip='$nip'");

      $jarak = TRUE;

    }

    else if($haktahunlalu == 0.00){

      $kuranghak= mysql_query("UPDATE tb_pegawai SET hak_cuti_tahunan= (hak_cuti_tahunan - $workingDays) WHERE nip='$nip'");

      $jarak= TRUE;

    }

    else if($workingDays > $haktahunlalu){

      $kurang = mysql_query("UPDATE tb_pegawai SET hak_cuti_tahunlalu= (hak_cuti_tahunlalu - $workingDays) WHERE nip='$nip'");

    $selectagain=mysql_query("SELECT hak_cuti_tahunlalu FROM tb_pegawai WHERE nip='$nip'");
    $hasil = mysql_fetch_assoc($selectagain);

    $hasilakhir = $hasil['hak_cuti_tahunlalu'] + $workingDays;

    $kuranginlagi=mysql_query("UPDATE tb_pegawai SET hak_cuti_tahunan= (hak_cuti_tahunan - $hasilakhir) WHERE nip='$nip'");

    $updatenol=mysql_query("UPDATE tb_pegawai SET hak_cuti_tahunlalu=0.00 WHERE nip='$nip'");

    $jarak = TRUE;

  }


}


  else if ($jenis == "Datang Telat Lebih Dari 2 Jam" || $jenis == "Pulang Lebih Cepat Lebih Dari 2 Jam") {

    $stgh = 0.50;

    if ($stgh < $haktahunlalu){

    $potong2 =mysql_query("UPDATE tb_pegawai SET hak_cuti_tahunlalu= (hak_cuti_tahunlalu - $stgh) WHERE nip='$nip'");

      $jarak = TRUE;
  }

  else if($haktahunlalu == 0.00){

    $kuranghak2= mysql_query("UPDATE tb_pegawai SET hak_cuti_tahunan= (hak_cuti_tahunan - $stgh) WHERE nip='$nip'");

    $jarak= TRUE;

  }

  else if($stgh > $haktahunlalu){

    $kurang2=mysql_query("UPDATE tb_pegawai SET hak_cuti_tahunlalu= (hak_cuti_tahunlalu - $stgh) WHERE nip='$nip'");

    $selectagain2=mysql_query("SELECT hak_cuti_tahunlalu FROM tb_pegawai WHERE nip='$nip'");
    $hasil2 = mysql_fetch_assoc($selectagain2);

    $hasilakhir2 = $hasil2['hak_cuti_tahunlalu'] + $stgh;

    $kuranginlagi2=mysql_query("UPDATE tb_pegawai SET hak_cuti_tahunan= (hak_cuti_tahunan - $hasilakhir2) WHERE nip='$nip'");

    $updatenol2=mysql_query("UPDATE tb_pegawai SET hak_cuti_tahunlalu=0.00 WHERE nip='$nip'");

    $jarak = TRUE;
  }

  }

  else {

      $jarak = TRUE;

  }


  if ($jarak == TRUE)
  {

    $sampainanti = "$sampaitgl 23:59:59";
    $begin = new DateTime($daritgl);
    $end   = new DateTime($sampainanti);

    $daterange = new DatePeriod($begin, new DateInterval('P1D'), $end);

    foreach($daterange as $date){
      $tanggal = $date->format("Y-m-d");

      $insertrange = mysql_query("INSERT INTO daterange_izin (no_izin,username,tanggal,jenis,persetujuan,gambar) VALUES ('$no','$nip','$tanggal','$jenis','','$nama_gambar')");

    }

    $updatebackdate = mysql_query("UPDATE tb_user SET izinbackdate = NULL WHERE id_user ='$nip'");

    echo "<div class='register-logo'><b>Input Form Izin Sukses!</b>.</div>
      <div class='box box-primary'>
        <div class='register-box-body'>
          <p>Form izin berhasil di ajukan, harap minta persetujuan kepada manager divisi terkait.</p>
          <div class='row'>
            <div class='col-xs-8'></div>
            <div class='col-xs-4'>
              <button type='button' onclick=location.href='home-pegawai2.php?page=history-izin-pegawai' class='btn btn-block btn-warning'>Next</button>
            </div>
          </div>
        </div>
      </div>";
  }
}

  else{
    echo "";
    }
}
?>
</div>
