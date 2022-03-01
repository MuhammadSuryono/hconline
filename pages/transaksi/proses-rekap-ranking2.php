<?php
error_reporting(0);
require_once("dist/koneksi.php");

$dari     = $_POST['daritgl'];
$sampai   = $_POST['sampaitgl'];
$stsd     = $_POST['stsd'];
$sdsd     = $_POST['sdsd'];
$cuti     = $_POST['cuti'];
$mangkir  = $_POST['mangkir'];
$unpaid   = $_POST['unpaid'];

if (isset($_POST['submit'])){

  if($_POST['cuti'] == 'Cuti'){
    $cutinya = " AND itung_cuti.jmlcuti IS NULL";
  }else{
    $cutinya = "";
  }

  if($_POST['sdsd'] == 'SDSD'){
    $sdsdnya = " AND itung_sdsd.jmlsdsd IS NULL";
  }else{
    $sdsdnya = "";
  }

  if($_POST['stsd'] == 'STSD'){
    $stsdnya = " AND itung_stsd.jmlstsd IS NULL";
  }else{
    $stsdnya = "";
  }

  if($_POST['unpaid'] == 'Unpaid'){
    $unpaidnya = " AND itung_unpaid.jmlunpaid IS NULL";
  }else{
    $unpaidnya = "";
  }

  if($_POST['mangkir'] == 'Mangkir'){
    $mangkir = " AND itung_mangkir.jmlmangkir IS NULL";
  }else{
    $mangkir = "";
  }

  $updatetanggal = mysql_query("UPDATE tanggal_mulaiakhir SET tanggalmulai = '$dari 00:00:00', tanggalakhir = '$sampai 23:59:59'");

?>

<div class="table-responsive">

  <table class="table bordered-table striped-table">
    <head>
      <tr>
        <th>No.</th>
        <th>Nama</th>
        <th>Divisi</th>
        <th>Tidak Telat</th>
        <th>Cuti</th>
        <th>Mangkir</th>
        <th>Unpaid</th>
        <th>SDSD</th>
        <th>STSD</th>
      </tr>
    </head>
    <body>
      <?php
      $caritanggalnya = mysql_query("SELECT
                                        	absensi03.username AS username,
                                        	tb_user.nama_user AS nama,
                                        	tb_user.divisi AS divisi,
                                        	absensi03.JumMasukTdkTelat AS TepatWaktu,
                                        	itung_cuti.jmlcuti AS JumlahCuti,
                                        	itung_mangkir.jmlmangkir AS JumlahMangkir,
                                        	itung_unpaid.jmlunpaid AS JumlahUnpaid,
                                        	itung_sdsd.jmlsdsd AS JumlahSDSD,
                                        	itung_stsd.jmlstsd AS JumlahSTSD,
                                        	tb_user.id_user AS usernametbuser
                                        FROM
                                        	absensi03
                                        JOIN tb_user ON absensi03.user_id = tb_user.id_absen
                                        LEFT JOIN itung_cuti ON absensi03.username = itung_cuti.username
                                        LEFT JOIN itung_sdsd ON absensi03.username = itung_sdsd.username
                                        LEFT JOIN itung_stsd ON absensi03.username = itung_stsd.username
                                        LEFT JOIN itung_unpaid ON absensi03.username = itung_unpaid.username
                                        LEFT JOIN itung_mangkir ON absensi03.username = itung_mangkir.username
                                        WHERE
                                        absensi03.username IS NOT NULL
                                        $cutinya
                                        $sdsdnya
                                        $stsdnya
                                        $unpaidnya
                                        $mangkir
                                        GROUP BY
                                        	absensi03.username
                                        ORDER BY
                                        	absensi03.JumMasukTdkTelat DESC
                                        ");
      $no = 1;
      while ($ct = mysql_fetch_array($caritanggalnya)){
      ?>
      <tr>
        <td><?php echo $no++ ?></td>
        <td><?php echo $ct['nama']; ?></td>
        <td><?php echo $ct['divisi']; ?></td>
        <td><?php echo $ct['TepatWaktu']; ?></td>
        <td><?php echo $ct['JumlahCuti']; ?></td>
        <td><?php echo $ct['JumlahMangkir']; ?></td>
        <td><?php echo $ct['JumlahUnpaid']; ?></td>
        <td><?php echo $ct['JumlahSDSD']; ?></td>
        <td><?php echo $ct['JumlahSTSD']; ?></td>
      </tr>
      <?php
      }
       ?>
    </body>
  </table>

</div>


<?php
}
?>
