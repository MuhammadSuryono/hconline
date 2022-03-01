<?php
//error_reporting(0);
include "dist/koneksi.php";

if (isset($_POST['submit']))

{

$no_cuti	= $_POST['nocuti'];
$alasan = $_POST['alasan'];

$updatelagi = mysql_query("UPDATE tb_mohoncuti SET alasan='$alasan' WHERE no_cuti='$no_cuti'");

if($updatelagi){
  echo "<div class='register-logo'><b>Permohonan cuti</b> tidak disetujui</div>
    <div class='register-box-body'>
      <p>Silahkan lihat history cuti</p>
      <div class='row'>
        <div class='col-xs-8'></div>
        <div class='col-xs-4'>
          <button type='button' onclick=location.href='home-manager.php?page=pre-approval-cuti2' class='btn btn-danger btn-block btn-flat'>Next >></button>
        </div>
      </div>
    </div>";
  }
  else {

  echo "<div class='register-logo'><b>Oops!</b> 404 Error Server.</div>";

  }
  }

?>
