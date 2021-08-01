<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cicilan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Sale_model');
        $this->load->model('Sale_detail_model');
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
            $config['first_url'] = base_url() . 'index.php/cicilan/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'index.php/cicilan/index/';
            $config['first_url'] = base_url() . 'index.php/cicilan/index/';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = FALSE;
        $config['total_rows'] = count($this->Sale_detail_model->total_rows($q));
        $sale_detail = $this->Sale_detail_model->get_limit_data($config['per_page'], $start, $q);
        $config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin pull-right">';
        $config['full_tag_close'] = '</ul>';
        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'sale_detail_data' => $sale_detail,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->template->load('template','cicilan/sale_detail_list', $data);
    }

    public function detail($id) 
    {
        $listcicilan = $this->Sale_detail_model->get_by_id($id);
        if ($listcicilan) {
            $data['list_cicilan'] = $listcicilan;
            $data['invoicenya'] = $id;
            $this->template->load('template','cicilan/sale_detail_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('cicilan'));
        }
    }

    public function update($id) 
    {
        $row = $this->Sale_detail_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('sale_detail/update_action'),
        		'sale_detail_id' => set_value('sale_detail_id', $row->sale_detail_id),
        		'sale_id' => set_value('sale_id', $row->sale_id),
        		'pembayaran_ke' => set_value('pembayaran_ke', $row->pembayaran_ke),
        		'status' => set_value('status', $row->status),
        		'total_bayar' => set_value('total_bayar', $row->total_bayar),
        		'jatuh_tempo' => set_value('jatuh_tempo', $row->jatuh_tempo),
    	    );
            $this->template->load('template','cicilan/sale_detail_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('cicilan'));
        }
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
        $this->template->load('template','sale/cicilan_form', $fetched);
    }

    public function paymentform()
    {
        //sudah pasti type sale kreidit
        $invoice = $this->input->get('invoice');
        $pelanggan_id = $this->input->get('idp');
        $itemid = $this->input->get('buy');
        $typeSale = $this->input->get('st');
        $tanggalsale = date('Y-m-d H:i:s', strtotime($this->input->get('d')));
        $userid = $this->input->get('user_id');
        $total_price_sale = $this->input->get('pc');
        $cicilan_x = $this->input->get('ci');

        $row = $this->Sale_model->get_by_invoice($invoice);

        if ($row) {
            redirect(site_url('cicilan/paymentformfor?inv='.$invoice));
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
            $this->template->load('template','sale/cicilan_form', $fetched);
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

        $total_price_sale = $this->input->post('total_price_sale');
        $biaya_admin = $this->input->post('biaya_admin');

        $tanggalsale = date('Y-m-d H:i:s', strtotime($this->input->post('tanggalsalehidden')));

        $kudubayar = $this->input->post('wajibdibayar');

        $sales_referral = $this->input->post('sales_referral');

        $total_cicilan_brpa_x = $this->input->post('lama_cicilan');

        $total_bayar_pbulan_w_bunga = $this->input->post('bayaranpbulanb');

        $bungacicilan = $this->input->post('bunga_cicilan');

        $targetbayarcicilan = $this->input->post('bayaranpbulanb');

        $datatoupdate = array(
            'invoice' => $id,
            'sales_referral' => $sales_referral,
            'contact_id' => $contact_id,
            'total_price_sale' => $total_price_sale,
            'biaya_admin' => $biaya_admin,

            'total_bayar' => intval($total_bayar_pbulan_w_bunga) * intval($total_cicilan_brpa_x),
            'dibayar' => $kudubayar,
            
            'jenis_bayar' => $this->input->post('jenis_pembayaran',TRUE),
            'tanggal_sale' => $tanggalsale,

            'status_sale' => 'Dalam Cicilan',
        );

        $dataCicilan = [];

        //$targetbayarcicilan = ((intval($total_price_sale) + intval($biaya_admin))/$bungacicilan + intval($total_price_sale) + intval($biaya_admin))/$total_cicilan_brpa_x;

        $start = $month = strtotime($tanggalsale);
        for($i = 1; $i <= intval($total_cicilan_brpa_x); $i++) {
            $dataCicilan[] = array(
                'sale_id' => $id,
                'pembayaran_ke' => $i,
                'status' => 'belum dibayar',
                'total_bayar' => 0,
                'harus_dibayar' => $targetbayarcicilan,
                'jatuh_tempo' =>date('Y-m-d', $month), 
            );
            //this code should be optimized later for 'performance' impact purpose
            $month = strtotime("+1 month", $month);
        }

        $this->Sale_model->insert_data_cicilan($dataCicilan);

        $this->Sale_model->update_data_dibayar($id, $datatoupdate);

        $item_id = $this->input->post('iditem');
        

        $statustoupdate = array(
            'status' => 'Terjual'
        );
        $this->Item_model->update($item_id, $statustoupdate);

        $this->session->set_flashdata('message', 'Data berhasil diupdate');
        redirect(site_url('cicilan'));
    }

    public function update_cicilan()
    {
        $sale_detail_id = $this->input->post('idcicilan');
        $total_bayar = $this->input->post('valuecicilan');
        $invoice_id = $this->input->post('idinvoice');

        //check
        $cek = $this->Sale_detail_model->get_data_cicilan($sale_detail_id);

        if(intval($total_bayar) == $cek->harus_dibayar)
        {
            $dttotalcicilan = array(
                'total_bayar' => $total_bayar,
                'status' => 'dibayar'
            );

            $this->Sale_detail_model->update($sale_detail_id,$dttotalcicilan);
            echo json_encode('<button type="button" class="btn btn-success btn-xs">Lunas</button>');
        }

        if(intval($total_bayar) < intval($cek->harus_dibayar)) {
            $dttotalcicilan = array(
                'total_bayar' => $total_bayar,
                'status' => 'belum dibayar'
            );

            $this->Sale_detail_model->update($sale_detail_id,$dttotalcicilan);
            echo json_encode('<button type="button" class="btn btn-warning btn-xs">Pembayaran Kurang (dibayar = '.$total_bayar.')</button>');
        }

        if(intval($total_bayar) > intval($cek->harus_dibayar)) {
            $dttotalcicilan = array(
                'total_bayar' => $total_bayar,
                'status' => 'dibayar'
            );

            $this->Sale_detail_model->update($sale_detail_id,$dttotalcicilan);

            echo json_encode('<button type="button" class="btn btn-secondary btn-xs">Pembayaran Berlebih (dibayar = '.$total_bayar.')</button>');
        }

        $this->update_sale_dibayar($invoice_id);

    }

    public function update_sale_dibayar($id) {
        $dibayar = $this->Sale_detail_model->getpaiddetail($id);
        
        $gettotaldibayarsekarang = $dibayar->telah_dibayar;
        
        $data = array(
            'dibayar' => $gettotaldibayarsekarang
        );

        $this->Sale_model->update_data_dibayar($id,$data);
    }
    
    
    public function delete($id) 
    {
        $row = $this->Sale_detail_model->get_by_id($id);

        if ($row) {
            $this->Sale_detail_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('cicilan'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('cicilan'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('sale_id', 'sale id', 'trim|required');
	$this->form_validation->set_rules('pembayaran_ke', 'pembayaran ke', 'trim|required');
	$this->form_validation->set_rules('status', 'status', 'trim|required');
	$this->form_validation->set_rules('total_bayar', 'total bayar', 'trim|required');
	$this->form_validation->set_rules('jatuh_tempo', 'jatuh tempo', 'trim|required');

	$this->form_validation->set_rules('sale_detail_id', 'sale_detail_id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "sale_detail.xls";
        $judul = "sale_detail";
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
	xlsWriteLabel($tablehead, $kolomhead++, "Sale Id");
	xlsWriteLabel($tablehead, $kolomhead++, "Pembayaran Ke");
	xlsWriteLabel($tablehead, $kolomhead++, "Status");
	xlsWriteLabel($tablehead, $kolomhead++, "Total Bayar");
	xlsWriteLabel($tablehead, $kolomhead++, "Jatuh Tempo");

	foreach ($this->Sale_detail_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->sale_id);
	    xlsWriteNumber($tablebody, $kolombody++, $data->pembayaran_ke);
	    xlsWriteLabel($tablebody, $kolombody++, $data->status);
	    xlsWriteNumber($tablebody, $kolombody++, $data->total_bayar);
	    xlsWriteLabel($tablebody, $kolombody++, $data->jatuh_tempo);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=sale_detail.doc");

        $data = array(
            'sale_detail_data' => $this->Sale_detail_model->get_all(),
            'start' => 0
        );
        
        $this->load->view('sale_detail/sale_detail_doc',$data);
    }

}

/* End of file Sale_detail.php */
/* Location: ./application/controllers/Sale_detail.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-07-26 14:34:47 */
/* http://harviacode.com */