<section class="content-header">
    <h1>Data<small>Cuti & Cuti Bersama</small></h1>
    <ol class="breadcrumb">
        <li><a href="home-hrd.php"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="active">Data Cuti & Cuti Bersama</li>
    </ol>
</section>
<?php
	include "dist/koneksi.php";
		//fungsi kode otomatis
		function kdauto($tabel, $inisial){
		$struktur   = mysql_query("SELECT * FROM $tabel");
		$field      = mysql_field_name($struktur,0);
		$panjang    = mysql_field_len($struktur,0);
		$qry  = mysql_query("SELECT max(".$field.") FROM ".$tabel);
		$row  = mysql_fetch_array($qry);
		if ($row[0]=="") {
		$angka=0;
		}
		else {
		$angka= substr($row[0], strlen($inisial));
		}
		$angka++;
		$angka      =strval($angka);
		$tmp  ="";
		for($i=1; $i<=($panjang-strlen($inisial)-strlen($angka)); $i++) {
		$tmp=$tmp."0";
		}
		return $inisial.$tmp.$angka;
		}
	$dataCuti=mysql_query("SELECT * FROM tb_jumlahcuti ORDER BY id DESC");

?>
<section class="content">
    <div class="row">
        <div class="col-md-12">
			<div class="box box-primary">
				<div class="box-body">
					<div class="panel-group">

       
				<div class="box-body">
					<table id="example1" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>No</th>
                				<th>Tahun</th>
								<th>Cuti Diperoleh</th>
                				<th>Cuti Bersama</th>
                				<th>Hasil Perhitungan Cuti Per Bulan</th>
                				<th>Tanggal Input</th>
								<th>SKB</th>
							</tr>
						</thead>
						<tbody>
						<?php
            $no =1;
							while($peg=mysql_fetch_array($dataCuti)){
						?>
							<tr>
								<td><?php echo $no++;?></td>
                				<td><?php echo $peg['tahun'];?></td>
								<td><?php echo $peg['cuti_diperoleh'];?> Hari</td>
                				<td><?php echo $peg['cuti_bersama'];?> Hari</td>
                				<td><?php echo $peg['cuti_perbulan'];?> Hari</td>
                				<td><?php echo $peg['tgl_input'];?></td>
                				<td><?php if ($peg['skb'] != NULL) {
                            		echo"<a href='' type='button' onclick='window.open(\"". "uploads/" . $peg['skb'] . "\", \"newwindow\", \"	width=810,height=900\"); return false;'><i class='fa fa-file'></i> <br>View</a>";
                                } else {
                                    echo "";
                                } ?>
                            	</td>
                
              
							</tr>
						<?php
							}
						?>
						</tbody>
					</table>
				</div>
			</div>
        </div>
	</div>
</section>


<script>
  $(function () {
    $("#example1").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });
  });
</script>
<!-- datepicker -->
<script type="text/javascript" src="plugins/datepicker/jquery/jquery-1.8.3.min.js" charset="UTF-8"></script>
<script type="text/javascript" src="plugins/datepicker/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="plugins/datepicker/js/locales/bootstrap-datetimepicker.id.js" charset="UTF-8"></script>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

<script type="text/javascript">
  $(document).ready(function() {
        $("#cuti_diperoleh, #cuti_bersama").keyup(function() {
            var cuti_diperoleh  = $("#cuti_diperoleh").val();
            var cuti_bersama = $("#cuti_bersama").val();

            var hasil = ((parseInt(cuti_diperoleh) - parseInt(cuti_bersama))/12).toFixed(2);

            $("#hasil").val(hasil);
        });
    });

	 $('.form_date').datetimepicker({
			language:  'id',
			weekStart: 1,
			todayBtn:  1,
	  autoclose: 1,
	  todayHighlight: 1,
	  startView: 2,
	  minView: 2,
	  forceParse: 0
		});

    function view_cuti(nip,nama){
      // alert(noid+' - '+waktu);
      $.ajax({
          type : 'post',
          url : 'pemotongancuti',
          data :  {nip:nip, nama:nama},
          success : function(data){
            $('.fetched-data').html(data);//menampilkan data ke dalam modal
            $('#myModal').modal();
          }
      });
    }
</script>
