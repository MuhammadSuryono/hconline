<?php

$servername = "localhost";
$username = "adam";
$password = "Ad@mMR1db";
$dbname = "mri_rekrutmen_ci2";
$dbname2 = "db_cuti";

// membuat koneksi
$koneksi = new mysqli($servername, $username, $password, $dbname);
$keneksi2 = new mysqli($servername, $username, $password, $dbname2);

// melakukan pengecekan koneksi
if ($koneksi->connect_error) {
    die("Connection failed: " . $koneksi->connect_error);
}

$no_reg         = $_POST['no_reg'];
$nik            = $_POST['nik'];
$jabatan        = $_POST['jabatan'];
$divisi         = $_POST['divisi'];
$kontrakdari    = $_POST['kontrakdari'];
$kontraksampai  = $_POST['kontraksampai'];
$rekeningmandiri= $_POST['rekeningmandiri'];
$npwp           = $_POST['npwp'];
$bpjstk         = $_POST['bpjstk'];
$bpjskes        = $_POST['bpjskes'];

if (isset($_POST['submit'])){

  $update = $koneksi->query("UPDATE data_user
                                SET nik = '$nik',
                                 jabatan = '$jabatan',
                                 divisi = '$divisi',
                                 kontrakdari = '$kontrakdari',
                                 kontraksampai = '$kontraksampai',
                                 rekeningmandiri = '$rekeningmandiri',
                                 npwp = '$npwp',
                                 bpjstk = '$npwp',
                                 bpjskes = '$bpjskes'
                                WHERE
                                	no_reg = '$no_reg'");

  if($update){
    echo "<div class='register-logo'><b>Edit Karyaawan Sukses!</b>.</div>
      <div class='box box-primary'>
        <div class='register-box-body'>
          <p>Edit Karyawan masuk di payroll berhasil</p>
          <div class='row'>
            <div class='col-xs-8'></div>
            <div class='col-xs-4'>
              <button type='button' onclick=location.href='home-hrd.php?page=laporan-payroll' class='btn btn-block btn-warning'>Next</button>
            </div>
          </div>
        </div>
      </div>";
  }

}

?>
