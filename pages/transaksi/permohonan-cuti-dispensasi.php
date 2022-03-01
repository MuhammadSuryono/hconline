<section class="content-header">
    <h1>Permohonan<small>Cuti Dispensasi</small></h1>
    <ol class="breadcrumb">
        <li><a href="home-pegawai.php"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="active">Permohonan Cuti Dispensasi</li>
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

	$no_cuti	=kdauto("tb_mohoncuti","");
	$nip		=$_SESSION['id_user'];
  $nama		=$_SESSION['nama_user'];
  $divisi =$_SESSION['divisi'];
	$tgl		=date('Y-m-d');

	if ($_POST['save'] == "save") {
	$dari	=$_POST['dari'];
	$sampai	=$_POST['sampai'];
	$jenis	=$_POST['jenis'];
  $saldo = "Dispensasi";
  $nama_gambar=$_FILES['gambar'] ['name'];
  $lokasi=$_FILES['gambar'] ['tmp_name']; // Menyiapkan tempat nemapung gambar yang diupload
  $lokasitujuan="./uploads"; // Menguplaod gambar kedalam folder ./image
  $upload=move_uploaded_file($lokasi,$lokasitujuan."/".$nama_gambar);

	//menghitung jumlah hari
	$selisih = strtotime($sampai) - strtotime($dari);
	$selisih = $selisih/86400;
	$jml_hari = 1 + $selisih;


  $cehhak = mysql_query("SELECT hak_cuti_dispensasi FROM tb_pegawai WHERE nip ='$nip'");
  $hak = mysql_fetch_assoc($cehhak);
  $hd = $hak['hak_cuti_dispensasi'];

	if (empty($_POST['dari']) || empty($_POST['sampai']) || empty($_POST['jenis'])) {
		echo "<div class='register-logo'><b>Oops!</b> Data Tidak Lengkap.</div>
			<div class='box box-primary'>
				<div class='register-box-body'>
					<p>Harap periksa kembali dan pastikan data yang Anda masukan lengkap dan benar</p>
					<div class='row'>
						<div class='col-xs-8'></div>
						<div class='col-xs-4'>
							<button type='button' onclick=location.href='home-pegawai.php?page=form-permohonan-cuti-dispensasi' class='btn btn-block btn-warning'>Back</button>
						</div>
					</div>
				</div>
			</div>";
	}

  else if ($hd < $jml_hari) {
    echo "<div class='register-logo'><b>Oops!</b> Hak Cuti Dispensasi Tidak Cukup.</div>
			<div class='box box-primary'>
				<div class='register-box-body'>
					<p>Harap periksa kembali data yang anda masukkan !!</p>
					<div class='row'>
						<div class='col-xs-8'></div>
						<div class='col-xs-4'>
							<button type='button' onclick=location.href='home-pegawai.php?page=form-permohonan-cuti-dispensasi' class='btn btn-block btn-warning'>Back</button>
						</div>
					</div>
				</div>
			</div>";
  }
  //jika sudah berhasil
  else
  {

    $insert =mysql_query("INSERT INTO tb_mohoncuti (no_cuti,nip,nama,divisi,tgl,dari,sampai,jml_hari,jenis,saldo,gambar)
                          VALUES ('$no_cuti','$nip','$nama','$divisi','$tgl','$dari','$sampai','$jml_hari','$jenis','$saldo','$nama_gambar')");


    $sampainanti = "$sampaitgl 23:59:59";
    $begin = new DateTime($daritgl);
    $end   = new DateTime($sampainanti);

    $daterange = new DatePeriod($begin, new DateInterval('P1D'), $end);

      foreach($daterange as $date){
            $tanggal = $date->format("Y-m-d");

            $insertrange = mysql_query("INSERT INTO daterange_izin (no_cuti,username,tanggal,persetujuan,gambar) VALUES ('$no_cuti','$nip','$tanggal','$jenis','','$nama_gambar')");

      }

    if ($insert){
      echo "<div class='register-logo'>Permohonan Cuti Dispensasi <b>Berhasil</b></div>
  			<div class='box box-primary'>
  				<div class='register-box-body'>
  					<p>Input Data Cuti Berhasil !!</p>
  					<div class='row'>
  						<div class='col-xs-8'></div>
  						<div class='col-xs-4'>
  							<button type='button' onclick=location.href='home-pegawai.php?page=form-permohonan-cuti-dispensasi' class='btn btn-block btn-warning'>Back</button>
  						</div>
  					</div>
  				</div>
  			</div>";
    }
    else{
    echo "GAGAL!!";
    }
  }
	}
?>
</div>
