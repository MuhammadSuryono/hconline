<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<style>
@media print {
  body * {
    visibility: hidden;
  }
  #section-to-print, #section-to-print * {
    visibility: visible;
  }
  #section-to-print {
    position: absolute;
    left: 0;
    top: 0;
  }
}
</style>

<?php

    // Optional Weekly

    $plus = 0;
    for ($i=date("N"); $i < 6; $i++) {
        $plus++;
    }
    $week2 = date('Y-m-d', strtotime("+".$plus." day"));
    $minggu2 = date('d M Y', strtotime("+".$plus." day"));
    $w1 = new DateTime($week2);
    $w1->modify('-6 day');
    $week1 = $w1->format('Y-m-d');
    $minggu1 = $w1->format('d M Y');

    $text_weekly = "Weekly (".$minggu1." s/d ".$minggu2.")";
    // End

    // Optional Cut Off
    if (date("j") <= 30) {
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
    // End

    $range_default  = isset($_POST['range_default']) != "" ? $_POST['range_default'] : "weekly";
    $range_custom   = isset($_POST['range_custom']) != "" ? $_POST['range_custom'] : "";
    if ($range_default == 'weekly') {
        $tgl_1 = $week1;
        $tgl_2 = $week2;
    }
    elseif ($range_default == 'cutoff') {
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
                $lvl = isset($_SESSION['hak_akses']) != "" ? $_SESSION['hak_akses'] : "" ;
                if ($lvl == 'HRD') {
                    $link = "home-hrd.php";
                }
                else if($lvl == 'Manager'){
                    $link = "home-manager.php";
                }
                else if($lvl == 'Pegawai'){
                    $link = "home-pegawai.php";
                }
                else if($lvl == 'Pegawai2'){
                    $link = "home-pegawai2.php";
                }
                else {
                    $link = "home-admin.php";
                }
            ?>
            <form action="<?php echo $link; ?>?page=attendance-baru-user" method="post">
                <div class="col-md-4">
                    <div class="input-prepend input-group">
                        <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                        <select class="form-control" name="range_default" onchange="dateRange(this.value)">
                            <option value='weekly' <?php if ($range_default=='weekly') { echo "selected"; } ?>><?php echo $text_weekly; ?></option>
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

<div id="printableArea">
<div id="percobaan" class="table-responsive">

</div>
</div>

<input type="button" onclick="printDiv('printableArea')" value="print a div!" />

<br/><br/>


<h2>Daftar Cuti User</h2>
<div class="table-responsive">
  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>No. </th>
        <th>Nama</th>
        <th>Divisi</th>
        <th>Cuti Tahunan</th>
        <th>Cuti Tahun Lalu</th>
        <th>Cuti Dispensasi</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $div = $_SESSION['divisi'];
      $i= 1;
      $carisaldo = mysql_query("SELECT * FROM tb_pegawai WHERE divisi='$div' ORDER BY nama ASC");
      while ($cs = mysql_fetch_array($carisaldo)){
      ?>
      <tr>
        <td><?php echo $i++; ?></td>
        <td><?php echo $cs['nama']; ?></td>
        <td><?php echo $cs['divisi']; ?></td>
        <td><?php echo $cs['hak_cuti_tahunan']; ?></td>
        <td><?php echo $cs['hak_cuti_tahunlalu']; ?></td>
        <td><?php echo $cs['hak_cuti_dispensasi']; ?></td>
      </tr>
      <?php
      }
      ?>
      </tr>
    </tbody>
  </table>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Modal Header</h4>
            </div>
            <div class="modal-body">
                <p>Some text in the modal.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>

    function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
    }

    function dateRange(pilihan) {
        var x = document.getElementById("custom");
        if (pilihan == 'cutoff') {
            x.style.display = "none";
        }
        else if(pilihan == 'weekly'){
            x.style.display = "none";
        }
        else{
            x.style.display = "block";
        }
    }

    $('input[name="range_custom"]').daterangepicker({
        timePicker: false,
        locale: {
            format: 'DD/MM/Y'
        }
    });

    // function showform(table_nama, inisial_id, tanggal, gambar) {
    //     // alert(table_nama + " - " + inisial_id + " - " + tanggal + " - " + gambar);
    //     $("#myModal").modal();
    // }

    $( document ).ready(function() {
        var tgl_1 = "<?php echo $tgl_1; ?>";
        var tgl_2 = "<?php echo $tgl_2; ?>";
        $.ajax({
            url: "pages/transaksi/attendance-process-new-user.php",
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
