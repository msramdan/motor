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

function cekstatuscicilan($invoice)
{
    $ci = get_instance();
    $ci->db->select('jatuh_tempo, tanggal_dibayar');
    $ci->db->where('sale_id', $invoice);
    return $ci->db->get('sale_detail')->result_array();
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

//block injeck url id setiap item
function block(){
    $ci =& get_instance();
    $ci->load->library('fungsi');
        $user_id = $ci->fungsi->user_login()->user_id;
        $unit_id = $ci->session->userdata('unit_id');
        $userAccess = $ci->db->get_where('user_access_unit', ['user_id' =>$user_id, 'unit_id' => $unit_id]);
        
            if ($userAccess->num_rows() < 1) {
                redirect('not_access');
            }
    }

function show_button($url,$function,$id_data = NULL, $text = NULL, $icon = NULL) {
    $ci =& get_instance();
    
    $ci->load->library('fungsi');
    $level = $ci->fungsi->user_login()->level_id;

    if($function == 'export' || $function == 'create' || $function == 'read' || $function == 'delete' || $function == 'update') {
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
    //other than having function above, soo using customized function name would be like this
    else
    {
        $arraywhere = array(
            'level.level_id'    => $level,
            'sub_menu.url'      => $url
        );

        $check = $ci->db->select('user_access_menu.additional_access as "additional_access"')
        ->from('level')
        ->join('user_access_menu','user_access_menu.level_id = level.level_id')
        ->join('sub_menu','sub_menu.sub_menu_id = user_access_menu.sub_menu_id')
        ->join('menu','sub_menu.menu_id = menu.menu_id')
        ->where($arraywhere);

        $result = $check->get()->row();

        $trim = ltrim($result->additional_access,'#');

        $splitaccess = explode('#',$trim);

        if ($id_data) {
            foreach($splitaccess as $v) {
                $e = explode(';',$v);
                if ($e[0] === $function) {
                    if ($e[2] == 1) {
                        return anchor(site_url($url.'/'.$function.'/'.$id_data), '<i class="fa '.$icon.'" aria-hidden="true"></i>','class="btn btn-warning btn-sm"');
                    }
                }
            }
        }

        if ($id_data === '' || $id_data === NULL) {
            foreach($splitaccess as $v) {
                $e = explode(';',$v);
                if ($e[0] === $function) {
                    if($e[2] == 1) {
                        return anchor(site_url($url.'/'.$function), '<i class="fa '.$icon.'" aria-hidden="true"></i>','class="btn btn-warning btn-sm"');
                    }
                }
            }
        }

        return '';
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

function fetchallurl($level_id, $menu_id ){
    $ci = get_instance();
    $ci->db->select('url')
        ->from('user_access_menu')
        ->join('sub_menu','sub_menu.sub_menu_id=user_access_menu.sub_menu_id')
        ->where('level_id', $level_id)
        ->where('sub_menu.sub_menu_id', $menu_id);
    $result = $ci->db->get();
    
    return $result->row();
}

function fetchallavailableaccessforsubmenu($level_id, $menu_id ){
    $ci = get_instance();
    $ci->db->select('additional_access');
    $ci->db->distinct();
    $ci->db->join('sub_menu','sub_menu.sub_menu_id = user_access_menu.sub_menu_id');
    $ci->db->where('level_id', $level_id);
    $ci->db->where('user_access_menu.sub_menu_id', $menu_id);
    $result = $ci->db->get('user_access_menu')->row();

    //$resu = array();

    /*foreach($result as $o) {
        $resu = $o->url;
    }*/

    //return $resu;
    //$anu = implode('-', $resu);

    $splitaccess = explode('#', $result->additional_access);

    $secondaryarray = array();

    //$tot = count($secondaryarray);

    foreach ($splitaccess as $key => $value) {

        $splitagain = explode(';', $value);

        $secondaryarray[] = $splitagain[0];
    }

    $joinallaccessintosinglestring = implode('-',$secondaryarray);

    
    //$thirdarray = array_slice($secondaryarray,5,count($secondaryarray)-5, true);

    //$tot = count($secondaryarray);


    //$thirdarray = array();
    //$getaccessname = array_values(array_slice($splitaccessdetail, 0, 1));
    /*for ($i=1; $i < $tot; $i++) { 
        $thirdarray[] = $secondaryarray[$i+3];
    }*/
    return ltrim($joinallaccessintosinglestring,'-');
}

function penyebut($nilai) {
    $nilai = abs($nilai);
    $huruf = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
    $temp = "";
    if ($nilai < 12) {
        $temp = " ". $huruf[$nilai];
    } else if ($nilai <20) {
        $temp = penyebut($nilai - 10). " Belas";
    } else if ($nilai < 100) {
        $temp = penyebut($nilai/10)." Puluh". penyebut($nilai % 10);
    } else if ($nilai < 200) {
        $temp = " Seratus" . penyebut($nilai - 100);
    } else if ($nilai < 1000) {
        $temp = penyebut($nilai/100) . " Ratus" . penyebut($nilai % 100);
    } else if ($nilai < 2000) {
        $temp = " seribu" . penyebut($nilai - 1000);
    } else if ($nilai < 1000000) {
        $temp = penyebut($nilai/1000) . " Ribu" . penyebut($nilai % 1000);
    } else if ($nilai < 1000000000) {
        $temp = penyebut($nilai/1000000) . " Juta" . penyebut($nilai % 1000000);
    } else if ($nilai < 1000000000000) {
        $temp = penyebut($nilai/1000000000) . " Milyar" . penyebut(fmod($nilai,1000000000));
    } else if ($nilai < 1000000000000000) {
        $temp = penyebut($nilai/1000000000000) . " Trilyun" . penyebut(fmod($nilai,1000000000000));
    }     
    return $temp;
}

function terbilang($nilai) {
    if($nilai<0) {
        $hasil = "minus ". trim(penyebut($nilai));
    } else {
        $hasil = trim(penyebut($nilai));
    }           
    return $hasil;
}



function date_indo($tgl)
{
    $ubah = gmdate($tgl, time()+60*60*8);
    $pecah = explode("-",$ubah);
    $tanggal = $pecah[2];
    $bulan = bulan($pecah[1]);
    $tahun = $pecah[0];
    return $tanggal.' '.$bulan.' '.$tahun;
}

function bulan($bln)
{
    switch ($bln)
    {
        case 1:
            return "Januari";
            break;
        case 2:
            return "Februari";
            break;
        case 3:
            return "Maret";
            break;
        case 4:
            return "April";
            break;
        case 5:
            return "Mei";
            break;
        case 6:
            return "Juni";
            break;
        case 7:
            return "Juli";
            break;
        case 8:
            return "Agustus";
            break;
        case 9:
            return "September";
            break;
        case 10:
            return "Oktober";
            break;
        case 11:
            return "November";
            break;
        case 12:
            return "Desember";
            break;
    }
}

function shortdate_indo($tgl)
{
    $ubah = gmdate($tgl, time()+60*60*8);
    $pecah = explode("-",$ubah);
    $tanggal = $pecah[2];
    $bulan = short_bulan($pecah[1]);
    $tahun = $pecah[0];
    return $tanggal.'/'.$bulan.'/'.$tahun;
}

function short_bulan($bln)
{
    switch ($bln)
    {
        case 1:
            return "01";
            break;
        case 2:
            return "02";
            break;
        case 3:
            return "03";
            break;
        case 4:
            return "04";
            break;
        case 5:
            return "05";
            break;
        case 6:
            return "06";
            break;
        case 7:
            return "07";
            break;
        case 8:
            return "08";
            break;
        case 9:
            return "09";
            break;
        case 10:
            return "10";
            break;
        case 11:
            return "11";
            break;
        case 12:
            return "12";
            break;
    }
}

function mediumdate_indo($tgl)
{
    $ubah = gmdate($tgl, time()+60*60*8);
    $pecah = explode("-",$ubah);
    $tanggal = $pecah[2];
    $bulan = medium_bulan($pecah[1]);
    $tahun = $pecah[0];
    return $tanggal.'-'.$bulan.'-'.$tahun;
}

function medium_bulan($bln)
{
    switch ($bln)
    {
        case 1:
            return "Jan";
            break;
        case 2:
            return "Feb";
            break;
        case 3:
            return "Mar";
            break;
        case 4:
            return "Apr";
            break;
        case 5:
            return "Mei";
            break;
        case 6:
            return "Jun";
            break;
        case 7:
            return "Jul";
            break;
        case 8:
            return "Ags";
            break;
        case 9:
            return "Sep";
            break;
        case 10:
            return "Okt";
            break;
        case 11:
            return "Nov";
            break;
        case 12:
            return "Des";
            break;
    }
}

function longdate_indo($tanggal)
{
    $ubah = gmdate($tanggal, time()+60*60*8);
    $pecah = explode("-",$ubah);
    $tgl = $pecah[2];
    $bln = $pecah[1];
    $thn = $pecah[0];
    $bulan = bulan($pecah[1]);

    $nama = date("l", mktime(0,0,0,$bln,$tgl,$thn));
    $nama_hari = "";
    if($nama=="Sunday") {$nama_hari="Minggu";}
    else if($nama=="Monday") {$nama_hari="Senin";}
    else if($nama=="Tuesday") {$nama_hari="Selasa";}
    else if($nama=="Wednesday") {$nama_hari="Rabu";}
    else if($nama=="Thursday") {$nama_hari="Kamis";}
    else if($nama=="Friday") {$nama_hari="Jumat";}
    else if($nama=="Saturday") {$nama_hari="Sabtu";}
    return $nama_hari.','.$tgl.' '.$bulan.' '.$thn;
}