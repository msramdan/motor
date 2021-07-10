<?php

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Karyawan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Karyawan_model');
        $this->load->model('Unit_model');
        $this->load->library('form_validation');
        $this->load->library('pdf');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->uri->segment(3));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . '.php/c_url/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'index.php/karyawan/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'index.php/karyawan/index/';
            $config['first_url'] = base_url() . 'index.php/karyawan/index/';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = FALSE;
        $config['total_rows'] = $this->Karyawan_model->total_rows($q);
        $karyawan = $this->Karyawan_model->get_limit_data($config['per_page'], $start, $q);
        $config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin pull-right">';
        $config['full_tag_close'] = '</ul>';
        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'karyawan_data' => $karyawan,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'menu_accessed' => $this->uri->segment(1),
        );
        $this->template->load('template','karyawan/karyawan_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Karyawan_model->get_by_id($id);
        if ($row) {
            $data = array(
        		'karyawan_id' => $row->karyawan_id,
        		'nama_karyawan' => $row->nama_karyawan,
        		'no_ktp_karyawan' => $row->no_ktp_karyawan,
        		'no_hp_karyawan' => $row->no_hp_karyawan,
        		'jenis_kelamin' => $row->jenis_kelamin,
        		'pendidikan' => $row->pendidikan,
        		'alamat' => $row->alamat,
        		'unit_id' => $row->nama_unit,
        		'photo' => $row->photo,
    	    );
            $this->template->load('template','karyawan/karyawan_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('karyawan'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'unit' =>$this->Unit_model->get_all(),
            'action' => site_url('karyawan/create_action'),
	    'karyawan_id' => set_value('karyawan_id'),
	    'nama_karyawan' => set_value('nama_karyawan'),
	    'no_ktp_karyawan' => set_value('no_ktp_karyawan'),
	    'no_hp_karyawan' => set_value('no_hp_karyawan'),
	    'jenis_kelamin' => set_value('jenis_kelamin'),
	    'pendidikan' => set_value('pendidikan'),
	    'alamat' => set_value('alamat'),
	    'unit_id' => set_value('unit_id'),
	    'photo' => set_value('photo'),
	);
        $this->template->load('template','karyawan/karyawan_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {

            $config['upload_path']      = './assets/img/karyawan'; 
            $config['allowed_types']    = 'jpg|png|jpeg'; 
            $config['max_size']         = 10048; 
            $config['file_name']        = 'File-'.date('ymd').'-'.substr(sha1(rand()),0,10); 
            $this->load->library('upload',$config);
            $this->upload->initialize($config);
            $this->upload->do_upload("photo");
            $data = $this->upload->data();
            
            $photo = $data['file_name'];

            $record = array(
        		'nama_karyawan' => $this->input->post('nama_karyawan',TRUE),
        		'no_ktp_karyawan' => $this->input->post('no_ktp_karyawan',TRUE),
        		'no_hp_karyawan' => $this->input->post('no_hp_karyawan',TRUE),
        		'jenis_kelamin' => $this->input->post('jenis_kelamin',TRUE),
        		'pendidikan' => $this->input->post('pendidikan',TRUE),
        		'alamat' => $this->input->post('alamat',TRUE),
        		'unit_id' => $this->input->post('unit_id',TRUE),
        		'photo' => $photo,
    	    );
            $this->Karyawan_model->insert($record);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('karyawan'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Karyawan_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'unit' =>$this->Unit_model->get_all(),
                'action' => site_url('karyawan/update_action'),
		'karyawan_id' => set_value('karyawan_id', $row->karyawan_id),
		'nama_karyawan' => set_value('nama_karyawan', $row->nama_karyawan),
		'no_ktp_karyawan' => set_value('no_ktp_karyawan', $row->no_ktp_karyawan),
		'no_hp_karyawan' => set_value('no_hp_karyawan', $row->no_hp_karyawan),
		'jenis_kelamin' => set_value('jenis_kelamin', $row->jenis_kelamin),
		'pendidikan' => set_value('pendidikan', $row->pendidikan),
		'alamat' => set_value('alamat', $row->alamat),
		'unit_id' => set_value('unit_id', $row->unit_id),
		'photo' => set_value('photo', $row->photo),
	    );
            $this->template->load('template','karyawan/karyawan_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('karyawan'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('karyawan_id', TRUE));
        } else {

        $config['upload_path']      = './assets/img/karyawan'; 
            $config['allowed_types']    = 'jpg|png|jpeg|gif'; 
            $config['max_size']         = 10048; 
            $config['file_name']        = 'File-'.date('ymd').'-'.substr(sha1(rand()),0,10); 
            $this->load->library('upload',$config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload("photo")) {
            $id = $this->input->post('karyawan_id');
            $row = $this->Karyawan_model->get_by_id($id);
            $data = $this->upload->data();
            $photo =$data['file_name'];
            if($row->photo==null || $row->photo=='' ){
            }else{

            $target_file = './assets/img/karyawan/'.$row->photo;
            unlink($target_file);
            
            }
                }else{
                $photo = $this->input->post('photo_lama');
            }


            $record = array(
		'nama_karyawan' => $this->input->post('nama_karyawan',TRUE),
		'no_ktp_karyawan' => $this->input->post('no_ktp_karyawan',TRUE),
		'no_hp_karyawan' => $this->input->post('no_hp_karyawan',TRUE),
		'jenis_kelamin' => $this->input->post('jenis_kelamin',TRUE),
		'pendidikan' => $this->input->post('pendidikan',TRUE),
		'alamat' => $this->input->post('alamat',TRUE),
		'unit_id' => $this->input->post('unit_id',TRUE),
		'photo' => $photo,
	    );

            $this->Karyawan_model->update($this->input->post('karyawan_id', TRUE), $record);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('karyawan'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Karyawan_model->get_by_id($id);

        if ($row) {

            if($row->photo==null || $row->photo=='' ){
                }else{
                $target_file = './assets/img/karyawan/'.$row->photo;
                unlink($target_file);
                }


            $this->Karyawan_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('karyawan'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('karyawan'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('nama_karyawan', 'nama karyawan', 'trim|required');
	$this->form_validation->set_rules('no_ktp_karyawan', 'no ktp karyawan', 'trim|required');
	$this->form_validation->set_rules('no_hp_karyawan', 'no hp karyawan', 'trim|required');
	$this->form_validation->set_rules('jenis_kelamin', 'jenis kelamin', 'trim|required');
	$this->form_validation->set_rules('pendidikan', 'pendidikan', 'trim|required');
	$this->form_validation->set_rules('alamat', 'alamat', 'trim|required');
	$this->form_validation->set_rules('unit_id', 'unit id', 'trim|required');

	$this->form_validation->set_rules('karyawan_id', 'karyawan_id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "karyawan.xls";
        $judul = "karyawan";
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
    	xlsWriteLabel($tablehead, $kolomhead++, "Nama Karyawan");
    	xlsWriteLabel($tablehead, $kolomhead++, "No Ktp Karyawan");
    	xlsWriteLabel($tablehead, $kolomhead++, "No Hp Karyawan");
    	xlsWriteLabel($tablehead, $kolomhead++, "Jenis Kelamin");
    	xlsWriteLabel($tablehead, $kolomhead++, "Pendidikan");
    	xlsWriteLabel($tablehead, $kolomhead++, "Alamat");
    	xlsWriteLabel($tablehead, $kolomhead++, "Unit");
    	xlsWriteLabel($tablehead, $kolomhead++, "Photo");

    	foreach ($this->Karyawan_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
    	    xlsWriteLabel($tablebody, $kolombody++, $data->nama_karyawan);
    	    xlsWriteLabel($tablebody, $kolombody++, $data->no_ktp_karyawan);
    	    xlsWriteLabel($tablebody, $kolombody++, $data->no_hp_karyawan);
    	    xlsWriteLabel($tablebody, $kolombody++, $data->jenis_kelamin);
    	    xlsWriteLabel($tablebody, $kolombody++, $data->pendidikan);
    	    xlsWriteLabel($tablebody, $kolombody++, $data->alamat);
    	    xlsWriteLabel($tablebody, $kolombody++, $data->nama_unit);
    	    xlsWriteLabel($tablebody, $kolombody++, $data->photo);

    	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function download($gambar) {
        if($gambar === 'no-photo-download') {
            force_download('assets/img/karyawan/no-photo.jpg',NULL);
        } else {
            force_download('assets/img/karyawan/'.$gambar,NULL);
        }
    }

    public function cetak_data($id) {

        $defaultphoto = base_url().'assets/img/karyawan/no-photo.jpg';

        $pdf = new FPDF('p','mm','A4');
        $data = $this->Karyawan_model->get_by_id($id);

        $gambar = base_url().'assets/img/karyawan/'.$data->photo;
        $pdf->AddPage();

        $pdf->setXY(0, 40);
        $pdf->SetFont('Arial','B',16);$pdf->Cell(0,7,'DATA KARYAWAN',0,0,'C');
        
        $pdf->Image($data->photo ? $gambar : $defaultphoto,150, 15, 35, 50);
        
        $pdf->setY(90);
        $pdf->SetFont('Arial','',12);
        $pdf->Cell(10,10,'1.',0,0,'L');
        $pdf->Cell(50,10,'Nama Lengkap',0,0,'L');
        $pdf->Cell(4,10,':',0,0,'L');
        $pdf->Cell(100,10,$data->nama_karyawan,0,1,'L');
        $pdf->Cell(10,10,'2.',0,0,'L');
        $pdf->Cell(50,10,'No. KTP',0,0,'L');
        $pdf->Cell(4,10,':',0,0,'L');
        $pdf->Cell(100,10,$data->no_ktp_karyawan,0,1,'L');
        $pdf->Cell(10,10,'3.',0,0,'L');
        $pdf->Cell(50,10,'No. HP',0,0,'L');
        $pdf->Cell(4,10,':',0,0,'L');
        $pdf->Cell(100,10,$data->no_hp_karyawan,0,1,'L');
        $pdf->Cell(10,10,'4.',0,0,'L');
        $pdf->Cell(50,10,'Jenis Kelamin',0,0,'L');
        $pdf->Cell(4,10,':',0,0,'L');
        $pdf->Cell(100,10,$data->no_ktp_karyawan,0,1,'L');
        $pdf->Cell(10,10,'5.',0,0,'L');
        $pdf->Cell(50,10,'Pendidikan Terakhir',0,0,'L');
        $pdf->Cell(4,10,':',0,0,'L');
        $pdf->Cell(100,10,$data->pendidikan,0,1,'L');
        $pdf->Cell(10,10,'6.',0,0,'L');
        $pdf->Cell(50,10,'Alamat',0,0,'L');
        $pdf->Cell(4,10,':',0,0,'L');
        $pdf->Cell(100,10,$data->alamat,0,1,'L');

        $pdf->setXY(142,65);
        $pdf->multiCell(50,7,$data->nama_unit,0,'C',false);        

        $pdf->Output('result.pdf', 'D');
    }

}

/* End of file Karyawan.php */
/* Location: ./application/controllers/Karyawan.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-07-06 16:02:13 */
/* http://harviacode.com */