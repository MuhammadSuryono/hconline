<?php
require_once("dist/koneksi.php");
$tgl1 = $_POST['daritgl'];
$tgl2 = $_POST['sampaitgl'];

// $tgl1 = "2020-02-10";
// $tgl2 = "2020-02-14";

if (isset($_POST['submit'])){

  // Data Absen
  $data = mysql_query("SELECT
                                  *,
                                  MIN(jamnya) AS masuk,
                                  IF(jamnya>'08:07:00', 0.5, 0) as rule,
                                  DATE(tgl_dan_jam) as tgl
                              FROM
                                  absensi
                              WHERE
                                  -- user_id = '2245' AND
                                  DATE(tgl_dan_jam) BETWEEN '$tgl1'
                              AND '$tgl2'
                              GROUP BY
                                  user_id,
                                  DATE(tgl_dan_jam)
                              ORDER BY user_id DESC");

  $dataAbsen = [];


  while($db = mysql_fetch_array($data)){

    $nama = $db['user_id'];

        if(array_key_exists($nama, $dataAbsen)){
            $nama1 = $db['tgl'];
            $dataAbsen[$nama][$nama1] = array('masuk' => $db['masuk'], 'rule' => $db['rule']);
        } else {
            $dataAbsen[$nama] = array($db['tgl'] => array('masuk' => $db['masuk'], 'rule' => $db['rule']));
        }

  }
  // Data Absen

  // AKHIR AMBIL DATA IZIN
  $dataIzin = [];
  $data = mysql_query("SELECT
                            *, CASE
                        WHEN jenis = 'Sakit Dengan Surat Dokter' THEN
                            0.5
                        WHEN jenis = 'Sakit Tanpa Surat Dokter' THEN
                            0.75
                        ELSE
                            0
                        END AS rule
                        FROM
                            daterange_izin
                        WHERE
                            tanggal BETWEEN '$tgl1'
                        AND '$tgl2'
                        ORDER BY username ASC");



  while($db = mysql_fetch_array($data)){
      $nama = $db['username'];

      if(array_key_exists($nama, $dataIzin)){
          $nama1 = $db['tanggal'];
          $dataIzin[$nama][$nama1] = array('jenis'=>$db['jenis'], 'rule'=>$db['rule']);
      } else {
          $dataIzin[$nama] = array($db['tanggal'] => array( 'jenis'=>$db['jenis'], 'rule'=>$db['rule']));
      }
  }
  // AKHIR AMBIL DATA IZIN

  // AMBIL DATA CUTI
  $dataCuti = [];
  $data = mysql_query("SELECT
                          *,
                      IF (username != '', 0.5, 0) AS rule
                      FROM
                          daterange_cuti
                      WHERE
                          tanggal BETWEEN '$tgl1'
                      AND '$tgl2'
                      ORDER BY
                          username DESC");

  while($db = mysql_fetch_array($data)) {
      $nama = $db['username'];

      if(array_key_exists($nama, $dataCuti)){
          $nama1 = $db['tanggal'];
          $dataCuti[$nama][$nama1] = $db['rule'];
      } else {
          $dataCuti[$nama] = array($db['tanggal'] => $db['rule']);
      }
  }
  // AKHIR AMBIL DATA CUTI

  // AMBIL DATA UNPAID
  $dataUnpaid = [];
  $data = mysql_query("SELECT
                            *,
                        IF (username != '', 1, 0) AS rule
                        FROM
                            daterange_unpaid
                        WHERE
                            tanggal BETWEEN '$tgl1'
                        AND '$tgl2'
                        ORDER BY
                            username DESC");

  while($db = mysql_fetch_array($data)){
      $nama = $db['username'];

      if(array_key_exists($nama, $dataUnpaid)){
          $nama1 = $db['tanggal'];
          $dataUnpaid[$nama][$nama1] = $db['rule'];
      } else {
          $dataUnpaid[$nama] = array($db['tanggal'] => $db['rule']);
      }
  }
  // AKHIR AMBIL DATA UNPAID

  // INSERT DATA
  $insert = [];

  // $data = $this->db->get_where('tb_user', ['aktif'=>'Y', 'resign'=>0])->result_array();

  $data1 =  mysql_query("SELECT * FROM tb_user WHERE aktif='Y' AND resign='0'");

  // echo '<pre>' . var_export($data1, true) . '</pre>';
  $trun = mysql_query("TRUNCATE ranking");

  // while($tots = mysql_fetch_array($data1)){
  //   echo $tots['id_user'];
  //   echo "<br>";
  // }
  // die;

  // var_dump($data); die;
  while($db = mysql_fetch_array($data1)){
      $tgl11 = $tgl1;
      // echo $tgl11;
      // die;
      $rank = 0; $telat=0; $izin=0; $cuti=0; $unpaid=0;
      $nama1 = $db['id_user'];
      $nama = $db['id_absen'];

      $adaAbsen = array_key_exists($nama, $dataAbsen);
      $adaIzin = array_key_exists($nama1, $dataIzin);
      $adaCuti = array_key_exists($nama1, $dataCuti);
      $adaUnpaid = array_key_exists($nama1, $dataUnpaid);

      while (strtotime($tgl11) <= strtotime($tgl2)) {
      //
          if($adaAbsen==true){
              if(array_key_exists($tgl11, $dataAbsen[$nama])==true){
                  $rank = $rank + (float)$dataAbsen[$nama][$tgl11]['rule'];

                      // RECORD TELAT
                      if($dataAbsen[$nama][$tgl11]['rule'] != 0){
                          $telat++;
                      }
              }
          }
      //
          if($adaIzin==true){
              if(array_key_exists($tgl11, $dataIzin[$nama1])==true){
                  $rank = $rank + (float)$dataIzin[$nama1][$tgl11]['rule'];

                  // RECORD IZIN
                  if($dataIzin[$nama1][$tgl11]['rule']!=0){
                      $izin++;
                  }
              }
          }
      //
          if($adaCuti==true){
              if(array_key_exists($tgl11, $dataCuti[$nama1])==true){
                  $rank = $rank + (float)$dataCuti[$nama1][$tgl11];

                  // RECORD CUTI
                  if($dataCuti[$nama1][$tgl11]!=0){
                      $cuti++;
                  }
              }
          }
      //
          if($adaUnpaid==true){
              if(array_key_exists($tgl11, $dataUnpaid[$nama1])==true){
                  $rank = $rank + (float)$dataUnpaid[$nama1][$tgl11];

                  // RECORD UNPAID
                  if($dataUnpaid[$nama1][$tgl11]!=0){
                      $unpaid++;
                  }
              }
          }
          $tgl11 = date ("Y-m-d", strtotime("+1 day", strtotime($tgl11)));
      }


      $data = [
          'username' => $nama1,
          'telat' => $telat,
          'izin' => $izin,
          'cuti' => $cuti,
          'unpaid' => $unpaid,
          'rank' => $rank,
      ];

      $masuk = mysql_query("INSERT INTO ranking (username,telat,izin,cuti,unpaid,rank) VALUES ('$nama1','$telat','$izin','$cuti','$unpaid','$rank')");

      array_push($insert, $data);
      // echo "t<br>";
  }
  // AKHIR INSERT

  // echo '<pre>' . var_export($insert, true) . '</pre>';
}
?>

<div class="table-responsive">
    <table class="table table-striped table-hover" id="table-1">
        <thead>
            <tr>
            <th>N0</th>
            <th>Nama Karyawan</th>
            <th>Telat</th>
            <th>Izin</th>
            <th>Cuti</th>
            <th>Unpaid</th>
            <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $rank=0;
            $ranklama=-1;
            $no=0;
            $ranking = mysql_query("SELECT a.*, b.nama_user from ranking a left join tb_user b on a.username=b.id_user order by a.rank ASC");
            while($db = mysql_fetch_array($ranking)){
            $no++?>
            <?php
            if($db['rank']>$ranklama){
                $rank++;
            } else {
                $rank = $rank;
            }
                $ranklama = $db['rank'];
            ?>
            <tr>
                <td><?=$no?></td>
                <td>#<?=$rank?> <?=$db['nama_user']?>
                </td>
                <td><?=$db['telat']?></td>
                <td><?=$db['izin']?></td>
                <td><?=$db['cuti']?></td>
                <td><?=$db['unpaid']?></td>
                <td><?=$db['rank']?></td>
            </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>
