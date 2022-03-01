<section class="content-header">
    <h1>Input<small>Data User</small></h1>
    <ol class="breadcrumb">
        <li><a href="home-admin.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Input Data User</li>
    </ol>
</section>
<div class="register-box">
<?php
	if ($_POST['save'] == "save") {
	$nama_user	  = $_POST['nama_user'];
	$divisi       = $_POST['divisi'];
	$hak_akses	  = $_POST['hak_akses'];

  function random_username($string) {
  $pattern = " ";
  $firstPart = strstr(strtolower($string), $pattern, true);
  $secondPart = substr(strstr(strtolower($string), $pattern, false), 0,3);
  $nrRand = rand(0, 100);

  $username = trim($firstPart).trim($secondPart).trim($nrRand);
  return $username;
  }

	include "dist/koneksi.php";
	$cekuser	=mysql_num_rows (mysql_query("SELECT nama_user FROM tb_user WHERE nama_user='$_POST[nama_user]'"));

		if (empty($_POST['nama_user']) || empty($_POST['divisi']) || empty($_POST['hak_akses'])) {
		echo "<div class='register-logo'><b>Oops!</b> Data Tidak Lengkap.</div>
			<div class='box box-primary'>
				<div class='register-box-body'>
					<p>Divisi dan hak akses tidak boleh kosong</p>
					<div class='row'>
						<div class='col-xs-8'></div>
						<div class='col-xs-4'>
							<button type='button' onclick=location.href='home-hrd.php?page=form-master-user' class='btn btn-block btn-warning'>Back</button>
						</div>
					</div>
				</div>
			</div>";
		}

		else if($cekuser > 0) {
		echo "<div class='register-logo'><b>Oops!</b> Nama user sudah terdaftar !!</div>
			<div class='box box-primary'>
				<div class='register-box-body'>
					<p>Nama user sudah terdaftar.</p>
					<div class='row'>
						<div class='col-xs-8'></div>
						<div class='col-xs-4'>
							<button type='button' onclick=location.href='home-hrd.php?page=form-master-user' class='btn btn-block btn-warning'>Back</button>
						</div>
					</div>
				</div>
			</div>";
		}

		else{

    $id_user  = random_username($nama_user);
    $password = $id_user;

		$insert = mysql_query("INSERT INTO tb_user (id_user, nama_user, password, divisi, hak_akses, aktif) VALUES ('$id_user', '$nama_user', '12345', '$divisi','$hak_akses', 'Y')");

    $insert2 = mysql_query("INSERT INTO tb_pegawai (nip,nama,divisi) VALUES ('$id_user','$nama_user','$divisi')");

		if($insert && $insert2){
			echo "<div class='register-logo'><b>Input Data</b> Successful!</div>
				<div class='register-box-body'>
					<p>Input Data User Berhasil.</p>
          Nama = $nama_user
          <br>
          Username = $id_user
          <br>
          Password = 12345
					<div class='row'>
						<div class='col-xs-8'></div>
						<div class='col-xs-4'>
							<button type='button' onclick=location.href='home-hrd.php?page=form-master-user' class='btn btn-danger btn-block btn-flat'>Next >></button>
						</div>
					</div>
				</div>";
		}
			else {
				echo "<div class='register-logo'><b>Oops!</b> 404 Error Server.</div>";
			}
		}
	}
?>
</div>
