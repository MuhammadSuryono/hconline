<?php
date_default_timezone_set("Asia/Bangkok");

if ($_POST['save'] == "save") {

  function kdauto($tabel, $inisial){
    $struktur   = mysql_query("SELECT * FROM $tabel");
    $field      = mysql_field_name($struktur,0);
    $panjang    = mysql_field_len($struktur,0);
    $qry  = mysql_query("SELECT max(".$field.") FROM ".$tabel);
    $row  = mysql_fetch_array($qry);
    if ($row[0]=="") {
    $angka=0;
    }
    else {
    $angka= substr($row[0], strlen($inisial));
    }
    $angka++;
    $angka      =strval($angka);
    $tmp  ="";
    for($i=1; $i<=($panjang-strlen($inisial)-strlen($angka)); $i++) {
    $tmp=$tmp."0";
    }
    return $inisial.$tmp.$angka;
  }

  $no	=kdauto("tb_izin","");
  $id_user      = $_POST['id_user'];
  $jenis        = $_POST['jenis'];

  $temp = explode(".", $_FILES["gambar"]["name"]);
  $newfilename = round(microtime(true)) . '.' . end($temp);
  move_uploaded_file($_FILES["gambar"]["tmp_name"], "./izin/" . $newfilename);

  // $nama_gambar  = $_FILES['gambar']['name'];
  // $lokasi       = $_FILES['gambar']['tmp_name']; // Menyiapkan tempat nemapung gambar yang diupload
  // $lokasitujuan = "./izin"; // Menguplaod gambar kedalam folder ./image
  // $upload       = move_uploaded_file($lokasi,$lokasitujuan."/".$nama_gambar);

  $keterangan   = $_POST['keterangan'];
  $latitude     = $_POST['latitude'];
  $longitude    = $_POST['longitude'];
  // $tanggal      = date("Y-m-d");
  $tanggal      = $_POST['tanggal'];
  $jamnya       = date("H:i:s");

  if(!empty($_POST['latitude']) && !empty($_POST['longitude'])){


  $selectnama = mysql_query("SELECT * FROM tb_user WHERE id_user='$id_user'");
  $sn = mysql_fetch_assoc($selectnama);
  $namanya  = $sn['nama_user'];
  $divisi   = $sn['divisi'];
  $id_absen = $sn['id_absen'];

  if($sn['hak_akses'] == 'Pegawai') {
    $home = "home-pegawai.php";
  }
  else if($sn['hak_akses'] == 'Manager'){
    $home = "home-manager.php";
  }
  else if($sn['hak_akses'] == 'HRD'){
    $home = "home-hrd.php";
  }
  else {
    $home = "home-pegawai2.php";
  }

    function getAddress($latitude,$longitude){
    if(!empty($latitude) && !empty($longitude)){
        //Send request and receive json data by address
        $geocodeFromLatLong = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?latlng='.$latitude.','.$longitude.'&sensor=false&key=AIzaSyDMfprTACdgY3kZ_M1hRP5j_1gbxLRXrYs');
        $output = json_decode($geocodeFromLatLong);
        $status = $output->status;
        //Get address from json data
        $address = ($status=="OK")?$output->results[1]->formatted_address:'';
        //Return address of the given latitude and longitude
        if(!empty($address)){
            return $address;
        }else{
            return false;
        }
    }else{
        return false;
    }
  }

  $address    = getAddress($latitude,$longitude);
  $address    = $address?$address:'Not found';


  $carilatlong = mysql_query("SELECT
                                    	*
                                    FROM
                                    	tb_izin
                                    WHERE
                                    	nip = '$id_user'
                                    AND tgl = '$tanggal'
                                    AND latitude = '$latitude'
                                    AND longitude = '$longitude'
                                    AND jamnya = (
                                    	SELECT
                                    		MAX(jamnya)
                                    	FROM
                                    		tb_izin
                                    	WHERE
                                    		nip = '$id_user'
                                    	AND tgl = '$tanggal'
                                    	AND latitude = '$latitude'
                                    	AND longitude = '$longitude')");


  if (mysql_num_rows($carilatlong)==0){

    $masukin = mysql_query("INSERT INTO tb_izin (no,nip,nama,divisi,tgl,dari,sampai,jml_hari,jenis,gambar,persetujuan,jamnya,latitude,longitude,keterangan,alamat)
                              VALUES ('$no','$id_user','$namanya','$divisi','$tanggal','$tanggal','$tanggal','1','$jenis','$newfilename','','$jamnya','$latitude','$longitude','$keterangan','$address')");

    $masukdurasi = mysql_query("INSERT INTO durasitugasdinas (nip,tanggal,latitude,longitude,durasi,alamat) VALUES ('$id_user','$tanggal','$latitude','$longitude','0','$address')");

    $masukdaterange = mysql_query("INSERT INTO daterange_izin (no_izin,username,tanggal,jenis,persetujuan,gambar,id_absen) VALUES ('$no','$id_user','$tanggal','$jenis','','$newfilename','$id_absen')");

  }else{

    $cll = mysql_fetch_assoc($carilatlong);
    $jampertama = $cll['jamnya'];
    $jamkedua   = $jamnya;
    $pertamajam = strtotime($jampertama);
    $keduajam   = strtotime($jamkedua);
    $selisihjam = $keduajam - $pertamajam;

    $masukin = mysql_query("INSERT INTO tb_izin (no,nip,nama,divisi,tgl,dari,sampai,jml_hari,jenis,gambar,persetujuan,jamnya,latitude,longitude,keterangan,alamat)
                              VALUES ('$no','$id_user','$namanya','$divisi','$tanggal','$tanggal','$tanggal','1','$jenis','$newfilename','','$jamnya','$latitude','$longitude','$keterangan','$address')");

    $masukdurasi = mysql_query("UPDATE durasitugasdinas SET durasi = (durasi + $selisihjam) WHERE nip='$id_user' AND tanggal='$tanggal' AND latitude='$latitude' AND longitude='$longitude'");

  }

    if ($masukin && $masukdurasi && $masukdaterange){

      echo "<div class='register-logo'><b>Input Form Tugas/Dinas Sukses!</b>.</div>
        <div class='box box-primary'>
          <div class='register-box-body'>
            <p>Form Tugas/Dinas berhasil di ajukan, harap minta persetujuan kepada manager divisi terkait.</p>
            <div class='row'>
              <div class='col-xs-8'></div>
              <div class='col-xs-4'>
                <button type='button' onclick=location.href='$home?page=history-izin-pegawai' class='btn btn-block btn-warning'>Next</button>
              </div>
            </div>
          </div>
        </div>";
    }

    else{

      echo "<div class='register-logo'><b>Input Form Tugas/Dinas GAGAL!</b>.</div>
        <div class='box box-primary'>
          <div class='register-box-body'>
            <p>Terjadi kesalahan, harap coba lagi!!</p>
            <div class='row'>
              <div class='col-xs-8'></div>
              <div class='col-xs-4'>
                <button type='button' onclick=location.href='$home?page=form-tugas-dinas' class='btn btn-block btn-warning'>Next</button>
              </div>
            </div>
          </div>
        </div>";

    }

  }
  else{
    echo "<div class='register-logo'><b>Input Form Tugas/Dinas GAGAL!</b>.</div>
      <div class='box box-primary'>
        <div class='register-box-body'>
          <p>Latitud dan longitude tidak boleh kosong, klik GET MAPS untuk mendapatkan koordinat maps.</p>
          <div class='row'>
            <div class='col-xs-8'></div>
            <div class='col-xs-4'>
              <button type='button' onclick=location.href='$home?page=form-tugas-dinas' class='btn btn-block btn-warning'>Next</button>
            </div>
          </div>
        </div>
      </div>";
  }

}
?>
