<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data['judul'] = "Insentif";

        $this->load->view('auth/index', $data);
    }

    public function login()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $cek = $this->db->get_where('user_access', ['email'=>$username])->row_array();

        if($cek>=1){

            if(password_verify($password,$cek['password'])){
                $this->session->set_userdata($cek);
                redirect('user/dashboard');
            } else {
                $this->session->set_flashdata('gagalLogin', 'Password Anda Salah!!');
                redirect('auth');
            }

        } else {
            $this->session->set_flashdata('gagalLogin', 'Username Tidak Ditemukan!!');
            redirect('auth');
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('auth');
    }

    public function rank()
    {
        $tgl1 = "2020-01-02";
        $tgl2 = "2020-02-14";


        // AMBIL DATA ABSEN
        $data = $this->db->query("SELECT
                                        *,
                                        MIN(jamnya) AS masuk,
                                        IF(jamnya>'08:07:00', 0.5, 0) as rule,
                                        DATE(tgl_dan_jam) as tgl
                                    FROM
                                        absensi
                                    WHERE
                                        -- user_id = '2245' AND
                                        DATE(tgl_dan_jam) BETWEEN '$tgl1'
                                    AND '$tgl2'
                                    GROUP BY
                                        user_id,
                                        DATE(tgl_dan_jam)
                                    ORDER BY user_id DESC") ->result_array();

        $dataAbsen = [];

        // foreach ($data as $key => $db) {
        //     $nama = $db['user_id']."/".$db['tgl'];
        //     $dataAbsen[$nama] = $db;
        // }

        foreach ($data as $key => $db) {
            $nama = $db['user_id'];

            if(array_key_exists($nama, $dataAbsen)){
                $nama1 = $db['tgl'];
                $dataAbsen[$nama][$nama1] = array('masuk' => $db['masuk'], 'rule' => $db['rule']);
            } else {
                $dataAbsen[$nama] = array($db['tgl'] => array('masuk' => $db['masuk'], 'rule' => $db['rule']));
            }
        }
        // AKHIR ARRAY ABSEN

        // AMBIL DATA IZIN
        $dataIzin = [];
        $data = $this->db->query("SELECT
                                        *, CASE
                                    WHEN jenis = 'Sakit Dengan Surat Dokter' THEN
                                        0.5
                                    WHEN jenis = 'Sakit Tanpa Surat Dokter' THEN
                                        0.75
                                    ELSE
                                        0
                                    END AS rule
                                    FROM
                                        daterange_izin
                                    WHERE
                                        tanggal BETWEEN '$tgl1'
                                    AND '$tgl2'
                                    ORDER BY username ASC")->result_array();

        foreach ($data as $key => $db) {
            $nama = $db['username'];

            if(array_key_exists($nama, $dataIzin)){
                $nama1 = $db['tanggal'];
                $dataIzin[$nama][$nama1] = array('jenis'=>$db['jenis'], 'rule'=>$db['rule']);
            } else {
                $dataIzin[$nama] = array($db['tanggal'] => array( 'jenis'=>$db['jenis'], 'rule'=>$db['rule']));
            }
        }
        // AKHIR AMBIL DATA IZIN

        // AMBIL DATA CUTI
        $dataCuti = [];
        $data = $this->db->query("SELECT
                                        *,
                                    IF (username != '', 0.5, 0) AS rule
                                    FROM
                                        daterange_cuti
                                    WHERE
                                        tanggal BETWEEN '$tgl1'
                                    AND '$tgl2'
                                    ORDER BY
                                        username DESC")->result_array();

        foreach ($data as $key => $db) {
            $nama = $db['username'];

            if(array_key_exists($nama, $dataCuti)){
                $nama1 = $db['tanggal'];
                $dataCuti[$nama][$nama1] = $db['rule'];
            } else {
                $dataCuti[$nama] = array($db['tanggal'] => $db['rule']);
            }
        }
        // AKHIR AMBIL DATA CUTI

        // AMBIL DATA UNPAID
        $dataUnpaid = [];
        $data = $this->db->query("SELECT
                                        *,
                                    IF (username != '', 1, 0) AS rule
                                    FROM
                                        daterange_unpaid
                                    WHERE
                                        tanggal BETWEEN '$tgl1'
                                    AND '$tgl2'
                                    ORDER BY
                                        username DESC")->result_array();

        foreach ($data as $key => $db) {
            $nama = $db['username'];

            if(array_key_exists($nama, $dataUnpaid)){
                $nama1 = $db['tanggal'];
                $dataUnpaid[$nama][$nama1] = $db['rule'];
            } else {
                $dataUnpaid[$nama] = array($db['tanggal'] => $db['rule']);
            }
        }
        // AKHIR AMBIL DATA UNPAID

        // INSERT DATA
        $insert = [];

        $data = $this->db->get_where('tb_user', ['aktif'=>'Y', 'resign'=>0])->result_array();
        // var_dump($data); die;
        foreach ($data as $key => $db) {
            $tgl11 = $tgl1;
            $rank = 0; $telat=0; $izin=0; $cuti=0; $unpaid=0;
            $nama1 = $db['id_user'];

            // if($db['id_absen']=='' or $db['id_absen']==null){
            //     $nama = "none";
            // } else {
            // }
            $nama = $db['id_absen'];


            // ULANGI SEBANYAK TANGGAL
            // while (strtotime($tgl11) <= strtotime($tgl2)) {

            //     // if(array_key_exists($nama, $dataAbsen)==true){
            //     // CEK DATA ABSEN
            //     if(array_key_exists($tgl11, $dataAbsen[$nama])==true){
            //         // echo "trueABSEN-$nama<br>";
            //         $rank = $rank + (float)$dataAbsen[$nama][$tgl11]['rule'];

            //             // RECORD TELAT
            //             if($dataAbsen[$nama][$tgl11]['rule'] != 0){
            //                 $telat++;
            //             }

            //     } else {

            //         // if(array_key_exists($nama1, $data))
            //         // CEK DATA IZIN
            //         if(array_key_exists($tgl11, $dataIzin[$nama1])==true){
            //             // echo "trueIZIN-$nama<br>";
            //             $rank = $rank + (float)$dataIzin[$nama1][$tgl11]['rule'];

            //             // RECORD IZIN
            //             if($dataIzin[$nama1][$tgl11]['rule']!=0){
            //                 $izin++;
            //             }

            //         } else {

            //             // CEK DATA CUTI
            //             if(array_key_exists($tgl11, $dataCuti[$nama1])==true){
            //                 // echo "trueCUTI-$nama<br>";
            //                 $rank = $rank + (float)$dataCuti[$nama1][$tgl11];

            //                 // RECORD CUTI
            //                 if($dataCuti[$nama1][$tgl11]!=0){
            //                     $cuti++;
            //                 }

            //             } else {

            //                 // CEK DATA UNPAID
            //                 if(array_key_exists($tgl11, $dataUnpaid[$nama1])==true){
            //                     // echo "trueUNPAID-$nama<br>";
            //                     $rank = $rank + (float)$dataUnpaid[$nama1][$tgl11];

            //                     // RECORD UNPAID
            //                     if($dataUnpaid[$nama1][$tgl11]!=0){
            //                         $unpaid++;
            //                     }
            //                 }
            //             }
            //         }
            //     }
            //     // AKHIR CEK DATA ABSEN
            // // }
            //     // echo $tgl1."<br>";
            //     $tgl11 = date ("Y-m-d", strtotime("+1 day", strtotime($tgl11)));
            // }
            // AKHIR ULANGI TANGGAL

            $adaAbsen = array_key_exists($nama, $dataAbsen);
            $adaIzin = array_key_exists($nama1, $dataIzin);
            $adaCuti = array_key_exists($nama1, $dataCuti);
            $adaUnpaid = array_key_exists($nama1, $dataUnpaid);

            while (strtotime($tgl11) <= strtotime($tgl2)) {

                if($adaAbsen==true){
                    if(array_key_exists($tgl11, $dataAbsen[$nama])==true){
                        $rank = $rank + (float)$dataAbsen[$nama][$tgl11]['rule'];

                            // RECORD TELAT
                            if($dataAbsen[$nama][$tgl11]['rule'] != 0){
                                $telat++;
                            }
                    }
                }

                if($adaIzin==true){
                    if(array_key_exists($tgl11, $dataIzin[$nama1])==true){
                        $rank = $rank + (float)$dataIzin[$nama1][$tgl11]['rule'];

                        // RECORD IZIN
                        if($dataIzin[$nama1][$tgl11]['rule']!=0){
                            $izin++;
                        }
                    }
                }

                if($adaCuti==true){
                    if(array_key_exists($tgl11, $dataCuti[$nama1])==true){
                        $rank = $rank + (float)$dataCuti[$nama1][$tgl11];

                        // RECORD CUTI
                        if($dataCuti[$nama1][$tgl11]!=0){
                            $cuti++;
                        }
                    }
                }

                if($adaUnpaid==true){
                    if(array_key_exists($tgl11, $dataUnpaid[$nama1])==true){
                        $rank = $rank + (float)$dataUnpaid[$nama1][$tgl11];

                        // RECORD UNPAID
                        if($dataUnpaid[$nama1][$tgl11]!=0){
                            $unpaid++;
                        }
                    }
                }
                $tgl11 = date ("Y-m-d", strtotime("+1 day", strtotime($tgl11)));
            }


            $data = [
                'username' => $nama1,
                'telat' => $telat,
                'izin' => $izin,
                'cuti' => $cuti,
                'unpaid' => $unpaid,
                'rank' => $rank,
            ];

            array_push($insert, $data);
        }
        // AKHIR INSERT

        // var_dump(date('d', strtotime($tgl2)-strtotime($tgl1))); die;
        $this->db->query("truncate ranking");
        $this->db->insert_batch('ranking', $insert);

        $data['ranking'] = $this->db->query("SELECT a.*, b.nama_user from ranking a left join tb_user b on a.username=b.id_user order by a.rank ASC")->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/rank', $data);
        $this->load->view('templates/footer');
        // echo '<pre>' . var_export($insert, true) . '</pre>';
    }
}
?>

<div class="gagal" data-flashdata="<?= $this->session->flashdata('gagal'); ?>"></div>
<div class="sukses" data-flashdata="<?= $this->session->flashdata('sukses'); ?>"></div>
<div class="hapus" data-flashdata="<?= $this->session->flashdata('hapus'); ?>"></div>

<!-- Main Content -->
<div class="main-content">
<section class="section">
    <div class="section-header">
    <h1></h1>
    </div>

    <div class="section-body">
    </div>
</section>

<div class="row">
<div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h4>Progress Bulan </h4>
            </div>
            <div class="card-body">
                <table class="table table-striped table-hover" id="table-1">
                    <thead>
                        <tr>
                        <th>N0</th>
                        <th>Nama Karyawan</th>
                        <th>Telat</th>
                        <th>Izin</th>
                        <th>Cuti</th>
                        <th>Unpaid</th>
                        <th>Total</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $rank=0; $ranklama=-1; $no=0; foreach($ranking as $db): $no++?>
                        <?php if($db['rank']>$ranklama){
                                    $rank++;
                                } else {
                                    $rank = $rank;
                                }

                                $ranklama = $db['rank'];
                        ?>

                        <tr>
                            <td><?=$no?></td>
                            <td>#<?=$rank?> <?=$db['nama_user']?>
                            </td>
                            <td><?=$db['telat']?></td>
                            <td><?=$db['izin']?></td>
                            <td><?=$db['cuti']?></td>
                            <td><?=$db['unpaid']?></td>
                            <td><?=$db['rank']?></td>
                        </tr>
                        <?php endforeach?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

</div>
