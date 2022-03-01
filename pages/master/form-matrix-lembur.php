<section class="content-header">
    <h1>Master<small>Matrix Pengganti Uang Malam</small></h1>
    <ol class="breadcrumb">
        <li><a href="home-admin.php"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="active">Pengganti Uang Malam</li>
    </ol>
</section>
<section class="content">
				<div class="box-body">
					<table id="example1" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>#No.</th>
								<th>Jumlah Jam Kerja</th>
								<th>Office Support</th>
								<th>Staff</th>
								<th>Coordinator</th>
                <th>Edit</th>
							</tr>
						</thead>
						<tbody>
						<?php
              include "./dist/koneksi.php";
              $i = 1;
              $carimatrix = mysql_query("SELECT * FROM matrixlembur");
							while($cm = mysql_fetch_array($carimatrix)){
						?>
							<tr>
								<td><?php echo $i++;?></td>
                <td><?php echo $cm['tipelembur'];?> Jam</td>
								<td><?php echo 'Rp. ' . number_format( $cm['Office Support'], 0 , '' , ',' ); ?></td>
								<td><?php echo 'Rp. ' . number_format( $cm['Staff'], 0 , '' , ',' ); ?></td>
								<td><?php echo 'Rp. ' . number_format( $cm['Coordinator'], 0 , '' , ',' ); ?></td>
                <td class="tools">
                  &nbsp;&nbsp;&nbsp;&nbsp;
                  <a href="home-hrd.php?page=form-edit-matrix-lembur&no=<?php echo $cm['no']; ?>" title="edit"><i class="fa fa-edit"></i></a>
                </td>
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
