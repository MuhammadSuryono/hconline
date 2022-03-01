<section class="content-header">
    <h1>History<small>Lembur Weekend</small></h1>
    <ol class="breadcrumb">
        <li><a href="home-hrd.php"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="active">History Lembur Weekend</li>
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
                <th>Nama (Divisi)</th>
								<th>Tanggal</th>
								<th>Project</th>
								<th>Keterangan</th>
								<th>Durasi</th>
                <th>Rupiah Lembur</th>
							</tr>
						</thead>
						<tbody>

              <?php
              include "dist/koneksi.php";
              $manager = $_SESSION['id_user'];
              $i = 1;
              if ($_SESSION['hak_akses'] == 'HRD'){
                $liatlembur = mysql_query("SELECT
                                            	a.*,
                                            	b.nama_user AS nama,
                                                b.level AS leveluser,
                                            	b.divisi AS divnya,
                                              b.id_absen AS idusernya,
                                              c.lemburweekend AS lembur
                                            FROM
                                            	lemburweekend a
                                            JOIN tb_user b ON a.username = b.id_user
                                            JOIN matrixjabatan c ON b.level = c.jabatan
                                            ORDER BY a.tanggal DESC");
              }else{
                $liatlembur = mysql_query("SELECT
                                            	a.*,
                                            	b.nama_user AS nama,
                                                b.level AS leveluser,
                                            	b.divisi AS divnya,
                                              b.id_absen AS idusernya,
                                              c.lemburweekend AS lembur
                                            FROM
                                            	lemburweekend a
                                            JOIN tb_user b ON a.username = b.id_user
                                            JOIN matrixjabatan c ON b.level = c.jabatan
                                            where a.manager ='$manager'
                                            ORDER BY a.tanggal DESC");
              }
							while($key = mysql_fetch_array($liatlembur)){
              $username = $key['username'];
              $tanggal  = $key['tanggal'];
              $idusernya = $key['idusernya'];
              ?>
							<tr>
								<td><?php echo $i++ ?></td>
								<td><?php echo $key['nama'];?> (<?php echo $key['divnya'];?>)</td>
                <td><?php echo $key['tanggal'];?></td>
								<td><?php echo $key['project'];?></td>
								<td><?php echo $key['keterangan'];?></td>
                <td>
                  <?php
                  // $caridurasi = mysql_query("SELECT TIMEDIFF(MAX(jamnya),MIN(jamnya)) AS durasi FROM tb_izin WHERE nip='$username' AND dari='$tanggal'");
                  // $cd = mysql_fetch_array($caridurasi);
                  // $durasi = $cd['durasi'];
                  // echo $durasi;

                  $caridurasi = mysql_query("SELECT TIMEDIFF(MAX(jamnya),MIN(jamnya)) AS durasi FROM absensi WHERE `user_id`='$idusernya' AND CAST(tgl_dan_jam AS DATE) = '$tanggal'");
                  $cd = mysql_fetch_array($caridurasi);
                  $durasi = $cd['durasi'];
                  echo $durasi;
                  ?>
                  


                </td>
                <td>  
                  <?php
                //   INI PUNYA BANG TEDI
                  if (strtotime($durasi) >= strtotime('04:00:00') AND strtotime($durasi) <= strtotime('06:00:00')){
                    echo "Rp. ". number_format( $key['lembur'], 0 , '' , ',' );
                  } elseif($durasi == ''){
                    echo "Data Tidak Ditemukan";
                  } else{
                    echo "CUTI DISPENSASI BERTAMBAH ";
                    $caricuti = mysql_query("SELECT hak_cuti_dispensasi FROM tb_pegawai WHERE nip='$username'");
                    $cc = mysql_fetch_array($caricuti);
                    $cuti = $cc['hak_cuti_dispensasi'] + 1;
                    echo "$cuti";

                    $query="UPDATE tb_pegawai SET hak_cuti_dispensasi='$cuti' where nip='$username'";
                    mysqli_query($Koneksi, $query);
                  } 
                // AKHIR PUNYA BANG TEDI

                // PUNYA IWAYRIWAY
                    // $jabatan = $key['leveluser'];
                    // $hasil = mysql_query("SELECT lemburweekend from matrixjabatan where jabatan = '$jabatan'");
                    // $row = mysql_fetch_array($hasil);
                    // echo number_format($row['lemburweekend'], 0 , '' , ',');
                  ?>
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
