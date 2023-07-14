<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('model');
    $this->load->model('m_tabel_ss');

    
  }


  function index()
  {
    $main['header'] = "Area Parkir Parepare";
    // $main['content'] = "admin/content/index";
    $this->load->view('user/index', $main);
  }

  
}
