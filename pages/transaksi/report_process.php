<?php

    require_once("../../dist/koneksi.php");
    session_start();

    $R      = $_REQUEST;

    $action = isset($R['action']) != '' ? $R['action'] : '';

    switch ($action) {

        case 'get_report':

            $id_user    = $R['id_user'];
            $id_absen   = $R['id_absen'];
            $tahun      = $R['tahun'];

            // BEGIN JAM MASUK & PULANG
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
                                                YEAR ( tgl_dan_jam ) = '$tahun'
                                                AND user_id = '$id_absen'
                                            GROUP BY
                                                user_id,
                                                tanggal
                                            ) AS masukdanpulang
                                        ORDER BY
                                            tanggal ASC");
            $absen_array = array();
            while ($row = mysql_fetch_array($absen_query)) {
                $absen_array[$row['tanggal']] = $row;
            }
            // END

            // BEGIN KALENDER
            $kalender_query = mysql_query("SELECT
                                            *
                                        FROM
                                            kalender
                                        WHERE
                                            YEAR ( tanggal ) = '$tahun'
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
                                            YEAR(tanggal) = '$tahun'
                                            AND username = '$id_user'
                                            AND persetujuan NOT IN ( 'Tidak Disetujui(Direksi)', 'Tidak Disetujui(Manager)' )
                                        ORDER BY
                                            tanggal ASC");
            $cuti_array = array();
            while ($row = mysql_fetch_array($cuti_query)) {
                $cuti_array[$row['tanggal']] = $row;
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
                                            YEAR(tanggal) = '$tahun'
                                            AND username = '$id_user'
                                        ORDER BY
                                            tanggal ASC");
            $unpaid_array = array();
            while ($row = mysql_fetch_array($unpaid_query)) {
                $unpaid_array[$row['tanggal']] = $row;
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
                                                    AND YEAR(tanggal) = '$tahun'
                                                    AND username = '$id_user'
                                                    AND persetujuan NOT IN ( 'Tidak Disetujui(Manager)' )");
            $izin_nonabsen = array();
            while ($row = mysql_fetch_array($izin_nonabsen_query)) {
                $izin_nonabsen[$row['tanggal']] = $row;
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
                                                AND YEAR ( tanggal ) = '$tahun'
                                                AND username = '$id_user'
                                                AND persetujuan NOT IN ( 'Tidak Disetujui(Manager)' )");
            $izin_absen = array();
            while ($row = mysql_fetch_array($izin_absen_query)) {
                $izin_absen[$row['username'].$row['tanggal']] = $row;
            }
            // END

            $now = date('Y-m-d');
            $report = "<table class='reportTahunan'>";
            $report .= "<thead>";
            $report .= "<tr>";
            $report .= "<th rowspan='2'>No</th>";
            $report .= "<th rowspan='2'>Month</th>";
            $report .= "<th rowspan='2' colspan='31'>Date</th>";
            // $report .= "<th rowspan='2'>Sisa Hak Cuti Tahun Lalu</th>";
            // $report .= "<th rowspan='2'>Hak Cuti Tahun Berjalan</th>";
            $report .= "<th rowspan='2'>Cuti yg sudah diambil</th>";
            $report .= "<th colspan='2'>Status</th>";
            $report .= "</tr>";
            $report .= "<tr>";
            $report .= "<th>Approve</th>";
            $report .= "<th>Belum Approve</th>";
            $report .= "</tr>";
            $report .= "</thead>";
            $report .= "<tbody>";
            $report .= "<tr>";
            $report .= "<td>1</td>";
            $report .= "<td>Jan</td>";
                $bln = "01";
                $tgl = date('t', mktime(0,0,0,$bln,1,$tahun));
                for ($i=1; $i <= 31; $i++) {
                    $tglRet = $i<=$tgl ? str_pad($i, 2, "0", STR_PAD_LEFT) : "" ;
                    $tglYmd = $i<=$tgl ? $tahun."-".$bln."-".str_pad($i, 2, "0", STR_PAD_LEFT) : "" ;
                    $tglDay = new DateTime($tglYmd);
                    $tglDay = $tglDay->format('D');
                    $warna = "";

                    if (strtotime($tglYmd) < strtotime($now) && $tglRet != "") {
                        $cek    = isset($absen_array[$tglYmd]) == true ? 1 : 0;
                        $izin   = isset($izin_nonabsen[$tglYmd]) == true ? 1 : 0;
                        $cuti   = isset($cuti_array[$tglYmd]) == true ? 1 : 0;
                        $unpaid = isset($unpaid_array[$tglYmd]) == true ? 1 : 0;
                        $libur  = isset($kalender[$tglYmd]) == true ? 1 : 0;
                        if ($cek != 0) { // Jika ada absen
                            $warna  = "";
                        }
                        elseif ($tglDay=='Sat' || $tglDay=='Sun') { // Jika Sabtu / Minggu
                            $warna  = "bgcolor='#cff4f9'";
                        }
                        elseif ($izin == 1) { // Jika Izin tanpa absen
                            $simbol = $izin_nonabsen[$tglYmd]['singkatan'];
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
                            }
                        }
                        elseif ($cuti == 1) { // Jika cuti
                            $warna = "bgcolor='#05bcff'";
                        }
                        elseif ($unpaid == 1) { // Jika Unpaid
                            $warna = "bgcolor='#a3a3a3'";
                        }
                        elseif ($libur == 1) {
                            $warna  = "bgcolor='#cff4f9'";
                        }
                        else{
                            $warna = "bgcolor='#ffb2a8'";
                        }
                    }
                    else {
                        $warna  = "bgcolor='#fff1c6'";
                    }

                    $report .= "<td ".$warna.">".$tglRet."</td>";
                }
            // $report .= "<td>t</td>";
            // $report .= "<td>j</td>";
            $report .= "<td>";
                    $jml_cuti = mysql_query("SELECT
                                                COUNT(no) AS jml_cuti
                                            FROM
                                                daterange_cuti
                                            WHERE
                                                YEAR ( tanggal ) = $tahun
                                                AND MONTH ( tanggal ) = $bln
                                                AND username = '$id_user'
                                                AND persetujuan IN ( 'Disetujui(Direksi)', 'Disetujui(Manager)' )");
                    $jml_cuti = mysql_fetch_assoc($jml_cuti);
                    $jml_cuti = isset($jml_cuti['jml_cuti']) != "" ? $jml_cuti['jml_cuti'] : 0;

                    $jml_izin = mysql_query("SELECT
                                                COUNT( NO ) AS jml_izin,
                                            CASE
                                                    jenis
                                                    WHEN 'Sakit Tanpa Surat Dokter' THEN
                                                    'STSD'
                                                    WHEN 'Datang Telat Lebih Dari 2 Jam' THEN
                                                    'DTL2'
                                                    WHEN 'Pulang Lebih Cepat Lebih Dari 2 Jam' THEN
                                                    'PCL2' ELSE jenis
                                                END AS singkatan
                                            FROM
                                                daterange_izin
                                            WHERE
                                                jenis IN ( 'Datang Telat Lebih Dari 2 Jam', 'Pulang Lebih Cepat Lebih Dari 2 Jam', 'Sakit Tanpa Surat Dokter' )
                                                AND YEAR ( tanggal ) = $tahun
                                                AND MONTH ( tanggal ) = $bln
                                                AND username = '$id_user'
                                                AND persetujuan NOT IN ( 'Tidak Disetujui(Manager)' )
                                            GROUP BY
                                                singkatan
                                            ORDER BY
                                                singkatan ASC");
                    $jmlizin = 0;
                    while ($row = mysql_fetch_array($jml_izin)) {
                        if ($row['singkatan'] == 'STSD') {
                            $jmlizin = $jmlizin + $row['jml_izin'];
                        }else{
                            $jmlizin = $jmlizin + ($row['jml_izin'] * 0.5);
                        }
                    }

                    $total = $jml_cuti+$jmlizin;

            $report .= $total."</td>";
            $report .= "<td></td>";
            $report .= "<td></td>";
            $report .= "</tr>";
            $report .= "<tr>";
            $report .= "<td>2</td>";
            $report .= "<td>Feb</td>";
                $bln = "02";
                $tgl = date('t', mktime(0,0,0,$bln,1,$tahun));
                for ($i=1; $i <= 31; $i++) {
                    $tglRet = $i<=$tgl ? str_pad($i, 2, "0", STR_PAD_LEFT) : "" ;
                    $tglYmd = $i<=$tgl ? $tahun."-".$bln."-".str_pad($i, 2, "0", STR_PAD_LEFT) : "" ;
                    $tglDay = new DateTime($tglYmd);
                    $tglDay = $tglDay->format('D');
                    $warna = "";

                    if (strtotime($tglYmd) < strtotime($now) && $tglRet != "") {
                        $cek    = isset($absen_array[$tglYmd]) == true ? 1 : 0;
                        $izin   = isset($izin_nonabsen[$tglYmd]) == true ? 1 : 0;
                        $cuti   = isset($cuti_array[$tglYmd]) == true ? 1 : 0;
                        $unpaid = isset($unpaid_array[$tglYmd]) == true ? 1 : 0;
                        $libur  = isset($kalender[$tglYmd]) == true ? 1 : 0;
                        if ($cek != 0) { // Jika ada absen
                            $warna  = "";
                        }
                        elseif ($tglDay=='Sat' || $tglDay=='Sun') { // Jika Sabtu / Minggu
                            $warna  = "bgcolor='#cff4f9'";
                        }
                        elseif ($izin == 1) { // Jika Izin tanpa absen
                            $simbol = $izin_nonabsen[$tglYmd]['singkatan'];
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
                            }
                        }
                        elseif ($cuti == 1) { // Jika cuti
                            $warna = "bgcolor='#05bcff'";
                        }
                        elseif ($unpaid == 1) { // Jika Unpaid
                            $warna = "bgcolor='#a3a3a3'";
                        }
                        elseif ($libur == 1) {
                            $warna  = "bgcolor='#cff4f9'";
                        }
                        else{
                            $warna = "bgcolor='#ffb2a8'";
                        }
                    }
                    else {
                        $warna  = "bgcolor='#fff1c6'";
                    }

                    $report .= "<td ".$warna.">".$tglRet."</td>";
                }
            // $report .= "<td>t</td>";
            // $report .= "<td>j</td>";
            $report .= "<td>";
                    $jml_cuti = mysql_query("SELECT
                                                COUNT(no) AS jml_cuti
                                            FROM
                                                daterange_cuti
                                            WHERE
                                                YEAR ( tanggal ) = $tahun
                                                AND MONTH ( tanggal ) = $bln
                                                AND username = '$id_user'
                                                AND persetujuan IN ( 'Disetujui(Direksi)', 'Disetujui(Manager)' )");
                    $jml_cuti = mysql_fetch_assoc($jml_cuti);
                    $jml_cuti = isset($jml_cuti['jml_cuti']) != "" ? $jml_cuti['jml_cuti'] : 0;
            $report .= $jml_cuti."</td>";
            $report .= "<td></td>";
            $report .= "<td></td>";
            $report .= "</tr>";
            $report .= "<tr>";
            $report .= "<td>3</td>";
            $report .= "<td>Mar</td>";
                $bln = "03";
                $tgl = date('t', mktime(0,0,0,$bln,1,$tahun));
                for ($i=1; $i <= 31; $i++) {
                    $tglRet = $i<=$tgl ? str_pad($i, 2, "0", STR_PAD_LEFT) : "" ;
                    $tglYmd = $i<=$tgl ? $tahun."-".$bln."-".str_pad($i, 2, "0", STR_PAD_LEFT) : "" ;
                    $tglDay = new DateTime($tglYmd);
                    $tglDay = $tglDay->format('D');
                    $warna = "";

                    if (strtotime($tglYmd) < strtotime($now) && $tglRet != "") {
                        $cek    = isset($absen_array[$tglYmd]) == true ? 1 : 0;
                        $izin   = isset($izin_nonabsen[$tglYmd]) == true ? 1 : 0;
                        $cuti   = isset($cuti_array[$tglYmd]) == true ? 1 : 0;
                        $unpaid = isset($unpaid_array[$tglYmd]) == true ? 1 : 0;
                        $libur  = isset($kalender[$tglYmd]) == true ? 1 : 0;
                        if ($cek != 0) { // Jika ada absen
                            $warna  = "";
                        }
                        elseif ($tglDay=='Sat' || $tglDay=='Sun') { // Jika Sabtu / Minggu
                            $warna  = "bgcolor='#cff4f9'";
                        }
                        elseif ($izin == 1) { // Jika Izin tanpa absen
                            $simbol = $izin_nonabsen[$tglYmd]['singkatan'];
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
                            }
                        }
                        elseif ($cuti == 1) { // Jika cuti
                            $warna = "bgcolor='#05bcff'";
                        }
                        elseif ($unpaid == 1) { // Jika Unpaid
                            $warna = "bgcolor='#a3a3a3'";
                        }
                        elseif ($libur == 1) {
                            $warna  = "bgcolor='#cff4f9'";
                        }
                        else{
                            $warna = "bgcolor='#ffb2a8'";
                        }
                    }
                    else {
                        $warna  = "bgcolor='#fff1c6'";
                    }

                    $report .= "<td ".$warna.">".$tglRet."</td>";
                }
            // $report .= "<td>t</td>";
            // $report .= "<td>j</td>";
            $report .= "<td>";
                    $jml_cuti = mysql_query("SELECT
                                                COUNT(no) AS jml_cuti
                                            FROM
                                                daterange_cuti
                                            WHERE
                                                YEAR ( tanggal ) = $tahun
                                                AND MONTH ( tanggal ) = $bln
                                                AND username = '$id_user'
                                                AND persetujuan IN ( 'Disetujui(Direksi)', 'Disetujui(Manager)' )");
                    $jml_cuti = mysql_fetch_assoc($jml_cuti);
                    $jml_cuti = isset($jml_cuti['jml_cuti']) != "" ? $jml_cuti['jml_cuti'] : 0;
            $report .= $jml_cuti."</td>";
            $report .= "<td></td>";
            $report .= "<td></td>";
            $report .= "</tr>";
            $report .= "<tr>";
            $report .= "<td>4</td>";
            $report .= "<td>Apr</td>";
                $bln = "04";
                $tgl = date('t', mktime(0,0,0,$bln,1,$tahun));
                for ($i=1; $i <= 31; $i++) {
                    $tglRet = $i<=$tgl ? str_pad($i, 2, "0", STR_PAD_LEFT) : "" ;
                    $tglYmd = $i<=$tgl ? $tahun."-".$bln."-".str_pad($i, 2, "0", STR_PAD_LEFT) : "" ;
                    $tglDay = new DateTime($tglYmd);
                    $tglDay = $tglDay->format('D');
                    $warna = "";

                    if (strtotime($tglYmd) < strtotime($now) && $tglRet != "") {
                        $cek    = isset($absen_array[$tglYmd]) == true ? 1 : 0;
                        $izin   = isset($izin_nonabsen[$tglYmd]) == true ? 1 : 0;
                        $cuti   = isset($cuti_array[$tglYmd]) == true ? 1 : 0;
                        $unpaid = isset($unpaid_array[$tglYmd]) == true ? 1 : 0;
                        $libur  = isset($kalender[$tglYmd]) == true ? 1 : 0;
                        if ($cek != 0) { // Jika ada absen
                            $warna  = "";
                        }
                        elseif ($tglDay=='Sat' || $tglDay=='Sun') { // Jika Sabtu / Minggu
                            $warna  = "bgcolor='#cff4f9'";
                        }
                        elseif ($izin == 1) { // Jika Izin tanpa absen
                            $simbol = $izin_nonabsen[$tglYmd]['singkatan'];
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
                            }
                        }
                        elseif ($cuti == 1) { // Jika cuti
                            $warna = "bgcolor='#05bcff'";
                        }
                        elseif ($unpaid == 1) { // Jika Unpaid
                            $warna = "bgcolor='#a3a3a3'";
                        }
                        elseif ($libur == 1) {
                            $warna  = "bgcolor='#cff4f9'";
                        }
                        else{
                            $warna = "bgcolor='#ffb2a8'";
                        }
                    }
                    else {
                        $warna  = "bgcolor='#fff1c6'";
                    }

                    $report .= "<td ".$warna.">".$tglRet."</td>";
                }
            // $report .= "<td>t</td>";
            // $report .= "<td>j</td>";
            $report .= "<td>";
                    $jml_cuti = mysql_query("SELECT
                                                COUNT(no) AS jml_cuti
                                            FROM
                                                daterange_cuti
                                            WHERE
                                                YEAR ( tanggal ) = $tahun
                                                AND MONTH ( tanggal ) = $bln
                                                AND username = '$id_user'
                                                AND persetujuan IN ( 'Disetujui(Direksi)', 'Disetujui(Manager)' )");
                    $jml_cuti = mysql_fetch_assoc($jml_cuti);
                    $jml_cuti = isset($jml_cuti['jml_cuti']) != "" ? $jml_cuti['jml_cuti'] : 0;
            $report .= $jml_cuti."</td>";
            $report .= "<td></td>";
            $report .= "<td></td>";
            $report .= "</tr>";
            $report .= "<tr>";
            $report .= "<td>5</td>";
            $report .= "<td>Mei</td>";
                $bln = "05";
                $tgl = date('t', mktime(0,0,0,$bln,1,$tahun));
                for ($i=1; $i <= 31; $i++) {
                    $tglRet = $i<=$tgl ? str_pad($i, 2, "0", STR_PAD_LEFT) : "" ;
                    $tglYmd = $i<=$tgl ? $tahun."-".$bln."-".str_pad($i, 2, "0", STR_PAD_LEFT) : "" ;
                    $tglDay = new DateTime($tglYmd);
                    $tglDay = $tglDay->format('D');
                    $warna = "";

                    if (strtotime($tglYmd) < strtotime($now) && $tglRet != "") {
                        $cek    = isset($absen_array[$tglYmd]) == true ? 1 : 0;
                        $izin   = isset($izin_nonabsen[$tglYmd]) == true ? 1 : 0;
                        $cuti   = isset($cuti_array[$tglYmd]) == true ? 1 : 0;
                        $unpaid = isset($unpaid_array[$tglYmd]) == true ? 1 : 0;
                        $libur  = isset($kalender[$tglYmd]) == true ? 1 : 0;
                        if ($cek != 0) { // Jika ada absen
                            $warna  = "";
                        }
                        elseif ($tglDay=='Sat' || $tglDay=='Sun') { // Jika Sabtu / Minggu
                            $warna  = "bgcolor='#cff4f9'";
                        }
                        elseif ($izin == 1) { // Jika Izin tanpa absen
                            $simbol = $izin_nonabsen[$tglYmd]['singkatan'];
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
                            }
                        }
                        elseif ($cuti == 1) { // Jika cuti
                            $warna = "bgcolor='#05bcff'";
                        }
                        elseif ($unpaid == 1) { // Jika Unpaid
                            $warna = "bgcolor='#a3a3a3'";
                        }
                        elseif ($libur == 1) {
                            $warna  = "bgcolor='#cff4f9'";
                        }
                        else{
                            $warna = "bgcolor='#ffb2a8'";
                        }
                    }
                    else {
                        $warna  = "bgcolor='#fff1c6'";
                    }

                    $report .= "<td ".$warna.">".$tglRet."</td>";
                }
            // $report .= "<td>t</td>";
            // $report .= "<td>j</td>";
            $report .= "<td>";
                    $jml_cuti = mysql_query("SELECT
                                                COUNT(no) AS jml_cuti
                                            FROM
                                                daterange_cuti
                                            WHERE
                                                YEAR ( tanggal ) = $tahun
                                                AND MONTH ( tanggal ) = $bln
                                                AND username = '$id_user'
                                                AND persetujuan IN ( 'Disetujui(Direksi)', 'Disetujui(Manager)' )");
                    $jml_cuti = mysql_fetch_assoc($jml_cuti);
                    $jml_cuti = isset($jml_cuti['jml_cuti']) != "" ? $jml_cuti['jml_cuti'] : 0;
            $report .= $jml_cuti."</td>";
            $report .= "<td></td>";
            $report .= "<td></td>";
            $report .= "</tr>";
            $report .= "<tr>";
            $report .= "<td>6</td>";
            $report .= "<td>Jun</td>";
                $bln = "06";
                $tgl = date('t', mktime(0,0,0,$bln,1,$tahun));
                for ($i=1; $i <= 31; $i++) {
                    $tglRet = $i<=$tgl ? str_pad($i, 2, "0", STR_PAD_LEFT) : "" ;
                    $tglYmd = $i<=$tgl ? $tahun."-".$bln."-".str_pad($i, 2, "0", STR_PAD_LEFT) : "" ;
                    $tglDay = new DateTime($tglYmd);
                    $tglDay = $tglDay->format('D');
                    $warna = "";

                    if (strtotime($tglYmd) < strtotime($now) && $tglRet != "") {
                        $cek    = isset($absen_array[$tglYmd]) == true ? 1 : 0;
                        $izin   = isset($izin_nonabsen[$tglYmd]) == true ? 1 : 0;
                        $cuti   = isset($cuti_array[$tglYmd]) == true ? 1 : 0;
                        $unpaid = isset($unpaid_array[$tglYmd]) == true ? 1 : 0;
                        $libur  = isset($kalender[$tglYmd]) == true ? 1 : 0;
                        if ($cek != 0) { // Jika ada absen
                            $warna  = "";
                        }
                        elseif ($tglDay=='Sat' || $tglDay=='Sun') { // Jika Sabtu / Minggu
                            $warna  = "bgcolor='#cff4f9'";
                        }
                        elseif ($izin == 1) { // Jika Izin tanpa absen
                            $simbol = $izin_nonabsen[$tglYmd]['singkatan'];
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
                            }
                        }
                        elseif ($cuti == 1) { // Jika cuti
                            $warna = "bgcolor='#05bcff'";
                        }
                        elseif ($unpaid == 1) { // Jika Unpaid
                            $warna = "bgcolor='#a3a3a3'";
                        }
                        elseif ($libur == 1) {
                            $warna  = "bgcolor='#cff4f9'";
                        }
                        else{
                            $warna = "bgcolor='#ffb2a8'";
                        }
                    }
                    else {
                        $warna  = "bgcolor='#fff1c6'";
                    }

                    $report .= "<td ".$warna.">".$tglRet."</td>";
                }
            // $report .= "<td>t</td>";
            // $report .= "<td>j</td>";
            $report .= "<td>";
                    $jml_cuti = mysql_query("SELECT
                                                COUNT(no) AS jml_cuti
                                            FROM
                                                daterange_cuti
                                            WHERE
                                                YEAR ( tanggal ) = $tahun
                                                AND MONTH ( tanggal ) = $bln
                                                AND username = '$id_user'
                                                AND persetujuan IN ( 'Disetujui(Direksi)', 'Disetujui(Manager)' )");
                    $jml_cuti = mysql_fetch_assoc($jml_cuti);
                    $jml_cuti = isset($jml_cuti['jml_cuti']) != "" ? $jml_cuti['jml_cuti'] : 0;
            $report .= $jml_cuti."</td>";
            $report .= "<td></td>";
            $report .= "<td></td>";
            $report .= "</tr>";
            $report .= "<tr>";
            $report .= "<td>7</td>";
            $report .= "<td>Jul</td>";
                $bln = "07";
                $tgl = date('t', mktime(0,0,0,$bln,1,$tahun));
                for ($i=1; $i <= 31; $i++) {
                    $tglRet = $i<=$tgl ? str_pad($i, 2, "0", STR_PAD_LEFT) : "" ;
                    $tglYmd = $i<=$tgl ? $tahun."-".$bln."-".str_pad($i, 2, "0", STR_PAD_LEFT) : "" ;
                    $tglDay = new DateTime($tglYmd);
                    $tglDay = $tglDay->format('D');
                    $warna = "";

                    if (strtotime($tglYmd) < strtotime($now) && $tglRet != "") {
                        $cek    = isset($absen_array[$tglYmd]) == true ? 1 : 0;
                        $izin   = isset($izin_nonabsen[$tglYmd]) == true ? 1 : 0;
                        $cuti   = isset($cuti_array[$tglYmd]) == true ? 1 : 0;
                        $unpaid = isset($unpaid_array[$tglYmd]) == true ? 1 : 0;
                        $libur  = isset($kalender[$tglYmd]) == true ? 1 : 0;
                        if ($cek != 0) { // Jika ada absen
                            $warna  = "";
                        }
                        elseif ($tglDay=='Sat' || $tglDay=='Sun') { // Jika Sabtu / Minggu
                            $warna  = "bgcolor='#cff4f9'";
                        }
                        elseif ($izin == 1) { // Jika Izin tanpa absen
                            $simbol = $izin_nonabsen[$tglYmd]['singkatan'];
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
                            }
                        }
                        elseif ($cuti == 1) { // Jika cuti
                            $warna = "bgcolor='#05bcff'";
                        }
                        elseif ($unpaid == 1) { // Jika Unpaid
                            $warna = "bgcolor='#a3a3a3'";
                        }
                        elseif ($libur == 1) {
                            $warna  = "bgcolor='#cff4f9'";
                        }
                        else{
                            $warna = "bgcolor='#ffb2a8'";
                        }
                    }
                    else {
                        $warna  = "bgcolor='#fff1c6'";
                    }

                    $report .= "<td ".$warna.">".$tglRet."</td>";
                }
            // $report .= "<td>t</td>";
            // $report .= "<td>j</td>";
            $report .= "<td>";
                    $jml_cuti = mysql_query("SELECT
                                                COUNT(no) AS jml_cuti
                                            FROM
                                                daterange_cuti
                                            WHERE
                                                YEAR ( tanggal ) = $tahun
                                                AND MONTH ( tanggal ) = $bln
                                                AND username = '$id_user'
                                                AND persetujuan IN ( 'Disetujui(Direksi)', 'Disetujui(Manager)' )");
                    $jml_cuti = mysql_fetch_assoc($jml_cuti);
                    $jml_cuti = isset($jml_cuti['jml_cuti']) != "" ? $jml_cuti['jml_cuti'] : 0;
            $report .= $jml_cuti."</td>";
            $report .= "<td></td>";
            $report .= "<td></td>";
            $report .= "</tr>";
            $report .= "<tr>";
            $report .= "<td>8</td>";
            $report .= "<td>Ags</td>";
                $bln = "08";
                $tgl = date('t', mktime(0,0,0,$bln,1,$tahun));
                for ($i=1; $i <= 31; $i++) {
                    $tglRet = $i<=$tgl ? str_pad($i, 2, "0", STR_PAD_LEFT) : "" ;
                    $tglYmd = $i<=$tgl ? $tahun."-".$bln."-".str_pad($i, 2, "0", STR_PAD_LEFT) : "" ;
                    $tglDay = new DateTime($tglYmd);
                    $tglDay = $tglDay->format('D');
                    $warna = "";

                    if (strtotime($tglYmd) < strtotime($now) && $tglRet != "") {
                        $cek    = isset($absen_array[$tglYmd]) == true ? 1 : 0;
                        $izin   = isset($izin_nonabsen[$tglYmd]) == true ? 1 : 0;
                        $cuti   = isset($cuti_array[$tglYmd]) == true ? 1 : 0;
                        $unpaid = isset($unpaid_array[$tglYmd]) == true ? 1 : 0;
                        $libur  = isset($kalender[$tglYmd]) == true ? 1 : 0;
                        if ($cek != 0) { // Jika ada absen
                            $warna  = "";
                        }
                        elseif ($tglDay=='Sat' || $tglDay=='Sun') { // Jika Sabtu / Minggu
                            $warna  = "bgcolor='#cff4f9'";
                        }
                        elseif ($izin == 1) { // Jika Izin tanpa absen
                            $simbol = $izin_nonabsen[$tglYmd]['singkatan'];
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
                            }
                        }
                        elseif ($cuti == 1) { // Jika cuti
                            $warna = "bgcolor='#05bcff'";
                        }
                        elseif ($unpaid == 1) { // Jika Unpaid
                            $warna = "bgcolor='#a3a3a3'";
                        }
                        elseif ($libur == 1) {
                            $warna  = "bgcolor='#cff4f9'";
                        }
                        else{
                            $warna = "bgcolor='#ffb2a8'";
                        }
                    }
                    else {
                        $warna  = "bgcolor='#fff1c6'";
                    }

                    $report .= "<td ".$warna.">".$tglRet."</td>";
                }
            // $report .= "<td>t</td>";
            // $report .= "<td>j</td>";
            $report .= "<td>";
                    $jml_cuti = mysql_query("SELECT
                                                COUNT(no) AS jml_cuti
                                            FROM
                                                daterange_cuti
                                            WHERE
                                                YEAR ( tanggal ) = $tahun
                                                AND MONTH ( tanggal ) = $bln
                                                AND username = '$id_user'
                                                AND persetujuan IN ( 'Disetujui(Direksi)', 'Disetujui(Manager)' )");
                    $jml_cuti = mysql_fetch_assoc($jml_cuti);
                    $jml_cuti = isset($jml_cuti['jml_cuti']) != "" ? $jml_cuti['jml_cuti'] : 0;
            $report .= $jml_cuti."</td>";
            $report .= "<td></td>";
            $report .= "<td></td>";
            $report .= "</tr>";
            $report .= "<tr>";
            $report .= "<td>9</td>";
            $report .= "<td>Sep</td>";
                $bln = "09";
                $tgl = date('t', mktime(0,0,0,$bln,1,$tahun));
                for ($i=1; $i <= 31; $i++) {
                    $tglRet = $i<=$tgl ? str_pad($i, 2, "0", STR_PAD_LEFT) : "" ;
                    $tglYmd = $i<=$tgl ? $tahun."-".$bln."-".str_pad($i, 2, "0", STR_PAD_LEFT) : "" ;
                    $tglDay = new DateTime($tglYmd);
                    $tglDay = $tglDay->format('D');
                    $warna = "";

                    if (strtotime($tglYmd) < strtotime($now) && $tglRet != "") {
                        $cek    = isset($absen_array[$tglYmd]) == true ? 1 : 0;
                        $izin   = isset($izin_nonabsen[$tglYmd]) == true ? 1 : 0;
                        $cuti   = isset($cuti_array[$tglYmd]) == true ? 1 : 0;
                        $unpaid = isset($unpaid_array[$tglYmd]) == true ? 1 : 0;
                        $libur  = isset($kalender[$tglYmd]) == true ? 1 : 0;
                        if ($cek != 0) { // Jika ada absen
                            $warna  = "";
                        }
                        elseif ($tglDay=='Sat' || $tglDay=='Sun') { // Jika Sabtu / Minggu
                            $warna  = "bgcolor='#cff4f9'";
                        }
                        elseif ($izin == 1) { // Jika Izin tanpa absen
                            $simbol = $izin_nonabsen[$tglYmd]['singkatan'];
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
                            }
                        }
                        elseif ($cuti == 1) { // Jika cuti
                            $warna = "bgcolor='#05bcff'";
                        }
                        elseif ($unpaid == 1) { // Jika Unpaid
                            $warna = "bgcolor='#a3a3a3'";
                        }
                        elseif ($libur == 1) {
                            $warna  = "bgcolor='#cff4f9'";
                        }
                        else{
                            $warna = "bgcolor='#ffb2a8'";
                        }
                    }
                    else {
                        $warna  = "bgcolor='#fff1c6'";
                    }

                    $report .= "<td ".$warna.">".$tglRet."</td>";
                }
            // $report .= "<td>t</td>";
            // $report .= "<td>j</td>";
            $report .= "<td>";
                    $jml_cuti = mysql_query("SELECT
                                                COUNT(no) AS jml_cuti
                                            FROM
                                                daterange_cuti
                                            WHERE
                                                YEAR ( tanggal ) = $tahun
                                                AND MONTH ( tanggal ) = $bln
                                                AND username = '$id_user'
                                                AND persetujuan IN ( 'Disetujui(Direksi)', 'Disetujui(Manager)' )");
                    $jml_cuti = mysql_fetch_assoc($jml_cuti);
                    $jml_cuti = isset($jml_cuti['jml_cuti']) != "" ? $jml_cuti['jml_cuti'] : 0;
            $report .= $jml_cuti."</td>";
            $report .= "<td></td>";
            $report .= "<td></td>";
            $report .= "</tr>";
            $report .= "<tr>";
            $report .= "<td>10</td>";
            $report .= "<td>Okt</td>";
                $bln = "10";
                $tgl = date('t', mktime(0,0,0,$bln,1,$tahun));
                for ($i=1; $i <= 31; $i++) {
                    $tglRet = $i<=$tgl ? str_pad($i, 2, "0", STR_PAD_LEFT) : "" ;
                    $tglYmd = $i<=$tgl ? $tahun."-".$bln."-".str_pad($i, 2, "0", STR_PAD_LEFT) : "" ;
                    $tglDay = new DateTime($tglYmd);
                    $tglDay = $tglDay->format('D');
                    $warna = "";

                    if (strtotime($tglYmd) < strtotime($now) && $tglRet != "") {
                        $cek    = isset($absen_array[$tglYmd]) == true ? 1 : 0;
                        $izin   = isset($izin_nonabsen[$tglYmd]) == true ? 1 : 0;
                        $cuti   = isset($cuti_array[$tglYmd]) == true ? 1 : 0;
                        $unpaid = isset($unpaid_array[$tglYmd]) == true ? 1 : 0;
                        $libur  = isset($kalender[$tglYmd]) == true ? 1 : 0;
                        if ($cek != 0) { // Jika ada absen
                            $warna  = "";
                        }
                        elseif ($tglDay=='Sat' || $tglDay=='Sun') { // Jika Sabtu / Minggu
                            $warna  = "bgcolor='#cff4f9'";
                        }
                        elseif ($izin == 1) { // Jika Izin tanpa absen
                            $simbol = $izin_nonabsen[$tglYmd]['singkatan'];
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
                            }
                        }
                        elseif ($cuti == 1) { // Jika cuti
                            $warna = "bgcolor='#05bcff'";
                        }
                        elseif ($unpaid == 1) { // Jika Unpaid
                            $warna = "bgcolor='#a3a3a3'";
                        }
                        elseif ($libur == 1) {
                            $warna  = "bgcolor='#cff4f9'";
                        }
                        else{
                            $warna = "bgcolor='#ffb2a8'";
                        }
                    }
                    else {
                        $warna  = "bgcolor='#fff1c6'";
                    }

                    $report .= "<td ".$warna.">".$tglRet."</td>";
                }
            // $report .= "<td>t</td>";
            // $report .= "<td>j</td>";
            $report .= "<td>";
                    $jml_cuti = mysql_query("SELECT
                                                COUNT(no) AS jml_cuti
                                            FROM
                                                daterange_cuti
                                            WHERE
                                                YEAR ( tanggal ) = $tahun
                                                AND MONTH ( tanggal ) = $bln
                                                AND username = '$id_user'
                                                AND persetujuan IN ( 'Disetujui(Direksi)', 'Disetujui(Manager)' )");
                    $jml_cuti = mysql_fetch_assoc($jml_cuti);
                    $jml_cuti = isset($jml_cuti['jml_cuti']) != "" ? $jml_cuti['jml_cuti'] : 0;
            $report .= $jml_cuti."</td>";
            $report .= "<td></td>";
            $report .= "<td></td>";
            $report .= "</tr>";
            $report .= "<tr>";
            $report .= "<td>11</td>";
            $report .= "<td>Nov</td>";
                $bln = "11";
                $tgl = date('t', mktime(0,0,0,$bln,1,$tahun));
                for ($i=1; $i <= 31; $i++) {
                    $tglRet = $i<=$tgl ? str_pad($i, 2, "0", STR_PAD_LEFT) : "" ;
                    $tglYmd = $i<=$tgl ? $tahun."-".$bln."-".str_pad($i, 2, "0", STR_PAD_LEFT) : "" ;
                    $tglDay = new DateTime($tglYmd);
                    $tglDay = $tglDay->format('D');
                    $warna = "";

                    if (strtotime($tglYmd) < strtotime($now) && $tglRet != "") {
                        $cek    = isset($absen_array[$tglYmd]) == true ? 1 : 0;
                        $izin   = isset($izin_nonabsen[$tglYmd]) == true ? 1 : 0;
                        $cuti   = isset($cuti_array[$tglYmd]) == true ? 1 : 0;
                        $unpaid = isset($unpaid_array[$tglYmd]) == true ? 1 : 0;
                        $libur  = isset($kalender[$tglYmd]) == true ? 1 : 0;
                        if ($cek != 0) { // Jika ada absen
                            $warna  = "";
                        }
                        elseif ($tglDay=='Sat' || $tglDay=='Sun') { // Jika Sabtu / Minggu
                            $warna  = "bgcolor='#cff4f9'";
                        }
                        elseif ($izin == 1) { // Jika Izin tanpa absen
                            $simbol = $izin_nonabsen[$tglYmd]['singkatan'];
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
                            }
                        }
                        elseif ($cuti == 1) { // Jika cuti
                            $warna = "bgcolor='#05bcff'";
                        }
                        elseif ($unpaid == 1) { // Jika Unpaid
                            $warna = "bgcolor='#a3a3a3'";
                        }
                        elseif ($libur == 1) {
                            $warna  = "bgcolor='#cff4f9'";
                        }
                        else{
                            $warna = "bgcolor='#ffb2a8'";
                        }
                    }
                    else {
                        $warna  = "bgcolor='#fff1c6'";
                    }

                    $report .= "<td ".$warna.">".$tglRet."</td>";
                }
            // $report .= "<td>t</td>";
            // $report .= "<td>j</td>";
            $report .= "<td>";
                    $jml_cuti = mysql_query("SELECT
                                                COUNT(no) AS jml_cuti
                                            FROM
                                                daterange_cuti
                                            WHERE
                                                YEAR ( tanggal ) = $tahun
                                                AND MONTH ( tanggal ) = $bln
                                                AND username = '$id_user'
                                                AND persetujuan IN ( 'Disetujui(Direksi)', 'Disetujui(Manager)' )");
                    $jml_cuti = mysql_fetch_assoc($jml_cuti);
                    $jml_cuti = isset($jml_cuti['jml_cuti']) != "" ? $jml_cuti['jml_cuti'] : 0;
            $report .= $jml_cuti."</td>";
            $report .= "<td></td>";
            $report .= "<td></td>";
            $report .= "</tr>";
            $report .= "<tr>";
            $report .= "<td>12</td>";
            $report .= "<td>Des</td>";
                $bln = "12";
                $tgl = date('t', mktime(0,0,0,$bln,1,$tahun));
                for ($i=1; $i <= 31; $i++) {
                    $tglRet = $i<=$tgl ? str_pad($i, 2, "0", STR_PAD_LEFT) : "" ;
                    $tglYmd = $i<=$tgl ? $tahun."-".$bln."-".str_pad($i, 2, "0", STR_PAD_LEFT) : "" ;
                    $tglDay = new DateTime($tglYmd);
                    $tglDay = $tglDay->format('D');
                    $warna = "";

                    if (strtotime($tglYmd) < strtotime($now) && $tglRet != "") {
                        $cek    = isset($absen_array[$tglYmd]) == true ? 1 : 0;
                        $izin   = isset($izin_nonabsen[$tglYmd]) == true ? 1 : 0;
                        $cuti   = isset($cuti_array[$tglYmd]) == true ? 1 : 0;
                        $unpaid = isset($unpaid_array[$tglYmd]) == true ? 1 : 0;
                        $libur  = isset($kalender[$tglYmd]) == true ? 1 : 0;
                        if ($cek != 0) { // Jika ada absen
                            $warna  = "";
                        }
                        elseif ($tglDay=='Sat' || $tglDay=='Sun') { // Jika Sabtu / Minggu
                            $warna  = "bgcolor='#cff4f9'";
                        }
                        elseif ($izin == 1) { // Jika Izin tanpa absen
                            $simbol = $izin_nonabsen[$tglYmd]['singkatan'];
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
                            }
                        }
                        elseif ($cuti == 1) { // Jika cuti
                            $warna = "bgcolor='#05bcff'";
                        }
                        elseif ($unpaid == 1) { // Jika Unpaid
                            $warna = "bgcolor='#a3a3a3'";
                        }
                        elseif ($libur == 1) {
                            $warna  = "bgcolor='#cff4f9'";
                        }
                        else{
                            $warna = "bgcolor='#ffb2a8'";
                        }
                    }
                    else {
                        $warna  = "bgcolor='#fff1c6'";
                    }

                    $report .= "<td ".$warna.">".$tglRet."</td>";
                }
            // $report .= "<td>t</td>";
            // $report .= "<td>j</td>";
            $report .= "<td>";
                    $jml_cuti = mysql_query("SELECT
                                                COUNT(no) AS jml_cuti
                                            FROM
                                                daterange_cuti
                                            WHERE
                                                YEAR ( tanggal ) = $tahun
                                                AND MONTH ( tanggal ) = $bln
                                                AND username = '$id_user'
                                                AND persetujuan IN ( 'Disetujui(Direksi)', 'Disetujui(Manager)' )");
                    $jml_cuti = mysql_fetch_assoc($jml_cuti);
                    $jml_cuti = isset($jml_cuti['jml_cuti']) != "" ? $jml_cuti['jml_cuti'] : 0;
            $report .= $jml_cuti."</td>";
            $report .= "<td></td>";
            $report .= "<td></td>";
            $report .= "</tr>";
            $report .= "</tbody>";
            $report .= "</table>";

            echo ($report);
            break;

        default:

            break;
    }


?>
