<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Kendaraan_model extends CI_Model
{

    public $table = 'kendaraan';
    public $id = 'kendaraan_id';
    public $table2 = 'harga';
    public $id2 = 'harga_id';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }



    // get all
    function get_all($status)
    {
        if(!$status) {
            $this->db->select('*');
            $this->db->join('agen', 'agen.agen_id = kendaraan.agen_id', 'left');
            $this->db->join('merek', 'merek.merek_id = kendaraan.merek_id', 'left');
            $this->db->join('type', 'type.type_id = kendaraan.type_id', 'left');
            $this->db->join('jenis_kendaraan', 'jenis_kendaraan.jenis_kendaraan_id = kendaraan.jenis_kendaraan_id', 'left');
            $this->db->order_by($this->id, $this->order);
            return $this->db->get($this->table)->result();
        } else {
            $this->db->select('*');
            $this->db->join('agen', 'agen.agen_id = kendaraan.agen_id', 'left');
            $this->db->join('merek', 'merek.merek_id = kendaraan.merek_id', 'left');
            $this->db->join('type', 'type.type_id = kendaraan.type_id', 'left');
            $this->db->join('jenis_kendaraan', 'jenis_kendaraan.jenis_kendaraan_id = kendaraan.jenis_kendaraan_id', 'left');
            $this->db->where('kendaraan.status',$status);
            $this->db->order_by($this->id, $this->order);
            return $this->db->get($this->table)->result();
        }
    }

    function get_harga ($id){
        $this->db->select('harga.*');
        $this->db->from('harga');
        $this->db->where('kendaraan_id', $id);
        $query = $this->db->get();
        return $query;
    }

    // get data by id
    function get_by_id($id)
    {
        $this->db->select('*')
            ->join('agen','agen.agen_id = kendaraan.agen_id')
            ->join('jenis_kendaraan','jenis_kendaraan.jenis_kendaraan_id = kendaraan.jenis_kendaraan_id')
            ->join('merek','merek.merek_id = kendaraan.merek_id');

        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }

    function delete_berkas($id_berkas)
    {
        $this->db->where($this->id2, $id_berkas);
        $this->db->delete($this->table2);
    }

     function get_harga_by_id($id)
    {
        $this->db->where($this->id2, $id);
        return $this->db->get($this->table2)->row();
    }
    
    // get total rows
    function total_rows($q = NULL) {
        $this->db->like('kendaraan_id', $q);
	$this->db->or_like('kd_pembelian', $q);
	$this->db->or_like('agen_id', $q);
	$this->db->or_like('kd_kendaraan', $q);
	$this->db->or_like('nama_kendaraan', $q);
	$this->db->or_like('jenis_kendaraan_id', $q);
	$this->db->or_like('merek_id', $q);
	$this->db->or_like('no_stnk', $q);
	$this->db->or_like('no_bpkb', $q);
	$this->db->or_like('deskripsi', $q);
	$this->db->or_like('harga_beli', $q);
	$this->db->or_like('photo', $q);
	$this->db->or_like('status', $q);
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->join('agen', 'agen.agen_id = kendaraan.agen_id', 'left');
        $this->db->join('kategori', 'kategori.kategori_id = kendaraan.kategori_id', 'left');
        $this->db->join('merek', 'merek.merek_id = kendaraan.merek_id', 'left');
        $this->db->join('type', 'type.type_id = kendaraan.type_id', 'left');
        $this->db->join('jenis_kendaraan', 'jenis_kendaraan.jenis_kendaraan_id = kendaraan.jenis_kendaraan_id', 'left');
        $this->db->order_by($this->id, $this->order);
        $this->db->group_start();
        $this->db->like('kendaraan_id', $q);
	$this->db->or_like('kd_pembelian', $q);
	$this->db->or_like('agen.nama_agen', $q);
	$this->db->or_like('kd_kendaraan', $q);
	$this->db->or_like('nama_kendaraan', $q);
    $this->db->or_like('kategori.nama_kategori', $q);
	$this->db->or_like('jenis_kendaraan.nama_jenis_kendaraan', $q);
	$this->db->or_like('merek.nama_merek', $q);
	$this->db->or_like('no_stnk', $q);
	$this->db->or_like('no_bpkb', $q);
	$this->db->or_like('kendaraan.deskripsi', $q);
	$this->db->or_like('harga_beli', $q);
	$this->db->or_like('photo', $q);
	$this->db->or_like('status', $q);
    $this->db->group_end();
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

    public function cekkodebarang()
    {
        $query = $this->db->query("SELECT MAX(kd_kendaraan) as kodebarang from kendaraan");
        $hasil = $query->row();
        return $hasil->kodebarang;
    }

    function buat_kode(){
        $q = $this->db->query("SELECT MAX(RIGHT(kd_pembelian,4)) AS kd_max FROM kendaraan WHERE DATE(tgl_beli)=CURDATE()");
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
        return date('dmy').$kd;
    }

}

/* End of file Kendaraan_model.php */
/* Location: ./application/models/Kendaraan_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-07-01 15:16:50 */
/* http://harviacode.com */