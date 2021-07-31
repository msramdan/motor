<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Onetimep extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Sale_model');
        $this->load->model('Dashboard_model');
        $this->load->model('Item_model');
        $this->load->model('karyawan_model');
        $this->load->model('Jenis_pembayaran_model');
        $this->load->model('Mitra_model');
        $this->load->model('Onetimep_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->uri->segment(3));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . '.php/c_url/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'index.php/ontimep/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'index.php/ontimep/index/';
            $config['first_url'] = base_url() . 'index.php/ontimep/index/';
        }
        $config['per_page'] = 10;
        $config['page_query_string'] = FALSE;
        $config['total_rows'] = $this->Onetimep_model->total_rows($q);
        $ontimep = $this->Onetimep_model->get_limit_data($config['per_page'], $start, $q);
        $config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin pull-right">';
        $config['full_tag_close'] = '</ul>';
        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'otps' => $ontimep,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->template->load('template','sale/otp_list', $data);
    }

    public function paymentformfor() 
    {	
    	$invoice = $this->input->get('inv');
        $row = $this->Sale_model->get_by_invoice($invoice);
    	
    	$fetched = array(
    		'admin_fee' => $this->Dashboard_model->admin_fee(),
    		'sale_id' => $row->sale_id,
    		'invoice' => $row->invoice,
    		'pelanggan_id' => $row->pelanggan_id,
    		'sales_referral' => $row->sales_referral,
    		'contact_id' => $row->contact_id,
    		'item_id' => $row->item_id,
    		'total_price_sale' => $row->total_price_sale,
    		'biaya_admin' => $row->biaya_admin,
    		'total_bayar' => $row->total_bayar,
    		'dibayar' => $row->dibayar,
    		'type_sale' => $row->type_sale,
    		'jenis_bayar' => $row->jenis_bayar,
    		'tanggal_sale' => $row->tanggal_sale,
    		'last_updated' => $row->last_updated,
    		'user_id' => $row->user_id,
    		'surveyor_id' => $row->surveyor_id,
    		'status_sale' => $row->status_sale,
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
    		'unit_id' => $row->unit_id,
    		'kd_pembelian' => $row->kd_pembelian,
    		'agen_id' => $row->agen_id,
    		'kd_item' => $row->kd_item,
    		'nama_item' => $row->nama_item,
    		'kategori_id' => $row->kategori_id,
    		'jenis_item_id' => $row->jenis_item_id,
    		'type_id' => $row->type_id,
    		'merek_id' => $row->merek_id,
    		'no_stnk' => $row->no_stnk,
    		'no_bpkb' => $row->no_bpkb,
    		'tahun_buat' => $row->tahun_buat,
    		'warna1' => $row->warna1,
    		'warna2' => $row->warna2,
    		'kondisi' => $row->kondisi,
    		'no_mesin' => $row->no_mesin,
    		'no_rangka' => $row->no_rangka,
    		'deskripsi' => $row->deskripsi,
    		'harga_beli' => $row->harga_beli,
    		'harga_pokok' => $row->harga_pokok,
    		'tgl_beli' => $row->tgl_beli, 
    		'tgl_terdata' => $row->tgl_terdata,
    		'photo' => $row->photo,
    		'nama_type' => $row->nama_type,
    		'nama_merek' => $row->nama_merek,
    		'status' => $row->status,
    		'nama_user' => $row->nama_user,
    		'username' => $row->username,
    		'level_id' => $row->level_id,
			'admin_fee' => $this->Dashboard_model->admin_fee(),
            'karyawan' =>$this->karyawan_model->get_all(),
            'jenis_pembayaran' =>$this->Jenis_pembayaran_model->get_all(),
            'mitra' =>$this->Mitra_model->get_all(),
    	);

    	//print_r($fetched);
    	$this->template->load('template','sale/otp_form', $fetched);
    }

    public function paymentform() {
    	$invoice = $this->input->get('invoice');
    	$pelanggan_id = $this->input->get('idp');
    	$itemid = $this->input->get('buy');
    	$typeSale = $this->input->get('st');
    	$tanggalsale = date('Y-m-d H:i:s', strtotime($this->input->get('d'))); 
    	$userid = $this->input->get('user_id');
    	$total_price_sale = $this->input->get('pc');

    	$row = $this->Sale_model->get_by_invoice($invoice);

    	if ($row) {
    		redirect(site_url('onetimep/paymentformfor?inv='.$invoice));
    	} else {
    		$data = array(
	            'invoice' => $invoice,
	            'jenis_bayar' => 'N/A',
	            'pelanggan_id' => $pelanggan_id,
	            'item_id' => $itemid,
	            'total_price_sale' => $total_price_sale,
	            'biaya_admin' => 0,
	            'total_bayar' => 0,
	            'dibayar' => 0,
	            'type_sale' => $typeSale,
	            'tanggal_sale' => $tanggalsale,
	            'user_id' => $userid,
	            'surveyor_id' => 'N/A',
	            'sales_referral' => 'N/A',
	            'contact_id' => 'N/A',
	            'status_sale' => 'Belum Dibayar',
	        );

	     	$this->Sale_model->insert($typeSale, $data);

	    	$whereitem = array(
	            'item_id' => $itemid
	        );
	        $statustoupdate = array(
	            'status' => 'Proses Jual'
	        );

	        $this->Item_model->update($itemid, $statustoupdate);

	        $p = $this->Sale_model->get_by_invoice($invoice);

	    	$fetched = array(
	    		'admin_fee' => $this->Dashboard_model->admin_fee(),
	    		'sale_id' => $p->sale_id,
	    		'invoice' => $p->invoice,
	    		'pelanggan_id' => $p->pelanggan_id,
	    		'sales_referral' => $p->sales_referral,
	    		'contact_id' => $p->contact_id,
	    		'item_id' => $p->item_id,
	    		'total_price_sale' => $p->total_price_sale,
	    		'biaya_admin' => $p->biaya_admin,
	    		'total_bayar' => $p->total_bayar,
	    		'dibayar' => $p->dibayar,
	    		'type_sale' => $p->type_sale,
	    		'jenis_bayar' => $p->jenis_bayar,
	    		'tanggal_sale' => $p->tanggal_sale,
	    		'last_updated' => $p->last_updated,
	    		'user_id' => $p->user_id,
	    		'surveyor_id' => $p->surveyor_id,
	    		'status_sale' => $p->status_sale,
	    		'no_ktp' => $p->no_ktp,
	    		'no_kk' => $p->no_kk,
	    		'nama_pelanggan' => $p->nama_pelanggan,
	    		'no_hp_pelanggan' => $p->no_hp_pelanggan,
	    		'jenis_kelamin' => $p->jenis_kelamin,
	    		'alamat_ktp' => $p->alamat_ktp,
	    		'alamat_domisili' => $p->alamat_domisili,
	    		'nama_saudara' => $p->nama_saudara,
	    		'alamat_saudara' => $p->alamat_saudara,
	    		'no_hp_saudara' => $p->no_hp_saudara,
	    		'unit_id' => $p->unit_id,
	    		'kd_pembelian' => $p->kd_pembelian,
	    		'agen_id' => $p->agen_id,
	    		'kd_item' => $p->kd_item,
	    		'nama_item' => $p->nama_item,
	    		'kategori_id' => $p->kategori_id,
	    		'jenis_item_id' => $p->jenis_item_id,
	    		'type_id' => $p->type_id,
	    		'merek_id' => $p->merek_id,
	    		'no_stnk' => $p->no_stnk,
	    		'no_bpkb' => $p->no_bpkb,
	    		'tahun_buat' => $p->tahun_buat,
	    		'warna1' => $p->warna1,
	    		'warna2' => $p->warna2,
	    		'kondisi' => $p->kondisi,
	    		'no_mesin' => $p->no_mesin,
	    		'no_rangka' => $p->no_rangka,
	    		'deskripsi' => $p->deskripsi,
	    		'harga_beli' => $p->harga_beli,
	    		'harga_pokok' => $p->harga_pokok,
	    		'tgl_beli' => $p->tgl_beli, 
	    		'tgl_terdata' => $p->tgl_terdata,
	    		'photo' => $p->photo,
	    		'status' => $p->status,
	    		'nama_user' => $p->nama_user,
	    		'username' => $p->username,
	    		'nama_type' => $p->nama_type,
	    		'nama_merek' => $p->nama_merek,
	    		'level_id' => $p->level_id,
				'admin_fee' => $this->Dashboard_model->admin_fee(),
	            'karyawan' =>$this->karyawan_model->get_all(),
	            'jenis_pembayaran' =>$this->Jenis_pembayaran_model->get_all(),
	            'mitra' =>$this->Mitra_model->get_all(),
	    	);

	    	//print_r($fetched);
	    	$this->template->load('template','sale/otp_form', $fetched);
    	}

    } 
    
    public function update_payment() 
    {
        // $data = array(
        //     'invoice' => $id,
        //     'biaya_admin' => $biaya_admin,
        //     'jenis_bayar' => $this->input->post('jenis_pembayaran',TRUE),
        //     'pelanggan_id' => $this->input->post('pelanggan_id',TRUE),
        //     'item_id' => $itemid,
        //     'total_price_sale' => $total_price_sale,
        //     'biaya_admin' => $biaya_admin,
        //     'total_bayar' => $total_kewajiban_bayar,
        //     'dibayar' => $total_kewajiban_bayar,
        //     'type_sale' => $typeSale,
        //     'tanggal_sale' => $tanggalsale,
        //     'user_id' => $this->input->post('user_id',TRUE),
        //     'surveyor_id' => $this->input->post('surveyor_id',TRUE),
        //     'sales_referral' => $this->input->post('sales_referral',TRUE),
        //     'contact_id' => $contact_id,
        //     'status_sale' => $status_sale,
        // );

        // $this->Sale_model->update($id $data);
        // $this->session->set_flashdata('message', 'Data berhasil diupdate');
        // redirect(site_url('onetimep'));
    }
    
    public function delete($id) 
    {
        $row = $this->Mitra_model->get_by_id($id);

        if ($row) {
            $this->Mitra_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('mitra'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('mitra'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('nama_mitra', 'nama mitra', 'trim|required');
	$this->form_validation->set_rules('no_hp_mitra', 'no hp mitra', 'trim|required');
	$this->form_validation->set_rules('alamat', 'alamat', 'trim|required');
	$this->form_validation->set_rules('deskripsi', 'deskripsi', 'trim|required');
	$this->form_validation->set_rules('unit_id', 'unit id', 'trim|required');

	$this->form_validation->set_rules('mitra_id', 'mitra_id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "mitra.xls";
        $judul = "mitra";
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
	xlsWriteLabel($tablehead, $kolomhead++, "Nama Mitra");
	xlsWriteLabel($tablehead, $kolomhead++, "No Hp Mitra");
	xlsWriteLabel($tablehead, $kolomhead++, "Alamat");
	xlsWriteLabel($tablehead, $kolomhead++, "Deskripsi");

	foreach ($this->Mitra_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->nama_mitra);
	    xlsWriteLabel($tablebody, $kolombody++, $data->no_hp_mitra);
	    xlsWriteLabel($tablebody, $kolombody++, $data->alamat);
	    xlsWriteLabel($tablebody, $kolombody++, $data->deskripsi);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

}

/* End of file Mitra.php */
/* Location: ./application/controllers/Mitra.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-07-14 07:33:22 */
/* http://harviacode.com */