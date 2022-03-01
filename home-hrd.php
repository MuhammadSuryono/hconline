<?php
session_start();
if (!isset($_SESSION['id_user'])) {
    die("<b>Oops!</b> Access Failed.
		<p>Sistem Logout. Anda harus melakukan Login kembali.</p>
		<button type='button' onclick=location.href='index.php'>Back</button>");
}
if ($_SESSION['hak_akses'] != "HRD") {
    die("<b>Oops!</b> Access Failed.
		<p>Anda Bukan HRD.</p>
		<button type='button' onclick=location.href='index.php'>Back</button>");
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>MRI || HC Online</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <!-- Attendance -->
    <link rel="stylesheet" href="bootstrap/css/attendance.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="dist/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="dist/css/ionicons.min.css">
    <link rel="stylesheet" href="dist/css/kalender.css">
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
require_once "dist/koneksi.php";
// include "dist/koneksi.php";
$tampilCuti = mysql_query("SELECT * FROM tb_mohoncuti WHERE persetujuan=''  AND jml_hari > '1' OR hak_akses='Manager' AND persetujuan=''");
$jmlcut = mysql_num_rows($tampilCuti);
?>

<body class="hold-transition skin-red fixed sidebar-mini">
    <div class="wrapper">
        <header class="main-header">
            <a href="home-hrd.php" class="logo"><span class="logo-mini">MRI</span><span class="logo-lg"><b>HC</b> ONLINE</span></a>
            <nav class="navbar navbar-static-top" role="navigation">
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button"><span class="sr-only">Toggle navigation</span></a>
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <li class="dropdown messages-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-inbox"></i><span class="label label-warning"><?= $jmlcut ?></span></a>
                            <ul class="dropdown-menu">
                                <li class="header">Anda memiliki <?= $jmlcut ?> permohonan cuti</li>
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
                                    <div class="row">&nbsp;&nbsp;<a href="home-hrd.php?page=form-ubah-password">
                                            <font color="blue"><b><i class="fa fa-edit"></i> Ubah Password
                                        </a></b></font>
                                    </div>
                                </li>
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <?php echo date("d-m-Y"); ?>
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
        <aside class="main-sidebar" >
            <section class="sidebar" >
                <ul class="sidebar-menu" style="overflow-y: scroll; padding-bottom: 70px; width: 100%;">
                    <li class="header">MAIN NAVIGATION</li>
                    <li class="treeview"><a href="home-hrd.php"><i class="fa fa-dashboard"></i> <span>Dashboard</span></i></a></li>

                    <li class="treeview"><a href="#"><i class="fa fa-book"></i> <span>Permohonan Cuti</span><i class="fa fa-angle-left pull-right"></i></a>
                        <ul class="treeview-menu">
                            <li><a href="home-hrd.php?page=form-permohonan-cuti-tahunan">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-caret-right"></i> Cuti Tahunan</a></li>
                            <!--<li><a href="home-hrd.php?page=form-permohonan-cuti-umum">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-caret-right"></i> Cuti Umum</a></li>-->
                        </ul>
                    </li>

                    <li class="treeview"><a href="home-hrd.php?page=form-input-data-cuti-tahunan"><i class="fa fa-book"></i> <span>Input Data Cuti</span></a></li>
                    <li class="treeview"><a href="home-hrd.php?page=pre-approval-cuti"><i class="fa fa-gear"></i> <span>Approval Cuti</span></a></li>
                    <li class="treeview"><a href="home-hrd.php?page=pre-approval-izin-direksi"><i class="fa fa-gear"></i> <span>Approval Izin</span></a></li>
                    <li class="treeview"><a href="home-hrd.php?page=form-lembur-weekend"><i class="fa fa-gear"></i> <span>Assign Lembur Weekend</span></a></li>


                    <li class="treeview"><a href="#"><i class="fa fa-book"></i> <span>History</span><i class="fa fa-angle-left pull-right"></i></a>
                        <ul class="treeview-menu">
                            <li><a href="home-hrd.php?page=history-transaksi-cuti"> <i class="fa fa-caret-right"></i>History Cuti</a></li>
                            <li><a href="home-hrd.php?page=history-izin-hrd"> <i class="fa fa-caret-right"></i>History Izin</a></li>
                            <li><a href="home-hrd.php?page=history-unpaid-leaveall"> <i class="fa fa-caret-right"></i>History Unpaid Leave</a></li>
                            <li><a href="home-hrd.php?page=history-lemburhrd"> <i class="fa fa-caret-right"></i>History Pengganti Pulang Malam</a></li>
                            <li><a href="home-hrd.php?page=history-data-dispensasi"> <i class="fa fa-caret-right"></i>History Data Cuti Dispensasi</a></li>
                            <li><a href="home-hrd.php?page=history-lembur-weekend"> <i class="fa fa-caret-right"></i>History Lembur Weekend</a></li>
                        </ul>

                    <li class="treeview"><a href="#"><i class="fa fa-book"></i> <span>Master Data</span><i class="fa fa-angle-left pull-right"></i></a>
                        <ul class="treeview-menu">
                            <li><a href="home-hrd.php?page=form-master-user"> <i class="fa fa-caret-right"></i> User</a></li>
                            <li><a href="home-hrd.php?page=form-master-pegawai"> <i class="fa fa-caret-right"></i> Pegawai</a></li>
                            <li><a href="home-hrd.php?page=keterangan"> <i class="fa fa-caret-right"></i> Data Lengkap</a></li>
                            <li><a href="home-hrd.php?page=attendance-baru"> <i class="fa fa-caret-right"></i> Attendance Terbaru</a></li>
                            <!-- <li><a href="home-hrd.php?page=attendance-mitra"> <i class="fa fa-caret-right"></i> Attendance Mitra</a></li> -->
                            <li><a href="home-hrd.php?page=rekap-data"> <i class="fa fa-caret-right"></i> Rekap Data Absensi</a></li>
                            <li><a href="home-hrd.php?page=rekap-ranking3"> <i class="fa fa-caret-right"></i> Rekap Data Ranking</a></li>
                            <!-- <li><a href="home-hrd.php?page=form-matrix-lembur"> <i class="fa fa-caret-right"></i> Matrix Pengganti Uang Malam</a></li> -->
                            <li><a href="home-hrd.php?page=view-matrix-jabatan"> <i class="fa fa-caret-right"></i> Matrix Jabatan</a></li>
                            <li><a href="home-hrd.php?page=rekap-mangkir"> <i class="fa fa-caret-right"></i> Data Mangkir Karyawan</a></li>
                            <li><a href="home-hrd.php?page=form-penilaian-karyawan"> <i class="fa fa-caret-right"></i> Penilaian Karyawan</a></li>
                            <li><a href="home-hrd.php?page=data-jumlah-cuti"> <i class="fa fa-caret-right"></i> Data Cuti & Cuti Bersama</a></li>
                            <li><a href="home-hrd.php?page=data-hari-libur"> <i class="fa fa-caret-right"></i> Data Hari Libur & Cuti Bersama</a></li>

                            
                        </ul>
                    </li>

                    <li class="treeview"><a href="home-hrd.php?page=history-transaksi-cuti"><i class="fa fa-book"></i> <span>History Transaksi Cuti</span></i></a></li>
                    <li class="treeview"><a href="home-hrd.php?page=laporan-payroll"><i class="fa fa-book"></i> <span>Laporan Payroll</span></i></a></li>
                    <li class="treeview"><a href="home-hrd.php?page=laporan-payroll-baru"><i class="fa fa-book"></i> <span>Laporan Payroll Baru (Under Developer)</span></i></a></li>
                    <li class="treeview"><a href="home-hrd.php?page=laporan-payroll-baru-2"><i class="fa fa-book"></i> <span>Laporan Payroll Baru 2 (Under Developer)</span></i></a></li>
                    <!-- <li class="treeview"><a href="home-hrd.php?page=laporan-payroll-lama"><i class="fa fa-book"></i> <span>Laporan Payroll Lama</span></i></a></li> -->
                    <li class="treeview"><a href="home-hrd.php?page=download-form"><i class="fa fa-book"></i> <span>FORM</span></i></a></li>
                    <li><a href="home-hrd.php?page=report-tahunan"><i class="fa fa-book"></i> <span>Report Tahunan</span></i></a></li>
                    <li class="treeview"><a href="home-hrd.php?page=list-exit-interview"><i class="fa fa-book"></i> <span>List Exit Interview</span></i></a></li>

                </ul>
            </section>
        </aside>
        <div class="content-wrapper">
            <section class="content">
                <?php
                $page = (isset($_GET['page'])) ? $_GET['page'] : "main";
                switch ($page) {
                    case 'form-input-data-cuti-tahunan':
                        include "pages/transaksi/form-input-data-cuti-tahunan.php";
                        break;
                    case 'form-permohonan-cuti-tahunan':
                        include "pages/transaksi/form-permohonan-cuti-tahunan.php";
                        break;
                    case 'form-permohonan-cuti-umum':
                        include "pages/transaksi/form-permohonan-cuti-umum.php";
                        break;
                    case 'permohonan-cuti-umum':
                        include "pages/transaksi/permohonan-cuti-umum.php";
                        break;
                    case 'input-data-cuti-tahunan':
                        include "pages/transaksi/input-data-cuti-tahunan.php";
                        break;
                    case 'input-data-cuti-tahunlalu':
                        include "pages/transaksi/input-data-cuti-tahunlalu.php";
                        break;
                    case 'input-data-cuti-dispensasi':
                        include "pages/transaksi/input-data-cuti-dispensasi.php";
                        break;
                    case 'pre-approval-cuti':
                        include "pages/transaksi/pre-approval-cuti.php";
                        break;
                    case 'pre-approval-izin-direksi':
                        include "pages/transaksi/pre-approval-izin-direksi.php";
                        break;
                    case 'form-approval-cuti':
                        include "pages/transaksi/form-approval-cuti.php";
                        break;
                    case 'form-approval-izin-direksi':
                        include "pages/transaksi/form-approval-izin-direksi.php";
                        break;
                    case 'approved-cuti':
                        include "pages/transaksi/approved-cuti.php";
                        break;
                    case 'approved-izin-direksi':
                        include "pages/transaksi/approved-izin-direksi.php";
                        break;
                    case 'not-approved-izin-direksi':
                        include "pages/transaksi/not-approved-izin-direksi.php";
                        break;
                    case 'not-approved-cuti':
                        include "pages/transaksi/not-approved-cuti.php";
                        break;
                    case 'alasan':
                        include "pages/transaksi/alasan.php";
                        break;
                    case 'alasanproses':
                        include "pages/transaksi/alasanproses.php";
                        break;
                    case 'history-cuti-hrd':
                        include "pages/view/history-cuti-hrd.php";
                        break;
                    case 'history-izin-hrd':
                        include "pages/view/history-izin-hrd.php";
                        break;
                    case 'history-unpaid-leaveall':
                        include "pages/view/history-unpaid-leaveall.php";
                        break;
                    case 'history-lemburhrd':
                        include "pages/view/history-lemburhrd.php";
                        break;
                    case 'edittanggal':
                        include "pages/transaksi/edittanggal.php";
                        break;
                    case 'form-master-user':
                        include "pages/master/form-master-user.php";
                        break;
                    case 'pre-activated-deactivate-user':
                        include "pages/master/pre-activated-deactivate-user.php";
                        break;
                    case 'activated-user':
                        include "pages/master/activated-user.php";
                        break;
                    case 'deactivate-user':
                        include "pages/master/deactivate-user.php";
                        break;
                    case 'form-master-pegawai':
                        include "pages/master/form-master-pegawai.php";
                        break;
                    case 'form-edit-data-pegawai':
                        include "pages/master/form-edit-data-pegawai.php";
                        break;
                    case 'master-user':
                        include "pages/master/master-user.php";
                        break;
                    case 'master-pegawai':
                        include "pages/master/master-pegawai.php";
                        break;
                    case 'delete-data-pegawai':
                        include "pages/master/delete-data-pegawai.php";
                        break;
                    case 'delete-data-hari-libur':
                        include "pages/master/delete-data-hari-libur.php";
                        break;
                    case 'edit-data-pegawai':
                        include "pages/master/edit-data-pegawai.php";
                        break;
                    case 'form-lihat-data-pegawai':
                        include "pages/master/form-lihat-data-pegawai.php";
                        break;
                    case 'keterangan':
                        include "pages/master/keterangan.php";
                        break;
                    case 'attendance':
                        include "pages/master/attendance.php";
                        break;
                    case 'attendance-proses':
                        include "pages/master/attendance-proses.php";
                        break;
                    case 'attendance-tebet':
                        include "pages/master/attendance-tebet.php";
                        break;
                    case 'attendance-tebet-proses':
                        include "pages/master/attendance-tebet-proses.php";
                        break;
                    case 'attendance-baru':
                        include "pages/master/attendance-baru.php";
                        break;
                    case 'attendance-mitra':
                        include "pages/master/attendance-mitra.php";
                        break;
                    case 'download-form':
                        include "pages/view/download-form.php";
                        break;
                    case 'history-transaksi-cuti':
                        include "pages/master/history-transaksi-cuti.php";
                        break;
                    case 'laporan-payroll':
                        include "pages/master/laporan-payroll.php";
                        break;
                    case 'laporan-payroll-baru':
                        include "pages/master/laporan-payroll-baru.php";
                        break;
                    case 'laporan-payroll-baru-2':
                        include "pages/master/laporan-payroll-baru-2.php";
                        break;
                    case 'form-matrix-lembur':
                        include "pages/master/form-matrix-lembur.php";
                        break;
                    case 'form-edit-matrix-lembur':
                        include "pages/master/form-edit-matrix-lembur.php";
                        break;
                    case 'proses-edit-matrix-lembur':
                        include "pages/transaksi/proses-edit-matrix-lembur.php";
                        break;
                    case 'report-tahunan':
                        include "pages/master/report-tahunan.php";
                        break;
                    case 'rekap-data':
                        include "pages/master/rekap-data.php";
                        break;
                    case 'proses-rekap-data':
                        include "pages/transaksi/proses-rekap-data.php";
                        break;
                    case 'rekap-mangkir':
                        include "pages/master/rekap-mangkir.php";
                        break;
                    case 'rekap-ranking':
                        include "pages/master/rekap-ranking.php";
                        break;
                    case 'proses-rekap-ranking':
                        include "pages/transaksi/proses-rekap-ranking";
                        break;
                    case 'rekap-ranking3':
                        include "pages/master/rekap-ranking3.php";
                        break;
                    case 'proses-rekap-ranking3':
                        include "pages/transaksi/proses-rekap-ranking3";
                        break;
                    case 'form-ubah-password':
                        include "pages/master/form-ubah-password.php";
                        break;
                    case 'proses-ubah-password':
                        include "pages/transaksi/proses-ubah-password.php";
                        break;
                    case 'laporan-payroll-lama':
                        include "pages/master/laporan-payroll-lama.php";
                        break;
                    case 'proses-laporan-payroll-lama':
                        include "pages/transaksi/proses-laporan-payroll-lama.php";
                        break;
                    case 'proses-izin-backdate':
                        include "pages/transaksi/proses-izin-backdate.php";
                        break;
                    case 'view-matrix-jabatan':
                        include "pages/view/view-matrix-jabatan.php";
                        break;
                    case 'edit-matrix-jabatan':
                        include "pages/master/edit-matrix-jabatan.php";
                        break;
                    case 'proses-edit-matrix-jabatan':
                        include "pages/transaksi/proses-edit-matrix-jabatan.php";
                        break;
                    case 'form-edit-matrix-user':
                        include "pages/master/form-edit-matrix-user.php";
                        break;
                    case 'proses-edit-matrix-user':
                        include "pages/transaksi/proses-edit-matrix-user.php";
                        break;
                    case 'tambah-matrix-jabatan':
                        include "pages/transaksi/tambah-matrix-jabatan.php";
                        break;
                    case 'form-penilaian-karyawan':
                        include "pages/master/form-penilaian-karyawan.php";
                        break;
                    case 'data-jumlah-cuti':
                        include "pages/transaksi/data-jumlah-cuti.php";
                        break;
                     case 'data-hari-libur':
                        include "pages/master/data-hari-libur.php";
                        break;
                    case 'proses-penilaiian-karyawan':
                        include "pages/transaksi/proses-penilaian-karyawan.php";
                        break;
                    case 'proses-editkaryawanbaru':
                        include "pages/transaksi/proses-editkaryawanbaru.php";
                        break;
                    case 'history-data-dispensasi':
                        include "pages/view/history-data-dispensasi.php";
                        break;
                    case 'form-lembur-weekend':
                        include "pages/master/form-lembur-weekend.php";
                        break;
                    case 'proses-lembur-weekend':
                        include "pages/transaksi/proses-lembur-weekend.php";
                        break;
                    case 'history-lembur-weekend':
                        include "pages/view/history-lembur-weekend.php";
                        break;
                    case 'proses-hari-libur': 
                        include "pages/transaksi/proses-hari-libur.php"; 
                        break;
                    case 'edit-hari-libur': 
                        include "pages/transaksi/edit-hari-libur.php"; 
                        break;
                    case 'list-exit-interview': 
                        include "pages/master/list-exit-interview.php"; 
                        break;
                    default:
                        include 'dashboard.php';
                }
                ?>
            </section>
            <MARQUEE DIRECTION=LEFT>
                <h3>Pastikan cuti anda mendapatkan persetujuan, Buka <b>hconline</b> untuk memastikan.</h3>
            </MARQUEE>
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