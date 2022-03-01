<section class="content-header">
    <h1>Daftar<small>Hari Libur & Cuti Bersama</small></h1>
    <ol class="breadcrumb">
        <li><a href="home-hrd.php"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="active">Daftar Hari Libur & Cuti Bersama</li>
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
	$dataLibur=mysql_query("SELECT * FROM kalender ORDER BY num ASC");

?>
<section class="content">
    <div class="row">
        <div class="col-md-12">
			<div class="box box-primary">
				<div class="box-body">
					<div class="panel-group">
						<div class="panel panel-default">
							<div class="panel-heading">
								 <h4 class="panel-title"><i class="fa fa-plus"></i> Add Hari Libur & Cuti Bersama<a data-toggle="collapse" data-target="#formuser" href="#formuser" class="collapsed"></a></h4>
							</div>

							<div id="formuser" class="panel-collapse collapse">
								<div class="panel-body">

         
									<form action="home-hrd.php?page=proses-hari-libur" class="form-horizontal" method="POST" enctype="multipart/form-data">

										<div class="form-group">
											<label class="col-sm-3 control-label">Tanggal <font color="red">*</font></label>
											<div class="col-sm-7">
												<input type="date" name="tanggal" class="form-control" id="tanggal" required>
											</div>
										</div>

										<div class="form-group">
											<label class="col-sm-3 control-label">Keterangan <font color="red">*</font></label>
											<div class="col-sm-7">
												<input type="text" name="keterangan" class="form-control" id="keterangan" required>
											</div>
										</div>

                    

										<div class="form-group">
											<div class="col-sm-offset-3 col-sm-7">
												<button type="submit" name="save" value="save" class="btn btn-danger">Save</button>
											</div>
										</div>

									</form>
								</div>
							</div>
						</div>

       
				<div class="box-body">
					<!-- <button type="botton" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Tambah Daftar</button> -->
					<!-- Button trigger modal -->
<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#edit">Launch demo modal</button> -->

					<table id="example1" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>No</th>
                				<th>Tanggal</th>
								<th>Keterangan</th>
                				<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
						<?php
            $no =1;
							while($peg=mysql_fetch_array($dataLibur)){
						?>
							<tr>
								<td><?php echo $no++;?></td>
                				<td><?php echo $peg['tanggal'];?></td>
								<td><?php echo $peg['keterangan'];?></td>
                				<td class="tools">
                					 <a href="" type="button" title="edit"  data-toggle="modal" data-target="#edit<?php echo $peg['num'] ?>"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;
                					<a href="home-hrd.php?page=delete-data-hari-libur&num=<?php echo $peg['num'];?>" title="delete"><i class="fa fa-trash-o"></i></a>
                				</td>              
							</tr>

							<div class="modal fade" id="edit<?php echo $peg['num'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
							  <div class="modal-dialog">
							    <div class="modal-content">
							      <div class="modal-header">
							        <h5 class="modal-title font-weight-bold" id="exampleModalLabel">Edit Daftar Hari Libur & Cuti Bersama</h5>
							        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
							          <span aria-hidden="true">&times;</span>
							        </button>
							      </div>
							      <div class="modal-body">
							      	<div class="panel-body">
							        <form action="home-hrd.php?page=edit-hari-libur" class="form-horizontal" method="POST" enctype="multipart/form-data">

							        	<input type="hidden" name="num" value="<?php echo $peg['num'];?>">
										
											<div class="form-group">
											    <label for="exampleInputPassword1">Tanggal</label>
												<input type="date" name="tanggal" class="form-control" id="tanggal" value="<?php echo $peg['tanggal'];?>" required>
											   
											  </div>
											  <div class="form-group">
											    <label for="exampleInputPassword1">Keterangan</label>
												<input type="text" name="keterangan" class="form-control" id="keterangan" value="<?php echo $peg['keterangan'];?>" required>
											  </div>

                    

										<!-- <div class="form-group">
											<div class="col-sm-offset-3 col-sm-7">
												<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							        
												<button type="submit" name="save" value="save" class="btn btn-danger">Save</button>
											</div>
										</div> -->

									</div>
							      </div>
							      <div class="modal-footer">
							        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
							        <button type="submit" name="save" value="save" class="btn btn-primary">Save</button>
							      </div>
							      </form>
							    </div>
							  </div>
							</div>
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
