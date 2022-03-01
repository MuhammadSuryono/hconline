<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<?php
    $range_default  = isset($_POST['range_default']) != "" ? $_POST['range_default'] : "cutoff";
    $range_custom   = isset($_POST['range_custom']) != "" ? $_POST['range_custom'] : "";

    if (date("j") <= 20) {
        if (date("n") == 1) {
            $bulan1 = date("d M Y", mktime(0,0,0,12,21,date("Y")-1));
            $bulan2 = date("d M Y", mktime(0,0,0,1,20,date("Y")));
        }else {
            $bulan1 = date("d M Y", mktime(0,0,0,date("n")-1,21,date("Y")));
            $bulan2 = date("d M Y", mktime(0,0,0,date("n"),20,date("Y")));
        }
    }else {
        if (date("n") == 12) {
            $bulan1 = date("d M Y", mktime(0,0,0,date("n"),21,date("Y")));
            $bulan2 = date("d M Y", mktime(0,0,0,1,20,date("Y")+1));
        }else {
            $bulan1 = date("d M Y", mktime(0,0,0,date("n"),21,date("Y")));
            $bulan2 = date("d M Y", mktime(0,0,0,date("n")+1,20,date("Y")));
        }
    }
    $text_default = "Cut Off (".$bulan1." s/d ".$bulan2.")";

    if ($range_default == 'cutoff') {
        $tgl_awal   = "21";
        $tgl_akhir  = "20";

        if (date("j") <= 20) {
            $bln_awal   = (date("n")) == 1 ? 12 : date("n")-1;
            $bln_akhir  = date("n");

            $thn_awal   = (date("n")) == 1 ? date("Y")-1 : date("Y");
            $thn_akhir  = date("Y");
        }else{
            $bln_awal   = date("n");
            $bln_akhir  = (date("n")) == 12 ? 1 : date("n")+1;

            $thn_awal   = date("Y");
            $thn_akhir  = (date("n")) == 12 ? date("Y")+1 : date("Y");
        }
    }
    elseif ($range_default == 'custom') {
        $range  = explode(" - ", $range_custom);
        $awal   = reformatDate($range[0]);
        $akhir  = reformatDate($range[1]);

        $tgl_awal   = date("j", strtotime($awal));
        $tgl_akhir  = date("j", strtotime($akhir));

        $bln_awal   = date("n", strtotime($awal));
        $bln_akhir  = date("n", strtotime($akhir));

        $thn_awal   = date("Y", strtotime($awal));
        $thn_akhir  = date("Y", strtotime($akhir));
    }

    function reformatDate($date, $from_format = 'd/m/Y', $to_format = 'Y-m-d') {
        $date_aux = date_create_from_format($from_format, $date);
        return date_format($date_aux,$to_format);
    }

    // echo $tgl_awal."</br>";
    // echo $tgl_akhir."</br>";
    // echo $bln_awal."</br>";
    // echo $bln_akhir."</br>";
    // echo $thn_awal."</br>";
    // echo $thn_akhir."</br>";


    $tgl        = "1";
    $bln        = isset($_GET['bulan']) ? $_GET['bulan'] : date("m");
    $thn        = isset($_GET['tahun']) ? $_GET['tahun'] : date("Y");
?>

<div class="x_panel" style="">
    <div class="x_content">
        <div class="well" style="overflow: auto">
            <form action="home-hrd.php?page=attendance-baru" method="post">
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

    $( document ).ready(function() {
        var tanggal = "<?php echo $tgl; ?>";
        var bulan = "<?php echo $bln; ?>";
        var tahun = "<?php echo $thn; ?>";

        var tgl_awal = "<?php echo $tgl_awal; ?>";
        var tgl_akhir = "<?php echo $tgl_akhir; ?>";
        var bln_awal = "<?php echo $bln_awal; ?>";
        var bln_akhir = "<?php echo $bln_akhir; ?>";
        var thn_awal = "<?php echo $thn_awal; ?>";
        var thn_akhir = "<?php echo $thn_akhir; ?>";
        $.ajax({
            url: "pages/transaksi/attendance_process_new.php",
            dataType: 'json',
            method: 'post',
            data: {
                action: "tampilkan_absen",
                tanggal: tanggal,
                bulan: bulan,
                tahun: tahun,

                tgl_awal: tgl_awal,
                tgl_akhir: tgl_akhir,
                bln_awal: bln_awal,
                bln_akhir: bln_akhir,
                thn_awal: thn_awal,
                thn_akhir: thn_akhir
            }
        })
        .done(function(data){
            console.log(data);
            $("#percobaan").html(data);
        });

        dateRange("<?php echo $range_default; ?>");
    });
    
</script>


<?php

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

<div id="percobaan" class="table-responsive">

</div>


