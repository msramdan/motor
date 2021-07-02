<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('User_model');
        $this->load->model('Level_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->uri->segment(3));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . '.php/c_url/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'index.php/user/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'index.php/user/index/';
            $config['first_url'] = base_url() . 'index.php/user/index/';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = FALSE;
        $config['total_rows'] = $this->User_model->total_rows($q);
        $user = $this->User_model->get_limit_data($config['per_page'], $start, $q);
        $config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin pull-right">';
        $config['full_tag_close'] = '</ul>';
        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'user_data' => $user,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->template->load('template','user/user_list', $data);
    }

    public function read($id) 
    {
        $row = $this->User_model->get_by_id($id);
        if ($row) {
            $data = array(
        'user_id' => $row->user_id,
        'nama_user' => $row->nama_user,
        'username' => $row->username,
        'password' => $row->password,
        'level_id' => $row->level_id,
        'email' => $row->email,
        'no_hp_user' => $row->no_hp_user,
        'alamat_user' => $row->alamat_user,
        'photo' => $row->photo,
        );
            $this->template->load('template','user/user_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('user'));
        }
    }

    public function create() 
    {
        $data = array(
            'level' =>$this->Level_model->get_all(),
            'button' => 'Create',
            'action' => site_url('user/create_action'),
        'user_id' => set_value('user_id'),
        'nama_user' => set_value('nama_user'),
        'username' => set_value('username'),
        'password' => set_value('password'),
        'level_id' => set_value('level_id'),
        'email' => set_value('email'),
        'no_hp_user' => set_value('no_hp_user'),
        'alamat_user' => set_value('alamat_user'),
        'photo' => set_value('photo'),
    );
        $this->template->load('template','user/user_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {

        $config['upload_path']      = './assets/img/user'; 
        $config['allowed_types']    = 'jpg|png|jpeg'; 
        $config['max_size']         = 10048; 
        $config['file_name']        = 'File-'.date('ymd').'-'.substr(sha1(rand()),0,10); 
        $this->load->library('upload',$config);
        $this->upload->initialize($config);
        $this->upload->do_upload("photo");
        $data = $this->upload->data();
        
        $photo =$data['file_name'];


            $data = array(
        'nama_user' => $this->input->post('nama_user',TRUE),
        'username' => $this->input->post('username',TRUE),
        'password' => sha1($this->input->post('password',TRUE)),
        'level_id' => $this->input->post('level_id',TRUE),
        'email' => $this->input->post('email',TRUE),
        'no_hp_user' => $this->input->post('no_hp_user',TRUE),
        'alamat_user' => $this->input->post('alamat_user',TRUE),
        'photo' => $photo,

        );

            $this->User_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success 2');
            redirect(site_url('user'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->User_model->get_by_id($id);

        if ($row) {
            $data = array(
                'level' =>$this->Level_model->get_all(),
                'button' => 'Update',
                'action' => site_url('user/update_action'),
                'user_id' => set_value('user_id', $row->user_id),
                'nama_user' => set_value('nama_user', $row->nama_user),
                'username' => set_value('username', $row->username),
                'password' => set_value('password', $row->password),
                'level_id' => set_value('level_id', $row->level_id),
                'email' => set_value('email', $row->email),
                'no_hp_user' => set_value('no_hp_user', $row->no_hp_user),
                'alamat_user' => set_value('alamat_user', $row->alamat_user),
                'photo' => set_value('photo', $row->photo),
            );
            $this->template->load('template','user/user_form', $data);
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

            if ($this->input->post('password')==''||$this->input->post('password')==null) {            
                    $data = array(
                'nama_user' => $this->input->post('nama_user',TRUE),
                'username' => $this->input->post('username',TRUE),
                'level_id' => $this->input->post('level_id',TRUE),
                'email' => $this->input->post('email',TRUE),
                'no_hp_user' => $this->input->post('no_hp_user',TRUE),
                'alamat_user' => $this->input->post('alamat_user',TRUE),
                'photo' => $photo,
                );
            }else{
                    $data = array(
                'nama_user' => $this->input->post('nama_user',TRUE),
                'username' => $this->input->post('username',TRUE),
                'password' => sha1($this->input->post('password',TRUE)),
                'level_id' => $this->input->post('level_id',TRUE),
                'email' => $this->input->post('email',TRUE),
                'no_hp_user' => $this->input->post('no_hp_user',TRUE),
                'alamat_user' => $this->input->post('alamat_user',TRUE),
                'photo' => $photo,
                );
            }



            $this->User_model->update($this->input->post('user_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('user'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->User_model->get_by_id($id);

        if ($row) {
            if($row->photo==null || $row->photo=='' ){
                }else{
                $target_file = './assets/img/user/'.$row->photo;
                unlink($target_file);
                }

            $this->User_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('user'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('user'));
        }
    }

    public function _rules() 
    {
    $this->form_validation->set_rules('nama_user', 'nama user', 'trim|required');
    $this->form_validation->set_rules('username', 'username', 'trim|required');
    // $this->form_validation->set_rules('password', 'password', 'trim|required');
    $this->form_validation->set_rules('level_id', 'level id', 'trim|required');
    $this->form_validation->set_rules('email', 'email', 'trim|required');
    $this->form_validation->set_rules('no_hp_user', 'no hp user', 'trim|required');
    $this->form_validation->set_rules('alamat_user', 'alamat user', 'trim|required');
    // $this->form_validation->set_rules('photo', 'photo', 'trim|required');

    $this->form_validation->set_rules('user_id', 'user_id', 'trim');
    $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "user.xls";
        $judul = "user";
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
    xlsWriteLabel($tablehead, $kolomhead++, "Nama User");
    xlsWriteLabel($tablehead, $kolomhead++, "Username");
    xlsWriteLabel($tablehead, $kolomhead++, "Password");
    xlsWriteLabel($tablehead, $kolomhead++, "Level Id");
    xlsWriteLabel($tablehead, $kolomhead++, "Email");
    xlsWriteLabel($tablehead, $kolomhead++, "No Hp User");
    xlsWriteLabel($tablehead, $kolomhead++, "Alamat User");
    xlsWriteLabel($tablehead, $kolomhead++, "Photo");

    foreach ($this->User_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
        xlsWriteLabel($tablebody, $kolombody++, $data->nama_user);
        xlsWriteLabel($tablebody, $kolombody++, $data->username);
        xlsWriteLabel($tablebody, $kolombody++, $data->password);
        xlsWriteNumber($tablebody, $kolombody++, $data->level_id);
        xlsWriteLabel($tablebody, $kolombody++, $data->email);
        xlsWriteLabel($tablebody, $kolombody++, $data->no_hp_user);
        xlsWriteLabel($tablebody, $kolombody++, $data->alamat_user);
        xlsWriteLabel($tablebody, $kolombody++, $data->photo);

        $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

}

/* End of file User.php */
/* Location: ./application/controllers/User.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-06-13 14:04:40 */
/* http://harviacode.com */