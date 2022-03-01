<section class="content-header">
    <h1>Matrix<small>Jabatan</small></h1>
    <ol class="breadcrumb">
        <li><a href="home-hrd.php"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="active">Matrix Jabatan</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
			<div class="box box-primary">
				<div class="box-body">

          <h3>Matrix Jabatan</h3>

          <button type="button" class="btn btn-info btn-small" data-toggle="modal" data-target="#myModal">Add Jabatan</button>

        </br></br>

          <div class="table-responsive">
					<table class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>No</th>
                <th>Jabatan</th>
                <th>Pengganti Pulang Malam 12.5 Jam</th>
								<th>Potongan Telat/Menit</th>
                <th>Lembur Weekeend</th>
                <th>Edit</th>
							</tr>
						</thead>
						<tbody>
              <?php
              include "dist/koneksi.php";
              $i = 1;
              $tampilmatrix= mysql_query("SELECT * FROM matrixjabatan ORDER BY no ASC");
							while($tm = mysql_fetch_array($tampilmatrix)){
              ?>
							<tr>
								<td><?php echo $i++ ?></td>
								<td><?php echo $tm['jabatan'];?></td>
                <td><?php echo 'Rp. ' . number_format( $tm['rupiahlembur'], 0 , '' , ',' ); ?></td>
                <td><?php echo 'Rp. ' . number_format( $tm['rupiahpotongan'], 0 , '' , ',' ); ?></td>
                <td><?php echo 'Rp. ' . number_format( $tm['lemburweekend'], 0 , '' , ',' ); ?></td>
                <td><a href="home-hrd.php?page=edit-matrix-jabatan&no=<?php echo $tm['no']; ?>"><i class="fa fa-edit"></i> Edit</a></td>
							</tr>
            <?php } ?>
						</tbody>
					</table>
        </div>

        </br></br>

        <div class="table-responsive">
        <table id="example1" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama</th>
              <th>Divisi</th>
              <th>Jabatan</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            include "dist/koneksi.php";
            $i = 1;
            $tampiluser = mysql_query("SELECT * FROM tb_user WHERE NOT
                                                                  (divisi = 'Direksi')
                                                                  AND aktif = 'Y'ORDER BY nama_user ASC");
            while($tu = mysql_fetch_array($tampiluser)){
            ?>
            <tr>
              <td><?php echo $i++ ?></td>
              <td><?php echo $tu['nama_user'];?></td>
              <td><?php echo $tu['divisi'];?></td>
              <td><?php echo $tu['level'];?></td>
              <td><a href="#" type="button" class="btn btn-success btn-md" data-toggle="modal" data-target="#myModaldal<?php echo $tu['id_user']; ?>">Edit</a></td>
            </tr>

          <!-- Modal Edit Mahasiswa-->
          <div class="modal fade" id="myModaldal<?php echo $tu['id_user']; ?>" role="dialog">
          <div class="modal-dialog">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit Matrix User</h4>
            </div>
          <div class="modal-body">
            <form action="home-hrd.php?page=proses-edit-matrix-user" method="POST">
            <?php
            $username = $tu['id_user'];
            $query_edit = mysql_query("SELECT * FROM tb_user WHERE id_user='$username'");
            //$result = mysqli_query($conn, $query);
            while ($row = mysql_fetch_array($query_edit)) {
            ?>

            <input type="hidden" name="username" value="<?php echo $row['id_user']; ?>">

            <div class="form-group">
              <label>Nama : </label>
                <input type="text" class="form-control" value="<?php echo $row['nama_user']; ?>" readonly>
            </div>

            <div class="form-group">
              <label>Jabatan : </label>
                <select class="form-control" name="jabatan">
                <option value="<?php echo $row['level']; ?>" selected><?php echo $row['level']; ?></option>
                <?php
                $matrixjab = mysql_query("SELECT * FROM matrixjabatan ORDER BY no ASC");
                while ($key =  mysql_fetch_array($matrixjab)){
                $jabatan = $key['jabatan'];
                echo "<option value='$jabatan'>$jabatan</option>";
                }
                ?>
                </select>
            </div>

            <div class="modal-footer">
            <button type="submit" name="submit" class="btn btn-success">Update</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>

            <?php
            }
            //mysql_close($host);
            ?>
            </form>
          </div>
          </div>

          </div>
          </div>

          <?php } ?>
          </tbody>
        </table>
      </div>


				</div>
			</div>
        </div>
	</div>
</section>

<!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add Matrix Jabatan</h4>
        </div>
        <div class="modal-body">
          <form action="home-hrd.php?page=tambah-matrix-jabatan" method="POST">
            <div class="form-group">
              <label>Jabatan : </label>
                <input type="text" name="jabatan" class="form-control">
            </div>
            <div class="form-group">
              <label>Rupiah Pengganti Pulang Malam (12.5 Jam) : </label>
                <input type="number" name="rupiahlembur" class="form-control">
            </div>
            <div class="form-group">
              <label>Rupiah Potongan Telat/menit : </label>
                <input type="number" name="rupiahpotongan" class="form-control">
            </div>
            <button type="submit" name="submit" class="btn btn-success btn-small">Submit</button>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

<script src="http://code.jquery.com/jquery-1.12.0.min.js"></script>
<script>
  $(function(){
    $('#example1').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });
  });
</script>
