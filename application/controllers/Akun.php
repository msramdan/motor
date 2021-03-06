<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Akun extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('User_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $row = $this->User_model->get_by_id($this->session->userdata('userid'));

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('akun/update_action'),
                'user_id' => set_value('user_id', $row->user_id),
                'nama_user' => set_value('nama_user', $row->nama_user),
                'email' => set_value('email', $row->email),
                'no_hp_user' => set_value('no_hp_user', $row->no_hp_user),
                'alamat_user' => set_value('alamat_user', $row->alamat_user),
                'photo' => set_value('photo', $row->photo),
            );
            $this->template->load('template','user/profil_update', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('user'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('user_id', TRUE));
        } else {

         $config['upload_path']      = './assets/img/user'; 
            $config['allowed_types']    = 'jpg|png|jpeg|gif'; 
            $config['max_size']         = 10048; 
            $config['file_name']        = 'File-'.date('ymd').'-'.substr(sha1(rand()),0,10); 
            $this->load->library('upload',$config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload("photo")) {
            $id = $this->input->post('user_id');
            $row = $this->User_model->get_by_id($id);
            $data = $this->upload->data();
            $photo =$data['file_name'];
            if($row->photo==null || $row->photo=='' ){
            }else{

            $target_file = './assets/img/user/'.$row->photo;
            unlink($target_file);
            
            }
                }else{
                $photo = $this->input->post('photo_lama');
            }
            
            $data = array(
                'nama_user' => $this->input->post('nama_user',TRUE),
                'email' => $this->input->post('email',TRUE),
                'no_hp_user' => $this->input->post('no_hp_user',TRUE),
                'alamat_user' => $this->input->post('alamat_user',TRUE),
                'photo' => $photo,
                );

            $this->User_model->update($this->input->post('user_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Profil Berhasil');
            redirect(site_url('Akun'));
        }
    }
    

    public function _rules() 
    {
		$this->form_validation->set_rules('nama_user', 'nama user', 'trim|required');


	    $this->form_validation->set_rules('email', 'email', 'trim|required');
	    $this->form_validation->set_rules('no_hp_user', 'no hp user', 'trim|required');
	    $this->form_validation->set_rules('alamat_user', 'alamat user', 'trim|required');
	    // $this->form_validation->set_rules('photo', 'photo', 'trim|required');

	    $this->form_validation->set_rules('user_id', 'user_id', 'trim');
	    $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Agen.php */
/* Location: ./application/controllers/Agen.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-06-29 11:06:27 */
/* http://harviacode.com */