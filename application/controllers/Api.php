<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, DELETE, PUT');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization');
header('Access-Control-Allow-Credentials: true');
header('Content-Type: application/json');

defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Api extends RestController
{
  function __construct()
  {
    parent::__construct();
    $this->load->model('model');;
    // $this->db->query("SET sql_mode = '' ");
    date_default_timezone_set("Asia/Kuala_Lumpur");
  }

  public function index_get()
  {
    $this->response(['message' => 'Halo Bosku', 'status' => true], 200);
    // redirect(base_url());

  }

  public function index_post()
  {
    $this->response(['message' => 'Halo Bosku post', 'status' => true], 400);
    // redirect(base_url());

  }




  // -----------------------------------------------------------------------------------------------------------

  public function siswa_post()
  {
    $nama = $this->post('nama');
    $jenis_kelamin = $this->post('jenis_kelamin');
    $tanggal_lahir = $this->post('tanggal_lahir');
    $tempat_lahir = $this->post('tempat_lahir');
    $alamat = $this->post('alamat');
    $no_telpon = $this->post('no_telpon');
    $agama = $this->post('agama');
    $kewarganegaraan = $this->post('kewarganegaraan');
    $pendidikan_sd = $this->post('pendidikan_sd');
    $pendidikan_smp = $this->post('pendidikan_smp');
    $pendidikan_sma = $this->post('pendidikan_sma');
    $kemampuan = $this->post('kemampuan');
    $hobi = $this->post('hobi');
    $foto = $_FILES['foto'];

    $cek_last_ai = $this->model->cek_last_ai('tb_siswa');

    $upload_dir = 'assets/siswa/' . $cek_last_ai . '/';
    if (!is_dir($upload_dir)) {
      mkdir($upload_dir);
    }

    $path = $upload_dir . $foto['name'];
    move_uploaded_file($foto['tmp_name'], $path);

    $array = [
      'nama' => $nama,
      'jenis_kelamin' => $jenis_kelamin,
      'tanggal_lahir' => $tanggal_lahir,
      'tempat_lahir' => $tempat_lahir,
      'alamat' => $alamat,
      'no_telpon' => $no_telpon,
      'agama' => $agama,
      'kewarganegaraan' => $kewarganegaraan,
      'pendidikan_sd' => $pendidikan_sd,
      'pendidikan_smp' => $pendidikan_smp,
      'pendidikan_sma' => $pendidikan_sma,
      'kemampuan' => $kemampuan,
      'hobi' => $hobi,
      'img_url' => $path
    ];

    $this->model->insert('tb_siswa', $array);



    $this->response(['message' => 'ini untuk siswa post', 'status' => $array], 200);
  }

  public function siswa_get()
  {
    $data = $this->model->tampil_data_keseluruhan('tb_siswa')->result();
    $this->response(['message' => 'ini untuk siswa get', 'status' => true, 'data' => $data], 200);
  }

  public function siswa_detail_get()
  {
    $id = $this->get('id');
    $data = $this->model->tampil_data_where('tb_siswa', ['id_siswa' => $id])->result();
    if (count($data) == 0) return $this->response(['message' => 'data tidak ditemukan', 'status' => false], 200);
    $this->response(['message' => 'ini untuk siswa get', 'status' => true, 'data' => $data[0]], 200);
  }

  // siswa delete
  public function siswa_delete_post()
  {
    $id = $this->post('id');
    $cek_data = $this->model->tampil_data_where('tb_siswa', ['id_siswa' => $id])->result();
    if (count($cek_data) == 0) return $this->response(['message' => 'data tidak ditemukan', 'status' => false], 400);
    // delete the folder
    $upload_dir = 'assets/siswa/' . $id . '/';
    if (is_dir($upload_dir)) {
      array_map('unlink', glob("$upload_dir/*.*"));
      rmdir($upload_dir);
    }
    $this->model->delete('tb_siswa', ['id_siswa' => $id]);
    
    $this->response(['message' => 'ini untuk siswa delete', 'status' => true], 200);
  }


  public function dana_sosial_post()
  {
    $nama = $this->post('nama') == '' ? null : $this->post('nama');
    $jumlah = $this->post('jumlah') == '' ? null : $this->post('jumlah');
    $tanggal = $this->post('tanggal');
    $ket = $this->post('ket') == '' ? null : $this->post('ket');
    $jenis = $this->post('jenis');
    $bentuk = $this->post('bentuk');

    $array = [
      'nama' => $nama,
      'jumlah' => $jumlah,
      'tanggal' => $tanggal,
      'ket' => $ket,
      'jenis' => $jenis,
      'bentuk' => $bentuk
    ];

    $this->model->insert('tb_dana_sosial', $array);

    $this->response(['message' => 'ini untuk dana sosial', 'status' => true], 200);
  }

  public function dana_sosial_get()
  {
    $data = $this->model->tampil_data_keseluruhan('tb_dana_sosial')->result();
    $this->response(['message' => 'ini untuk dana sosial get', 'status' => true, 'data' => $data], 200);
  }

  public function dana_sosial_detail_get()
  {
    $id = $this->get('id');
    $data = $this->model->tampil_data_where('tb_dana_sosial', ['id_dana_sosial' => $id])->result();
    if (count($data) == 0) return $this->response(['message' => 'data tidak ditemukan', 'status' => false], 400);
    $this->response(['message' => 'ini untuk dana sosial get', 'status' => true, 'data' => $data[0]], 200);
  }


  public function filter_dana_post()
  {
    $sql = $this->post('sql');

    $data = $this->model->custom_query($sql)->result();

    $this->response(['message' => 'ini untuk filter dana', 'status' => true, 'data' => $data], 200);
  }

  public function dana_sosial_ttd_post()
  {
    $id = $this->post('id');
    $cek_data = $this->model->tampil_data_where('tb_dana_sosial', ['id_dana_sosial' => $id])->result();

    if (count($cek_data) == 0) return $this->response(['message' => 'data tidak ditemukan', 'status' => false], 400);

    $this->model->update('tb_dana_sosial', ['id_dana_sosial' => $id], ['status' => 1]);

    $this->response(['message' => 'ini untuk dana sosial ttd', 'status' => true], 200);
  }

  public function edit_jabatan_post()
  {
    $jabatan = $this->post('jabatan');
    $jumlah = $this->post('jumlah');
    // change jumlah to int
    $jumlah = (int)$jumlah;

    $cek_data = $this->model->tampil_data_where('tb_jabatan', ['jabatan' => $jabatan])->result();
    for ($j = 0; $j < count($cek_data); $j++) {
      // delete folder
      $upload_dir = 'assets/jabatan/' . $cek_data[$j]->id . '/';
      if (is_dir($upload_dir)) {
        $files = glob($upload_dir . '*');
        foreach ($files as $file) {
          if (is_file($file)) {
            unlink($file);
          }
        }
        rmdir($upload_dir);
      }
    }
    $this->model->delete('tb_jabatan', ['jabatan' => $jabatan]);

    for($i = 1; $i <= $jumlah; $i++){
      $nama = $this->post('nama'.$i);
      $foto = $_FILES['image'.$i];

      $cek_last_ai = $this->model->cek_last_ai('tb_jabatan');

      $upload_dir = 'assets/jabatan/' . $cek_last_ai . '/';
      if (!is_dir($upload_dir)) {
        mkdir($upload_dir);
      }

      $path = $upload_dir . $foto['name'];
      move_uploaded_file($foto['tmp_name'], $path);

      $array = [
        'jabatan' => $jabatan,
        'nama' => $nama,
        'img_url' => $path
      ];

      $this->model->insert('tb_jabatan', $array);
    }


    $this->response(['message' => $cek_data, 'status' => true], 200);
  }

  public function jabatan_get(){
    $jabatan = $this->get('jabatan');
    $data = $this->model->tampil_data_where('tb_jabatan', ['jabatan' => $jabatan])->result();
    $this->response(['message' => 'ini untuk jabatan get', 'status' => true, 'data' => $data], 200);
  }
}
