<section class="content-header">
    <h1>History<small>Cuti</small></h1>
    <ol class="breadcrumb">
        <li><a href="home-pegawai.php"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="active">History Cuti</li>
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
								<th>No. Cuti</th>
                <th>Nama (Divisi)</th>
								<th>Tgl Pengajuan</th>
								<th>Jumlah Hari</th>
								<th>Dari Tanggal</th>
								<th>Sampai Tanggal</th>
								<th>Jenis Cuti</th>
                <th>Keterangan</th>
                <th>Gambar</th>
								<th>Persetujuan</th>
								<td>Alasan</th>
							</tr>
						</thead>
						<tbody>

              <?php
              include "dist/koneksi.php";

              $tampilCuti=mysql_query("SELECT * FROM tb_mohoncuti WHERE nama='$_SESSION[nama_user]' ORDER BY no_cuti DESC");
              while($history=mysql_fetch_array($tampilCuti)){
               ?>

							<tr>
								<td><?php echo $history['no_cuti'];?></td>
                <td><?php echo $history['nama'];?> (<?php echo $history['divisi'];?>)</td>
								<td><?php echo $history['tgl'];?></td>
								<td><?php echo $history['jml_hari'];?></td>
								<td><?php echo $history['dari'];?></td>
								<td><?php echo $history['sampai'];?></td>
								<td><?php echo $history['jenis'];?></td>
                <td><?php echo $history['keterangan'];?></td>
                <td>
                  <a href="uploads/<?php echo $history['gambar']; ?>">
                    <img src="uploads/<?php echo $history['gambar']; ?>" width="50" height="50">
                  </a>
                </td>
								<td><?php echo $history['persetujuan'];?></td>
								<td><?php echo $history['alasan'];?></td>
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
