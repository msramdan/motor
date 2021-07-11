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
        $this->db->where('unit_id', $this->session->userdata('unit_id'));
        
        return $this->db->count_all_results();
    }

    function count_item()
    {
        $this->db->select('*');
        $this->db->from('item');
        $this->db->where('unit_id', $this->session->userdata('unit_id'));
        return $this->db->count_all_results();
    }

    function count_agen()
    {
        $this->db->select('*');
        $this->db->from('agen');
        $this->db->where('unit_id', $this->session->userdata('unit_id'));
        return $this->db->count_all_results();
    }

    function count_allusers()
    {
        $this->db->select('*');
        $this->db->from('karyawan');
        $this->db->where('unit_id', $this->session->userdata('unit_id'));
        return $this->db->count_all_results();
    }

}
