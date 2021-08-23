<?php

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class R_cicilan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Sale_model');
        $this->load->model('Sale_detail_model');
        $this->load->model('Dashboard_model');
        $this->load->model('Item_model');
        $this->load->model('Denda_model');
        $this->load->model('karyawan_model');
        $this->load->model('Jenis_pembayaran_model');
        $this->load->model('Mitra_model');
        $this->load->model('Pelanggan_model');
        $this->load->model('Onetimep_model');
        $this->load->model('Approval_lists_model');
        $this->load->library('form_validation');
        $this->load->library('pdf');
        $this->load->library('Custom_authorization');
    }

    public function index()
    {
        is_allowed($this->uri->segment(1),null);

        $v = array(
            'invoice_id' => $this->session->flashdata('invoicenya')
        );
        $this->template->load('template','cicilan/cicilan_home', $v);
    }

    public function update($invoice)
    {
        is_allowed($this->uri->segment(1),null);
        $this->session->set_flashdata('invoicenya', $invoice);
        redirect('R_cicilan/', 'refresh');
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
        $cicilan_x = $this->input->get('ci');

        $row = $this->Sale_model->get_by_invoice($invoice);
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

        $this->session->set_flashdata('invoicenya', $invoice);
        redirect('R_cicilan/', 'refresh');
    }

    public function searchInvoice()
    {
        $invoice = $this->input->post('idinvoice');

        $row = $this->Sale_model->get_by_invoice($invoice);
        $admin_fee = $this->Dashboard_model->admin_fee();
        $karyawan = $this->karyawan_model->get_all();
        $jenis_pembayaran = $this->Jenis_pembayaran_model->get_all();
        $mitra = $this->Mitra_model->get_all();
        if($row)
        {
            if ($row->status_sale === 'Belum Dibayar' && $row->type_sale === 'Kredit') {
                $this->form($invoice);
            }

            if ($row->status_sale === 'Dalam Review' && $row->type_sale === 'Kredit') {
                $this->show_inreview($invoice);
            }

            if ($row->status_sale === 'Dalam Cicilan' && $row->type_sale === 'Kredit') {
                $this->show_progresscicilan($invoice);
            }

            if ($row->status_sale === 'Selesai' && $row->type_sale === 'Kredit') {
                $this->show_cicilanfinalinfo($invoice);
            }

            if ($row->type_sale === 'Cash') {
                
                echo '  <div style="display: flex; flex-direction: column;margin-top: 17vh; text-align: center;">
                        <div><i class="fa fa-times" style="font-size: 65px"></i></div>
                        <h3 style="color: #9d9d9d;s">Data '.$invoice.' Tidak Ditemukan</h3>
                        <p>Lupa nomor invoice? coba cari di <a class="btn btn-warning btn-xs" href="'. base_url().'Sale">daftar penjualan</a></p>
                    <div>';
            }
        }
        else
        {
            echo '  <div style="display: flex; flex-direction: column;margin-top: 17vh; text-align: center;">
                        <div><i class="fa fa-times" style="font-size: 65px"></i></div>
                        <h3 style="color: #9d9d9d;s">Data '.$invoice.' Tidak Ditemukan</h3>
                        <p>Lupa nomor invoice? coba cari di <a class="btn btn-warning btn-xs" href="'. base_url().'Sale">daftar penjualan</a></p>
                    <div>';
        }
    }

    public function form($invoice)
    {
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
            'bunga' => $this->Dashboard_model->bunga()
        );

        //print_r($fetched);
        $this->load->view('cicilan/cicilan_form', $fetched);
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

        $total_bayar_pbulan_pokok = $this->input->post('bayaranpbulantb');

        $total_bayar_pbulan_w_bunga = $this->input->post('bayaranpbulanb');

        $bungacicilan = $this->input->post('bunga_cicilan');

        $targetbayarcicilan = $this->input->post('bayaranpbulanb');

        $komentar = $this->input->post('keterangan',TRUE);
        $totaltransaksi = intval($total_price_sale) + intval($biaya_admin);

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

            'status_sale' => 'Dalam Review'
        );

        $dataCicilan = [];

        $time = strtotime($this->input->post('tanggalsalehidden'));
        $final = date("Y-m-d", strtotime("+1 month", $time));

        $start = $month = strtotime($final);
        for($i = 1; $i <= intval($total_cicilan_brpa_x); $i++) {
            if ($i === 1) {
                $dataCicilan[] = array(
                    'sale_id' => $id,
                    'pembayaran_ke' => $i,
                    'status' => 'siap dibayar',
                    'total_bayar' => 0,
                    'pokok_cicilan' => $total_bayar_pbulan_pokok,
                    'harus_dibayar' => $targetbayarcicilan,
                    'nilai_bunga_percicilan' => $bungacicilan,
                    'jatuh_tempo' =>date('Y-m-d', $month), 
                );
            } else {
                $dataCicilan[] = array(
                    'sale_id' => $id,
                    'pembayaran_ke' => $i,
                    'status' => 'belum siap dibayar',
                    'total_bayar' => 0,
                    'pokok_cicilan' => $total_bayar_pbulan_pokok,
                    'harus_dibayar' => $targetbayarcicilan,
                    'nilai_bunga_percicilan' => $bungacicilan,
                    'jatuh_tempo' =>date('Y-m-d', $month), 
                );
                
            }
            //this code should be optimized later for 'performance' impact purpose
            $month = strtotime("+1 month", $month);
        }

        $ket = $this->input->post('komentar',TRUE);

        if ($ket == null) {
            $ket = 'Tidak ada';
        }

        $approval_stage = $this->custom_authorization->addApprovalby($totaltransaksi);
        $data = array(
            'invoice_id' => $id,
            'approve_by' => $approval_stage,
            'approval_status' => 'Dalam Review',
            'keterangan' => $ket,
            'jenis_tindakan' => 'Pembayaran Kredit',
            'komentar' => '',
            'unit_id' => $this->session->userdata('unit_id')
        );

        $this->Approval_lists_model->insert($data);

        $this->Sale_model->insert_data_cicilan($dataCicilan);

        $this->Sale_model->update_data_dibayar($id, $datatoupdate);

        $datahistorypayment = array(
            'id' => $id,
            'total_bayar' => $kudubayar,
            'tanggal_bayar' => $tanggalsale,
            'jenis_pembayaran' => 'dp cicilan',
            'status' => 'dibayar',
            'deskripsi' => 'bayar dp cicilan',
            'unit_id' => $this->session->userdata('unit_id')
        );

        $this->Sale_model->inserttopaymenthistory($datahistorypayment);



        $fetchone = $this->Approval_lists_model->get_by_invoice($id);

        $fetchedsecond = $this->Sale_model->get_by_invoice($id);
        
        $sajidata = array(
            'approval_id' => $fetchone->approval_id,
            'invoice_id' => $fetchone->invoice_id,
            'whoisreviewing' => $approval_stage,
            'approval_status' => $fetchone->approval_status,
            'keterangan' => $fetchone->keterangan,
            'komentar' => $fetchone->komentar,

            'sale_id' => $fetchedsecond->sale_id,
            'biaya_admin' => $fetchedsecond->biaya_admin,
            'pelanggan_id' => $fetchedsecond->nama_pelanggan,
            'item_id' => $fetchedsecond->nama_item,
            'total_price_sale' => $fetchedsecond->total_price_sale,
            'type_sale' => $fetchedsecond->type_sale,
            'biaya_admin' => $fetchedsecond->biaya_admin,
            'total_bayar' => $fetchedsecond->total_bayar,
            'dibayar' => $fetchedsecond->dibayar,
            'status_sale' => $fetchedsecond->status_sale,
            'tanggal_sale' => $fetchedsecond->tanggal_sale,
            'last_updated' => $fetchedsecond->last_updated,
            'user_id' => $fetchedsecond->nama_user,

            'berkas' =>$this->Pelanggan_model->get_berkas($fetchedsecond->pelanggan_id)
        );
        
        $this->load->view('cicilan/cicilan_inreview', $sajidata);
    }

    public function show_inreview() 
    {
        $id = $this->input->post('idinvoice');
        $row = $this->Approval_lists_model->get_by_invoice($id);

        $sale = $this->Sale_model->get_by_invoice($id);

        $data = array(
            'approval_id' => $row->approval_id,
            'invoice_id' => $row->invoice_id,
            'whoisreviewing' => $row->approve_by,
            'approval_status' => $row->approval_status,
            'keterangan' => $row->keterangan,
            'komentar' => $row->komentar,

            'sale_id' => $sale->sale_id,
            'biaya_admin' => $sale->biaya_admin,
            'pelanggan_id' => $sale->nama_pelanggan,
            'item_id' => $sale->nama_item,
            'total_price_sale' => $sale->total_price_sale,
            'type_sale' => $sale->type_sale,
            'biaya_admin' => $sale->biaya_admin,
            'total_bayar' => $sale->total_bayar,
            'dibayar' => $sale->dibayar,
            'status_sale' => $sale->status_sale,
            'tanggal_sale' => $sale->tanggal_sale,
            'last_updated' => $sale->last_updated,
            'user_id' => $sale->nama_user,

            'berkas' =>$this->Pelanggan_model->get_berkas($sale->pelanggan_id),
        );
        $this->load->view('cicilan/cicilan_inreview', $data);
    }

    public function show_progresscicilan($invoice)
    {
        $row = $this->Sale_model->get_by_invoice($invoice);

        $listcicilan = $this->Sale_detail_model->get_by_id($invoice);

        $sisapembayaran = $this->Sale_detail_model->count_sisa_pembayaran($invoice);

        $progresscicilan = $this->Sale_detail_model->get_progress_jumlah_cicilan($invoice);

        $sajidata = array(
            'invoice_id' => $invoice,
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
            'list_cicilan' => $listcicilan,
            'user_id' => $row->nama_user,

            'sisapembayaranbrapax' => $sisapembayaran,

            'progresscicilan' => $progresscicilan,
            'classnyak' => $this
        );
        $this->load->view('cicilan/cicilan_inprogress', $sajidata);
    }

    public function show_cicilanfinalinfo($invoice) 
    {
        $row = $this->Approval_lists_model->get_by_invoice($invoice);

        $sale = $this->Sale_model->get_by_invoice($invoice);

        $listcicilan = $this->Sale_detail_model->get_by_id($invoice);

        $sisapembayaran = $this->Sale_detail_model->count_sisa_pembayaran($invoice);

        $progresscicilan = $this->Sale_detail_model->get_progress_jumlah_cicilan($invoice);

        $data = array(
            'approval_id' => $row->approval_id,
            'invoice_id' => $row->invoice_id,
            'whoisreviewing' => $row->approve_by,
            'approval_status' => $row->approval_status,
            'keterangan' => $row->keterangan,
            'komentar' => $row->komentar,

            'sale_id' => $sale->sale_id,
            'biaya_admin' => $sale->biaya_admin,
            'pelanggan_id' => $sale->nama_pelanggan,
            'item_id' => $sale->nama_item,
            'total_price_sale' => $sale->total_price_sale,
            'type_sale' => $sale->type_sale,
            'biaya_admin' => $sale->biaya_admin,
            'total_bayar' => $sale->total_bayar,
            'dibayar' => $sale->dibayar,
            'status_sale' => $sale->status_sale,
            'tanggal_sale' => $sale->tanggal_sale,
            'last_updated' => $sale->last_updated,
            'user_id' => $sale->nama_user,

            'list_cicilan' => $listcicilan,
            'sisapembayaranbrapax' => $sisapembayaran,

            'progresscicilan' => $progresscicilan,
            'classnyak' => $this,

            'berkas' =>$this->Pelanggan_model->get_berkas($sale->pelanggan_id),
            'cekdenda' => $this->cekDendapadaInvoice($invoice)
        );
        $this->load->view('cicilan/cicilan_selesaiinfo', $data);
    }

    public function update_cicilan()
    {
        $this->load->library('Fungsi');
        $sale_detail_id = $this->input->post('idcicilan');
        $total_bayar = $this->input->post('valuecicilan');
        $invoice_id = $this->input->post('idinvoice');

        $pembayaranke = $this->input->post('pembayaranke');

        $tglinput = date("d-m-Y h:m:s"); 
        $penginput = $this->fungsi->user_login()->username;
        $label = '';

        $statusbayarancicilan = '';

        $cek = $this->Sale_detail_model->get_data_cicilan($sale_detail_id);

        if ($total_bayar) {
            if(intval($total_bayar) == intval($cek->harus_dibayar))
            {
                $statusbayarancicilan = 'dibayar';
                $label = '<button type="button" class="btn btn-success btn-xs">Lunas</button>';

                $datahistorypayment = array(
                    'id' => $invoice_id,
                    'total_bayar' => $total_bayar,
                    'tanggal_bayar' => $tglinput,
                    'jenis_pembayaran' => 'bayar cicilan',
                    'status' => 'dibayar',
                    'deskripsi' => 'bayar cicilan ke '.$pembayaranke,
                    'unit_id' => $this->session->userdata('unit_id')
                );

                $this->Sale_model->inserttopaymenthistory($datahistorypayment);
            }

            if(intval($total_bayar) < intval($cek->harus_dibayar)) {
                $statusbayarancicilan = 'siap dibayar';    
                $label = '<button type="button" class="btn btn-warning btn-xs">Pembayaran Kurang (dibayar = '.$total_bayar.')</button>';
            }

            if(intval($total_bayar) > intval($cek->harus_dibayar)) {
                $statusbayarancicilan = 'siap dibayar';
                $label = '<button type="button" class="btn btn-secondary btn-xs">Pembayaran Berlebih (dibayar = '.$total_bayar.')</button>';
            }

            // it should be initiated if no value entered!
            if(!intval($total_bayar)) {
                $statusbayarancicilan = 'siap dibayar';
                $label = '<button type="button" class="btn btn-danger btn-xs">belum lunas</button>';
            }
            $dttotalcicilan = array(
                'total_bayar' => $total_bayar,
                'status' => $statusbayarancicilan,
                'tanggal_dibayar' => $tglinput,
                'penginput' => $penginput
            );
            $this->Sale_detail_model->update($sale_detail_id,$dttotalcicilan);

        }

        $this->update_sale_dibayar($invoice_id);

        $semuacicilanlunaskah = $this->pastikanSemuaCicilanLunas($invoice_id);

        $test = 'no';

        if ($statusbayarancicilan == 'dibayar') {
            $test = $this->updateNextCicilan($invoice_id);
        }
        $datatoechoed = array(
            'tglinput' => $tglinput,
            'penginput' => $penginput,
            'label' => $label,
            'lunaskah' => $semuacicilanlunaskah,
            'statusbayarcicilanini' => $statusbayarancicilan,
            'test' => json_encode($test)
        );

        echo json_encode($datatoechoed);

    }

    public function update_sale_dibayar($id) {
        $dibayar = $this->Sale_detail_model->getpaiddetail($id);
        
        $gettotaldibayarsekarang = $dibayar->telah_dibayar;
        
        $data = array(
            'dibayar' => $gettotaldibayarsekarang
        );

        $this->Sale_model->update_data_dibayar($id,$data);
    }

    public function refresh_cicilan_table()
    {   
        $invoice = $this->input->post('idinvoice');
        $listcicilan = $this->Sale_detail_model->get_by_id($invoice);
        $sisapembayaran = $this->Sale_detail_model->count_sisa_pembayaran($invoice);
        $arr = array(
            'list_cicilan' => $listcicilan,
            'sisapembayaranbrapax' => $sisapembayaran,
            'classnyak' => $this // it really breaks the principal of MVC, should fine another way later (timestamp: 15:46, 19 Agustus 2021)
        );
        
        $this->load->view('cicilan/cicilan_table', $arr);
        
    }

    public function updateNextCicilan($invoice)
    {
        $deteksipembayranyangbelumreadylast = $this->Sale_detail_model->deteksidatacicilan($invoice, 'belum siap dibayar');

        if ($deteksipembayranyangbelumreadylast) {
            $updatenextcicilan = array(
                'status' => 'siap dibayar',
            );
            $this->Sale_detail_model->update($deteksipembayranyangbelumreadylast->sale_detail_id, $updatenextcicilan);

            return $deteksipembayranyangbelumreadylast;
        }
    }

    public function cekDenda($sale_detail_id)
    {
        $cek = $this->Sale_detail_model->get_data_cicilan($sale_detail_id);

        $jatuhtempo = new DateTime($cek->jatuh_tempo);
        $haribayarnya = new DateTime();
        $abs_diff = $haribayarnya->diff($jatuhtempo)->format("%r%a");
        
        $cekdenda = $this->Denda_model->get_by_id($sale_detail_id);

        if ($cekdenda) {
            if ($cekdenda->status == 'dibayar') {
                return 'denda lunas';
            }

            if ($cekdenda->status == 'belum dibayar' || $cekdenda->status == 'belum lunas') {
                $arrdatadenda = array(
                    'jumlah_telat_hari' => $cekdenda->jumlah_telat_hari,
                    'jumlah_denda' => $cekdenda->jumlah_denda,
                    'diskon_denda' => $cekdenda->diskon_denda,
                    'dibayar' => $cekdenda->dibayar,
                    'status' => $cekdenda->status
                ); 
                return $arrdatadenda;
            }
        }

        if (!$cekdenda) {
            if ($abs_diff < 0) {
                $datatunggakan = array(
                    'sale_detail_id' => $sale_detail_id,
                    'jumlah_telat_hari' => abs($abs_diff),
                    'jumlah_denda' => intval((0.05 * intval($cek->harus_dibayar)) * abs($abs_diff)),
                    'diskon_denda' => 0,
                    'dibayar' => 0,
                    'status' => 'belum dibayar'
                );
                $this->Denda_model->insert($datatunggakan);
                $denda = $datatunggakan;
                return $datatunggakan;
            }
            return 'tidak ada denda';
        }
    }

    public function pastikanSemuaCicilanLunas($invoice_id)
    {
        $cekstatuslunas = $this->Sale_detail_model->cekstatuslunas($invoice_id);

        // $cekdendaberdasarkaninvoice = $this->Denda_model->cekdendaberdasarkaninvoice($invoide_id);

        $datatunggakan = 'tidak ada';
        $cekalldendadataonthisinvoice = $this->Sale_detail_model->ceksemuadendapadainvoiceini($invoice_id);
        if ($cekstatuslunas->telah_bayar == $cekstatuslunas->total_bayar) {

            if ($cekalldendadataonthisinvoice < 1) {
                $lunaskah = 'Lunas';
                $datatoupdate = array(
                    'status_sale' => 'Selesai',
                );
                $this->Sale_model->update_data_dibayar($invoice_id, $datatoupdate);
                return $lunaskah;
            } else {
                $lunaskah = 'Lunas dengan denda';
                $datatoupdate = array(
                    'status_sale' => 'Selesai',
                );
                $this->Sale_model->update_data_dibayar($invoice_id, $datatoupdate);
                return $lunaskah;
            }
        } else {
            $lunaskah = 'belum lunas';
            $datatoupdate = array(
                'status_sale' => 'Dalam Cicilan',
            );
            $this->Sale_model->update_data_dibayar($invoice_id, $datatoupdate);
            return $lunaskah;
        }
    }

    public function cekDendapadaInvoice($invoice_id)
    {
        $cekalldendadataonthisinvoice = $this->Sale_detail_model->ceksemuadendapadainvoiceini($invoice_id);
        if ($cekalldendadataonthisinvoice < 1) {
            $lunaskah = 'Lunas';
            return $lunaskah;
        } else {
            $lunaskah = 'Lunas dengan denda';
            return $lunaskah;
        }
    }

    public function bayarDenda()
    {
        $sale_detail_id = $this->input->post('idcicilan');
        $dibayar = $this->input->post('tbjumlahbayar');
        $invoice_id = $this->input->post('invoicehidden');
        $cicilanke = $this->input->post('cicilanke');

        $cek = $this->Denda_model->get_by_id($sale_detail_id);

        $init = intval($cek->dibayar);

        $added = $init + intval($dibayar);

        if ($cek->dibayar < $cek->jumlah_denda) {
            if ($added <= $cek->jumlah_denda) {
                $datatunggakan;

                if ($added == $cek->jumlah_denda) {
                    $datatunggakan = array(
                        'dibayar' => $added,
                        'status' => 'dibayar'
                    );
                }

                if ($added < $cek->jumlah_denda) {
                    $datatunggakan = array(
                        'dibayar' => $added,
                        'status' => 'belum lunas'
                    );
                }

                if ($added > $cek->jumlah_denda) {
                    $datatunggakan = array(
                        'dibayar' => $added,
                        'status' => 'kelebihan'
                    );
                }

                $this->Denda_model->update_by_sale_data_id($sale_detail_id, $datatunggakan);

                $datacicilan = $this->Sale_detail_model->get_data_cicilan($sale_detail_id);
                $datahistorypayment = array(
                    'id' => $invoice_id,
                    'total_bayar' => $dibayar,
                    'tanggal_bayar' => date("Y-m-d h:m:s"),
                    'jenis_pembayaran' => 'bayar denda',
                    'status' => $datatunggakan['status'],
                    'deskripsi' => 'bayar denda cicilan ke '.$cicilanke,
                    'unit_id' => $this->session->userdata('unit_id')
                );

                $this->Sale_model->inserttopaymenthistory($datahistorypayment);
                
                $p = array(
                    'status' => 'success'
                );
                echo json_encode($p);
            }
            else
            {
                $p = array(
                    'status' => 'bayarnyakelebihan',
                    'recommendedvalue' => $cek->jumlah_denda - $cek->dibayar
                );
                echo json_encode($p);
            }
        }
        else
        {
            $p = array(
                'status' => 'udahlunas'
            );
            echo json_encode($p);
        }
    }

    public function pengajuanDiskonDenda()
    {
        $id = $this->input->post('invoice_id');
        $ket = $this->input->post('catatan');

        $approval_stage = $this->custom_authorization->addApprovalby('p-diskondenda');

        $data = array(
            'invoice_id' => $id,
            'approve_by' => $approval_stage,
            'approval_status' => 'Dalam Review',
            'keterangan' => $ket,
            'jenis_tindakan' => 'Pengajuan Diskon',
            'komentar' => '',
            'unit_id' => $this->session->userdata('unit_id')
        );

        $this->Approval_lists_model->insert($data);
        return json_encode('success');
    }

    public function kwitansiBayardenda($pembayaranke, $invoice)
    {
        $pdf = new FPDF('l','mm','A5');
        $data = $this->Denda_model->get_invoice_profile($invoice);
        $datadenda = $this->Denda_model->getInfoDendaBerdasarkanInvoice($invoice);

        $pdf->AddPage();

        $pdf->setxY(15, 10);$pdf->SetFont('Arial','B',16);$pdf->Cell(100,7,'KWITANSI PEMBAYARAN DENDA',0,0,'L');

        $pdf->setXY(15, 25);
        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(35,6,'Nama Pelanggan',0,2,'L');
        $pdf->Cell(35,6,'No. HP',0,2,'L');
        $pdf->Cell(35,6,'Alamat',0,2,'L');
        $pdf->setXY(15, 55);
        $pdf->Cell(35,6,'Type Sale',0,2,'L');

        $pdf->setXY(40, 25);
        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(35,6,':',0,2,'L');
        $pdf->Cell(35,6,':',0,2,'L');
        $pdf->Cell(35,6,':',0,2,'L');

        $pdf->setXY(42, 25);
        $pdf->SetFont('Arial','',8);
        $pdf->Cell(65,6,$data->nama_pelanggan,0,2,'L');
        $pdf->Cell(65,6,$data->no_hp_pelanggan,0,2,'L');
        $pdf->MultiCell(50,6,$data->alamat_ktp,0,'L',false);
        
        $pdf->setXY(15, 55);
        $pdf->Cell(35,6,'Type Sale',0,2,'L');
        $pdf->setXY(50, 55);
        $pdf->Cell(65,6,': '.$data->type_sale,0,2,'L');

        
        // SET X itu dari pojok kiri atas ke kanan
        // SET Y itu dari pojok kiri atas ke bawah
        // setXY() DUAA DUANYA
        
        $pdf->setXY(120, 19);
        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(20,6,'Invoice',0,2,'L');
        $pdf->Cell(20,6,'Tanggal',0,2,'L');
        $pdf->Cell(20,6,'Halaman',0,2,'L');

        $pdf->setXY(140, 19);
        $pdf->SetFont('Arial','',8);
        $pdf->Cell(50,6,': '.$data->invoice,0,2,'L');
        $pdf->Cell(50,6,': '.date('d-m-Y h:m:s'),0,2,'L');
        $pdf->Cell(50,6,': 1',0,2,'L');
        

        $pdf->setXY(10, 70);
        $pdf->SetFont('Arial','B',9);
        $pdf->Cell(7,6,'No',1,0);
        $pdf->Cell(85,6,'Deskripsi',1,0);
        $pdf->Cell(25,6,'Qty',1,0);
        $pdf->Cell(25,6,'Harga',1,0);
        $pdf->Cell(25,6,'Jumlah',1,1);
        
        $pdf->SetFont('Arial','',9);
        $pdf->Cell(7,25,'1',1,0);
        $x_axis = $pdf->getx();
        $pdf->vcell(85,25,$x_axis,'Bayar denda pembayaran ke-'.$pembayaranke.' untuk invoice '.$data->invoice.'(lewat '.$datadenda->jumlah_telat_hari.' hari sejak '.$datadenda->jatuh_tempo.')');
        $pdf->Cell(25,25,'1',1,0);
        $pdf->Cell(25,25,$datadenda->jumlah_denda,1,0);
        $pdf->Cell(25,25,$datadenda->jumlah_denda,1,0);
        $pdf->setXY(127, 101);
        $pdf->Cell(25,6,'Biaya Admin',0,0);
        $pdf->Cell(25,6,'0',1,0);
        $pdf->setXY(127, 107);
        $pdf->Cell(25,6,'Grand Total',0,0);
        $pdf->Cell(25,6,$datadenda->jumlah_denda,1,0);


        $pdf->setXY(20, 120);
        $pdf->Cell(50,6,'(KASIR)',0,0,'C');
        $pdf->Output('kwitansidenda'.$invoice.$pembayaranke.'.pdf', 'D');
    }

    public function kwitansiBayarCicilan($sale_detail_id, $invoice, $pembayaranke)
    {
        $pdf = new FPDF('l','mm','A5');
        $data = $this->Denda_model->get_invoice_profile($invoice);
        $cek = $this->Sale_detail_model->get_data_cicilan($sale_detail_id);

        $pdf->AddPage();

        $pdf->setxY(15, 10);$pdf->SetFont('Arial','B',16);$pdf->Cell(100,7,'KWITANSI CICILAN',0,0,'L');

        $pdf->setXY(15, 25);
        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(35,6,'Nama Pelanggan',0,2,'L');
        $pdf->Cell(35,6,'No. HP',0,2,'L');
        $pdf->Cell(35,6,'Alamat',0,2,'L');
        $pdf->setXY(15, 55);
        $pdf->Cell(35,6,'Type Sale',0,2,'L');

        $pdf->setXY(40, 25);
        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(35,6,':',0,2,'L');
        $pdf->Cell(35,6,':',0,2,'L');
        $pdf->Cell(35,6,':',0,2,'L');

        $pdf->setXY(42, 25);
        $pdf->SetFont('Arial','',8);
        $pdf->Cell(65,6,$data->nama_pelanggan,0,2,'L');
        $pdf->Cell(65,6,$data->no_hp_pelanggan,0,2,'L');
        $pdf->MultiCell(50,6,$data->alamat_ktp,0,'L',false);
        
        $pdf->setXY(15, 55);
        $pdf->Cell(35,6,'Type Sale',0,2,'L');
        $pdf->setXY(50, 55);
        $pdf->Cell(65,6,': '.$data->type_sale,0,2,'L');

        
        // SET X itu dari pojok kiri atas ke kanan
        // SET Y itu dari pojok kiri atas ke bawah
        // setXY() DUAA DUANYA
        
        $pdf->setXY(120, 19);
        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(20,6,'Invoice',0,2,'L');
        $pdf->Cell(20,6,'Tanggal',0,2,'L');
        $pdf->Cell(20,6,'Halaman',0,2,'L');

        $pdf->setXY(140, 19);
        $pdf->SetFont('Arial','',8);
        $pdf->Cell(50,6,': '.$data->invoice,0,2,'L');
        $pdf->Cell(50,6,': '.date('d-m-Y h:m:s'),0,2,'L');
        $pdf->Cell(50,6,': 1',0,2,'L');
        

        $pdf->setXY(10, 70);
        $pdf->SetFont('Arial','B',9);
        $pdf->Cell(7,6,'No',1,0);
        $pdf->Cell(85,6,'Deskripsi',1,0);
        $pdf->Cell(25,6,'Qty',1,0);
        $pdf->Cell(25,6,'Harga',1,0);
        $pdf->Cell(25,6,'Jumlah',1,1);
        
        $pdf->SetFont('Arial','',9);
        $pdf->Cell(7,25,'1',1,0);
        $x_axis = $pdf->getx();
        $pdf->vcell(85,25,$x_axis,'Bayar cicilan pembayaran ke-'.$pembayaranke.' untuk invoice '.$data->invoice);
        $pdf->Cell(25,25,'1',1,0);
        $pdf->Cell(25,25,$cek->total_bayar,1,0);
        $pdf->Cell(25,25,$cek->total_bayar,1,0);
        $pdf->setXY(127, 101);
        $pdf->Cell(25,6,'Biaya Admin',0,0);
        $pdf->Cell(25,6,'0',1,0);
        $pdf->setXY(127, 107);
        $pdf->Cell(25,6,'Grand Total',0,0);
        $pdf->Cell(25,6,$cek->total_bayar,1,0);


        $pdf->setXY(20, 120);
        $pdf->Cell(50,6,'(KASIR)',0,0,'C');
        $pdf->Output('kwitansicicilan'.$invoice.$pembayaranke.'.pdf', 'D');
    }

    public function kartuPiutang($invoice)
    {

        $row = $this->Sale_model->get_kartupiutang_data($invoice);

        $fetched = array(
            'admin_fee' => $this->Dashboard_model->admin_fee(),
            'sale_id' => $row->sale_id,
            'invoice' => $row->invoice,
            'bunga_cicilan' => $this->Sale_model->get_bungapercicilan($invoice),
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
            'nama_jenis_item' => $row->nama_jenis_item,
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
            'status' => $row->status,
            'nama_user' => $row->nama_user,
            'username' => $row->username,
            'nama_type' => $row->nama_type,
            'nama_merek' => $row->nama_merek,
            'level_id' => $row->level_id,
            'admin_fee' => $this->Dashboard_model->admin_fee(),
            'karyawan' =>$this->karyawan_model->get_all(),
            'jenis_pembayaran' =>$this->Jenis_pembayaran_model->get_all(),
            'mitra' =>$this->Mitra_model->get_all(),
            'data_cicilan' =>$this->Sale_detail_model->get_by_id($invoice)
        );

        $this->template->load('template','cicilan/kartu_piutang', $fetched);
    }

    public function cetak_kartupiutang($id)
    {
        $pdf = new FPDF('P','mm','A4');
        $row = $this->Sale_model->get_kartupiutang_data($id);
        $bunga_cicilan = $this->Sale_model->get_bungapercicilan($id);
        $data_cicilan = $this->Sale_detail_model->get_by_id($id);
    
        $pdf->AddPage();

        $pdf->setxY(15, 10);$pdf->SetFont('Arial','B',16);$pdf->Cell(100,7,'KARTU PIUTANG',0,0,'L');

        $pdf->setXY(15, 35);
        $pdf->SetFont('Arial','B',11);
        $pdf->Cell(35,6,'Invoice',0,2,'L');
        $pdf->Cell(35,6,'Pelanggan',0,2,'L');
        $pdf->Cell(35,6,'Alamat',0,2,'L');
        $pdf->Cell(35,6,'Jenis Barang',0,2,'L');
        $pdf->Cell(35,6,'Merek',0,2,'L');
        $pdf->Cell(35,6,'Type',0,2,'L');
        $pdf->Cell(35,6,'No. BPKB',0,2,'L');
        $pdf->Cell(35,6,'Warna',0,2,'L');

        $pdf->setXY(40, 35);
        $pdf->SetFont('Arial','B',11);
        $pdf->Cell(35,6,':',0,2,'L');
        $pdf->Cell(35,6,':',0,2,'L');
        $pdf->Cell(35,6,':',0,2,'L');
        $pdf->Cell(35,6,':',0,2,'L');
        $pdf->Cell(35,6,':',0,2,'L');
        $pdf->Cell(35,6,':',0,2,'L');
        $pdf->Cell(35,6,':',0,2,'L');
        $pdf->Cell(35,6,':',0,2,'L');

        $pdf->setXY(45, 35);
        $pdf->SetFont('Arial','',11);

        $pdf->Cell(65,6,$row->invoice,0,2,'L');
        $pdf->Cell(65,6,$row->nama_pelanggan,0,2,'L');
        $pdf->Cell(65,6,$row->alamat_domisili,0,2,'L');
        $pdf->Cell(65,6,$row->nama_jenis_item,0,2,'L');
        $pdf->Cell(65,6,$row->nama_merek,0,2,'L');
        $pdf->Cell(65,6,$row->nama_type,0,2,'L');
        $pdf->Cell(65,6,$row->no_bpkb,0,2,'L');
        $pdf->Cell(65,6,$row->warna1.'/'.$row->warna2,0,2,'L');

        
        // SET X itu dari pojok kiri atas ke kanan
        // SET Y itu dari pojok kiri atas ke bawah
        // setXY() DUAA DUANYA
        
        $pdf->setXY(110, 35);
        $pdf->SetFont('Arial','B',11);
        $pdf->Cell(20,6,'Harga Nominal',0,2,'L');
        $pdf->Cell(20,6,'Pokok Kredit',0,2,'L');
        $pdf->Cell(20,6,'Angsuran/bulan',0,2,'L');
        $pdf->Cell(20,6,'Jangka Waktu',0,2,'L');
        $pdf->Cell(20,6,'Tanggal Pembayaran',0,2,'L');

        $pdf->setXY(150, 35);
        $pdf->Cell(20,6,':',0,2,'L');
        $pdf->Cell(20,6,':',0,2,'L');
        $pdf->Cell(20,6,':',0,2,'L');
        $pdf->Cell(20,6,':',0,2,'L');
        $pdf->Cell(20,6,':',0,2,'L');

        $pdf->setXY(155, 35);
        $pdf->SetFont('Arial','',11);
        $pdf->Cell(65,6,$row->total_price_sale,0,2,'L');
        $pdf->Cell(65,6,$bunga_cicilan->pokok_cicilan.' + '.$bunga_cicilan->nilai_bunga_percicilan.'%',0,2,'L');
        $pdf->Cell(65,6,$bunga_cicilan->harus_dibayar,0,2,'L');
        $pdf->Cell(65,6,$bunga_cicilan->brapaxcicilan.' Bulan',0,2,'L');
        $pdf->Cell(65,6,'Setiap tanggal '. $bunga_cicilan->tiap_tanggal,0,2,'L');
        

        $pdf->setXY(10, 90);
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(7,12,'No',1,0);
        $pdf->Cell(28,12,'Jatuh Tempo',1,0);
        $pdf->Cell(75,6,'Angsuran',1,0);
        $pdf->Cell(50,6,'Saldo Piutang',1,1);
        $pdf->setX(45);
        $pdf->Cell(25,6,'Nominal',1,0);
        $pdf->Cell(25,6,'Pokok',1,0);
        $pdf->Cell(25,6,'Bunga',1,0);
        $pdf->Cell(25,6,'Pokok',1,0);
        $pdf->Cell(25,6,'Bruto',1,0);
        $pdf->setXY(170, 90);
        $pdf->Cell(25,12,'Keterangan',1,1);

        $pdf->setXY(10, 102);
        $pdf->SetFont('Arial','',10);
        $pokok =  $data_cicilan[0]->pokok_cicilan * sizeof($data_cicilan);
        $bruto =  $data_cicilan[0]->harus_dibayar * sizeof($data_cicilan);

        $no = 1;
        foreach ($data_cicilan as $v) {
            
                $pdf->Cell(7,8, $no++, 1, 0);
                $pdf->Cell(28,8, date("d/m/Y", strtotime($v->jatuh_tempo)), 1, 0);
                $pdf->Cell(25,8, $v->harus_dibayar, 1, 0);
                $pdf->Cell(25,8, $v->pokok_cicilan, 1, 0);
                $pdf->Cell(25,8, $v->harus_dibayar - $v->pokok_cicilan, 1, 0);
                $pdf->Cell(25,8, $pokok -= $v->pokok_cicilan, 1, 0);
                $pdf->Cell(25,8, $bruto -= $v->harus_dibayar, 1, 0);
                $pdf->Cell(25,8, 'Bayar', 1,1);
        }

        $pdf->setXY(20, 260);
        $pdf->Cell(50,6,'(KASIR)',0,0,'C');
        $pdf->Cell(40,6,'(PENERIMA)',0,0,'R');
        $pdf->Output('kartupiutang'.$id.'.pdf', 'D');
    }

    function refresh_info_pembayaran()
    {
        $invoice = $this->input->post('idinvoice');
        $row = $this->Sale_model->get_by_invoice($invoice);

        $listcicilan = $this->Sale_detail_model->get_by_id($invoice);

        $sisapembayaran = $this->Sale_detail_model->count_sisa_pembayaran($invoice);

        $progresscicilan = $this->Sale_detail_model->get_progress_jumlah_cicilan($invoice);

        $sajidata = array(
            'invoice_id' => $invoice,
            'total_price_sale' => $row->total_price_sale,
            'biaya_admin' => $row->biaya_admin,
            'total_bayar' => $row->total_bayar,
            'dibayar' => $row->dibayar,
            'status_sale' => $row->status_sale,
            'last_updated' => $row->last_updated,
            'list_cicilan' => $listcicilan,

            'sisapembayaranbrapax' => $sisapembayaran,

            'progresscicilan' => $progresscicilan
        );
        $this->load->view('cicilan/info_pembayaran', $sajidata);
    }

}

/* End of file Sale_detail.php */
/* Location: ./application/controllers/Sale_detail.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-07-26 14:34:47 */
/* http://harviacode.com */