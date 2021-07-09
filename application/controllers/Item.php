<?php

require 'vendor/autoload.php';

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class item extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Item_model');
        $this->load->model('Type_model');
        $this->load->model('Kategori_model');
        $this->load->model('Merek_model');
        $this->load->model('Jenis_item_model');
        $this->load->model('Agen_model');
        $this->load->library('form_validation');
        $this->load->library('pdf');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->uri->segment(3));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . '.php/c_url/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'index.php/item/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'index.php/item/index/';
            $config['first_url'] = base_url() . 'index.php/item/index/';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = FALSE;
        $config['total_rows'] = $this->Item_model->total_rows($q);
        $item = $this->Item_model->get_limit_data($config['per_page'], $start, $q);
        $config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin pull-right">';
        $config['full_tag_close'] = '</ul>';
        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'item_data' => $item,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->template->load('template','item/item_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Item_model->get_by_id($id);
        if ($row) {
            $data = array(
                'harga' =>$this->Item_model->get_harga($id),
                'item_id' => $row->item_id,
                'kd_pembelian' => $row->kd_pembelian,
                'agen_id' => $row->nama_agen,
                'kd_item' => $row->kd_item,
                'nama_item' => $row->nama_item,
                'jenis_item_id' => $row->nama_jenis_item,
                'merek_id' => $row->nama_merek,
                'no_stnk' => $row->no_stnk,
                'no_bpkb' => $row->no_bpkb,
                'deskripsi' => $row->deskripsi,
                'harga_beli' => $row->harga_beli,
                'photo' => $row->photo,
                'status' => $row->status,
            );
            $this->template->load('template','item/item_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('item'));
        }
    }

    public function create() 
    {
        $dariDB = $this->Item_model->cekkodebarang();
        // contoh JRD0004, angka 3 adalah awal pengambilan angka, dan 4 jumlah angka yang diambil
        $nourut = substr($dariDB, 3, 4);
        $kodeBarangSekarang = $nourut + 1;

        $data = array(
            'button' => 'Create',
            'kode_barang' => $kodeBarangSekarang,
            'kodeunik' =>$this->Item_model->buat_kode(),
            'action' => site_url('item/create_action'),
            'jenis' =>$this->Jenis_item_model->get_all(),
            'type' =>$this->Type_model->get_all(),
            'kategori' =>$this->Kategori_model->get_all(),
            'merek' =>$this->Merek_model->get_all(),
            'agen' =>$this->Agen_model->get_all(),
            'item_id' => set_value('item_id'),
            'kd_pembelian' => set_value('kd_pembelian'),
            'agen_id' => set_value('agen_id'),
            'kd_item' => set_value('kd_item'),
            'nama_item' => set_value('nama_item'),
            'jenis_item_id' => set_value('jenis_item_id'),
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
        $this->template->load('template','item/item_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $config['upload_path']      = './assets/img/item'; 
        $config['allowed_types']    = 'jpg|png|jpeg'; 
        $config['max_size']         = 10048; 
        $config['file_name']        = 'File-'.date('ymd').'-'.substr(sha1(rand()),0,10); 
        $this->load->library('upload',$config);
        $this->upload->initialize($config);
        $this->upload->do_upload("photo");
        $data = $this->upload->data();
        
        $photo =$data['file_name'];

            $data = array(
                'unit_id' => $this->input->post('unit_id',TRUE),
		'kd_pembelian' => $this->input->post('kd_pembelian',TRUE),
		'agen_id' => $this->input->post('agen_id',TRUE),
        'kategori_id' => $this->input->post('kategori_id',TRUE),
		'kd_item' => $this->input->post('kd_item',TRUE),
		'nama_item' => $this->input->post('nama_item',TRUE),
		'jenis_item_id' => $this->input->post('jenis_item_id',TRUE),
		'merek_id' => $this->input->post('merek_id',TRUE),
        'type_id' => $this->input->post('type_id',TRUE),
		'no_stnk' => $this->input->post('no_stnk',TRUE),
		'no_bpkb' => $this->input->post('no_bpkb',TRUE),
		'deskripsi' => $this->input->post('deskripsi',TRUE),
		'harga_beli' => $this->input->post('harga_beli',TRUE),
		'photo' => $photo,
		'status' => $this->input->post('status',TRUE),
	    );

            $this->Item_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('item'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Item_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('item/update_action'),
                'jenis' =>$this->Jenis_item_model->get_all(),
            'type' =>$this->Type_model->get_all(),
            'merek' =>$this->Merek_model->get_all(),
            'kategori' =>$this->Kategori_model->get_all(),
            'agen' =>$this->Agen_model->get_all(),
		'item_id' => set_value('item_id', $row->item_id),
		'kd_pembelian' => set_value('kd_pembelian', $row->kd_pembelian),
		'agen_id' => set_value('agen_id', $row->agen_id),
        'kategori_id' => set_value('kategori_id', $row->kategori_id),
		'kd_item' => set_value('kd_item', $row->kd_item),
		'nama_item' => set_value('nama_item', $row->nama_item),
		'jenis_item_id' => set_value('jenis_item_id', $row->jenis_item_id),
		'merek_id' => set_value('merek_id', $row->merek_id),
        'type_id' => set_value('type_id', $row->type_id),
		'no_stnk' => set_value('no_stnk', $row->no_stnk),
		'no_bpkb' => set_value('no_bpkb', $row->no_bpkb),
		'deskripsi' => set_value('deskripsi', $row->deskripsi),
		'harga_beli' => set_value('harga_beli', $row->harga_beli),
		'photo' => set_value('photo', $row->photo),
		'status' => set_value('status', $row->status),
	    );
            $this->template->load('template','item/item_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('item'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('item_id', TRUE));
        } else {

        $config['upload_path']      = './assets/img/item'; 
            $config['allowed_types']    = 'jpg|png|jpeg'; 
            $config['max_size']         = 10048; 
            $config['file_name']        = 'File-'.date('ymd').'-'.substr(sha1(rand()),0,10); 
            $this->load->library('upload',$config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload("photo")) {
            $id = $this->input->post('item_id');
            $row = $this->Item_model->get_by_id($id);
            $data = $this->upload->data();
            $photo =$data['file_name'];
            if($row->photo==null || $row->photo=='' ){
            }else{

            $target_file = './assets/img/item/'.$row->photo;
            unlink($target_file);
            
            }
                }else{
                $photo = $this->input->post('photo_lama');
            }

            $data = array(
                'unit_id' => $this->input->post('unit_id',TRUE),
		'kd_pembelian' => $this->input->post('kd_pembelian',TRUE),
		'agen_id' => $this->input->post('agen_id',TRUE),
        'kategori_id' => $this->input->post('kategori_id',TRUE),
		'kd_item' => $this->input->post('kd_item',TRUE),
		'nama_item' => $this->input->post('nama_item',TRUE),
		'jenis_item_id' => $this->input->post('jenis_item_id',TRUE),
		'merek_id' => $this->input->post('merek_id',TRUE),
        'type_id' => $this->input->post('type_id',TRUE),
		'no_stnk' => $this->input->post('no_stnk',TRUE),
		'no_bpkb' => $this->input->post('no_bpkb',TRUE),
		'deskripsi' => $this->input->post('deskripsi',TRUE),
		'harga_beli' => $this->input->post('harga_beli',TRUE),
		'photo' => $photo,
		'status' => $this->input->post('status',TRUE),
	    );

            $this->Item_model->update($this->input->post('item_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('item'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Item_model->get_by_id($id);

        if ($row) {
            if($row->photo==null || $row->photo=='' ){
                }else{
                $target_file = './assets/img/item/'.$row->photo;
                unlink($target_file);
                }

            $this->Item_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('item'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('item'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('kd_pembelian', 'kd pembelian', 'trim|required');
	$this->form_validation->set_rules('agen_id', 'agen id', 'trim|required');
	$this->form_validation->set_rules('kd_item', 'kd item', 'trim|required');
	$this->form_validation->set_rules('nama_item', 'nama item', 'trim|required');
	$this->form_validation->set_rules('jenis_item_id', 'jenis item id', 'trim|required');
	$this->form_validation->set_rules('merek_id', 'merek id', 'trim|required');
    $this->form_validation->set_rules('type_id', 'type id', 'trim|required');
	$this->form_validation->set_rules('no_stnk', 'no stnk', 'trim|required');
	$this->form_validation->set_rules('no_bpkb', 'no bpkb', 'trim|required');
	$this->form_validation->set_rules('deskripsi', 'deskripsi', 'trim|required');
	$this->form_validation->set_rules('harga_beli', 'harga beli', 'trim|required');
	// $this->form_validation->set_rules('photo', 'photo', 'trim|required');
	$this->form_validation->set_rules('status', 'status', 'trim|required');

	$this->form_validation->set_rules('item_id', 'item_id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "item.xls";
        $judul = "item";
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
    	xlsWriteLabel($tablehead, $kolomhead++, "Kd item");
    	xlsWriteLabel($tablehead, $kolomhead++, "Nama item");
    	xlsWriteLabel($tablehead, $kolomhead++, "Jenis item");
        xlsWriteLabel($tablehead, $kolomhead++, "Kategori");
    	xlsWriteLabel($tablehead, $kolomhead++, "Merek");
        xlsWriteLabel($tablehead, $kolomhead++, "Type");
    	xlsWriteLabel($tablehead, $kolomhead++, "No Stnk");
    	xlsWriteLabel($tablehead, $kolomhead++, "No Bpkb");
        xlsWriteLabel($tablehead, $kolomhead++, "Deskripsi");
        xlsWriteLabel($tablehead, $kolomhead++, "Harga Beli");
        xlsWriteLabel($tablehead, $kolomhead++, "Status");

	    foreach ($this->Item_model->get_all('') as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
    	    xlsWriteLabel($tablebody, $kolombody++, $data->kd_pembelian);
    	    xlsWriteLabel($tablebody, $kolombody++, $data->nama_agen);
    	    xlsWriteLabel($tablebody, $kolombody++, $data->kd_item);
    	    xlsWriteLabel($tablebody, $kolombody++, $data->nama_item);
    	    xlsWriteLabel($tablebody, $kolombody++, $data->nama_jenis_item);
            xlsWriteLabel($tablebody, $kolombody++, $data->nama_kategori);
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

    public function cetak($id)
    {
        $pdf = new FPDF('p','mm','A4');
        $data = $this->Item_model->get_by_id($id);
        $dtlharga = $this->Item_model->get_harga($id);

        $pdf->AddPage();

        $pdf->setXY(0, 40);
        $pdf->SetFont('Arial','B',16);$pdf->Cell(0,7,'DATA ITEM',0,0,'C');
        $pdf->setXY(0, 50);
        $pdf->SetFont('Arial','',13);$pdf->Cell(0,7,$data->kd_pembelian.'/'.$data->nama_agen,0,0,'C');
        
        $pdf->setY(90);
        $pdf->SetFont('Arial','',12);
        $pdf->Cell(10,10,'1.',0,0,'L');
        $pdf->Cell(50,10,'Nama Item',0,0,'L');
        $pdf->Cell(4,10,':',0,0,'L');
        $pdf->Cell(100,10,$data->nama_item.'/'.$data->kd_item,0,1,'L');
        $pdf->Cell(10,10,'2.',0,0,'L');
        $pdf->Cell(50,10,'Jenis Item',0,0,'L');
        $pdf->Cell(4,10,':',0,0,'L');
        $pdf->Cell(100,10,$data->nama_jenis_item,0,1,'L');
        $pdf->Cell(10,10,'3.',0,0,'L');
        $pdf->Cell(50,10,'Merek',0,0,'L');
        $pdf->Cell(4,10,':',0,0,'L');
        $pdf->Cell(100,10,$data->nama_merek,0,1,'L');
        $pdf->Cell(10,10,'4.',0,0,'L');
        $pdf->Cell(50,10,'No. STNK',0,0,'L');
        $pdf->Cell(4,10,':',0,0,'L');
        $pdf->Cell(100,10,$data->no_stnk,0,1,'L');
        $pdf->Cell(10,10,'5.',0,0,'L');
        $pdf->Cell(50,10,'No. BPKB',0,0,'L');
        $pdf->Cell(4,10,':',0,0,'L');
        $pdf->Cell(100,10,$data->no_bpkb,0,1,'L');
        $pdf->Cell(10,10,'6.',0,0,'L');
        $pdf->Cell(50,10,'Harga Perolehan',0,0,'L');
        $pdf->Cell(4,10,':',0,0,'L');
        $pdf->Cell(100,10,'Rp'.$data->harga_beli,0,1,'L');
        $pdf->Cell(50,10,'7. Detail Biaya',0,0,'L');
        $pdf->Cell(4,10,':',0,0,'L');
        $pdf->Cell(100,10,'Rp'.$data->harga_beli,0,1,'L');
        $pdf->Cell(50,2,'',0,1,'L');
        foreach($dtlharga->result() as $key => $p) {
            $pdf->setX(30);
            $pdf->Cell(50,10,$p->nama_harga,0,0,'L');
            $pdf->Cell(4,10,':',0,0,'L');
            $pdf->Cell(100,10,'Rp'.$p->nominal,0,1,'L');
        }
        $pdf->Cell(50,10,'8. Deskripsi',0,0,'L');
        $pdf->Cell(4,10,':',0,0,'L');
        $pdf->multiCell(90,10,$data->deskripsi,0,'L',false);

        $pdf->setXY(130, 220);
        $pdf->Cell(50,10,'Mengetahui',0,2,'C');
        $pdf->Cell(50,30,'',0,2,'C');
        $pdf->Cell(50,10,'(_______________________)',0,2,'C');

        $pdf->Output('item'.$data->kd_pembelian.'.pdf', 'D');
    }

    public function update_harga($id){
        $this->template->load('template','item/update_harga');
    }

    public function action_update_harga(){
        $nama_harga    = $_POST['nama_harga'];
        $nominal       = $_POST['nominal'];
        $item_id       = $_POST['item_id'];
        $jumlah_data = count($nama_harga);
    for($i = 0; $i < $jumlah_data;$i++)
        {       
                    $data['nama_harga'] = $nama_harga[$i];
                    $data['nominal'] = $nominal[$i];
                    $data['item_id'] = $item_id[$i];
                    $this->db->insert('harga',$data);
        }
        redirect(site_url('item'));
    }

    public function del_harga($id,$uri) 
    {
        $row = $this->Item_model->get_harga_by_id($id);

        if ($row) {
            $this->Item_model->delete_berkas($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('item/read/'.$uri));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('item/read/'.$uri));
        }
    }

    public function download($gambar){
        force_download('assets/img/item/'.$gambar,NULL);
    }

}
