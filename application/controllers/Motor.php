<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Motor extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Motor_model');
        $this->load->model('Merek_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->uri->segment(3));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . '.php/c_url/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'index.php/motor/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'index.php/motor/index/';
            $config['first_url'] = base_url() . 'index.php/motor/index/';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = FALSE;
        $config['total_rows'] = $this->Motor_model->total_rows($q);
        $motor = $this->Motor_model->get_limit_data($config['per_page'], $start, $q);
        $config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin pull-right">';
        $config['full_tag_close'] = '</ul>';
        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'motor_data' => $motor,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->template->load('template','motor/motor_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Motor_model->get_by_id($id);
        if ($row) {
            $data = array(
		'motor_id' => $row->motor_id,
		'kd_motor' => $row->kd_motor,
		'nama_motor' => $row->nama_motor,
		'merek_id' => $row->merek_id,
		'deskripsi' => $row->deskripsi,
		'stok' => $row->stok,
		'photo' => $row->photo,
	    );
            $this->template->load('template','motor/motor_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('motor'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'merek' =>$this->Merek_model->get_all(),
            'action' => site_url('motor/create_action'),
	    'motor_id' => set_value('motor_id'),
	    'kd_motor' => set_value('kd_motor'),
	    'nama_motor' => set_value('nama_motor'),
	    'merek_id' => set_value('merek_id'),
	    'deskripsi' => set_value('deskripsi'),
	    'stok' => set_value('stok'),
	    'photo' => set_value('photo'),
	);
        $this->template->load('template','motor/motor_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
             $config['upload_path']      = './assets/img/motor'; 
        $config['allowed_types']    = 'jpg|png|jpeg'; 
        $config['max_size']         = 10048; 
        $config['file_name']        = 'File-'.date('ymd').'-'.substr(sha1(rand()),0,10); 
        $this->load->library('upload',$config);
        $this->upload->initialize($config);
        $this->upload->do_upload("photo");
        $data = $this->upload->data();
        
        $photo =$data['file_name'];

            $data = array(
		'kd_motor' => $this->input->post('kd_motor',TRUE),
		'nama_motor' => $this->input->post('nama_motor',TRUE),
		'merek_id' => $this->input->post('merek_id',TRUE),
		'deskripsi' => $this->input->post('deskripsi',TRUE),
		'stok' => $this->input->post('stok',TRUE),
		'photo' => $photo,
	    );

            $this->Motor_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success 2');
            redirect(site_url('motor'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Motor_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'merek' =>$this->Merek_model->get_all(),
                'action' => site_url('motor/update_action'),
		'motor_id' => set_value('motor_id', $row->motor_id),
		'kd_motor' => set_value('kd_motor', $row->kd_motor),
		'nama_motor' => set_value('nama_motor', $row->nama_motor),
		'merek_id' => set_value('merek_id', $row->merek_id),
		'deskripsi' => set_value('deskripsi', $row->deskripsi),
		'stok' => set_value('stok', $row->stok),
		'photo' => set_value('photo', $row->photo),
	    );
            $this->template->load('template','motor/motor_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('motor'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('motor_id', TRUE));
        } else {

             $config['upload_path']      = './assets/img/motor'; 
            $config['allowed_types']    = 'jpg|png|jpeg|gif'; 
            $config['max_size']         = 10048; 
            $config['file_name']        = 'File-'.date('ymd').'-'.substr(sha1(rand()),0,10); 
            $this->load->library('upload',$config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload("photo")) {
            $id = $this->input->post('motor_id');
            $row = $this->Motor_model->get_by_id($id);
            $data = $this->upload->data();
            $photo =$data['file_name'];
            if($row->photo==null || $row->photo=='' ){
            }else{

            $target_file = './assets/img/motor/'.$row->photo;
            unlink($target_file);
            
            }
                }else{
                $photo = $this->input->post('photo_lama');
            }

            $data = array(
		'kd_motor' => $this->input->post('kd_motor',TRUE),
		'nama_motor' => $this->input->post('nama_motor',TRUE),
		'merek_id' => $this->input->post('merek_id',TRUE),
		'deskripsi' => $this->input->post('deskripsi',TRUE),
		'stok' => $this->input->post('stok',TRUE),
		'photo' => $photo,
	    );

            $this->Motor_model->update($this->input->post('motor_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('motor'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Motor_model->get_by_id($id);

        if ($row) {
            $this->Motor_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('motor'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('motor'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('kd_motor', 'kd motor', 'trim|required');
	$this->form_validation->set_rules('nama_motor', 'nama motor', 'trim|required');
	$this->form_validation->set_rules('merek_id', 'merek id', 'trim|required');
	$this->form_validation->set_rules('deskripsi', 'deskripsi', 'trim|required');
	$this->form_validation->set_rules('stok', 'stok', 'trim|required');
	// $this->form_validation->set_rules('photo', 'photo', 'trim|required');

	$this->form_validation->set_rules('motor_id', 'motor_id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "motor.xls";
        $judul = "motor";
        $tablehead = 0;
        $tablebody = 1;
        $nourut = 1;
        //penulisan header
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header("Content-Disposition: attachment;filename=" . $namaFile . "");
        header("Content-Transfer-Encoding: binary ");

        xlsBOF();

        $kolomhead = 0;
        xlsWriteLabel($tablehead, $kolomhead++, "No");
	xlsWriteLabel($tablehead, $kolomhead++, "Kd Motor");
	xlsWriteLabel($tablehead, $kolomhead++, "Nama Motor");
	xlsWriteLabel($tablehead, $kolomhead++, "Merek Id");
	xlsWriteLabel($tablehead, $kolomhead++, "Deskripsi");
	xlsWriteLabel($tablehead, $kolomhead++, "Stok");
	xlsWriteLabel($tablehead, $kolomhead++, "Photo");

	foreach ($this->Motor_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->kd_motor);
	    xlsWriteLabel($tablebody, $kolombody++, $data->nama_motor);
	    xlsWriteNumber($tablebody, $kolombody++, $data->merek_id);
	    xlsWriteLabel($tablebody, $kolombody++, $data->deskripsi);
	    xlsWriteNumber($tablebody, $kolombody++, $data->stok);
	    xlsWriteLabel($tablebody, $kolombody++, $data->photo);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=motor.doc");

        $data = array(
            'motor_data' => $this->Motor_model->get_all(),
            'start' => 0
        );
        
        $this->load->view('motor/motor_doc',$data);
    }

}

/* End of file Motor.php */
/* Location: ./application/controllers/Motor.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-06-29 10:31:45 */
/* http://harviacode.com */