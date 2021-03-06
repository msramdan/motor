<?php

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lap_pembayaran extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Jenis_item_model');
        $this->load->model('Laporan_model');
        $this->load->model('Sale_model');
        $this->load->model('History_pembayaran_model');
        $this->load->model('Kategori_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        is_allowed($this->uri->segment(1),null);
        $data['kategori'] = $this->Kategori_model->get_all();
        $this->template->load('template','laporan/pembayaran', $data);
    }

    public function fetch_tabel_pembayaran()
    {
        $from = $this->input->post('fromDate');
        $to = $this->input->post('toDate');
        $allunit = $this->input->post('allunit');

        $idpenjualan = $this->input->post('idpenjualan');
        $namapelanggan = $this->input->post('namapelanggan');

        $selectkategori = $this->input->post('selectkategori');
        $selectobjek = $this->input->post('selectobjek');

        if ($allunit == 'true') {
            $data['lists_data'] = $this->Laporan_model->getallPaymentDatawithDate($from, $to);
            $data['fromDate'] = $from;
            $data['toDate'] = $to;
            $data['allunit'] = $allunit;
            $data['classnyak'] = $this;
            $this->load->view('laporan/tabel_pembayaran', $data);
        }
        else
        {
            $data['lists_data'] = $this->Laporan_model->getallPaymentDatawithDate(
                $from,
                $to,
                $this->session->userdata('unit_id'),
                $idpenjualan,
                $namapelanggan,
                $selectkategori,
                $selectobjek
            );
            $data['fromDate'] = $from;
            $data['toDate'] = $to;
            $data['allunit'] = $allunit;
            $data['classnyak'] = $this;

            $data['idpenjualan'] = $idpenjualan;
            $data['namapelanggan'] = $namapelanggan;
            $data['kategori'] = $selectkategori;
            $data['objek'] = $selectobjek;
            $this->load->view('laporan/tabel_pembayaran', $data);
        }
    }

    public function excel()
    {
        $dateFrom = $this->input->get('from');
        $dateTo = $this->input->get('to');

        $idpenjualan = $this->input->get('idpenjualan');
        $namapelanggan = $this->input->get('namapelanggan');

        $kategori = $this->input->get('kategori');
        $objek = $this->input->get('objek');

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->mergeCells('A1:A2'); // No
        $sheet->mergeCells('B1:C1'); //invoice
        $sheet->mergeCells('D1:D2'); //item (meliputi merek dan type)
        $sheet->mergeCells('E1:E2');
        $sheet->mergeCells('F1:G1');
        $sheet->mergeCells('H1:H2');
        $sheet->mergeCells('I1:I1');
        $sheet->mergeCells('J1:J2');
        

        $sheet->setCellValue('A1','No');
        $sheet->setCellValue('B1','Pelanggan');
        $sheet->setCellValue('B2','Nama');
        $sheet->setCellValue('C2','ID');
        $sheet->setCellValue('D1','Invoice');
        $sheet->setCellValue('E1','Kategori');
        $sheet->setCellValue('F1','Faktur');
        $sheet->setCellValue('F2','Tanggal');
        $sheet->setCellValue('G2','Jam');
        $sheet->setCellValue('H1','Detail Objek');
        $sheet->setCellValue('I1','Jumlah');
        $sheet->setCellValue('J1','User');
        

        
        $nourut = 1;
        $baris = 3;
        foreach($this->Laporan_model->getallPaymentDatawithDate(
                $dateFrom,
                $dateTo,
                $this->session->userdata('unit_id'),
                $idpenjualan,
                $namapelanggan,
                $kategori,
                $objek
            ) as $data)
        {
            
            $sheet->setCellValue('A'.$baris, $nourut++);
            $sheet->setCellValue('B'.$baris,$data->nama_pelanggan); 
			$sheet->setCellValue('C'.$baris,$data->pelanggan_id); 
			$sheet->setCellValue('D'.$baris,$data->invoice); 
			$sheet->setCellValue('E'.$baris,$data->nama_kategori); 
			$sheet->setCellValue('F'.$baris,$data->tanggal_sale); 
			$sheet->setCellValue('G'.$baris,$data->tanggal_sale);
			$sheet->setCellValue('H'.$baris,$data->jenis_pembayaran);
			$sheet->setCellValue('I'.$baris,$data->total_bayar);
			$sheet->setCellValue('J'.$baris,$data->nama_user);

            $baris++;
        }

        
        $writer = new Xlsx($spreadsheet);
        $filename = 'payment-report';
        
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

}

/* End of file Jenis_item.php */
/* Location: ./application/controllers/Jenis_item.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-07-01 08:38:23 */
/* http://harviacode.com */
