<div class="x_panel" style="">
    <div class="x_content">
        <div class="well" style="overflow: auto">
            <div class="col-md-5">
                <div class="input-prepend input-group">
                    <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                    <select class="form-control" style="width: 350px" onchange="dateRange(this.value)">
                        <option value='cutoff'>Cut Off (21 Januari s/d 20 Februari 2019)</option>
                        <option value='custom'>Custom</option>
                    </select>
                </div>
            </div>
            <div id="custom" style="display:none;">
                <div class="col-md-4">
                    <div class="input-prepend input-group">
                        <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                        <input type="text" class="form-control datepicker">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="input-prepend input-group">
                        <button type="button" class="form-control btn btn-info"><i class="glyphicon glyphicon-eye fa fa-eye"></i> Tampilkan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
    $tgl        = "1";
    $bln        = isset($_GET['bulan']) ? $_GET['bulan'] : date("m");
    $thn        = isset($_GET['tahun']) ? $_GET['tahun'] : date("Y");

    $jml_hari   = date("t", mktime(0,0,0,$bln,$tgl,$thn));

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
                                    YEAR ( tgl_dan_jam ) = '$thn' 
                                    AND MONTH ( tgl_dan_jam ) = '$bln' 
                                GROUP BY
                                    user_id,
                                    DAY ( tgl_dan_jam )");
    $absen_array = array();
    while ($row = mysql_fetch_array($absen_query)) {
        $absen_array[$row['user_id'].$row['tanggal']] = $row;
    }
    // END

?>
<div class="table-responsive">
    <table class="blueTable table-striped">
        <thead>
            <tr>
                <th rowspan="3" width="60px">No</th>
                <th rowspan="3">Nama Karyawan</th>
                <?php
                
                    $tahun = date('F Y', mktime(0,0,0,$bln,1,$thn));
                    echo "<th width='50px' colspan='31'>".$tahun."</th>";
                
                ?>
            </tr>
            <tr>
                <?php
                for ($i=1; $i <= $jml_hari; $i++) { 
                    $hari = date('D', mktime(0,0,0,$bln,$i,$thn));
                    $warna = "";
                    if ($hari=='Sat' || $hari=='Sun') {
                        $warna = "bgcolor='#630404'";
                    }
                    echo "<th width='50px' ".$warna.">".$i."</th>";
                }
                ?>
            </tr>
            <tr>
                <?php
                for ($i=1; $i <= $jml_hari; $i++) { 
                    $hari = date('D', mktime(0,0,0,$bln,$i,$thn));
                    $warna = "";
                    if ($hari=='Sat' || $hari=='Sun') {
                        $warna = "bgcolor='#630404'";
                    }
                    echo "<th ".$warna.">".$hari."</th>";
                }
                ?>
            </tr>
        </thead>
        <tbody>
            <?php
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
                echo "<tr>";
                echo "<td>".$no++."</td>";
                echo "<td align='left'>".$row['user_nama']."</td>";
                for ($i=1; $i <= $jml_hari; $i++) { 
                    $tanggal    = date("Y-m-d", mktime(0,0,0,$bln,$i,$thn));
                    $hari       = date('D', mktime(0,0,0,$bln,$i,$thn));
                    $simbol     = "";
                    $warna      = "";
                    $absen      = isset($absen_array[$row['user_id'].$tanggal]) == true ? 1 : 0;
                    if ($hari=='Sat' || $hari=='Sun') {
                        if ($absen == 0) {
                            $warna  = "bgcolor='#fffb3f'";
                        }
                    }elseif ($absen == 0) {
                        $warna  = "bgcolor='#ffdddd'";
                        $simbol = "x";
                    }
                    echo "<td ".$warna."><center>".$simbol."</center></td>";
                }
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
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
</script>
