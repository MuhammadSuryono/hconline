<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<?php

    if (date("j") <= 20) {
        if (date("n") == 1) {
            $bulan1 = date("d M Y", mktime(0,0,0,12,21,date("Y")-1));
            $bulan2 = date("d M Y", mktime(0,0,0,1,20,date("Y")));

            $satu   = date("Y-m-d", mktime(0,0,0,12,21,date("Y")-1));
            $dua    = date("Y-m-d", mktime(0,0,0,1,20,date("Y")));
        }else {
            $bulan1 = date("d M Y", mktime(0,0,0,date("n")-1,21,date("Y")));
            $bulan2 = date("d M Y", mktime(0,0,0,date("n"),20,date("Y")));

            $satu   = date("Y-m-d", mktime(0,0,0,date("n")-1,21,date("Y")));
            $dua    = date("Y-m-d", mktime(0,0,0,date("n"),20,date("Y")));
        }
    }else {
        if (date("n") == 12) {
            $bulan1 = date("d M Y", mktime(0,0,0,date("n"),21,date("Y")));
            $bulan2 = date("d M Y", mktime(0,0,0,1,20,date("Y")+1));

            $satu   = date("Y-m-d", mktime(0,0,0,date("n"),21,date("Y")));
            $dua    = date("Y-m-d", mktime(0,0,0,1,20,date("Y")+1));
        }else {
            $bulan1 = date("d M Y", mktime(0,0,0,date("n"),21,date("Y")));
            $bulan2 = date("d M Y", mktime(0,0,0,date("n")+1,20,date("Y")));

            $satu   = date("Y-m-d", mktime(0,0,0,date("n"),21,date("Y")));
            $dua    = date("Y-m-d", mktime(0,0,0,date("n")+1,20,date("Y")));
        }
    }
    $text_default = "Cut Off (".$bulan1." s/d ".$bulan2.")";

    $range_default  = isset($_POST['range_default']) != "" ? $_POST['range_default'] : "cutoff";
    $range_custom   = isset($_POST['range_custom']) != "" ? $_POST['range_custom'] : "";
    if ($range_default == 'cutoff') {
        $tgl_1 = $satu;
        $tgl_2 = $dua;
    }
    elseif ($range_default == 'custom') {
        $range  = explode(" - ", $range_custom);
        $tgl_1  = reformatDate($range[0]);
        $tgl_2  = reformatDate($range[1]);
    }

    function reformatDate($date, $from_format = 'd/m/Y', $to_format = 'Y-m-d') {
        $date_aux = date_create_from_format($from_format, $date);
        return date_format($date_aux,$to_format);
    }
?>

<div class="x_panel" style="">
    <div class="x_content">
        <div class="well" style="overflow: auto">
            <form action="home-hrd.php?page=history-transaksi-cuti" method="post">
                <div class="col-md-4">
                    <div class="input-prepend input-group">
                        <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                        <select class="form-control" name="range_default" onchange="dateRange(this.value)">
                            <option value='cutoff' <?php if ($range_default=='cutoff') { echo "selected"; } ?>><?php echo $text_default; ?></option>
                            <option value='custom' <?php if ($range_default=='custom') { echo "selected"; } ?>>Custom</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4" id="custom" style="display:none;">
                    <div class="input-prepend input-group">
                        <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                        <input type="text" name="range_custom" value="<?php echo $range_custom; ?>" class="form-control pull-right">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="input-prepend input-group">
                        <button type="submit" class="form-control btn btn-info"><i class="glyphicon glyphicon-eye fa fa-eye"></i> Tampilkan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="percobaan" class="table-responsive">

</div>

<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Modal Header</h4>
            </div>
            <div class="modal-body">
                <p>Some text in the modal.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>

    function dateRange(pilihan) {
        var x = document.getElementById("custom");
        if (pilihan == 'cutoff') {
            x.style.display = "none";
        }else{
            x.style.display = "block";
        }
    }

    $('input[name="range_custom"]').daterangepicker({
        timePicker: false,
        locale: {
            format: 'DD/MM/Y'
        }
    });

</script>

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
      $i = 1;
      $daftaruser1 = mysql_query("SELECT * FROM tb_unpaid WHERE dari BETWEEN '2019-01-21' AND '2019-02-20' AND keterangan NOT LIKE '%Mangkir%' GROUP BY nama_karyawan");
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
              $cariunpaid1 = mysql_query("SELECT * FROM tb_unpaid WHERE nip_karyawan='$nipkary' AND dari BETWEEN '2019-01-21' AND '2019-02-20' AND keterangan NOT LIKE '%Mangkir%'");
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
          $crow = mysql_num_rows($cariunpaid1);
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
                                            tanggal,
                                            absen_masuk,
                                            absen_pulang,
                                            TIMEDIFF( absen_pulang, absen_masuk ) AS jam_total
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
                                                tgl_dan_jam BETWEEN '$awal'
                                                AND '$akhir'
                                            GROUP BY
                                                user_id,
                                                tanggal
                                            ) AS xxx
                                        ORDER BY
                                            tanggal ASC");
      while ($du = mysql_fetch_array($daftaruser)){
      ?>

      <tr>
        <td><?php echo $i++; ?></td>
        <td>
          <a data-toggle="collapse" data-parent="#accordion" href="#<?php echo $du['nip_karyawan']; ?>"><?php echo $du['nama_karyawan']; ?>  </a>
          <div id="<?php echo $du['nip_karyawan']; ?>" class="panel-collapse collapse">
            <div class="panel-body">
              <?php
              $nipkary = $du['nip_karyawan'];
              $cariunpaid = mysql_query("SELECT * FROM tb_unpaid WHERE nip_karyawan='$nipkary' AND dari BETWEEN '2019-01-21' AND '2019-02-20' AND keterangan !='No Work No Pay'");
              while ($cun = mysql_fetch_array($cariunpaid)){
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
                <td><?php echo $cun['keterangan']; ?></td>
                <td><?php echo $cun['dari']; ?></td>
                <td><?php echo $cun['sampai']; ?></td>
                <td><?php echo $cun['jml_hari']; ?></td>
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
      $daftaruser = mysql_query("SELECT * FROM tb_unpaid WHERE dari BETWEEN '2019-01-21' AND '2019-02-20' AND keterangan ='Mangkir(Pemotongan Cuti)'
                                                            OR dari BETWEEN '2019-01-21' AND '2019-02-20' AND keterangan ='Mangkir(No Work No Pay)'
                                                                GROUP BY nama_karyawan");
      while ($du = mysql_fetch_array($daftaruser)){
      ?>

      <tr>
        <td><?php echo $i++; ?></td>
        <td>
          <a data-toggle="collapse" data-parent="#accordion" href="#<?php echo $du['nip_karyawan']; ?>3"><?php echo $du['nama_karyawan']; ?>  </a>
          <div id="<?php echo $du['nip_karyawan']; ?>3" class="panel-collapse collapse">
            <div class="panel-body">
              <?php
              $nipkary = $du['nip_karyawan'];
              $cariunpaid = mysql_query("SELECT * FROM tb_unpaid WHERE nip_karyawan='$nipkary' AND dari BETWEEN '2019-01-21' AND '2019-02-20' AND keterangan ='Mangkir(Pemotongan Cuti)'
                                                                    OR nip_karyawan='$nipkary' AND dari BETWEEN '2019-01-21' AND '2019-02-20' AND keterangan ='Mangkir(No Work No Pay)'");
              while ($cun = mysql_fetch_array($cariunpaid)){
              ?>

              <div class="table-responsive">
              <table class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Keterangan Unpaid</th>
                    <th>Dari Tanggal</th>
                    <th>Sampai Tanggal</th>
                    <th>Jumlah Hari</th>
                    <th>Saldo Cuti Awal</th>
                    <th>Saldo Cuti Akhir</th>
                  </tr>
                </thead>
                <tbody>
                <tr>
                <td><?php echo $cun['keterangan']; ?></td>
                <td><?php echo $cun['dari']; ?></td>
                <td><?php echo $cun['sampai']; ?></td>
                <td><?php echo $cun['jml_hari']; ?></td>
                <td>
                  <?php
                    $cekpegawai = mysql_query("SELECT hak_akses FROM tb_user WHERE id_user='$nipkary'");
                    $cp = mysql_fetch_assoc($cekpegawai);
                    if ($cp['hak_akses'] == 'Pegawai2'){
                      echo "Belum Ada Cuti";
                    }else{
                      echo $cun['cutisebelum'];
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
                      echo $cun['cutisesudah'];
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
