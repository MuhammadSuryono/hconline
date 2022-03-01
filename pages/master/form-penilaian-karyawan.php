<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<?php
		error_reporting(0);
		$userbray = $_POST['username'];


    $range_custom   = isset($_POST['range_custom']) != "" ? $_POST['range_custom'] : "";
    $range  = explode(" - ", $range_custom);
    $tgl_1  = reformatDate($range[0]);
    $tgl_2  = reformatDate($range[1]);

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
                }else {
                    $link = "home-admin.php";
                }
            ?>
						<form action="<?php echo $link; ?>?page=form-penilaian-karyawan" method="post">
							<div class="col-md-4">
									<div class="input-prepend input-group">
											<span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-user"></i></span>
											<select class="form-control" name="username">
													<option value="">Pilih Nama</option>
													<?php
													include "dist/koneksi.php";
													$usernya = mysql_query("SELECT * FROM tb_user WHERE aktif='Y' AND hak_akses !='HRD' ORDER BY nama_user");
													while ($us = mysql_fetch_array($usernya)){
													?>
													<option value="<?php echo $us['id_absen']; ?>"><?php echo $us['nama_user']; ?></option>
													<?php
													}
													?>
											</select>
									</div>
							</div>
                <div class="col-md-4">
                    <div class="input-prepend input-group">
                        <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                        <input type="text" name="range_custom" value="" class="form-control pull-right">
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



<div id="lemburmalam" class="table-responsive">

</div>


<script>

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
				var user 	= "<?php echo $userbray; ?>";
        $.ajax({
            url: "pages/transaksi/proses-penilaian-karyawan.php",
            dataType: 'html',
            method: 'post',
            data: {
                tgl_1: tgl_1,
                tgl_2: tgl_2,
								user: user
            }
        })
        .done(function(data){
            console.log(data);
            $("#lemburmalam").html(data);
        });

        dateRange("<?php echo $range_default; ?>");
    });
</script>
