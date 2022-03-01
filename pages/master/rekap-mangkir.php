
<h3>Data Mangkir yang di potong cuti</h3>
<div class="table-responsive">
<table id="example1" class="table table-bordered table-striped">
  <thead>
    <tr>
      <th>No</th>
      <th>Nama</th>
      <td>Tanggal</th>
      <th>Jumlah Pemotongan</th>
      <th>Jenis Pemotongan</th>
    </tr>
  </thead>
  <tbody>
      <?php
      $i = 1;
      $daftaruser = mysql_query("SELECT * FROM tb_mangkir WHERE jenis='Pemotongan Cuti' ORDER BY tanggal DESC");
      while ($du = mysql_fetch_array($daftaruser)){
      ?>
      <tr>
        <td><?php echo $i++; ?></td>
        <td><?php echo $du['nama']; ?></td>
        <td><?php echo $du['tanggal']; ?></td>
        <td><?php echo $du['pemotongan']; ?> Hari</td>
        <td>Mangkir potong cuti</td>
      </tr>
      <?php
      }
      ?>
  </tbody>
</table>
</div>


<br/><br/><br/>



<h3>Data Mangkir yang di tidak potong cuti</h3>
<div class="table-responsive">
<table id="example2" class="table table-bordered table-striped">
  <thead>
    <tr>
      <th>No</th>
      <th>Nama</th>
      <td>Tanggal</th>
      <th>Jumlah Pemotongan</th>
      <th>Jenis Pemotongan</th>
    </tr>
  </thead>
  <tbody>
      <?php
      $i = 1;
      $daftaruser2 = mysql_query("SELECT * FROM tb_mangkir WHERE jenis='Tidak Ada Cuti' ORDER BY tanggal DESC");
      while ($du2 = mysql_fetch_array($daftaruser2)){
      ?>
      <tr>
        <td><?php echo $i++; ?></td>
        <td><?php echo $du2['nama']; ?></td>
        <td><?php echo $du2['tanggal']; ?></td>
        <td><?php echo $du2['pemotongan']; ?> Hari</td>
        <td>Mangkir tanpa cuti</td>
      </tr>
      <?php
      }
      ?>
  </tbody>
</table>
</div>

<script>
  $(function () {
    $("#example1").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });
  });
</script>
