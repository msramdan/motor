<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Merek extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Merek_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        is_allowed($this->uri->segment(1),null);
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->uri->segment(3));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . '.php/c_url/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'index.php/merek/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'index.php/merek/index/';
            $config['first_url'] = base_url() . 'index.php/merek/index/';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = FALSE;
        $config['total_rows'] = $this->Merek_model->total_rows($q);
        $merek = $this->Merek_model->get_limit_data($config['per_page'], $start, $q);
        $config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin pull-right">';
        $config['full_tag_close'] = '</ul>';
        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'merek_data' => $merek,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->template->load('template','merek/merek_list', $data);
    }

    public function read($id) 
    {
        is_allowed($this->uri->segment(1),'read');
        $row = $this->Merek_model->get_by_id($id);
        if ($row) {
            $data = array(
		'merek_id' => $row->merek_id,
		'nama_merek' => $row->nama_merek,
	    );
            $this->template->load('template','merek/merek_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('merek'));
        }
    }

    public function create() 
    {
        is_allowed($this->uri->segment(1),'create');
        $data = array(
            'button' => 'Create',
            'action' => site_url('merek/create_action'),
	    'merek_id' => set_value('merek_id'),
	    'nama_merek' => set_value('nama_merek'),
	);
        $this->template->load('template','merek/merek_form', $data);
    }
    
    public function create_action() 
    {
        is_allowed($this->uri->segment(1),'create');
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'nama_merek' => $this->input->post('nama_merek',TRUE),
	    );

            $this->Merek_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('merek'));
        }
    }
    
    public function update($id) 
    {
        is_allowed($this->uri->segment(1),'update');
        $row = $this->Merek_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('merek/update_action'),
		'merek_id' => set_value('merek_id', $row->merek_id),
		'nama_merek' => set_value('nama_merek', $row->nama_merek),
	    );
            $this->template->load('template','merek/merek_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('merek'));
        }
    }
    
    public function update_action() 
    {
        is_allowed($this->uri->segment(1),'update');
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('merek_id', TRUE));
        } else {
            $data = array(
		'nama_merek' => $this->input->post('nama_merek',TRUE),
	    );

            $this->Merek_model->update($this->input->post('merek_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('merek'));
        }
    }
    
    public function delete($id) 
    {
        is_allowed($this->uri->segment(1),'delete');
        $row = $this->Merek_model->get_by_id($id);

        if ($row) {
            $this->Merek_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('merek'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('merek'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('nama_merek', 'nama merek', 'trim|required');

	$this->form_validation->set_rules('merek_id', 'merek_id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        is_allowed($this->uri->segment(1),'export');
        $this->load->helper('exportexcel');
        $namaFile = "merek.xls";
        $judul = "merek";
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
	xlsWriteLabel($tablehead, $kolomhead++, "Nama Merek");

	foreach ($this->Merek_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->nama_merek);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=merek.doc");

        $data = array(
            'merek_data' => $this->Merek_model->get_all(),
            'start' => 0
        );
        
        $this->load->view('merek/merek_doc',$data);
    }

}

/* End of file Merek.php */
/* Location: ./application/controllers/Merek.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-06-29 10:13:27 */
/* http://harviacode.com */