<?php

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lap_salesref extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Jenis_item_model');
        $this->load->model('Laporan_model');
        $this->load->model('Sale_model');
        $this->load->model('Mitra_model');
        $this->load->model('Karyawan_model');
        $this->load->model('History_pembayaran_model');
        $this->load->model('Kategori_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        is_allowed($this->uri->segment(1),null);

        $data['mitrasaleslist'] = $this->Mitra_model->get_all();
        $data['karyawanlist'] = $this->Karyawan_model->get_all();

        $this->template->load('template','laporan/sales_ref', $data);
    }

    public function fetch_tabel_salesref()
    {
        $from = $this->input->post('fromDate');
        $to = $this->input->post('toDate');
        $allunit = $this->input->post('allunit');

        $selectsalesreferral = $this->input->post('selectsalesreferral');

        $namasalesreferral = '';
        $jenissalesreferral = '';

        if (strlen($selectsalesreferral) > 2) {
        	$pisah = explode('-', $selectsalesreferral);

	        $namasalesreferral = $pisah[1];
	        $jenissalesreferral = $pisah[0];
        }

        if ($allunit == 'true') {
            $data['lists_data'] = $this->Laporan_model->getallSalesRefDatawithDate($from, $to);
            $data['fromDate'] = $from;
            $data['toDate'] = $to;
            $data['allunit'] = $allunit;
            $data['classnyak'] = $this;
            $this->load->view('laporan/tabel_penjualan', $data);
        }
        else
        {
            $data['lists_data'] = $this->Laporan_model->getallSalesRefDatawithDate(
                $from,
                $to,
                $this->session->userdata('unit_id'),
                $namasalesreferral,
                $jenissalesreferral
            );
            $data['fromDate'] = $from;
            $data['toDate'] = $to;
            $data['allunit'] = $allunit;
            $data['classnyak'] = $this;

            $data['namasalesreferral'] = $namasalesreferral;
            $data['jenissalesreferral'] = $jenissalesreferral;


            $this->load->view('laporan/tabel_salesref', $data);
        }
    }

    public function excel()
    {
        $dateFrom = $this->input->get('from');
        $dateTo = $this->input->get('to');

        $namasalesreferral = $this->input->get('namasalesreferral');
        $jenissalesreferral = $this->input->get('jenissalesreferral');

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->mergeCells('A1:A2'); 
        $sheet->mergeCells('B1:C1');
        $sheet->mergeCells('D1:F1');
        $sheet->mergeCells('G1:G2');
        $sheet->mergeCells('H1:I1');
        $sheet->mergeCells('J1:J2');
        $sheet->mergeCells('K1:K2');
        $sheet->mergeCells('L1:L1');
        $sheet->mergeCells('M1:M2');
        

        $sheet->setCellValue('A1','No');
        $sheet->setCellValue('B1','Customer');
        $sheet->setCellValue('B2','Nama');
        $sheet->setCellValue('C2','ID');
        $sheet->setCellValue('D1','Sales Ref');
        $sheet->setCellValue('D2','Nama');
        $sheet->setCellValue('E2','ID');
        $sheet->setCellValue('F2','Kategori');
        $sheet->setCellValue('G1','Invoice');
        $sheet->setCellValue('H1','Waktu');
        $sheet->setCellValue('H2','Tanggal');
        $sheet->setCellValue('I2','Jam');
        $sheet->setCellValue('J2','Sales Pokok');
        $sheet->setCellValue('K1','Bunga Angsuran');
        $sheet->setCellValue('L1','Harga Nominal');
        $sheet->setCellValue('M1','Durasi Cicil');
        

        
        $nourut = 1;
        $baris = 3;
        foreach($this->Laporan_model->getallSalesRefDatawithDate(
                $dateFrom,
                $dateTo,
                $this->session->userdata('unit_id'),
                $namasalesreferral,
                $jenissalesreferral
            ) as $data)
        {
            
            $sheet->setCellValue('A'.$baris, $nourut++);
			$sheet->setCellValue('B'.$baris, $data->nama_pelanggan);
			$sheet->setCellValue('C'.$baris, $data->pelanggan_id);

			if ($data->sales_referral == 'Mitra Sales') {
				$sheet->setCellValue('D'.$baris, $this->getNamaMitra($data->contact_id)->nama_mitra);
			} 
			else if($data->sales_referral == 'Karyawan')
			{
					$sheet->setCellValue('D'.$baris, $this->getNamaKaryawan($data->contact_id)->nama_karyawan);
			}
			else
			{
					$sheet->setCellValue('D'.$baris, '-');
			}
			$sheet->setCellValue('E'.$baris, $data->contact_id);
			$sheet->setCellValue('F'.$baris, $data->sales_referral);
			$sheet->setCellValue('G'.$baris, $data->invoice);
			$sheet->setCellValue('H'.$baris, $data->tanggal_sale);
			$sheet->setCellValue('I'.$baris, $data->tanggal_sale);
			$sheet->setCellValue('J'.$baris, $data->total_price_sale);
			$sheet->setCellValue('K'.$baris, (intval($data->total_bayar) - intval($data->harga_pokok)));

			$sheet->setCellValue('L'.$baris, $data->total_bayar);
			$sheet->setCellValue('M'.$baris, $this->Sale_model->get_bungapercicilan($data->invoice)->brapaxcicilan);

            $baris++;
        }

        
        $writer = new Xlsx($spreadsheet);
        $filename = 'sales-ref-report';
        
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    function getNamaMitra($id)
    {
    	$data = $this->Mitra_model->get_by_id($id);
    	return $data;
    }

    function getNamaKaryawan($id)
    {
    	$data = $this->Karyawan_model->get_by_id($id);
    	return $data;
    }

}

/* End of file Jenis_item.php */
/* Location: ./application/controllers/Jenis_item.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-07-01 08:38:23 */
/* http://harviacode.com */
