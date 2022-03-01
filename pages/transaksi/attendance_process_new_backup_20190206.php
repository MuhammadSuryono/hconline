<?php

    require_once("../../dist/koneksi.php");
    session_start();

    $R      = $_REQUEST;

    $action = isset($R['action']) != '' ? $R['action'] : '';

    switch ($action) {
        case 'tampilkan_absen':

            $tgl_awal = $R['tgl_awal'];
            $tgl_akhir = $R['tgl_akhir'];
            $bln_awal = $R['bln_awal'];
            $bln_akhir = $R['bln_akhir'];
            $thn_awal = $R['thn_awal'];
            $thn_akhir = $R['thn_akhir'];

            $jml_hari_awal  = date("t", mktime(0,0,0,$bln_awal,$tgl_awal,$thn_awal));
            $jml_hari_akhir = date("t", mktime(0,0,0,$bln_akhir,$tgl_akhir,$thn_akhir));

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
                                            YEAR ( tgl_dan_jam ) BETWEEN '$thn_awal' AND '$thn_akhir'
	                                        AND MONTH ( tgl_dan_jam ) BETWEEN '$bln_awal' AND '$bln_akhir'
                                        GROUP BY
                                            user_id,
                                            DAY ( tgl_dan_jam )");
            $absen_array = array();
            while ($row = mysql_fetch_array($absen_query)) {
                $absen_array[$row['user_id'].$row['tanggal']] = $row;
            }
            // END
            
            $absen = "<table class='blueTable table-striped'>";
            $absen .= "<thead>";
            $absen .= "<tr>";
            $absen .= "<th rowspan='3' width='60px'>No</th>";
            $absen .= "<th rowspan='3'>Nama Karyawan</th>";
            // ============================================================================================================================
                // Cari cara untuk looping day of the month betwean date
                $tahun_awal     = date('F Y', mktime(0,0,0,$bln_awal,$tgl_awal,$thn_awal));
                $colspan_awal   = date('t', mktime(0,0,0,$bln_awal,1,$thn_awal))-$tgl_awal+1;
                $absen .= "<th colspan='".$colspan_awal."'>".$tahun_awal."</th>";

                $tahun_akhir = date('F Y', mktime(0,0,0,$bln_akhir,$tgl_akhir,$thn_akhir));
                $colspan_akhir = date('t', mktime(0,0,0,$bln_akhir,1,$thn_akhir))-$tgl_akhir;
                $colspan_akhir = date('t', mktime(0,0,0,$bln_akhir,1,$thn_akhir))-$colspan_akhir;
            $absen .= "<th colspan='".$colspan_akhir."'>".$tahun_akhir."</th>";
            $absen .= "</tr>";
            $absen .= "<tr>";
                for ($i=$tgl_awal; $i <= $jml_hari_awal; $i++) { 
                    $hari = date('D', mktime(0,0,0,$bln_awal,$i,$thn_awal));
                    $warna = "";
                    if ($hari=='Sat' || $hari=='Sun') {
                        $warna = "bgcolor='#630404'";
                    }
                    $absen .= "<th width='50px' ".$warna.">".$i."</th>";
                }
                for ($i=1; $i <= $tgl_akhir; $i++) { 
                    $hari = date('D', mktime(0,0,0,$bln_akhir,$i,$thn_akhir));
                    $warna = "";
                    if ($hari=='Sat' || $hari=='Sun') {
                        $warna = "bgcolor='#630404'";
                    }
                    $absen .= "<th width='50px' ".$warna.">".$i."</th>";
                }
            $absen .= "</tr>";
            $absen .= "<tr>";
                for ($i=$tgl_awal; $i <= $jml_hari_awal; $i++) { 
                    $hari = date('D', mktime(0,0,0,$bln_awal,$i,$thn_awal));
                    $warna = "";
                    if ($hari=='Sat' || $hari=='Sun') {
                        $warna = "bgcolor='#630404'";
                    }
                    $absen .= "<th ".$warna.">".$hari."</th>";
                }
                for ($i=1; $i <= $tgl_akhir; $i++) { 
                    $hari = date('D', mktime(0,0,0,$bln_akhir,$i,$thn_akhir));
                    $warna = "";
                    if ($hari=='Sat' || $hari=='Sun') {
                        $warna = "bgcolor='#630404'";
                    }
                    $absen .= "<th ".$warna.">".$hari."</th>";
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
                                                iduser != '' 
                                            ORDER BY
                                                nama_user ASC");
                $no = 1;
                while ($row = mysql_fetch_array($user_query)) {
                    $absen .= "<tr>";
                    $absen .= "<td>".$no++."</td>";
                    $absen .= "<td align='left'>".$row['user_nama']."</td>";
                    for ($i=$tgl_awal; $i <= $jml_hari_awal; $i++) { 
                        $tanggal    = date("Y-m-d", mktime(0,0,0,$bln_awal,$i,$thn_awal));
                        $hari       = date('D', mktime(0,0,0,$bln_awal,$i,$thn_awal));
                        $simbol     = "";
                        $warna      = "";
                        $cek        = isset($absen_array[$row['user_id'].$tanggal]) == true ? 1 : 0;
                        if ($hari=='Sat' || $hari=='Sun') {
                            if ($cek == 0) {
                                $warna  = "bgcolor='#fffb3f'";
                            }
                        }elseif ($cek == 0) {
                            $warna  = "bgcolor='#ffdddd'";
                            $simbol = "x";
                        }
                        $absen .= "<td ".$warna."><center>".$simbol."</center></td>";
                    }
                    for ($i=1; $i <= $tgl_akhir; $i++) { 
                        $tanggal    = date("Y-m-d", mktime(0,0,0,$bln_akhir,$i,$thn_akhir));
                        $hari       = date('D', mktime(0,0,0,$bln_akhir,$i,$thn_akhir));
                        $simbol     = "";
                        $warna      = "";
                        $cek        = isset($absen_array[$row['user_id'].$tanggal]) == true ? 1 : 0;
                        if ($hari=='Sat' || $hari=='Sun') {
                            if ($cek == 0) {
                                $warna  = "bgcolor='#fffb3f'";
                            }
                        }elseif ($cek == 0) {
                            $warna  = "bgcolor='#ffdddd'";
                            $simbol = "x";
                        }
                        $absen .= "<td ".$warna."><center>".$simbol."</center></td>";
                    }
                    $absen .= "</tr>";
                }
                $absen .= "</tbody>";
                $absen .= "</table>";
            echo json_encode($absen);
            break;

            // case 'tampilkan_absen':

            // $tgl = $R['tanggal'];
            // $bln = $R['bulan'];
            // $thn = $R['tahun'];

            // $jml_hari   = date("t", mktime(0,0,0,$bln,$tgl,$thn));

            // // BEGIN ARRAY FROM TABLE CHECKINOUT
            // $absen_query = mysql_query("SELECT
            //                                 user_id,
            //                                 DATE( tgl_dan_jam ) AS tanggal,
            //                                 min( tgl_dan_jam ) AS absen_masuk,
            //                             IF
            //                                 ( max( tgl_dan_jam ) = MIN( tgl_dan_jam ), NULL, max( tgl_dan_jam ) ) AS absen_pulang 
            //                             FROM
            //                                 absensi 
            //                             WHERE
            //                                 YEAR ( tgl_dan_jam ) = '$thn' 
            //                                 AND MONTH ( tgl_dan_jam ) = '$bln' 
            //                             GROUP BY
            //                                 user_id,
            //                                 DAY ( tgl_dan_jam )");
            // $absen_array = array();
            // while ($row = mysql_fetch_array($absen_query)) {
            //     $absen_array[$row['user_id'].$row['tanggal']] = $row;
            // }
            // // END
            
            // $absen = "<table class='blueTable table-striped'>";
            // $absen .= "<thead>";
            // $absen .= "<tr>";
            // $absen .= "<th rowspan='3' width='60px'>No</th>";
            // $absen .= "<th rowspan='3'>Nama Karyawan</th>";
            //     $tahun = date('F Y', mktime(0,0,0,$bln,1,$thn));
            // $absen .= "<th width='50px' colspan='31'>".$tahun."</th>";
            // $absen .= "</tr>";
            // $absen .= "<tr>";
            //     for ($i=1; $i <= $jml_hari; $i++) { 
            //         $hari = date('D', mktime(0,0,0,$bln,$i,$thn));
            //         $warna = "";
            //         if ($hari=='Sat' || $hari=='Sun') {
            //             $warna = "bgcolor='#630404'";
            //         }
            //         $absen .= "<th width='50px' ".$warna.">".$i."</th>";
            //     }
            // $absen .= "</tr>";
            // $absen .= "<tr>";
            //     for ($i=1; $i <= $jml_hari; $i++) { 
            //         $hari = date('D', mktime(0,0,0,$bln,$i,$thn));
            //         $warna = "";
            //         if ($hari=='Sat' || $hari=='Sun') {
            //             $warna = "bgcolor='#630404'";
            //         }
            //         $absen .= "<th ".$warna.">".$hari."</th>";
            //     }
            // $absen .= "</tr>";
            // $absen .= "</thead>";
            // $absen .= "<tbody>";
            //     $user_query = mysql_query("SELECT
            //                                     id_absen AS user_id,
            //                                     nama_user AS user_nama,
            //                                     id_user AS inisial_id 
            //                                 FROM
            //                                     tb_user 
            //                                 WHERE
            //                                     iduser != '' 
            //                                 ORDER BY
            //                                     nama_user ASC");
            //     $no = 1;
            //     while ($row = mysql_fetch_array($user_query)) {
            //         $absen .= "<tr>";
            //         $absen .= "<td>".$no++."</td>";
            //         $absen .= "<td align='left'>".$row['user_nama']."</td>";
            //         for ($i=1; $i <= $jml_hari; $i++) { 
            //             $tanggal    = date("Y-m-d", mktime(0,0,0,$bln,$i,$thn));
            //             $hari       = date('D', mktime(0,0,0,$bln,$i,$thn));
            //             $simbol     = "";
            //             $warna      = "";
            //             $cek        = isset($absen_array[$row['user_id'].$tanggal]) == true ? 1 : 0;
            //             if ($hari=='Sat' || $hari=='Sun') {
            //                 if ($cek == 0) {
            //                     $warna  = "bgcolor='#fffb3f'";
            //                 }
            //             }elseif ($cek == 0) {
            //                 $warna  = "bgcolor='#ffdddd'";
            //                 $simbol = "x";
            //             }
            //             $absen .= "<td ".$warna."><center>".$simbol."</center></td>";
            //         }
            //         $absen .= "</tr>";
            //     }
            //     $absen .= "</tbody>";
            //     $absen .= "</table>";
            // echo json_encode($absen);
            // break;

        default:
            // header("Location: ../index.php");
            break;
    }


?>