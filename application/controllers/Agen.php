<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Agen extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Agen_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->uri->segment(3));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . '.php/c_url/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'index.php/agen/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'index.php/agen/index/';
            $config['first_url'] = base_url() . 'index.php/agen/index/';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = FALSE;
        $config['total_rows'] = $this->Agen_model->total_rows($q);
        $agen = $this->Agen_model->get_limit_data($config['per_page'], $start, $q);
        $config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin pull-right">';
        $config['full_tag_close'] = '</ul>';
        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'agen_data' => $agen,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->template->load('template','agen/agen_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Agen_model->get_by_id($id);
        if ($row) {
            $data = array(
		'agen_id' => $row->agen_id,
		'nama_agen' => $row->nama_agen,
		'no_hp_agen' => $row->no_hp_agen,
		'alamat' => $row->alamat,
		'deskripsi' => $row->deskripsi,
	    );
            $this->template->load('template','agen/agen_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('agen'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('agen/create_action'),
	    'agen_id' => set_value('agen_id'),
	    'nama_agen' => set_value('nama_agen'),
	    'no_hp_agen' => set_value('no_hp_agen'),
	    'alamat' => set_value('alamat'),
	    'deskripsi' => set_value('deskripsi'),
	);
        $this->template->load('template','agen/agen_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'unit_id' => $this->input->post('unit_id',TRUE),
		'nama_agen' => $this->input->post('nama_agen',TRUE),
		'no_hp_agen' => $this->input->post('no_hp_agen',TRUE),
		'alamat' => $this->input->post('alamat',TRUE),
		'deskripsi' => $this->input->post('deskripsi',TRUE),
	    );

            $this->Agen_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('agen'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Agen_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('agen/update_action'),
		'agen_id' => set_value('agen_id', $row->agen_id),
		'nama_agen' => set_value('nama_agen', $row->nama_agen),
		'no_hp_agen' => set_value('no_hp_agen', $row->no_hp_agen),
		'alamat' => set_value('alamat', $row->alamat),
		'deskripsi' => set_value('deskripsi', $row->deskripsi),
	    );
            $this->template->load('template','agen/agen_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('agen'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('agen_id', TRUE));
        } else {
            $data = array(
                'unit_id' => $this->input->post('unit_id',TRUE),
		'nama_agen' => $this->input->post('nama_agen',TRUE),
		'no_hp_agen' => $this->input->post('no_hp_agen',TRUE),
		'alamat' => $this->input->post('alamat',TRUE),
		'deskripsi' => $this->input->post('deskripsi',TRUE),
	    );

            $this->Agen_model->update($this->input->post('agen_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('agen'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Agen_model->get_by_id($id);

        if ($row) {
            $this->Agen_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('agen'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('agen'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('nama_agen', 'nama agen', 'trim|required');
	$this->form_validation->set_rules('no_hp_agen', 'no hp agen', 'trim|required');
	$this->form_validation->set_rules('alamat', 'alamat', 'trim|required');
	$this->form_validation->set_rules('deskripsi', 'deskripsi', 'trim|required');

	$this->form_validation->set_rules('agen_id', 'agen_id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "agen.xls";
        $judul = "agen";
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
	xlsWriteLabel($tablehead, $kolomhead++, "Nama Agen");
	xlsWriteLabel($tablehead, $kolomhead++, "No Hp Agen");
	xlsWriteLabel($tablehead, $kolomhead++, "Alamat");
	xlsWriteLabel($tablehead, $kolomhead++, "Deskripsi");

	foreach ($this->Agen_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->nama_agen);
	    xlsWriteLabel($tablebody, $kolombody++, $data->no_hp_agen);
	    xlsWriteLabel($tablebody, $kolombody++, $data->alamat);
	    xlsWriteLabel($tablebody, $kolombody++, $data->deskripsi);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=agen.doc");

        $data = array(
            'agen_data' => $this->Agen_model->get_all(),
            'start' => 0
        );
        
        $this->load->view('agen/agen_doc',$data);
    }

}

/* End of file Agen.php */
/* Location: ./application/controllers/Agen.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-07-02 03:59:05 */
/* http://harviacode.com */