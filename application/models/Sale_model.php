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
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    // get data by id
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }
    
    // get total rows
    function total_rows($q = NULL) {
        $this->db->like('sale_id', $q);
	$this->db->or_like('invoice', $q);
	$this->db->or_like('pelanggan_id', $q);
	$this->db->or_like('kendaraan_id', $q);
	$this->db->or_like('total_price_sale', $q);
	$this->db->or_like('type_sale', $q);
	$this->db->or_like('tanggal_sale', $q);
	$this->db->or_like('user_id', $q);
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('sale_id', $q);
	$this->db->or_like('invoice', $q);
	$this->db->or_like('pelanggan_id', $q);
	$this->db->or_like('kendaraan_id', $q);
	$this->db->or_like('total_price_sale', $q);
	$this->db->or_like('type_sale', $q);
	$this->db->or_like('tanggal_sale', $q);
	$this->db->or_like('user_id', $q);
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

/* End of file Sale_model.php */
/* Location: ./application/models/Sale_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-07-03 11:10:29 */
/* http://harviacode.com */