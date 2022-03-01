

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

            // BEGIN KALENDER
            $kalender_query = mysql_query("SELECT
                                            *
                                        FROM
                                            kalender
                                        WHERE
                                            tanggal BETWEEN '$awal'
                                            AND '$akhir'
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
                                            tanggal BETWEEN '$awal'
                                            AND '$akhir'
                                            AND persetujuan NOT IN ( 'Tidak Disetujui(Direksi)', 'Tidak Disetujui(Manager)' )
                                        ORDER BY
                                            tanggal ASC");
            $cuti = array();
            while ($row = mysql_fetch_array($cuti_query)) {
                $cuti[$row['username'].$row['tanggal']] = $row;
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
                                            tanggal BETWEEN '$awal'
                                            AND '$akhir'
                                        ORDER BY
                                            tanggal ASC");
            $unpaid = array();
            while ($row = mysql_fetch_array($unpaid_query)) {
                $unpaid[$row['username'].$row['tanggal']] = $row;
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
                                                    AND persetujuan NOT IN ( 'Tidak Disetujui(Manager)' )");
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
                                                AND persetujuan NOT IN ( 'Tidak Disetujui(Manager)' )");
            $izin_absen = array();
            while ($row = mysql_fetch_array($izin_absen_query)) {
                $izin_absen[$row['username'].$row['tanggal']] = $row;
            }
            // END

            $wd = 570;
            for ($i=1; $i <= $jml_hari; $i++) {
                $wd = $wd+150;
            }
            $absen = "<div class='table-responsive'>";
            $absen .= "<button type='button' class='btn btn-info' data-toggle='modal' data-target='#myModal' onclick='functionranking()'>Ranking</button>";
            $absen .= "<table class='table table-striped table-bordered' id='example1'>";
            $absen .= "<thead>";
            $absen .= "<tr>";
            $absen .= "<th rowspan='3' width='60px'>No</th>";
            $absen .= "<th rowspan='3' width='260px'>Nama Karyawan</th>";
                $d = $tgl;
                $t = intval($x->format('t'));
                $n = $bln;
                $y = $thn;

                $bln_thn    = date('F Y', mktime(0,0,0,$n,$d,$y));
                if ($n == $bln2) {
                    $colspan    = $tgl2 - $d;
                }else{
                    $colspan    = date('t', mktime(0,0,0,$n,1,$y))-$d+1;
                }

                //$absen      .= "<th colspan='".$colspan."'>".$bln_thn."</th>";
                for ($i=1; $i <= $jml_hari; $i++) {
                    if ($d > $t) {
                        if ($n >= 12) {
                            $n = 1;
                            $y++;
                        }else {
                            $n++;
                        }
                        $d = 1;
                        $t = date('t', mktime(0,0,0,$n,$d,$y));
                        $bln_thn = date('F Y', mktime(0,0,0,$n,$d,$y));
                        if (($jml_hari - $i) < $t) {
                            $t = $jml_hari - $i + 1;
                        }
                        //$absen      .= "<th colspan='".$t."'>".$bln_thn."</th>";
                    }
                    //$d++;
                }
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
                            //$absen .= "<th ".$warna." width='150px'>".$d."</th>";
                            $t = date('t', mktime(0,0,0,$n,$d,$y++));
                        }else {
                            $n++;
                            $hari = date('D', mktime(0,0,0,$n,$d,$y));
                            $warna = "";
                            if ($hari=='Sat' || $hari=='Sun') {
                                $warna = "bgcolor='#094e68'";
                            }
                            //$absen .= "<th ".$warna." width='150px'>".$d."</th>";
                            $t = date('t', mktime(0,0,0,$n,$d,$y));
                        }
                    }else {
                        $hari = date('D', mktime(0,0,0,$n,$d,$y));
                        $warna = "";
                        if ($hari=='Sat' || $hari=='Sun') {
                            $warna = "bgcolor='#094e68'";
                        }
                        //$absen .= "<th ".$warna." width='150px'>".$d."</th>";
                    }
                    $d++;
                }
            $absen .= "<th rowspan='2' bgcolor='#155050'>C</th>";
            $absen .= "<th rowspan='2' bgcolor='#155050'>M</th>";
            $absen .= "<th rowspan='2' bgcolor='#155050'>SDSD</th>";
            $absen .= "<th rowspan='2' bgcolor='#155050'>STSD</th>";
            $absen .= "<th rowspan='2' bgcolor='#155050'>UP</th>";
            $absen .= "<th rowspan='2' bgcolor='#155050'>Telat</th>";
            $absen .= "<th rowspan='2' bgcolor='#155050'> < 9 Jam</th>";
            $absen .= "<th rowspan='2' bgcolor='#155050'>Ranking</th>";
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
                            //$absen .= "<th ".$warna.">".$hari."</th>";
                            $t = date('t', mktime(0,0,0,$n,$d,$y++));
                        }else {
                            $n++;
                            $hari = date('D', mktime(0,0,0,$n,$d,$y));
                            $warna = "";
                            if ($hari=='Sat' || $hari=='Sun') {
                                $warna = "bgcolor='#094e68'";
                            }
                            //$absen .= "<th ".$warna.">".$hari."</th>";
                            $t = date('t', mktime(0,0,0,$n,$d,$y));
                        }
                    }else {
                        $hari = date('D', mktime(0,0,0,$n,$d,$y));
                        $warna = "";
                        if ($hari=='Sat' || $hari=='Sun') {
                            $warna = "bgcolor='#094e68'";
                        }
                        //$absen .= "<th ".$warna.">".$hari."</th>";
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
                $no     = 1;
                while ($row = mysql_fetch_array($user_query)) {
                    $absen .= "<tr>";
                    $absen .= "<td>".$no++."</td>";
                    $absen .= "<td align='left'>".$row['user_nama']."</td>";

                    $d = $tgl;
                    $t = intval($x->format('t'));
                    $n = $bln;
                    $y = $thn;

                    $c          = 0;
                    $m          = 0;
                    $sdsd       = 0;
                    $stsd       = 0;
                    $up         = 0;
                    $jml_telat  = 0;
                    $kurang9    = 0;

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
                        $rangejam   = "";
                        $btn        = "";
                        $telat      = "";
                        $cek        = isset($absen_array[$row['user_id'].$ymd]) == true ? 1 : 0;
                        if ($hari=='Sat' || $hari=='Sun') { // Sabtu / Minggu
                            if ($cek == 0) {
                                $warna  = "bgcolor='#e8f5ff'";
                            }else{
                                $jam = substr($absen_array[$row['user_id'].$ymd]['jam_total'], 0, -3);
                                $rangejam   = substr($absen_array[$row['user_id'].$ymd]['jam_masuk'], 0, -3)." - ".substr($absen_array[$row['user_id'].$ymd]['jam_keluar'], 0, -3)." = ".$jam;
                            }
                        }elseif ($cek == 0) { // Tidak Absen
                            $kal     = isset($kalender[$ymd]) == true ? 1 : 0;
                            if ($kal == 1) {
                                $warna  = "bgcolor='#E8F5FF'";
                            }else{
                                $izin1   = isset($izin_nonabsen[$row['inisial_id'].$ymd]) == true ? 1 : 0;
                                if ($izin1 == 1) { // Jika Form Izin ada
                                    $simbol = $izin_nonabsen[$row['inisial_id'].$ymd]['singkatan'];
                                    switch ($simbol) {
                                        case 'STSD':
                                            $warna  = "bgcolor='#ffdddd'";
                                            $stsd   = $stsd + 1;
                                            break;

                                        case 'SDSD':
                                            $warna  = "bgcolor='#fff968'";
                                            $sdsd   = $sdsd + 1;
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
                                    $btn = "onclick='window.open(\"http://180.211.92.131/hconline/izin/".$izin_nonabsen[$row['inisial_id'].$ymd]['gambar']."\", \"newwindow\", \"width=810,height=900\")'";
                                }else { // Jika Form Izin Tidak Ada --> Periksa data cuti
                                    $ada_cuti   = isset($cuti[$row['inisial_id'].$ymd]) == true ? 1 : 0;
                                    if ($ada_cuti == 1) { // Jika Form Cuti Ada
                                        $simbol     = "C";
                                        $c          = $c + 1;
                                        $warna      = "bgcolor='#05bcff'";
                                        $btn        = "onclick='window.open(\"http://180.211.92.131/hconline/uploads/".$cuti[$row['inisial_id'].$ymd]['gambar']."\", \"newwindow\", \"width=810,height=900\")'";
                                    }
                                    else { // Jika tidak abasen & tidak ditemukan data izin dan cuti
                                        $ada_unpaid   = isset($unpaid[$row['inisial_id'].$ymd]) == true ? 1 : 0;
                                        if ($ada_unpaid == 1) { // Jika Form Cuti Ada
                                            $simbol     = "UP";
                                            $up         = $up + 1;
                                            $warna      = "bgcolor='#a3a3a3'";
                                            $btn        = "onclick='window.open(\"http://180.211.92.131/hconline/uploads/".$unpaid[$row['inisial_id'].$ymd]['gambar']."\", \"newwindow\", \"width=810,height=900\")'";
                                        }elseif ($ymd >= date('Y-m-d')) {
                                            $warna  = "bgcolor='#fffeef'";
                                        }
                                        else { // Jika tidak abasen & tidak ditemukan data izin dan cuti
                                            $warna  = "bgcolor='#f94f4f'";
                                            $simbol = "M";
                                            $m      = $m + 1;
                                        }
                                    }
                                }
                            }
                        }else {
                            $izin2   = isset($izin_absen[$row['inisial_id'].$ymd]) == true ? 1 : 0;
                            if ($izin2 == 1) {
                                $inisial = $izin_absen[$row['inisial_id'].$ymd]['singkatan'];
                                if ($inisial == 'DTL2' || $inisial == 'PCL2') {
                                    $simbol = "C&frac12;</br>";
                                    $c = $c + 0.5;
                                }else{
                                    $simbol = $inisial."</br>";
                                }
                            }

                            $rangejam   = substr($absen_array[$row['user_id'].$ymd]['jam_masuk'], 0, -3)." - ".substr($absen_array[$row['user_id'].$ymd]['jam_keluar'], 0, -3);
                            $jamtotal = $absen_array[$row['user_id'].$ymd]['jam_total'];
                            $jam = substr($jamtotal, 0, -3);
                            $cal = intval(substr($jamtotal, 0, -6));
                            if ($cal < 9) {
                                $warna  = "bgcolor='#4397B8'";
                                $kurang9 = $kurang9 + 1;
                            }
                            $rangejam   = substr($absen_array[$row['user_id'].$ymd]['jam_masuk'], 0, -3)." - ".substr($absen_array[$row['user_id'].$ymd]['jam_keluar'], 0, -3)." = ".$jam;
                            $fff = strtotime('09:00:00');
                            $ccc = strtotime($absen_array[$row['user_id'].$ymd]['jam_masuk']);
                            if ($ccc > $fff) {
                                $telat = "<font color='red'><b>TELAT</b></font></br>";
                                $jml_telat = $jml_telat + 1;
                            }else {
                                $telat = "";
                            }
                        }
                        $key = $row['user_id']."-".$row['inisial_id']."-".$ymd;
                        //$absen .= "<td ".$warna." ".$btn."><center>".$telat.$simbol.$rangejam."</center></td>";
                        $d++;
                    }

                    $c      = ($c)==0 ? "" : $c;
                    $m      = ($m)==0 ? "" : $m;
                    $sdsd   = ($sdsd)==0 ? "" : $sdsd;
                    $stsd   = ($stsd)==0 ? "" : $stsd;
                    $up     = ($up)==0 ? "" : $up;



                    $absen .= "<td bgcolor='#d3f3ff'>".$c."</td>";
                    $absen .= "<td bgcolor='#ffc9c9'>".$m."</td>";
                    $absen .= "<td bgcolor='#fffddb'>".$sdsd."</td>";
                    $absen .= "<td bgcolor='#fff2f2'>".$stsd."</td>";
                    $absen .= "<td bgcolor='#dbdbdb'>".$up."</td>";
                    $absen .= "<td bgcolor='#ffb0bd'>".$jml_telat."</td>";
                    $absen .= "<td bgcolor='#4397B8'>".$kurang9."</td>";
                    $ranking = $jml_telat + $kurang9;
                    $absen .= "<td bgcolor='#4397B8'>".$ranking."</td>";
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
