<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Info extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Info_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        is_allowed($this->uri->segment(1),null);
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->uri->segment(3));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . '.php/c_url/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'index.php/info/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'index.php/info/index/';
            $config['first_url'] = base_url() . 'index.php/info/index/';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = FALSE;
        $config['total_rows'] = $this->Info_model->total_rows($q);
        $info = $this->Info_model->get_limit_data($config['per_page'], $start, $q);
        $config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin pull-right">';
        $config['full_tag_close'] = '</ul>';
        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'info_data' => $info,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'menu_accessed' => $this->uri->segment(1),
        );
        $this->template->load('template','info/info_list', $data);
    }

    public function read($id) 
    {
        is_allowed($this->uri->segment(1),'read');
        $row = $this->Info_model->get_by_id($id);
        if ($row) {
            $data = array(
		'info_id' => $row->info_id,
		'title' => $row->title,
		'desk' => $row->desk,
	    );
            $this->template->load('template','info/info_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('info'));
        }
    }

    public function create() 
    {
        is_allowed($this->uri->segment(1),'create');
        $data = array(
            'button' => 'Create',
            'action' => site_url('info/create_action'),
	    'info_id' => set_value('info_id'),
	    'title' => set_value('title'),
	    'desk' => set_value('desk'),
	);
        $this->template->load('template','info/info_form', $data);
    }
    
    public function create_action() 
    {
        is_allowed($this->uri->segment(1),'create');
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'title' => $this->input->post('title',TRUE),
		'desk' => $this->input->post('desk',TRUE),
	    );

            $this->Info_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('info'));
        }
    }
    
    public function update($id) 
    {
        is_allowed($this->uri->segment(1),'update');
        $row = $this->Info_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('info/update_action'),
		'info_id' => set_value('info_id', $row->info_id),
		'title' => set_value('title', $row->title),
		'desk' => set_value('desk', $row->desk),
	    );
            $this->template->load('template','info/info_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('info'));
        }
    }
    
    public function update_action() 
    {
        is_allowed($this->uri->segment(1),'update');
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('info_id', TRUE));
        } else {
            $data = array(
		'title' => $this->input->post('title',TRUE),
		'desk' => $this->input->post('desk',TRUE),
	    );

            $this->Info_model->update($this->input->post('info_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('info'));
        }
    }
    
    public function delete($id) 
    {
        is_allowed($this->uri->segment(1),'delete');
        $row = $this->Info_model->get_by_id($id);

        if ($row) {
            $this->Info_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('info'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('info'));
        }
    }

    public function _rules() 
    {
    	$this->form_validation->set_rules('title', 'title', 'trim|required');
    	$this->form_validation->set_rules('desk', 'desk', 'trim|required');

    	$this->form_validation->set_rules('info_id', 'info_id', 'trim');
    	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
}

/* End of file Info.php */
/* Location: ./application/controllers/Info.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-07-08 16:30:30 */
/* http://harviacode.com */