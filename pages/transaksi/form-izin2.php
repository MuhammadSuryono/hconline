<?php
date_default_timezone_set("Asia/Bangkok");
$yesterday = date("Y-m-d");
include "dist/koneksi.php";
$cekdaterange = mysql_query("SELECT izinbackdate FROM tb_user WHERE id_user='$_SESSION[id_user]'");
$cdr = mysql_fetch_array($cekdaterange);

if ($cdr['izinbackdate'] == NULL || $cdr['izinbackdate'] == 0){
  $minback = "min='$yesterday'";
}else{
  $minback = "";
}
?>

<section class="content-header">
    <h1>Form<small>Cuti Tahunan</small></h1>
    <ol class="breadcrumb">
        <li><a href="home-pegawai.php"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="active">Form Izin</li>
    </ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-primary">
				<form action="home-pegawai2.php?page=izin2" class="form-horizontal" method="POST" enctype="multipart/form-data">
					<div class="box-body">

						<div class="form-group">
							<label class="col-sm-3 control-label">Dari Tanggal <span class="glyphicon glyphicon-calendar"></span></label>
							<div class="col-sm-4">
									<input type="date" name="dari" class="form-control" <?php //echo $minback; ?>>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label">Sampai Tanggal <span class="glyphicon glyphicon-calendar"></span></label>
							<div class="col-sm-4">
									<input type="date" name="sampai" class="form-control" <?php //echo $minback; ?>>
							</div>
						</div>

						<div class="form-group has-feedback">
							<label class="col-sm-3 control-label">Jenis Izin</label>
							<div class="col-sm-4">
								<select name="jenis" class="form-control" required>
									<option value="">Pilih</option>
									<option value="Sakit Dengan Surat Dokter">Sakit Dengan Surat Dokter</option>
									<option value="Sakit Tanpa Surat Dokter">Sakit Tanpa Surat Dokter</option>
                  <option value="Dinas">Dinas</option>
                  <option value="Datang Telat Kurang Dari 2 Jam">Datang Telat Kurang Dari 2 Jam</option>
                  <option value="Datang Telat Lebih Dari 2 Jam">Datang Telat Lebih Dari 2 Jam</option>
                  <option value="Pulang Lebih Cepat Kurang Dari 2 Jam">Pulang Lebih Cepat Kurang Dari 2 Jam</option>
                  <option value="Pulang Lebih Cepat Lebih Dari 2 Jam">Pulang Lebih Cepat Lebih Dari 2 Jam</option>
								</select>
							</div>
						</div>

            <div class="form-group">
							<label class="col-sm-3 control-label">Upload File</label>
            <div class="col-sm-4">
              <input type="file" class="form-control" accept="image/*" name="gambar" id="fileInput">
              <span class="middle txt-default">Screenshot Atau Photo Dokumen Terkait</span>
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
