<?php
$no_cuti	= $_GET['code'];
?>

<div class='register-logo'><b>Cuti</b> Tidak Disetujui</div>
  <div class='register-box-body'>
    <p>Silahkan tulis alasan anda tidak menyetujuinya</p>
    <div class='row'>
      <div class='col-xs-1'></div>
      <div class='col-xs-5'>
<form action="home-hrd.php?page=alasanproses" method="POST">
        <div class='box-body box- profile'>
          <div class="form-group">
            <label for="usr">Alasan:</label>
            <input type="text" class="form-control" id="usr" name="alasan">
          </div>
        </div>

<input type="hidden" name="nocuti" value="<?php echo $no_cuti?>">

        <div class="form-group">
          <div class="col-sm-offset-3 col-sm-7">
            <button type="submit" name="submit" class="btn btn-danger">Kirim</button>
          </div>
        </div>

      </div>
    </div>
  </div>
