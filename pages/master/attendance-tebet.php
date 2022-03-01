<div class="panel panel-default">
  <div class="panel-heading">
     <h4 class="panel-title"><i class="fa fa-plus"></i> Pilih Bulan<a data-toggle="collapse" data-target="#formaddcuti" href="#formaddcuti" class="collapsed"></a></h4>
  </div>
  <div id="formaddcuti" class="panel-collapse collapse">
    <div class="panel-body">
      <form action="home-hrd.php?page=attendance-tebet-proses" class="form-horizontal" method="POST" enctype="multipart/form-data">
        <div class="form-group">
          <label class="col-sm-2 control-label">Bulan:</label>
          <div class="col-sm-3">
            <select name="bulan" class="form-control">
              <option selected value="01">Januari</option>
              <option value="02">Febuari</option>
              <option value="03">Maret</option>
              <option value="04">April</option>
              <option value="05">Mei</option>
              <option value="06">Juni</option>
              <option value="07">Juli</option>
              <option value="08">Agustus</option>
              <option value="09">September</option>
              <option value="10">Oktober</option>
              <option value="11">November</option>
              <option value="12">Desember</option>
            </select>
          </div>
          <div class="col-sm-2">
            <button type="submit" name="save" value="save" class="btn btn-danger">Submit</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
