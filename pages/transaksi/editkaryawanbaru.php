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

    if($_POST['noreg']) {
        $noreg = $_POST['noreg'];

        // mengambil data berdasarkan id
        // dan menampilkan data ke dalam form modal bootstrap
        $sql = "SELECT * FROM data_user WHERE no_reg = '$noreg'";
        $result = $koneksi->query($sql);
        foreach ($result as $baris) {

        ?>

        <!-- MEMBUAT FORM -->
        <form method="POST" action="home-hrd.php?page=proses-editkaryawanbaru">
            <input type="hidden" name="no_reg" value="<?php echo $baris['no_reg']; ?>">

            <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" id="nama" class="form-control" placeholder="<?php echo $baris['nama']; ?>" disabled>
            </div>

            <div class="form-group">
                <label for="jabatan">NIK</label>
                <input type="text" name="nik" class="form-control" value="<?php echo $baris['nik']; ?>">
            </div>

            <div class="form-group">
                <label for="jabatan">Jabatan</label>
                <input type="text" name="jabatan" class="form-control" value="<?php echo $baris['jabatan']; ?>">
            </div>

            <div class="form-group">
                <label for="divisi">Divisi</label>
                <select class="form-control form-control-user" id="divisi" name="divisi">
                  <option value="<?php echo $baris['divisi']; ?>" selected><?php echo $baris['divisi']; ?></option>
                  <?php
                  $caridiv = $keneksi2->query("SELECT divisi from tb_user GROUP BY divisi ORDER BY divisi ASC");
                  while ($cv = mysqli_fetch_array($caridiv)){
                  ?>
                  <option value="<?php echo $cv['divisi']; ?>"><?php echo $cv['divisi']; ?></option>
                  <?php
                  }
                  ?>
                </select>
            </div>

            <div class="form-group">
                <label for="jabatan">Kontrak Dari</label>
                <input type="date" name="kontrakdari" class="form-control" value="<?php echo $baris['kontrakdari']; ?>">
            </div>

            <div class="form-group">
                <label for="jabatan">Kontrak Sampai Dengan</label>
                <input type="date" name="kontraksampai" class="form-control" value="<?php echo $baris['kontraksampai']; ?>">
            </div>

            <div class="form-group">
                <label for="jabatan">Rekening Mandiri</label>
                <input type="text" name="rekeningmandiri" class="form-control" value="<?php echo $baris['rekeningmandiri']; ?>">
            </div>

            <div class="form-group">
                <label for="jabatan">NPWP</label>
                <input type="text" name="npwp" class="form-control" value="<?php echo $baris['npwp']; ?>">
            </div>

            <div class="form-group">
                <label for="jabatan">BPJS TK</label>
                <input type="text" name="bpjstk" class="form-control" value="<?php echo $baris['bpjstk']; ?>">
            </div>

            <div class="form-group">
                <label for="jabatan">BPJS Kes</label>
                <input type="text" name="bpjskes" class="form-control" value="<?php echo $baris['bpjskes']; ?>">
            </div>

          <button type="submit" class="btn btn-success" name="submit">Submit</button>
        </form>

      <?php } }
    $koneksi->close();
?>


<script>
function sum() {
      var txtSecondNumberValue = document.getElementById('harga').value;
      var txtTigaNumberValue = document.getElementById('quantity').value;
      var result = parseFloat(txtSecondNumberValue) * parseFloat(txtTigaNumberValue);
      if (!isNaN(result)) {
         document.getElementById('total').value = result;
      }
}
</script>
