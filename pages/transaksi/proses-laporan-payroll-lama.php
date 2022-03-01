<h4>Unpaid Leave</h4>
<div class="table-responsive">
<table id="example1" class="table table-bordered table-striped">
  <thead>
    <tr>
      <th>No</th>
      <th>Nama</th>
      <td>Divisi</th>
      <td>Jumlah Hari</th>
    </tr>
  </thead>
  <tbody>
      <?php
      include "../../dist/koneksi.php";
      date_default_timezone_set("Asia/Bangkok");

      $tgl_1 = $_POST['tgl_1'];
      $tgl_2 = $_POST['tgl_2'];

      $i = 1;
      $daftaruser1 = mysql_query("SELECT * FROM tb_unpaid WHERE dari BETWEEN '$tgl_1' AND '$tgl_2' AND keterangan NOT LIKE '%Mangkir%' GROUP BY nama_karyawan");
      while ($du1 = mysql_fetch_array($daftaruser1)){
      ?>

      <tr>
        <td><?php echo $i++; ?></td>
        <td>
          <a data-toggle="collapse" data-parent="#accordion" href="#<?php echo $du1['nip_karyawan']; ?>"><?php echo $du1['nama_karyawan']; ?>  </a>
          <div id="<?php echo $du1['nip_karyawan']; ?>" class="panel-collapse collapse">
            <div class="panel-body">
              <?php
              $nipkary = $du1['nip_karyawan'];
              $cariunpaid1 = mysql_query("SELECT * FROM tb_unpaid WHERE nip_karyawan='$nipkary' AND dari BETWEEN '$tgl_1' AND '$tgl_2' AND keterangan NOT LIKE '%Mangkir%'");
              while ($cun1 = mysql_fetch_array($cariunpaid1)){
              ?>

              <div class="table-responsive">
              <table class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Keterangan Unpaid</th>
                    <th>Dari Tanggal</th>
                    <th>Sampai Tanggal</th>
                    <th>Jumlah Hari</th>
                  </tr>
                </thead>
                <tbody>
                <tr>
                <td><?php echo $cun1['keterangan']; ?></td>
                <td><?php echo $cun1['dari']; ?></td>
                <td><?php echo $cun1['sampai']; ?></td>
                <td><?php echo $cun1['jml_hari']; ?></td>
                </tr>
              </tbody>
              </table>
            </div>

              <?php
              }
               ?>
            </div>
          </div>
        </div>
        </td>
        <td><?php echo $du1['divisi']; ?></td>
        <td>
          <?php
          $jumlahunpaid = mysql_query("SELECT SUM(jml_hari) AS sumjum FROM tb_unpaid WHERE nip_karyawan='$nipkary' AND dari BETWEEN '$tgl_1' AND '$tgl_2' AND keterangan NOT LIKE '%Mangkir%'");
          $crow = mysql_fetch_array($jumlahunpaid);
          echo $crow['sumjum'];
           ?>
        </td>
      </tr>
      <?php
      }
      ?>
  </tbody>
</table>
</div>

<br/><br/><br/>
<!-- Tabel 9 Jam -->
<h4>Laporan Kehadiran Kurang Dari 9 Jam</h4>
<div class="table-responsive">
<table id="example2" class="table table-bordered table-striped">
  <thead>
    <tr>
      <th>No</th>
      <th>Nama</th>
      <td>Divisi</th>
      <td>Jumlah Hari</th>
    </tr>
  </thead>
  <tbody>
      <?php

      $i = 1;
      $daftaruser = mysql_query("SELECT
                                      	user_id,
                                      	id_user,
                                      	nama_user,
                                      	divisi,
                                      	COUNT(user_id) AS jml_hari
                                      FROM
                                      	(
                                      		SELECT
                                      			xxx.user_id,
                                      			tb_user.id_user,
                                      			tb_user.nama_user,
                                      			tb_user.divisi,
                                      			TIMEDIFF(
                                      				xxx.absen_pulang,
                                      				xxx.absen_masuk
                                      			) AS jam_total
                                      		FROM
                                      			(
                                      				SELECT
                                      					user_id,
                                      					DATE(tgl_dan_jam) AS tanggal,
                                      					min(tgl_dan_jam) AS absen_masuk,
                                      				IF (
                                      					max(tgl_dan_jam) = MIN(tgl_dan_jam),
                                      					NULL,
                                      					max(tgl_dan_jam)
                                      				) AS absen_pulang
                                      				FROM
                                      					absensi
                                      				WHERE
                                      					tgl_dan_jam BETWEEN '$tgl_1' AND '$tgl_2'
                                      				GROUP BY
                                      					user_id,
                                      					tanggal
                                      			) AS xxx
                                      		INNER JOIN tb_user ON xxx.user_id = tb_user.id_absen
                                      		ORDER BY
                                      			xxx.user_id,
                                      			xxx.tanggal ASC
                                      	) AS coba
                                      WHERE
                                      	HOUR (jam_total) < 9
                                      GROUP BY
                                      	user_id
                                      ORDER BY
                                      	nama_user ASC");
      while ($du = mysql_fetch_array($daftaruser)){
        echo "<tr>";
        echo "<td>".$i++."</td>";
        echo "<td>";
        echo "<a data-toggle='collapse' data-parent='#accordion' href='#".$du['id_user']."2'>".$du['nama_user']."</a>";
        echo "<div id='".$du['id_user']."2' class='panel-collapse collapse'>";
        echo "<div class='panel-body'>";

          $query_otw = mysql_query("SELECT
                                        *
                                      FROM
                                        (
                                        SELECT
                                          xxx.user_id,
                                          xxx.tanggal,
                                          tb_user.id_user,
                                          TIMEDIFF( xxx.absen_pulang, xxx.absen_masuk ) AS jam_total
                                        FROM
                                          (
                                          SELECT
                                            user_id,
                                            DATE( tgl_dan_jam ) AS tanggal,
                                            min( tgl_dan_jam ) AS absen_masuk,
                                          IF
                                            ( max( tgl_dan_jam ) = MIN( tgl_dan_jam ), NULL, max( tgl_dan_jam ) ) AS absen_pulang
                                          FROM
                                            absensi
                                          WHERE
                                            user_id = '$du[user_id]'
                                            AND tgl_dan_jam BETWEEN '$tgl_1'
                                            AND '$tgl_2'
                                          GROUP BY
                                            user_id,
                                            tanggal
                                          ) AS xxx
                                          INNER JOIN tb_user ON xxx.user_id = tb_user.id_absen
                                        ORDER BY
                                          xxx.user_id,
                                          xxx.tanggal ASC
                                        ) AS coba
                                      WHERE
                                        HOUR ( jam_total ) < 9");
          while ($row = mysql_fetch_array($query_otw)) {
            echo "<div class='table-responsive'>";
            echo "<table class='table table-bordered table-striped'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>Tanggal</th>";
            echo "<th>Jumlah jam</th>";
            echo "<th>Menit Kurang</th>";
            echo "<th>Potongan Rupiah</th>";
            echo "<th>Status Izin</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            echo "<tr>";
            echo "<td>".$row['tanggal']."</td>";
            echo "<td>".$row['jam_total']."</td>";

            $jamkerja = $row['jam_total'];
            $time1 = strtotime($jamkerja);
            $time2 = strtotime('09:00:00');
            $interval  = $time2 - $time1;
            $detiknya = $interval;
            $menitnya = $detiknya / 60;
            $jadimenit = floor($menitnya);
            $rupiahnya = $jadimenit * 1000;


            echo "<td>$jadimenit</td>";
            echo "<td>Rp. " . number_format( $rupiahnya, 0 , '' , ',' ) ."</td>";
            echo "<td>";

            $cariizinsembilan = mysql_query("SELECT * FROM daterange_izin WHERE username='$row[id_user]' AND tanggal='$row[tanggal]'");
            if (mysql_num_rows($cariizinsembilan) != 0){
                $cis = mysql_fetch_array($cariizinsembilan);
                echo $cis['jenis'];
            }else{
              echo "-";
            }
            echo "</td>";
            echo "</tr>";
            echo "</tbody>";
            echo "</table>";
            echo "</div>";
          }

        echo "</div>";
        echo "</div>";
        echo "</div>";
        echo "</td>";
        echo "</td>";
        echo "<td>".$du['divisi']."</td>";
        echo "<td>".$du['jml_hari']."</td>";
        echo "</tr>";
      }
      ?>
      <!-- <tr>
        <td><?php // echo $i++; ?></td>
        <td>
          <a data-toggle="collapse" data-parent="#accordion" href="#<?php// echo $du['nip_karyawan']; ?>"><?php// echo $du['nama_karyawan']; ?>  </a>
          <div id="<?php // echo $du['nip_karyawan']; ?>" class="panel-collapse collapse">
            <div class="panel-body">
            <?php
              // $nipkary = $du['nip_karyawan'];
              // $cariunpaid = mysql_query("SELECT * FROM tb_unpaid WHERE nip_karyawan='$nipkary' AND dari BETWEEN '$tgl_1' AND '$tgl_2' AND keterangan !='No Work No Pay'");
              // while ($cun = mysql_fetch_array($cariunpaid)){
              ?>

              <div class="table-responsive">
              <table class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Tanggal</th>
                    <th>Jumlah Jam</th>
                    <th>Sampai Tanggal</th>
                    <th>Jumlah Hari</th>
                  </tr>
                </thead>
                <tbody>
                <tr>
                <td><?php // echo $cun['keterangan']; ?></td>
                <td><?php // echo $cun['dari']; ?></td>
                <td><?php // echo $cun['sampai']; ?></td>
                <td><?php // echo $cun['jml_hari']; ?></td>
                </tr>
              </tbody>
              </table>
            </div>

              <?php
              // }
               ?>
            </div>
          </div>
        </div>
        </td>
        <td><?php // echo $du['divisi']; ?></td>
        <td>
          <?php
          // $crow = mysql_num_rows($cariunpaid);
          // echo $crow;
           ?>
        </td>
      </tr> -->
  </tbody>
</table>
</div>
<!-- //Tabel 9 Jam -->
<br/><br/><br/>

<h4>Mangkir (Alpha)</h4>
<div class="table-responsive">
<table id="example1" class="table table-bordered table-striped">
  <thead>
    <tr>
      <th>No</th>
      <th>Nama</th>
      <td>Divisi</th>
      <td>Jumlah Hari</th>
    </tr>
  </thead>
  <tbody>
      <?php
      $i = 1;
      $daftaruser = mysql_query("SELECT * FROM tb_mangkir LEFT JOIN tb_user ON tb_mangkir.username = tb_user.id_user WHERE tanggal BETWEEN '$tgl_1' AND '$tgl_2' GROUP BY nama");
      while ($du = mysql_fetch_array($daftaruser)){
      ?>

      <tr>
        <td><?php echo $i++; ?></td>
        <td>
          <a data-toggle="collapse" data-parent="#accordion" href="#<?php echo $du['username']; ?>3"><?php echo $du['nama']; ?>  </a>
          <div id="<?php echo $du['username']; ?>3" class="panel-collapse collapse">
            <div class="panel-body">
              <?php
              $nipkary = $du['username'];
              $cariunpaid = mysql_query("SELECT * FROM tb_mangkir WHERE username='$nipkary' AND tanggal BETWEEN '$tgl_1' AND '$tgl_2'");
              while ($cun = mysql_fetch_array($cariunpaid)){
              ?>

              <div class="table-responsive">
              <table class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Jenis Pemotongan</th>
                    <th>Tanggal</th>
                    <th>Cuti Terpotong</th>
                  </tr>
                </thead>
                <tbody>
                <tr>
                <td><?php echo $cun['jenis']; ?></td>
                <td><?php echo $cun['tanggal']; ?></td>
                <td><?php echo $cun['pemotongan']; ?></td>
                </tr>
              </tbody>
              </table>
            </div>

              <?php
              }
               ?>
            </div>
          </div>
        </div>
        </td>
        <td><?php echo $du['divisi']; ?></td>
        <td>
          <?php
          $crow = mysql_num_rows($cariunpaid);
          echo $crow;
           ?>
        </td>
      </tr>
      <?php
      }
      ?>
  </tbody>
</table>
</div>

<script>
  $(function () {
    $("#example1").DataTable();
    $("#example3").DataTable();
    $("#example2").DataTable();
    $('#example4').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });
  });
</script>
