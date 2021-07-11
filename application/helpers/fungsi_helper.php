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

function show_button($url,$function,$id_data = NULL, $text = NULL) {
    $ci =& get_instance();
    $ci->load->library('fungsi');
    $level = $ci->fungsi->user_login()->level_id;
    $check = $ci->db->select('level.nama_level, menu.menu as "menu", sub_menu.nama_sub_menu as "Sub Menu", sub_menu.url as "url" ,user_access_menu.'.$function.' as "allow_status"')
        ->from('level')
        ->join('user_access_menu','user_access_menu.level_id = level.level_id')
        ->join('sub_menu','sub_menu.sub_menu_id = user_access_menu.sub_menu_id','left')
        ->join('menu','sub_menu.menu_id = menu.menu_id','left')
        ->where('level.level_id',$level)
        ->where('url',$url);

    $result = $check->get()->row();

    if ($result->allow_status == 1) {
        if ($function == 'export') {
            $function = 'excel';
        }
        $icon = '';
        $class = '';
        if ($id_data) {
            if ($function == 'update') {
                $icon = '<i class="fa fa-pencil-square-o" aria-hidden="true"></i>';
                $class = 'class="btn btn-primary btn-sm"'; 
                echo anchor(site_url($url.'/'.$function.'/'.$id_data), $icon,$class);
            }
            if ($function == 'delete') {
                $icon = '<i class="fa fa-trash-o" aria-hidden="true"></i>';
                $class = 'class="btn btn-danger btn-sm"';   
                echo anchor(site_url($url.'/'.$function.'/'.$id_data), $icon,$class.' onclick="javascript: return confirm(\'Are You Sure ?\')"'); 
            }
            if ($function == 'read') {
                $icon = '<i class="fa fa-eye" aria-hidden="true"></i>';
                $class = 'class="btn btn-success btn-sm"';
                echo anchor(site_url($url.'/'.$function.'/'.$id_data), $icon,$class);   
            }
            if ($function == 'upload') {
                $icon = '<i class="fa fa-upload" aria-hidden="true"></i>';
                $class = 'class="btn btn-warning btn-sm"';
                echo anchor(site_url($url.'/'.$function.'/'.$id_data), $icon,$class);
            } 
            /*else {
                echo anchor(site_url($url.'/'.$function.'/'.$id_data), '<i class="fa fa-upload" aria-hidden="true"></i>','class="btn btn-warning btn-sm"'); 
                
                00.31, 11/07/2021
                can't add this because level settings not yet support this operation, it should be discussed sometimes 
                
                15:31, 11/07/2021
                nvm, working on it
            }*/
        }

        if ($id_data == NULL || $id_data == '') {
            if ($function == 'create') {
                $icon = $text ? '<i class="fa fa-wpforms" aria-hidden="true"></i> '.$text : '<i class="fa fa-wpforms" aria-hidden="true"></i> Tambah data';
                $class = 'class="btn btn-danger btn-sm"';
            }
            if ($function == 'excel') {
                $icon = '<i class="fa fa-file-excel-o" aria-hidden="true"></i> Export Ms Excel';
                $class = 'class="btn btn-success btn-sm"';
            }
            echo anchor(site_url($url.'/'.$function), $icon,$class);
        }
        
    } else {
        echo '';
    }
}

function fetchalladditionalaccess($level_id, $menu_id ){
    $ci = get_instance();
    $ci->db->select('additional_access');
    $ci->db->where('level_id', $level_id);
    $ci->db->where('sub_menu_id', $menu_id);
    $result = $ci->db->get('user_access_menu');
    
    return $result->row();
}