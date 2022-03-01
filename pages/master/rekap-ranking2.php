<div class="x_panel" style="">
    <div class="x_content">
        <div class="well" style="overflow: auto">
            <?php
                $lvl = isset($_SESSION['hak_akses']) != "" ? $_SESSION['hak_akses'] : "" ;
                if ($lvl == 'HRD') {
                    $link = "home-hrd.php";
                }else {
                    $link = "home-admin.php";
                }
            ?>
              <form class="form-inline" action="<?php echo $link; ?>?page=rekap-ranking2&hal=1" method="POST">

                <?php
                $pilihtanggal = mysql_query("SELECT DATE(tanggalmulai) as tanggalmulai, DATE(tanggalakhir) AS tanggalakhir FROM tanggal_mulaiakhir");
                $pt = mysql_fetch_assoc($pilihtanggal);
                $mulai = $pt['tanggalmulai'];
                $akhir = $pt['tanggalakhir'];
                ?>

                <div class="form-group">
                  <label for="email">Dari Tanggal :</label>
                  <input type="date" class="form-control" name="daritgl" value="<?php echo date($mulai); ?>">
                </div>

                <div class="form-group">
                  <label for="pwd">Sampai :</label>
                  <input type="date" class="form-control" name="sampaitgl" value="<?php echo date($akhir); ?>">
                </div>

                <div class="form-group">
                  <label class="checkbox-inline"><input type="checkbox" value="Cuti" name="cuti">Cuti</label>
                  <label class="checkbox-inline"><input type="checkbox" value="SDSD" name="sdsd">SDSD</label>
                  <label class="checkbox-inline"><input type="checkbox" value="STSD" name="stsd">STSD</label>
                  <label class="checkbox-inline"><input type="checkbox" value="Unpaid" name="unpaid">Unpaid</label>
                  <label class="checkbox-inline"><input type="checkbox" value="Mangkir" name="mangkir">Mangkir</label>
                </div>

                <button type="submit" class="btn btn-success" name="submit">Submit</button>
              </form>

            </form>
        </div>
    </div>
</div>

<?php

if (isset($_POST['submit'])){

include "pages/transaksi/isi.php";

}else{


}

 ?>
