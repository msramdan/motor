<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sale extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Sale_model');
        $this->load->model('Kendaraan_model');
        $this->load->model('Pelanggan_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->uri->segment(3));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . '.php/c_url/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'index.php/sale/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'index.php/sale/index/';
            $config['first_url'] = base_url() . 'index.php/sale/index/';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = FALSE;
        $config['total_rows'] = $this->Sale_model->total_rows($q);
        $sale = $this->Sale_model->get_limit_data($config['per_page'], $start, $q);
        $config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin pull-right">';
        $config['full_tag_close'] = '</ul>';
        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'sale_data' => $sale,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->template->load('template','sale/sale_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Sale_model->get_by_id($id);
        if ($row) {
            $data = array(
		'sale_id' => $row->sale_id,
		'invoice' => $row->invoice,
		'pelanggan_id' => $row->pelanggan_id,
		'kendaraan_id' => $row->kendaraan_id,
		'total_price_sale' => $row->total_price_sale,
		'type_sale' => $row->type_sale,
		'tanggal_sale' => $row->tanggal_sale,
		'user_id' => $row->user_id,
	    );
            $this->template->load('template','sale/sale_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('sale'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'pelanggan' =>$this->Pelanggan_model->get_all(),
            'kendaraan' =>$this->Kendaraan_model->get_all(),
            'action' => site_url('sale/create_action'),
	    'sale_id' => set_value('sale_id'),
	    'invoice' => set_value('invoice'),
	    'pelanggan_id' => set_value('pelanggan_id'),
	    'kendaraan_id' => set_value('kendaraan_id'),
	    'total_price_sale' => set_value('total_price_sale'),
	    'type_sale' => set_value('type_sale'),
	    'tanggal_sale' => set_value('tanggal_sale'),
	    'user_id' => set_value('user_id'),
	);
        $this->template->load('template','sale/sale_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'invoice' => $this->input->post('invoice',TRUE),
		'pelanggan_id' => $this->input->post('pelanggan_id',TRUE),
		'kendaraan_id' => $this->input->post('kendaraan_id',TRUE),
		'total_price_sale' => $this->input->post('total_price_sale',TRUE),
		'type_sale' => $this->input->post('type_sale',TRUE),
		'tanggal_sale' => $this->input->post('tanggal_sale',TRUE),
		'user_id' => $this->input->post('user_id',TRUE),
	    );

            $this->Sale_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success 2');
            redirect(site_url('sale'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Sale_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('sale/update_action'),
		'sale_id' => set_value('sale_id', $row->sale_id),
		'invoice' => set_value('invoice', $row->invoice),
		'pelanggan_id' => set_value('pelanggan_id', $row->pelanggan_id),
		'kendaraan_id' => set_value('kendaraan_id', $row->kendaraan_id),
		'total_price_sale' => set_value('total_price_sale', $row->total_price_sale),
		'type_sale' => set_value('type_sale', $row->type_sale),
		'tanggal_sale' => set_value('tanggal_sale', $row->tanggal_sale),
		'user_id' => set_value('user_id', $row->user_id),
	    );
            $this->template->load('template','sale/sale_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('sale'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('sale_id', TRUE));
        } else {
            $data = array(
		'invoice' => $this->input->post('invoice',TRUE),
		'pelanggan_id' => $this->input->post('pelanggan_id',TRUE),
		'kendaraan_id' => $this->input->post('kendaraan_id',TRUE),
		'total_price_sale' => $this->input->post('total_price_sale',TRUE),
		'type_sale' => $this->input->post('type_sale',TRUE),
		'tanggal_sale' => $this->input->post('tanggal_sale',TRUE),
		'user_id' => $this->input->post('user_id',TRUE),
	    );

            $this->Sale_model->update($this->input->post('sale_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('sale'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Sale_model->get_by_id($id);

        if ($row) {
            $this->Sale_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('sale'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('sale'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('invoice', 'invoice', 'trim|required');
	$this->form_validation->set_rules('pelanggan_id', 'pelanggan id', 'trim|required');
	$this->form_validation->set_rules('kendaraan_id', 'kendaraan id', 'trim|required');
	$this->form_validation->set_rules('total_price_sale', 'total price sale', 'trim|required');
	$this->form_validation->set_rules('type_sale', 'type sale', 'trim|required');
	$this->form_validation->set_rules('tanggal_sale', 'tanggal sale', 'trim|required');
	$this->form_validation->set_rules('user_id', 'user id', 'trim|required');

	$this->form_validation->set_rules('sale_id', 'sale_id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "sale.xls";
        $judul = "sale";
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
	xlsWriteLabel($tablehead, $kolomhead++, "Invoice");
	xlsWriteLabel($tablehead, $kolomhead++, "Pelanggan Id");
	xlsWriteLabel($tablehead, $kolomhead++, "Kendaraan Id");
	xlsWriteLabel($tablehead, $kolomhead++, "Total Price Sale");
	xlsWriteLabel($tablehead, $kolomhead++, "Type Sale");
	xlsWriteLabel($tablehead, $kolomhead++, "Tanggal Sale");
	xlsWriteLabel($tablehead, $kolomhead++, "User Id");

	foreach ($this->Sale_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->invoice);
	    xlsWriteNumber($tablebody, $kolombody++, $data->pelanggan_id);
	    xlsWriteNumber($tablebody, $kolombody++, $data->kendaraan_id);
	    xlsWriteNumber($tablebody, $kolombody++, $data->total_price_sale);
	    xlsWriteLabel($tablebody, $kolombody++, $data->type_sale);
	    xlsWriteLabel($tablebody, $kolombody++, $data->tanggal_sale);
	    xlsWriteNumber($tablebody, $kolombody++, $data->user_id);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=sale.doc");

        $data = array(
            'sale_data' => $this->Sale_model->get_all(),
            'start' => 0
        );
        
        $this->load->view('sale/sale_doc',$data);
    }

}

/* End of file Sale.php */
/* Location: ./application/controllers/Sale.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-07-03 11:10:29 */
/* http://harviacode.com */