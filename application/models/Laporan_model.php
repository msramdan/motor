<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Laporan_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function getSaldoAwalBB($keadaancicilan)
    {
        $query = "
            SELECT SUM(sale_detail.pokok_cicilan) as 'Pokok',(SUM(sale_detail.harus_dibayar) - SUM(sale_detail.pokok_cicilan)) as 'Bunga'
            FROM sale_detail
            JOIN sale ON sale.invoice = sale_detail.sale_id
            LEFT JOIN item ON item.item_id = sale.item_id
            WHERE sale_detail.sale_id = sale.invoice AND item.unit_id = ".$this->session->userdata('unit_id')." AND sale.keadaan_cicilan = '".$keadaancicilan."';
        ";
        return $this->db->query($query)->row();
    }

    function getAngsuranlBB($keadaancicilan)
    {
        $query = "
            SELECT SUM(sale_detail.pokok_cicilan) as 'Pokok',(SUM(sale_detail.harus_dibayar) - SUM(sale_detail.pokok_cicilan)) as 'Bunga'
            FROM sale_detail
            JOIN sale ON sale.invoice = sale_detail.sale_id
            LEFT JOIN item ON item.item_id = sale.item_id
            WHERE sale_detail.sale_id = sale.invoice AND item.unit_id = ".$this->session->userdata('unit_id')." AND sale_detail.status = 'dibayar' AND sale.keadaan_cicilan = '".$keadaancicilan."';
        ";
        return $this->db->query($query)->row();
    }

    function getSaldoAkhirBB($keadaancicilan)
    {
        $query = "
            SELECT SUM(sale_detail.pokok_cicilan) as 'Pokok',(SUM(sale_detail.harus_dibayar) - SUM(sale_detail.pokok_cicilan)) as 'Bunga'
            FROM sale_detail
            JOIN sale ON sale.invoice = sale_detail.sale_id
            LEFT JOIN item ON item.item_id = sale.item_id
            WHERE sale_detail.sale_id = sale.invoice AND item.unit_id = ".$this->session->userdata('unit_id')." AND (sale_detail.status = 'siap dibayar' OR sale_detail.status = 'belum siap dibayar') AND sale.keadaan_cicilan = '".$keadaancicilan."';
        ";
        return $this->db->query($query)->row();
    }

    function getallSaleDatawithDate(
        $from,
        $to,
        $allunit,
        $idpenjualan,
        $iditem,
        $namapelanggan,
        $salesreferral,
        $mode,
        $kategori,
        $status
    )
    {

        $this->db->join('user', 'user.user_id = sale.user_id');
        $this->db->join('pelanggan', 'pelanggan.pelanggan_id = sale.pelanggan_id');
        $this->db->join('item', 'item.item_id = sale.item_id','left');
        $this->db->join('merek', 'merek.merek_id = item.merek_id','left');
        $this->db->join('type', 'type.type_id = item.type_id','left');
        $this->db->join('kategori', 'kategori.kategori_id = item.kategori_id','left');
        $this->db->join('unit', 'unit.unit_id = item.unit_id','left');
        $this->db->join('jenis_item', 'jenis_item.jenis_item_id = item.jenis_item_id','left');
        $this->db->join('karyawan', 'karyawan.karyawan_id = sale.surveyor_id','left');

        $this->db->like('item.unit_id',$allunit);

        $this->db->like('sale.invoice',$idpenjualan);
        $this->db->like('item.item_id',$iditem);
        $this->db->like('pelanggan.nama_pelanggan',$namapelanggan);

        $this->db->like('sale.sales_referral', $salesreferral);
        $this->db->like('sale.type_Sale', $mode);
        $this->db->like('item.kategori_id',$kategori);
        $this->db->like('sale.keadaan_cicilan',$status);

        $this->db->where('sale.tanggal_sale BETWEEN "'. date('Y-m-d', strtotime($from)). '" and "'. date('Y-m-d', strtotime($to)).'"');

        $this->db->order_by('sale.tanggal_sale', 'ASC');
        return $this->db->get('sale')->result();
    }

    function getallPaymentDatawithDate($from, $to, $allunit = NULL)
    {
        $this->db->join('user', 'user.user_id = sale.user_id');
        $this->db->join('pelanggan', 'pelanggan.pelanggan_id = sale.pelanggan_id');
        $this->db->join('item', 'item.item_id = sale.item_id','left');
        $this->db->join('merek', 'merek.merek_id = item.merek_id','left');
        $this->db->join('type', 'type.type_id = item.type_id','left');
        $this->db->join('kategori', 'kategori.kategori_id = item.kategori_id','left');
        $this->db->join('karyawan', 'karyawan.karyawan_id = sale.surveyor_id','left');
        $this->db->join('unit', 'unit.unit_id = item.unit_id','left');
        $this->db->join('jenis_item', 'jenis_item.jenis_item_id = item.jenis_item_id','left');
        $this->db->join('history_pembayaran', 'history_pembayaran.id = sale.invoice');

        $this->db->where('history_pembayaran.tanggal_bayar BETWEEN "'. date('Y-m-d', strtotime($from)). '" and "'. date('Y-m-d', strtotime($to)).'"');

        $this->db->like('item.unit_id',$allunit);

        $this->db->order_by('history_pembayaran.tanggal_bayar', 'ASC');
        return $this->db->get('sale')->result();
    }

 //    // get all
 //    function get_all()
 //    {
 //        $this->db->order_by($this->id, $this->order);
 //        return $this->db->get($this->table)->result();
 //    }

 //    // get data by id
 //    function get_by_id($id)
 //    {
 //        $this->db->where($this->id, $id);
 //        return $this->db->get($this->table)->row();
 //    }
    
 //    // get total rows
 //    function total_rows($q = NULL) {
 //        $this->db->like('kategori_id', $q);
	// $this->db->or_like('nama_kategori', $q);
	// $this->db->from($this->table);
 //        return $this->db->count_all_results();
 //    }

 //    // get data with limit and search
 //    function get_limit_data($limit, $start = 0, $q = NULL) {
 //        $this->db->order_by($this->id, $this->order);
 //        $this->db->like('kategori_id', $q);
	// $this->db->or_like('nama_kategori', $q);
	// $this->db->limit($limit, $start);
 //        return $this->db->get($this->table)->result();
 //    }

 //    // insert data
 //    function insert($data)
 //    {
 //        $this->db->insert($this->table, $data);
 //    }

 //    // update data
 //    function update($id, $data)
 //    {
 //        $this->db->where($this->id, $id);
 //        $this->db->update($this->table, $data);
 //    }

 //    // delete data
 //    function delete($id)
 //    {
 //        $this->db->where($this->id, $id);
 //        $this->db->delete($this->table);
 //    }

}

/* End of file Kategori_model.php */
/* Location: ./application/models/Kategori_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-07-04 20:20:13 */
/* http://harviacode.com */