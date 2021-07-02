<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Dashboard_model');
    }

	public function index()
	{
		$data['countpelanggan'] = $this->Dashboard_model->count_pelanggan();
		$data['countkendaraan'] = $this->Dashboard_model->count_kendaraan();
		$data['counttransaksi'] = $this->Dashboard_model->count_transaksi();
		$data['countusers'] = $this->Dashboard_model->count_allusers();
		$this->template->load('template','dashboard',$data);
	}

}
