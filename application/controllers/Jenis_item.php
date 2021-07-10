<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Jenis_item extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Jenis_item_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->uri->segment(3));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . '.php/c_url/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'index.php/jenis_item/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'index.php/jenis_item/index/';
            $config['first_url'] = base_url() . 'index.php/jenis_item/index/';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = FALSE;
        $config['total_rows'] = $this->Jenis_item_model->total_rows($q);
        $jenis_item = $this->Jenis_item_model->get_limit_data($config['per_page'], $start, $q);
        $config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin pull-right">';
        $config['full_tag_close'] = '</ul>';
        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'jenis_item_data' => $jenis_item,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'menu_accessed' => $this->uri->segment(1),
        );
        $this->template->load('template','jenis_item/jenis_item_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Jenis_item_model->get_by_id($id);
        if ($row) {
            $data = array(
		'jenis_item_id' => $row->jenis_item_id,
		'nama_jenis_item' => $row->nama_jenis_item,
	    );
            $this->template->load('template','jenis_item/jenis_item_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('jenis_item'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('jenis_item/create_action'),
	    'jenis_item_id' => set_value('jenis_item_id'),
	    'nama_jenis_item' => set_value('nama_jenis_item'),
	);
        $this->template->load('template','jenis_item/jenis_item_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'nama_jenis_item' => $this->input->post('nama_jenis_item',TRUE),
	    );

            $this->Jenis_item_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('jenis_item'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Jenis_item_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('jenis_item/update_action'),
		'jenis_item_id' => set_value('jenis_item_id', $row->jenis_item_id),
		'nama_jenis_item' => set_value('nama_jenis_item', $row->nama_jenis_item),
	    );
            $this->template->load('template','jenis_item/jenis_item_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('jenis_item'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('jenis_item_id', TRUE));
        } else {
            $data = array(
		'nama_jenis_item' => $this->input->post('nama_jenis_item',TRUE),
	    );

            $this->Jenis_item_model->update($this->input->post('jenis_item_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('jenis_item'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Jenis_item_model->get_by_id($id);

        if ($row) {
            $this->Jenis_item_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('jenis_item'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('jenis_item'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('nama_jenis_item', 'nama jenis item', 'trim|required');

	$this->form_validation->set_rules('jenis_item_id', 'jenis_item_id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "jenis_item.xls";
        $judul = "jenis_item";
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
	xlsWriteLabel($tablehead, $kolomhead++, "Nama Jenis item");

	foreach ($this->Jenis_item_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->nama_jenis_item);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=jenis_item.doc");

        $data = array(
            'jenis_item_data' => $this->Jenis_item_model->get_all(),
            'start' => 0
        );
        
        $this->load->view('jenis_item/jenis_item_doc',$data);
    }

}

/* End of file Jenis_item.php */
/* Location: ./application/controllers/Jenis_item.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-07-01 08:38:23 */
/* http://harviacode.com */
