<?php
error_reporting(0);
include "../../dist/koneksi.php";
date_default_timezone_set("Asia/Bangkok");

$tgl_1    = $_POST['tgl_1'];
$tgl_2    = $_POST['tgl_2'];
$username = $_POST['user'];

$getuser = mysql_query("SELECT * FROM tb_user where id_absen='$username'");
$gu = mysql_fetch_assoc($getuser);
$idabsen = $gu['id_absen'];
?>

<h3>Evaluasi Karyawan</h3>
<h4>Nama : <?php echo $gu['nama_user']; ?></h4>
<h5>Periode : <?php echo $tgl_1; ?> s/d <?php echo $tgl_2; ?></h5>

</br></br>

  <div class="table-responsive">
    <table id="example1" class="table table-bordered">
      <thead>
        <tr>
          <th>No. </th>
          <th>Tanggal</th>
          <th>Jam Masuk</th>
          <th>Telat (jam:menit)</th>
          <th>Keterangan</th>
        <tr>
      <thead>
      <tbody>
        <?php

        // $caritelat = mysql_query("SELECT
        //                         	tb_user.nama_user,
        //                         	tb_user.id_user,
        //                         	tb_user.id_absen,
        //                         	tb_user.divisi,
        //                         	date(absensi.tgl_dan_jam) AS tanggal,
        //                           min(absensi.tgl_dan_jam) AS jam_masuk
        //                         FROM
        //                         	absensi
        //                         JOIN tb_user ON tb_user.id_absen = absensi.user_id
        //                         WHERE date(absensi.tgl_dan_jam) BETWEEN '$tgl_1' AND '$tgl_2' AND tb_user.id_user='$username'");

        $caritelat = mysql_query("SELECT
                                  	user_id,
                                  	tanggal,
                                  	TIME(absen_masuk) AS jam_masuk,
                                  	TIME(absen_pulang) AS jam_keluar,
                                  	TIMEDIFF(absen_pulang, absen_masuk) AS jam_total
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
                                  			tgl_dan_jam BETWEEN '$tgl_1'
                                  		AND '$tgl_2'
                                      AND user_id='$username'
                                  		GROUP BY
                                  			user_id,
                                  			tanggal
                                  	) as XXX
                                  ORDER BY
                                  	tanggal ASC");

        $cari_arr = array();
        while ($ct = mysql_fetch_array($caritelat)){
          $cari_arr[$ct['user_id'].$ct['tanggal']] = $ct;
        }

        // print_r($cari_arr);
        $i = 1;
        $pertanggal = mysql_query("SELECT
                                    	user_id,
                                    	DATE(tgl_dan_jam) AS tanggal,
                                      TIME(tgl_dan_jam) AS jam_masuk
                                    FROM
                                    	absensi
                                    WHERE
                                    	user_id = '$username'
                                    AND date(tgl_dan_jam) BETWEEN '$tgl_1'
                                    AND '$tgl_2'
                                    GROUP BY
                                    	date(tgl_dan_jam)");

        while ($row = mysql_fetch_array($pertanggal)){
        $tanggalnya = $row['tanggal'];

            ?>
            <tr>
              <td><?php echo $i++; ?></td>
              <td><?php echo $cari_arr[$username.$tanggalnya]['tanggal']; ?></td>
              <td><?php echo $cari_arr[$username.$tanggalnya]['jam_masuk']; ?></td>
              <td></td>
              <td> ..... </td>
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
