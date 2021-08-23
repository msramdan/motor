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
        $this->db->where('sale_id', $id)
            ->group_start()
                ->where('status', 'siap dibayar')
                ->or_where('status', 'dibayar')
            ->group_end();
        return $this->db->get($this->table)->result();
    }

    function get_all_by_id($id)
    {
        $this->db->where('sale_id', $id);
        return $this->db->get($this->table)->result();
    }

    function count_sisa_pembayaran($id)
    {
        $query = $this->db->query('SELECT * FROM sale_detail WHERE sale_id = "'.$id.'" AND (status = "belum siap dibayar" OR status = "siap dibayar")');
        return $query->num_rows();
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
        $this->db->select("sale_detail.sale_id as 'saleid', (SELECT COUNT(status) from `sale_detail` WHERE sale_id = saleid AND status = 'belum dibayar') as 'total_belum_dibayar', (SELECT COUNT(status) from `sale_detail` WHERE sale_id = saleid AND status = 'dibayar') as 'total_dibayar', (SELECT COUNT(status) from `sale_detail` WHERE sale_id = saleid) as 'total_angsuran', sale.status_sale as 'status_sale'");
        $this->db->join('sale','sale.invoice = sale_detail.sale_id');
        $this->db->like('sale_detail_id', $q);
        $this->db->or_like('sale_detail.sale_id', $q);
    	// $this->db->or_like('pembayaran_ke', $q);
    	// $this->db->or_like('status', $q);
    	// $this->db->or_like('total_bayar', $q);
    	// $this->db->or_like('jatuh_tempo', $q);
        return $this->db->get($this->table)->result_array();
    }

    // get data with limit and search
    function get_progress_jumlah_cicilan($invoice) {
        $this->db->distinct();
        $this->db->select("sale_detail.sale_id as 'saleid', (SELECT COUNT(status) from `sale_detail` WHERE sale_id = saleid AND status = 'belum dibayar') as 'total_belum_dibayar', (SELECT COUNT(status) from `sale_detail` WHERE sale_id = saleid AND status = 'dibayar') as 'total_dibayar', (SELECT COUNT(status) from `sale_detail` WHERE sale_id = saleid) as 'total_angsuran', sale.status_sale as 'status_sale'");
        $this->db->join('sale','sale.invoice = sale_detail.sale_id');
        $this->db->where('sale_detail.sale_id', $invoice);
        return $this->db->get('sale_detail')->row();
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

    function getpaiddetail($id)
    {
        $this->db->select('sale_id, sum(total_bayar) as "telah_dibayar", sum(harus_dibayar) as "wajib_dibayar"')
            ->from('sale_detail')
            ->where('sale_id', $id);
        return $this->db->get()->row();
    }

    function cekstatuslunas($invoice) {
        $this->db->distinct()->select("(SELECT COUNT(*) FROM sale_detail WHERE sale_id = '".$invoice."' AND status = 'dibayar') AS 'telah_bayar', (SELECT COUNT(*) FROM sale_detail WHERE sale_id = '".$invoice."') AS 'total_bayar'")->from('sale_detail');
        return $this->db->get()->row();
    }

    function deteksidatacicilan($invoice, $whatstatus)
    {
        $where = array(
            'sale_id' => $invoice,
            'status' => $whatstatus
        );
        $this->db->select("*")
            ->where($where)
            ->order_by('pembayaran_ke','ASC')
            ->limit(1)
            ->from('sale_detail');
        return $this->db->get()->row();
    }

    function ceksemuadendapadainvoiceini($invoice)
    {
        // SELECT * FROM sale_detail JOIN denda ON denda.sale_detail_id = sale_detail.sale_detail_id WHERE sale_id = 'S1708210002';
        $where = array(
            'sale_id' => $invoice,
            'denda.status' => 'belum dibayar'
        );
        $this->db->select('*')
            ->from('sale_detail')
            ->join('denda','denda.sale_detail_id = sale_detail.sale_detail_id')
            ->where($where);
        return $this->db->get()->num_rows();
    }
}

/* End of file Sale_detail_model.php */
/* Location: ./application/models/Sale_detail_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-07-26 14:34:47 */
/* http://harviacode.com */