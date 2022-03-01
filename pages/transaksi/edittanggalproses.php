<?php
//error_reporting(0);
 include ('../../dist/koneksi.php');

  $nocut=$_POST['nocut'];
  $dari=$_POST['dari'];
  $sampai=$_POST['sampai'];

  //get current month for example
  function number_of_working_days($startDate, $endDate)
  {
      $workingDays = 0;
      $startTimestamp = strtotime($startDate);
      $endTimestamp = strtotime($endDate);
      for ($i = $startTimestamp; $i <= $endTimestamp; $i = $i + (60 * 60 * 24)) {
          if (date("N", $i) <= 5) $workingDays = $workingDays + 1;
      }
      return $workingDays;
  }

  $startDate = $dari;
  $endDate = $sampai;
  $workingDays = number_of_working_days($startDate, $endDate);

  //periksa apakah udah submit
  if (isset($_POST['submit']))
  {

      $update=mysql_query("UPDATE tb_mohoncuti SET dari ='$dari', sampai ='$sampai', jml_hari='$workingDays' WHERE no_cuti='$nocut'");

      //jika sudah berhasil
      if ($update)
      {
        echo "<script language='javascript'>";
        echo "alert('Edit Tanggal Berhasil')";
        echo "</script>";
        echo "<script> document.location.href='../../home-hrd.php?page=pre-approval-cuti.php'; </script>";
      }else{
        echo "Edit Tanggal Gagal";
      }
    }

?>
