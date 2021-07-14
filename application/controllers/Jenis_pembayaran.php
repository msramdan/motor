<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Jenis_pembayaran extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Jenis_pembayaran_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->uri->segment(3));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . '.php/c_url/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'index.php/jenis_pembayaran/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'index.php/jenis_pembayaran/index/';
            $config['first_url'] = base_url() . 'index.php/jenis_pembayaran/index/';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = FALSE;
        $config['total_rows'] = $this->Jenis_pembayaran_model->total_rows($q);
        $jenis_pembayaran = $this->Jenis_pembayaran_model->get_limit_data($config['per_page'], $start, $q);
        $config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin pull-right">';
        $config['full_tag_close'] = '</ul>';
        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'jenis_pembayaran_data' => $jenis_pembayaran,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->template->load('template','jenis_pembayaran/jenis_pembayaran_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Jenis_pembayaran_model->get_by_id($id);
        if ($row) {
            $data = array(
		'jenis_pembayaran_id' => $row->jenis_pembayaran_id,
		'nama_jenis_pembayaran' => $row->nama_jenis_pembayaran,
	    );
            $this->template->load('template','jenis_pembayaran/jenis_pembayaran_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('jenis_pembayaran'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('jenis_pembayaran/create_action'),
	    'jenis_pembayaran_id' => set_value('jenis_pembayaran_id'),
	    'nama_jenis_pembayaran' => set_value('nama_jenis_pembayaran'),
	);
        $this->template->load('template','jenis_pembayaran/jenis_pembayaran_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'nama_jenis_pembayaran' => $this->input->post('nama_jenis_pembayaran',TRUE),
	    );

            $this->Jenis_pembayaran_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('jenis_pembayaran'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Jenis_pembayaran_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('jenis_pembayaran/update_action'),
		'jenis_pembayaran_id' => set_value('jenis_pembayaran_id', $row->jenis_pembayaran_id),
		'nama_jenis_pembayaran' => set_value('nama_jenis_pembayaran', $row->nama_jenis_pembayaran),
	    );
            $this->template->load('template','jenis_pembayaran/jenis_pembayaran_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('jenis_pembayaran'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('jenis_pembayaran_id', TRUE));
        } else {
            $data = array(
		'nama_jenis_pembayaran' => $this->input->post('nama_jenis_pembayaran',TRUE),
	    );

            $this->Jenis_pembayaran_model->update($this->input->post('jenis_pembayaran_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('jenis_pembayaran'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Jenis_pembayaran_model->get_by_id($id);

        if ($row) {
            $this->Jenis_pembayaran_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('jenis_pembayaran'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('jenis_pembayaran'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('nama_jenis_pembayaran', 'nama jenis pembayaran', 'trim|required');

	$this->form_validation->set_rules('jenis_pembayaran_id', 'jenis_pembayaran_id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "jenis_pembayaran.xls";
        $judul = "jenis_pembayaran";
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
	xlsWriteLabel($tablehead, $kolomhead++, "Nama Jenis Pembayaran");

	foreach ($this->Jenis_pembayaran_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->nama_jenis_pembayaran);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

}

/* End of file Jenis_pembayaran.php */
/* Location: ./application/controllers/Jenis_pembayaran.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-07-14 12:22:44 */
/* http://harviacode.com */