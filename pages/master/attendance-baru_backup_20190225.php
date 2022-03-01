<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<?php

    if (date("j") <= 20) {
        if (date("n") == 1) {
            $bulan1 = date("d M Y", mktime(0,0,0,12,21,date("Y")-1));
            $bulan2 = date("d M Y", mktime(0,0,0,1,20,date("Y")));

            $satu   = date("Y-m-d", mktime(0,0,0,12,21,date("Y")-1));
            $dua    = date("Y-m-d", mktime(0,0,0,1,20,date("Y")));
        }else {
            $bulan1 = date("d M Y", mktime(0,0,0,date("n")-1,21,date("Y")));
            $bulan2 = date("d M Y", mktime(0,0,0,date("n"),20,date("Y")));

            $satu   = date("Y-m-d", mktime(0,0,0,date("n")-1,21,date("Y")));
            $dua    = date("Y-m-d", mktime(0,0,0,date("n"),20,date("Y")));
        }
    }else {
        if (date("n") == 12) {
            $bulan1 = date("d M Y", mktime(0,0,0,date("n"),21,date("Y")));
            $bulan2 = date("d M Y", mktime(0,0,0,1,20,date("Y")+1));

            $satu   = date("Y-m-d", mktime(0,0,0,date("n"),21,date("Y")));
            $dua    = date("Y-m-d", mktime(0,0,0,1,20,date("Y")+1));
        }else {
            $bulan1 = date("d M Y", mktime(0,0,0,date("n"),21,date("Y")));
            $bulan2 = date("d M Y", mktime(0,0,0,date("n")+1,20,date("Y")));

            $satu   = date("Y-m-d", mktime(0,0,0,date("n"),21,date("Y")));
            $dua    = date("Y-m-d", mktime(0,0,0,date("n")+1,20,date("Y")));
        }
    }
    $text_default = "Cut Off (".$bulan1." s/d ".$bulan2.")";

    $range_default  = isset($_POST['range_default']) != "" ? $_POST['range_default'] : "cutoff";
    $range_custom   = isset($_POST['range_custom']) != "" ? $_POST['range_custom'] : "";
    if ($range_default == 'cutoff') {
        $tgl_1 = $satu;
        $tgl_2 = $dua;
    }
    elseif ($range_default == 'custom') {
        $range  = explode(" - ", $range_custom);
        $tgl_1  = reformatDate($range[0]);
        $tgl_2  = reformatDate($range[1]);
    }

    function reformatDate($date, $from_format = 'd/m/Y', $to_format = 'Y-m-d') {
        $date_aux = date_create_from_format($from_format, $date);
        return date_format($date_aux,$to_format);
    }
?>

<div class="x_panel" style="">
    <div class="x_content">
        <div class="well" style="overflow: auto">
		<?php
          if ($_SESSION['hak_akses'] == 'HRD'){
            $homepage = "home-hrd.php";
            //}else{
            //$homepage = "home-pegawai2.php";
          }
          ?>			
            <form action="<?php echo $homepage; ?>?page=attendance-baru" method="post">
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

<div id="percobaan" class="table-responsive">

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
        var tgl_1 = "<?php echo $tgl_1; ?>";
        var tgl_2 = "<?php echo $tgl_2; ?>";
        $.ajax({
            url: "pages/transaksi/attendance_process_new.php",
            dataType: 'json',
            method: 'post',
            data: {
                action: "tampilkan_absen",
                tgl_1: tgl_1,
                tgl_2: tgl_2
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
    // END

?>


