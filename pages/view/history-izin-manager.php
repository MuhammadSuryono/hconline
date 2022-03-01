<section class="content-header">
    <h1>History<small>Izin</small></h1>
    <ol class="breadcrumb">
        <li><a href="home-hrd.php"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="active">History Izin</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
			<div class="box box-primary">
				<div class="box-body">
					<div>

					</div>

          <div class="table-responsive">
					<table id="example1" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>No</th>
                <th>Nama (Divisi)</th>
								<th>Tgl Pengajuan</th>
								<th>Jumlah Hari</th>
								<th>Dari Tanggal</th>
								<th>Sampai Tanggal</th>
								<th>Jenis Izin</th>
                <th>Gambar</th>
                <th>Keterangan</th>
                <th>persetujuan</th>
							</tr>
						</thead>
						<tbody>

              <?php
              include "dist/koneksi.php";

              function getAddress($latitude,$longitude){
              if(!empty($latitude) && !empty($longitude)){
                  //Send request and receive json data by address
                  $geocodeFromLatLong = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?latlng='.$latitude.','.$longitude.'&sensor=false&key=AIzaSyAiyhesBNvNBUPfa_88RhWcs7nULCfJOBg');
                  $output = json_decode($geocodeFromLatLong);
                  $status = $output->status;
                  //Get address from json data
                  $address = ($status=="OK")?$output->results[1]->formatted_address:'';
                  //Return address of the given latitude and longitude
                  if(!empty($address)){
                      return $address;
                  }else{
                      return false;
                  }
              }else{
                  return false;
              }
          }


              $i=1;
              $tampilCuti=mysql_query("SELECT * FROM tb_izin WHERE divisi='$_SESSION[divisi]' ORDER BY no DESC");
							while($history=mysql_fetch_array($tampilCuti)){

                $latitude   = $history['latitude'];
                $longitude  = $history['longitude'];
                $address    = getAddress($latitude,$longitude);
                $address    = $address?$address:'Not found';


              ?>

							<tr>
								<td><?php echo $i++ ?></td>
								<td><?php echo $history['nama'];?> (<?php echo $history['divisi'];?>)</td>
                <td><?php echo $history['tgl'];?></td>
								<td><?php echo $history['jml_hari'];?></td>
								<td><?php echo $history['dari'];?></td>
								<td><?php echo $history['sampai'];?></td>
								<td><?php echo $history['jenis'];?></td>
                <td>
                  <a href="izin/<?php echo $history['gambar']; ?>">
                    <img src="izin/<?php echo $history['gambar']; ?>" width="50" height="50">
                  </a>
                </td>
                <td><?php echo $address; ?>, <?php echo $latitude; ?>, <?php echo $longitude; ?></td>
                <td><?php echo $history['persetujuan'];?></td>
							</tr>
            <?php } ?>
						</tbody>
					</table>
        </div>

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
