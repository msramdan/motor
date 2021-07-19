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
        $data = array(
    		'countpelanggan' => $this->Dashboard_model->count_pelanggan(),
    		'countitem' => $this->Dashboard_model->count_item(),
    		'countagen' => $this->Dashboard_model->count_agen(),
    		'countkaryawan' => $this->Dashboard_model->count_allusers(),
            'countjenispembayaran' => $this->Dashboard_model->count_jenis_pembayaran(),
    		'admin_fee' => $this->Dashboard_model->admin_fee(),
            'bunga' => $this->Dashboard_model->bunga(),
    		'sales_referal_chart'=>$this->Dashboard_model->sales_referal_chart(date('Y-m-d 00:00:00'),date('Y-m-d 23:59:00'),$this->session->userdata('unit_id')),
            'uang_masup' => $this->Dashboard_model->umuk_chart(date('Y-m-d 00:00:00'), date('Y-m-d 23:59:00'), $this->session->userdata('unit_id'), 'uang_masuk', 'Terjual'),
            'uang_kuwar' => $this->Dashboard_model->umuk_chart(date('Y-m-d 00:00:00'), date('Y-m-d 23:59:00'), $this->session->userdata('unit_id'), 'uang_keluar', 'Ready'),
        );
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
        $type = $this->input->post('type');
        $startdate = date('Y-m-d H:i:s', strtotime($this->input->post('startdate')));
        $enddate = date('Y-m-d H:i:s', strtotime($this->input->post('enddate')));

        if ($type === 'sales_referal') {
            $anu = $this->Dashboard_model->sales_referal_chart($startdate,$enddate,$this->session->userdata('unit_id'));
        }

        if ($type === 'umuk') {
            $anu = array(
                'uang_masup' => $this->Dashboard_model->umuk_chart($startdate, $enddate, $this->session->userdata('unit_id'), 'uang_masuk', 'Terjual'),
                'uang_kuwar' => $this->Dashboard_model->umuk_chart($startdate, $enddate, $this->session->userdata('unit_id'), 'uang_keluar', 'Ready'),
            );
        }
        

        echo json_encode($anu);
    }


}