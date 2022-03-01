<section class="content-header">
    <h1>Form<small>Ubah Password</small></h1>
    <ol class="breadcrumb">
        <li><a href="home-admin.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Proses Ubah Password</li>
    </ol>
</section>
<div class="register-box">
<?php
	if ($_POST['save'] == "save") {

  $id_user      = $_POST['id_user'];
  $passwordlama = $_POST['passwordlama'];
  $passwordbaru = $_POST['passwordbaru'];

  $cariuser = mysql_query("SELECT * FROM tb_user WHERE id_user='$id_user'");
  $cu = mysql_fetch_array($cariuser);
  $passnya = $cu['password'];

  if ($cu['hak_akses'] == 'Pegawai'){
    $loading = "home-pegawai.php";
  }
  else if ($cu['hak_akses'] == 'Pegawai2'){
    $loading = "home-pegawai2.php";
  }
  else if ($cu['hak_akses'] == 'Manager'){
    $loading = "home-manager.php";
  }
  else if ($cu['hak_akses'] == 'HRD'){
    $loading = "home-hrd.php";
  }
  else if($cu['hak_akses'] == 'Admin'){
    $loading = "home-admin";
  }

    if($passnya == $passwordlama){

      $updatepass = mysql_query("UPDATE tb_user SET password='$passwordbaru' WHERE id_user='$id_user'");

      echo "<div class='register-logo'><b>Ubah Password Berhasil</b></div>
  			<div class='box box-primary'>
  				<div class='register-box-body'>
  					<p>Password berhasil di ubah !!</p>
  					<div class='row'>
  						<div class='col-xs-8'></div>
  						<div class='col-xs-4'>
  							<button type='button' onclick=location.href='$loading?page=form-ubah-password' class='btn btn-block btn-warning'>Back</button>
  						</div>
  					</div>
  				</div>
  			</div>";


    }else{

      echo "<div class='register-logo'><b>Oops!</b> Rubah password GAGAL!!</div>
  			<div class='box box-primary'>
  				<div class='register-box-body'>
  					<p>Password lama anda salah. Silahkan masukkan password lama dengan benar</p>
  					<div class='row'>
  						<div class='col-xs-8'></div>
  						<div class='col-xs-4'>
  							<button type='button' onclick=location.href='$loading?page=form-ubah-password' class='btn btn-block btn-warning'>Back</button>
  						</div>
  					</div>
  				</div>
  			</div>";
  		}


	}
?>
</div>
