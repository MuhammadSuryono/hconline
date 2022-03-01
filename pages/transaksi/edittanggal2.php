<?php
    $servername = "localhost";
    $username = "adam";
    $password = "Ad@mMR1db";
    $dbname = "db_cuti";

    // membuat koneksi
    $koneksi = new mysqli($servername, $username, $password, $dbname);

    // melakukan pengecekan koneksi
    if ($koneksi->connect_error) {
        die("Connection failed: " . $koneksi->connect_error);
    }

    if($_POST['rowid']) {
        $id = $_POST['rowid'];
        // mengambil data berdasarkan id
        // dan menampilkan data ke dalam form modal bootstrap
        $sql = "SELECT * FROM tb_mohoncuti WHERE no_cuti = $id";
        $result = $koneksi->query($sql);
        foreach ($result as $baris) { ?>

        <!-- MEMBUAT FORM -->
        <form action="pages/transaksi/edittanggalproses2.php" method="post">
            <input type="hidden" name="nocut" value="<?php echo $baris['no_cuti']; ?>">

                Nama : <?php echo $baris['nama']; ?><br>
                Divisi : <?php echo $baris['divisi']; ?><br>
                Dari Tanggal : <?php echo $baris['dari']; ?><br>
                Sampai Tanggal : <?php echo $baris['sampai']; ?><br>
                Jumlah Hari : <?php echo $baris['jml_hari']; ?> Hari<br>

                <h3>Edit Tanggal</h3>

                <div class="form-group">
                  <label for="focusedinput" class="col-sm-3 control-label">Dari Tanggal :</label>
                    <input placeholder="<?php echo $baris['dari']; ?>" class="textbox-n form-control" type="text" onfocus="(this.type='date')"  id="date" name="dari">
                </div>

                <div class="clearfix"></div>

                <div class="form-group">
                  <label for="focusedinput" class="col-sm-3 control-label">Sampai Tanggal :</label>
                    <input placeholder="<?php echo $baris['sampai']; ?>" class="textbox-n form-control" type="text" onfocus="(this.type='date')"  id="date" name="sampai">
                </div>


              <button class="btn btn-primary" type="submit" name="submit">EDIT</button>
        </form>

        <?php } }
    $koneksi->close();
?>
