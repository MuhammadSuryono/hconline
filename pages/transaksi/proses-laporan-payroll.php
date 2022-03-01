<?php
require_once "../../dist/koneksi.php";
// include "../../dist/koneksi.php";
date_default_timezone_set("Asia/Bangkok");

$tgl_1 = $_POST['tgl_1'];
$tgl_2 = $_POST['tgl_2'];
$tgl_2untuktelat = $tgl_2;
$tgl_2untuktelat = date('Y-m-d H:i:s', strtotime("$tgl_2untuktelat + 1 day"));

echo $tgl_1;
echo "<br>";
echo $tgl_2;
?>


<h4>Karyawan Masuk</h4>
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No.</th>
                <th>Nik</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>No.Ktp</th>
                <th>Tempat Tgl Lahir</th>
                <th>Status Perkawinan</th>
                <th>Email</th>
                <th>No. Telp</th>
                <th>Jabatan</th>
                <th>Divisi</th>
                <th>Kontrak Dari</th>
                <th>Kontrak S/d</th>
                <th>Rekening Mandiri</th>
                <th>NPWP</th>
                <th>Agama</th>
                <th>BPJS TK</th>
                <th>BPJS Kesehatan</th>
                <th>Edit</th>
            </tr>
        </thead>

        <tbody>
            <?php
            $dbhost     = 'localhost';
            $dbuser     = 'adam';
            $dbpass     = 'Ad@mMR1db';
            $dbname     = 'mri_rekrutmen_ci2';

            $db         = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

            if ($db->connect_error) {
                die('Maaf koneksi gagal: ' . $db->connect_error);
            }

            $carikarybaru = $db->query("SELECT * FROM data_user WHERE hasil='Lulus' AND kontrakdari BETWEEN '$tgl_1' AND '$tgl_2'");
            $c = 1;
            while ($ckb = mysqli_fetch_array($carikarybaru)) {
            ?>
                <tr>
                    <td><?php echo $c++; ?></td>
                    <td><?php echo $ckb['nik']; ?></td>
                    <td><?php echo $ckb['nama']; ?></td>
                    <td><?php echo $ckb['alamat']; ?></td>
                    <td><?php echo $ckb['ktp']; ?></td>
                    <td><?php echo $ckb['tmp_lahir']; ?> - <?php echo $ckb['tgl_lahir']; ?> </td>
                    <td><?php echo $ckb['status']; ?></td>
                    <td><?php echo $ckb['email']; ?></td>
                    <td><?php echo $ckb['tlp']; ?></td>
                    <td><?php echo $ckb['jabatan']; ?></td>
                    <td><?php echo $ckb['divisi']; ?></td>
                    <td><?php echo $ckb['kontrakdari']; ?></td>
                    <td><?php echo $ckb['kontraksampai']; ?></td>
                    <td><?php echo $ckb['rekeningmandiri']; ?></td>
                    <td><?php echo $ckb['npwp']; ?></td>
                    <td><?php echo $ckb['agama']; ?></td>
                    <td><?php echo $ckb['bpjstk']; ?></td>
                    <td><?php echo $ckb['bpjskes']; ?></td>
                    <td><button type="button" class="btn btn-default btn-small" onclick="edit_user('<?php echo $ckb['no_reg']; ?>')">Edit</button></td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>

<!-- MODAL UNTUK EDIT -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit Karyawan</h4>
            </div>
            <div class="modal-body">
                <div class="fetched-data"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Keluar</button>
            </div>
        </div>
    </div>
</div>
<!-- //MODAL UNTUK EDIT -->

<h4>Karyawan Keluar</h4>
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No.</th>
                <th>Nik</th>
                <th>Nama</th>
                <th>Tgl Masuk</th>
                <th>Jabatan</th>
                <th>Tgl Keluar</th>
                <th>Jml Kehadiran s/d Tgl Resign</th>
                <th>Sisa Cuti 2019</th>
                <th>Sisa Cuti 2018</th>
                <th>Total HK+Cuti</th>
                <th>Keterangan</th>
            </tr>
        </thead>

        <tbody>
            <?php
            $carikarykeluar = mysql_query("SELECT * FROM tb_user WHERE id_user IN (SELECT nip FROM tb_pegawai WHERE tgl_keluar BETWEEN '$tgl_1' AND '$tgl_2')");
            $c = 1;
            while ($ckk = mysql_fetch_array($carikarykeluar)) {
            ?>
                <tr>
                    <td><?php echo $c++; ?></td>
                    <td><?php echo $ckb['nik']; ?></td>
                    <td><?php echo $ckb['nama']; ?></td>
                    <td><?php echo $ckb['alamat']; ?></td>
                    <td><?php echo $ckb['ktp']; ?></td>
                    <td><?php echo $ckb['tmp_lahir']; ?> - <?php echo $ckb['tgl_lahir']; ?> </td>
                    <td><?php echo $ckb['status']; ?></td>
                    <td><?php echo $ckb['jabatan']; ?></td>
                    <td><?php echo $ckb['divisi']; ?></td>
                    <td><?php echo $ckb['kontrakdari']; ?></td>
                    <td><?php echo $ckb['kontraksampai']; ?></td>
                    <td><?php echo $ckb['rekeningmandiri']; ?></td>
                    <td><?php echo $ckb['npwp']; ?></td>
                    <td><?php echo $ckb['agama']; ?></td>
                    <td><?php echo $ckb['bpjstk']; ?></td>
                    <td><?php echo $ckb['bpjskes']; ?></td>
                    <td><button type="button" class="btn btn-default btn-small" onclick="edit_user('<?php echo $ckb['no_reg']; ?>')">Edit</button></td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>

<br /><br />

<button class="btn btn-default btn-sm btn-exp" id="expandAllFormats">Expand All</button>

<h4>Unpaid Leave</h4>
<div class="table-responsive">
    <table id="example1" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Nik</th>
                <th>Nama</th>
                <td>Divisi</th>
                <td>Jumlah Hari</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
            $daftaruser1 = mysql_query("SELECT * FROM tb_unpaid JOIN tb_user ON tb_unpaid.nip_karyawan = tb_user.id_user WHERE dari BETWEEN '$tgl_1' AND '$tgl_2' AND keterangan NOT LIKE '%Mangkir%' GROUP BY nama_karyawan");
            while ($du1 = mysql_fetch_array($daftaruser1)) {
            ?>

                <tr>
                    <td><?php echo $i++; ?></td>
                    <td><?php echo $du1['nik']; ?></td>
                    <td>
                        <a data-toggle="collapse" data-parent="#accordion" href="#<?php echo $du1['nip_karyawan']; ?>"><?php echo $du1['nama_karyawan']; ?> </a>
                        <div id="<?php echo $du1['nip_karyawan']; ?>" class="panel-collapse collapse">
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Keterangan Unpaid</th>
                                                <th>Dari Tanggal</th>
                                                <th>Sampai Tanggal</th>
                                                <th>Jumlah Hari</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $nipkary = $du1['nip_karyawan'];
                                            $cariunpaid1 = mysql_query("SELECT * FROM tb_unpaid WHERE nip_karyawan='$nipkary' AND dari BETWEEN '$tgl_1' AND '$tgl_2' AND keterangan NOT LIKE '%Mangkir%'");
                                            $li = 1;
                                            while ($cun1 = mysql_fetch_array($cariunpaid1)) {
                                            ?>
                                                <tr>
                                                    <td><?php echo $li++; ?></td>
                                                    <td><?php echo $cun1['keterangan']; ?></td>
                                                    <td><?php echo $cun1['dari']; ?></td>
                                                    <td><?php echo $cun1['sampai']; ?></td>
                                                    <td><?php echo $cun1['jml_hari']; ?></td>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
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

<br /><br /><br />
<!-- Tabel Telat -->
<h4>Laporan Telat</h4>
<div class="table-responsive">
    <table id="example2" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Nik</th>
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
                                        niknya,
                                      	divisi,
                                      	COUNT(divisi) AS jml_hari
                                      FROM
                                      	(
                                      		SELECT
                                      			xxx.user_id,
                                      			tb_user.id_user,
                                      			tb_user.nama_user,
                                      			tb_user.divisi,
                                            tb_user.nik AS niknya,
                                            tb_user.jabatan AS jabnya,
                                            tb_user.harian AS hariannya,
                                            tb_user.resign AS resignnya,
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
                                      					NULL,
                                      					max(tgl_dan_jam)
                                      				) AS absen_pulang
                                      				FROM
                                      					absensi
                                      				WHERE
                                      					tgl_dan_jam BETWEEN '$tgl_1'
                                      				AND '$tgl_2untuktelat'
                                      				AND date(tgl_dan_jam) NOT IN (
                                      					SELECT
                                      						tanggal
                                      					FROM
                                      						daterange_izin
                                      					WHERE
                                      						daterange_izin.id_absen = absensi.user_id
                                      				)
                                      				AND date(tgl_dan_jam) NOT IN (SELECT tanggal FROM kalender)
                                              AND date(tgl_dan_jam) NOT IN (SELECT tanggal FROM pulangcepat)
                                      				AND DAYOFWEEK(date(tgl_dan_jam)) = 2
                                      				OR tgl_dan_jam BETWEEN '$tgl_1'
                                      				AND '$tgl_2untuktelat'
                                      				AND date(tgl_dan_jam) NOT IN (
                                      					SELECT
                                      						tanggal
                                      					FROM
                                      						daterange_izin
                                      					WHERE
                                      						daterange_izin.id_absen = absensi.user_id
                                      				)
                                      				AND date(tgl_dan_jam) NOT IN (SELECT tanggal FROM kalender)
                                              AND date(tgl_dan_jam) NOT IN (SELECT tanggal FROM pulangcepat)
                                      				AND DAYOFWEEK(date(tgl_dan_jam)) = 3
                                      				OR tgl_dan_jam BETWEEN '$tgl_1'
                                      				AND '$tgl_2untuktelat'
                                      				AND date(tgl_dan_jam) NOT IN (
                                      					SELECT
                                      						tanggal
                                      					FROM
                                      						daterange_izin
                                      					WHERE
                                      						daterange_izin.id_absen = absensi.user_id
                                      				)
                                      				AND date(tgl_dan_jam) NOT IN (SELECT tanggal FROM kalender)
                                              AND date(tgl_dan_jam) NOT IN (SELECT tanggal FROM pulangcepat)
                                      				AND DAYOFWEEK(date(tgl_dan_jam)) = 4
                                      				OR tgl_dan_jam BETWEEN '$tgl_1'
                                      				AND '$tgl_2untuktelat'
                                      				AND date(tgl_dan_jam) NOT IN (
                                      					SELECT
                                      						tanggal
                                      					FROM
                                      						daterange_izin
                                      					WHERE
                                      						daterange_izin.id_absen = absensi.user_id
                                      				)
                                      				AND date(tgl_dan_jam) NOT IN (SELECT tanggal FROM kalender)
                                              AND date(tgl_dan_jam) NOT IN (SELECT tanggal FROM pulangcepat)
                                      				AND DAYOFWEEK(date(tgl_dan_jam)) = 5
                                      				OR tgl_dan_jam BETWEEN '$tgl_1'
                                      				AND '$tgl_2untuktelat'
                                      				AND date(tgl_dan_jam) NOT IN (
                                      					SELECT
                                      						tanggal
                                      					FROM
                                      						daterange_izin
                                      					WHERE
                                      						daterange_izin.id_absen = absensi.user_id
                                      				)
                                      				AND date(tgl_dan_jam) NOT IN (SELECT tanggal FROM kalender)
                                              AND date(tgl_dan_jam) NOT IN (SELECT tanggal FROM pulangcepat)
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
                                      jamnya > '08:30:59'
                                      -- AND jabnya IS NULL
                                      AND hariannya IS NULL AND resignnya = 0
                                      OR
                                      pulangnya < '17:00:00'
                                      -- AND jabnya IS NULL 
                                      AND hariannya IS NULL AND resignnya = 0
                                      GROUP BY
                                      	user_id
                                      ORDER BY
                                      	nama_user ASC
                                      ");
            while ($du = mysql_fetch_array($daftaruser)) {
                echo "<tr>";
                echo "<td>" . $i++ . "</td>";
                echo "<td>" . $du['niknya'] . "</td>";
                echo "<td>";
                echo "<a data-toggle='collapse' data-parent='#accordion' href='#" . $du['id_user'] . "2'>" . $du['nama_user'] . "</a>";
                echo "<div id='" . $du['id_user'] . "2' class='panel-collapse collapse'>";
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
                echo "<th>Telat</th>";
                echo "<th>Pulang Cepat</th>";
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
                                              AND date(tgl_dan_jam) NOT IN (SELECT tanggal FROM pulangcepat)
                                              AND date(tgl_dan_jam) NOT IN (SELECT date(waktuscan) FROM absensi_kegiatan WHERE id_user='$du[id_user]')
                                              AND date(tgl_dan_jam) NOT IN (SELECT tanggal FROM koreksiabsen WHERE username='$du[id_user]')
                                              AND DAYOFWEEK(date(tgl_dan_jam)) = 2
                                              OR
                                              user_id = '$du[user_id]'
                                              AND tgl_dan_jam BETWEEN '$tgl_1'
                                              AND '$tgl_2' AND date(tgl_dan_jam) NOT IN (SELECT tanggal FROM daterange_izin WHERE username='$du[id_user]')
                                              AND date(tgl_dan_jam) NOT IN (SELECT tanggal FROM kalender)
                                              AND date(tgl_dan_jam) NOT IN (SELECT tanggal FROM pulangcepat)
                                              AND date(tgl_dan_jam) NOT IN (SELECT date(waktuscan) FROM absensi_kegiatan WHERE id_user='$du[id_user]')
                                              AND date(tgl_dan_jam) NOT IN (SELECT tanggal FROM koreksiabsen WHERE username='$du[id_user]')
                                              AND DAYOFWEEK(date(tgl_dan_jam)) = 3
                                              OR
                                              user_id = '$du[user_id]'
                                              AND tgl_dan_jam BETWEEN '$tgl_1'
                                              AND '$tgl_2' AND date(tgl_dan_jam) NOT IN (SELECT tanggal FROM daterange_izin WHERE username='$du[id_user]')
                                              AND date(tgl_dan_jam) NOT IN (SELECT tanggal FROM kalender)
                                              AND date(tgl_dan_jam) NOT IN (SELECT tanggal FROM pulangcepat)
                                              AND date(tgl_dan_jam) NOT IN (SELECT date(waktuscan) FROM absensi_kegiatan WHERE id_user='$du[id_user]')
                                              AND date(tgl_dan_jam) NOT IN (SELECT tanggal FROM koreksiabsen WHERE username='$du[id_user]')
                                              AND DAYOFWEEK(date(tgl_dan_jam)) = 4
                                              OR
                                              user_id = '$du[user_id]'
                                              AND tgl_dan_jam BETWEEN '$tgl_1'
                                              AND '$tgl_2' AND date(tgl_dan_jam) NOT IN (SELECT tanggal FROM daterange_izin WHERE username='$du[id_user]')
                                              AND date(tgl_dan_jam) NOT IN (SELECT tanggal FROM kalender)
                                              AND date(tgl_dan_jam) NOT IN (SELECT tanggal FROM pulangcepat)
                                              AND date(tgl_dan_jam) NOT IN (SELECT date(waktuscan) FROM absensi_kegiatan WHERE id_user='$du[id_user]')
                                              AND date(tgl_dan_jam) NOT IN (SELECT tanggal FROM koreksiabsen WHERE username='$du[id_user]')
                                              AND DAYOFWEEK(date(tgl_dan_jam)) = 5
                                              OR
                                              user_id = '$du[user_id]'
                                              AND tgl_dan_jam BETWEEN '$tgl_1'
                                              AND '$tgl_2' AND date(tgl_dan_jam) NOT IN (SELECT tanggal FROM daterange_izin WHERE username='$du[id_user]')
                                              AND date(tgl_dan_jam) NOT IN (SELECT tanggal FROM kalender)
                                              AND date(tgl_dan_jam) NOT IN (SELECT tanggal FROM pulangcepat)
                                              AND date(tgl_dan_jam) NOT IN (SELECT date(waktuscan) FROM absensi_kegiatan WHERE id_user='$du[id_user]')
                                              AND date(tgl_dan_jam) NOT IN (SELECT tanggal FROM koreksiabsen WHERE username='$du[id_user]')
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
                                        jamnya > '08:30:59'
                                        OR
                                        pulangnya < '17:00:00'");
                $l = 1;
                $xnxx = "";
                $rp = 0;
                while ($row = mysql_fetch_array($query_otw)) {
                    $xnxx .= "<tr>";
                    $xnxx .= "<td>" . $l++ . "</td>";
                    $xnxx .= "<td>" . $row['tanggal'] . "</td>";
                    $xnxx .= "<td>" . $row['jamnya'] . "</td>";
                    $xnxx .= "<td>" . $row['pulangnya'] . "</td>";
                    $xnxx .= "<td>" . $row['jam_total'] . "</td>";

                    // $jamkerja = $row['jam_total'];
                    // $time1 = strtotime($jamkerja);
                    // $time2 = strtotime('09:00:00');
                    // $interval  = $time2 - $time1;
                    // $detiknya = $interval;
                    // $menitnya = $detiknya / 60;
                    // $jadimenit = floor($menitnya);
                    // $rupiahnya = $jadimenit * 1000;
                    $tesjammasuk  = $row['jamnya'];
                    $tespulangnya = $row['pulangnya'];

                    // if ($tesjammasuk > strtotime('17:00:00')){
                    //   $jammasuknya = strtotime('17:00:00');
                    // }
                    // else{
                    //   $jammasuknya = strtotime($tesjammasuk);
                    // }

                    // if($tespulangnya('') > strtotime('17:00:00')){
                    //   $jampulangnya = strtotime('17:00:00');
                    // }else{
                    //   $jampulangnya = strtotime($tespulangnya);
                    // }
                    // else{
                    //   $jammasuknya = strtotime($tesjammasuk);
                    //   $jampulangnya = strtotime($tespulangnya);
                    // }

                    $jammasuk   = strtotime('08:05:59');
                    $jampulang  = strtotime('17:00:00');
                    $masuknya   = strtotime($tesjammasuk);
                    $pulangnya  = strtotime($tespulangnya);
                    $telatnya   = $masuknya - $jammasuk;
                    $detiknya   = $telatnya;
                    $menitnya   = $detiknya / 60;
                    $jadimenit  = floor($menitnya);

                    if ($jadimenit < 0) {
                        $jadimenit = 0;
                    } else if ($jadimenit > 534) {
                        $jadimenit = 534;
                    }

                    $cepatnya   = $jampulang - $pulangnya;
                    $detiknya2  = $cepatnya;
                    $menitnya2  = $detiknya2 / 60;
                    $jadimenit2 = floor($menitnya2);

                    if ($jadimenit2 < 0) {
                        $jadimenit2 = 0;
                    } else if ($jadimenit2 > 534) {
                        $jadimenit2 = 534;
                    }

                    $totalkurang = $jadimenit + $jadimenit2;

                    $carilevel = mysql_query("SELECT rupiahpotongan FROM tb_user JOIN matrixjabatan ON tb_user.level = matrixjabatan.jabatan WHERE tb_user.id_user ='$du[id_user]'");
                    $cl = mysql_fetch_array($carilevel);
                    $pot = $cl['rupiahpotongan'];

                    $rupiahnya = $totalkurang * $pot;

                    $xnxx .= "<td>$jadimenit Menit </td>";
                    $xnxx .= "<td>$jadimenit2 Menit </td>";
                    $xnxx .= "<td>$totalkurang * $pot = Rp. " . number_format($rupiahnya, 0, '', ',') . "</td>";
                    $xnxx .= "<td>";

                    $cariizinsembilan = mysql_query("SELECT * FROM daterange_izin WHERE username='$row[id_user]' AND tanggal='$row[tanggal]'");
                    if (mysql_num_rows($cariizinsembilan) != 0) {
                        $cis = mysql_fetch_array($cariizinsembilan);
                        echo $cis['jenis'];
                    } else {
                        $xnxx .= "-";
                    }
                    $xnxx .= "</td>";
                    $xnxx .= "</tr>";
                    $rp = $rp + $rupiahnya;
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
                echo "<td>" . $du['divisi'] . "</td>";

                $itung = mysql_num_rows($query_otw);

                echo "<td>" . $itung . "</td>";
                echo "<td>Rp. " . number_format($rp, 0, '', ',') . "</td>";
                echo "</tr>";
            }
            ?>
            <!-- <tr>
        <td><?php // echo $i++;
            ?></td>
        <td>
          <a data-toggle="collapse" data-parent="#accordion" href="#<? php // echo $du['nip_karyawan'];
                                                                    ?>"><? php // echo $du['nama_karyawan'];
                                                                        ?>  </a>
          <div id="<?php // echo $du['nip_karyawan'];
                    ?>" class="panel-collapse collapse">
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
                <td><?php // echo $cun['keterangan'];
                    ?></td>
                <td><?php // echo $cun['dari'];
                    ?></td>
                <td><?php // echo $cun['sampai'];
                    ?></td>
                <td><?php // echo $cun['jml_hari'];
                    ?></td>
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
        <td><?php // echo $du['divisi'];
            ?></td>
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
<!-- //Tabel Telat -->

<br /><br /><br />

<h4>Mangkir (Alpha)</h4>
<div class="table-responsive">
    <table id="example1" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Nik</th>
                <th>Nama</th>
                <th>Divisi</th>
                <th>Jumlah Hari</th>
                <th>Full</th>
                <th>Tidak Full</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
            $daftaruser = mysql_query("SELECT * FROM tb_mangkir LEFT JOIN tb_user ON tb_mangkir.username = tb_user.id_user WHERE tanggal BETWEEN '$tgl_1' AND '$tgl_2' GROUP BY nama");
            while ($du = mysql_fetch_array($daftaruser)) {
            ?>

                <tr>
                    <td><?php echo $i++; ?></td>
                    <td><?php echo $du['nik']; ?></td>
                    <td>
                        <a data-toggle="collapse" data-parent="#accordion" href="#<?php echo $du['username']; ?>4"><?php echo $du['nama']; ?> </a>
                        <div id="<?php echo $du['username']; ?>4" class="panel-collapse collapse">
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Jenis Pemotongan</th>
                                                <th>Tanggal</th>
                                                <th>Cuti Terpotong</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $nipkary = $du['username'];
                                            $cariunpaid = mysql_query("SELECT * FROM tb_mangkir WHERE username='$nipkary' AND tanggal BETWEEN '$tgl_1' AND '$tgl_2'");
                                            $lu = 1;
                                            $tb = "";
                                            $full = 0;
                                            $tf = 0;
                                            while ($cun = mysql_fetch_array($cariunpaid)) {
                                                $tb .= "<tr>";
                                                $tb .= "<td>" . $lu++ . "</td>";
                                                $tb .= "<td>" . $cun['jenis'] . "</td>";
                                                $tb .= "<td>" . $cun['tanggal'] . "</td>";
                                                $tb .= "<td>" . $cun['pemotongan'] . "</td>";
                                                $tb .= "</tr>";
                                                $full = (int) $cun['pemotongan'] == 0 ? $full + 1 : $full;
                                                $tf = (int) $cun['pemotongan'] + $tf;
                                            }
                                            // echo $tf;
                                            echo $tb;
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
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
<td><?php echo $full ?></td>
<td><?php echo $tf; ?></td>
</tr>
<?php
            }
?>
</tbody>
</table>
</div>

<br /><br /><br />

<h4>Izin</h4>
<div class="table-responsive">
    <table id="example1" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Nik</th>
                <th>Nama</th>
                <td>Divisi</th>
                <td>Jumlah Hari</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
            $daftaruserizin = mysql_query("SELECT
                                  	a.username as username,
                                  	b.nama_user as nama,
                                  	b.divisi as divisi,
                                  	a.tanggal as tanggal,
                                  	a.jenis as jenis,
                                    b.nik as niknya
                                  FROM
                                  	daterange_izin a
                                  JOIN tb_user b ON a.username = b.id_user
                                  WHERE
                                  	a.tanggal BETWEEN '$tgl_1'
                                  AND '$tgl_2'
                                  AND jenis ='Sakit Tanpa Surat Dokter'
                                  OR
                                  a.tanggal BETWEEN '$tgl_1'
                                  AND '$tgl_2'
                                  AND jenis ='Sakit Dengan Surat Dokter'
                                  GROUP BY
                                  	a.username");
            while ($dui = mysql_fetch_array($daftaruserizin)) {
            ?>

                <tr>
                    <td><?php echo $i++; ?></td>
                    <td><?php echo $dui['niknya']; ?></td>
                    <td>
                        <a data-toggle="collapse" data-parent="#accordion" href="#<?php echo $dui['username']; ?>5"><?php echo $dui['nama']; ?> </a>
                        <div id="<?php echo $dui['username']; ?>5" class="panel-collapse collapse">
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Jenis</th>
                                                <th>Tanggal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $nipkary = $dui['username'];
                                            $carilahbray = mysql_query("SELECT
                                              	a.username as username,
                                              	b.nama_user as nama,
                                              	b.divisi as divisi,
                                              	a.tanggal as tanggal,
                                              	a.jenis as jenis
                                              FROM
                                              	daterange_izin a
                                              JOIN tb_user b ON a.username = b.id_user
                                              WHERE
                                              	a.tanggal BETWEEN '$tgl_1'
                                              AND '$tgl_2'
                                              AND jenis ='Sakit Tanpa Surat Dokter'
                                              AND a.username ='$nipkary'
                                              OR
                                              a.tanggal BETWEEN '$tgl_1'
                                              AND '$tgl_2'
                                              AND jenis ='Sakit Dengan Surat Dokter'
                                              AND a.username ='$nipkary'
                                              GROUP BY a.tanggal");
                                            $lu = 1;
                                            while ($clb = mysql_fetch_array($carilahbray)) {
                                            ?>
                                                <tr>
                                                    <td><?php echo $lu++; ?></td>
                                                    <td><?php echo $clb['jenis']; ?></td>
                                                    <td><?php echo $clb['tanggal']; ?></td>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
</div>
</td>
<td><?php echo $dui['divisi']; ?></td>
<td>
    <?php
                $hahaha = mysql_num_rows($carilahbray);
                echo $hahaha;
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
    $(function() {
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

    $('#expandAllFormats').on('click', function() {

        if ($(this).data("lastState") === null || $(this).data("lastState") === 0) {
            $('.collapse.in').collapse('hide');
            $(this).data("lastState", 1);
            $(this).text("Expand All");
        } else {

            $('.panel-collapse').removeData('bs.collapse').collapse({
                    parent: false,
                    toggle: false
                })
                .collapse('show')
                .removeData('bs.collapse')
                .collapse({
                    parent: '#accordionFormat',
                    toggle: false
                });

            $(this).data("lastState", 0);
            $(this).text("Collapse All");
        }

    });

    //modal edit user
    function edit_user(noreg) {
        // alert(noid+' - '+waktu);
        $.ajax({
            type: 'post',
            url: 'pages/transaksi/editkaryawanbaru.php',
            data: {
                noreg: noreg
            },
            success: function(data) {
                $('.fetched-data').html(data); //menampilkan data ke dalam modal
                $('#myModal').modal();
            }
        });
    }
</script>
