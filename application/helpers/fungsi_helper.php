<?php
function check_already_login(){
    $ci =& get_instance();
    $user_session = $ci->session->userdata('userid');
    if ($user_session){
        redirect('dashboard');
    }
}

function check_access($level_id, $menu_id ){
    $ci = get_instance();
    $ci->db->where('level_id', $level_id);
    $ci->db->where('sub_menu_id', $menu_id);
    $result = $ci->db->get('user_access_menu');
    if ($result->num_rows() > 0 ) {
         return "checked='checked'";
    }

 }

 function check_access_unit($user_id, $unit_id ){
    $ci = get_instance();
    $ci->db->where('user_id', $user_id);
    $ci->db->where('unit_id', $unit_id);
    $result = $ci->db->get('user_access_unit');
    if ($result->num_rows() > 0 ) {
         return "checked='checked'";
    }

 }

 

function is_login(){
    $ci =& get_instance();
    $user_session = $ci->session->userdata('userid');
    if (!$user_session){
        redirect('auth');
    }
}
    

    function check_admin(){
        $ci =& get_instance();
        $ci->load->library('fungsi');
        if($ci->fungsi->user_login()->level !=1 ){
            redirect('dashboard');

        }

    }

function rupiah($angka){
    
    $hasil_rupiah = "Rp " . number_format($angka,0,',','.');
    return $hasil_rupiah;
}

function indo_date($date){
    $d = substr($date,8,2);
    $m = substr($date,5,2);
    $y = substr($date,0,4);
    return $d.'/'.$m.'/'.$y;
}
