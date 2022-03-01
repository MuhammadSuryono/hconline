<section class="content-header">
    <h1>Permohonan<small>Cuti</small></h1>
    <ol class="breadcrumb">
        <li><a href="home-pegawai.php"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="active">Permohonan Cuti</li>
    </ol>
</section>
<div class="register-box">
<?php
	include "dist/koneksi.php";
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
	$no_cuti	= kdauto("tb_mohoncuti","");
	$nip		  = $_SESSION['id_user'];
  $nama     = $_SESSION['nama_user'];
  $divisi   = $_SESSION['divisi'];
  $hak_akses= $_SESSION['hak_akses'];
	$tgl		  = date('Y-m-d');


	if ($_POST['save'] == "save") {
	$daritgl	=$_POST['dari'];
	$sampaitgl	=$_POST['sampai'];
  $tahunan=$_POST['tahunan'];
  $saldo=$_POST['saldo'];
  $keterangan=$_POST['keterangan'];
  $nama_gambar=$_FILES['gambar'] ['name'];
  $lokasi=$_FILES['gambar'] ['tmp_name']; // Menyiapkan tempat nemapung gambar yang diupload
  $lokasitujuan="./uploads"; // Menguplaod gambar kedalam folder ./image
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
  $workingDays = number_of_working_days($startDate, $endDate);

	$cekhak  = "SELECT hak_cuti_tahunan,hak_cuti_tahunlalu FROM tb_pegawai WHERE nip='$nip'";
	$query   = mysql_query($cekhak);
	$data    = mysql_fetch_array($query);
	$hak     = $data['hak_cuti_tahunan'];
  $hak2    = $data['hak_cuti_tahunlalu'];
  $totalhak = $hak + $hak2;
  $haktahunlalu = $data['hak_cuti_tahunlalu'];

  if (empty($_POST['dari']) || empty($_POST['sampai'])) {
		echo "<div class='register-logo'><b>Oops!</b> Data Tidak Lengkap.</div>
			<div class='box box-primary'>
				<div class='register-box-body'>
					<p>Harap periksa kembali dan pastikan data yang Anda masukan lengkap dan benar</p>
					<div class='row'>
						<div class='col-xs-8'></div>
						<div class='col-xs-4'>
							<button type='button' onclick=location.href='home-pegawai.php?page=form-permohonan-cuti-tahunan' class='btn btn-block btn-warning'>Back</button>
						</div>
					</div>
				</div>
			</div>";
  }

  else if ($totalhak < $workingDays) {
	   echo "<div class='register-logo'><b>Oops!</b> Hak Cuti Defisit</div>
			<div class='box box-primary'>
				<div class='register-box-body'>
					<p>Periksa kembali tanggal cuti. Hak cuti tersedia adalah <b>$totalhak Hari</b>, jumlah pengajuan <b>$workingDays  Hari</b>.</p>
					<div class='row'>
						<div class='col-xs-8'></div>
						<div class='col-xs-4'>
							<button type='button' onclick=location.href='home-pegawai.php?page=form-permohonan-cuti-tahunan' class='btn btn-block btn-warning'>Back</button>
						</div>
					</div>
				</div>
			</div>";
  }


  //jika sudah berhasil
  else {

    if($workingDays <= $haktahunlalu) {
      $kurang    = mysql_query("UPDATE tb_pegawai SET hak_cuti_tahunlalu= (hak_cuti_tahunlalu - $workingDays) WHERE nip='$nip'");
    }
    if($haktahunlalu <= 0.00){
      $kurang    = mysql_query("UPDATE tb_pegawai SET hak_cuti_tahunan= (hak_cuti_tahunan - $workingDays) WHERE nip='$nip'");
    }
    if($workingDays >= $haktahunlalu){
      $hasilnya  = $totalhak - $workingDays;
      $kurang    = mysql_query("UPDATE tb_pegawai SET hak_cuti_tahunan ='$hasilnya',hak_cuti_tahunlalu=0.00 WHERE nip='$nip'");
    }

    
    $cekku  = "SELECT hak_cuti_tahunan,hak_cuti_tahunlalu FROM tb_pegawai WHERE nip='$nip'";
    $queryku   = mysql_query($cekku);
    $dataku    = mysql_fetch_array($queryku);
    $hak_update     = $dataku['hak_cuti_tahunan'];
    $hak2_update    = $dataku['hak_cuti_tahunlalu'];
    
    if($workingDays <= $haktahunlalu) {
    $insert =mysql_query("INSERT INTO tb_mohoncuti (no_cuti,nip,nama,divisi,hak_akses,tgl,dari,sampai,jml_hari,jenis,saldo,keterangan,gambar,     cutisebelum, cutisesudah) 
                        VALUES
                          ('$no_cuti','$nip','$nama','$divisi','$hak_akses','$tgl','$daritgl','$sampaitgl','$workingDays','Tahun Lalu','$saldo','$keterangan','$nama_gambar', '$hak2', '$hak2_update')");
    } else {
      $insert =mysql_query("INSERT INTO tb_mohoncuti (no_cuti,nip,nama,divisi,hak_akses,tgl,dari,sampai,jml_hari,jenis,saldo,keterangan,gambar, cutisebelum, cutisesudah) 
                        VALUES
                          ('$no_cuti','$nip','$nama','$divisi','$hak_akses','$tgl','$daritgl','$sampaitgl','$workingDays','$tahunan','$saldo','$keterangan','$nama_gambar', '$hak', '$hak_update')");
    }


    $sampainanti = "$sampaitgl 23:59:59";
    $begin = new DateTime($daritgl);
    $end   = new DateTime($sampainanti);

    $daterange = new DatePeriod($begin, new DateInterval('P1D'), $end);

    foreach($daterange as $date){
      $tanggal = $date->format("Y-m-d");

      $insertrange = mysql_query("INSERT INTO daterange_cuti (no_cuti,username,tanggal,persetujuan,gambar) VALUES ('$no_cuti','$nip','$tanggal','','$nama_gambar')");

    }
    echo "<div class='register-logo'><b>Cuti Berhasil Di Input</b></div>
     <div class='box box-primary'>
       <div class='register-box-body'>
         <p>Harap informasikan ke manager divisi terkait untuk di setujui.</p>
         <div class='row'>
           <div class='col-xs-8'></div>
           <div class='col-xs-4'>
             <button type='button' onclick=location.href='home-pegawai.php' class='btn btn-block btn-warning'>Back</button>
           </div>
         </div>
       </div>
     </div>";
  }
}
?>
</div>
