<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Approval_lists extends CI_Controller
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

    public function index()
    {
        is_allowed($this->uri->segment(1),null);
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->uri->segment(3));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . '.php/c_url/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'index.php/approval_lists/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'index.php/approval_lists/index/';
            $config['first_url'] = base_url() . 'index.php/approval_lists/index/';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = FALSE;
        $config['total_rows'] = $this->Approval_lists_model->total_rows($q);
        $approval_lists = $this->Approval_lists_model->get_limit_data($config['per_page'], $start, $q);
        $config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin pull-right">';
        $config['full_tag_close'] = '</ul>';
        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'approval_lists_data' => $approval_lists,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'menu_accessed' => $this->uri->segment(1),
        );
        $this->template->load('template','approval_lists/approval_lists_list', $data);
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('approval_lists/create_action'),
    	    'approval_id' => set_value('approval_id'),
    	    'invoice_id' => set_value('invoice_id'),
    	    'approve_by' => set_value('approve_by'),
    	    'approval_status' => set_value('approval_status'),
    	    'keterangan' => set_value('keterangan'),
    	    'komentar' => set_value('komentar'),
    	);
        $this->template->load('template','approval_lists/approval_lists_form', $data);
    }
    
    // public function create_action() 
    // {
    //     $this->_rules();

    //     if ($this->form_validation->run() == FALSE) {
    //         $this->create();
    //     } else {
    //         $data = array(
    //     		'invoice_id' => $this->input->post('invoice_id',TRUE),
    //     		'approve_by' => $this->input->post('approve_by',TRUE),
    //     		'approval_status' => $this->input->post('approval_status',TRUE),
    //     		'keterangan' => $this->input->post('keterangan',TRUE),
    //     		'komentar' => $this->input->post('komentar',TRUE),
    //         );

    //         $this->Approval_lists_model->insert($data);
    //         $this->session->set_flashdata('message', 'Create Record Success');
    //         redirect(site_url('approval_lists'));
    //     }
    // }
    
    public function update($id) 
    {
        $row = $this->Approval_lists_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('approval_lists/update_action'),
		'approval_id' => set_value('approval_id', $row->approval_id),
		'invoice_id' => set_value('invoice_id', $row->invoice_id),
		'approve_by' => set_value('approve_by', $row->approve_by),
		'approval_status' => set_value('approval_status', $row->approval_status),
		'keterangan' => set_value('keterangan', $row->keterangan),
		'komentar' => set_value('komentar', $row->komentar),
	    );
            $this->template->load('template','approval_lists/approval_lists_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('approval_lists'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('approval_id', TRUE));
        } else {
            $data = array(
		'invoice_id' => $this->input->post('invoice_id',TRUE),
		'approve_by' => $this->input->post('approve_by',TRUE),
		'approval_status' => $this->input->post('approval_status',TRUE),
		'keterangan' => $this->input->post('keterangan',TRUE),
		'komentar' => $this->input->post('komentar',TRUE),
	    );

            $this->Approval_lists_model->update($this->input->post('approval_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('approval_lists'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Approval_lists_model->get_by_id($id);

        if ($row) {
            $this->Approval_lists_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('approval_lists'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('approval_lists'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('invoice_id', 'invoice id', 'trim|required');
	$this->form_validation->set_rules('approve_by', 'approve by', 'trim|required');
	$this->form_validation->set_rules('approval_status', 'approval status', 'trim|required');
	$this->form_validation->set_rules('keterangan', 'keterangan', 'trim|required');
	$this->form_validation->set_rules('komentar', 'komentar', 'trim|required');

	$this->form_validation->set_rules('approval_id', 'approval_id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "approval_lists.xls";
        $judul = "approval_lists";
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
	xlsWriteLabel($tablehead, $kolomhead++, "Invoice Id");
	xlsWriteLabel($tablehead, $kolomhead++, "Approve By");
	xlsWriteLabel($tablehead, $kolomhead++, "Approval Status");
	xlsWriteLabel($tablehead, $kolomhead++, "Keterangan");
	xlsWriteLabel($tablehead, $kolomhead++, "Komentar");

	foreach ($this->Approval_lists_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->invoice_id);
	    xlsWriteLabel($tablebody, $kolombody++, $data->approve_by);
	    xlsWriteLabel($tablebody, $kolombody++, $data->approval_status);
	    xlsWriteLabel($tablebody, $kolombody++, $data->keterangan);
	    xlsWriteLabel($tablebody, $kolombody++, $data->komentar);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=approval_lists.doc");

        $data = array(
            'approval_lists_data' => $this->Approval_lists_model->get_all(),
            'start' => 0
        );
        
        $this->load->view('approval_lists/approval_lists_doc',$data);
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

        if ($row->type_sale === 'Kredit') {
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
                'data_cicilan' =>$this->Sale_detail_model->get_all_by_id($id),
                'berkas' => $this->Pelanggan_model->get_berkas($row->pelanggan_id)
            );

            $this->template->load('template','approval_lists/approval_cicilan', $fetched);
        }
        else
        {
            $this->template->load('template','approval_lists/test');
        }
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

/* End of file Approval_lists.php */
/* Location: ./application/controllers/Approval_lists.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-08-14 14:49:50 */
/* http://harviacode.com */