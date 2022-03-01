<section class="content-header">
    <h1>Edit<small>Data Maxtrix Pengganti Pulang Malam</small></h1>
    <ol class="breadcrumb">
        <li><a href="home-admin.php"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="active">Edit Maxtrix Pengganti Pulang Malam</li>
    </ol>
</section>
<div class="register-box">
<?php
include "dist/koneksi.php";
$no                   = $_POST['no'];
$lemburos             = $_POST['lemburos'];
$lemburstaff          = $_POST['lemburstaff'];
$lemburcoordinator    = $_POST['lemburcoordinator'];

if (isset($_POST['submit'])){

		$update= mysql_query ("UPDATE matrixlembur
                                                SET lemburos ='$lemburos',
                                                  	lemburstaff ='$lemburstaff',
                                                  	lemburcoordinator ='$lemburcoordinator'
                                                WHERE
                                                	   no ='$no'");

    if($update){
			echo "<div class='register-logo'><b>Edit</b> Successful!</div>
				<div class='register-box-body'>
					<p>Edit Maxtrix Pengganti Pulang Malam Berhasil</p>
					<div class='row'>
						<div class='col-xs-8'></div>
						<div class='col-xs-4'>
							<button type='button' onclick=location.href='home-hrd.php?page=form-matrix-lembur' class='btn btn-primary btn-block btn-flat'>Next >></button>
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
