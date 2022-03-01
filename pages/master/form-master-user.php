<section class="content-header">
    <h1>Master<small>Data User</small></h1>
    <ol class="breadcrumb">
        <li><a href="home-admin.php"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="active">Data User</li>
    </ol>
</section>
<?php
	include "dist/koneksi.php";
  date_default_timezone_get('asia/bangkok');
	$tampilUser=mysql_query("SELECT * FROM tb_user ORDER BY nama_user");
?>
<section class="content">
    <div class="row">
        <div class="col-md-12">
			<div class="box box-primary">
				<div class="box-body">
					<div class="panel-group">

						<div class="panel panel-default">
							<div class="panel-heading">
								 <h4 class="panel-title"><i class="fa fa-plus"></i> Add Data User<a data-toggle="collapse" data-target="#formuser" href="#formuser" class="collapsed"></a></h4>
							</div>

							<div id="formuser" class="panel-collapse collapse">
								<div class="panel-body">
									<form action="home-hrd.php?page=master-user" class="form-horizontal" method="POST" enctype="multipart/form-data">

										<div class="form-group">
											<label class="col-sm-3 control-label">Nama User <font color="red">*</font></label>
											<div class="col-sm-7">
												<input type="text" name="nama_user" class="form-control" placeholder="Nama" maxlength="64" required>
											</div>
										</div>

                    <div class="form-group">
											<label class="col-sm-3 control-label">Divisi <font color="red">*</font></label>
											<div class="col-sm-7">
												<select name="divisi" class="form-control">
                          <option value="">Pilih</option>
                          <option value="checker">Checker</option>
                          <option value="DP">DP</option>
                          <option value="Driver">Driver</option>
                          <option value="FIELD B1">FIELD</option>
                          <option value="FINANCE">FINANCE</option>
                          <option value="GA">GA</option>
                          <option value="HC">HC</option>
                          <option value="IT">IT</option>
                          <option value="RE B1">RE B1</option>
                          <option value="RE B2">RE B2</option>
												</select>
											</div>
										</div>

										<div class="form-group">
											<label class="col-sm-3 control-label">Hak Akses <font color="red">*</font></label>
											<div class="col-sm-7">
												<select name="hak_akses" class="form-control">
                          <option value="">Pilih</option>
                          <option value="Pegawai2">Pegawai</option>
                          <option value="Manager">Manager</option>
												</select>
											</div>
										</div>

										<div class="form-group">
											<div class="col-sm-offset-3 col-sm-7">
												<button type="submit" name="save" value="save" class="btn btn-danger">Save</button>
											</div>
										</div>

									</form>
								</div>
							</div>
						</div>
					</div>


          <div class="panel panel-default">
            <div class="panel-heading">
               <h4 class="panel-title"><i class="fa fa-plus"></i> Add Data Resign<a data-toggle="collapse" data-target="#formresign" href="#formuser" class="collapsed"></a></h4>
            </div>
            <div id="formresign" class="panel-collapse collapse">
              <div class="panel-body">
                <form action="home-admin.php?page=proses-resign" class="form-horizontal" method="POST" enctype="multipart/form-data">

                  <div class="form-group">
                    <label class="col-sm-3 control-label">Nama User <font color="red">*</font></label>
                    <div class="col-sm-7">
                      <select class="form-control" name="id_user" required>
                        <option value="" selected>Pilih Nama Karyawan</option>
                        <?php
                        $listkaryawan = mysql_query("SELECT id_user,nama_user,divisi FROM tb_user WHERE resign = 0 AND hak_akses !='HRD' AND level IS NOT NULL ORDER BY nama_user");
                        while ($lk = mysql_fetch_array($listkaryawan)){
                        ?>
                        <option value="<?php echo $lk['id_user']; ?>"><?php echo $lk['nama_user']; ?> - <?php echo $lk['divisi'] ?></option>
                        <?php
                        }
                        ?>
                      </select>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-3 control-label">Tanggal Resign <font color="red">*</font></label>
                    <div class="col-sm-7">
                      <input type="date" class="form-control" name="tglresign" required>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-7">
                      <button type="submit" name="save" value="save" class="btn btn-danger">Save</button>
                    </div>
                  </div>

                </form>
              </div>
            </div>
          </div>
        </div>
				</div>
				<div class="box-body">
					<table id="example1" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>Username</th>
								<th>Nama</th>
                <th>Divisi</th>
								<th>Hak Akses</th>
                <th>Tanggal Resign</th>
								<th>Aktif</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
						<?php
              $i = 1;
							while($user=mysql_fetch_array($tampilUser)){
						?>
							<tr>
								<td><?php echo $user['id_user'];?></td>
								<td><?php echo $user['nama_user'];?></td>
                <td><?php echo $user['divisi']; ?></td>
								<td><?php echo $user['hak_akses'];?></td>
                <td><?php
                      if ($user['tglresign'] == NULL){
                        echo "-";
                      }else{
                        echo $user['tglresign'];
                      }
                      ?>
                </td>
								<td><?php echo $user['aktif'];?></td>
								<td align="center"><a href="home-hrd.php?page=pre-activated-deactivate-user&id_user=<?=$user['id_user'];?>&aktif=<?=$user['aktif'];?>" title="Activated OR Deactivate"><i class="fa  fa-refresh"></i></a></td>
							</tr>
						<?php
              }
						?>
						</tbody>
					</table>
				</div>
			</div>
        </div>
	</div>
</section>

<script>
  $(function () {
    $('#example1').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });
  });
</script>
