<?php
if ($_POST['save'] == "save") {
$tgl = 1;
$bulan = $_POST['bulan'];
$tahun = 2018;
?>

<section class="content-header">
    <h1>Attendance<small>Karyawan</small></h1>
    <ol class="breadcrumb">
        <li><a href="home-hrd.php"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="active">Attendance Karyawan</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
			<div class="box box-primary">
				<div class="box-body">
					<div>
					</div>
          <?php
          if($_POST['bulan'] == '01'){
            $namabulan = "Januari";
          }else if($_POST['bulan'] == '02'){
            $namabulan = "Febuari";
          }else if($_POST['bulan'] == '03'){
            $namabulan = "Maret";
          }else if($_POST['bulan'] == '04'){
            $namabulan = "April";
          }else if($_POST['bulan'] == '05'){
            $namabulan = "Mei";
          }else if($_POST['bulan'] == '06'){
            $namabulan = "Juni";
          }else if($_POST['bulan'] == '07'){
            $namabulan = "Juli";
          }else if($_POST['bulan'] == '08'){
            $namabulan = "Agustus";
          }else if($_POST['bulan'] == '09'){
            $namabulan = "September";
          }else if($_POST['bulan'] == '10'){
            $namabulan = "Oktober";
          }else if($_POST['bulan'] == '11'){
            $namabulan = "November";
          }else{
            $namabulan = "Desember";
          }
          ?>
          <h3>Attendance SOHO <?php echo $namabulan; ?> 2018</h3>
          <div class="table-responsive">
					<table id="example1" class="table table-bordered table-striped">
            <thead>
              <?php
              $jumtgl = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
              ?>
              <tr>
              <?php
              $sql = mysql_query("SELECT A.USERID as nip, A.name as nama,
            				group_concat(A.1) as '1', group_concat(A.2) as '2',
            				group_concat(A.3) as '3', group_concat(A.4) as '4',
            				group_concat(A.5) as '5', group_concat(A.6) as '6',
            				group_concat(A.7) as '7', group_concat(A.8) as '8',
            				group_concat(A.9) as '9', group_concat(A.10) as '10',
            				group_concat(A.11) as '11', group_concat(A.12) as '12',
            				group_concat(A.13) as '13', group_concat(A.14) as '14',
            				group_concat(A.15) as '15', group_concat(A.16) as '16',
            				group_concat(A.17) as '17', group_concat(A.18) as '18',
            				group_concat(A.19) as '19', group_concat(A.20) as '20',
            				group_concat(A.21) as '21', group_concat(A.22) as '22',
            				group_concat(A.23) as '23', group_concat(A.24) as '24',
            				group_concat(A.25) as '25', group_concat(A.26) as '26',
            				group_concat(A.27) as '27', group_concat(A.28) as '28',
            				group_concat(A.29) as '29', group_concat(A.30) as '30',
            				group_concat(A.31) as '31'
            				from v_monthly_report as A
            				WHERE MONTH(tanggal) = '".$bulan."' AND YEAR(tanggal) = '".$tahun."' GROUP BY USERID");


              ?>
                <th>No</th>
                <th>UserID</th>
                <th>Nama Pegawai</th>

              <?php
              while($tgl <= $jumtgl){
                echo "<th><b>".$tgl."</b></th>";
                $tgl++;
              }
              ?>
              </tr>
            </thead>

            <tbody>
                <?php
                $no = 1;

                while ($isi = mysql_fetch_array($sql)){

                echo "<tr>
      						<td>".$no."</td>
      						<td>".$isi['nip']."</td>
      						<td valign='top' style='white-space:nowrap'>".$isi['nama']."</td>";

                  if ($isi['1'] == NULL) {
                    $cektanggal1 = ($tahun.'-'.$bulan.'-'."1");
                    $tesuserid = $isi['nip'];
                    $cek1 = mysql_query("SELECT jenis,DATE(dari) as dari
                                          FROM tb_mohoncuti
                                          WHERE dari='$cektanggal1' AND nip='$tesuserid'");
                    $d1 = mysql_num_rows($cek1);
                    $d11 = mysql_fetch_assoc($cek1);
                    $d111 = $d11['jenis'];
                        if ($d1 > 0){
                            echo "<td>".$d111."</td>";
                        }
                        else {
      						       echo "<td bgcolor='#FF0000'>".$cektanggal1."</td>";
                        }
                  }
                  else {
                    $coba1 = explode(',', $isi['1']);
        						echo "<td>".current($coba1)." --- ".end($coba1)."</td>";
                  }


                  if ($isi['2'] == NULL) {
                    $cektanggal2 = ($tahun.'-'.$bulan.'-'."2");
                    $tesuserid = $isi['nip'];
                    $cek2 = mysql_query("SELECT jenis,DATE(dari) as dari
                                          FROM tb_mohoncuti
                                          WHERE dari='$cektanggal2' AND nip='$tesuserid'");
                    $d2 = mysql_num_rows($cek2);
                    $d22 = mysql_fetch_assoc($cek2);
                    $d222 = $d22['jenis'];
                        if ($d2 > 0){
                            echo "<td>".$d222."</td>";
                        }
                        else {
      						       echo "<td bgcolor='#FF0000'>".$cektanggal2."</td>";
                        }
                  }
                  else {
                    $coba2 = explode(',', $isi['2']);
        						echo "<td>".current($coba2)." --- ".end($coba2)."</td>";
                  }


                  if ($isi['3'] == NULL) {
                    $cektanggal3 = ($tahun.'-'.$bulan.'-'."3");
                    $tesuserid = $isi['nip'];
                    $cek3 = mysql_query("SELECT jenis,DATE(dari) as dari
                                          FROM tb_mohoncuti
                                          WHERE dari='$cektanggal3' AND nip='$tesuserid'");
                    $d3 = mysql_num_rows($cek3);
                    $d33 = mysql_fetch_assoc($cek3);
                    $d333 = $d33['jenis'];
                        if ($d3 > 0){
                            echo "<td>".$d333."</td>";
                        }
                        else {
      						       echo "<td bgcolor='#FF0000'>".$cektanggal3."</td>";
                        }
                  }
                  else {
                    $coba3 = explode(',', $isi['3']);
        						echo "<td>".current($coba3)." --- ".end($coba3)."</td>";
                  }

                  if ($isi['4'] == NULL) {
                    $cektanggal4 = ($tahun.'-'.$bulan.'-'."4");
                    $tesuserid = $isi['nip'];
                    $cek4 = mysql_query("SELECT jenis,DATE(dari) as dari
                                          FROM tb_mohoncuti
                                          WHERE dari='$cektanggal4' AND nip='$tesuserid'");
                    $d4 = mysql_num_rows($cek4);
                    $d44 = mysql_fetch_assoc($cek4);
                    $d444 = $d44['jenis'];
                        if ($d4 > 0){
                            echo "<td>".$d444."</td>";
                        }
                        else {
      						       echo "<td bgcolor='#FF0000'>".$cektanggal4."</td>";
                        }
                  }
                  else {
                    $coba4 = explode(',', $isi['4']);
        						echo "<td>".current($coba4)." --- ".end($coba4)."</td>";
                  }

                  if ($isi['5'] == NULL) {
                    $cektanggal5 = ($tahun.'-'.$bulan.'-'."5");
                    $tesuserid = $isi['nip'];
                    $cek5 = mysql_query("SELECT jenis,DATE(dari) as dari
                                          FROM tb_mohoncuti
                                          WHERE dari='$cektanggal5' AND nip='$tesuserid'");
                    $d5 = mysql_num_rows($cek5);
                    $d55 = mysql_fetch_assoc($cek5);
                    $d555 = $d55['jenis'];
                        if ($d5 > 0){
                            echo "<td>".$d555."</td>";
                        }
                        else {
      						       echo "<td bgcolor='#FF0000'>".$cektanggal5."</td>";
                        }
                  }
                  else {
                    $coba5 = explode(',', $isi['5']);
        						echo "<td>".current($coba5)." --- ".end($coba5)."</td>";
                  }

                  $cektanggal6 = ($tahun.'-'.$bulan.'-'."6");
                  if ($isi['6'] == NULL) {
                    $tesuserid = $isi['nip'];
                    $cek6 = mysql_query("SELECT jenis,DATE(dari) as dari
                                          FROM tb_mohoncuti
                                          WHERE dari='$cektanggal6' AND nip='$tesuserid'");
                    $d6 = mysql_num_rows($cek6);
                    $d66 = mysql_fetch_assoc($cek6);
                    $d666 = $d66['jenis'];
                        if ($d6 > 0){
                            echo "<td>".$d666."</td>";
                        }
                        else {
      						       echo "<td bgcolor='#FF0000'>".$cektanggal6."</td>";
                        }
                  }
                  else if(date('D', strtotime($cektanggal6)) == 'Sat' || date('D', strtotime($cektanggal6)) == 'Sun') {
                    echo "<td>Weekend</td>";
                  }
                  else {
                    $coba6 = explode(',', $isi['6']);
        						echo "<td>".current($coba6)." --- ".end($coba6)."</td>";
                  }

      						$coba7 = explode(',', $isi['7']);
      						echo "<td>".current($coba7)." --- ".end($coba7)."</td>";

      						$coba8 = explode(',', $isi['8']);
      						echo "<td>".current($coba8)." --- ".end($coba8)."</td>";

      						$coba9 = explode(',', $isi['9']);
      						echo "<td>".current($coba9)." --- ".end($coba9)."</td>";

      						$coba10 = explode(',', $isi['10']);
      						echo "<td>".current($coba10)." --- ".end($coba10)."</td>";

      						$coba11 = explode(',', $isi['11']);
      						echo "<td>".current($coba11)." --- ".end($coba11)."</td>";

      						$coba12 = explode(',', $isi['12']);
      						echo "<td>".current($coba12)." --- ".end($coba12)."</td>";

      						$coba13 = explode(',', $isi['13']);
      						echo "<td>".current($coba13)." --- ".end($coba13)."</td>";

      						$coba14 = explode(',', $isi['14']);
      						echo "<td>".current($coba14)." --- ".end($coba14)."</td>";

      						$coba15 = explode(',', $isi['15']);
      						echo "<td>".current($coba15)." --- ".end($coba15)."</td>";

      						$coba16 = explode(',', $isi['16']);
      						echo "<td>".current($coba16)." --- ".end($coba16)."</td>";

      						$coba17 = explode(',', $isi['17']);
      						echo "<td>".current($coba17)." --- ".end($coba17)."</td>";

      						$coba18 = explode(',', $isi['18']);
      						echo "<td>".current($coba18)." --- ".end($coba18)."</td>";

      						$coba19 = explode(',', $isi['19']);
      						echo "<td>".current($coba19)." --- ".end($coba19)."</td>";

      						$coba20 = explode(',', $isi['20']);
      						echo "<td>".current($coba20)." --- ".end($coba20)."</td>";

      						$coba21 = explode(',', $isi['21']);
      						echo "<td>".current($coba21)." --- ".end($coba21)."</td>";

      						$coba22 = explode(',', $isi['22']);
      						echo "<td>".current($coba22)." --- ".end($coba22)."</td>";

      						$coba23 = explode(',', $isi['23']);
      						echo "<td>".current($coba23)." --- ".end($coba23)."</td>";

      						$coba24 = explode(',', $isi['24']);
      						echo "<td>".current($coba24)." --- ".end($coba24)."</td>";

      						$coba25 = explode(',', $isi['25']);
      						echo "<td>".current($coba25)." --- ".end($coba25)."</td>";

      						$coba26 = explode(',', $isi['26']);
      						echo "<td>".current($coba26)." --- ".end($coba26)."</td>";

      						$coba27 = explode(',', $isi['27']);
      						echo "<td>".current($coba27)." --- ".end($coba27)."</td>";

      						$coba28 = explode(',', $isi['28']);
      						$coba29 = explode(',', $isi['29']);
      						$coba30 = explode(',', $isi['30']);
      						$coba31 = explode(',', $isi['31']);

      						switch ($jumtgl) {

      						case 28:
      						echo "<td>".current($coba28)." --- ".end($coba28)."</td>";
      							break;

      						case 29:
      							echo "<td>".current($coba28)." --- ".end($coba28)."</td>
      								    <td>".current($coba29)." --- ".end($coba29)."</td>";
      							break;

      						case 30:
      							echo "<td>".current($coba28)." --- ".end($coba28)."</td>
      									 	<td>".current($coba29)." --- ".end($coba29)."</td>
      										<td>".current($coba30)." --- ".end($coba30)."</td>";
      							break;

      						case 31:
      						echo "<td>".current($coba28)." --- ".end($coba28)."</td>
      									<td>".current($coba29)." --- ".end($coba29)."</td>
      									<td>".current($coba30)." --- ".end($coba30)."</td>
      									<td>".current($coba31)." --- ".end($coba31)."</td>";
      							break;
      						default:
      							//nothing
      							break;
      				}
      					echo "</tr>";
      					$no++;

              } }?>
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
