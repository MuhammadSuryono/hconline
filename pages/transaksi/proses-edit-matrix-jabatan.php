<section class="content-header">
    <h1>Edit<small>Data Maxtrix User</small></h1>
    <ol class="breadcrumb">
        <li><a href="home-admin.php"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="active">Edit Maxtrix User</li>
    </ol>
</section>
<div class="register-box">
<?php
include "dist/koneksi.php";
$no             = $_POST['no'];
$rupiahlembur   = $_POST['rupiahlembur'];
$rupiahpotongan = $_POST['rupiahpotongan'];
$lemburweekend  = $_POST['lemburweekend'];

if (isset($_POST['submit'])){

		$update= mysql_query("UPDATE matrixjabatan SET rupiahlembur ='$rupiahlembur', rupiahpotongan='$rupiahpotongan', lemburweekend='$lemburweekend' WHERE no='$no'");

    if($update){
			echo "<div class='register-logo'><b>Edit</b> Successful!</div>
				<div class='register-box-body'>
					<p>Edit Matrix Jabatan Berhasil</p>
					<div class='row'>
						<div class='col-xs-8'></div>
						<div class='col-xs-4'>
							<button type='button' onclick=location.href='home-hrd.php?page=view-matrix-jabatan' class='btn btn-primary btn-block btn-flat'>Next >></button>
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
