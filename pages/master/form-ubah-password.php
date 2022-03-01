<section class="content-header">
    <h1>Form<small>Ubah Password</small></h1>
    <ol class="breadcrumb">
        <li><a href="home-pegawai.php"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="active">Form Ubah Password</li>
    </ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-primary">

        <?php
        if ($_SESSION['hak_akses'] == 'Manager'){
          $home = "home-manager.php";
        }
        else if($_SESSION['hak_akses'] == 'Pegawai'){
          $home = "home-pegawai.php";
        }
        else if($_SESSION['hak_akses'] == 'HRD'){
          $home = "home-hrd.php";
        }
        else{
          $home = "home-pegawai2.php";
        }
        ?>

				<form action="<?php echo $home?>?page=proses-ubah-password" class="form-horizontal" method="POST" enctype="multipart/form-data">
					<div class="box-body">

            <input type="hidden" name="id_user" value="<?php echo $_SESSION['id_user']; ?>">

						<div class="form-group">
							<label class="col-sm-3 control-label">Password Lama <font color="red">*</font></label>
							<div class="col-sm-4">
									<input type="password" name="passwordlama" class="form-control" required>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label">Password Baru <font color="red">*</font></label>
							<div class="col-sm-4">
									<input type="password" name="passwordbaru" id="password" class="form-control" required>
							</div>
						</div>

            <div class="form-group">
							<label class="col-sm-3 control-label">ulangi Password Baru <font color="red">*</font></label>
							<div class="col-sm-4">
									<input type="password" id="confirm_password" class="form-control" required>
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-offset-3 col-sm-7">
								<button type="submit" name="save" value="save" class="btn btn-danger">Save</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>

<script>
var password = document.getElementById("password")
  , confirm_password = document.getElementById("confirm_password");

function validatePassword(){
  if(password.value != confirm_password.value) {
    confirm_password.setCustomValidity("Passwords Don't Match");
  } else {
    confirm_password.setCustomValidity('');
  }
}

password.onchange = validatePassword;
confirm_password.onkeyup = validatePassword;
</script>
