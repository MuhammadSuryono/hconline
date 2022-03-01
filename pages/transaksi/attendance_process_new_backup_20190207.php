<?php

    require_once("../../dist/koneksi.php");
    session_start();

    $R      = $_REQUEST;

    $action = isset($R['action']) != '' ? $R['action'] : '';

    switch ($action) {

        case 'tampilkan_absen':

            $awal       = $R['tgl_1'];
            $akhir      = $R['tgl_2'];
            
            $x          = new DateTime($awal);
            $y          = new DateTime($akhir);
            $jml_hari   = $x->diff($y);
            $jml_hari   = intval($jml_hari->days) + 1;

            $tgl        = intval($x->format('d'));
            $bln        = intval($x->format('n'));
            $thn        = intval($x->format('Y'));

            // BEGIN ARRAY FROM TABLE CHECKINOUT
            $absen_query = mysql_query("SELECT
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
                                            DAY ( tgl_dan_jam )");
            $absen_array = array();
            while ($row = mysql_fetch_array($absen_query)) {
                $absen_array[$row['user_id'].$row['tanggal']] = $row;
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
                        $cek        = isset($absen_array[$row['user_id'].$ymd]) == true ? 1 : 0;
                        if ($hari=='Sat' || $hari=='Sun') {
                            if ($cek == 0) {
                                $warna  = "bgcolor='#e8f5ff'";
                            }
                        }elseif ($cek == 0) {
                            $warna  = "bgcolor='#ffdddd'";
                            $simbol = "x";
                        }

                        $key = $row['user_id'].$ymd;
                        $absen .= "<td ".$warna."><center>".$simbol."</center></td>";
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