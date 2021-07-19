<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }


    function admin_fee()
    {
        $this->db->from('admin_fee');
        $query = $this->db->get();
        return $query->row();
    }

    function bunga()
    {
        $this->db->from('bunga');
        $query = $this->db->get();
        return $query->row();
    }


    function update_admin_fee($post){
        $params =array(
            'nominal' =>$post['nominal'],
            
        );
        $this->db->update('admin_fee',$params);

    }

    function update_bunga($post){
        $params =array(
            'nominal' =>$post['nominal'],
            
        );
        $this->db->update('bunga',$params);

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

    function count_jenis_pembayaran()
    {
        $this->db->select('*');
        $this->db->from('jenis_pembayaran');
        return $this->db->count_all_results();
    }

    function sales_referal_chart($startdate, $enddate, $idunit) {

        $query = "SELECT DISTINCT 
                    (SELECT COUNT(`sales_referral`) 
                        FROM sale
                        JOIN item ON `item`.`item_id` = `sale`.`item_id`
                        LEFT JOIN unit ON `unit`.`unit_id` = `item`.`unit_id`
                        WHERE `sales_referral` = 'Datang Langsung' AND `unit`.`unit_id` = '".$idunit."') as 'datang_langsung',
                    (SELECT COUNT(`sale`.`sales_referral`) 
                        FROM sale
                        JOIN item ON `item`.`item_id` = `sale`.`item_id` 
                        LEFT JOIN unit ON `unit`.`unit_id` = `item`.`unit_id`
                        WHERE `sales_referral` = 'Karyawan' AND `unit`.`unit_id` = '".$idunit."') as 'karyawan',
                    (SELECT COUNT(`sale`.`sales_referral`) 
                        FROM sale 
                        JOIN item ON `item`.`item_id` = `sale`.`item_id` 
                        LEFT JOIN unit ON `unit`.`unit_id` = `item`.`unit_id`
                        WHERE `sales_referral` = 'Mitra Sales' AND `unit`.`unit_id` = '".$idunit."') as 'mitra_sales'
                  FROM sale
                  WHERE `tanggal_sale` BETWEEN '".$startdate."' AND '".$enddate."'";
        $res = $this->db->query($query)->row();
        return $res;
    }

    function umuk_chart($startdate, $enddate, $idunit, $what, $status) {
        $query = "SELECT SUM(`harga_pokok`) as '".$what."' FROM item WHERE `unit_id` = '".$idunit."' AND `status` = '".$status."' tanggal_sale BETWEEN '".$startdate."' AND '".$enddate."'";
        $res = $this->db->query($query)->row();

        if ($res->$what === NULL) {
            return 0;
        }

        return $res;
    }

}
