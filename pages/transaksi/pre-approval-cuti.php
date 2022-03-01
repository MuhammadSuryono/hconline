<section class="content-header">
    <h1>Pre Approval<small>Cuti</small></h1>
    <ol class="breadcrumb">
        <li><a href="home-hrd.php"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="active">Approval Cuti</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
			<div class="box box-primary">
				<div class="box-body table-responsive">
					<table id="example1" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>No. Cuti</th>
                <th>Nama (Divisi)</th>
								<th>Tgl Pengajuan</th>
								<th>Jumlah Hari</th>
								<th>Dari Tanggal</th>
								<th>Sampai Tanggal</th>
								<th>Jenis Cuti</th>
                <th>Keterangan</th>
                <th>Gambar</th>
                <th>Persetujuan</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
						<?php
							include "dist/koneksi.php";

              $tampilCuti=mysql_query("SELECT * FROM tb_mohoncuti WHERE persetujuan='' ORDER BY no_cuti");
							while($history=mysql_fetch_array($tampilCuti)){
						?>
							<tr>
								<td><?php echo $history['no_cuti'];?></td>
                <td><?php echo $history['nama'];?> (<?php echo $history['divisi'];?>)
								<td><?php echo $history['tgl']; ?></td>
								<td><?php echo $history['jml_hari'];?></td>
								<td><?php echo $history['dari'];?></td>
								<td><?php echo $history['sampai'];?></td>
								<td><?php echo $history['jenis'];?></td>
                <td><?php echo $history['keterangan'];?></td>
                <td>
                  <a href="uploads/<?php echo $history['gambar']; ?>">
                    <img src="uploads/<?php echo $history['gambar']; ?>" width="50" height="50">
                  </a>
                </td>
                <td><?php echo $history['persetujuan'];?></td>
								<td class="tools"><a href="home-hrd.php?page=form-approval-cuti&no_cuti=<?=$history['no_cuti'];?>&nip=<?=$history['nip'];?>&jml_hari=<?=$history['jml_hari'];?>&jenis=<?=$history['jenis'];?>&saldo=<?=$history['saldo'];?>" title="approval"><i class="fa fa-check"></i></a>
                  <?php echo "<td><a href='#myModal' class='btn btn-default btn-small' id='custId' data-toggle='modal' data-id=".$history['no_cuti'].">EDIT</a></td>"; ?></td>
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

<div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Detail Cuti</h4>
                </div>
                <div class="modal-body">
                    <div class="fetched-data"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Keluar</button>
                </div>
            </div>
        </div>
    </div>

<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
      <script type="text/javascript">
        $(document).ready(function(){
            $('#myModal').on('show.bs.modal', function (e) {
                var rowid = $(e.relatedTarget).data('id');
                //menggunakan fungsi ajax untuk pengambilan data
                $.ajax({
                    type : 'post',
                    url : 'pages/transaksi/edittanggal.php',
                    data :  'rowid='+ rowid,
                    success : function(data){
                    $('.fetched-data').html(data);//menampilkan data ke dalam modal
                    }
                });
             });
        });
      </script>
