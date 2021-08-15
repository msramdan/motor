<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Approval_lists extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Approval_lists_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->uri->segment(3));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . '.php/c_url/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'index.php/approval_lists/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'index.php/approval_lists/index/';
            $config['first_url'] = base_url() . 'index.php/approval_lists/index/';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = FALSE;
        $config['total_rows'] = $this->Approval_lists_model->total_rows($q);
        $approval_lists = $this->Approval_lists_model->get_limit_data($config['per_page'], $start, $q);
        $config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin pull-right">';
        $config['full_tag_close'] = '</ul>';
        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'approval_lists_data' => $approval_lists,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start
        );
        $this->template->load('template','approval_lists/approval_lists_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Approval_lists_model->get_by_id($id);
        if ($row) {
            $data = array(
		'approval_id' => $row->approval_id,
		'invoice_id' => $row->invoice_id,
		'approve_by' => $row->approve_by,
		'approval_status' => $row->approval_status,
		'keterangan' => $row->keterangan,
		'komentar' => $row->komentar,
	    );
            $this->template->load('template','approval_lists/approval_lists_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('approval_lists'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('approval_lists/create_action'),
    	    'approval_id' => set_value('approval_id'),
    	    'invoice_id' => set_value('invoice_id'),
    	    'approve_by' => set_value('approve_by'),
    	    'approval_status' => set_value('approval_status'),
    	    'keterangan' => set_value('keterangan'),
    	    'komentar' => set_value('komentar'),
    	);
        $this->template->load('template','approval_lists/approval_lists_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
        		'invoice_id' => $this->input->post('invoice_id',TRUE),
        		'approve_by' => $this->input->post('approve_by',TRUE),
        		'approval_status' => $this->input->post('approval_status',TRUE),
        		'keterangan' => $this->input->post('keterangan',TRUE),
        		'komentar' => $this->input->post('komentar',TRUE),
            );

            $this->Approval_lists_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('approval_lists'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Approval_lists_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('approval_lists/update_action'),
		'approval_id' => set_value('approval_id', $row->approval_id),
		'invoice_id' => set_value('invoice_id', $row->invoice_id),
		'approve_by' => set_value('approve_by', $row->approve_by),
		'approval_status' => set_value('approval_status', $row->approval_status),
		'keterangan' => set_value('keterangan', $row->keterangan),
		'komentar' => set_value('komentar', $row->komentar),
	    );
            $this->template->load('template','approval_lists/approval_lists_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('approval_lists'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('approval_id', TRUE));
        } else {
            $data = array(
		'invoice_id' => $this->input->post('invoice_id',TRUE),
		'approve_by' => $this->input->post('approve_by',TRUE),
		'approval_status' => $this->input->post('approval_status',TRUE),
		'keterangan' => $this->input->post('keterangan',TRUE),
		'komentar' => $this->input->post('komentar',TRUE),
	    );

            $this->Approval_lists_model->update($this->input->post('approval_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('approval_lists'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Approval_lists_model->get_by_id($id);

        if ($row) {
            $this->Approval_lists_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('approval_lists'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('approval_lists'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('invoice_id', 'invoice id', 'trim|required');
	$this->form_validation->set_rules('approve_by', 'approve by', 'trim|required');
	$this->form_validation->set_rules('approval_status', 'approval status', 'trim|required');
	$this->form_validation->set_rules('keterangan', 'keterangan', 'trim|required');
	$this->form_validation->set_rules('komentar', 'komentar', 'trim|required');

	$this->form_validation->set_rules('approval_id', 'approval_id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "approval_lists.xls";
        $judul = "approval_lists";
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
	xlsWriteLabel($tablehead, $kolomhead++, "Invoice Id");
	xlsWriteLabel($tablehead, $kolomhead++, "Approve By");
	xlsWriteLabel($tablehead, $kolomhead++, "Approval Status");
	xlsWriteLabel($tablehead, $kolomhead++, "Keterangan");
	xlsWriteLabel($tablehead, $kolomhead++, "Komentar");

	foreach ($this->Approval_lists_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->invoice_id);
	    xlsWriteLabel($tablebody, $kolombody++, $data->approve_by);
	    xlsWriteLabel($tablebody, $kolombody++, $data->approval_status);
	    xlsWriteLabel($tablebody, $kolombody++, $data->keterangan);
	    xlsWriteLabel($tablebody, $kolombody++, $data->komentar);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=approval_lists.doc");

        $data = array(
            'approval_lists_data' => $this->Approval_lists_model->get_all(),
            'start' => 0
        );
        
        $this->load->view('approval_lists/approval_lists_doc',$data);
    }

}

/* End of file Approval_lists.php */
/* Location: ./application/controllers/Approval_lists.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-08-14 14:49:50 */
/* http://harviacode.com */