<?php
session_start();
if(!isset($_SESSION['id_user'])){
    die("<b>Oops!</b> Access Failed.
		<p>Sistem Logout. Anda harus melakukan Login kembali.</p>
		<button type='button' onclick=location.href='index.php'>Back</button>");
}
if($_SESSION['hak_akses']!="Manager"){
    die("<b>Oops!</b> Access Failed.
		<p>Anda Bukan Manager.</p>
		<button type='button' onclick=location.href='index.php'>Back</button>");
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>MRI || HC ONLINE</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.5 -->
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="bootstrap/css/bootstrap.css">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="dist/css/font-awesome.min.css">
	<!-- Ionicons -->
	<link rel="stylesheet" href="dist/css/ionicons.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
	<link rel="stylesheet" href="dist/css/AdminLTE.css">
	<!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
	<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
	<!-- iCheck -->
	<link rel="stylesheet" href="plugins/iCheck/flat/blue.css">
	<link rel="stylesheet" href="plugins/iCheck/square/blue.css">
	<!-- Morris chart -->
	<link rel="stylesheet" href="plugins/morris/morris.css">
	<!-- jvectormap -->
	<link rel="stylesheet" href="plugins/jvectormap/jquery-jvectormap-1.2.2.css">
	<!-- Date Picker -->
	<link rel="stylesheet" href="plugins/datepicker/bootstrap-datetimepicker.min.css">
	<!-- bootstrap wysihtml5 - text editor -->
	<link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
	<!-- DataTables -->
	<link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
	<script type="text/javascript" src="plugins/datatables/jquery.js"></script>

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<?php
	include "dist/koneksi.php";
	$tampilCuti=mysql_query("SELECT * FROM tb_mohoncuti WHERE persetujuan='' AND divisi='$_SESSION[divisi]'");
	$jmlcut=mysql_num_rows($tampilCuti);

  $tampilIzin=mysql_query("SELECT * FROM tb_izin WHERE persetujuan='' AND divisi='$_SESSION[divisi]'");
  $jmlizin=mysql_num_rows($tampilIzin);
?>
<body class="hold-transition skin-red fixed sidebar-mini">
<div class="wrapper">
	<header class="main-header">
		<a href="home-manager.php" class="logo"><span class="logo-mini">MRI</span><span class="logo-lg"><b>HC</b> ONLINE</span></a>
		<nav class="navbar navbar-static-top" role="navigation">
			<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button"><span class="sr-only">Toggle navigation</span></a>
			<div class="navbar-custom-menu">
				<ul class="nav navbar-nav">
					<li class="dropdown messages-menu">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-inbox"></i><span class="label label-warning"><?=$jmlcut?></span></a>
						<ul class="dropdown-menu">
							<li class="header">Anda memiliki <?=$jmlcut?> permohonan cuti</li>
						</ul>
					</li>
					<li class="dropdown user user-menu">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<img src='dist/img/profile/no-image.jpg' class='user-image' alt='User Image'>
							<span class="hidden-xs">HC Online</span> &nbsp;<i class="fa fa-angle-down"></i>
						</a>
						<ul class="dropdown-menu">
							<li class="user-header">
								<img src='dist/img/profile/no-image.jpg' class='img-circle' alt='User Image'>
								<p>Welcome - <?php echo $_SESSION['nama_user'] ?><small><?php echo $_SESSION['hak_akses'] ?></small></p>
							</li>
              <li class="user-body">
                 <div class="row">&nbsp;&nbsp;<a href="home-manager.php?page=form-ubah-password"> <font color="blue"><b><i class="fa fa-edit"></i> Ubah Password</a></b></font></div>
             </li>
							<li class="user-footer">
								<div class="pull-left">
									<?php echo date("d-m-Y");?>
								</div>
								<div class="pull-right">
								  <a href="pages/login/act-logout.php" class="btn btn-default btn-flat">Log out</a>
								</div>
							</li>
						</ul>
					</li>
				</ul>
			</div>
		</nav>
	</header>
	<aside class="main-sidebar">
		<section class="sidebar">
			<ul class="sidebar-menu" style="overflow-y: scroll; padding-bottom: 60px;">
				<li class="header">MAIN NAVIGATION</li>

				<li class="treeview"><a href="home-manager.php"><i class="fa fa-dashboard"></i> <span>Dashboard</span></i></a></li>

        <li class="treeview"><a href="#"><i class="fa fa-book"></i> <span>Permohonan</span><i class="fa fa-angle-left pull-right"></i></a>
					<ul class="treeview-menu">
						<li><a href="home-manager.php?page=form-permohonan-cuti-tahunanm">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-caret-right"></i> Cuti Tahunan</a></li>
						<!--<li><a href="home-manager.php?page=form-permohonan-cuti-umumm">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-caret-right"></i> Cuti Umum</a></li>-->
            <li><a href="home-manager.php?page=form-permohonan-cuti-dispensasim">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-caret-right"></i> Cuti Dispensasi</a></li>
					</ul>
				</li>

        <li class="treeview"><a href="home-manager.php?page=form-izinm"><i class="fa fa-book"></i> <span>Izin</span></i></a></li>

        <li class="treeview"><a href="home-manager.php?page=form-tugas-dinas"><i class="fa fa-book"></i> <span>Tugas</span></i></a></li>

        <li class="treeview"><a href="home-manager.php?page=form-unpaid"><i class="fa fa-book"></i> <span>Unpaid Leave</span></i></a></li>

        <li class="treeview"><a href="home-manager.php?page=form-lupa-absen"><i class="fa fa-book"></i> <span>Koreksi Absen</span></i></a></li>

        <li class="treeview"><a href="home-manager.php?page=form-lembur"><i class="fa fa-book"></i> <span>Pengganti Pulang Malam</span></i></a></li>

        <li class="treeview"><a href="home-manager.php?page=form-lembur-weekend"><i class="fa fa-book"></i> <span>Assign Lembur Weekend</span></i></a></li>

        <li class="treeview"><a href="home-manager.php?page=laporan-payroll"><i class="fa fa-book"></i> <span>Laporan Payroll</span></i></a></li>

				<li class="treeview"><a href="home-manager.php?page=pre-approval-cuti2"><i class="fa fa-gear"></i> <span>Approval Cuti</span><small class="label pull-right bg-yellow"><?=$jmlcut?></small></a></li>

        <li class="treeview"><a href="home-manager.php?page=pre-approval-izin"><i class="fa fa-gear"></i> <span>Approval Izin</span><small class="label pull-right bg-yellow"><?=$jmlizin?></small></a></li>

        <li class="treeview"><a href="#"><i class="fa fa-book"></i> <span>History</span><i class="fa fa-angle-left pull-right"></i></a>
					<ul class="treeview-menu">
        <li class="treeview"><a href="home-manager.php?page=history-transaksi-cuti"><i class="fa fa-exchange"></i> <span>History Cuti</span></a></li>
        <li class="treeview"><a href="home-manager.php?page=history-izin-manager"><i class="fa fa-exchange"></i> <span>History Izin</span></a></li>
        <li class="treeview"><a href="home-manager.php?page=history-unpaid-leave"><i class="fa fa-exchange"></i> <span>History Unpaid Leave</span></a></li>
        <li class="treeview"><a href="home-manager.php?page=history-lembur"><i class="fa fa-exchange"></i> <span>History Lembur</span></a></li>
        <li class="treeview"><a href="home-manager.php?page=history-lembur-weekend"><i class="fa fa-exchange"></i> <span>History Lembur Weekend</span></a></li>
          </ul>
        </li>

        <li class="treeview"><a href="home-manager.php?page=attendance-baru-user"><i class="fa fa-book"></i> <span>Attendance</span></i></a></li>

        <li class="treeview"><a href="home-manager.php?page=download-form"><i class="fa fa-book"></i> <span>FORM</span></i></a></li>
        <li class="treeview"><a href="home-manager.php?page=list-exit-interview"><i class="fa fa-book"></i> <span>List Exit Interview</span></i></a></li>

			</ul>
		</section>
	</aside>
	<div class="content-wrapper">
		<section class="content">
			<?php
				$page = (isset($_GET['page']))? $_GET['page'] : "main";
				switch ($page) {
					case 'form-permohonan-cuti-tahunanm': include "pages/transaksi/form-permohonan-cuti-tahunanm.php"; break;
					case 'permohonan-cuti-tahunanm': include "pages/transaksi/permohonan-cuti-tahunanm.php"; break;
          case 'form-permohonan-cuti-umumm': include "pages/transaksi/form-permohonan-cuti-umumm.php"; break;
					case 'permohonan-cuti-umumm': include "pages/transaksi/permohonan-cuti-umumm.php"; break;
          case 'form-permohonan-cuti-dispensasim': include "pages/transaksi/form-permohonan-cuti-dispensasim.php"; break;
          case 'permohonan-cuti-dispensasim': include "pages/transaksi/permohonan-cuti-dispensasim.php"; break;
					case 'pre-approval-cuti2': include "pages/transaksi/pre-approval-cuti2.php"; break;
					case 'form-approval-cuti2': include "pages/transaksi/form-approval-cuti2.php"; break;
          case 'form-approval-izin': include "pages/transaksi/form-approval-izin.php"; break;
          case 'form-budget': include "pages/transaksi/form-budget.php"; break;
          case 'budget1': include "pages/transaksi/budget1.php"; break;
          case 'pre-approval-izin': include "pages/transaksi/pre-approval-izin.php"; break;
					case 'approved-cuti2': include "pages/transaksi/approved-cuti2.php"; break;
          case 'approved-izin': include "pages/transaksi/approved-izin.php"; break;
					case 'not-approved-cuti2': include "pages/transaksi/not-approved-cuti2.php"; break;
          case 'not-approved-izin': include "pages/transaksi/not-approved-izin.php"; break;
          case 'alasan2': include "pages/transaksi/alasan2.php"; break;
          case 'alasanproses2': include "pages/transaksi/alasanproses2.php"; break;
          case 'izinm': include "pages/transaksi/izinm.php"; break;
          case 'form-izinm': include "pages/transaksi/form-izinm.php"; break;
          case 'form-unpaid': include "pages/transaksi/form-unpaid.php"; break;
          case 'form-lembur': include "pages/transaksi/form-lembur.php"; break;
          case 'unpaid-proses': include "pages/transaksi/unpaid-proses.php"; break;
          case 'lembur-proses': include "pages/transaksi/lembur-proses.php"; break;
					case 'history-cuti-manager': include "pages/view/history-cuti-manager.php"; break;
		 case 'history-transaksi-cuti': include "pages/master/history-transaksi-cuti.php"; break;
          case 'history-izin-manager': include "pages/view/history-izin-manager.php"; break;
          case 'history-unpaid-leave': include "pages/view/history-unpaid-leave.php"; break;
          case 'history-cuti-dispensasim': include "pages/view/history-cuti-dispensasim.php"; break;
          case 'history-lembur': include "pages/view/history-lembur.php"; break;
          case 'download-form': include "pages/view/download-form.php"; break;
          case 'attendance_process_new-user': include "pages/transaksi/attendance-process-new-user.php"; break;
          case 'attendance-baru-user': include "pages/master/attendance-baru-user.php"; break;
          case 'form-tugas-dinas': include "pages/master/form-tugas-dinas.php"; break;
          case 'proses-tugas-dinas': include "pages/transaksi/proses-tugas-dinas.php"; break;
          case 'form-ubah-password': include "pages/master/form-ubah-password.php"; break;
          case 'proses-ubah-password': include "pages/transaksi/proses-ubah-password.php"; break;
          case 'laporan-payroll': include "pages/master/laporan-payroll.php"; break;
          case 'proses-laporan-payroll': include "pages/transaksi/proses-laporan-payroll.php"; break;
          case 'form-lupa-absen': include "pages/master/form-lupa-absen.php"; break;
          case 'proses-lupa-absen': include "pages/transaksi/proses-lupa-absen.php"; break;
          case 'form-lembur-weekend': include "pages/master/form-lembur-weekend.php"; break;
          case 'proses-lembur-weekend': include "pages/transaksi/proses-lembur-weekend.php"; break;
          case 'history-lembur-weekend': include "pages/view/history-lembur-weekend.php"; break;
          case 'list-exit-interview': include "pages/master/list-exit-interview.php"; break;

					default : include 'dashboard-pegawai.php';
				}
			?>
		</section>



    <MARQUEE DIRECTION=LEFT><h3>Pastikan cuti anda mendapatkan persetujuan, Buka <b>hconline</b> untuk memastikan.</h3></MARQUEE>
	</div>
	<footer class="main-footer">
		<div class="pull-right hidden-xs"><b>Version</b> 1.0</div>
		Copyright &copy; 2018 <a href="#" target="_blank"> MRI HC ONLINE</a>. All rights reserved
	</footer>
</div>
	<!-- ./wrapper -->
	<!-- jQuery 2.1.4 -->
	<script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
	<!-- jQuery UI 1.11.4 -->
	<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
	<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
	<script>
	  $.widget.bridge('uibutton', $.ui.button);
	</script>
	<!-- Bootstrap 3.3.5 -->
	<script src="bootstrap/js/bootstrap.min.js"></script>
	<!-- Morris.js charts -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
	<script src="plugins/morris/morris.min.js"></script>
	<!-- Sparkline -->
	<script src="plugins/sparkline/jquery.sparkline.min.js"></script>
	<!-- jvectormap -->
	<script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
	<script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
	<!-- jQuery Knob Chart -->
	<script src="plugins/knob/jquery.knob.js"></script>
	<!-- Bootstrap WYSIHTML5 -->
	<script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
	<!-- Slimscroll -->
	<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
	<!-- FastClick -->
	<script src="plugins/fastclick/fastclick.js"></script>
	<!-- AdminLTE App -->
	<script src="dist/js/app.min.js"></script>
	<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
	<script src="dist/js/pages/dashboard.js"></script>
	<!-- AdminLTE for demo purposes -->
	<script src="dist/js/demo.js"></script>
	<!-- DataTables -->
	<script src="plugins/datatables/jquery.dataTables.min.js"></script>
	<script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
</body>
</html>
