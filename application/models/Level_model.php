<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Level_model extends CI_Model
{

    public $table = 'level';
    public $id = 'level_id';
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
        $this->db->like('level_id', $q);
	$this->db->or_like('nama_level', $q);
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('level_id', $q);
	$this->db->or_like('nama_level', $q);
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

    function getids($idlevel,$idsubmenu) {
        $params = array(
            'level_id'                          => $idlevel,
            'user_access_menu.sub_menu_id'      => $idsubmenu
        );

        $this->db->select("*")
            ->from('user_access_menu')
            ->join('sub_menu','sub_menu.sub_menu_id = user_access_menu.sub_menu_id')
            ->where($params);
        return $this->db->get()->row();
    }

}

/* End of file Level_model.php */
/* Location: ./application/models/Level_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-06-28 13:00:38 */
/* http://harviacode.com */