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

            // BEGIN ARRAY FROM TABLE ABSENSI
            $absen_query = mysql_query("SELECT
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
            $absen_array = array();
            while ($row = mysql_fetch_array($absen_query)) {
                $absen_array[$row['user_id'].$row['tanggal']] = $row;
            }
            // END

            // BEGIN CUTI FROM TABLE TB_MOHONCUTI
            $cuti_query = mysql_query("SELECT
                                            username,
                                            tanggal 
                                        FROM
                                            daterange_cuti 
                                        WHERE
                                            tanggal BETWEEN '$awal' 
                                            AND '$akhir' 
                                            AND persetujuan NOT IN ( 'Tidak Disetujui(Direksi)', 'Tidak Disetujui(Manager)', '' ) 
                                        ORDER BY
                                            tanggal ASC");
            $cuti = array();
            while ($row = mysql_fetch_array($cuti_query)) {
                $cuti[$row['username'].$row['tanggal']] = $row;
            }
            // END

            // BEGIN ARRAY NON ABSEN FROM TABLE TB_IZIN
            $izin_nonabsen_query = mysql_query("SELECT
                                                    username,
                                                    tanggal,
                                                CASE
                                                        jenis 
                                                        WHEN 'Dinas' THEN
                                                        'D' 
                                                        WHEN 'Sakit Dengan Surat Dokter' THEN
                                                        'SDSD' 
                                                        WHEN 'Sakit Tanpa Surat Dokter' THEN
                                                        'STSD' 
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
                                                    jenis IN ( 'Dinas', 'Sakit Dengan Surat Dokter', 'Sakit Tanpa Surat Dokter', 'Tugas' ) 
                                                    AND tanggal BETWEEN '$awal' 
                                                    AND '$akhir' 
                                                    AND persetujuan NOT IN ( 'Tidak Disetujui(Manager)', '' )");
            $izin_nonabsen = array();
            while ($row = mysql_fetch_array($izin_nonabsen_query)) {
                $izin_nonabsen[$row['username'].$row['tanggal']] = $row;
            }
            // END

            // BEGIN ARRAY DENGAN ABSEN FROM TABLE TB_IZIN
            $izin_absen_query = mysql_query("SELECT
                                                username,
                                                tanggal,
                                            CASE
                                                    jenis 
                                                    WHEN 'Dinas' THEN
                                                    'D' 
                                                    WHEN 'Sakit Dengan Surat Dokter' THEN
                                                    'SDSD' 
                                                    WHEN 'Sakit Tanpa Surat Dokter' THEN
                                                    'STSD' 
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
                                                AND tanggal BETWEEN '$awal' 
                                                AND '$akhir' 
                                                AND persetujuan NOT IN ( 'Tidak Disetujui(Manager)', '' )");
            $izin_absen = array();
            while ($row = mysql_fetch_array($izin_absen_query)) {
                $izin_absen[$row['username'].$row['tanggal']] = $row;
            }
            // END


            $wd = 320;
            for ($i=1; $i <= $jml_hari; $i++) { 
                $wd = $wd+40;
            }
            $absen = "<table width='".$wd."px' class='blueTable table-striped'>";
            $absen .= "<thead>";
            $absen .= "<tr>";
            $absen .= "<th rowspan='3' width='60px'>No</th>";
            $absen .= "<th rowspan='3' width='260px'>Nama Karyawan</th>";
                $d = $tgl;
                $t = intval($x->format('t'));
                $n = $bln;
                $y = $thn;

                $bln_thn    = date('F Y', mktime(0,0,0,$n,$d,$y));
                $colspan    = date('t', mktime(0,0,0,$n,1,$y))-$d+1;
                $absen      .= "<th colspan='".$colspan."'>".$bln_thn."</th>";
                for ($i=1; $i <= $jml_hari; $i++) { 
                    if ($d > $t) {
                        if ($n >= 12) {
                            $n      = 1;
                            $y++;
                        }else {
                            $n++;
                        }
                        $d          = 1;
                        $t          = date('t', mktime(0,0,0,$n,$d,$y));
                        $bln_thn    = date('F Y', mktime(0,0,0,$n,$d,$y));
                        $absen      .= "<th colspan='".$t."'>".$bln_thn."</th>";
                    }
                    $d++;
                }
            $absen .= "</tr>";
            $absen .= "<tr>";

                $d = $tgl;
                $t = intval($x->format('t'));
                $n = $bln;
                $y = $thn;
                for ($i=1; $i <= $jml_hari; $i++) { 
                    if ($d > $t) {
                        $d = 1;
                        if ($n >= 12) {
                            $n = 1;
                            $hari = date('D', mktime(0,0,0,$n,$d,$y));
                            $warna = "";
                            if ($hari=='Sat' || $hari=='Sun') {
                                $warna = "bgcolor='#094e68'";
                            }
                            $absen .= "<th ".$warna." width='40px'>".$d."</th>";
                            $t = date('t', mktime(0,0,0,$n,$d,$y++));
                        }else {
                            $n++;
                            $hari = date('D', mktime(0,0,0,$n,$d,$y));
                            $warna = "";
                            if ($hari=='Sat' || $hari=='Sun') {
                                $warna = "bgcolor='#094e68'";
                            }
                            $absen .= "<th ".$warna." width='40px'>".$d."</th>";
                            $t = date('t', mktime(0,0,0,$n,$d,$y));
                        }
                    }else {
                        $hari = date('D', mktime(0,0,0,$n,$d,$y));
                        $warna = "";
                        if ($hari=='Sat' || $hari=='Sun') {
                            $warna = "bgcolor='#094e68'";
                        }
                        $absen .= "<th ".$warna." width='40px'>".$d."</th>";
                    }
                    $d++;
                }
            $absen .= "</tr>";
            $absen .= "<tr>";
                $d = $tgl;
                $t = intval($x->format('t'));
                $n = $bln;
                $y = $thn;
                for ($i=1; $i <= $jml_hari; $i++) { 
                    if ($d > $t) {
                        $d = 1;
                        if ($n >= 12) {
                            $n = 1;
                            $hari = date('D', mktime(0,0,0,$n,$d,$y));
                            $warna = "";
                            if ($hari=='Sat' || $hari=='Sun') {
                                $warna = "bgcolor='#094e68'";
                            }
                            $absen .= "<th ".$warna.">".$hari."</th>";
                            $t = date('t', mktime(0,0,0,$n,$d,$y++));
                        }else {
                            $n++;
                            $hari = date('D', mktime(0,0,0,$n,$d,$y));
                            $warna = "";
                            if ($hari=='Sat' || $hari=='Sun') {
                                $warna = "bgcolor='#094e68'";
                            }
                            $absen .= "<th ".$warna.">".$hari."</th>";
                            $t = date('t', mktime(0,0,0,$n,$d,$y));
                        }
                    }else {
                        $hari = date('D', mktime(0,0,0,$n,$d,$y));
                        $warna = "";
                        if ($hari=='Sat' || $hari=='Sun') {
                            $warna = "bgcolor='#094e68'";
                        }
                        $absen .= "<th ".$warna.">".$hari."</th>";
                    }
                    $d++;
                }
            $absen .= "</tr>";
            $absen .= "</thead>";
            $absen .= "<tbody>";
                $user_query = mysql_query("SELECT
                                                id_absen AS user_id,
                                                nama_user AS user_nama,
                                                id_user AS inisial_id 
                                            FROM
                                                tb_user 
                                            WHERE
                                                id_absen != '' 
                                                AND resign = 0 
                                            ORDER BY
                                                nama_user ASC");
                $no = 1;
                while ($row = mysql_fetch_array($user_query)) {
                    $absen .= "<tr>";
                    $absen .= "<td>".$no++."</td>";
                    $absen .= "<td align='left'>".$row['user_nama']."</td>";

                    $d = $tgl;
                    $t = intval($x->format('t'));
                    $n = $bln;
                    $y = $thn;
                    for ($i=1; $i <= $jml_hari; $i++) { 
                        if ($d > $t) {
                            $d = 1;
                            if ($n >= 12) {
                                $n      = 1;
                                $ymd    = date('Y-m-d', mktime(0,0,0,$n,$d,$y));
                                $t      = date('t', mktime(0,0,0,$n,$d,$y++));
                            }else {
                                $n++;
                                $ymd    = date('Y-m-d', mktime(0,0,0,$n,$d,$y));
                                $t      = date('t', mktime(0,0,0,$n,$d,$y));
                            }
                        }else {
                            $ymd    = date('Y-m-d', mktime(0,0,0,$n,$d,$y));
                        }
                        $hari       = new DateTime($ymd);
                        $hari       = $hari->format('D');
                        $simbol     = "";
                        $warna      = "";
                        $jam        = "";
                        $cek        = isset($absen_array[$row['user_id'].$ymd]) == true ? 1 : 0;
                        if ($hari=='Sat' || $hari=='Sun') { // Sabtu / Minggu
                            if ($cek == 0) {
                                $warna  = "bgcolor='#e8f5ff'";
                            }else{
                                $jam = substr($absen_array[$row['user_id'].$ymd]['jam_total'], 0, -3);
                            }
                        }elseif ($cek == 0) { // Tidak Absen
                            $izin1   = isset($izin_nonabsen[$row['inisial_id'].$ymd]) == true ? 1 : 0;
                            if ($izin1 == 1) { // Jika Form Izin ada
                                $simbol = $izin_nonabsen[$row['inisial_id'].$ymd]['singkatan'];
                                switch ($simbol) {
                                    case 'STSD':
                                        $warna  = "bgcolor='#ffdddd'";
                                        break;

                                    case 'SDSD':
                                        $warna  = "bgcolor='#fff968'";
                                        break;
                                    
                                    case 'D':
                                        $warna  = "bgcolor='#b1e580'";
                                        break;
                                    
                                    case 'T':
                                        $warna  = "bgcolor='#b1e580'";
                                        break;

                                    default:
                                        $warna  = "bgcolor='#b1e580'";
                                        break;
                                }
                            }else { // Jika Form Izin Tidak Ada --> Periksa data cuti
                                $ada_cuti   = isset($cuti[$row['inisial_id'].$ymd]) == true ? 1 : 0;
                                if ($ada_cuti == 1) { // Jika Form Cuti Ada
                                    $simbol     = "C";
                                    $warna      = "bgcolor='#05bcff'";
                                }
                                elseif ($ymd >= date('Y-m-d')) {
                                    $warna  = "bgcolor='#fffeef'";
                                }
                                else { // Jika tidak abasen & tidak ditemukan data izin dan cuti
                                    $warna  = "bgcolor='#f94f4f'";
                                    $simbol = "M";
                                }
                            }
                        }else {
                            $izin2   = isset($izin_absen[$row['inisial_id'].$ymd]) == true ? 1 : 0;
                            if ($izin2 == 1) {
                                $simbol = $izin_absen[$row['inisial_id'].$ymd]['singkatan']."</br>";
                            }
                            $jamtotal = $absen_array[$row['user_id'].$ymd]['jam_total'];
                            $jam = substr($jamtotal, 0, -3);
                            $cal = intval(substr($jamtotal, 0, -6));
                            if ($cal < 9) {
                                $warna  = "bgcolor='#4397B8'";
                            }
                        }

                        $key = $row['user_id']."-".$row['inisial_id']."-".$ymd;
                        $absen .= "<td ".$warna."><center>".$simbol.$jam."</center></td>";
                        $d++;
                    }
                    $absen .= "</tr>";
                }
                $absen .= "</tbody>";
                $absen .= "</table>";
            echo json_encode($absen);
            break;

        default:
            // header("Location: ../index.php");
            break;
    }


?>