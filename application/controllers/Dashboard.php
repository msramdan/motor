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
        $data['countjenispembayaran'] = $this->Dashboard_model->count_jenis_pembayaran();
		$data['admin_fee'] = $this->Dashboard_model->admin_fee();
        $data['bunga'] = $this->Dashboard_model->bunga();
		$data['sales_referal_chart']= $this->Dashboard_model->sales_referal_chart('2021-07-01','2021-07-31',$this->session->userdata('unit_id'));
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


    public function update_bunga(){
        $data = $this->input->post(null, TRUE);
        if (isset($_POST['update_bunga'])) {
            $this->Dashboard_model->update_bunga($data); 
            if($this->db->affected_rows() > 0){

            $params = array("success" => true);
            }else{
                $params = array("success" => false);
            }
            echo json_encode($params);
        }
      
    }

    public function update_report() {
        $startdate = date('Y-m-d H:i:s', strtotime($this->input->post('startdate')));
        $enddate = date('Y-m-d H:i:s', strtotime($this->input->post('enddate')));

        $anu = $this->Dashboard_model->sales_referal_chart($startdate,$enddate,$this->session->userdata('unit_id'));

        echo json_encode($anu);
    }


}