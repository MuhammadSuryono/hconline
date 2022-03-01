<section class="content-header">
    <h1>List Exit History</h1>
    <ol class="breadcrumb">
        <li><a href="home-pegawai.php"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="active">List Exit Interview</li>
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
								<th>No</th>
                <th>Nama</th>
                <th>Divisi</th>
								<th>Tanggal Resign</th>
							</tr>
						</thead>

						<tbody>
              <?php
              $Open = mysql_connect("localhost","adam","Ad@mMR!db213");
              $Koneksi = mysql_select_db("dev_exit");
              $i = 1;
              // echo $_SESSION['divisi'];
              if ($_SESSION['hak_akses'] == 'HRD' OR $_SESSION['hak_akses'] == 'Admin') {
                $resign=mysql_query("SELECT * FROM exitinterview ORDER BY nama ASC");
              } else {
                $resign=mysql_query("SELECT * FROM exitinterview WHERE divisi='$_SESSION[divisi]' ORDER BY nama ASC");
              }
              while($user=mysql_fetch_array($resign)){
               ?>
							<tr>
								<td><?php echo $i++ ?></td>
                <td><a href="#" data-toggle="modal" data-target="#detail<?= $user['noid'] ?>"><?= $user['nama'] ?></a></td>
                <td><?php echo $user['divisi'];?></td>
								<td><?php echo $user['tanggal_keluar'];?></td>
                
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




<!-- MODAL DETAIL -->
       <?php $no=1;
              if ($_SESSION['hak_akses'] == 'HRD' OR $_SESSION['hak_akses'] == 'Admin') {
                $resign2=mysql_query("SELECT * FROM exitinterview ORDER BY nama ASC");
              } else {
                $resign2=mysql_query("SELECT * FROM exitinterview WHERE divisi='$_SESSION[divisi]' ORDER BY nama ASC");
              }
        while($user=mysql_fetch_array($resign2)){ $no++;
        ?>
        <div class="modal fade" id="detail<?= $user['noid'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg" role="document" style="min-width: 75%;">
                <div class="modal-content">
                  <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel">Detail Pengisian Exit Interview MRI</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <!-- <div class="table-responsive"> -->
                      <table width="100%" id="tab_detail">
                        <tr>
                          <td width="200"><b>Nama</b></td>
                          <td width="10">:</td>
                          <td><?= $user['nama'] ?></td>
                        </tr>
                        <tr>
                          <td ><b>Divisi</b></td>
                          <td >:</td>
                          <td><?= $user['divisi'] ?></td>
                        </tr>
                        <tr>
                          <td ><b>Tanggal Keluar</b></td>
                          <td >:</td>
                          <td><?= $user['tanggal_keluar'] ?></td>
                        </tr>
                        <tr>
                          <td ><b>Alasan</b></td>
                          <td >:</td>
                          <td><?= $user['alasan'] ?></td>
                        </tr>
                        <?php if($user['alasan'] == 'Pindah Perusahaan') { ?>
                          <tr>
                          <td ><b>Nama Perusahaan</b></td>
                          <td >:</td>
                          <td><?= $user['nama_perusahaan'] ?></td>
                        </tr>
                        <tr>
                          <td ><b>Alasan Pindah Ke Perusahaan Lain</b></td>
                          <td >:</td>
                          <td><?= $user['pindah_perusahaan'] ?></td>
                        </tr>
                        <?php } else { ?>
                        <tr>
                          <td ><b>Alasan Lain</b></td>
                          <td >:</td>
                          <td><?= $user['alasan_lain'] ?></td>
                        </tr>
                            <?php if($user['namakotanegara'] != NULL){ ?>
                              <tr>
                                <td ><b>Nama Kota/Negara</b></td>
                                <td >:</td>
                                <td><?= $user['namakotanegara'] ?></td>
                              </tr>
                            <?php } ?> 
                            <?php if($user['lainnyalasan'] != NULL){ ?>
                              <tr>
                                <td ><b>Alasan Lainnya</b></td>
                                <td >:</td>
                                <td><?= $user['lainnyalasan'] ?></td>
                              </tr>
                            <?php } ?> 
                      <?php } ?>
                        <tr>
                          <td ><b>Yang Memuaskan</b></td>
                          <td >:</td>
                          <td><?= $user['yangmemuaskan'] ?></td>
                        </tr>
                        <tr>
                          <td ><b>Yang Membuat Frustasi</b></td>
                          <td >:</td>
                          <td><?= $user['frustasi'] ?></td>
                        </tr>
                        <tr>
                          <td ><b>Yang Membuat Kesulitan</b></td>
                          <td >:</td>
                          <td><?= $user['kesulitan'] ?></td>
                        </tr>
                        <tr>
                          <td><b>Mempertimbangkan Untuk Kembali </b></td>
                          <td>:</td>
                          <td><?= $user['kembali'] ?> <?php if($user['alasankembali'] != NULL){echo "(".$user['alasankembali'].")";} ?></td>
                        </tr>
                        <tr>
                          <td><b>Kesediaan merekomendasikan Perusahaan ini </b></td>
                          <td>:</td>
                          <td><?= $user['rekomen'] ?> <?php if($user['alasanrekomen'] != NULL){echo "(".$user['alasankembali'].")";} ?></td>
                        </tr>
                        <tr>
                          <td colspan="3"><b>Masukan Untuk Perusahaan</b></td>
                        </tr>
                        <tr>
                          <td>Untuk Management</td>
                          <td>:</td>
                          <td><?= $user['manajemen'] ?></td>
                        </tr>
                        <tr>
                          <td>Untuk Karyawan</td>
                          <td>:</td>
                          <td><?= $user['karyawan'] ?></td>
                        </tr>
                        <tr>
                          <td>Untuk System</td>
                          <td>:</td>
                          <td><?= $user['system'] ?></td>
                        </tr>
                        <tr>
                          <td>Dan lain lain</td>
                          <td>:</td>
                          <td><?= $user['dll'] ?></td>
                        </tr>
                        

                      </table>
                    <!-- </div> -->
                    
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                  </div>
                </div>
              </div>
            </div>
          <?php } ?>


<script>
  $(function () {
    $("#example1").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });
  });
</script>
