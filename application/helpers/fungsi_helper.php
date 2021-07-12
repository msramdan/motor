<?php
function check_already_login(){

    $ci =& get_instance();
    $user_session = $ci->session->userdata('userid');
    if ($user_session){
        redirect('beranda');
    }
}

//akses menu
function check_access($level_id, $menu_id ){
    $ci = get_instance();
    $ci->db->where('level_id', $level_id);
    $ci->db->where('sub_menu_id', $menu_id);
    $result = $ci->db->get('user_access_menu');
    if ($result->num_rows() > 0 ) {
         return "checked='checked'";
    }

 }

 //acces_read

  function check_access_read($level_id, $menu_id ){
    $ci = get_instance();
    $ci->db->where('level_id', $level_id);
    $ci->db->where('sub_menu_id', $menu_id);
    $result = $ci->db->get('user_access_menu');
    if ($result->num_rows() > 0 ) {
        $row = $result->row();
        if ($row->read == 1) {
            return "checked='checked'";
        }         
    }

 }

 //acces_create

  function check_access_create($level_id, $menu_id ){
    $ci = get_instance();
    $ci->db->where('level_id', $level_id);
    $ci->db->where('sub_menu_id', $menu_id);
    $result = $ci->db->get('user_access_menu');
    if ($result->num_rows() > 0 ) {
        $row = $result->row();
        if ($row->create == 1) {
            return "checked='checked'";
        }         
    }

 }

  //acces_update
  function check_access_update($level_id, $menu_id ){
    $ci = get_instance();
    $ci->db->where('level_id', $level_id);
    $ci->db->where('sub_menu_id', $menu_id);
    $result = $ci->db->get('user_access_menu');
    if ($result->num_rows() > 0 ) {
        $row = $result->row();
        if ($row->update == 1) {
            return "checked='checked'";
        }         
    }

 }

 //acces_delete
  function check_access_delete($level_id, $menu_id ){
    $ci = get_instance();
    $ci->db->where('level_id', $level_id);
    $ci->db->where('sub_menu_id', $menu_id);
    $result = $ci->db->get('user_access_menu');
    if ($result->num_rows() > 0 ) {
        $row = $result->row();
        if ($row->delete == 1) {
            return "checked='checked'";
        }         
    }

 }

 //acces_export
  function check_access_export($level_id, $menu_id ){
    $ci = get_instance();
    $ci->db->where('level_id', $level_id);
    $ci->db->where('sub_menu_id', $menu_id);
    $result = $ci->db->get('user_access_menu');
    if ($result->num_rows() > 0 ) {
        $row = $result->row();
        if ($row->export == 1) {
            return "checked='checked'";
        }         
    }

 }

//akses unit
 function check_access_unit($user_id, $unit_id ){
    $ci = get_instance();
    $ci->db->where('user_id', $user_id);
    $ci->db->where('unit_id', $unit_id);
    $result = $ci->db->get('user_access_unit');
    if ($result->num_rows() > 0 ) {
         return "checked='checked'";
    }

 }

 
//untuk semua ctrl cek seesion login dan session unit
function is_login(){
    $ci =& get_instance();
    $unit_session = $ci->session->userdata('unit_id');
    $user_session = $ci->session->userdata('userid');
    if ($user_session){
        if (!$unit_session){
        redirect('beranda/unit');
        }
    }else{
        redirect('auth');
    }
}

//untuk bagian beranda saja
function cek_login_aja(){
    $ci =& get_instance();
    $user_session = $ci->session->userdata('userid');
        if (!$user_session){
        redirect('auth');
        }
}

//cek admin status login
function check_admin(){
        $ci =& get_instance();
        $ci->load->library('fungsi');
        if($ci->fungsi->user_login()->level !=1 ){
            redirect('beranda');

        }

    }

//format rupiah
function rupiah($angka){
    
    $hasil_rupiah = "Rp " . number_format($angka,0,',','.');
    return $hasil_rupiah;
}

//is_allowed
function is_allowed($nama_menu, $access=null){
    $ci =& get_instance();
    $ci->load->library('fungsi');
    $user_session = $ci->fungsi->user_login()->level_id;
        $ci->db->select('user_access_menu.*,sub_menu.url');
        $ci->db->from('user_access_menu');
        $ci->db->join('sub_menu', 'sub_menu.sub_menu_id = user_access_menu.sub_menu_id','left');
        $ci->db->where('url', $nama_menu);
        $ci->db->where('level_id', $user_session);
        if ($access !=null){
            $ci->db->where($access,1);
        }
        $query = $ci->db->get();
        if ($query->num_rows() < 1 ) {
         redirect('not_access');
        }

            
    }
