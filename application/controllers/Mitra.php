<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mitra extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Mitra_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        is_allowed($this->uri->segment(1),null);
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->uri->segment(3));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . '.php/c_url/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'index.php/mitra/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'index.php/mitra/index/';
            $config['first_url'] = base_url() . 'index.php/mitra/index/';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = FALSE;
        $config['total_rows'] = $this->Mitra_model->total_rows($q);
        $mitra = $this->Mitra_model->get_limit_data($config['per_page'], $start, $q);
        $config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin pull-right">';
        $config['full_tag_close'] = '</ul>';
        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'mitra_data' => $mitra,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->template->load('template','mitra/mitra_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Mitra_model->get_by_id($id);
        if ($row) {
            $data = array(
		'mitra_id' => $row->mitra_id,
		'nama_mitra' => $row->nama_mitra,
		'no_hp_mitra' => $row->no_hp_mitra,
		'alamat' => $row->alamat,
		'deskripsi' => $row->deskripsi,
		'unit_id' => $row->unit_id,
	    );
            $this->template->load('template','mitra/mitra_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('mitra'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('mitra/create_action'),
	    'mitra_id' => set_value('mitra_id'),
	    'nama_mitra' => set_value('nama_mitra'),
	    'no_hp_mitra' => set_value('no_hp_mitra'),
	    'alamat' => set_value('alamat'),
	    'deskripsi' => set_value('deskripsi'),
	    'unit_id' => set_value('unit_id'),
	);
        $this->template->load('template','mitra/mitra_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'nama_mitra' => $this->input->post('nama_mitra',TRUE),
		'no_hp_mitra' => $this->input->post('no_hp_mitra',TRUE),
		'alamat' => $this->input->post('alamat',TRUE),
		'deskripsi' => $this->input->post('deskripsi',TRUE),
		'unit_id' => $this->input->post('unit_id',TRUE),
	    );

            $this->Mitra_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('mitra'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Mitra_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('mitra/update_action'),
		'mitra_id' => set_value('mitra_id', $row->mitra_id),
		'nama_mitra' => set_value('nama_mitra', $row->nama_mitra),
		'no_hp_mitra' => set_value('no_hp_mitra', $row->no_hp_mitra),
		'alamat' => set_value('alamat', $row->alamat),
		'deskripsi' => set_value('deskripsi', $row->deskripsi),
		'unit_id' => set_value('unit_id', $row->unit_id),
	    );
            $this->template->load('template','mitra/mitra_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('mitra'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('mitra_id', TRUE));
        } else {
            $data = array(
		'nama_mitra' => $this->input->post('nama_mitra',TRUE),
		'no_hp_mitra' => $this->input->post('no_hp_mitra',TRUE),
		'alamat' => $this->input->post('alamat',TRUE),
		'deskripsi' => $this->input->post('deskripsi',TRUE),
		'unit_id' => $this->input->post('unit_id',TRUE),
	    );

            $this->Mitra_model->update($this->input->post('mitra_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('mitra'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Mitra_model->get_by_id($id);

        if ($row) {
            $this->Mitra_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('mitra'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('mitra'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('nama_mitra', 'nama mitra', 'trim|required');
	$this->form_validation->set_rules('no_hp_mitra', 'no hp mitra', 'trim|required');
	$this->form_validation->set_rules('alamat', 'alamat', 'trim|required');
	$this->form_validation->set_rules('deskripsi', 'deskripsi', 'trim|required');
	$this->form_validation->set_rules('unit_id', 'unit id', 'trim|required');

	$this->form_validation->set_rules('mitra_id', 'mitra_id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "mitra.xls";
        $judul = "mitra";
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
	xlsWriteLabel($tablehead, $kolomhead++, "Nama Mitra");
	xlsWriteLabel($tablehead, $kolomhead++, "No Hp Mitra");
	xlsWriteLabel($tablehead, $kolomhead++, "Alamat");
	xlsWriteLabel($tablehead, $kolomhead++, "Deskripsi");

	foreach ($this->Mitra_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->nama_mitra);
	    xlsWriteLabel($tablebody, $kolombody++, $data->no_hp_mitra);
	    xlsWriteLabel($tablebody, $kolombody++, $data->alamat);
	    xlsWriteLabel($tablebody, $kolombody++, $data->deskripsi);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

}

/* End of file Mitra.php */
/* Location: ./application/controllers/Mitra.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-07-14 07:33:22 */
/* http://harviacode.com */