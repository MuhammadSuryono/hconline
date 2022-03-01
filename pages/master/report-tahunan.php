<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />


<style>
table.reportTahunan {
    border: 1px solid #1C6EA4;
    width: 1050px;
    text-align: center;
    border-collapse: collapse;
}

table.reportTahunan td,
table.reportTahunan th {
    border: 1px solid #AAAAAA;
    padding: 2px 2px;
}

table.reportTahunan tbody td {
    font-size: 13px;
}

table.reportTahunan thead {
    border-bottom: 2px solid #444444;
}

table.reportTahunan thead th {
    font-size: 15px;
    font-weight: bold;
    text-align: center;
}

table.reportTahunan tfoot td {
    font-size: 14px;
}

table.reportTahunan tfoot .links {
    text-align: right;
}

table.reportTahunan tfoot .links a {
    display: inline-block;
    background: #1C6EA4;
    color: #FFFFFF;
    padding: 2px 8px;
    border-radius: 5px;
}
</style>

<div class="box box-primary">
    <div class="row">
        <div class="box-body">
            <div class="col-md-4">
                <div class="input-group">
                    <div class="input-group-addon">
                    <i class="fa fa-user"></i>
                    </div>
                    <select class="form-control" id="karyawan" onchange="get_report()">
                        <option value=''>Pilih Karyawan</option>
                        <?php
                            $q_user = mysql_query("SELECT id_user, nama_user, divisi, id_absen FROM tb_user WHERE id_absen != '' ORDER BY nama_user ASC");
                            while ($row = mysql_fetch_array($q_user)) {
                                echo "<option value='".$row['id_user']."/".$row['divisi']."/".$row['id_absen']."'>".$row['nama_user']."</option>";
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <input class='form-control' type='text' id='jabatan' disabled>
            </div>
            <div class="col-md-4">
                <div class="input-group date">
                    <div class="input-group-addon">
                    <i class="fa fa-user"></i>
                    </div>
                    <select class="form-control" id="tahun" onchange="get_report()">
                        <?php
                            $tahun = date('Y');
                            for ($i=0; $i < 3; $i++) {
                                echo "<option value='".$tahun."'>".$tahun."</option>";
                                $tahun--;
                            }
                        ?>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="row>">
        <div class="box-body" id="report">

        </div>
    </div>
    <div class="row>">
        <div class="box-body">
            <table>
                <tr>
                    <td bgcolor='#cff4f9'>
                        &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                    </td>
                    <td>
                        &nbsp;:&nbsp;
                    </td>
                    <td>
                        Libur
                    </td>
                </tr>
                <tr>
                    <td bgcolor='#05bcff'>
                        &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                    </td>
                    <td>
                        &nbsp;:&nbsp;
                    </td>
                    <td>
                        Cuti
                    </td>
                </tr>
                <tr>
                    <td bgcolor='#fff968'>
                        &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                    </td>
                    <td>
                        &nbsp;:&nbsp;
                    </td>
                    <td>
                        Sakit dengan surat dokter
                    </td>
                </tr>
                <tr>
                    <td bgcolor='#ffdddd'>
                        &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                    </td>
                    <td>
                        &nbsp;:&nbsp;
                    </td>
                    <td>
                        Sakit tanpa surat dokter
                    </td>
                </tr>
                <tr>
                    <td bgcolor='#b1e580'>
                        &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                    </td>
                    <td>
                        &nbsp;:&nbsp;
                    </td>
                    <td>
                        Dinas / Tugas
                    </td>
                </tr>
                <tr>
                    <td bgcolor='#a3a3a3'>
                        &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                    </td>
                    <td>
                        &nbsp;:&nbsp;
                    </td>
                    <td>
                        Unpaid
                    </td>
                </tr>
                <tr>
                    <td bgcolor='#ffb2a8'>
                        &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                    </td>
                    <td>
                        &nbsp;:&nbsp;
                    </td>
                    <td>
                        Mangkir
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>

<script>

    function get_report() {
        var karyawan = document.getElementById("karyawan").value;
        var tahun = document.getElementById("tahun").value;
        if (karyawan!='' && tahun!='') {
            var res = karyawan.split("/");
            document.getElementById("jabatan").value = res[1];
            $.ajax({
                url: "pages/transaksi/report_process.php",
                dataType: "html",
                method: "post",
                data: {
                    action: "get_report",
                    id_user: res[0],
                    id_absen: res[2],
                    tahun: tahun
                }
            })
            .done(function(data){
                document.getElementById("report").innerHTML = data;
            });
        }
    }

</script>
