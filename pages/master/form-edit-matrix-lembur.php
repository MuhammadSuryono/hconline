<?php
	if (isset($_GET['no'])) {
	$no = $_GET['no'];
	}
	else {
		die ("Error. No Kode Selected! ");
	}
	include "dist/koneksi.php";
	$ambilData=mysql_query("SELECT * FROM matrixlembur WHERE no='$no'");
	$hasil=mysql_fetch_array($ambilData);
?>
<section class="content-header">
    <h1>Form<small>Edit Maxtrix Lembur <b><?php echo $hasil['tipelembur']; ?> Jam</b></small></h1>
    <ol class="breadcrumb">
        <li><a href="home-admin.php"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="active">Edit Maxtrix Lembur</li>
    </ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-primary">
				<div class="box-body">
					<form class="form-horizontal" action="home-hrd.php?page=proses-edit-matrix-lembur" method="POST">

            <input type="hidden" name="no" value="<?php echo $no; ?>">

						<div class="form-group">
							<label class="col-sm-3 control-label">Jumlah Jam :</label>
							<div class="col-sm-7">
								<input type="text" class="form-control" value="<?=$hasil['tipelembur'];?>" disabled/>
							</div>
						</div>

            <div class="form-group">
							<label class="col-sm-3 control-label">Office Support :</label>
							<div class="col-sm-7">
								<input type="nummber" class="form-control" value="<?=$hasil['Office Support'];?>" name="lemburos"/>
							</div>
						</div>


            <div class="form-group">
							<label class="col-sm-3 control-label">Staff :</label>
							<div class="col-sm-7">
								<input type="nummber" class="form-control" value="<?=$hasil['Staff'];?>" name="lemburstaff"/>
							</div>
						</div>

            <div class="form-group">
							<label class="col-sm-3 control-label">Coordinator :</label>
							<div class="col-sm-7">
								<input type="nummber" class="form-control" value="<?=$hasil['Coordinator'];?>" name="lemburcoordinator"/>
							</div>
						</div>

          <div class="form-group">
            <div class="col-sm-3">
            </div>
            <div class="col-sm-3">
              <button type="submit" class="btn btn-success" name="submit">SUBMIT</button>
            </div>
          </div>

					</form>
				</div>
			</div>
		</div>
	</div>
</section>
