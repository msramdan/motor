<?php

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lap_penjualan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Jenis_item_model');
        $this->load->model('Laporan_model');
        $this->load->model('Sale_model');
        $this->load->model('History_pembayaran_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        is_allowed($this->uri->segment(1),null);
        $this->template->load('template','laporan/penjualan');
    }

    public function fetch_tabel_penjualan()
    {
        $from = $this->input->post('fromDate');
        $to = $this->input->post('toDate');
        $allunit = $this->input->post('allunit');

        if ($allunit == 'true') {
            $data['lists_data'] = $this->Laporan_model->getallSaleDatawithDate($from, $to);
            $data['fromDate'] = $from;
            $data['toDate'] = $to;
            $data['allunit'] = $allunit;
            $data['classnyak'] = $this;
            $this->load->view('laporan/tabel_penjualan', $data);
        }
        else
        {
            echo 'all unit must true!';
        }
    }

    public function excel()
    {
        $dateFrom = $this->input->get('from');
        $dateTo = $this->input->get('to');


        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->mergeCells('A1:A2'); // No
        $sheet->mergeCells('B1:B2'); //invoice
        $sheet->mergeCells('C1:H1'); //item (meliputi merek dan type)
        $sheet->mergeCells('I1:I2');
        $sheet->mergeCells('J1:K1');
        $sheet->mergeCells('L1:L2');
        $sheet->mergeCells('M1:M2');
        $sheet->mergeCells('N1:O1');
        $sheet->mergeCells('P1:P2');
        $sheet->mergeCells('Q1:Q2');
        $sheet->mergeCells('R1:R2');
        $sheet->mergeCells('S1:S2');
        $sheet->mergeCells('T1:T2');
        $sheet->mergeCells('U1:U2');
        $sheet->mergeCells('V1:V2');
        $sheet->mergeCells('W1:W2');
        

        $sheet->setCellValue('A1','No');
        $sheet->setCellValue('B1','Invoice');
        $sheet->setCellValue('C1','item');
        $sheet->setCellValue('C2','ID Item');
        $sheet->setCellValue('D2','Merek');
        $sheet->setCellValue('E2','Type');
        $sheet->setCellValue('F2','STNK');
        $sheet->setCellValue('G2','Kategori');
        $sheet->setCellValue('H2','Jenis');
        $sheet->setCellValue('I1','Surveyor');
        $sheet->setCellValue('J1','Lokasi');
        $sheet->setCellValue('J2','Unit');
        $sheet->setCellValue('K2','Wipem');
        $sheet->setCellValue('L1','Nama Pelanggan');
        $sheet->setCellValue('M1','ID Pelanggan');
        $sheet->setCellValue('N1','Waktu');
        $sheet->setCellValue('N2','Tanggal');
        $sheet->setCellValue('O2','Jam');
        $sheet->setCellValue('P1','DP');
        $sheet->setCellValue('Q1','TradeIn');
        $sheet->setCellValue('R1','Harga Beli Pokok');
        $sheet->setCellValue('S1','Harga Penjualan');
        $sheet->setCellValue('T1','Markup');
        $sheet->setCellValue('U1','Sales Pokok');
        $sheet->setCellValue('V1','Durasi Cicil');
        $sheet->setCellValue('W1','Bunga/bln');
        

        
        $nourut = 1;
        $baris = 3;
        foreach($this->Laporan_model->getallSaleDatawithDate($dateFrom,$dateTo) as $data)
        {
            
            $sheet->setCellValue('A'.$baris, $nourut++);
            $sheet->setCellValue('B'.$baris, $data->invoice);
            $sheet->setCellValue('C'.$baris, $data->item_id);
            $sheet->setCellValue('D'.$baris, $data->nama_merek);
            $sheet->setCellValue('E'.$baris, $data->nama_type);
            $sheet->setCellValue('F'.$baris, $data->no_stnk);
            $sheet->setCellValue('G'.$baris, $data->nama_kategori);
            $sheet->setCellValue('H'.$baris, $data->nama_jenis_item);
            $sheet->setCellValue('I'.$baris, $data->nama_karyawan);
            $sheet->setCellValue('J'.$baris, $data->nama_unit);
            $sheet->setCellValue('K'.$baris, $data->nama_unit);
            $sheet->setCellValue('L'.$baris, $data->nama_pelanggan);
            $sheet->setCellValue('M'.$baris, $data->pelanggan_id);
            $sheet->setCellValue('N'.$baris, $data->tanggal_sale);
            $sheet->setCellValue('O'.$baris, $data->tanggal_sale);
            $sheet->setCellValue('P'.$baris, $this->History_pembayaran_model->getSingleDataHistoryPembayaran($data->invoice, 'dp cicilan')->total_bayar);
            $sheet->setCellValue('Q'.$baris, $data->harga_beli);
            $sheet->setCellValue('R'.$baris, $data->harga_pokok);
            $sheet->setCellValue('S'.$baris, $data->total_bayar);
            $sheet->setCellValue('T'.$baris, (intval($data->total_bayar) - intval($data->harga_pokok)));
            $sheet->setCellValue('U'.$baris, $data->total_price_sale);
            $sheet->setCellValue('V'.$baris, $this->Sale_model->get_bungapercicilan($data->invoice)->brapaxcicilan);
            $sheet->setCellValue('W'.$baris, $this->Sale_model->get_bungapercicilan($data->invoice)->nilai_bunga_percicilan);

            $baris++;
        }

        
        $writer = new Xlsx($spreadsheet);
        $filename = 'sale-report';
        
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
