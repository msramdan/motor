<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class R_onetimep extends CI_Controller
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
    	is_allowed($this->uri->segment(1),null);
        $v = array(
            'invoice_id' => $this->session->flashdata('invoicenya')
        );
        $this->template->load('template','onetimepayment/onetimepayment_home', $v);
    }

    public function update($invoice)
    {
        $this->session->set_flashdata('invoicenya', $invoice);
        redirect('R_onetimep/', 'refresh');
    }

    public function saveandedit()
    {
        $invoice = $this->input->get('invoice');
        $pelanggan_id = $this->input->get('idp');
        $itemid = $this->input->get('buy');
        $typeSale = $this->input->get('st');
        $tanggalsale = date('Y-m-d H:i:s', strtotime($this->input->get('d')));
        $userid = $this->input->get('user_id');
        $total_price_sale = $this->input->get('pc');

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
            'keadaan_cicilan' => 'NULL',
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
        
        $this->session->set_flashdata('invoicenya', $invoice);
        redirect('R_onetimep/', 'refresh');
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

    	$id = $this->input->post('invoicehidden');

    	$contact_id = 'N/A';
        if ($this->input->post('sales_referral')=="Karyawan") {
            $contact_id = $this->input->post('karyawan_id');
        }
        if ($this->input->post('sales_referral')=="Mitra Sales") {
            $contact_id = $this->input->post('mitra_id');
		}

        $dibayar = $this->input->post('wajibdibayar');

        $biaya_admin = $this->input->post('biaya_admin');

		$tanggalsale = date('Y-m-d H:i:s', strtotime($this->input->post('tanggalsalehidden')));

        $datatoupdate = array(
            'invoice' => $id,
            'sales_referral' => $this->input->post('sales_referral'),
            'contact_id' => $contact_id,
            'total_price_sale' => $this->input->post('total_price_sale'),
            'biaya_admin' => $biaya_admin,

            
            'total_bayar' => $dibayar,     
            'dibayar' => $dibayar,
            
            'jenis_bayar' => $this->input->post('jenis_pembayaran'),
            
            'tanggal_sale' => $tanggalsale,
            

            // 'pelanggsan_id' => $this->input->post('pelanggan_id'),
            // 'item_id' => $itemid,
            // 'type_sale' => $typeSale,
            // 'user_id' => $this->input->post('user_id'),
            // 'surveyor_id' => $this->input->post('surveyor_id'),
            'status_sale' => 'Selesai',
        );
        
        $item_id = $this->input->post('iditem');
        

        $statustoupdate = array(
            'status' => 'Terjual'
        );
        $this->Item_model->update($item_id, $statustoupdate);

        $this->Sale_model->update_data_dibayar($id, $datatoupdate);
        

        $datahistorypayment = array(
            'id' => $id,
            'total_bayar' => $dibayar,
            'tanggal_bayar' => $tanggalsale,
            'jenis_pembayaran' => 'one time payment',
            'status' => 'dibayar',
            'deskripsi' => 'bayar cash',
            'unit_id' => $this->session->userdata('unit_id')
        );

        $this->Sale_model->inserttopaymenthistory($datahistorypayment);

        $datahistorypaymentadmin = array(
            'id' => $id,
            'total_bayar' => $biaya_admin,
            'tanggal_bayar' => $tanggalsale,
            'jenis_pembayaran' => 'biaya admin',
            'status' => 'dibayar',
            'deskripsi' => 'bayar biaya admin one time payment/cash',
            'unit_id' => $this->session->userdata('unit_id')
        );

        $this->Sale_model->inserttopaymenthistory($datahistorypaymentadmin);

        $row = $this->Sale_model->get_by_invoice($id);

        $sajidata = array(
            'sale_id' => $row->sale_id,
            'biaya_admin' => $row->biaya_admin,
            'invoice' => $row->invoice,
            'pelanggan_id' => $row->nama_pelanggan,
            'item_id' => $row->nama_item,
            'total_price_sale' => $row->total_price_sale,
            'type_sale' => $row->type_sale,
            'biaya_admin' => $row->biaya_admin,
            'total_bayar' => $row->total_bayar,
            'dibayar' => $row->dibayar,
            'status_sale' => $row->status_sale,
            'tanggal_sale' => $row->tanggal_sale,
            'last_updated' => $row->last_updated,
            'user_id' => $row->nama_user,
        );
        $this->load->view('sale/sale_read', $sajidata);
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

    public function searchInvoice()
    {
        $invoice = $this->input->post('idinvoice');

        $row = $this->Sale_model->get_by_invoice($invoice);
        $admin_fee = $this->Dashboard_model->admin_fee();
        $karyawan = $this->karyawan_model->get_all();
        $jenis_pembayaran = $this->Jenis_pembayaran_model->get_all();
        $mitra = $this->Mitra_model->get_all();
        if($row && $row->unit_id === $this->session->userdata('unit_id'))
        {
            if ($row->status_sale === 'Belum Dibayar' && $row->type_sale === 'Cash') {
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
                $this->load->view('onetimepayment/onetimepayment_form', $fetched);
            }

            if ($row->status_sale === 'Selesai' && $row->type_sale === 'Cash') {
                $row = $this->Sale_model->get_by_invoice($invoice);

                $sajidata = array(
                    'sale_id' => $row->sale_id,
                    'biaya_admin' => $row->biaya_admin,
                    'invoice' => $row->invoice,
                    'pelanggan_id' => $row->nama_pelanggan,
                    'item_id' => $row->nama_item,
                    'total_price_sale' => $row->total_price_sale,
                    'type_sale' => $row->type_sale,
                    'biaya_admin' => $row->biaya_admin,
                    'total_bayar' => $row->total_bayar,
                    'dibayar' => $row->dibayar,
                    'status_sale' => $row->status_sale,
                    'tanggal_sale' => $row->tanggal_sale,
                    'last_updated' => $row->last_updated,
                    'user_id' => $row->nama_user,
                );
                $this->load->view('onetimepayment/onetimepayment_read', $sajidata);
            }

            if ($row->type_sale === 'Kredit') {
                
                echo '  <div style="display: flex; flex-direction: column;margin-top: 17vh; text-align: center;">
                        <div><i class="fa fa-times" style="font-size: 65px"></i></div>
                        <h3 style="color: #9d9d9d;s">Data '.$invoice.' Tidak Ditemukan</h3>
                        <p>Lupa nomor invoice? coba cari di <a class="btn btn-warning btn-xs" href="'.base_url().'Sale">daftar penjualan</a></p>
                    <div>';
            }
        }
        else
        {
            echo '  <div style="display: flex; flex-direction: column;margin-top: 17vh; text-align: center;">
                        <div><i class="fa fa-times" style="font-size: 65px"></i></div>
                        <h3 style="color: #9d9d9d;s">Data '.$invoice.' Tidak Ditemukan</h3>
                        <p>Lupa nomor invoice? coba cari di <a class="btn btn-warning btn-xs" href="'.base_url().'Sale">daftar penjualan</a></p>
                    <div>';
        }
    }

}

/* End of file Mitra.php */
/* Location: ./application/controllers/Mitra.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-07-14 07:33:22 */
/* http://harviacode.com */