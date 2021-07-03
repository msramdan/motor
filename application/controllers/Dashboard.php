<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	function __construct()
    {
        parent::__construct();
        is_login();
    }

	public function index()
	{
		$this->template->load('template','dashboard');
	}

}
