<?php
function check_already_login(){

    $ci =& get_instance();
    $user_session = $ci->session->userdata('userid');
    if ($user_session){
        redirect('beranda');
    }
}

function check_url_access() {
    
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
