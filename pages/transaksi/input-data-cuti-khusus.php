<section class="content-header">
    <h1>Input<small>Data Cuti Tahunan</small></h1>
    <ol class="breadcrumb">
        <li><a href="home-hrd.php"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="active">Input Data Cuti Khusus Sesuai PP</li>
    </ol>
</section>
<div class="register-box">
<?php
	if ($_POST['save'] == "save") {
	$nip				= $_POST['nip'];
  $dari       = $_POST['dari'];
  $sampai     = $_POST['sampai'];
  $jenis      = $_POST['jenis'];
  $nama_gambar=$_FILES['gambar'] ['name'];
  $lokasi=$_FILES['gambar'] ['tmp_name']; // Menyiapkan tempat nemapung gambar yang diupload
  $lokasitujuan="./uploads"; // Menguplaod gambar kedalam folder ./image
  $upload=move_uploaded_file($lokasi,$lokasitujuan."/".$nama_gambar);



		if (empty($_POST['nip']) || empty($_POST['hak_cuti_tahunan']) || empty($_POST['dari']) || empty($_POST['sampai']) || empty($_POST['jenis'])) {
		echo "<div class='register-logo'><b>Oops!</b> Data Tidak Lengkap.</div>
			<div class='box box-primary'>
				<div class='register-box-body'>
					<p>Harap periksa kembali dan pastikan data yang Anda masukan lengkap dan benar.</p>
					<div class='row'>
						<div class='col-xs-8'></div>
						<div class='col-xs-4'>
							<button type='button' onclick=location.href='home-hrd.php?page=form-input-data-cuti-tahunan' class='btn btn-block btn-warning'>Back</button>
						</div>
					</div>
				</div>
			</div>";
		}

		else{
		include "dist/koneksi.php";

    $ceknama = mysql_query("SELECT * FROM tb_pegawai WHERE nip='$nip'");
    $cn = mysql_fetch_assoc($ceknama);
    


		$updateHak = "INSERT INTO tb_mohoncuti (no_cuti,nip,nama,divisi,tgl,dari,sampai,jml_hari,jenis,saldo,gambar)
                                    VALUES ('$no_cuti','$nip','$nama','$divisi','$tgl','$dari','$sampai','$jml_hari','$jenis','$saldo','$nama_gambar'";
		$query = mysql_query ($updateHak);

		if($query){
			echo "<div class='register-logo'><b>Input Data</b> Successful!</div>
				<div class='register-box-body'>
					<p>Input Data Cuti Tahunan Berhasil.</p>
					<div class='row'>
						<div class='col-xs-8'></div>
						<div class='col-xs-4'>
							<button type='button' onclick=location.href='home-hrd.php?page=form-input-data-cuti-tahunan' class='btn btn-danger btn-block btn-flat'>Next >></button>
						</div>
					</div>
				</div>";
		}
			else {
				echo "<div class='register-logo'><b>Oops!</b> 404 Error Server.</div>";
			}
		}
	}
?>
</div>
