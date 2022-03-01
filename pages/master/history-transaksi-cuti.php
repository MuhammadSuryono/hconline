<?php
$akses = $_SESSION['hak_akses'];
$divisi = $_SESSION['divisi'];
?>
<section class="content-header">
    <h1>History<small>Transaksi Cuti</small></h1>
    <ol class="breadcrumb">
        <li><a href="home-hrd.php"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="active">History Transaksi Cuti</li>
    </ol>
</section>

<section class="content">
<form action="" method="POST" enctype="multipart/form-data">
<div class="container-fluid">
  <div class="row bg-info" style="padding-top: 20px; padding-bottom: 20px; border-top: 5px solid #B22222;">
    <div class="col-sm-2 text-center"><h4 style="font-weight: bold;">Pilih Tahun</h4></div>
    <?php $tahun = date('Y'); ?>
    <div class="col-sm-4">
      <select name="tahun" class="form-control">
        <option value="">--Pilih Tahun--</option>
        <option value="<?php echo $tahun ?>"><?php echo $tahun; ?></option>
        <option value="<?php echo $tahun - 1 ?>"><?php echo $tahun - 1; ?></option>
        <option value="<?php echo $tahun - 2 ?>"><?php echo $tahun - 2; ?></option>
        <option value="<?php echo $tahun - 3 ?>"><?php echo $tahun - 3; ?></option>
        <option value="<?php echo $tahun - 4 ?>"><?php echo $tahun - 4; ?></option>
      </select>
    </div>
    <div class="col-sm-1 text-center"><input type="submit" class="btn btn-primary" name="cari" value="Cari"></div>
  </div>
</div>
</form>


<?php
$thisyear = date('Y');
if(isset($_POST['cari'])) {
$tahun = $_POST['tahun'];

  ?>
  <div style="padding-top: 20px;">
  <h4 style="font-weight: bold;">History Transaksi Cuti Tahun <?php echo $tahun; ?></h4>
  </div>
<div class="table-responsive">
<table id="example1" class="table table-bordered table-striped">
  <thead>
    <tr>
      <th>No</th>
      <th>Nama</th>
      <td>Divisi</th>
      <th>Hak Cuti Tahun <?php echo $thisyear; ?></th>
      <th>Hak Cuti Tahun <?php echo $thisyear - 1; ?></th>
      <th>Hak Cuti Dispensasi</th>
      <th>Total Hak Cuti</th>
      <th>Total Penggunaan Cuti Tahun <?php echo $tahun; ?></th>
      <!-- <th>View</th> -->
    </tr>
  </thead>
  <tbody>
      <?php
      $i = 1;
      // $daftaruser = mysql_query("SELECT * FROM tb_pegawai WHERE nip IN (SELECT id_user FROM tb_user WHERE aktif='Y') ORDER BY nama");
      if ($akses == 'HRD' OR $akses == 'Admin') {
        $daftaruser=mysql_query("SELECT * FROM tb_pegawai a JOIN tb_user b ON a.nip=b.id_user WHERE b.aktif='Y' AND b.resign='0' ORDER BY a.nama");
      } else if($akses == 'Manager') {
        $daftaruser=mysql_query("SELECT * FROM tb_pegawai a JOIN tb_user b ON a.nip=b.id_user WHERE b.aktif='Y' AND b.resign='0' AND b.divisi='$divisi' ORDER BY a.nama");
      }
      // echo $divisi;
      while ($du = mysql_fetch_array($daftaruser)){
      $cutidigunakan = 0.00;
      ?>
      <tr>
        <td><?php echo $i++; ?></td>
        <td>
          <a data-toggle="collapse" data-parent="#accordion" href="#<?php echo $du['nip']; ?>"> <?php echo $du['nama']; ?> </a>
          <div id="<?php echo $du['nip']; ?>" class="panel-collapse collapse">
            <div class="panel-body">
              <?php
              $nipkary = $du['nip'];
              $caricut = mysql_query ("SELECT
                                              	nip,
                                              	nama,
                                              	divisi,
                                              	dari,
                                              	sampai,
                                              	jml_hari,
                                              	jenis,
                                                persetujuan,
                                              	cutisebelum,
                                              	cutisesudah,
                                                keterangan
                                              FROM
                                              	tb_mohoncuti
                                              WHERE
                                              	nip = '$nipkary'
                                                AND YEAR(dari)='$tahun'
                                                AND (persetujuan = 'Disetujui(Direksi)' OR persetujuan = 'Disetujui(Manager)' OR persetujuan = '') 
                                              UNION ALL
                                              	SELECT
                                              		nip,
                                              		nama,
                                              		divisi,
                                              		dari,
                                              		sampai,
                                              		jml_hari,
                                              		jenis,
                                                  persetujuan,
                                              		cutisebelum,
                                              		cutisesudah,
                                                  keterangan
                                              	FROM
                                              		tb_izin
                                              	WHERE
                                              		nip = '$nipkary'
                                                  AND YEAR(dari)='$tahun'
                                              	-- AND dari BETWEEN '2019-01-21'
                                              	-- AND '2019-02-20'
                                                AND (persetujuan = 'Disetujui(Direksi)' OR persetujuan = 'Disetujui(Manager)' OR persetujuan = '')
                                              	ORDER BY
                                              		dari ASC");
              while ($cc = mysql_fetch_array($caricut)){
              ?>
              <div class="table-responsive">
              <table class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Transaksi</th>
                    <th>Dari Tanggal</th>
                    <th>Sampai Tanggal</th>
                    <th>Jumlah Hari</th>
                    <th>Keterangan</th>
                    <th>Approval</th>
                    <th>Cuti Terpotong</th>
                  </tr>
                </thead>
                <tbody>
                <tr>
                <td>
                  <?php
                  if ($cc['jenis'] == 'Datang Telat Lebih Dari 2 Jam' || $cc['jenis'] == 'Pulang Lebih Cepat Lebih Dari 2 Jam'){
                    echo "Cuti 1/2 Hari";
                  }
                  else if ($cc['jenis'] == 'Tahunan'){
                    echo "Cuti Tahunan";
                  }
                  else if ($cc['jenis'] == 'Tahun Lalu'){
                    echo "Cuti Tahun Lalu";
                  }
                  else {
                    echo $cc['jenis'];
                  }
                  ?>
                </td>
                <td><?php echo $cc['dari']; ?></td>
                <td><?php echo $cc['sampai']; ?></td>
                <td>
                  <?php
                  if ($cc['jenis'] == 'Datang Telat Lebih Dari 2 Jam' || $cc['jenis'] == 'Pulang Lebih Cepat Lebih Dari 2 Jam'){
                    echo "0.50";
                  }
                  else if($cc['jenis'] == 'Datang Telat Kurang Dari 2 Jam'){
                    echo "";
                  }
                  else{
                    echo $cc['jml_hari'];
                  }
                  ?>
                </td>
                <td>
                  <?php
                   if($cc['jenis'] == 'Datang Telat Kurang Dari 2 Jam' || $cc['jenis'] == 'Sakit Dengan Surat Dokter' || $cc['jenis'] == 'Dinas' || $cc['jenis'] == 'Pulang Lebih Cepat Kurang Dari 2 Jam' || $cc['jenis'] == 'Tugas' || $cc['jenis'] == 'Datang Telat Lebih Dari 2 Jam' || $cc['jenis'] == 'Pulang Lebih Cepat Lebih Dari 2 Jam' || $cc['jenis'] == 'Sakit Tanpa Surat Dokter') {
                      echo $cc['jenis'];
                   } else {
                      echo $cc['keterangan'];
                   }
                 ?>   
                </td>
                <td><?php echo $cc['persetujuan']; ?></td>
                <td>
                  <?php
                  if ($cc['jenis'] == 'Datang Telat Lebih Dari 2 Jam' || $cc['jenis'] == 'Pulang Lebih Cepat Lebih Dari 2 Jam'){
                    $cut = 0.50;
                    echo $cut;
                    // echo "0.50";
                  }
                  else if($cc['jenis'] == 'Datang Telat Kurang Dari 2 Jam' || $cc['jenis'] == 'Sakit Dengan Surat Dokter' || $cc['jenis'] == 'Dinas' || $cc['jenis'] == 'Pulang Lebih Cepat Kurang Dari 2 Jam' || $cc['jenis'] == 'Tugas'){
                    $cut = 0.00;
                    echo "-";
                  }
                  else{
                    $cut = $cc['jml_hari'];
                    echo $cut; 
                    // echo $cc['jml_hari'];
                  }
                  ?>
                </td>
                </tr>
              </tbody>
              </table>
            </div>
              <?php
                if ($caricut != NULL) {
                
                $cutidigunakan += $cut;
                } else {
                  $cutidigunakan = 0.00;
                }
              }
               ?>

               <?php
               $cariunpaid = mysql_query ("SELECT
                                               	*
                                               FROM
                                               	tb_unpaid
                                               WHERE
                                               	nip_karyawan = '$nipkary'
                                                AND YEAR(dari)='$tahun'
                                               	ORDER BY
                                               		dari ASC");
               while ($cu = mysql_fetch_array($cariunpaid)){
               ?>

               <div class="table-responsive">
                 <h5>Unpaid Leave</h5>
               <table class="table table-bordered table-striped">
                 <thead>
                   <tr>
                     <th>Transaksi</th>
                     <th>Dari Tanggal</th>
                     <th>Sampai Tanggal</th>
                     <th>Jumlah Hari</th>
                     <th>Approval</th>
                     <th>Cuti Terpotong</th>
                   </tr>
                 </thead>
                 <tbody>
                 <tr>
                 <td>
                   <?php
                   echo $cu['keterangan'];
                   ?>
                 </td>
                 <td><?php echo $cu['dari']; ?></td>
                 <td><?php echo $cu['sampai']; ?></td>
                 <td>
                   <?php
                     echo $cu['jml_hari'];
                   ?>
                 </td>
                 <td>
                   <?php
                     $cekpegawai = mysql_query("SELECT hak_akses FROM tb_user WHERE id_user='$nipkary'");
                     $cp = mysql_fetch_assoc($cekpegawai);
                     if ($cp['hak_akses'] == 'Pegawai2'){
                       echo "Belum Ada Cuti";
                     }else{
                       echo $cu['cutisebelum'];
                     }
                    ?>
                 </td>
                 <td>
                   <?php
                     $cekpegawai = mysql_query("SELECT hak_akses FROM tb_user WHERE id_user='$nipkary'");
                     $cp = mysql_fetch_assoc($cekpegawai);
                     if ($cp['hak_akses'] == 'Pegawai2'){
                       echo "Belum Ada Cuti";
                     }else{
                       echo $cu['cutisesudah'];
                     }
                    ?>
                 </td>
                 </tr>
               </tbody>
               </table>
             </div>
               <?php
               }
                ?>

                <?php
                $cariunpaid = mysql_query ("SELECT
                                                	*
                                                FROM
                                                	tb_mangkir
                                                WHERE
                                                	username = '$nipkary'
                                                  AND YEAR(tanggal)='$tahun'
                                                	ORDER BY
                                                		tanggal ASC");
                while ($cu = mysql_fetch_array($cariunpaid)){
                ?>

                <div class="table-responsive">
                  <h5>Mangkir</h5>
                <table class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>Transaksi</th>
                      <th>Tanggal</th>
                      <th>Jumlah Hari</th>
                      <th>Cuti Terpotong</th>
                    </tr>
                  </thead>
                  <tbody>
                  <tr>
                  <td>
                    <?php
                    echo $cu['jenis'];
                    ?>
                  </td>
                  <td><?php echo $cu['tanggal']; ?></td>
                  <td>
                    <?php
                      echo $cu['pemotongan'];
                    ?>
                  </td>
                  <td>
                    <?php
                    $harinya = $cu['pemotongan'];
                    echo "$harinya Hari";
                    ?>
                  </td>
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
        <td><?php echo $du['hak_cuti_tahunan']; ?></td>
        <td><?php echo $du['hak_cuti_tahunlalu']; ?></td>
        <td><?php echo $du['hak_cuti_dispensasi']; ?></td>
        <td>
          <?php
          $cutitahunini   = $du['hak_cuti_tahunan'];
          $cutitahunlalu  = $du['hak_cuti_tahunlalu'];
          $cutidispensasi = $du['hak_cuti_dispensasi'];
          $totalcuti = $cutitahunini + $cutitahunlalu + $cutidispensasi;
          echo number_format($totalcuti,2);
          ?>
        </td>
        <td><?php echo number_format($cutidigunakan,2); ?></td>
        <!-- <td></td> -->
      </tr>
      <?php
      }
      ?>
  </tbody>
</table>
</div>
<?php
  }
 ?>
</section>

<script>
  $(function () {
    $('#example1').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });
  });
</script>
