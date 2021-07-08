<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Beranda extends CI_Controller {

	function __construct()
    {
        parent::__construct();
        is_login();
    }

	public function index()
	{
		$this->load->view('beranda/beranda');
	}

	public function Unit()
	{
		$this->load->view('beranda/list_unit');
	}

}