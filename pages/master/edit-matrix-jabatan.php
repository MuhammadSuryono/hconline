<?php
	if (isset($_GET['no'])) {
	$no = $_GET['no'];
	}
	else {
		die ("Error. No Kode Selected! ");
	}
	include "dist/koneksi.php";
	$ambilData=mysql_query("SELECT * FROM matrixjabatan WHERE no='$no'");
	$hasil=mysql_fetch_array($ambilData);
?>
<section class="content-header">
    <h1>Form<small>Edit Maxtrix <b><?php echo $hasil['jabatan']; ?></b></small></h1>
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
					<form class="form-horizontal" action="home-hrd.php?page=proses-edit-matrix-jabatan" method="POST">

            <input type="hidden" name="no" value="<?php echo $no; ?>">

						<div class="form-group">
							<label class="col-sm-3 control-label">Nama Jabatan :</label>
							<div class="col-sm-7">
								<input type="text" class="form-control" value="<?=$hasil['jabatan'];?>" disabled/>
							</div>
						</div>

            <div class="form-group">
							<label class="col-sm-3 control-label">Rupiah Lembur :</label>
							<div class="col-sm-7">
								<input type="number" class="form-control" value="<?=$hasil['rupiahlembur'];?>" name="rupiahlembur"/>
							</div>
						</div>


            <div class="form-group">
							<label class="col-sm-3 control-label">Rupiah Potongan :</label>
							<div class="col-sm-7">
								<input type="number" class="form-control" value="<?=$hasil['rupiahpotongan'];?>" name="rupiahpotongan"/>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label">Rupiah Lembur Weekend :</label>
							<div class="col-sm-7">
								<input type="number" class="form-control" value="<?=$hasil['lemburweekend'];?>" name="lemburweekend"/>
							</div>
						</div>


          <div class="form-group">
            <div class="col-sm-3">
            </div>
            <div class="col-sm-3">
              <a class="btn btn-danger" href="home-hrd.php?page=view-matrix-jabatan">back</a>
              <button type="submit" class="btn btn-success" name="submit">SUBMIT</button>
            </div>
          </div>

					</form>
				</div>
			</div>
		</div>
	</div>
</section>
