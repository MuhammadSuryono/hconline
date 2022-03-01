<section class="content-header">
    <h1>Input<small>Data Resign</small></h1>
    <ol class="breadcrumb">
        <li><a href="home-admin.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Input Data Resign</li>
    </ol>
</section>
<div class="register-box">
<?php
	if ($_POST['save'] == "save") {
	$id_user	  = $_POST['id_user'];
	$tglresign  = $_POST['tglresign'];

	include "dist/koneksi.php";
  $ubahstatus	= mysql_query("UPDATE tb_user SET tglresign='$tglresign', resign = 1 WHERE id_user='$id_user'");


		if($ubahstatus){
			echo "<div class='register-logo'><b>Input Data Resign</b> Successful!</div>
				<div class='register-box-body'>
					<p>Input Data Resign Berhasil.</p>
					<div class='row'>
						<div class='col-xs-8'></div>
						<div class='col-xs-4'>
							<button type='button' onclick=location.href='home-admin.php?page=form-master-user' class='btn btn-danger btn-block btn-flat'>Next >></button>
						</div>
					</div>
				</div>";
		}
		else {
			echo "<div class='register-logo'><b>Oops!</b> 404 Error Server.</div>";
		}

	}
?>
</div>
