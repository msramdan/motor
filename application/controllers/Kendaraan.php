<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Kendaraan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Kendaraan_model');
        $this->load->model('Type_model');
        $this->load->model('Kategori_model');
        $this->load->model('Merek_model');
        $this->load->model('Jenis_kendaraan_model');
        $this->load->model('Agen_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->uri->segment(3));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . '.php/c_url/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'index.php/kendaraan/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'index.php/kendaraan/index/';
            $config['first_url'] = base_url() . 'index.php/kendaraan/index/';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = FALSE;
        $config['total_rows'] = $this->Kendaraan_model->total_rows($q);
        $kendaraan = $this->Kendaraan_model->get_limit_data($config['per_page'], $start, $q);
        $config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin pull-right">';
        $config['full_tag_close'] = '</ul>';
        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'kendaraan_data' => $kendaraan,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->template->load('template','kendaraan/kendaraan_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Kendaraan_model->get_by_id($id);
        if ($row) {
            $data = array(
                'harga' =>$this->Kendaraan_model->get_harga($id),
                'kendaraan_id' => $row->kendaraan_id,
                'kd_pembelian' => $row->kd_pembelian,
                'agen_id' => $row->nama_agen,
                'kd_kendaraan' => $row->kd_kendaraan,
                'nama_kendaraan' => $row->nama_kendaraan,
                'jenis_kendaraan_id' => $row->nama_jenis_kendaraan,
                'merek_id' => $row->nama_merek,
                'no_stnk' => $row->no_stnk,
                'no_bpkb' => $row->no_bpkb,
                'deskripsi' => $row->deskripsi,
                'harga_beli' => $row->harga_beli,
                'photo' => $row->photo,
                'status' => $row->status,
            );
            $this->template->load('template','kendaraan/kendaraan_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('kendaraan'));
        }
    }

    public function create() 
    {
        $dariDB = $this->Kendaraan_model->cekkodebarang();
        // contoh JRD0004, angka 3 adalah awal pengambilan angka, dan 4 jumlah angka yang diambil
        $nourut = substr($dariDB, 3, 4);
        $kodeBarangSekarang = $nourut + 1;

        $data = array(
            'button' => 'Create',
            'kode_barang' => $kodeBarangSekarang,
            'kodeunik' =>$this->Kendaraan_model->buat_kode(),
            'action' => site_url('kendaraan/create_action'),
            'jenis' =>$this->Jenis_kendaraan_model->get_all(),
            'type' =>$this->Type_model->get_all(),
            'kategori' =>$this->Kategori_model->get_all(),
            'merek' =>$this->Merek_model->get_all(),
            'agen' =>$this->Agen_model->get_all(),
            'kendaraan_id' => set_value('kendaraan_id'),
            'kd_pembelian' => set_value('kd_pembelian'),
            'agen_id' => set_value('agen_id'),
            'kd_kendaraan' => set_value('kd_kendaraan'),
            'nama_kendaraan' => set_value('nama_kendaraan'),
            'jenis_kendaraan_id' => set_value('jenis_kendaraan_id'),
            'merek_id' => set_value('merek_id'),
            'type_id' => set_value('type_id'),
            'no_stnk' => set_value('no_stnk'),
            'no_bpkb' => set_value('no_bpkb'),
            'kategori_id' => set_value('kategori_id'),
            'deskripsi' => set_value('deskripsi'),
            'harga_beli' => set_value('harga_beli'),
            'photo' => set_value('photo'),
            'status' => set_value('status'),
        );
        $this->template->load('template','kendaraan/kendaraan_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $config['upload_path']      = './assets/img/kendaraan'; 
        $config['allowed_types']    = 'jpg|png|jpeg'; 
        $config['max_size']         = 10048; 
        $config['file_name']        = 'File-'.date('ymd').'-'.substr(sha1(rand()),0,10); 
        $this->load->library('upload',$config);
        $this->upload->initialize($config);
        $this->upload->do_upload("photo");
        $data = $this->upload->data();
        
        $photo =$data['file_name'];

            $data = array(
		'kd_pembelian' => $this->input->post('kd_pembelian',TRUE),
		'agen_id' => $this->input->post('agen_id',TRUE),
        'kategori_id' => $this->input->post('kategori_id',TRUE),
		'kd_kendaraan' => $this->input->post('kd_kendaraan',TRUE),
		'nama_kendaraan' => $this->input->post('nama_kendaraan',TRUE),
		'jenis_kendaraan_id' => $this->input->post('jenis_kendaraan_id',TRUE),
		'merek_id' => $this->input->post('merek_id',TRUE),
        'type_id' => $this->input->post('type_id',TRUE),
		'no_stnk' => $this->input->post('no_stnk',TRUE),
		'no_bpkb' => $this->input->post('no_bpkb',TRUE),
		'deskripsi' => $this->input->post('deskripsi',TRUE),
		'harga_beli' => $this->input->post('harga_beli',TRUE),
		'photo' => $photo,
		'status' => $this->input->post('status',TRUE),
	    );

            $this->Kendaraan_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('kendaraan'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Kendaraan_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('kendaraan/update_action'),
                'jenis' =>$this->Jenis_kendaraan_model->get_all(),
            'type' =>$this->Type_model->get_all(),
            'merek' =>$this->Merek_model->get_all(),
            'kategori' =>$this->Kategori_model->get_all(),
            'agen' =>$this->Agen_model->get_all(),
		'kendaraan_id' => set_value('kendaraan_id', $row->kendaraan_id),
		'kd_pembelian' => set_value('kd_pembelian', $row->kd_pembelian),
		'agen_id' => set_value('agen_id', $row->agen_id),
        'kategori_id' => set_value('kategori_id', $row->kategori_id),
		'kd_kendaraan' => set_value('kd_kendaraan', $row->kd_kendaraan),
		'nama_kendaraan' => set_value('nama_kendaraan', $row->nama_kendaraan),
		'jenis_kendaraan_id' => set_value('jenis_kendaraan_id', $row->jenis_kendaraan_id),
		'merek_id' => set_value('merek_id', $row->merek_id),
        'type_id' => set_value('type_id', $row->type_id),
		'no_stnk' => set_value('no_stnk', $row->no_stnk),
		'no_bpkb' => set_value('no_bpkb', $row->no_bpkb),
		'deskripsi' => set_value('deskripsi', $row->deskripsi),
		'harga_beli' => set_value('harga_beli', $row->harga_beli),
		'photo' => set_value('photo', $row->photo),
		'status' => set_value('status', $row->status),
	    );
            $this->template->load('template','kendaraan/kendaraan_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('kendaraan'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('kendaraan_id', TRUE));
        } else {

        $config['upload_path']      = './assets/img/kendaraan'; 
            $config['allowed_types']    = 'jpg|png|jpeg'; 
            $config['max_size']         = 10048; 
            $config['file_name']        = 'File-'.date('ymd').'-'.substr(sha1(rand()),0,10); 
            $this->load->library('upload',$config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload("photo")) {
            $id = $this->input->post('kendaraan_id');
            $row = $this->Kendaraan_model->get_by_id($id);
            $data = $this->upload->data();
            $photo =$data['file_name'];
            if($row->photo==null || $row->photo=='' ){
            }else{

            $target_file = './assets/img/kendaraan/'.$row->photo;
            unlink($target_file);
            
            }
                }else{
                $photo = $this->input->post('photo_lama');
            }

            $data = array(
		'kd_pembelian' => $this->input->post('kd_pembelian',TRUE),
		'agen_id' => $this->input->post('agen_id',TRUE),
        'kategori_id' => $this->input->post('kategori_id',TRUE),
		'kd_kendaraan' => $this->input->post('kd_kendaraan',TRUE),
		'nama_kendaraan' => $this->input->post('nama_kendaraan',TRUE),
		'jenis_kendaraan_id' => $this->input->post('jenis_kendaraan_id',TRUE),
		'merek_id' => $this->input->post('merek_id',TRUE),
        'type_id' => $this->input->post('type_id',TRUE),
		'no_stnk' => $this->input->post('no_stnk',TRUE),
		'no_bpkb' => $this->input->post('no_bpkb',TRUE),
		'deskripsi' => $this->input->post('deskripsi',TRUE),
		'harga_beli' => $this->input->post('harga_beli',TRUE),
		'photo' => $photo,
		'status' => $this->input->post('status',TRUE),
	    );

            $this->Kendaraan_model->update($this->input->post('kendaraan_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('kendaraan'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Kendaraan_model->get_by_id($id);

        if ($row) {
            if($row->photo==null || $row->photo=='' ){
                }else{
                $target_file = './assets/img/kendaraan/'.$row->photo;
                unlink($target_file);
                }

            $this->Kendaraan_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('kendaraan'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('kendaraan'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('kd_pembelian', 'kd pembelian', 'trim|required');
	$this->form_validation->set_rules('agen_id', 'agen id', 'trim|required');
	$this->form_validation->set_rules('kd_kendaraan', 'kd kendaraan', 'trim|required');
	$this->form_validation->set_rules('nama_kendaraan', 'nama kendaraan', 'trim|required');
	$this->form_validation->set_rules('jenis_kendaraan_id', 'jenis kendaraan id', 'trim|required');
	$this->form_validation->set_rules('merek_id', 'merek id', 'trim|required');
    $this->form_validation->set_rules('type_id', 'type id', 'trim|required');
	$this->form_validation->set_rules('no_stnk', 'no stnk', 'trim|required');
	$this->form_validation->set_rules('no_bpkb', 'no bpkb', 'trim|required');
	$this->form_validation->set_rules('deskripsi', 'deskripsi', 'trim|required');
	$this->form_validation->set_rules('harga_beli', 'harga beli', 'trim|required');
	// $this->form_validation->set_rules('photo', 'photo', 'trim|required');
	$this->form_validation->set_rules('status', 'status', 'trim|required');

	$this->form_validation->set_rules('kendaraan_id', 'kendaraan_id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "kendaraan.xls";
        $judul = "kendaraan";
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
	xlsWriteLabel($tablehead, $kolomhead++, "Kd Pembelian");
	xlsWriteLabel($tablehead, $kolomhead++, "Agen");
	xlsWriteLabel($tablehead, $kolomhead++, "Kd Kendaraan");
	xlsWriteLabel($tablehead, $kolomhead++, "Nama Kendaraan");
	xlsWriteLabel($tablehead, $kolomhead++, "Jenis Kendaraan");
    xlsWriteLabel($tablehead, $kolomhead++, "Kategori");
	xlsWriteLabel($tablehead, $kolomhead++, "Merek");
    xlsWriteLabel($tablehead, $kolomhead++, "Type");
	xlsWriteLabel($tablehead, $kolomhead++, "No Stnk");
	xlsWriteLabel($tablehead, $kolomhead++, "No Bpkb");
	xlsWriteLabel($tablehead, $kolomhead++, "Deskripsi");
	xlsWriteLabel($tablehead, $kolomhead++, "Harga Beli");
	xlsWriteLabel($tablehead, $kolomhead++, "Status");

	foreach ($this->Kendaraan_model->get_all('') as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->kd_pembelian);
	    xlsWriteLabel($tablebody, $kolombody++, $data->nama_agen);
	    xlsWriteLabel($tablebody, $kolombody++, $data->kd_kendaraan);
	    xlsWriteLabel($tablebody, $kolombody++, $data->nama_kendaraan);
	    xlsWriteLabel($tablebody, $kolombody++, $data->nama_jenis_kendaraan);
        xlsWriteLabel($tablebody, $kolombody++, $data->kategori_item);
	    xlsWriteLabel($tablebody, $kolombody++, $data->nama_merek);
        xlsWriteLabel($tablebody, $kolombody++, $data->nama_type);
	    xlsWriteLabel($tablebody, $kolombody++, $data->no_stnk);
	    xlsWriteLabel($tablebody, $kolombody++, $data->no_bpkb);
	    xlsWriteLabel($tablebody, $kolombody++, $data->deskripsi);
	    xlsWriteNumber($tablebody, $kolombody++, $data->harga_beli);
	    xlsWriteLabel($tablebody, $kolombody++, $data->status);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=kendaraan.doc");

        $data = array(
            'kendaraan_data' => $this->Kendaraan_model->get_all(''),
            'start' => 0
        );
        
        $this->load->view('kendaraan/kendaraan_doc',$data);
    }

    public function update_harga($id){
        $this->template->load('template','kendaraan/update_harga');
    }

    public function action_update_harga(){
        $nama_harga    = $_POST['nama_harga'];
        $nominal       = $_POST['nominal'];
        $kendaraan_id       = $_POST['kendaraan_id'];
        $jumlah_data = count($nama_harga);
    for($i = 0; $i < $jumlah_data;$i++)
        {       
                    $data['nama_harga'] = $nama_harga[$i];
                    $data['nominal'] = $nominal[$i];
                    $data['kendaraan_id'] = $kendaraan_id[$i];
                    $this->db->insert('harga',$data);
        }
        redirect(site_url('kendaraan'));
    }

    public function del_harga($id,$uri) 
    {
        $row = $this->Kendaraan_model->get_harga_by_id($id);

        if ($row) {
            $this->Kendaraan_model->delete_berkas($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('kendaraan/read/'.$uri));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('kendaraan/read/'.$uri));
        }
    }

    public function download($gambar){
        force_download('assets/img/kendaraan/'.$gambar,NULL);
    }

}
