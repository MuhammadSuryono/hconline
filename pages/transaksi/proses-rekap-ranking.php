

<?php

    require_once("../../dist/koneksi.php");
    session_start();

    $R      = $_REQUEST;

    $action = isset($R['action']) != '' ? $R['action'] : '';

    switch ($action) {

        case 'tampilkan_absen':

            $awal       = $R['tgl_1'];
            $akhir      = new DateTime($R['tgl_2']);
            $akhir->modify('+1 day');
            $akhir      = $akhir->format('Y-m-d');

            $x          = new DateTime($awal);
            $y          = new DateTime($akhir);

            $jml_hari   = $x->diff($y);
            $jml_hari   = intval($jml_hari->days);

            $tgl        = intval($x->format('d'));
            $bln        = intval($x->format('n'));
            $thn        = intval($x->format('Y'));

            $tgl2        = intval($y->format('d'));
            $bln2        = intval($y->format('n'));
            $thn2        = intval($y->format('Y'));

            $stsd        = isset($R['STSD']) == '' ? '' : "AND izin = 'Sakit tanpa surat dokter'";



            // BEGIN ARRAY FROM TABLE ABSENSI

            $updatetanggal = mysql_query("UPDATE tanggal_mulaiakhir SET tanggalmulai = '$awal 00:00:00', tanggalakhir = '$akhir 23:59:59'");


            $absen = "<div class='table-responsive'>";
            $absen .= "<table class='table table-striped table-bordered' id='example1'>";
            $absen .= "<thead>";
            $absen .= "<tr>";
            $absen .= "<th rowspan='3' width='60px'>No</th>";
            $absen .= "<th rowspan='3' width='260px'>Nama Karyawan</th>";
            $absen .= "<th rowspan='2' bgcolor='#155050'>Masuk Tepat Waktu</th>";
            $absen .= "<th>hahaha</th>";
            $absen .= "</tr>";
            $absen .= "</thead>";
            $absen .= "<tbody>";

                $masukintanggal = mysql_query("SELECT * FROM absensi03 INNER JOIN tb_user ON absensi03.user_id = tb_user.id_absen ORDER BY JumMasukTdkTelat DESC");
                $no     = 1;
                while ($row = mysql_fetch_array($masukintanggal)) {
                    $absen .= "<tr>";
                    $absen .= "<td>".$no++."</td>";
                    $absen .= "<td align='left'>".$row['nama_user']."</td>";
                    $absen .= "<td bgcolor='#ffb0bd'>".$row['JumMasukTdkTelat']."</td>";
                    $absen .= "<td>$stsd</td>";
                    $absen .= "</tr>";
                }
                $absen .= "</tbody>";
                $absen .= "</table>";
                $absen .= "</div>";

            echo json_encode($absen);
            break;



        default:
            // header("Location: ../index.php");
            break;
    }

?>
