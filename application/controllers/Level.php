<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Level extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Level_model');
        $this->load->model('Menu_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        is_allowed($this->uri->segment(1),null);
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->uri->segment(3));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . '.php/c_url/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'index.php/level/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'index.php/level/index/';
            $config['first_url'] = base_url() . 'index.php/level/index/';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = FALSE;
        $config['total_rows'] = $this->Level_model->total_rows($q);
        $level = $this->Level_model->get_limit_data($config['per_page'], $start, $q);
        $config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin pull-right">';
        $config['full_tag_close'] = '</ul>';
        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'level_data' => $level,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'menu_accessed' => $this->uri->segment(1),
        );
        $this->template->load('template','level/level_list', $data);
    }

    public function read($id) 
    {
        is_allowed($this->uri->segment(1),'read');
        $row = $this->Level_model->get_by_id($id);
        if ($row) {
            $data = array(
		'level_id' => $row->level_id,
		'nama_level' => $row->nama_level,
	    );
            $this->template->load('template','level/level_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('level'));
        }
    }

     public function role($id)
    {
        is_allowed($this->uri->segment(1),'create');

        $data['role'] = $this->db->get_where('level', ['level_id' =>$id])->row_array();
        $data['row']= $this->Menu_model->get();
        $this->template->load('template','level/role',$data);
    }

    public function create() 
    {
        is_allowed($this->uri->segment(1),'create');
        $data = array(
            'button' => 'Create',
            'action' => site_url('level/create_action'),
	    'level_id' => set_value('level_id'),
	    'nama_level' => set_value('nama_level'),
	);
        $this->template->load('template','level/level_form', $data);
    }
    
    public function create_action() 
    {
        is_allowed($this->uri->segment(1),'create');
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'nama_level' => $this->input->post('nama_level',TRUE),
	    );

            $this->Level_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('level'));
        }
    }
    
    public function update($id) 
    {
        is_allowed($this->uri->segment(1),'update');
        $row = $this->Level_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('level/update_action'),
		'level_id' => set_value('level_id', $row->level_id),
		'nama_level' => set_value('nama_level', $row->nama_level),
	    );
            $this->template->load('template','level/level_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('level'));
        }
    }
    
    public function update_action() 
    {
        is_allowed($this->uri->segment(1),'update');
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('level_id', TRUE));
        } else {
            $data = array(
		'nama_level' => $this->input->post('nama_level',TRUE),
	    );

            $this->Level_model->update($this->input->post('level_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('level'));
        }
    }
    
    public function delete($id) 
    {
        is_allowed($this->uri->segment(1),'delete');
        $row = $this->Level_model->get_by_id($id);

        if ($row) {
            $this->Level_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('level'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('level'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('nama_level', 'nama level', 'trim|required');

	$this->form_validation->set_rules('level_id', 'level_id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        is_allowed($this->uri->segment(1),'export');
        $this->load->helper('exportexcel');
        $namaFile = "level.xls";
        $judul = "level";
        $tablehead = 0;
        $tablebody = 1;
        $nourut = 1;
        //penulisan header
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header("Content-Disposition: attachment;filename=" . $namaFile . "");
        header("Content-Transfer-Encoding: binary ");

        xlsBOF();

        $kolomhead = 0;
        xlsWriteLabel($tablehead, $kolomhead++, "No");
	xlsWriteLabel($tablehead, $kolomhead++, "Nama Level");

	foreach ($this->Level_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->nama_level);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=level.doc");

        $data = array(
            'level_data' => $this->Level_model->get_all(),
            'start' => 0
        );
        
        $this->load->view('level/level_doc',$data);
    }

    public function changeaccess_submenu(){
        $menu_id = $this->input->post('menuId');
        $level_id = $this->input->post('roleId');
        $namasubmenu = $this->input->post('namasubmenu');
        $namalevel = $this->input->post('namalevel');

        $data=[
            'level_id' =>$level_id,
            'sub_menu_id' =>$menu_id,
        ];

        $data2=[
            'level_id' =>$level_id,
            'sub_menu_id' =>$menu_id,
            'namasubmenu' => $namasubmenu,
            'namalevel' => $namalevel,
            'namamenu' => $this->input->post('namamenu')
        ];

        $result = $this->db->get_where('user_access_menu', $data);

        if ($result->num_rows() < 1) {
            $this->db->insert('user_access_menu', $data);
            echo $this->load->view('level/access_list_submenu',$data2, TRUE);
        }else{
            $this->db->delete('user_access_menu', $data);
            echo json_encode('deleted');
        }

    }

    public function changeaccess_read(){
        $menu_id = $this->input->post('menuId');
        $level_id = $this->input->post('roleId');

        $params=[
            'level_id' =>$level_id,
            'sub_menu_id' =>$menu_id
        ];
        $result = $this->db->get_where('user_access_menu', $params);
        $row = $result->row();
        if ($row->read == 1) {
            $data=[
            'read' =>0
        ];
        }else{
            $data=[
            'read' =>1
        ];
        }
        $this->db->where('level_id',$level_id);
        $this->db->where('sub_menu_id',$menu_id);
        $this->db->update('user_access_menu',$data);
    }

    public function changeaccess_create(){
        $menu_id = $this->input->post('menuId');
        $level_id = $this->input->post('roleId');

        $params=[
            'level_id' =>$level_id,
            'sub_menu_id' =>$menu_id
        ];
        $result = $this->db->get_where('user_access_menu', $params);
        $row = $result->row();
        if ($row->create == 1) {
            $data=[
            'create' =>0
        ];
        }else{
            $data=[
            'create' =>1
        ];
        }
        $this->db->where('level_id',$level_id);
        $this->db->where('sub_menu_id',$menu_id);
        $this->db->update('user_access_menu',$data);
    }

     public function changeaccess_update(){
        $menu_id = $this->input->post('menuId');
        $level_id = $this->input->post('roleId');

        $params=[
            'level_id' =>$level_id,
            'sub_menu_id' =>$menu_id
        ];
        $result = $this->db->get_where('user_access_menu', $params);
        $row = $result->row();
        if ($row->update == 1) {
            $data=[
            'update' =>0
        ];
        }else{
            $data=[
            'update' =>1
        ];
        }
        $this->db->where('level_id',$level_id);
        $this->db->where('sub_menu_id',$menu_id);
        $this->db->update('user_access_menu',$data);
    }

    public function changeaccess_delete(){
        $menu_id = $this->input->post('menuId');
        $level_id = $this->input->post('roleId');

        $params=[
            'level_id' =>$level_id,
            'sub_menu_id' =>$menu_id
        ];
        $result = $this->db->get_where('user_access_menu', $params);
        $row = $result->row();
        if ($row->delete == 1) {
            $data=[
            'delete' =>0
        ];
        }else{
            $data=[
            'delete' =>1
        ];
        }
        $this->db->where('level_id',$level_id);
        $this->db->where('sub_menu_id',$menu_id);
        $this->db->update('user_access_menu',$data);
    }

    public function changeaccess_export(){
        $menu_id = $this->input->post('menuId');
        $level_id = $this->input->post('roleId');

        $params=[
            'level_id' =>$level_id,
            'sub_menu_id' =>$menu_id
        ];
        $result = $this->db->get_where('user_access_menu', $params);
        $row = $result->row();
        if ($row->export == 1) {
            $data=[
            'export' =>0
        ];
        }else{
            $data=[
            'export' =>1
        ];
        }
        $this->db->where('level_id',$level_id);
        $this->db->where('sub_menu_id',$menu_id);
        $this->db->update('user_access_menu',$data);
    }

    public function custom_access_operation() {
        $menu_id = $this->input->post('submenuid');
        $level_id = $this->input->post('levelid');
        $nama_access = $this->input->post('access_name');
        $deskripsi_access = $this->input->post('access_description');
        $izinkan = $this->input->post('allowaccess');
        $operation = $this->input->post('operation');

        //print_r($params);
        $result = $this->Level_model->getids($level_id,$menu_id);
        
        $namasubm = $result->nama_sub_menu;
        $fetcheddata = trim($result->additional_access);


        //echo $fetcheddata."\n";
        //echo $namasubm;
        //echo "\n";
        //print_r($convertfromstdobjecttoassociativearray);
        if ($operation == 'add_custom_access') {
           $this->add_custom_access($menu_id, $level_id, $nama_access, $deskripsi_access, $izinkan, $operation, $fetcheddata,$namasubm);
        }
        
        // change status?
        else if($operation == 'change_custom_access_status') {
            $this->change_custom_access_status($menu_id, $level_id, $nama_access, $deskripsi_access, $izinkan, $operation, $fetcheddata,$namasubm);
        }

        // delete this operation?
        else
        {
            $this->delete_custom_access($menu_id, $level_id, $nama_access, $deskripsi_access, $izinkan, $operation, $fetcheddata,$namasubm);
        }
    }

    public function add_custom_access($menu_id, $level_id, $nama_access, $deskripsi_access, $izinkan, $operation, $fetcheddata,$namasubm) {
        if( strpos( $fetcheddata, $nama_access ) !== false) {
            $resp = array(
                'result' => 'no',
            );
            echo json_encode($resp);
        } else {

            $converted = strval($izinkan);
            $newdata = "#".$nama_access.";".$deskripsi_access.";".$converted;

            $appendeddata = $fetcheddata.$newdata;

            $data = [
                'additional_access' => $appendeddata,
            ];

            $this->db->where('level_id',$level_id);
            $this->db->where('sub_menu_id',$menu_id);
            $this->db->update('user_access_menu',$data);

            $o = ucfirst($namasubm);
            $bor = ucwords(strtolower($o));
            $trimmedsubmenuname = preg_replace('/\s+/', '', $bor);

            $resp = array(
                'result' => 'ok',
                'dataiwant' => $trimmedsubmenuname,
                'nama_access' => $nama_access
            );
            echo json_encode($resp);
        }
    }

    public function delete_custom_access($menu_id, $level_id, $nama_access, $deskripsi_access, $izinkan, $operation, $fetcheddata, $namasubm) {

        $preparedata = ltrim($fetcheddata,'#');
        //run detect
        if(strpos($fetcheddata, $nama_access) !== false) {
            
            $splitaccess = explode('#',$preparedata);
            
            //echo $preparedata;

            //put the old data first
            $arrayofaccess = $splitaccess;
            
            //let find the index first
            //echo $nama_access.';'.$deskripsi_access.';'.$izinkan; // will return index number
            $accessindex = array_search($nama_access.';'.$deskripsi_access.';'.trim($izinkan), $arrayofaccess);
            //lets remove it from the array by index we hef fown
            unset($arrayofaccess[$accessindex]);

            $p = $arrayofaccess;
            $joinnewdata = implode("#", $p);

            $b = '#'.$joinnewdata;

            $c = $b;

            if(strlen($c) < 3) {
                $c = '';
            }

            //echo $c;

            //echo $joinnewdata;
            //put thhe new data into anu
            $newdata = array(
                'additional_access' => $c,
            );

            $this->db->where('level_id',$level_id);
            $this->db->where('sub_menu_id',$menu_id);
            $this->db->update('user_access_menu',$newdata);

            //print_r($arrayofaccess);
            //print_r($splittedaccesslist);
            echo 'delete_succes';
        }
        //no data
        else
        {   
            echo "alreadydeleted";
        }
    }

    public function change_custom_access_status($menu_id, $level_id, $nama_access, $deskripsi_access, $izinkan, $operation, $fetcheddata, $namasubm) {
        
        $a = ltrim($fetcheddata,'#');

        $splitaccess = explode('#',$a);
        
        $arrayaccess = $splitaccess;

        //find the data
        $accessindex = array_search($nama_access.';'.$deskripsi_access.';'.trim($izinkan), $arrayaccess); 

        //echo 'before: '.$fetcheddata;
        //replace
        $updatestatusaccess = array(
            $accessindex => $nama_access.';'.$deskripsi_access.';'.trim($izinkan),
        );

        $arrayaccess = array_replace($arrayaccess, $updatestatusaccess);

        //echo 'after: '.$arrayaccess[$accessindex];
        

        //echo 'after: '.$arrayaccess[0].';'.$arrayaccess[1].';'.$arrayaccess[2];
        //echo json_encode($arrayofaccess[$accessindex]);
        //unset($arrayofaccess[$accessindex]);
        $joinnewdata = implode('#',$arrayaccess);
        //echo "\n";
        //echo 'after :'.$joinnewdata;

        $dta = array(
            'additional_access' => '#'.$joinnewdata
        );
        
        $this->db->where('level_id',$level_id);
        $this->db->where('sub_menu_id',$menu_id);
        $this->db->update('user_access_menu',$dta);
        echo json_encode('ok');
    }

    public function getdataaccesslist() {
        $menu_id = $this->input->post('submenuid');
        $level_id = $this->input->post('levelid');

        $listofacc = fetchallavailableaccessforsubmenu($level_id, $menu_id);

        echo json_encode($listofacc);

    }

    public function checklink() {
        //$namamenu = $this->input->post('namamenu');
        $level_id = $this->input->post('levelid');
        $menu_id = $this->input->post('submenuid');
        $method = $this->input->post('operation'); 

        //let's find out what the URL is

        $controllerName = fetchallurl($level_id, $menu_id);


        //change it to uppercase first
        $changetouppercase = ucfirst($controllerName->url);

        // let's go to controller path using the URL we got!
        $controllerPath = APPPATH . "controllers/".$changetouppercase.".php";

        //check if the controller is exists
        if(file_exists($controllerPath)){

            //let's dive in and check if the controller has those method/operation u call it?
            require_once $controllerPath;
            if(method_exists($changetouppercase, $method)){
                echo json_encode('ok');
            } else {
                echo json_encode('nomethod');
            }
        }
        else
        {
            echo 'nocontroller';
        }
    }
}

/* End of file Level.php */
/* Location: ./application/controllers/Level.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-06-28 13:00:38 */
/* http://harviacode.com */