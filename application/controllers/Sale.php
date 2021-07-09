<?php

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sale extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Sale_model');
        $this->load->model('Item_model');
        $this->load->model('Pelanggan_model');
        $this->load->library('form_validation');
        $this->load->library('pdf');
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
                'biaya_admin' => $row->biaya_admin,
                'invoice' => $row->invoice,
                'pelanggan_id' => $row->nama_pelanggan,
                'item_id' => $row->nama_item,
                'total_price_sale' => $row->total_price_sale,
                'type_sale' => $row->type_sale,
                'tanggal_sale' => $row->tanggal_sale,
                'user_id' => $row->nama_user,
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
            'item' =>$this->Item_model->get_all('Ready'),
            'kodeunik' =>$this->Sale_model->buat_kode(),
            'action' => site_url('sale/create_action'),
            'sale_id' => set_value('sale_id'),
            'invoice' => set_value('invoice'),
            'biaya_admin' => set_value('biaya_admin'),
            'pelanggan_id' => set_value('pelanggan_id'),
            'item_id' => set_value('item_id'),
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
        'biaya_admin' => $this->input->post('biaya_admin',TRUE),
        'jenis_bayar' => $this->input->post('jenis_pembayaran',TRUE),
		'pelanggan_id' => $this->input->post('pelanggan_id',TRUE),
		'item_id' => $this->input->post('item_id',TRUE),
		'total_price_sale' => $this->input->post('total_price_sale',TRUE),
		'type_sale' => $this->input->post('type_sale',TRUE),
		'tanggal_sale' => $this->input->post('tanggal_sale',TRUE),
		'user_id' => $this->input->post('user_id',TRUE),
	    );

            $this->Sale_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
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
		'item_id' => set_value('item_id', $row->item_id),
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
		'item_id' => $this->input->post('item_id',TRUE),
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
	$this->form_validation->set_rules('item_id', 'item id', 'trim|required');
	$this->form_validation->set_rules('total_price_sale', 'total price sale', 'trim|required');
	$this->form_validation->set_rules('type_sale', 'type sale', 'trim|required');
	$this->form_validation->set_rules('tanggal_sale', 'tanggal sale', 'trim|required');
	$this->form_validation->set_rules('user_id', 'user id', 'trim|required');

	$this->form_validation->set_rules('sale_id', 'sale_id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        /*$sheet->mergeCells('A1:A2'); // No
        $sheet->mergeCells('B1:B2'); //invoice
        $sheet->mergeCells('C1:E1'); //item
        $sheet->mergeCells('F1:F2'); //kategori
        $sheet->mergeCells('G1:G2'); //jenis item
        $sheet->mergeCells('H1:H2'); //nama pelanggan
        $sheet->mergeCells('I1:I2'); //id pelanggan
        $sheet->mergeCells('J1:J2'); //id pembelian
        $sheet->mergeCells('K1:L1'); //waktu (meliputi tanggal dan jam)
        $sheet->mergeCells('M1:M2'); //Harga beli pokok
        $sheet->mergeCells('N1:S1'); //Haarga (meliputi perolehan, rekondisi, stnk, komisi, admin, lainnya)
        $sheet->mergeCells('T1:T2'); //User
        
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Invoice');
        $sheet->setCellValue('C1', 'Item');
        $sheet->setCellValue('C2', 'Merek');
        $sheet->setCellValue('D2', 'Type');
        $sheet->setCellValue('E2', 'Nopol');
        $sheet->setCellValue('F1', 'Kategori');
        $sheet->setCellValue('G1', 'Jenis');
        $sheet->setCellValue('H1', 'Nama Pelanggan');
        $sheet->setCellValue('I1', 'ID Pelanggan');
        $sheet->setCellValue('J1', 'ID Pembelian');
        $sheet->setCellValue('K1', 'Waktu');
        $sheet->setCellValue('K2', 'Tanggal');
        $sheet->setCellValue('L2', 'Jam');
        $sheet->setCellValue('M1', 'Harga Beli Pokok');
        $sheet->setCellValue('N1', 'Harga');
        $sheet->setCellValue('N2', 'Perolehan');
        $sheet->setCellValue('O2', 'Rekondisi');
        $sheet->setCellValue('P2', 'STNK');
        $sheet->setCellValue('Q2', 'Komisi');
        $sheet->setCellValue('R2', 'Admin');
        $sheet->setCellValue('S2', 'Lainnya');
        $sheet->setCellValue('T1', 'User');*/

        $sheet->mergeCells('A1:A2'); // No
        $sheet->mergeCells('B1:B2'); //invoice
        $sheet->mergeCells('C1:C2'); //id pelanggan
        $sheet->mergeCells('D1:D2'); //Nama pelanggan
        $sheet->mergeCells('E1:F1'); //item (meliputi merek dan type)
        $sheet->mergeCells('G1:G2'); //TOTAL PRICE Sale
        $sheet->mergeCells('H1:H2'); //Type sale
        $sheet->mergeCells('I1:I2'); //TANGGAL Sale
        $sheet->mergeCells('J1:J2'); //USER

        $sheet->setCellVAlue('A1','No');
        $sheet->setCellVAlue('B1','Invoice');
        $sheet->setCellVAlue('C1','ID Pelanggan');
        $sheet->setCellVAlue('D1','Nama Pelanggan');
        $sheet->setCellVAlue('E1','item');
        $sheet->setCellVAlue('E2','Merek');
        $sheet->setCellVAlue('F2','Type');
        $sheet->setCellVAlue('G1','Total Price Sale');
        $sheet->setCellVAlue('H1','Type Sale');
        $sheet->setCellVAlue('I1','Tanggal Sale');
        $sheet->setCellVAlue('J1','User');
        
        $nourut = 1;
        $baris = 3;
        foreach($this->Sale_model->get_all() as $data)
        {
            
            $sheet->setCellValue('A'.$baris, $nourut++);
            $sheet->setCellValue('B'.$baris, $data->invoice);
            $sheet->setCellValue('C'.$baris, $data->pelanggan_id);
            $sheet->setCellValue('D'.$baris, $data->nama_pelanggan);
            $sheet->setCellValue('E'.$baris, $data->nama_merek);
            $sheet->setCellValue('F'.$baris, $data->nama_type);
            $sheet->setCellValue('G'.$baris, $data->total_price_sale);
            $sheet->setCellValue('H'.$baris, $data->type_sale);
            $sheet->setCellValue('I'.$baris, $data->tanggal_sale);
            $sheet->setCellValue('J'.$baris, $data->nama_user);
            $baris++;
        }

        
        $writer = new Xlsx($spreadsheet);
        $filename = 'sale-report';
        
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function cetak_faktur($id) {
        $pdf = new FPDF('l','mm','A5');
        $data = $this->Sale_model->get_by_id($id);
    
        $pdf->AddPage();

        $pdf->setxY(15, 10);$pdf->SetFont('Arial','B',16);$pdf->Cell(100,7,'FAKTUR PENJUALAAN',0,0,'L');

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
        $pdf->Cell(50,6,': '.$data->tanggal_sale,0,2,'L');
        $pdf->Cell(50,6,': 1',0,2,'L');
        

        $pdf->setXY(10, 70);
        $pdf->SetFont('Arial','B',9);
        $pdf->Cell(7,6,'No',1,0);
        $pdf->Cell(85,6,'Item',1,0);
        $pdf->Cell(25,6,'Qty',1,0);
        $pdf->Cell(25,6,'Harga',1,0);
        $pdf->Cell(25,6,'Jumlah',1,1);
        
        $pdf->SetFont('Arial','',9);
        $pdf->Cell(7,25,'1',1,0);
        $pdf->Cell(85,25,$data->nama_item,1,0);
        $pdf->Cell(25,25,'1',1,0);
        $pdf->Cell(25,25,$data->harga_beli,1,0);
        $pdf->Cell(25,25,floatval($data->harga_beli) * 1,1,0); //harga beli dikali 1
        $pdf->setXY(127, 101);
        $pdf->Cell(25,6,'Biaya Admin',0,0);
        $pdf->Cell(25,6,$data->biaya_admin,1,0);
        $pdf->setXY(127, 107);
        $pdf->Cell(25,6,'Grand Total',0,0);
        $pdf->Cell(25,6,$data->total_price_sale,1,0);


        $pdf->setXY(20, 120);
        $pdf->Cell(50,6,'(KASIR)',0,0,'C');
        $pdf->Cell(40,6,'(PENERIMA)',0,0,'R');
        $pdf->Output('result.pdf', 'D');
    }

}

/* End of file Sale.php */
/* Location: ./application/controllers/Sale.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-07-03 11:10:29 */
/* http://harviacode.com */