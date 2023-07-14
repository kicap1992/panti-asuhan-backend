<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('model');
    $this->load->model('m_tabel_ss');

    if ($this->session->userdata('level') != "admin") {
      // remove session
      $this->session->unset_userdata('level');
      redirect(base_url("login"));
    }
  }


  function index()
  {
    $main['header'] = "Halaman Utama";
    // $main['content'] = "admin/content/index";
    $this->load->view('admin/index', $main);
  }

  function parkir()
  {
    if ($this->input->post('proses') == "table_area_parkir") {
      $list = $this->m_tabel_ss->get_datatables(array('luas','alamat'), array(null, 'alamat',null, null, 'luas', null), array('id_parkir' => 'desc'), "tb_area_parkir", null,null, "*");
      $data = array();
      $no = $_POST['start'];
      foreach ($list as $field) {

        

        $kecamatan = '';
        $kelurahan = '';
        $cek_kelurahan = $this->model->tampil_data_where('tb_kelurahan', array('no' => $field->id_kelurahan))->result();
        $kelurahan = $cek_kelurahan[0]->kelurahan;
        $cek_kecamatan = $this->model->tampil_data_where('tb_kecamatan', array('no' => $cek_kelurahan[0]->kecamatan))->result();
        $kecamatan = $cek_kecamatan[0]->kecamatan;

        

        $no++;
        $row = array();
        $row[] = $no;
        $row[] = $field->alamat;
        $row[] = $kecamatan;
        $row[] = $kelurahan;
        $row[] = $field->luas . " m<sup>2</sup>";
        $row[] = "<center><button type='button' onclick='hapus_area_parkir(".$field->id_parkir.")' title='Hapus Area Parkir' class='btn btn-danger btn-circle btn-sm waves-effect waves-light'><i class='ico zmdi zmdi-delete'></i></button></center>";
        $data[] = $row;
      }

      $output = array(
        "draw" => $_POST['draw'],
        "recordsTotal" => $this->m_tabel_ss->count_all("tb_area_parkir", null, null, "*"),
        "recordsFiltered" => $this->m_tabel_ss->count_filtered(array('luas','alamat'), array(null, 'alamat',null, null, 'luas', null), array('id_parkir' => 'desc'), "tb_area_parkir", null,null, "*"),
        "data" => $data,
      );
      //output dalam format JSON
      echo json_encode($output);
    } else {
      $main['header'] = "Pengaturan Parkir";
      // $main['content'] = "admin/content/pengaturan_parkir";
      $this->load->view('admin/content/parkir', $main);
    }
  }

  function logout(){
    $this->session->sess_destroy();
    redirect(base_url("login"));
  }

  function coba()
  {
    $check_data = $this->model->tampil_data_where('tb_kelurahan', array('no' => '21'))->result();

    $data = $check_data[0]->kordinat;

    $data = json_decode($data, true);

    print_r($data[0]['kordinat']);
  }


  function coba1()
  {
    $string = '';
    // replace lng and lat to "lng" and "lat" and remove space and last comma
    $string = str_replace('lng:', '"lng":', $string);
    $string = str_replace('lat:', '"lat":', $string);
    $string = str_replace(' ', '', $string);
    $string = substr($string, 0, -1);
    // add square bracket
    $string = '[' . $string . ']';
    print_r($string);
  }

  function coba2()
  {
    $array = '';

    $array = json_decode($array, true);
    print_r($array);
    // print_r(json_encode($array));
  }
}
