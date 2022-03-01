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

  $no	    =kdauto("tb_unpaid","");
	$nip		=$_SESSION['id_user'];
  $nama   =$_SESSION['nama_user'];
  $divisi =$_SESSION['divisi'];
	$tgl		=date('Y-m-d');


	if ($_POST['save'] == "save") {
	$daritgl	      =$_POST['dari'];
	$sampaitgl	    =$_POST['sampai'];
  $nama_karyawan  =$_POST['nama_karyawan'];
  $keterangan     =$_POST['keterangan'];
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
  $workingDays = number_of_working_days($startDate, $endDate);


	if (empty($_POST['dari']) || empty($_POST['sampai']) || empty($_POST['nama_karyawan'])) {
		echo "<div class='register-logo'><b>Oops!</b> Data Tidak Lengkap.</div>
			<div class='box box-primary'>
				<div class='register-box-body'>
					<p>Harap periksa kembali dan pastikan data yang Anda masukan lengkap dan benar</p>
					<div class='row'>
						<div class='col-xs-8'></div>
						<div class='col-xs-4'>
							<button type='button' onclick=location.href='home-pegawai.php?page=form-izin' class='btn btn-block btn-warning'>Back</button>
						</div>
					</div>
				</div>
			</div>";
	}

  //jika sudah berhasil
  else
  {

    $carinipkary = mysql_query("SELECT id_user FROM tb_user WHERE nama_user='$nama_karyawan'");
    $cnpk = mysql_fetch_assoc($carinipkary);
    $nipkary = $cnpk['id_user'];

    $insert =mysql_query("INSERT INTO tb_unpaid (no,nama_manager,nip_karyawan,nama_karyawan,divisi,pengajuan,dari,sampai,jml_hari,keterangan,gambar)
                          VALUES ('$no','$nama','$nipkary','$nama_karyawan','$divisi','$tgl','$daritgl','$sampaitgl','$workingDays','$keterangan','$nama_gambar')");

  }

  if($insert){

  $sampainanti = "$sampaitgl 23:59:59";
  $begin = new DateTime($daritgl);
  $end   = new DateTime($sampainanti);

  $daterange = new DatePeriod($begin, new DateInterval('P1D'), $end);

  foreach($daterange as $date){
    $tanggal = $date->format("Y-m-d");

    $insertrange = mysql_query("INSERT INTO daterange_unpaid (no_unpaid,username,tanggal,gambar) VALUES ('$no','$nipkary','$tanggal','$nama_gambar')");

  }
  }

  if ($insertrange)
  {
    echo "<script> document.location.href='home-manager.php'; </script>";
  }
}
?>
</div>
