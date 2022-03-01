<br/><br/><br/>
<!-- Tabel 9 Jam -->
<h4>Laporan Kurang dari 9 Jam</h4>
<div class="table-responsive">
<table id="example2" class="table table-bordered table-striped">
  <thead>
    <tr>
      <th>No</th>
      <th>Nama</th>
      <td>Divisi</th>
      <td>Jumlah Hari</th>
      <td>Total Potongan</th>
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
                                      	COUNT(divisi) AS jml_hari
                                      FROM
                                      	(
                                      		SELECT
                                      			xxx.user_id,
                                      			tb_user.id_user,
                                      			tb_user.nama_user,
                                      			tb_user.divisi,
                                            TIME(xxx.absen_masuk) AS jamnya,
                                            TIME(xxx.absen_pulang) AS pulangnya,
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
                                      					min(tgl_dan_jam),
                                      					max(tgl_dan_jam)
                                      				) AS absen_pulang
                                      				FROM
                                      					absensi
                                      				WHERE
                                      					tgl_dan_jam BETWEEN '$tgl_1' AND '$tgl_2'
                                                AND date(tgl_dan_jam) NOT IN (SELECT tanggal FROM daterange_izin WHERE daterange_izin.id_absen = absensi.user_id)
                                                AND date(tgl_dan_jam) NOT IN (SELECT tanggal FROM kalender)
                                                AND DAYOFWEEK(date(tgl_dan_jam)) = 2
                                                OR
                                                tgl_dan_jam BETWEEN '$tgl_1' AND '$tgl_2'
                                                AND date(tgl_dan_jam) NOT IN (SELECT tanggal FROM daterange_izin WHERE daterange_izin.id_absen = absensi.user_id)
                                                AND date(tgl_dan_jam) NOT IN (SELECT tanggal FROM kalender)
                                                AND DAYOFWEEK(date(tgl_dan_jam)) = 3
                                                OR
                                                tgl_dan_jam BETWEEN '$tgl_1' AND '$tgl_2'
                                                AND date(tgl_dan_jam) NOT IN (SELECT tanggal FROM daterange_izin WHERE daterange_izin.id_absen = absensi.user_id)
                                                AND date(tgl_dan_jam) NOT IN (SELECT tanggal FROM kalender)
                                                AND DAYOFWEEK(date(tgl_dan_jam)) = 4
                                                OR
                                                tgl_dan_jam BETWEEN '$tgl_1' AND '$tgl_2'
                                                AND date(tgl_dan_jam) NOT IN (SELECT tanggal FROM daterange_izin WHERE daterange_izin.id_absen = absensi.user_id)
                                                AND date(tgl_dan_jam) NOT IN (SELECT tanggal FROM kalender)
                                                AND DAYOFWEEK(date(tgl_dan_jam)) = 5
                                                OR
                                                tgl_dan_jam BETWEEN '$tgl_1' AND '$tgl_2'
                                                AND date(tgl_dan_jam) NOT IN (SELECT tanggal FROM daterange_izin WHERE daterange_izin.id_absen = absensi.user_id)
                                                AND date(tgl_dan_jam) NOT IN (SELECT tanggal FROM kalender)
                                                AND DAYOFWEEK(date(tgl_dan_jam)) = 6
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
                                      HOUR(jam_total) < 9
                                      GROUP BY
                                      	user_id
                                      ORDER BY
                                      	nama_user ASC");
      while ($du = mysql_fetch_array($daftaruser)){
        echo "<tr>";
        echo "<td>".$i++."</td>";
        echo "<td>";
        echo "<a data-toggle='collapse' data-parent='#accordion' href='#".$du['id_user']."3'>".$du['nama_user']."</a>";
        echo "<div id='".$du['id_user']."3' class='panel-collapse collapse'>";
        echo "<div class='panel-body'>";
            echo "<div class='table-responsive'>";
            echo "<table class='table table-bordered table-striped'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>No.</th>";
            echo "<th>Tanggal</th>";
            echo "<th>Jam Masuk</th>";
            echo "<th>Jam Pulang</th>";
            echo "<th>Jumlah jam</th>";
            echo "<th>Potongan Rupiah</th>";
            echo "<th>Status Izin</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            $query_otw = mysql_query("SELECT
                                          *
                                        FROM
                                          (
                                          SELECT
                                            xxx.user_id,
                                            xxx.tanggal,
                                            tb_user.id_user,
                                            TIME(xxx.absen_masuk) AS jamnya,
                                            TIME(xxx.absen_pulang) AS pulangnya,
                                            TIMEDIFF( xxx.absen_pulang, xxx.absen_masuk ) AS jam_total
                                          FROM
                                            (
                                            SELECT
                                              user_id,
                                              DATE( tgl_dan_jam ) AS tanggal,
                                              min( tgl_dan_jam ) AS absen_masuk,
                                            IF
                                              ( max( tgl_dan_jam ) = MIN( tgl_dan_jam ), min(tgl_dan_jam), max( tgl_dan_jam ) ) AS absen_pulang
                                            FROM
                                              absensi
                                            WHERE
                                              user_id = '$du[user_id]'
                                              AND tgl_dan_jam BETWEEN '$tgl_1'
                                              AND '$tgl_2' AND date(tgl_dan_jam) NOT IN (SELECT tanggal FROM daterange_izin WHERE username='$du[id_user]')
                                              AND date(tgl_dan_jam) NOT IN (SELECT tanggal FROM kalender)
                                              AND DAYOFWEEK(date(tgl_dan_jam)) = 2
                                              OR
                                              user_id = '$du[user_id]'
                                              AND tgl_dan_jam BETWEEN '$tgl_1'
                                              AND '$tgl_2' AND date(tgl_dan_jam) NOT IN (SELECT tanggal FROM daterange_izin WHERE username='$du[id_user]')
                                              AND date(tgl_dan_jam) NOT IN (SELECT tanggal FROM kalender)
                                              AND DAYOFWEEK(date(tgl_dan_jam)) = 3
                                              OR
                                              user_id = '$du[user_id]'
                                              AND tgl_dan_jam BETWEEN '$tgl_1'
                                              AND '$tgl_2' AND date(tgl_dan_jam) NOT IN (SELECT tanggal FROM daterange_izin WHERE username='$du[id_user]')
                                              AND date(tgl_dan_jam) NOT IN (SELECT tanggal FROM kalender)
                                              AND DAYOFWEEK(date(tgl_dan_jam)) = 4
                                              OR
                                              user_id = '$du[user_id]'
                                              AND tgl_dan_jam BETWEEN '$tgl_1'
                                              AND '$tgl_2' AND date(tgl_dan_jam) NOT IN (SELECT tanggal FROM daterange_izin WHERE username='$du[id_user]')
                                              AND date(tgl_dan_jam) NOT IN (SELECT tanggal FROM kalender)
                                              AND DAYOFWEEK(date(tgl_dan_jam)) = 5
                                              OR
                                              user_id = '$du[user_id]'
                                              AND tgl_dan_jam BETWEEN '$tgl_1'
                                              AND '$tgl_2' AND date(tgl_dan_jam) NOT IN (SELECT tanggal FROM daterange_izin WHERE username='$du[id_user]')
                                              AND date(tgl_dan_jam) NOT IN (SELECT tanggal FROM kalender)
                                              AND DAYOFWEEK(date(tgl_dan_jam)) = 6
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
                                        HOUR(jam_total) < 9");
            $l = 1;
            $xnxx = "";
            $p9j = 0;
            while ($row = mysql_fetch_array($query_otw)) {
            $xnxx .= "<tr>";
            $xnxx .= "<td>".$l++."</td>";
            $xnxx .= "<td>".$row['tanggal']."</td>";
            $xnxx .= "<td>".$row['jamnya']."</td>";
            $xnxx .= "<td>".$row['pulangnya']."</td>";
            $xnxx .= "<td>".$row['jam_total']."</td>";

            $potongan9jam = '15000';

            $xnxx .= "<td>Rp. " . number_format( $potongan9jam, 0 , '' , ',' ) ."</td>";
            $xnxx .= "<td>";

            $cariizinsembilan = mysql_query("SELECT * FROM daterange_izin WHERE username='$row[id_user]' AND tanggal='$row[tanggal]'");
            if (mysql_num_rows($cariizinsembilan) != 0){
                $cis = mysql_fetch_array($cariizinsembilan);
                echo $cis['jenis'];
            }else{
              $xnxx .= "-";
            }
            $xnxx .= "</td>";
            $xnxx .= "</tr>";
            $p9j = $p9j + $potongan9jam;
          }
            echo $xnxx;
            echo "</tbody>";
            echo "</table>";
            echo "</div>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
        echo "</td>";
        echo "</td>";
        echo "<td>".$du['divisi']."</td>";

        $itung = mysql_num_rows($query_otw);

        echo "<td>".$itung."</td>";
        echo "<td>Rp. " . number_format( $p9j, 0 , '' , ',' ) ."</td>";
        echo "</tr>";
      }
      ?>
  </tbody>
</table>
</div>
<!-- //Tabel 9 Jam -->
