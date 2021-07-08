<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Beranda extends CI_Controller {

	function __construct()
    {
        parent::__construct();
        cek_login_aja();
         $this->load->model('Info_model');
         $this->load->model('Unit_model');
    }

	public function index()
	{
		$data = array(
        'info' =>$this->Info_model->get_all(),
        );
		$this->load->view('beranda/beranda',$data);
	}

	public function Unit()
	{
		$data = array(
            'unit' =>$this->Unit_model->get_all_access(),
	);
		$this->load->view('beranda/list_unit',$data);
	}

	function session_unit($id){
		$row = $this->Unit_model->get_by_id($id);
		$nama_unit = $row->nama_unit;
        $this->session->set_userdata('unit_id', $id);
        $this->session->set_userdata('nama_unit', $nama_unit);
        $this->session->set_flashdata('message', 'Anda telah berpindah Unit');   
        redirect('dashboard');
    }

}