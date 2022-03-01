<section class="content-header">
    <h1>History<small>Izin</small></h1>
    <ol class="breadcrumb">
        <li><a href="home-hrd.php"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="active">History Unpaid Leave Karyawan</li>
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
                <th>Nama Karyawan</th>
								<th>Tgl Pengajuan</th>
								<th>Jumlah Hari</th>
								<th>Dari Tanggal</th>
								<th>Sampai Tanggal</th>
								<th>Keterangan</th>
                <th>Gambar</th>
							</tr>
						</thead>
						<tbody>

              <?php
              include "dist/koneksi.php";
              $i = 1;
              $tampilCuti=mysql_query("SELECT * FROM tb_unpaid WHERE divisi='$_SESSION[divisi]' ORDER BY no DESC");
							while($history=mysql_fetch_array($tampilCuti)){
               ?>

							<tr>
								<td><?php echo $i++ ?></td>
								<td><?php echo $history['nama_karyawan'];?> (<?php echo $history['divisi'];?>)</td>
                <td><?php echo $history['pengajuan'];?></td>
								<td><?php echo $history['jml_hari'];?></td>
								<td><?php echo $history['dari'];?></td>
								<td><?php echo $history['sampai'];?></td>
								<td><?php echo $history['keterangan'];?></td>
                <td>
                  <a href="izin/<?php echo $history['gambar']; ?>">
                    <img src="izin/<?php echo $history['gambar']; ?>" width="50" height="50">
                  </a>
                </td>
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
