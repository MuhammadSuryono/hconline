<?php
date_default_timezone_set("Asia/Bangkok");
$yesterday = date("Y-m-d");
?>

<section class="content-header">
    <h1>Form<small>Cuti Umum</small></h1>
    <ol class="breadcrumb">
        <li><a href="home-pegawai.php"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="active">Form Cuti Umum</li>
    </ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-primary">
				<form action="home-pegawai.php?page=permohonan-cuti-umum" class="form-horizontal" method="POST" enctype="multipart/form-data">
					<div class="box-body">

            <div class="form-group">
							<label class="col-sm-3 control-label">Dari Tanggal <span class="glyphicon glyphicon-calendar"></span></label>
							<div class="col-sm-4">
									<input type="date" name="dari" class="form-control" min="<?php echo $yesterday ?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Sampai Tanggal <span class="glyphicon glyphicon-calendar"></span></label>
							<div class="col-sm-4">
									<input type="date" name="sampai" class="form-control" min="<?php echo $yesterday ?>">
							</div>
						</div>

						<div class="form-group has-feedback">
							<label class="col-sm-3 control-label">Jenis Cuti</label>
							<div class="col-sm-4">
								<select name="jenis" class="form-control">
									<option value="">Pilih</option>
									<option value="Cuti Baptis">Cuti Baptis (2 Hari)</option>
									<option value="Cuti Nikah">Cuti Nikah (3 Hari)</option>
									<option value="Cuti Melahirkan">Cuti Melahirkan (3 Bulan)</option>
									<option value="Cuti Istri Melahirkan">Cuti Istri Melahirkan (2 Hari)</option>
									<option value="Cuti Kematian">Cuti Kematian Keluarga Satu Garis (3 Hari)</option>
                  <option value="Cuti Anak Nikah">Cuti Anak Nikah (2 Hari)</option>
                  <option value="Cuti Anak Nikah">Cuti Khitanan (2 Hari)</option>
                  <option value="Cuti Anak Nikah">Wisuda (1/2 Hari)</option>
								</select>
							</div>
						</div>

            <div class="form-group">
              <label class="col-sm-3 control-label">Upload File</label>
            <div class="col-sm-4">
              <input type="file" class="form-control" accept="image/*" name="gambar" id="fileInput">
              <span class="middle txt-default">Upload Dokumen Terkait !!</span>
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
                if ($(this).val() == "") {
                    $('button:submit').attr('disabled',true);
                    // or, as has been pointed out elsewhere:
                    // $('input:submit').removeAttr('disabled');
                }
                else {
                  $('button:submit').attr('disabled',false);
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
