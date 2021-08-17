<?php

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
        }
        else
        {
            echo '  <div style="display: flex; flex-direction: column;margin-top: 17vh; text-align: center;">
                        <div><i class="fa fa-times" style="font-size: 65px"></i></div>
                        <h3 style="color: #9d9d9d;s">Data '.$invoice.' Tidak Ditemukan</h3>
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

        $approval_stage = $this->custom_authorization->addApprovalby($totaltransaksi);
        $data = array(
            'invoice_id' => $id,
            'approve_by' => $approval_stage,
            'approval_status' => 'Dalam Review',
            'keterangan' => $this->input->post('komentar',TRUE),
            'jenis_tindakan' => 'Pembayaran Kredit',
            'komentar' => '',
        );

        $this->Approval_lists_model->insert($data);

        $this->Sale_model->insert_data_cicilan($dataCicilan);

        $this->Sale_model->update_data_dibayar($id, $datatoupdate);



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

            'progresscicilan' => $progresscicilan
        );
        $this->load->view('cicilan/cicilan_inprogress', $sajidata);
    }

    public function show_cicilanfinalinfo($id) 
    {
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

        $lunaskah = 'belum';

        $statusbayarancicilan = '';

        $cek = $this->Sale_detail_model->get_data_cicilan($sale_detail_id);

        if ($total_bayar) {
            if(intval($total_bayar) == intval($cek->harus_dibayar))
            {
                $statusbayarancicilan = 'dibayar';
                $label = '<button type="button" class="btn btn-success btn-xs">Lunas</button>';
            }

            if(intval($total_bayar) < intval($cek->harus_dibayar)) {
                $statusbayarancicilan = 'siap dibayar';    
                $label = '<button type="button" class="btn btn-warning btn-xs">Pembayaran Kurang (dibayar = '.$total_bayar.')</button>';
            }

            if(intval($total_bayar) > intval($cek->harus_dibayar)) {
                $statusbayarancicilan = 'dibayar';
                $label = '<button type="button" class="btn btn-secondary btn-xs">Pembayaran Berlebih (dibayar = '.$total_bayar.')</button>';
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


        $cekstatuslunas = $this->Sale_detail_model->cekstatuslunas($invoice_id);

        $denda = false;

        $datatunggakan = 'tidak ada';

        if ($cekstatuslunas->telah_bayar == $cekstatuslunas->total_bayar) {

            // memang bayar pas, tapi apakah kamu telat bayarnya?
            $jatuhtempo = new DateTime($cek->jatuh_tempo);
            $later = new DateTime();
            $abs_diff = $later->diff($jatuhtempo)->format("%r%a");
            if ($abs_diff < 0) {
                //check
                $cekdenda = $this->Denda_model->get_by_id($sale_detail_id);

                if ($cekdenda) {
                    $datatunggakan = array(
                        'sale_detail_id' => $cekdenda->sale_detail_id,
                        'jumlah_telat_hari' => $cekdenda->jumlah_telat_hari,
                        'jumlah_denda' => $cekdenda->jumlah_denda,
                        'status' => $cekdenda->status
                    );
                }

                if (!$cekdenda) {
                    $datatunggakan = array(
                        'sale_detail_id' => $sale_detail_id,
                        'jumlah_telat_hari' => abs($abs_diff),
                        'jumlah_denda' => (0.05 * intval($cek->harus_dibayar)) * abs($abs_diff),
                        'status' => 'belum dibayar'
                    );
                    $this->Denda_model->insert($datatunggakan);
                }
                $denda = true;
            }


            $lunaskah = 'Lunas';
            $datatoupdate = array(
                'status_sale' => 'Selesai',
            );

            $this->Sale_model->update_data_dibayar($invoice_id, $datatoupdate);

        } else {
            $datatoupdate = array(
                'status_sale' => 'Dalam Cicilan',
            );

            $this->Sale_model->update_data_dibayar($invoice_id, $datatoupdate);            
        }

        $test = 'no';

        if ($statusbayarancicilan == 'dibayar') {
            $test = $this->updateNextCicilan($invoice_id);
        }
        $datatoechoed = array(
            'tglinput' => $tglinput,
            'penginput' => $penginput,
            'label' => $label,
            'lunaskah' => $lunaskah,
            'statusbayarcicilanini' => $statusbayarancicilan,
            'denda' => $denda,
            'datatunggakan' => $datatunggakan,
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
            'sisapembayaranbrapax' => $sisapembayaran
        );
        
        $this->load->view('cicilan/cicilan_table', $arr);
        
    }

    // stil failed

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

}

/* End of file Sale_detail.php */
/* Location: ./application/controllers/Sale_detail.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-07-26 14:34:47 */
/* http://harviacode.com */