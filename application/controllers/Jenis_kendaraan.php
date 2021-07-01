<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Jenis_kendaraan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Jenis_kendaraan_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->uri->segment(3));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . '.php/c_url/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'index.php/jenis_kendaraan/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'index.php/jenis_kendaraan/index/';
            $config['first_url'] = base_url() . 'index.php/jenis_kendaraan/index/';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = FALSE;
        $config['total_rows'] = $this->Jenis_kendaraan_model->total_rows($q);
        $jenis_kendaraan = $this->Jenis_kendaraan_model->get_limit_data($config['per_page'], $start, $q);
        $config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin pull-right">';
        $config['full_tag_close'] = '</ul>';
        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'jenis_kendaraan_data' => $jenis_kendaraan,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->template->load('template','jenis_kendaraan/jenis_kendaraan_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Jenis_kendaraan_model->get_by_id($id);
        if ($row) {
            $data = array(
		'jenis_kendaraan_id' => $row->jenis_kendaraan_id,
		'nama_jenis_kendaraan' => $row->nama_jenis_kendaraan,
	    );
            $this->template->load('template','jenis_kendaraan/jenis_kendaraan_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('jenis_kendaraan'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('jenis_kendaraan/create_action'),
	    'jenis_kendaraan_id' => set_value('jenis_kendaraan_id'),
	    'nama_jenis_kendaraan' => set_value('nama_jenis_kendaraan'),
	);
        $this->template->load('template','jenis_kendaraan/jenis_kendaraan_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'nama_jenis_kendaraan' => $this->input->post('nama_jenis_kendaraan',TRUE),
	    );

            $this->Jenis_kendaraan_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success 2');
            redirect(site_url('jenis_kendaraan'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Jenis_kendaraan_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('jenis_kendaraan/update_action'),
		'jenis_kendaraan_id' => set_value('jenis_kendaraan_id', $row->jenis_kendaraan_id),
		'nama_jenis_kendaraan' => set_value('nama_jenis_kendaraan', $row->nama_jenis_kendaraan),
	    );
            $this->template->load('template','jenis_kendaraan/jenis_kendaraan_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('jenis_kendaraan'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('jenis_kendaraan_id', TRUE));
        } else {
            $data = array(
		'nama_jenis_kendaraan' => $this->input->post('nama_jenis_kendaraan',TRUE),
	    );

            $this->Jenis_kendaraan_model->update($this->input->post('jenis_kendaraan_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('jenis_kendaraan'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Jenis_kendaraan_model->get_by_id($id);

        if ($row) {
            $this->Jenis_kendaraan_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('jenis_kendaraan'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('jenis_kendaraan'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('nama_jenis_kendaraan', 'nama jenis kendaraan', 'trim|required');

	$this->form_validation->set_rules('jenis_kendaraan_id', 'jenis_kendaraan_id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "jenis_kendaraan.xls";
        $judul = "jenis_kendaraan";
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
	xlsWriteLabel($tablehead, $kolomhead++, "Nama Jenis Kendaraan");

	foreach ($this->Jenis_kendaraan_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->nama_jenis_kendaraan);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=jenis_kendaraan.doc");

        $data = array(
            'jenis_kendaraan_data' => $this->Jenis_kendaraan_model->get_all(),
            'start' => 0
        );
        
        $this->load->view('jenis_kendaraan/jenis_kendaraan_doc',$data);
    }

}

/* End of file Jenis_kendaraan.php */
/* Location: ./application/controllers/Jenis_kendaraan.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-07-01 08:38:23 */
/* http://harviacode.com */