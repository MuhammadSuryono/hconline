<section class="content-header">
    <h1>Form<small>Izin</small></h1>
    <ol class="breadcrumb">
        <li><a href="home-manager.php"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="active">Form Izin</li>
    </ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-primary">
				<form action="home-manager.php?page=lembur-proses" class="form-horizontal" method="POST" enctype="multipart/form-data">
					<div class="box-body">

						<div class="form-group">
							<label class="col-sm-3 control-label">Tanggal Lembur <span class="glyphicon glyphicon-calendar"></span></label>
							<div class="col-sm-4">
									<input type="date" name="tanggal_lembur" class="form-control">
							</div>
						</div>

						<div class="form-group has-feedback">
							<label class="col-sm-3 control-label">Nama Karyawan :</label>
              <?php
              $divisi = $_SESSION['divisi'];
              $karyawan = mysql_query("SELECT id_user,nama_user FROM tb_user WHERE divisi='$divisi'");
              while($d=mysql_fetch_array($karyawan)){
               ?>
               <div class="checkbox-inline">
                 <label><input type="checkbox" value="<?php echo $d['nama_user'] ?>" name="nama_lembur[]"><?php echo $d['nama_user'] ?></label>
               </div>
              <?php
              }
              ?>
						</div>

            <div class="form-group">
              <label class="col-sm-3 control-label">Project :</label>
              <div class="col-sm-4">
                <select class="form-control" name="project" required>
                  <option selected disabled value="">Pilih Project</option>
                  <?php
                  $servername = "localhost";
                  $username = "adam";
                  $password = "Ad@mMR1db";
                  $dbname = "jay2";
                  $dbname2 = "budget";

                  // membuat koneksi
                  $koneksi  = new mysqli($servername, $username, $password, $dbname);
                  $koneksi2 = new mysqli($servername, $username, $password, $dbname2);

                  // melakukan pengecekan koneksi
                  if ($koneksi->connect_error) {
                      die("Connection failed: " . $koneksi->connect_error);
                  }

                  $cariproject = "SELECT kode,nama FROM project WHERE visible='y'";
                  $run_cariproject = $koneksi->query($cariproject);
                  while ($rc = mysqli_fetch_array($run_cariproject)){
                  $namapro = $rc['nama'];
                  echo "<option value='$namapro'>$namapro</option>";
                  }

                  $cariproject2     = "SELECT nama FROM pengajuan WHERE jenis='B2'";
                  $run_cariproject2 = $koneksi2->query($cariproject2);
                  while ($rc2 = mysqli_fetch_array($run_cariproject2)){
                  $namapro2 = $rc2['nama'];
                  echo "<option value='$namapro2'>$namapro2</option>";
                  }
                  ?>
                  <option value="Lainnya">Lainnya</option>
                </select>
              </div>
            </div>

            <div class="form-group">
							<label class="col-sm-3 control-label">Keterangan :</label>
							<div class="col-sm-4">
									<textarea name="keterangan" class="form-control"></textarea>
							</div>
						</div>

						<br /><br /><br />
						<div class="form-group">
							<div class="col-sm-offset-3 col-sm-7">
								<button type="submit" name="save" value="save" class="btn btn-danger">Kirim</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>

<script>
$(document).ready(
    function(){
        $('input:file').change(
            function(){
                if ($(this).val()) {
                    $('button:submit').attr('disabled',false);
                    // or, as has been pointed out elsewhere:
                    // $('input:submit').removeAttr('disabled');
                }
            }
            );
    });
</script>


<!-- datepicker -->
<script type="text/javascript" src="plugins/datepicker/jquery/jquery-1.8.3.min.js" charset="UTF-8"></script>
<script type="text/javascript" src="plugins/datepicker/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="plugins/datepicker/js/locales/bootstrap-datetimepicker.id.js" charset="UTF-8"></script>
<script type="text/javascript">
	 $('.form_date').datetimepicker({
			language:  'id',
			weekStart: 1,
			todayBtn:  1,
	  autoclose: 1,
	  todayHighlight: 1,
	  startView: 2,
	  minView: 2,
	  forceParse: 0
		});
</script>
