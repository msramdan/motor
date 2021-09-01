<?php

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
            $this->load->view('laporan/tabel_penjualan', $data);
        }
        else
        {
            echo 'all unit must true!';
        }
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
        $sheet->mergeCells('E1:J1'); //item (meliputi merek dan type)
        $sheet->mergeCells('K1:K2');
        $sheet->mergeCells('L1:M1');
        $sheet->mergeCells('N1:N2');
        $sheet->mergeCells('O1:O2');
        $sheet->mergeCells('P1:Q1');
        $sheet->mergeCells('R1:R2');
        $sheet->mergeCells('S1:S2');
        $sheet->mergeCells('T1:T2');
        $sheet->mergeCells('U1:U2');
        $sheet->mergeCells('V1:V2');
        $sheet->mergeCells('W1:W2');
        $sheet->mergeCells('X1:X2');
        $sheet->mergeCells('Y1:Y2');
        

        $sheet->setCellValue('A1','No');
        $sheet->setCellValue('B1','Invoice');
        $sheet->setCellValue('C1','ID Pelanggan');
        $sheet->setCellValue('D1','Nama Pelanggan');
        $sheet->setCellValue('E1','item');
        $sheet->setCellValue('E2','ID Item');
        $sheet->setCellValue('F2','Merek');
        $sheet->setCellValue('G2','Type');
        $sheet->setCellValue('H2','Nopol');
        $sheet->setCellValue('I2','Kategori');
        $sheet->setCellValue('J2','Jenis');
        $sheet->setCellValue('K1','Surveyor');
        $sheet->setCellValue('L1','Lokasi');
        $sheet->setCellValue('L2','Unit');
        $sheet->setCellValue('M2','Wipem');
        $sheet->setCellValue('N1','Nama Pelanggan');
        $sheet->setCellValue('O1','ID Pelanggan');
        $sheet->setCellValue('P1','Waktu');
        $sheet->setCellValue('P2','Tanggal');
        $sheet->setCellValue('Q2','Jam');
        $sheet->setCellValue('R1','DP');
        $sheet->setCellValue('S1','TradeIn');
        $sheet->setCellValue('T1','Harga Beli Pokok');
        $sheet->setCellValue('U1','Harga Penjualan');
        $sheet->setCellValue('V1','Markup');
        $sheet->setCellValue('W1','Sales Pokok');
        $sheet->setCellValue('X1','Durasi Cicil');
        $sheet->setCellValue('Y1','Bunga/bln');
        

        
        // $nourut = 1;
        // $baris = 3;
        // foreach($this->Sale_model->get_all() as $data)
        // {
            
        //     $sheet->setCellValue('A'.$baris, $nourut++);
        //     $sheet->setCellValue('B'.$baris, $data->invoice);
        //     $sheet->setCellValue('C'.$baris, $data->pelanggan_id);
        //     $sheet->setCellValue('D'.$baris, $data->nama_pelanggan);
        //     $sheet->setCellValue('E'.$baris, $data->nama_merek);
        //     $sheet->setCellValue('F'.$baris, $data->nama_type);
        //     $sheet->setCellValue('G'.$baris, $data->total_price_sale);
        //     $sheet->setCellValue('H'.$baris, $data->type_sale);
        //     $sheet->setCellValue('I'.$baris, $data->tanggal_sale);
        //     $sheet->setCellValue('J'.$baris, $data->nama_user);
        //     $baris++;
        // }

        
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
