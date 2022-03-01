<section class="content-header">
   <h1>MRI Cuti Online<small>Dashboard</small></h1>
    <ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i>Dashboard</a></li>
    </ol>
</section>
<?php
	include "dist/koneksi.php";
	$cuti=mysql_query("SELECT hak_cuti_tahunan,hak_cuti_tahunlalu,hak_cuti_dispensasi FROM tb_pegawai  WHERE nip='$_SESSION[id_user]'");
	$d = mysql_fetch_assoc($cuti);

	$approve=mysql_query("SELECT * FROM tb_mohoncuti WHERE nip='$_SESSION[id_user]' AND persetujuan='Disetujui' OR persetujuan='Tidak Disetujui'");
	$jmlapprove = mysql_num_rows($approve);

	$wait=mysql_query("SELECT * FROM tb_mohoncuti WHERE persetujuan='' AND nip='$_SESSION[id_user]'");
	$jmlwait = mysql_num_rows($wait);

  
    $year = date('Y');
    $previousyear = date('Y') - 1;

    $datacuti = mysql_query("SELECT * FROM tb_jumlahcuti WHERE tahun = '$year' ORDER BY id DESC LIMIT 1");
    $get = mysql_fetch_array($datacuti);

    $cuti_bulanan = $get['cuti_perbulan'];
                        
?>
<section class="content">
    <div class="row">
		<div class="col-lg-3 col-xs-12">
			<div class="small-box bg-aqua">
				<div class="inner">
					<h3><?=$d['hak_cuti_tahunan'];?> Hari</h3>
					<p>Saldo Cuti Tahun <?php echo $year; ?></p>
                    <!-- <br> -->
                    <p>Penambahan Cuti Perbulan <?php echo $cuti_bulanan ?> Hari</p>
				</div>
				<div class="icon">
					<i class="ion ion-bag"></i>
				</div>
				<p class="small-box-footer">Cuti <i class="fa fa-arrow-circle-right"></i></p>
			</div>
        </div>

        <!-- <div class="row"> -->
    		<div class="col-lg-3 col-xs-12">
    			<div class="small-box bg-aqua">
    				<div class="inner">
    					<h3><?=$d['hak_cuti_tahunlalu'];?> Hari</h3>
    					<p>Saldo Cuti Tahun <?php echo $previousyear; ?></p> 
                        <p>Masa Berlaku s.d 30 Juni <?php echo $year; ?></p>
    				</div>
    				<div class="icon">
    					<i class="ion ion-bag"></i>
    				</div>
    				<p class="small-box-footer">Cuti <i class="fa fa-arrow-circle-right"></i></p>
    			</div>
            </div>

            <!-- <div class="row"> -->
        		<div class="col-lg-3 col-xs-12">
        			<div class="small-box bg-aqua">
        				<div class="inner">
        					<h3><?=$d['hak_cuti_dispensasi'];?> Hari</h3>
        					<p>Saldo Cuti Dispensasi</p>
                            <br>
        				</div>
        				<div class="icon">
        					<i class="ion ion-bag"></i>
        				</div>
        				<p class="small-box-footer">Cuti <i class="fa fa-arrow-circle-right"></i></p>
        			</div>
                </div>



</section>
