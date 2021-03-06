<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sale_model extends CI_Model
{

    public $table = 'sale';
    public $id = 'sale_id';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // get all
    function get_all()
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

        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    function get_by_id_w_appr($id)
    {
        $this->db->join('pelanggan','pelanggan.pelanggan_id = sale.pelanggan_id');
        $this->db->join('item','item.item_id = sale.item_id');
        $this->db->join('user','user.user_id = sale.user_id');
        $this->db->join('approval_lists','approval_lists.invoice_id = sale.invoice');
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }

    function get_by_id($id)
    {
        $this->db->join('pelanggan','pelanggan.pelanggan_id = sale.pelanggan_id');
        $this->db->join('item','item.item_id = sale.item_id');
        $this->db->join('user','user.user_id = sale.user_id');
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }

    function get_by_invoice($id)
    {
        $this->db->join('pelanggan','pelanggan.pelanggan_id = sale.pelanggan_id');
        $this->db->join('user','user.user_id = sale.user_id');
        $this->db->join('item','item.item_id = sale.item_id');
        $this->db->join('type','item.type_id = type.type_id','left');
        $this->db->join('merek','item.merek_id = merek.merek_id','left');
        $this->db->where('invoice', $id);
        return $this->db->get($this->table)->row();
    }
    
    // get total rows
    function total_rows($q = NULL) {
        $this->db->like('sale_id', $q);
    	$this->db->or_like('invoice', $q);
    	$this->db->or_like('pelanggan_id', $q);
    	$this->db->or_like('item_id', $q);
    	$this->db->or_like('total_price_sale', $q);
    	$this->db->or_like('type_sale', $q);
    	$this->db->or_like('tanggal_sale', $q);
    	$this->db->or_like('user_id', $q);
    	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->join('user', 'user.user_id = sale.user_id', 'left');
        $this->db->join('pelanggan', 'pelanggan.pelanggan_id = sale.pelanggan_id', 'left');
        $this->db->join('item', 'item.item_id = sale.item_id', 'left');
        $this->db->order_by($this->id, $this->order);
        $this->db->where('item.unit_id', $this->session->userdata('unit_id'));
        $this->db->group_start();
        $this->db->like('sale_id', $q);
    	$this->db->or_like('invoice', $q);
    	$this->db->or_like('pelanggan.nama_pelanggan', $q);
    	$this->db->or_like('item.nama_item', $q);
    	$this->db->or_like('total_price_sale', $q);
    	$this->db->or_like('type_sale', $q);
    	$this->db->or_like('tanggal_sale', $q);
    	$this->db->or_like('user.nama_user', $q);
        $this->db->group_end();
    	$this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    //insert data
    function insert($tipesale, $data)
    {
        if ($tipesale == 'Kredit') {
            $this->db->insert($this->table, $data);
            // foreach($datacicilan as $k) {
            //     $this->db->insert('sale_detail', $k);
            // }
            return;
        }

        $this->db->insert($this->table, $data);
        return;
    }

    function insert_data_cicilan($datacicilan)
    {
        foreach($datacicilan as $k) {
            $this->db->insert('sale_detail', $k);
        }
    }

    function inserttopaymenthistory($data)
    {
        $this->db->insert('history_pembayaran', $data);
    }

    // update data
    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    function update_data_dibayar($id,$data)
    {
        $this->db->where('invoice', $id);
        $this->db->update('sale', $data);
    }

    // delete data
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }

    
    function buat_kode(){
        $q = $this->db->query("SELECT MAX(RIGHT(invoice,4)) AS kd_max FROM sale WHERE DATE(tanggal_sale)=CURDATE()");
        $kd = "";
        if($q->num_rows()>0){
            foreach($q->result() as $k){
                $tmp = ((int)$k->kd_max)+1;
                $kd = sprintf("%04s", $tmp);
            }
        }else{
            $kd = "0001";
        }
        date_default_timezone_set('Asia/Jakarta');
        return 'S'.date('dmy').$kd;
    }

    function get_kartupiutang_data($inv) 
    {
        $this->db->select('*');
        $this->db->from('item');
        $this->db->join('agen', 'agen.agen_id = item.agen_id', 'left');
        $this->db->join('merek', 'merek.merek_id = item.merek_id', 'left');
        $this->db->join('type', 'type.type_id = item.type_id', 'left');
        $this->db->join('jenis_item', 'jenis_item.jenis_item_id = item.jenis_item_id', 'left');
        $this->db->join('kategori', 'kategori.kategori_id = item.kategori_id', 'left');
        $this->db->join('sale', 'sale.item_id = item.item_id');
        $this->db->join('pelanggan','pelanggan.pelanggan_id = sale.pelanggan_id','left');
        $this->db->join('user','user.user_id = item.item_id','left');
        $this->db->where('invoice', $inv);
        return $this->db->get()->row();
    }

    function get_bungapercicilan($inv)
    {
        $this->db->select("pokok_cicilan, harus_dibayar, nilai_bunga_percicilan, COUNT(harus_dibayar) as 'brapaxcicilan', MID(jatuh_tempo,9,2) as 'tiap_tanggal'")
            ->distinct()
            ->from('sale_detail');
        $this->db->where('sale_id',$inv);
        return $this->db->get()->row();
    }

    function get_detail_pengajuancicilan($id)
    {
        $this->db->select('*');
        $this->db->from('item');
        $this->db->join('agen', 'agen.agen_id = item.agen_id', 'left');
        $this->db->join('merek', 'merek.merek_id = item.merek_id', 'left');
        $this->db->join('type', 'type.type_id = item.type_id', 'left');
        $this->db->join('jenis_item', 'jenis_item.jenis_item_id = item.jenis_item_id', 'left');
        $this->db->join('kategori', 'kategori.kategori_id = item.kategori_id', 'left');
        $this->db->join('sale', 'sale.item_id = item.item_id');
        $this->db->join('approval_lists','approval_lists.invoice_id = sale.invoice','right');
        $this->db->join('pelanggan','pelanggan.pelanggan_id = sale.pelanggan_id','left');
        $this->db->join('user','user.user_id = item.item_id','left');
        $this->db->join('level','level.level_id = user.level_id','left');
        $this->db->where('invoice', $id);
        return $this->db->get()->row();
    }

    function getAllbyKeadaanCicilan($status)
    {
        $this->db->select('*')
            ->where('type_sale','Kredit')
            ->group_start()
                ->where('status_sale','Dalam Cicilan')
                ->or_where('status_sale','Selesai')
            ->group_end()
            ->where('keadaan_cicilan',$status);
        $this->db->from('sale');
        $this->db->join('user', 'user.user_id = sale.user_id');
        $this->db->join('pelanggan', 'pelanggan.pelanggan_id = sale.pelanggan_id');
        $this->db->join('item', 'item.item_id = sale.item_id','left');
        $this->db->join('merek', 'merek.merek_id = item.merek_id','left');
        $this->db->join('type', 'type.type_id = item.type_id','left');

        return $this->db->get()->result();
    }

    function total_rows_ka($q = NULL, $status) {
        $this->db->where('type_sale','Kredit');
        $this->db->where('keadaan_cicilan',$status)
            ->group_start()
                ->where('status_sale','Dalam Cicilan')
                ->or_where('status_sale','Selesai')
            ->group_end();
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data_ka($limit, $start = 0, $q = NULL, $status) {
        $this->db->join('user', 'user.user_id = sale.user_id', 'left');
        $this->db->join('pelanggan', 'pelanggan.pelanggan_id = sale.pelanggan_id', 'left');
        $this->db->join('item', 'item.item_id = sale.item_id', 'left');
        $this->db->order_by($this->id, $this->order);
        $this->db->where('item.unit_id', $this->session->userdata('unit_id'));
        $this->db->where('keadaan_cicilan',$status);
        $this->db->group_start();
            $this->db->where('status_sale','Dalam Cicilan');
            $this->db->or_where('status_sale','Selesai');
        $this->db->group_end();
        $this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }
}

/* End of file Sale_model.php */
/* Location: ./application/models/Sale_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-07-03 11:10:29 */
/* http://harviacode.com */
