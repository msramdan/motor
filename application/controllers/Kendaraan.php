<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Kendaraan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Kendaraan_model');
        $this->load->model('Merek_model');
        $this->load->model('Jenis_kendaraan_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->uri->segment(3));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . '.php/c_url/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'index.php/kendaraan/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'index.php/kendaraan/index/';
            $config['first_url'] = base_url() . 'index.php/kendaraan/index/';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = FALSE;
        $config['total_rows'] = $this->Kendaraan_model->total_rows($q);
        $kendaraan = $this->Kendaraan_model->get_limit_data($config['per_page'], $start, $q);
        $config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin pull-right">';
        $config['full_tag_close'] = '</ul>';
        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'kendaraan_data' => $kendaraan,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->template->load('template','kendaraan/kendaraan_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Kendaraan_model->get_by_id($id);
        if ($row) {
            $data = array(
		'kendaraan_id' => $row->kendaraan_id,
		'kd_motor' => $row->kd_motor,
		'nama_kendaraan' => $row->nama_kendaraan,
		'jenis_kendaraan_id' => $row->jenis_kendaraan_id,
		'merek_id' => $row->merek_id,
		'deskripsi' => $row->deskripsi,
		'stok' => $row->stok,
		'photo' => $row->photo,
	    );
            $this->template->load('template','kendaraan/kendaraan_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('kendaraan'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'jenis' =>$this->Jenis_kendaraan_model->get_all(),
            'merek' =>$this->Merek_model->get_all(),
            'action' => site_url('kendaraan/create_action'),
	    'kendaraan_id' => set_value('kendaraan_id'),
	    'kd_motor' => set_value('kd_motor'),
	    'nama_kendaraan' => set_value('nama_kendaraan'),
	    'jenis_kendaraan_id' => set_value('jenis_kendaraan_id'),
	    'merek_id' => set_value('merek_id'),
	    'deskripsi' => set_value('deskripsi'),
	    'stok' => set_value('stok'),
	    'photo' => set_value('photo'),
	);
        $this->template->load('template','kendaraan/kendaraan_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
         $config['upload_path']      = './assets/img/kendaraan'; 
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
		'nama_kendaraan' => $this->input->post('nama_kendaraan',TRUE),
		'jenis_kendaraan_id' => $this->input->post('jenis_kendaraan_id',TRUE),
		'merek_id' => $this->input->post('merek_id',TRUE),
		'deskripsi' => $this->input->post('deskripsi',TRUE),
		'stok' => $this->input->post('stok',TRUE),
		'photo' => $photo,
	    );

            $this->Kendaraan_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success 2');
            redirect(site_url('kendaraan'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Kendaraan_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'jenis' =>$this->Jenis_kendaraan_model->get_all(),
                'merek' =>$this->Merek_model->get_all(),
                'action' => site_url('kendaraan/update_action'),
		'kendaraan_id' => set_value('kendaraan_id', $row->kendaraan_id),
		'kd_motor' => set_value('kd_motor', $row->kd_motor),
		'nama_kendaraan' => set_value('nama_kendaraan', $row->nama_kendaraan),
		'jenis_kendaraan_id' => set_value('jenis_kendaraan_id', $row->jenis_kendaraan_id),
		'merek_id' => set_value('merek_id', $row->merek_id),
		'deskripsi' => set_value('deskripsi', $row->deskripsi),
		'stok' => set_value('stok', $row->stok),
		'photo' => set_value('photo', $row->photo),
	    );
            $this->template->load('template','kendaraan/kendaraan_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('kendaraan'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('kendaraan_id', TRUE));
        } else {
        $config['upload_path']      = './assets/img/kendaraan'; 
            $config['allowed_types']    = 'jpg|png|jpeg|gif'; 
            $config['max_size']         = 10048; 
            $config['file_name']        = 'File-'.date('ymd').'-'.substr(sha1(rand()),0,10); 
            $this->load->library('upload',$config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload("photo")) {
            $id = $this->input->post('kendaraan_id');
            $row = $this->Kendaraan_model->get_by_id($id);
            $data = $this->upload->data();
            $photo =$data['file_name'];
            if($row->photo==null || $row->photo=='' ){
            }else{

            $target_file = './assets/img/kendaraan/'.$row->photo;
            unlink($target_file);
            
            }
                }else{
                $photo = $this->input->post('photo_lama');
            }

            $data = array(
		'kd_motor' => $this->input->post('kd_motor',TRUE),
		'nama_kendaraan' => $this->input->post('nama_kendaraan',TRUE),
		'jenis_kendaraan_id' => $this->input->post('jenis_kendaraan_id',TRUE),
		'merek_id' => $this->input->post('merek_id',TRUE),
		'deskripsi' => $this->input->post('deskripsi',TRUE),
		'stok' => $this->input->post('stok',TRUE),
		'photo' => $photo,
	    );

            $this->Kendaraan_model->update($this->input->post('kendaraan_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('kendaraan'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Kendaraan_model->get_by_id($id);

        if ($row) {
            if($row->photo==null || $row->photo=='' ){
                }else{
                $target_file = './assets/img/kendaraan/'.$row->photo;
                unlink($target_file);
                }
            $this->Kendaraan_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('kendaraan'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('kendaraan'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('kd_motor', 'kd motor', 'trim|required');
	$this->form_validation->set_rules('nama_kendaraan', 'nama kendaraan', 'trim|required');
	$this->form_validation->set_rules('jenis_kendaraan_id', 'jenis kendaraan id', 'trim|required');
	$this->form_validation->set_rules('merek_id', 'merek id', 'trim|required');
	$this->form_validation->set_rules('deskripsi', 'deskripsi', 'trim|required');
	$this->form_validation->set_rules('stok', 'stok', 'trim|required');
	// $this->form_validation->set_rules('photo', 'photo', 'trim|required');

	$this->form_validation->set_rules('kendaraan_id', 'kendaraan_id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "kendaraan.xls";
        $judul = "kendaraan";
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
	xlsWriteLabel($tablehead, $kolomhead++, "Nama Kendaraan");
	xlsWriteLabel($tablehead, $kolomhead++, "Jenis Kendaraan Id");
	xlsWriteLabel($tablehead, $kolomhead++, "Merek Id");
	xlsWriteLabel($tablehead, $kolomhead++, "Deskripsi");
	xlsWriteLabel($tablehead, $kolomhead++, "Stok");
	xlsWriteLabel($tablehead, $kolomhead++, "Photo");

	foreach ($this->Kendaraan_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->kd_motor);
	    xlsWriteLabel($tablebody, $kolombody++, $data->nama_kendaraan);
	    xlsWriteNumber($tablebody, $kolombody++, $data->jenis_kendaraan_id);
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
        header("Content-Disposition: attachment;Filename=kendaraan.doc");

        $data = array(
            'kendaraan_data' => $this->Kendaraan_model->get_all(),
            'start' => 0
        );
        
        $this->load->view('kendaraan/kendaraan_doc',$data);
    }

}

/* End of file Kendaraan.php */
/* Location: ./application/controllers/Kendaraan.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-07-01 08:37:31 */
/* http://harviacode.com */