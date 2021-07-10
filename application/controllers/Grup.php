<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Grup extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Grup_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        is_allowed($this->uri->segment(1),null);
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->uri->segment(3));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . '.php/c_url/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'index.php/grup/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'index.php/grup/index/';
            $config['first_url'] = base_url() . 'index.php/grup/index/';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = FALSE;
        $config['total_rows'] = $this->Grup_model->total_rows($q);
        $grup = $this->Grup_model->get_limit_data($config['per_page'], $start, $q);
        $config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin pull-right">';
        $config['full_tag_close'] = '</ul>';
        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'grup_data' => $grup,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->template->load('template','grup/grup_list', $data);
    }

    public function read($id) 
    {
        is_allowed($this->uri->segment(1),'read');
        $row = $this->Grup_model->get_by_id($id);
        if ($row) {
            $data = array(
		'grup_id' => $row->grup_id,
		'nama_grup' => $row->nama_grup,
	    );
            $this->template->load('template','grup/grup_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('grup'));
        }
    }

    public function create() 
    {
        is_allowed($this->uri->segment(1),'create');
        $data = array(
            'button' => 'Create',
            'kodeunik' =>$this->Grup_model->buat_kode(),
            'action' => site_url('grup/create_action'),
	    'grup_id' => set_value('grup_id'),
        'kd_grup' => set_value('kd_grup'),
	    'nama_grup' => set_value('nama_grup'),
	);
        $this->template->load('template','grup/grup_form', $data);
    }
    
    public function create_action() 
    {
        is_allowed($this->uri->segment(1),'create');
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'kd_grup' => $this->input->post('kd_grup',TRUE),
		'nama_grup' => $this->input->post('nama_grup',TRUE),
	    );

            $this->Grup_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('grup'));
        }
    }
    
    public function update($id) 
    {
        is_allowed($this->uri->segment(1),'update');
        $row = $this->Grup_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('grup/update_action'),
		'grup_id' => set_value('grup_id', $row->grup_id),
        'kd_grup' => set_value('kd_grup', $row->kd_grup),
		'nama_grup' => set_value('nama_grup', $row->nama_grup),
	    );
            $this->template->load('template','grup/grup_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('grup'));
        }
    }
    
    public function update_action() 
    {
        is_allowed($this->uri->segment(1),'update');
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('grup_id', TRUE));
        } else {
            $data = array(
                'kd_grup' => $this->input->post('kd_grup',TRUE),
		'nama_grup' => $this->input->post('nama_grup',TRUE),
	    );

            $this->Grup_model->update($this->input->post('grup_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('grup'));
        }
    }
    
    public function delete($id) 
    {
        is_allowed($this->uri->segment(1),'delete');
        $row = $this->Grup_model->get_by_id($id);

        if ($row) {
            $this->Grup_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('grup'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('grup'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('nama_grup', 'nama grup', 'trim|required');

	$this->form_validation->set_rules('grup_id', 'grup_id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        is_allowed($this->uri->segment(1),'export');
        $this->load->helper('exportexcel');
        $namaFile = "grup.xls";
        $judul = "grup";
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
	xlsWriteLabel($tablehead, $kolomhead++, "Nama Grup");

	foreach ($this->Grup_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->nama_grup);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

}

/* End of file Grup.php */
/* Location: ./application/controllers/Grup.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-07-06 09:25:51 */
/* http://harviacode.com */