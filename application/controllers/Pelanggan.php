<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pelanggan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Pelanggan_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        is_allowed($this->uri->segment(1),null);
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->uri->segment(3));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . '.php/c_url/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'index.php/pelanggan/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'index.php/pelanggan/index/';
            $config['first_url'] = base_url() . 'index.php/pelanggan/index/';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = FALSE;
        $config['total_rows'] = $this->Pelanggan_model->total_rows($q);
        $pelanggan = $this->Pelanggan_model->get_limit_data($config['per_page'], $start, $q);
        $config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin pull-right">';
        $config['full_tag_close'] = '</ul>';
        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'pelanggan_data' => $pelanggan,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->template->load('template','pelanggan/pelanggan_list', $data);
    }

    public function read($id) 
    {

        is_allowed($this->uri->segment(1),'read');
        $row = $this->Pelanggan_model->get_by_id($id);
        if ($row) {
            $data = array(
		'pelanggan_id' => $row->pelanggan_id,
        'berkas' =>$this->Pelanggan_model->get_berkas($id),
		'no_ktp' => $row->no_ktp,
		'no_kk' => $row->no_kk,
		'nama_pelanggan' => $row->nama_pelanggan,
		'no_hp_pelanggan' => $row->no_hp_pelanggan,
		'jenis_kelamin' => $row->jenis_kelamin,
		'alamat_ktp' => $row->alamat_ktp,
		'alamat_domisili' => $row->alamat_domisili,
		'nama_saudara' => $row->nama_saudara,
		'alamat_saudara' => $row->alamat_saudara,
		'no_hp_saudara' => $row->no_hp_saudara,
	    );
            $this->template->load('template','pelanggan/pelanggan_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('pelanggan'));
        }
    }

    public function create() 
    {
        is_allowed($this->uri->segment(1),'create');
        $data = array(
            'button' => 'Create',
            'action' => site_url('pelanggan/create_action'),
	    'pelanggan_id' => set_value('pelanggan_id'),
	    'no_ktp' => set_value('no_ktp'),
	    'no_kk' => set_value('no_kk'),
	    'nama_pelanggan' => set_value('nama_pelanggan'),
	    'no_hp_pelanggan' => set_value('no_hp_pelanggan'),
	    'jenis_kelamin' => set_value('jenis_kelamin'),
	    'alamat_ktp' => set_value('alamat_ktp'),
	    'alamat_domisili' => set_value('alamat_domisili'),
	    'nama_saudara' => set_value('nama_saudara'),
	    'alamat_saudara' => set_value('alamat_saudara'),
	    'no_hp_saudara' => set_value('no_hp_saudara'),
	);
        $this->template->load('template','pelanggan/pelanggan_form', $data);
    }
    
    public function create_action() 
    {
        is_allowed($this->uri->segment(1),'create');
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'no_ktp' => $this->input->post('no_ktp',TRUE),
        'unit_id' => $this->input->post('unit_id',TRUE),
		'no_kk' => $this->input->post('no_kk',TRUE),
		'nama_pelanggan' => $this->input->post('nama_pelanggan',TRUE),
		'no_hp_pelanggan' => $this->input->post('no_hp_pelanggan',TRUE),
		'jenis_kelamin' => $this->input->post('jenis_kelamin',TRUE),
		'alamat_ktp' => $this->input->post('alamat_ktp',TRUE),
		'alamat_domisili' => $this->input->post('alamat_domisili',TRUE),
		'nama_saudara' => $this->input->post('nama_saudara',TRUE),
		'alamat_saudara' => $this->input->post('alamat_saudara',TRUE),
		'no_hp_saudara' => $this->input->post('no_hp_saudara',TRUE),
	    );

            $this->Pelanggan_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('pelanggan'));
        }
    }
    
    public function update($id) 
    {
        is_allowed($this->uri->segment(1),'update');
        $row = $this->Pelanggan_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('pelanggan/update_action'),
		'pelanggan_id' => set_value('pelanggan_id', $row->pelanggan_id),
		'no_ktp' => set_value('no_ktp', $row->no_ktp),
		'no_kk' => set_value('no_kk', $row->no_kk),
        'unit_id' => set_value('unit_id', $row->unit_id),
		'nama_pelanggan' => set_value('nama_pelanggan', $row->nama_pelanggan),
		'no_hp_pelanggan' => set_value('no_hp_pelanggan', $row->no_hp_pelanggan),
		'jenis_kelamin' => set_value('jenis_kelamin', $row->jenis_kelamin),
		'alamat_ktp' => set_value('alamat_ktp', $row->alamat_ktp),
		'alamat_domisili' => set_value('alamat_domisili', $row->alamat_domisili),
		'nama_saudara' => set_value('nama_saudara', $row->nama_saudara),
		'alamat_saudara' => set_value('alamat_saudara', $row->alamat_saudara),
		'no_hp_saudara' => set_value('no_hp_saudara', $row->no_hp_saudara),
	    );
            $this->template->load('template','pelanggan/pelanggan_form_update', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('pelanggan'));
        }
    }
    
    public function update_action() 
    {
        is_allowed($this->uri->segment(1),'update');
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('pelanggan_id', TRUE));
        } else {
            $data = array(
		'no_ktp' => $this->input->post('no_ktp',TRUE),
		'no_kk' => $this->input->post('no_kk',TRUE),
		'nama_pelanggan' => $this->input->post('nama_pelanggan',TRUE),
		'no_hp_pelanggan' => $this->input->post('no_hp_pelanggan',TRUE),
		'jenis_kelamin' => $this->input->post('jenis_kelamin',TRUE),
		'alamat_ktp' => $this->input->post('alamat_ktp',TRUE),
		'alamat_domisili' => $this->input->post('alamat_domisili',TRUE),
		'nama_saudara' => $this->input->post('nama_saudara',TRUE),
		'alamat_saudara' => $this->input->post('alamat_saudara',TRUE),
		'no_hp_saudara' => $this->input->post('no_hp_saudara',TRUE),
        'unit_id' => $this->input->post('unit_id',TRUE),
	    );

            $this->Pelanggan_model->update($this->input->post('pelanggan_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('pelanggan'));
        }
    }
    
    public function delete($id) 
    {
        is_allowed($this->uri->segment(1),'delete');
        $row = $this->Pelanggan_model->get_by_id($id);
        if ($row) {
            $this->Pelanggan_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('pelanggan'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('pelanggan'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('no_ktp', 'no ktp', 'trim|required');
	$this->form_validation->set_rules('no_kk', 'no kk', 'trim|required');
	$this->form_validation->set_rules('nama_pelanggan', 'nama pelanggan', 'trim|required');
	$this->form_validation->set_rules('no_hp_pelanggan', 'no hp pelanggan', 'trim|required');
	$this->form_validation->set_rules('jenis_kelamin', 'jenis kelamin', 'trim|required');
	$this->form_validation->set_rules('alamat_ktp', 'alamat ktp', 'trim|required');
	$this->form_validation->set_rules('alamat_domisili', 'alamat domisili', 'trim|required');
	$this->form_validation->set_rules('nama_saudara', 'nama saudara', 'trim|required');
	$this->form_validation->set_rules('alamat_saudara', 'alamat saudara', 'trim|required');
	$this->form_validation->set_rules('no_hp_saudara', 'no hp saudara', 'trim|required');

	$this->form_validation->set_rules('pelanggan_id', 'pelanggan_id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        is_allowed($this->uri->segment(1),'export');
        $this->load->helper('exportexcel');
        $namaFile = "pelanggan.xls";
        $judul = "pelanggan";
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
	xlsWriteLabel($tablehead, $kolomhead++, "No Ktp");
	xlsWriteLabel($tablehead, $kolomhead++, "No Kk");
	xlsWriteLabel($tablehead, $kolomhead++, "Nama Pelanggan");
	xlsWriteLabel($tablehead, $kolomhead++, "No Hp Pelanggan");
	xlsWriteLabel($tablehead, $kolomhead++, "Jenis Kelamin");
	xlsWriteLabel($tablehead, $kolomhead++, "Alamat Ktp");
	xlsWriteLabel($tablehead, $kolomhead++, "Alamat Domisili");
	xlsWriteLabel($tablehead, $kolomhead++, "Nama Saudara");
	xlsWriteLabel($tablehead, $kolomhead++, "Alamat Saudara");
	xlsWriteLabel($tablehead, $kolomhead++, "No Hp Saudara");

	foreach ($this->Pelanggan_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->no_ktp);
	    xlsWriteLabel($tablebody, $kolombody++, $data->no_kk);
	    xlsWriteLabel($tablebody, $kolombody++, $data->nama_pelanggan);
	    xlsWriteLabel($tablebody, $kolombody++, $data->no_hp_pelanggan);
	    xlsWriteLabel($tablebody, $kolombody++, $data->jenis_kelamin);
	    xlsWriteLabel($tablebody, $kolombody++, $data->alamat_ktp);
	    xlsWriteLabel($tablebody, $kolombody++, $data->alamat_domisili);
	    xlsWriteLabel($tablebody, $kolombody++, $data->nama_saudara);
	    xlsWriteLabel($tablebody, $kolombody++, $data->alamat_saudara);
	    xlsWriteLabel($tablebody, $kolombody++, $data->no_hp_saudara);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=pelanggan.doc");

        $data = array(
            'pelanggan_data' => $this->Pelanggan_model->get_all(),
            'start' => 0
        );
        
        $this->load->view('pelanggan/pelanggan_doc',$data);
    }

    public function download_berkas($gambar){
        force_download('assets/img/berkas/'.$gambar,NULL);
    }

    public function upload($id){
        is_allowed($this->uri->segment(1),'create');  
        $this->template->load('template','pelanggan/upload');
    }

    public function upload_berkas(){         
        $config['upload_path']          = './assets/img/berkas'; 
        $config['allowed_types']        = 'jpg|png|pdf|docx|doc';
        $config['max_size']             = 10000;
        // $config['max_width']            = 2048;
        // $config['max_height']           = 1000;
        // $config['encrypt_name']         = true;
        $this->load->library('upload',$config);
        $nama               = $_POST['nama_berkas'];
        $pelanggan_id       = $_POST['pelanggan_id'];
        $jumlah_berkas = count($_FILES['berkas']['name']);

        for($i = 0; $i < $jumlah_berkas;$i++)
        {
            if(!empty($_FILES['berkas']['name'][$i])){
 
                $_FILES['file']['name'] = $_FILES['berkas']['name'][$i];
                $_FILES['file']['type'] = $_FILES['berkas']['type'][$i];
                $_FILES['file']['tmp_name'] = $_FILES['berkas']['tmp_name'][$i];
                $_FILES['file']['error'] = $_FILES['berkas']['error'][$i];
                $_FILES['file']['size'] = $_FILES['berkas']['size'][$i];
       
                if($this->upload->do_upload('file')){
                    $uploadData = $this->upload->data();
                    $data['nama_berkas'] = $nama[$i];
                    $data['photo'] = $uploadData['file_name'];
                    $data['pelanggan_id'] = $pelanggan_id[$i];
                    $this->db->insert('berkas',$data);
                }
            }
        }

        redirect(site_url('pelanggan'));

    }

    public function del_berkas($id,$uri) 
    {
        is_allowed($this->uri->segment(1),'delete');   
        $row = $this->Pelanggan_model->get_berkas_by_id($id);

        if ($row) {
            if($row->photo==null || $row->photo==''){
                }else{
                $target_file = './assets/img/berkas/'.$row->photo;
                unlink($target_file);
                }
            $this->Pelanggan_model->delete_berkas($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('pelanggan/read/'.$uri));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('pelanggan/read/'.$uri));
        }
    }

}

/* End of file Pelanggan.php */
/* Location: ./application/controllers/Pelanggan.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-07-01 09:21:03 */
/* http://harviacode.com */