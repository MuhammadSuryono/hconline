<section class="content-header">
    <h1>Data<small>Cuti Tahunan</small></h1>
    <ol class="breadcrumb">
        <li><a href="home-hrd.php"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="active">Data Cuti Tahunan</li>
    </ol>
</section>
<?php
	include "dist/koneksi.php";
		//fungsi kode otomatis
		function kdauto($tabel, $inisial){
		$struktur   = mysql_query("SELECT * FROM $tabel");
		$field      = mysql_field_name($struktur,0);
		$panjang    = mysql_field_len($struktur,0);
		$qry  = mysql_query("SELECT max(".$field.") FROM ".$tabel);
		$row  = mysql_fetch_array($qry);
		if ($row[0]=="") {
		$angka=0;
		}
		else {
		$angka= substr($row[0], strlen($inisial));
		}
		$angka++;
		$angka      =strval($angka);
		$tmp  ="";
		for($i=1; $i<=($panjang-strlen($inisial)-strlen($angka)); $i++) {
		$tmp=$tmp."0";
		}
		return $inisial.$tmp.$angka;
		}
	// $tampilPeg=mysql_query("SELECT * FROM tb_pegawai ORDER BY nama");
   $tampilPeg=mysql_query("SELECT * FROM tb_pegawai a JOIN tb_user b ON a.nip=b.id_user WHERE b.aktif='Y' AND b.resign='0' ORDER BY a.nama ASC");
?>
<section class="content">
    <div class="row">
        <div class="col-md-12">
			<div class="box box-primary">
				<div class="box-body">
					<div class="panel-group">

            <?php
            $tahun = date('Y');
            $tmin1 = $tahun - 1;
            $get = mysql_query("SELECT * FROM tb_jumlahcuti WHERE tahun='$tahun' ORDER BY id DESC LIMIT 1");
            if ($get != NULL) {
            $data = mysql_fetch_array($get);
            } else {
              $data['cuti_perbulan'] = "";
            } 
             ?>


            <div class="panel panel-default">
              <div class="panel-heading">
                 <h4 class="panel-title"><i class="fa fa-plus"></i> Add Data Jumlah Cuti & Cuti Bersama<a data-toggle="collapse" data-target="#formaddjumlah" href="#formaddjumlah" class="collapsed"></a></h4>
              </div>
              <div id="formaddjumlah" class="panel-collapse collapse">
                <div class="panel-body">
                  <form action="home-hrd.php?page=input-data-cuti-tahunan" class="form-horizontal" method="POST" enctype="multipart/form-data">
                    <label class="col-sm-12 text-center">Jumlah Cuti Diperoleh & Cuti Bersama</label>
                    <br>
                    <div class="form-group">
                      
                      <div class="col-sm-3">
                        <label>Jumlah Cuti Diperoleh</label>
                        <input type="text" name="cuti_diperoleh" id="cuti_diperoleh" class="form-control" placeholder="Jumlah" maxlength="4" required onkeypress="return hanyaAngka(event)">
                      </div>
                      <div class="col-sm-3">
                        <label>Jumlah Cuti Bersama</label>
                        <input type="text" name="cuti_bersama" id="cuti_bersama" class="form-control" placeholder="Jumlah" maxlength="4" required onkeypress="return hanyaAngka(event)">
                      </div>
                      <div class="col-sm-1">
                        <label>Tahun</label>
                        <input type="text" name="tahun" class="form-control" maxlength="4" value="<?php echo $tahun; ?>" readonly>
                      </div>
                      <div class="col-sm-3">
                        <label>Hasil Penambahan Cuti Per Bulan</label>
                        <input type="text" name="hasil" id="hasil" class="form-control" maxlength="4" value="<?php echo $data['cuti_perbulan'] ?>" readonly>
                      </div>
                      <div class="col-sm-2">
                        <label>Upload SKB</label>
                        <input type="file" name="skb" class="form-control" maxlength="4" required>
                      </div>
                      
                    </div>
                    <br>
                      <div class="col-sm-12 text-center">
                        <button type="submit" name="save_jumlahcb" value="save" class="btn btn-danger">Save</button>
                      </div>
                  </form>
                </div>
              </div>
            </div>

						<div class="panel panel-default">
							<div class="panel-heading">
								 <h4 class="panel-title"><i class="fa fa-plus"></i> Add Data Cuti Tahunan <?php echo $tahun; ?><a data-toggle="collapse" data-target="#formaddcuti" href="#formaddcuti" class="collapsed"></a></h4>
							</div>
							<div id="formaddcuti" class="panel-collapse collapse">
								<div class="panel-body">
									<form action="home-hrd.php?page=input-data-cuti-tahunan" class="form-horizontal" method="POST" enctype="multipart/form-data">
										<div class="form-group">
											<label class="col-sm-3 control-label">Jumlah Cuti Tahunan</label>
											<div class="col-sm-3">
												<?php
												include "dist/koneksi.php";
												$data = mysql_query("SELECT * FROM tb_pegawai ORDER BY nama");
												echo '<select name="nip" onchange="changeValue(this.value)" class="form-control">';
												echo '<option value="">Pilih NIP</option>';
												while ($row = mysql_fetch_array($data)) {
													echo '<option value="'.$row['nip'].'">'. $row['nama'].' - '.$row['divisi'].'</option>';
												}
												echo '</select>';
												?>
											</div>
											<div class="col-sm-3">
												<input type="text" name="hak_cuti_tahunan" class="form-control" placeholder="Jumlah" maxlength="4">
											</div>
											<div class="col-sm-3">
												<button type="submit" name="save" value="save" class="btn btn-danger">Save</button>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>

            <div class="panel panel-default">
							<div class="panel-heading">
								 <h4 class="panel-title"><i class="fa fa-plus"></i> Add Data Cuti Tahun <?php echo $tmin1; ?><a data-toggle="collapse" data-target="#formtahunlalu" href="#formtahunlalu" class="collapsed"></a></h4>
							</div>
							<div id="formtahunlalu" class="panel-collapse collapse">
								<div class="panel-body">
									<form action="home-hrd.php?page=input-data-cuti-tahunlalu" class="form-horizontal" method="POST" enctype="multipart/form-data">
										<div class="form-group">
											<label class="col-sm-3 control-label">Jumlah Cuti Tahun <?php echo $tmin1; ?></label>
											<div class="col-sm-3">
												<?php
												include "dist/koneksi.php";
                        $y = "Y";
												$data = mysql_query("SELECT * FROM tb_pegawai ORDER BY nama");
												echo '<select name="nip" onchange="changeValue(this.value)" class="form-control">';
												echo '<option value="">Pilih NIP</option>';
												while ($row = mysql_fetch_array($data)) {
													echo '<option value="'.$row['nip'].'">'. $row['nama'].' - '.$row['divisi'].'</option>';
												}
												echo '</select>';
												?>
											</div>
											<div class="col-sm-3">
												<input type="text" name="hak_cuti_tahunan" class="form-control" placeholder="Jumlah" maxlength="4">
											</div>
											<div class="col-sm-3">
												<button type="submit" name="save" value="save" class="btn btn-danger">Save</button>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>

            <div class="panel panel-default">
							<div class="panel-heading">
								 <h4 class="panel-title"><i class="fa fa-plus"></i> Add Data Cuti Dispensasi<a data-toggle="collapse" data-target="#formdispensasi" href="#formdispensasi" class="collapsed"></a></h4>
							</div>
							<div id="formdispensasi" class="panel-collapse collapse">
								<div class="panel-body">
									<form action="home-hrd.php?page=input-data-cuti-dispensasi" class="form-horizontal" method="POST" enctype="multipart/form-data">
												<?php
												include "dist/koneksi.php";
                        $servername = "localhost";
                        $username   = "adam";
                        $password   = "Ad@mMR1db";
                        $dbname     = "budget";
                        $dbname2    = "jay2";
                        // membuat koneksi
                        $koneksi  = new mysqli($servername, $username, $password, $dbname);
                        $koneksi2 = new mysqli($servername, $username, $password, $dbname2);
                        ?>

                        <div class="form-group">
                         <label for="nip">Nama : </label>
                           <select class="form-control" name="nip" required>
                             <option value="">Pilih Nama Pegawai</option>
                             <?php
                             $data = mysql_query("SELECT * FROM tb_pegawai ORDER BY nama");
                             while ($row = mysql_fetch_array($data)){
                             ?>
                             <option value="<?php echo $row['nip']?>"><?php echo $row['nama']?></option>
                             <?php
                             }
                             ?>
                           </select>
                        </div>

                        <div class="form-group">
                          <label for="project">Project</label>
                          <select class="form-control" name="project" required>
                            <option value="">Pilih Nama Project</option>
                            <option disabled><--- B1 ---></option>
                            <?php
                            $project = $koneksi2->query("SELECT * FROM project WHERE visible='Y' ORDER BY nama");
                            foreach ($project as $key) {
                            ?>
                            <option value="<?php echo $key['nama']; ?>"><?php echo $key['nama']; ?></option>
                            <?php
                            }
                            ?>
                            <option disabled><--- B2 ---></option>
                            <?php
                            $projectb2 = $koneksi->query("SELECT * FROM pengajuan WHERE jenis='B2' AND tahun = YEAR(CURDATE()) ORDER BY nama");
                            foreach ($projectb2 as $key2) {
                            ?>
                            <option value="<?php echo $key2['nama']; ?>"><?php echo $key2['nama']; ?></option>
                            <?php
                            }
                            ?>
                            <option disabled><--- Lainnya ---></option>
                            <option value="Lain-lain">Lain-lain</option>
                          </select>
                        </div>

                        <div class="form-group">
                          <label for="tanggal">Keterangan</label>
                          <input type="text" name="keterangan" class="form-control">
                        </div>

                        <div class="form-group">
                          <label for="tanggal">Tanggal</label>
                          <input type="date" name="tanggal" class="form-control" required>
                        </div>

                        <div class="form-group">
                          <label for="tanggal">Jumlah Cuti Dispensasi</label>
                          <input type="number" name="jumlahcuti" class="form-control" required>
                        </div>

												<button type="submit" name="save" value="save" class="btn btn-danger">Save</button>

									</form>
								</div>
							</div>
						</div>

            <div class="panel panel-default">
							<div class="panel-heading">
								 <h4 class="panel-title"><i class="fa fa-plus"></i> Add Cuti Khusus Sesuai PP<a data-toggle="collapse" data-target="#formcutikhusus" href="#formcutikhusus" class="collapsed"></a></h4>
							</div>
							<div id="formcutikhusus" class="panel-collapse collapse">
								<div class="panel-body">
                  <form action="home-hrd.php?page=permohonan-cuti-umum" class="form-horizontal" method="POST" enctype="multipart/form-data">
          					<div class="box-body">

                      <div class="form-group">
          							<label class="col-sm-3 control-label">Dari Tanggal <span class="glyphicon glyphicon-calendar"></span></label>
          							<div class="col-sm-4">
          									<input type="date" name="dari" class="form-control">
          							</div>
          						</div>
          						<div class="form-group">
          							<label class="col-sm-3 control-label">Sampai Tanggal <span class="glyphicon glyphicon-calendar"></span></label>
          							<div class="col-sm-4">
          									<input type="date" name="sampai" class="form-control">
          							</div>
          						</div>

                      <div class="form-group has-feedback">
          							<label class="col-sm-3 control-label">Pilih Nama Pegawai</label>
          							<div class="col-sm-4">
                          <?php
  												include "dist/koneksi.php";
                          $y = "Y";
  												$data = mysql_query("SELECT * FROM tb_pegawai ORDER BY nama");
  												echo '<select name="nip" onchange="changeValue(this.value)" class="form-control">';
  												echo '<option value="">Pilih Nama Pegawai</option>';
  												while ($row = mysql_fetch_array($data)) {
  													echo '<option value="'.$row['nip'].'">'. $row['nama'].' - '.$row['divisi'].'</option>';
  												}
  												echo '</select>';
  												?>
          							</div>
          						</div>

          						<div class="form-group has-feedback">
          							<label class="col-sm-3 control-label">Jenis Cuti</label>
          							<div class="col-sm-4">
          								<select name="jenis" class="form-control">
          									<option selected disabled value="">Pilih</option>
          									<option value="Cuti Baptis">Cuti Baptis (2 Hari)</option>
          									<option value="Cuti Nikah">Cuti Nikah (3 Hari)</option>
          									<option value="Cuti Melahirkan">Cuti Melahirkan (3 Bulan)</option>
          									<option value="Cuti Istri Melahirkan">Cuti Istri Melahirkan (2 Hari)</option>
          									<option value="Cuti Kematian">Cuti Kematian Keluarga(suami/istri/anak/orang tua/mertua) (3 Hari)</option>
                            <option value="Cuti Anak Nikah">Cuti Anak Nikah (2 Hari)</option>
                            <option value="Cuti Khitanan">Cuti Khitanan (2 Hari)</option>
                            <option value="Cuti Wisuda">Wisuda (1/2 Hari)</option>
                            <option value="Cuti Ibadah Naik Haji">Ibadah Naik Haji Pertama</option>
                            <option value="Cuti Memenuhi Panggilan Pihak Berwajib">Memenuhi Panggilan Pihak Berwajib</option>
          								</select>
          							</div>
          						</div>

                      <!-- <div class="form-group">
                        <label class="col-sm-3 control-label">Upload File</label>
                      <div class="col-sm-4">
                        <input type="file" class="form-control" accept="image/*" name="gambar" id="fileInput">
                        <span class="middle txt-default">Upload Dokumen Terkait !!</span>
                      </div>
                    </div> -->

          						<br /><br /><br />
          						<div class="form-group">
          							<div class="col-sm-offset-3 col-sm-7">
          								<button type="submit" name="save" value="save" class="btn btn-danger">Kirim</button>
          							</div>
          						</div>
          					</div>
          				</form>
								</div>
							</div>
						</div>


            <div class="panel panel-default">
							<div class="panel-heading">
								 <!-- <h4 class="panel-title"><i class="fa fa-plus"></i> Add izin/cuti backdate<a data-toggle="collapse" data-target="#formizinbackdate" href="#formizinbackdate" class="collapsed"></a></h4> -->
							</div>
							<div id="formizinbackdate" class="panel-collapse collapse">
								<div class="panel-body">
                  <form action="home-hrd.php?page=proses-izin-backdate" class="form-horizontal" method="POST" enctype="multipart/form-data">
          					<div class="box-body">

                      <div class="form-group has-feedback">
          							<label class="col-sm-3 control-label">Pilih Nama Pegawai</label>
          							<div class="col-sm-4">
                          <?php
  												include "dist/koneksi.php";
                          $y = "Y";
  												$data = mysql_query("SELECT * FROM tb_pegawai ORDER BY nama");
  												echo '<select name="nip" onchange="changeValue(this.value)" class="form-control">';
  												echo '<option value="">Pilih Nama Pegawai</option>';
  												while ($row = mysql_fetch_array($data)) {
  													echo '<option value="'.$row['nip'].'">'. $row['nama'].' - '.$row['divisi'].'</option>';
  												}
  												echo '</select>';
  												?>
          							</div>
          						</div>

          						<br /><br />
          						<div class="form-group">
          							<div class="col-sm-offset-3 col-sm-7">
          								<button type="submit" name="save" value="save" class="btn btn-danger">Kirim</button>
          							</div>
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
                <th>No</th>
								<th>NIP</th>
								<th>Nama</th>
                <th>Divisi</th>
                <th>Jabatan</th>
								<th>Sisa Hak Cuti Tahun <?php echo date("Y"); ?></th>
                <th>Sisa Hak Cuti Tahun <?php echo date('Y', strtotime('-1 year'));; ?></th>
                <th>Hak Cuti Dispensasi</th>
                <th>Total Hak Cuti</th>
							</tr>
						</thead>
						<tbody>
						<?php
              $no = 1;
							while($peg=mysql_fetch_array($tampilPeg)){
						?>
							<tr>
                <td><?php echo $no++; ?></td>
								<td><?php echo $peg['nip'];?></td>
								<td><?php echo $peg['nama'];?></td>
                <td><?php echo $peg['divisi'];?></td>
                <td>
                  <?php
                  $nip = $peg['nip'];
                  $ceklevel = mysql_query("SELECT level FROM tb_user WHERE id_user='$nip'");
                  $cl = mysql_fetch_assoc($ceklevel);
                  echo $cl['level'];
                  ?>
                </td>
								<td align="center"><?php echo $peg['hak_cuti_tahunan'];?> Hari</td>
                <td align="center"><?php echo $peg['hak_cuti_tahunlalu'];?> Hari</td>
                <td align="center"><?php echo $peg['hak_cuti_dispensasi'];?> Hari</td>
                <td align="center"><?php echo $peg['hak_cuti_dispensasi'] + $peg['hak_cuti_tahunlalu'] + $peg['hak_cuti_tahunan'];?> Hari</td>
                <!-- <td><center><button type="button" class="btn btn-info btn-small" onclick="view_cuti('<?php //echo $peg['nip']; ?>','<?php //echo $peg['nama']; ?>')">History</button></center></td> -->
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

<div class="modal fade" id="myModal" role="dialog">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">History Pemotongan Cuti</h4>
              </div>
              <div class="modal-body">
                  <div class="fetched-data"></div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Keluar</button>
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
<!-- datepicker -->
<script type="text/javascript" src="plugins/datepicker/jquery/jquery-1.8.3.min.js" charset="UTF-8"></script>
<script type="text/javascript" src="plugins/datepicker/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="plugins/datepicker/js/locales/bootstrap-datetimepicker.id.js" charset="UTF-8"></script>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

<script type="text/javascript">
  $(document).ready(function() {
        $("#cuti_diperoleh, #cuti_bersama").keyup(function() {
            var cuti_diperoleh  = $("#cuti_diperoleh").val();
            var cuti_bersama = $("#cuti_bersama").val();

            var hasil = ((parseInt(cuti_diperoleh) - parseInt(cuti_bersama))/12).toFixed(2);

            $("#hasil").val(hasil);
        });
    });

  function hanyaAngka(evt) {
      var charCode = (evt.which) ? evt.which : event.keyCode
       if (charCode > 31 && (charCode < 48 || charCode > 57))
 
        return false;
      return true;
    }

	 $('.form_date').datetimepicker({
			language:  'id',
			weekStart: 1,
			todayBtn:  1,
	  autoclose: 1,
	  todayHighlight: 1,
	  startView: 2,
	  minView: 2,
	  forceParse: 0
		});

    function view_cuti(nip,nama){
      // alert(noid+' - '+waktu);
      $.ajax({
          type : 'post',
          url : 'pemotongancuti',
          data :  {nip:nip, nama:nama},
          success : function(data){
            $('.fetched-data').html(data);//menampilkan data ke dalam modal
            $('#myModal').modal();
          }
      });
    }
</script>
