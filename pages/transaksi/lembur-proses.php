<section class="content-header">
    <h1>Permohonan<small>Cuti</small></h1>
    <ol class="breadcrumb">
        <li><a href="home-manager.php"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="active">Permohonan Cuti</li>
    </ol>
</section>
<div class="register-box">
<?php
  //error_reporting(0);
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

  $nolembur       =   kdauto("tb_lembur","");
	$tanggal_lembur	=   $_POST['tanggal_lembur'];
  $namalembur     =   $_POST['nama_lembur'];
  $nama_lembur    =   implode(',', $_POST['nama_lembur']);
  $project        =   $_POST['project'];
  $keterangan     =   $_POST['keterangan'];


	if (empty($_POST['tanggal_lembur']) || empty($_POST['keterangan'])){
		echo "<div class='register-logo'><b>Oops!</b> Data Tidak Lengkap.</div>
			<div class='box box-primary'>
				<div class='register-box-body'>
					<p>Harap periksa kembali dan pastikan data yang Anda masukan lengkap dan benar</p>
					<div class='row'>
						<div class='col-xs-8'></div>
						<div class='col-xs-4'>
							<button type='button' onclick=location.href='home-manager.php?page=form-lembur' class='btn btn-block btn-warning'>Back</button>
						</div>
					</div>
				</div>
			</div>";
	}

  //jika sudah berhasil
  else
  {

  $insert =mysql_query("INSERT INTO tb_lembur (no,manager,nama_lembur,divisi,pengajuan,tanggal_lembur,keterangan,project)
                          VALUES ('$nolembur','$nama','" . $nama_lembur . "','$divisi','$tgl','$tanggal_lembur','$keterangan','$project')");

  foreach ($namalembur as $namlem) {

  $carilevel = mysql_query("SELECT id_user,divisi,id_absen,level FROM tb_user WHERE nama_user='$namlem'");
  $cl = mysql_fetch_assoc($carilevel);
  $nipuser  = $cl['id_user'];
  $divuser  = $cl['divisi'];
  $idabsen  = $cl['id_absen'];
  $level    = $cl['level'];

  $insernama = mysql_query("INSERT INTO namalembur (nolembur,nip,nama,id_absen,tanggal,divisi,level)
                                            VALUES ('$nolembur','$nipuser','$namlem','$idabsen','$tanggal_lembur','$divuser','$level')");

  }

}
  if ($insert)
  {
    echo "<script> document.location.href='home-manager.php'; </script>";
  }

}
?>
</div>
