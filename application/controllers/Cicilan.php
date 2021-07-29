<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cicilan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Sale_detail_model');
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
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('sale_detail_id', TRUE));
        } else {
            $data = array(
        		'sale_id' => $this->input->post('sale_id',TRUE),
        		'pembayaran_ke' => $this->input->post('pembayaran_ke',TRUE),
        		'status' => $this->input->post('status',TRUE),
        		'total_bayar' => $this->input->post('total_bayar',TRUE),
        		'jatuh_tempo' => $this->input->post('jatuh_tempo',TRUE),
            );

            $this->Sale_detail_model->update($this->input->post('sale_detail_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('cicilan'));
        }
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