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
        is_allowed($this->uri->segment(1),null);
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
        is_allowed($this->uri->segment(1),'read');
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
        is_allowed($this->uri->segment(1),'create');
        $data = array(
            'button' => 'Create',
            'action' => site_url('jenis_item/create_action'),
	    'jenis_item_id' => set_value('jenis_item_id'),
	    'nama_jenis_item' => set_value('nama_jenis_item'),
	);
        $this->template->load('template','jenis_item/jenis_item_form', $data);
    }

}

/* End of file Jenis_item.php */
/* Location: ./application/controllers/Jenis_item.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-07-01 08:38:23 */
/* http://harviacode.com */
