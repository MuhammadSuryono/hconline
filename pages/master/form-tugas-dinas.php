<section class="content-header">
    <h1>Form<small>Tugas dan Dinas</small></h1>
    <ol class="breadcrumb">
        <li><a href="home-pegawai.php"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="active">Form tugas dan dinas</li>
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
        else{
          $home = "home-pegawai2.php";
        }
        ?>

				<form action="<?php echo $home?>?page=proses-tugas-dinas" class="form-horizontal" method="POST" enctype="multipart/form-data">

					<div class="box-body">

            <input type="hidden" name="id_user" value="<?php echo $_SESSION['id_user']; ?>">

            <div class="form-group has-feedback">
							<label class="col-sm-3 control-label">Tanggal :</label>
							<div class="col-sm-4">
								<input type="date" class="form-control" name="tanggal" min="2020-03-21" max="<?php echo date('Y-m-d')?>" required>
							</div>
						</div>

						<div class="form-group has-feedback">
							<label class="col-sm-3 control-label">Jenis :</label>
							<div class="col-sm-4">
								<select name="jenis" class="form-control" required>
									<option value="Tugas">Tugas</option>
								</select>
							</div>
						</div>

            <div class="form-group">
  							<label class="col-sm-3 control-label">Ambil Foto</label>
              <div class="col-sm-4">
                <input type="file" class="form-control" accept="image/*" capture="camera" name="gambar" />
                <span class="middle txt-default">Silahkan ambil foto selfie di tempat tugas atau dinas</span>
              </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Keterangan <span class="required">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <textarea name="keterangan" class="form-control" rows="3"></textarea>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12"></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <button type="button" class="btn btn-warning" onclick="getLocation()">Get Maps</button>
                    <span class="middle txt-default">Klik <b>GET MAPS</b> untuk mendapatkan koordinat lokasi !!</span>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Latitude <span class="required">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="lat" name="latitude" type="text" readonly class="form-control" required>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Longitude <span class="required">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="lon" name="longitude" type="text" readonly class="form-control" required>
                </div>
            </div>

						<br /><br /><br />
						<div class="form-group">
							<div class="col-sm-offset-3 col-sm-7">
								<button type="submit" name="save" value="save" class="btn btn-danger" disabled>Kirim</button>
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

    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else {
            alert("Geolocation is not supported by this browser.");
        }
    }

    function showPosition(position) {
        $("#lat").val(position.coords.latitude);
        $("#lon").val(position.coords.longitude);
    }
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
