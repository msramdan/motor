<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Menu extends CI_Controller
{

     function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Menu_model');
        $this->load->model('Sub_menu_model');
        
       
    }

    public function index()
    {
        is_allowed($this->uri->segment(1),null);
        $data['row']= $this->Menu_model->get();
        $data['row2']= $this->Sub_menu_model->get();
        $data['menu_accessed'] = $this->uri->segment(1);
        $this->template->load('template','menu/menu_list', $data);
    }

    public function create() 
    {
        is_allowed($this->uri->segment(1),'create');
        $data = array(
            'button' => 'Create',
            'action' => site_url('menu/create_action'),
	    'menu_id' => set_value('menu_id'),
	    'menu' => set_value('menu'),
	    'icon' => set_value('icon'),
	    'urutan' => set_value('urutan'),
	);
        $this->template->load('template','menu/menu_form', $data);
    }
    
    public function create_action() 
    {
        is_allowed($this->uri->segment(1),'create');
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'menu' => $this->input->post('menu',TRUE),
		'icon' => $this->input->post('icon',TRUE),
		'urutan' => $this->input->post('urutan',TRUE),
	    );

            $this->Menu_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('menu'));
        }
    }
    
    public function update($id) 
    {
        is_allowed($this->uri->segment(1),'update');
        $row = $this->Menu_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('menu/update_action'),
		'menu_id' => set_value('menu_id', $row->menu_id),
		'menu' => set_value('menu', $row->menu),
		'icon' => set_value('icon', $row->icon),
		'urutan' => set_value('urutan', $row->urutan),
	    );
            $this->template->load('template','menu/menu_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('menu'));
        }
    }
    
    public function update_action() 
    {
        is_allowed($this->uri->segment(1),'update');
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('menu_id', TRUE));
        } else {
            $data = array(
		'menu' => $this->input->post('menu',TRUE),
		'icon' => $this->input->post('icon',TRUE),
		'urutan' => $this->input->post('urutan',TRUE),
	    );

            $this->Menu_model->update($this->input->post('menu_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('menu'));
        }
    }
    
    public function delete($id) 
    {
        is_allowed($this->uri->segment(1),'delete');
        $row = $this->Menu_model->get_by_id($id);

        if ($row) {
            $this->Menu_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('menu'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('menu'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('menu', 'menu', 'trim|required');
	$this->form_validation->set_rules('icon', 'icon', 'trim|required');
	$this->form_validation->set_rules('urutan', 'urutan', 'trim|required');

	$this->form_validation->set_rules('menu_id', 'menu_id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Menu.php */
/* Location: ./application/controllers/Menu.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-07-06 06:51:59 */
/* http://harviacode.com */