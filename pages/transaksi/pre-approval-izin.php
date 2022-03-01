<section class="content-header">
    <h1>Pre Approval<small>Izin</small></h1>
    <ol class="breadcrumb">
        <li><a href="home-hrd.php"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="active">Approval Izin</li>
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
								<th>No. Izin</th>
                <th>Nama (Divisi)</th>
								<th>Tgl Pengajuan</th>
								<th>Jumlah Hari</th>
								<th>Dari Tanggal</th>
								<th>Sampai Tanggal</th>
								<th>Jenis Izin</th>
                <th>Gambar</th>
                <th>Persetujuan</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
						<?php
							include "dist/koneksi.php";
              $i = 1;
              $divisi = $_SESSION['divisi'];
              $tampilCuti=mysql_query("SELECT * FROM tb_izin WHERE persetujuan='' AND divisi='$divisi' ORDER BY no DESC");
							while($history=mysql_fetch_array($tampilCuti)){
						?>
							<tr>
								<td><?php echo $i++ ?></td>
                						<td><?php echo $history['nama'];?> (<?php echo $history['divisi'];?>)
								<td><?php echo $history['tgl']; ?></td>
								<td><?php echo $history['jml_hari'];?></td>
								<td><?php echo $history['dari'];?></td>
								<td><?php echo $history['sampai'];?></td>
								<td><?php echo $history['jenis'];?></td>
                <td>
                  <a href="izin/<?php echo $history['gambar']; ?>">
                    <img src="izin/<?php echo $history['gambar']; ?>" width="50" height="50">
                  </a>
                </td>
                <td><?php echo $history['persetujuan'];?></td>
								<td class="tools"><a href="home-manager.php?page=form-approval-izin&no=<?=$history['no'];?>&nip=<?=$history['nip'];?>&jml_hari=<?=$history['jml_hari'];?>&jenis=<?=$history['jenis'];?>" title="approval"><i class="fa fa-check"></i></a>
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
