<section class="content-header">
    <h1>History<small>Pengganti Uang Malam</small></h1>
    <ol class="breadcrumb">
        <li><a href="home-hrd.php"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="active">History Pengganti Pulang Malam</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
			<div class="box box-primary">
				<div class="box-body">
					<div>

					</div>


          <?php
          include "../../dist/koneksi.php";
          date_default_timezone_set("Asia/Bangkok");

          $tgl_1 = $_POST['tgl_1'];
          $tgl_2 = $_POST['tgl_2'];

          $tanggalnow = date("Y/m/d");
          $caridivisi = mysql_query("SELECT * FROM tb_lembur WHERE
                                                          tanggal_lembur BETWEEN '$tgl_1' AND '$tgl_2'
                                                          GROUP BY divisi");

          if (mysql_num_rows($caridivisi)==0){
            echo "<p>Tidak ada data lembur</p>";
          }else{
            while ($cd = mysql_fetch_array($caridivisi)){
          $no           = $cd['no'];
          $divisi       = $cd['divisi'];
          $tanggal      = $cd['tanggal_lembur'];
          $nama         = $cd['nama_lembur'];
          $manager      = $cd['manager'];
          $namaarray    = $cd['nama_lembur'];
          $nama_lembur  = explode(',', $namaarray);
          ?>

          <h4>Divisi <?php echo $cd['divisi']; ?></h4>

          <div class="table-responsive">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Nama Karyawan</th>
                <th>Jam Masuk dan Pulang</th>
                <th>Jam Kerja</th>
                <th>Project</th>
                <th>Keterangan</th>
                <th>Jabatan</th>
                <th>Total Pengganti</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $i = 1;
              $carinama = mysql_query("SELECT
                                              *
                                       FROM namalembur
                                       WHERE divisi='$divisi' AND tanggal BETWEEN '$tgl_1' AND '$tgl_2'
                                       ORDER BY tanggal");
              while ($cn = mysql_fetch_array($carinama)){
              ?>
              <tr>
                <td><?php echo $i++ ?>
                <td><?php echo $cn['tanggal']; ?></td>
                <td><?php echo $cn['nama']; ?></td>
                <td>
                  <?php
                  $userid     = $cn['id_absen'];
                  $tanggalnow = $cn['tanggal'];
                  $carijam = mysql_query("SELECT
                                                MAX(tgl_dan_jam) AS maxjam, MIN(tgl_dan_jam) AS minjam
                                          FROM absensi
                                          WHERE user_id='$userid' AND DATE(tgl_dan_jam)='$tanggalnow'");
                  $cj = mysql_fetch_array($carijam);
                  $jammin = $cj['minjam'];
                  $jammax = $cj['maxjam'];

                  $coba = new DateTime($jammin);
                  $coba_jammin = $coba->format('H:i');
                  $coba2 = new DateTime($jammax);
                  $coba_jammax = $coba2->format('H:i');
                  echo $coba_jammin;
                  echo " - ";
                  echo $coba_jammax;
                  ?>
                </td>
                <td>
                  <?php
                  $time1 = strtotime($coba_jammin);
                  $time2 = strtotime($coba_jammax);
                  $difference = round(abs($time2 - $time1) / 3600,2);
                  echo $difference;
                   ?>
                </td>
                <td>
                  <?php
                  $number = $cn['nolembur'];
                  $tampilprojet = mysql_query("SELECT project FROM tb_lembur WHERE no='$number'");
                  $tp = mysql_fetch_array($tampilprojet);
                  echo $tp['project'];
                   ?>
                </td>
                <td>
                  <?php
                  $tampilprojet = mysql_query("SELECT keterangan FROM tb_lembur WHERE no='$number'");
                  $tp = mysql_fetch_array($tampilprojet);
                  echo $tp['keterangan'];
                   ?>
                </td>
                <td>
                  <?php
                  $levelnya = $cn['level'];
                  echo $levelnya;
                  ?>
                </td>
                <td>
                  <?php
                  $cariuang = mysql_query("SELECT * FROM matrixlembur");
                  $cu = mysql_fetch_array($cariuang);
                  $tipejam = $cu['tipelembur'];
                  if($levelnya == 'Office Support' && $difference > $tipejam){
                    echo 'Rp. ' . number_format( $cu['lemburos'], 0 , '' , ',' );
                  }
                  else if($levelnya == 'Staff' && $difference > $tipejam){
                    echo 'Rp. ' . number_format( $cu['lemburstaff'], 0 , '' , ',' );
                  }
                  else if($levelnya == 'Coordinator' && $difference > $tipejam){
                    echo 'Rp. ' . number_format( $cu['lemburcoordinator'], 0 , '' , ',' );
                  }
                  else{
                    echo 'Rp. ' . number_format( 0, 0 , '' , ',' );
                  }
                   ?>
                </td>
              </tr>
              <?php
              }
              ?>
            </tbody>
          </table>
          </div>
        <?php
        }
        }
        ?>
				</div>
			</div>
        </div>
	</div>
</section>
