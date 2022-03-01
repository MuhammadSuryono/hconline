<?php
include "dist/koneksi.php";

if (isset($_POST['submit'])){

$jabatan        = $_POST['jabatan'];
$rupiahlembur   = $_POST['rupiahlembur'];
$rupiahpotongan = $_POST['rupiahpotongan'];


  $insert = mysql_query("INSERT INTO matrixjabatan (jabatan,rupiahlembur,rupiahpotongan) VALUES ('$jabatan','$rupiahlembur','$rupiahpotongan')");


  if ($insert){
    echo "<div class='register-logo'><b>Input Matrix Jabatan Sukses!</b>.</div>
      <div class='box box-primary'>
        <div class='register-box-body'>
          <p>Data Matrix jabatan berhasil di input.</p>
          <div class='row'>
            <div class='col-xs-8'></div>
            <div class='col-xs-4'>
              <button type='button' onclick=location.href='home-hrd.php?page=view-matrix-jabatan' class='btn btn-block btn-warning'>Next</button>
            </div>
          </div>
        </div>
      </div>";
  }else{
    echo "<script language='javascript'>";
    echo "alert('Input gagal!! Ulangi atau hubungi administrator!!')";
    echo "</script>";
    echo "<script> document.location.href='home-hrd.php?page=view-matrix-jabatan'; </script>";
  }
}

 ?>
