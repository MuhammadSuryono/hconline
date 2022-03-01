<?php
error_reporting(0);
session_start();
if(!isset($_SESSION['nama_user'])){
  header("location:login.php");
    // die('location:login.php');//jika belum login jangan lanjut
}


    $servername = "localhost";
    $username = "adam";
    $password = "Ad@mMR1db";
    $dbname = "budget";

    // membuat koneksi
    $koneksi = new mysqli($servername, $username, $password, $dbname);

    // melakukan pengecekan koneksi
    if ($koneksi->connect_error) {
        die("Connection failed: " . $koneksi->connect_error);
    }

    if($_POST['no'] && $_POST['waktu']) {
        $id = $_POST['no'];
        $waktu = $_POST['waktu'];

        $cekterm = "SELECT min(term) FROM bpu WHERE no ='$id' AND waktu ='$waktu' AND status='Belum Di Bayar'";
        $run_cekterm = $koneksi->query($cekterm);
        $rc = mysqli_fetch_assoc($run_cekterm);
        $minterm = $rc['min(term)'];

        // mengambil data berdasarkan id
        // dan menampilkan data ke dalam form modal bootstrap
        $sql = "SELECT * FROM bpu WHERE no ='$id' AND waktu ='$waktu' AND status='Belum Di Bayar' AND term='$minterm'";
        $result = $koneksi->query($sql);
        foreach ($result as $baris) {

        ?>

        <!-- MEMBUAT FORM -->
        <form action="bayarbudgetproses.php" method="post">

        <input type="hidden" name="no" value="<?php echo $baris['no']; ?>">
        <input type="hidden" name="waktu" value="<?php echo $baris['waktu']; ?>">
        <input type="hidden" name="term" value="<?php echo $minterm; ?>">
        <input type="hidden" name="pembayar" value="<?php echo $_SESSION['nama_user'];?>">
        <input type="hidden" name="divisi" value="<?php echo $_SESSION['divisi'];?>">

        <ul class="list-group">
          <li class="list-group-item">Request BPU : <b><?php echo $baris['jumlah']; ?></b></li>
          <li class="list-group-item">Bank : <b><?php echo $baris['namabank']; ?></b></li>
          <li class="list-group-item">NO Rekening : <b><?php echo $baris['norek']; ?></b></li>
          <li class="list-group-item">Nama Penerima : <b><?php echo $baris['namapenerima']; ?></b></li>
        </ul>

        <div class="form-group">
          <label for="jumlah">Jumlah Pembayaran :</label>
          <input type="number" class="form-control" id="jumlah" name="jumlahbayar">
        </div>

        <div class="form-group">
          <label for="nomorvoucher">Nomor Voucher :</label>
          <input type="text" class="form-control" id="nomorvoucher" name="nomorvoucher">
        </div>

        <div class="form-group">
          <label for="tanggal">Tanggal Pembayaran:</label>
          <input type="date" class="form-control" id="tanggal" name="tanggalbayar">
        </div>

          <button class="btn btn-primary" type="submit" name="submit">Bayar</button>
        </form>

      <?php } }
    $koneksi->close();
?>
