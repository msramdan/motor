<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Approval_cicilan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Sale_model');
        $this->load->model('karyawan_model');
        $this->load->model('Mitra_model');
        $this->load->model('Item_model');
        $this->load->model('Pelanggan_model');
        $this->load->model('Dashboard_model');
        $this->load->model('Jenis_pembayaran_model');
        $this->load->model('Sale_detail_model');
        $this->load->model('Approval_lists_model');
        $this->load->library('form_validation');
        $this->load->library('pdf');
    }

    public function index($value='')
    {
        echo 'Not Available';
    }

    public function read($id) 
    {
        // $invoice = $this->input->get($id);
        if ($id === 'yes') {
            $this->yes();
        }
        if ($id === 'no') {
            $this->no();
        }

        $row = $this->Sale_model->get_detail_pengajuancicilan($id);

        $getlevelname = $this->fungsi->user_login()->nama_level;

        $this->load->library('Custom_authorization');
        $letscheck = $this->custom_authorization->apaAkuSudahApprove($getlevelname,$id);

        $fetched = array(
            'admin_fee' => $this->Dashboard_model->admin_fee(),
            'sale_id' => $row->sale_id,
            'invoice' => $row->invoice,
            'bunga_cicilan' => $this->Sale_model->get_bungapercicilan($id),
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
            'approval' => $row->approve_by,
            'nama_user' => $row->nama_user,
            'username' => $row->username,
            'nama_type' => $row->nama_type,
            'nama_merek' => $row->nama_merek,
            'level_id' => $row->level_id,
            'result' => $letscheck,
            'catatan' => $row->keterangan,
            'nama_level' => $row->nama_level,
            'admin_fee' => $this->Dashboard_model->admin_fee(),
            'karyawan' =>$this->karyawan_model->get_all(),
            'jenis_pembayaran' =>$this->Jenis_pembayaran_model->get_all(),
            'mitra' =>$this->Mitra_model->get_all(),
            'data_cicilan' =>$this->Sale_detail_model->get_by_id($id)
        );

        $this->template->load('template','sale/approval_cicilan_read', $fetched);
    }

    public function yes() {

        // init authorization
        $invoice = $this->input->post('invoicehidden');
        $approvalby = $this->session->userdata('level_id');

        $datarequired = array(
            'invoice' => $invoice,
            'approvestatus' => 'true'
        );

        // RUNNING check based on documentation said
        $this->load->library('Custom_authorization');
        $customAuthorizationCheck = $this->custom_authorization->authorization_scheme('1', $approvalby, $datarequired);

        $datatoupdate;

        if ($customAuthorizationCheck) {
            if ($customAuthorizationCheck === 'cicilanApproved') {
                $datatoupdate = array(
                    'status_sale' => 'Dalam Cicilan'
                );

                $this->Sale_model->update_data_dibayar($invoice, $datatoupdate);

                $checkdata = $this->Sale_model->get_by_invoice($invoice);
                $statustoupdate = array(
                    'status' => 'Terjual'
                );
                $this->Item_model->update($checkdata->item_id, $statustoupdate);
            }
            if ($customAuthorizationCheck === 'cicilanDisapproved') {
                $datatoupdate = array(
                    'status_sale' => 'Ditolak'
                );

                $dataapprovaltoupdate = array(
                    'approval_status' => 'Ditolak',
                    'komentar' => $this->input->post('komentar')
                );

                $this->Approval_lists_model->update($invoice, $dataapprovaltoupdate);

                $this->Sale_model->update_data_dibayar($invoice, $datatoupdate);

                $checkdata = $this->Sale_model->get_by_invoice($invoice);
                $statustoupdate = array(
                    'status' => 'Ready'
                );
                $this->Item_model->update($checkdata->item_id, $statustoupdate);
            }

            if ($customAuthorizationCheck === 'alreadyapprove') {
                echo 'Sudah memutuskan';
            }

            if ($customAuthorizationCheck === 'belumlengkap') {
                $datatoupdate = array(
                    'status_sale' => 'Dalam Review',
                    'approval_stage' => $customAuthorizationCheck
                );

                $this->Sale_model->update_data_dibayar($invoice, $datatoupdate);
            }
        }

        $this->session->set_flashdata('message', 'Data berhasil diupdate');
        redirect(site_url('Approval_cicilan'));
        
    }

    public function no() {

        // init authorization
        $invoice = $this->input->post('invoicehidden');
        $approvalby = $this->session->userdata('level_id');

        $datarequired = array(
            'invoice' => $invoice,
            'approvestatus' => 'false'
        );

        // RUNNING check based on documentation said
        $this->load->library('Custom_authorization');
        $customAuthorizationCheck = $this->custom_authorization->authorization_scheme('1', $approvalby, $datarequired);

        $datatoupdate;

        if ($customAuthorizationCheck) {
            if ($customAuthorizationCheck['status'] === 'cicilanApproved') {
                $datatoupdate = array(
                    'status_sale' => 'Dalam Cicilan'
                );

                $this->Sale_model->update_data_dibayar($invoice, $datatoupdate);

                $checkdata = $this->Sale_model->get_by_invoice($invoice);
                $statustoupdate = array(
                    'status' => 'Terjual'
                );

                $dataapprovaltoupdate = array(
                    'approval_status' => 'Diterima',
                    'approve_by' => $customAuthorizationCheck['dataapprovalupdate'],
                    'komentar' => $this->input->post('komentar')
                );

                $this->Approval_lists_model->update($invoice, $dataapprovaltoupdate);
                $this->Item_model->update($checkdata->item_id, $statustoupdate);
            }
            if ($customAuthorizationCheck['status'] === 'Cicilandisapproved') {
                $datatoupdate = array(
                    'status_sale' => 'Ditolak'
                );

                $dataapprovaltoupdate = array(
                    'approval_status' => 'Ditolak',
                    'approve_by' => $customAuthorizationCheck['dataapprovalupdate'],
                    'komentar' => $this->input->post('komentar')
                );

                $this->Approval_lists_model->update($invoice, $dataapprovaltoupdate);

                $this->Sale_model->update_data_dibayar($invoice, $datatoupdate);

                $checkdata = $this->Sale_model->get_by_invoice($invoice);
                $statustoupdate = array(
                    'status' => 'Ready'
                );
                $this->Item_model->update($checkdata->item_id, $statustoupdate);
            }

            if ($customAuthorizationCheck['status'] === 'alreadyapprove') {
                echo 'Sudah memutuskan';
            }

            if ($customAuthorizationCheck['status'] === 'belumlengkap') {
                $datatoupdate = array(
                    'status_sale' => 'Dalam Review'
                );

                $dataapprovaltoupdate = array(
                    'approve_by' => $customAuthorizationCheck['dataapprovalupdate'],
                    'komentar' => $this->input->post('komentar')
                );

                $this->Approval_lists_model->update($invoice, $dataapprovaltoupdate);

                $this->Sale_model->update_data_dibayar($invoice, $datatoupdate);
            }
        }

        $this->session->set_flashdata('message', 'Data berhasil diupdate');
        redirect(site_url('approval_lists'));
        
    }
}

/* End of file Sale_detail.php */
/* Location: ./application/controllers/Sale_detail.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-07-26 14:34:47 */
/* http://harviacode.com */