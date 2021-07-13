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
		$data['countitem'] = $this->Dashboard_model->count_item();
		$data['countagen'] = $this->Dashboard_model->count_agen();
		$data['countkaryawan'] = $this->Dashboard_model->count_allusers();
		$data['admin_fee'] = $this->Dashboard_model->admin_fee();
		$this->template->load('template','dashboard',$data);
	}

	public function update_admin_fee(){
        $data = $this->input->post(null, TRUE);
        if (isset($_POST['update_nominal'])) {
            $this->Dashboard_model->update_admin_fee($data); 

            if($this->db->affected_rows() > 0){

            $params = array("success" => true);
            }else{
                $params = array("success" => false);
            }
            echo json_encode($params);
        }
      
    }


}