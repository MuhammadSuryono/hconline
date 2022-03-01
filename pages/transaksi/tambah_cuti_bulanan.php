<?php
$servername = "localhost";
$username = "adam";
$password = "Ad@mMR1db";
$dbname = "db_cuti";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
} 
//Tambah cuti per bulan
// include "dist/koneksi.php";
     $tahun = date('Y');

     // $query = "SELECT * FROM tb_jumlahcuti WHERE tahun='$tahun'";
     $query = "SELECT * FROM tb_jumlahcuti WHERE tahun='$tahun' ORDER BY id DESC LIMIT 1";

     $exe = mysqli_query($conn, $query);
     $qry = mysqli_fetch_array($exe);

     $avg_cuti = $qry['cuti_perbulan'];
     // $cuti_diperoleh = $qry['cuti_diperoleh'];
     // $cuti_bersama = $qry['cuti_bersama'];
     // $jumlahbulan = 12 ;

     // $avg = ($cuti_diperoleh - $cuti_bersama)/$jumlahbulan;
     // $avg_cuti = round($avg,2);
     $datenow = date('Y-m-d');

     if(date('m') == '02')
     {
      $pemindahanCuti ="UPDATE tb_pegawai
        SET hak_cuti_tahunlalu = hak_cuti_tahunan, hak_cuti_tahunan = '0.00'";

       mysqli_query($conn, $pemindahanCuti); 

     }

$tambahCuti ="UPDATE tb_pegawai
				SET hak_cuti_tahunan = hak_cuti_tahunan + '$avg_cuti'
				WHERE 
				IF( DATEDIFF('$datenow', tgl_masuk ) >=365, 1, 0 )
				AND ('$datenow' <= tgl_habis_kontrak OR tgl_habis_kontrak IS NULL)";

  if (date('m') == '07') {
    $cuti_tahunlalu = "UPDATE tb_pegawai
                        SET hak_cuti_tahunlalu_backup = hak_cuti_tahunlalu, hak_cuti_tahunlalu = '0.00'
                        ";
    mysqli_query($conn, $cuti_tahunlalu); 
  }

// $tambahCuti ="UPDATE tb_pegawai
// 				SET hak_cuti_tahunan = hak_cuti_tahunan + 0.75
// 				WHERE nip IN (
// 				'998'
// 				-- 'dedesoleman',
// 				-- 'Kharizma',
// 				-- 'thedyhermawan',
// 				-- 'farid',
// 				-- 'Accounting',
// 				-- '159',
// 				-- 'Jaury',
// 				-- 'ibenk',
// 				-- 'dyah',
// 				-- '918',
// 				-- 'Ribka',
// 				-- 'rizal',
// 				-- 'alnik',
// 				-- 'galihhedy',
// 				-- 'Lya',
// 				-- 'meinariclaudia',
// 				-- 'hudi',
// 				-- '935',
// 				-- 'siswanto',
// 				-- 'icha'
// 				)";

if (mysqli_query($conn, $tambahCuti)) {
  echo "Record updated successfully";
} else {
  echo "Error updating record: " . mysqli_error($conn);
}


mysqli_close($conn);

// 998	hendra
// dedesoleman Dede Soleman
// Kharizma	Kharizma Arivianti
// thedyhermawan	Tedi Hermawan
// farid	Farid Nuranshory
// Accounting	Sri Dewi Marpaung
// 159	Ika Hendarwati
// Jaury	Jaury Jihanes P Tehupeiory
// ibenk	Bambang Agus Surono
// dyah	Dyah Dewi Arumi
// 918		Guruh Dwi Anggoro
// Ribka	Ribka Amanda
// rizal	Rizal Hanif Husain
// alnik	Alyssa Nikita Putri
// galihhedy	Galih Hedy Saputra
// Lya	Kharisma Aprillya
// meinariclaudia	Meinari Claudia Mamengko
// hudi	M Hudi
// 935	Sukanti
// Intan Pertiwi (belum ada di hc online)
// siswanto	Siswanto
// icha	Chairunnisya
?>

