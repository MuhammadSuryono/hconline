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
            $i = 1;
            $caritelat = mysql_query("SELECT
                                            user_id,
                                            tanggal,
                                            TIME(absen_masuk) AS jam_masuk,
	                                          TIME(absen_pulang) AS jam_keluar,
                                            TIMEDIFF( absen_pulang, absen_masuk ) AS jam_total,
                                            IF(CU)
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
                                                tgl_dan_jam BETWEEN '$tgl_1'
                                                AND '$tgl_2'
                                                AND user_id='$username'
                                                AND TIME(tgl_dan_jam) > '08:06:00' 
                                            GROUP BY
                                                tanggal
                                            ) AS xxx
                                        ORDER BY
                                            tanggal ASC");

            while ($ct = mysql_fetch_array($caritelat)){
            ?>
            <tr>
              <td><?php echo $i++; ?></td>
              <td><?php echo $ct['tanggal']; ?></td>
              <td><?php echo $ct['jam_masuk']; ?></td>
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
