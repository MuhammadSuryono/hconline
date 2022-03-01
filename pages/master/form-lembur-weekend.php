<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.2.3/flatpickr.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.2.3/themes/material_red.css">

<section class="content-header">
    <h1>Form<small>Lembur Weekend</small></h1>
    <ol class="breadcrumb">
        <li><a href="home-manager.php"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="active">Form Lembur Weekend</li>
    </ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-primary">
        <?php
        if ($_SESSION['hak_akses'] == 'HRD'){
          $home = "home-hrd.php";
        }else{
          $home = "home-manager.php";
        }
        ?>
				<form action="<?php echo $home; ?>?page=proses-lembur-weekend" method="POST" enctype="multipart/form-data">
					<div class="box-body">

            <?php
            include "dist/koneksi.php";
            $servername = "localhost";
            $username   = "adam";
            $password   = "Ad@mMR1db";
            $dbname     = "budget";
            $dbname2    = "jay2";
            // membuat koneksi
            $koneksi  = new mysqli($servername, $username, $password, $dbname);
            $koneksi2 = new mysqli($servername, $username, $password, $dbname2);
            ?>

						<div class="form-group">
							<label class="control-label">Tanggal Lembur <span class="glyphicon glyphicon-calendar"></span></label>
  							<input name="tanggal" class="form-control" id="date1" placeholder="MM/DD/YYYY" data-input required>
						</div>

            <div class="form-group">
							<label class="control-label">Nama Karyawan :</label>
                <?php
                $divisi = $_SESSION['divisi'];

                if ($_SESSION['hak_akses'] == 'HRD'){
                  $carinama =  mysql_query("SELECT * FROM tb_user WHERE hak_akses ='Manager' AND aktif='Y'");
                }else{
                  $carinama =  mysql_query("SELECT * FROM tb_user WHERE divisi='$divisi' AND hak_akses !='Manager'");
                }
                while ($cn = mysql_fetch_array($carinama)){
                ?>
                <div class="checkbox">
                  <label><input type="checkbox" name="username[]" value="<?php echo $cn['id_user']; ?>"><?php echo $cn['nama_user']; ?></label>
                </div>
                <?php
                }
                ?>
						</div>

            <div class="form-group">
              <label for="project">Project</label>
              <select class="form-control" name="project" required>
                <option value="">Pilih Nama Project</option>
                <option disabled><--- B1 ---></option>
                <?php
                $project = $koneksi2->query("SELECT * FROM project WHERE visible='Y' ORDER BY nama");
                foreach ($project as $key) {
                ?>
                <option value="<?php echo $key['nama']; ?>"><?php echo $key['nama']; ?></option>
                <?php
                }
                ?>
                <option disabled><--- B2 ---></option>
                <?php
                $projectb2 = $koneksi->query("SELECT * FROM pengajuan WHERE jenis='B2' AND tahun = YEAR(CURDATE()) ORDER BY nama");
                foreach ($projectb2 as $key2) {
                ?>
                <option value="<?php echo $key2['nama']; ?>"><?php echo $key2['nama']; ?></option>
                <?php
                }
                ?>
                <option disabled><--- Lainnya ---></option>
                <option value="Lain-lain">Lain-lain</option>
              </select>
            </div>

            <div class="form-group">
              <label for="tanggal">Keterangan</label>
              <input type="text" name="keterangan" class="form-control">
            </div>

						<br /><br /><br />
						<div class="form-group">
							<button type="submit" name="save" value="save" class="btn btn-danger">Kirim</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>

<!-- jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!--  Flatpickr  -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.2.3/flatpickr.js"></script>
<script>
$("#date1").flatpickr({
    enableTime: false,
    dateFormat: "Y-m-d",
    "disable": [
        function(date) {
           return (date.getDay() === 1 || date.getDay() === 2 || date.getDay() === 3 || date.getDay() === 4 || date.getDay() === 5);  // disable weekends
        }
    ],
    "locale": {
        "firstDayOfWeek": 1 // set start day of week to Monday
    }
});
</script>
