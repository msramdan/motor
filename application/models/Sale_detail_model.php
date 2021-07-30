<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sale_detail_model extends CI_Model
{

    public $table = 'sale_detail';
    public $id = 'sale_detail_id';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // get all
    function get_all()
    {
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    // get data by id
    function get_by_id($id)
    {
        $this->db->where('sale_id', $id);
        return $this->db->get($this->table)->result();
    }

    //get anu
    function get_data_cicilan($id)
    {
        $this->db->where('sale_detail_id', $id);
        return $this->db->get($this->table)->row();
    }
    
    // get total rows
    function total_rows($q = NULL) {
        $this->db->distinct();
        $this->db->select("sale_id as 'saleid', (SELECT COUNT(status) from `sale_detail` WHERE sale_id = saleid AND status = 'belum dibayar') as 'total_belum_dibayar', (SELECT COUNT(status) from `sale_detail` WHERE sale_id = saleid AND status = 'dibayar') as 'total_dibayar', (SELECT COUNT(status) from `sale_detail` WHERE sale_id = saleid) as 'total_angsuran'");
        $this->db->like('sale_detail_id', $q);
        $this->db->or_like('sale_id', $q);
    	// $this->db->or_like('pembayaran_ke', $q);
    	// $this->db->or_like('status', $q);
    	// $this->db->or_like('total_bayar', $q);
    	// $this->db->or_like('jatuh_tempo', $q);
        return $this->db->get($this->table)->result_array();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->distinct();
        //asdaasaadsasd

        $this->db->select("sale_id as 'saleid', (SELECT COUNT(status) from `sale_detail` WHERE sale_id = saleid AND status = 'belum dibayar') as 'total_belum_dibayar', (SELECT COUNT(status) from `sale_detail` WHERE sale_id = saleid AND status = 'dibayar') as 'total_dibayar', (SELECT COUNT(status) from `sale_detail` WHERE sale_id = saleid) as 'total_angsuran'");
        $this->db->order_by($this->id, $this->order);
        $this->db->like('sale_detail_id', $q);
    	$this->db->or_like('sale_id', $q);
    	// $this->db->or_like('pembayaran_ke', $q);
    	// $this->db->or_like('status', $q);
    	// $this->db->or_like('total_bayar', $q);
    	// $this->db->or_like('jatuh_tempo', $q);
    	$this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    // insert data
    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    // update data
    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    // delete data
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }

}

/* End of file Sale_detail_model.php */
/* Location: ./application/models/Sale_detail_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-07-26 14:34:47 */
/* http://harviacode.com */