<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function count_pelanggan()
    {
        $this->db->select('*');
        $this->db->from('pelanggan');
        return $this->db->count_all_results();
    }

    function count_item()
    {
        $this->db->select('*');
        $this->db->from('item');
        return $this->db->count_all_results();
    }

    function count_transaksi()
    {
        $this->db->select('*');
        $this->db->from('sale');
        return $this->db->count_all_results();
    }

    function count_allusers()
    {
        $this->db->select('*');
        $this->db->from('user');
        return $this->db->count_all_results();
    }

}
