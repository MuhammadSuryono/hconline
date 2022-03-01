<section class="content-header">
    <h1>Upload<small>Video</small></h1>
    <ol class="breadcrumb">
        <li><a href="home-hrd.php"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="active">Upload Video</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
			<div class="box box-primary">
				<div class="box-body">
					<div>
					</div>

          <div class="table-responsive">
					<table id="example1" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>No</th>
                <th>Tanggal Upload</th>
								<th>Video</th>
							</tr>
						</thead>
						<tbody>

              <?php
              include "dist/koneksi.php";
              $i = 1;
              $tampilCuti=mysql_query("SELECT * FROM video ORDER BY no ASC");
							while($history=mysql_fetch_array($tampilCuti)){
               ?>

							<tr>
								<td><?php echo $i++;?></td>
								<td><?php echo $history['tanggalupload'];?></td>
                <td><a href="video/<?php echo $history['file'];?>" target="_blank"><?php echo $history['file'];?></a></td>
							</tr>
            <?php } ?>
						</tbody>
					</table>
        </div>

        <br/><br/>

        <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Tambah Video</button>


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
          <h4 class="modal-title">Form Upload Video</h4>
        </div>
        <div class="modal-body">

          <form action="home-admin.php?page=upload-video-proses" method="POST" enctype="multipart/form-data">

          <div class="form-group">
            <input type="file" class="form-control" name="video">
          </div>

          <button type="submit" name="submit" class="btn btn-success">Submit</button>

          </form>


        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>

    </div>
  </div>

<script>
  $(function () {
    $("#example1").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });
  });
</script>
