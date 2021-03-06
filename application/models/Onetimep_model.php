<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Onetimep_model extends CI_Model
{

    public $table = 'mitra';
    public $id = 'mitra_id';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // get all
    function get_all()
    {
        $this->db->where('unit_id', $this->session->userdata('unit_id'));
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
    	$this->db->or_like('item_id', $q);
    	$this->db->or_like('total_price_sale', $q);
    	$this->db->or_like('type_sale', $q);
    	$this->db->or_like('tanggal_sale', $q);
    	$this->db->or_like('user_id', $q);
    	$this->db->where('type_sale','Cash');
    	$this->db->from('sale');
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->join('user', 'user.user_id = sale.user_id', 'left');
        $this->db->join('pelanggan', 'pelanggan.pelanggan_id = sale.pelanggan_id', 'left');
        $this->db->join('item', 'item.item_id = sale.item_id', 'left');
        $this->db->order_by('sale_id', $this->order);
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
    	$this->db->where('type_sale','Cash');
        return $this->db->get('sale')->result();
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

/* End of file Mitra_model.php */
/* Location: ./application/models/Mitra_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-07-14 07:33:22 */
/* http://harviacode.com */