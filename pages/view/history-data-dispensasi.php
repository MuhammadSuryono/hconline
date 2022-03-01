<section class="content-header">
    <h1>History<small>Cuti</small></h1>
    <ol class="breadcrumb">
        <li><a href="home-pegawai.php"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="active">History Data Cuti Dispensasi</li>
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
					<table id="example2" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>No.</th>
                <th>Nama (Divisi)</th>
								<th>Tanggal</th>
								<th>Project</th>
                <th>Keterangan</th>
								<th>Jumlah Cuti</th>
							</tr>
						</thead>
						<tbody>

              <?php
              include "dist/koneksi.php";
              $i = 1;
              $dispennya = mysql_query("SELECT
                                        	a.*, b.nama_user nama,
                                        	b.divisi divnya
                                        FROM
                                        	historydispensasi a
                                        JOIN tb_user b ON a.username = b.id_user
                                        ORDER BY
                                        	a.tanggal DESC");
              while($key=mysql_fetch_array($dispennya)){
               ?>
							<tr>
								<td><?php echo $i++; ?></td>
                <td><?php echo $key['nama'];?> (<?php echo $key['divnya'];?>)</td>
								<td><?php echo $key['tanggal'];?></td>
								<td><?php echo $key['project'];?></td>
                <td><?php echo $key['keterangan'];?></td>
								<td><?php echo $key['jumlahcuti'];?></td>
							</tr>
            <?php } ?>
						</tbody>
					</table>
        </div>
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
