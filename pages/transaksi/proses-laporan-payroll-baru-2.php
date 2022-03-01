<?php
require_once "../../dist/koneksi.php";
date_default_timezone_set("Asia/Bangkok");

$tgl_1 = $_POST['tgl_1'];
$tgl_2 = $_POST['tgl_2'];

$tgl_1_btw = new DateTime($tgl_1);
$tgl_1_btw->modify('-150 day');
$tgl_1_btw = $tgl_1_btw->format('Y-m-d');
$tgl_2_btw = new DateTime($tgl_2);
$tgl_2_btw->modify('+1 day');
$tgl_2_btw = $tgl_2_btw->format('Y-m-d');

$jml_hari = new DateTime($tgl_1);
$jml_hari = $jml_hari->diff(new DateTime($tgl_2));
$jml_hari = $jml_hari->days + 1;

// BEGIN ARRAY FROM TABLE ABSENSI
$absen_query = mysql_query("SELECT
                                user_id,
                                tanggal,
                                TIME(absen_masuk) AS jam_masuk,
                                TIME(absen_pulang) AS jam_keluar,
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
                                    tgl_dan_jam BETWEEN '$tgl1'
                                    AND '$tgl_2_btw'
                                GROUP BY
                                    user_id,
                                    tanggal
                                ) AS xxx
                                ORDER BY
                                tanggal ASC");
$absen_array = array();
while ($row = mysql_fetch_array($absen_query)) {
    $absen_array[$row['user_id'] . $row['tanggal']] = $row;
}
// END

// BEGIN KALENDER
$kalender_query = mysql_query("SELECT
                                *
                                FROM
                                kalender
                                WHERE
                                tanggal BETWEEN '$tgl_1'
                                AND '$tgl_2_btw'
                                ORDER BY
                                tanggal ASC");
$kalender = array();
while ($row = mysql_fetch_array($kalender_query)) {
    $kalender[$row['tanggal']] = $row;
}
// END

// BEGIN CUTI FROM TABLE daterange_cuti
$cuti_query = mysql_query("SELECT
                                username,
                                tanggal,
                                gambar
                            FROM
                                daterange_cuti
                            WHERE
                                tanggal BETWEEN '$tgl_1_btw'
                            AND '$tgl_2_btw'
                            AND persetujuan NOT IN ( 'Tidak Disetujui(Direksi)', 'Tidak Disetujui(Manager)', '' )
                            ORDER BY
                                tanggal ASC");
$cuti = array();
while ($row = mysql_fetch_array($cuti_query)) {
    $cuti[$row['username'] . $row['tanggal']] = $row;
}
// END


// BEGIN ARRAY NON ABSEN FROM TABLE TB_IZIN
$izin_nonabsen_query = mysql_query("SELECT
                                        username,
                                        tanggal,
                                        gambar,
                                        CASE
                                            jenis
                                            WHEN 'Dinas' THEN
                                            'D'
                                            WHEN 'Sakit Dengan Surat Dokter' THEN
                                            'SDSD'
                                            WHEN 'Sakit Tanpa Surat Dokter' THEN
                                            'STSD'
                                            WHEN 'Tugas' THEN
                                            'T' ELSE jenis
                                        END AS singkatan
                                    FROM
                                        daterange_izin
                                    WHERE
                                        jenis IN ( 'Dinas', 'Sakit Dengan Surat Dokter', 'Sakit Tanpa Surat Dokter', 'Tugas' )
                                    AND tanggal BETWEEN '$tgl_1'
                                    AND '$tgl_2_btw'
                                    AND persetujuan NOT IN ( 'Tidak Disetujui(Manager)', '' )");
$izin_nonabsen = array();
while ($row = mysql_fetch_array($izin_nonabsen_query)) {
    $izin_nonabsen[$row['username'] . $row['tanggal']] = $row;
}
// END

// BEGIN ARRAY DENGAN ABSEN FROM TABLE TB_IZIN
$izin_absen_query = mysql_query("SELECT
                                        username,
                                        tanggal,
                                        CASE
                                            jenis
                                            WHEN 'Tugas' THEN
                                            'T'
                                            WHEN 'Datang Telat Kurang Dari 2 Jam' THEN
                                            'DTK2'
                                            WHEN 'Datang Telat Lebih Dari 2 Jam' THEN
                                            'DTL2'
                                            WHEN 'Pulang Lebih Cepat Kurang Dari 2 Jam' THEN
                                            'PCK2'
                                            WHEN 'Pulang Lebih Cepat Lebih Dari 2 Jam' THEN
                                            'PCL2' ELSE jenis
                                        END AS singkatan
                                    FROM
                                        daterange_izin
                                    WHERE
                                        jenis IN ( 'Datang Telat Kurang Dari 2 Jam', 'Datang Telat Lebih Dari 2 Jam', 'Pulang Lebih Cepat Kurang Dari 2 Jam', 'Pulang Lebih Cepat Lebih Dari 2 Jam', 'Tugas' )
                                    AND tanggal BETWEEN '$tgl_1'
                                    AND '$tgl_2_btw'
                                    AND persetujuan NOT IN ( 'Tidak Disetujui(Manager)' )");
$izin_absen = array();
while ($row = mysql_fetch_array($izin_absen_query)) {
    $izin_absen[$row['username'] . $row['tanggal']] = $row;
}
// END

// BEGIN UNPAID FROM TABLE daterange_unpaid
$unpaid_query = mysql_query("SELECT
                                    username,
                                    tanggal,
                                    gambar
                                FROM
                                    daterange_unpaid
                                WHERE
                                    tanggal BETWEEN '$tgl_1'
                                AND '$tgl_2_btw'
                                ORDER BY
                                    tanggal ASC");
$unpaid = array();
while ($row = mysql_fetch_array($unpaid_query)) {
    $unpaid[$row['username'] . $row['tanggal']] = $row;
}
// END

// BEGIN UNPAID FROM TABLE koreksiabsen
$ka_query = mysql_query("SELECT
                                username,
                                id_absen,
                                tanggal,
                                TIME( jammasuk ) AS jam_masuk,
                                TIME( jamkeluar ) AS jam_keluar 
                            FROM
                                koreksiabsen 
                            WHERE
                                tanggal BETWEEN '$tgl_1' 
                            AND '$tgl_2_btw'");
$ka = array();
while ($row = mysql_fetch_array($ka_query)) {
    $ka[$row['username'] . $row['tanggal']] = $row;
}
// END
?>


<!-- Tabel Telat -->
<div class="table-responsive">
    <table id="example2" class="table table-bordered table-striped">
        <thead>
            <tr style="background-color:salmon;">
                <th>No</th>
                <th>Nik</th>
                <th>Nama</th>
                <th>Divisi</th>
                <th>Total mangkir</th>
                <th>Total menit terlambat (< 2 jam)</th>
                <th>Total Izin T. Masuk (STSD,UP)</th>
                <th>Total kurang 9 jam</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $x = 1;
            $daftaruser = mysql_query("SELECT
                                            id_user,
                                            nik,
                                            nama_user,
                                            divisi,
                                            id_absen 
                                        FROM
                                            tb_user 
                                        WHERE
                                            resign = '0' 
                                            AND aktif = 'y' 
                                            AND divisi != 'Direksi' 
                                            AND harian IS NULL 
                                            AND mitra IS NULL 
                                            AND id_absen != '' 
                                        ORDER BY
                                            nama_user ASC");
            while ($du = mysql_fetch_array($daftaruser)) {
                $contect_detail = "";
                $total_jam_kurang = 0;
                $total_hari_telat = 0;
                $total_mangkir = 0;
                $total_9jam = 0;
                $total_t_masuk = 0;
                $jatahdtk = 0;
                $jatahpck = 0;
                for ($i = 0; $i < $jml_hari; $i++) {
                    $n = 1 + $i;
                    $tanggal = new DateTime($tgl_1);
                    $tanggal->modify('+' . $i . ' day');
                    $tanggal = $tanggal->format('Y-m-d');
                    if ($tanggal >= date('Y-m-d')) {
                        break;
                    }

                    $kal     = isset($kalender[$tanggal]) == true ? 1 : 0;
                    if (date('N', strtotime($tanggal)) != 6 && date('N', strtotime($tanggal)) != 7 && $kal == 0) {
                        $jam_masuk = substr($absen_array[$du['id_absen'] . $tanggal]['jam_masuk'], 0, -3);
                        $jam_keluar = substr($absen_array[$du['id_absen'] . $tanggal]['jam_keluar'], 0, -3);
                        $jam_total = substr($absen_array[$du['id_absen'] . $tanggal]['jam_total'], 0, -3);
                        $_9jam = intval(substr($absen_array[$du['id_absen'] . $tanggal]['jam_total'], 0, -6));
                        if ($_9jam < 9) {
                            $_9jam = "&nbsp;&nbsp;&nbsp;&nbsp; < 9 jam";
                        } else {
                            $_9jam = "";
                        }

                        $kehadiran = "";
                        $sanksi = "";
                        $jam_kurang = 0;
                        if ($jam_masuk <= '08:30' && !empty($ka[$du['id_user'] . $tanggal])) {
                            // Untuk Koreksi Aktual apabila tidak absen pagi atau absen pulang
                            $jam_masuk = $ka[$du['id_user'] . $tanggal]['jam_masuk'] == '00:00:00' ? $absen_array[$du['id_absen'] . $tanggal]['jam_masuk'] : $ka[$du['id_user'] . $tanggal]['jam_masuk'];
                            $jam_keluar = $ka[$du['id_user'] . $tanggal]['jam_keluar'] == '00:00:00' ? $absen_array[$du['id_absen'] . $tanggal]['jam_keluar'] : $ka[$du['id_user'] . $tanggal]['jam_keluar'];
                            $diff = (strtotime($jam_keluar) - strtotime($jam_masuk)) + strtotime('00:00:00');
                            $jam_total = date('H:i', $diff);
                            $jam_masuk = substr($jam_masuk, 0, -3);
                            $jam_keluar = substr($jam_keluar, 0, -3);
                            $kehadiran = "Koreksi Absen";
                        } else if ($jam_masuk > '08:30' && $jam_masuk <= '10:00') {
                            $jk = strtotime('08:30') - strtotime($jam_masuk);
                            $jk = $jk / 60;
                            if (empty($ka[$du['id_user'] . $tanggal])) {
                                if (empty($izin_absen[$du['id_user'] . $tanggal])) {
                                    $kehadiran = "Terlambat";
                                    $sanksi = "Potong Gaji / Menit";
                                    $jam_kurang = floor($jk);
                                } else {
                                    if ($izin_absen[$du['id_user'] . $tanggal]['singkatan'] != 'T') {
                                        $kehadiran = $izin_absen[$du['id_user'] . $tanggal]['singkatan'];
                                        $sanksi = "Potong Gaji / Menit";
                                        $jam_kurang = floor($jk);
                                    } else {
                                        $kehadiran = "Tugas";
                                        $_9jam = "";
                                    }
                                }
                            } else {
                                // Untuk Koreksi Aktual apabila tidak absen pagi atau absen pulang
                                $jam_masuk = $ka[$du['id_user'] . $tanggal]['jam_masuk'] == '00:00:00' ? $absen_array[$du['id_absen'] . $tanggal]['jam_masuk'] : $ka[$du['id_user'] . $tanggal]['jam_masuk'];
                                $jam_keluar = $ka[$du['id_user'] . $tanggal]['jam_keluar'] == '00:00:00' ? $absen_array[$du['id_absen'] . $tanggal]['jam_keluar'] : $ka[$du['id_user'] . $tanggal]['jam_keluar'];
                                $diff = (strtotime($jam_keluar) - strtotime($jam_masuk)) + strtotime('00:00:00');
                                $jam_total = date('H:i', $diff);
                                $jam_masuk = substr($jam_masuk, 0, -3);
                                $jam_keluar = substr($jam_keluar, 0, -3);
                                $kehadiran = "Koreksi Absen";
                            }
                        } else if ($jam_masuk > '10:00') {
                            $jk = strtotime('08:30') - strtotime($jam_masuk);
                            $jk = $jk / 60;
                            if (empty($ka[$du['id_user'] . $tanggal])) {
                                if (empty($izin_absen[$du['id_user'] . $tanggal])) {
                                    $kehadiran = "Terlambat";
                                    $sanksi = "Potong Cuti / Gaji";
                                    $jam_kurang = floor($jk);
                                    $total_potong_gc = $total_potong_gc + 1;
                                    $_9jam = "";
                                } else {
                                    if ($izin_absen[$du['id_user'] . $tanggal]['singkatan'] != 'T') {
                                        $kehadiran = $izin_absen[$du['id_user'] . $tanggal]['singkatan'];
                                        // $sanksi = "Potong Cuti 0,5 Hari / Gaji";
                                        $jam_kurang = floor($jk);
                                        $sanksi = "Potong Cuti / Gaji";
                                        $_9jam = "";
                                    } else {
                                        $kehadiran = "Tugas";
                                        $_9jam = "";
                                    }
                                }
                            } else {
                                // Untuk Koreksi Aktual apabila tidak absen pagi atau absen pulang
                                $jam_masuk = $ka[$du['id_user'] . $tanggal]['jam_masuk'] == '00:00:00' ? $absen_array[$du['id_absen'] . $tanggal]['jam_masuk'] : $ka[$du['id_user'] . $tanggal]['jam_masuk'];
                                $jam_keluar = $ka[$du['id_user'] . $tanggal]['jam_keluar'] == '00:00:00' ? $absen_array[$du['id_absen'] . $tanggal]['jam_keluar'] : $ka[$du['id_user'] . $tanggal]['jam_keluar'];
                                $diff = (strtotime($jam_keluar) - strtotime($jam_masuk)) + strtotime('00:00:00');
                                $jam_total = date('H:i', $diff);
                                $jam_masuk = substr($jam_masuk, 0, -3);
                                $jam_keluar = substr($jam_keluar, 0, -3);
                                $kehadiran = "Koreksi Absen";
                            }
                        } else if (empty($absen_array[$du['id_absen'] . $tanggal])) { // Tidak ada catatan finger print
                            if (!empty($cuti[$du['id_user'] . $tanggal])) {
                                $kehadiran = "Cuti";
                                $_9jam = "";
                            } else if (!empty($izin_nonabsen[$du['id_user'] . $tanggal])) {
                                $jenis = $izin_nonabsen[$du['id_user'] . $tanggal]['singkatan'];
                                $kehadiran = $jenis;
                                if ($jenis == 'STSD') {
                                    $sanksi = "Potong Cuti / Gaji";
                                    $total_t_masuk = $total_t_masuk + 1;
                                } else if ($jenis == 'T') {
                                    $kehadiran = 'Tugas';
                                }
                                $_9jam = "";
                            } else if (!empty($unpaid[$du['id_user'] . $tanggal])) {
                                $kehadiran = "Izin T. Masuk";
                                $_9jam = "";
                                $sanksi = "UnPaid";
                                $total_t_masuk = $total_t_masuk + 1;
                            } else {
                                $kehadiran = "Mangkir";
                                $total_mangkir = $total_mangkir + 1;
                                $_9jam = "";
                                $sanksi = "Potong Cuti / Gaji";
                            }
                        } else if ($jam_keluar <= '17:00' && $kehadiran == "") {
                            if ($izin_absen[$du['id_user'] . $tanggal]['singkatan'] != 'T') {
                                $kehadiran = $izin_absen[$du['id_user'] . $tanggal]['singkatan'];
                                $_9jam = "";
                            } else {
                                $kehadiran = "Tugas";
                                $_9jam = "";
                            }
                        }
                        
                        if ($kehadiran == "Koreksi Absen") {
                            $_9jam = "";
                        }
                        $jam_kurang = $jam_kurang >= 0 ? 0 : $jam_kurang;
                        if ($kehadiran == "DTK2") {
                            if ($jatahdtk == 0) {
                                $jam_kurang = 0;
                                $sanksi = "";
                                $jatahdtk++;
                            }
                        } else if ($kehadiran == "PCK2") {
                            if ($jatahpck == 0) {
                                $jam_kurang = 0;
                                $sanksi = "";
                                $jatahpck++;
                            }
                        } else if ($kehadiran == "DTL2" || $kehadiran == "PCL2") {
                            $jam_kurang = 0;
                        }

                        if ($_9jam != "" && $jam_kurang < 0) {
                            $jam_kurang = $jam_kurang - 30;
                        }

                        if ($jam_kurang < 0) {
                            $total_hari_telat = $total_hari_telat + 1;
                        }

                        $total_jam_kurang = $total_jam_kurang + $jam_kurang;
                        $total_9jam = $_9jam == "" ? $total_9jam : $total_9jam + 1;
                        $contect_detail .= "<tr>";
                        $contect_detail .= "</td>";
                        $contect_detail .= "<td>" . $n . "</td>";
                        $contect_detail .= "<td>" . $tanggal . "</td>";
                        $contect_detail .= "<td>" . $jam_masuk . "</td>";
                        $contect_detail .= "<td>" . $jam_keluar . "</td>";
                        $contect_detail .= "<td>" . $jam_total . "</td>";
                        $contect_detail .= "<td>" . $_9jam . "</td>";
                        $contect_detail .= "<td>" . $kehadiran . "</td>";
                        $contect_detail .= "<td>";
                        $contect_detail .= $jam_kurang >= 0 ? "" : $jam_kurang . " menit";
                        $contect_detail .= "</td>";
                        $contect_detail .= "<td>";
                        $contect_detail .= $sanksi;
                        $contect_detail .= "</td>";
                        $contect_detail .= "</tr>";
                    }
                }

                echo "<tr>";
                echo "<td>" . $x++ . "</td>";
                echo "<td>" . $du['nik'] . "</td>";
                echo "<td>";
                echo "<a data-toggle='collapse' data-parent='#accordion' href='#" . $du['id_user'] . "'>" . $du['nama_user'] . "</a>";

                echo "</td>";
                echo "<td>" . $du['divisi'] . "</td>";
                echo "<td><center>" . $total_mangkir . "</center></td>";
                echo "<td><center>" . $total_jam_kurang . " menit @ ". $total_hari_telat ." hari</center></td>";
                echo "<td><center>" . $total_t_masuk . "</center></td>";
                echo "<td><center>" . $total_9jam . "</center></td>";
                echo "</tr>";

                echo "<tr id='" . $du['id_user'] . "' class='panel-collapse collapse'>";
                echo "<td colspan='8'>";

                echo "<table class='table table-bordered table-striped'>";
                echo "<thead>";
                echo "<tr style='background-color:antiquewhite;'>";
                echo "<th>No.</th>";
                echo "<th>Tanggal</th>";
                echo "<th>Jam Masuk</th>";
                echo "<th>Jam Pulang</th>";
                echo "<th>Jumlah jam</th>";
                echo "<th>9 Jam</th>";
                echo "<th>Kehadiran</th>";
                echo "<th>Menit Terlambat</th>";
                echo "<th>Sanksi</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
                echo $contect_detail;
                echo "<tr style='background-color:#fdffde;'>";
                echo "</th>";
                echo "<td colspan='3' rowspan='6'></td>";
                echo "<td colspan='4'>Total mangkir</td>";
                echo "<td colspan='2'>" . $total_mangkir . " hari</td>";
                echo "</tr>";
                echo "<tr style='background-color:#fdffde;'>";
                echo "</th>";
                echo "<td colspan='4'>Total menit terlambat (< 2 jam)</td>";
                echo "<td colspan='2'>" . $total_jam_kurang . " menit</td>";
                echo "</tr>";
                echo "<tr style='background-color:#fdffde;'>";
                echo "</th>";
                echo "<td colspan='4'>Total hari terlambat</td>";
                echo "<td colspan='2'>" . $total_hari_telat . " hari</td>";
                echo "</tr>";
                echo "<tr style='background-color:#fdffde;'>";
                echo "</td>";
                echo "<td colspan='4'>Total Izin T. Masuk (STSD,UP)</td>";
                echo "<td colspan='2'>" . $total_t_masuk . " hari</td>";
                echo "</tr>";
                echo "<tr style='background-color:#fdffde;'>";
                echo "</td>";
                echo "<td colspan='4'>Total kurang 9 jam</td>";
                echo "<td colspan='2'>" . $total_9jam . "</td>";
                echo "</tr>";

                echo "</tbody>";
                echo "</table>";
                echo "</td>";

                echo "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>
<!-- //Tabel Telat -->

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