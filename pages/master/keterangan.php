<section class="content-header">
    <h1>Data<small>Lengkap</small></h1>
    <ol class="breadcrumb">
        <li><a href="home-hrd.php"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="active">Data Lengkap</li>
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
					<table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th colspan="1"></th>
                <th colspan="2"></th>
                <th colspan="2"><center>Saldo Cuti</center></th>
                <th colspan="2"><center>History Cuti</center></th>
              </tr>
              <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Divisi</th>
                <th><center>Tahun Ini</center></th>
                <th><center>Tahun Lalu</center></th>
                <th><center>Tanggal Cuti</center></th>
              </tr>
            </thead>
						<tbody>

              <?php
              include "dist/koneksi.php";

              $tampilCuti=mysql_query("SELECT * FROM tb_pegawai ORDER BY nama");
              $i=1;
              while($history=mysql_fetch_array($tampilCuti)){
               ?>

							<tr>
								<td><?php echo $i++ ?></td>
                <td><?php echo $history['nama'];?></td>
								<td><?php echo $history['divisi'];?></td>
								<td><?php echo $history['hak_cuti_tahunan'];?></td>
								<td><?php echo $history['hak_cuti_tahunlalu'];?></td>
                  <td>
                  <?php
                  $nip = $history['nip'];
                  $select=mysql_query("SELECT * FROM tb_mohoncuti WHERE nip='$nip'");
                  ?>
                  <table>
                    <tr>
                      <td>
                  <?php
                  while ($c = mysql_fetch_array($select)){
                    echo "<td><b>" . $c['dari'] . "</b> s/d <b>" . $c['sampai'] .  ", &nbsp;</b></td>" . " ";
                  } ?>
                      </td>
                </tr>
                  </table>
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
