<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sub_unit extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Sub_unit_model');
        $this->load->model('Unit_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        is_allowed($this->uri->segment(1),null);
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->uri->segment(3));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . '.php/c_url/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'index.php/sub_unit/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'index.php/sub_unit/index/';
            $config['first_url'] = base_url() . 'index.php/sub_unit/index/';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = FALSE;
        $config['total_rows'] = $this->Sub_unit_model->total_rows($q);
        $sub_unit = $this->Sub_unit_model->get_limit_data($config['per_page'], $start, $q);
        $config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin pull-right">';
        $config['full_tag_close'] = '</ul>';
        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'sub_unit_data' => $sub_unit,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->template->load('template','sub_unit/sub_unit_list', $data);
    }

    public function read($id) 
    {
        is_allowed($this->uri->segment(1),'read');
        $row = $this->Sub_unit_model->get_by_id($id);
        if ($row) {
            $data = array(
		'sub_unit_id' => $row->sub_unit_id,
		'unit_id' => $row->unit_id,
		'nama_sub_unit' => $row->nama_sub_unit,
	    );
            $this->template->load('template','sub_unit/sub_unit_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('sub_unit'));
        }
    }

    public function create() 
    {
        is_allowed($this->uri->segment(1),'create');
        $data = array(
            'button' => 'Create',
            'kodeunik' =>$this->Sub_unit_model->buat_kode(),
            'unit' =>$this->Unit_model->get_all(),
            'action' => site_url('sub_unit/create_action'),
	    'sub_unit_id' => set_value('sub_unit_id'),
        'kd_sub_unit' => set_value('kd_sub_unit'),
	    'unit_id' => set_value('unit_id'),
	    'nama_sub_unit' => set_value('nama_sub_unit'),
	);
        $this->template->load('template','sub_unit/sub_unit_form', $data);
    }
    
    public function create_action() 
    {
        is_allowed($this->uri->segment(1),'create');
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $unit_id = $this->input->post('unit_id');
            $cek = $this->db->get_where('unit', ['unit_id' =>$unit_id])->row_array();

            // var_dump($cek['kd_unit']);
            // exit();
            $q = $this->db->query("SELECT MAX(RIGHT(kd_sub_unit,3)) AS kd_max FROM sub_unit WHERE unit_id='$unit_id'");
            $kd = "";
            if($q->num_rows()>0){
                foreach($q->result() as $k){
                    $tmp = ((int)$k->kd_max)+1;
                    $kd = sprintf("%03s", $tmp);
                    $buat_kode = $cek['kd_unit'].$kd;
                }
            }else{
                $kd = "001";
                $buat_kode = $cek['kd_unit'].$kd;
            }



            $data = array(
		'kd_sub_unit' => $buat_kode,
        'unit_id' => $this->input->post('unit_id',TRUE),
		'nama_sub_unit' => $this->input->post('nama_sub_unit',TRUE),
	    );

            $this->Sub_unit_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('sub_unit'));
        }
    }
    
    public function update($id) 
    {
        is_allowed($this->uri->segment(1),'update');
        $row = $this->Sub_unit_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'unit' =>$this->Unit_model->get_all(),
                'action' => site_url('sub_unit/update_action'),
		'sub_unit_id' => set_value('sub_unit_id', $row->sub_unit_id),
        'kd_sub_unit' => set_value('kd_sub_unit', $row->kd_sub_unit),
		'unit_id' => set_value('unit_id', $row->unit_id),
		'nama_sub_unit' => set_value('nama_sub_unit', $row->nama_sub_unit),
	    );
            $this->template->load('template','sub_unit/sub_unit_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('sub_unit'));
        }
    }
    
    public function update_action() 
    {
        is_allowed($this->uri->segment(1),'update');
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('sub_unit_id', TRUE));
        } else {
            $data = array(
                'kd_sub_unit' => $this->input->post('kd_sub_unit',TRUE),
		'unit_id' => $this->input->post('unit_id',TRUE),
		'nama_sub_unit' => $this->input->post('nama_sub_unit',TRUE),
	    );

            $this->Sub_unit_model->update($this->input->post('sub_unit_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('sub_unit'));
        }
    }
    
    public function delete($id) 
    {
        is_allowed($this->uri->segment(1),'delete');
        $row = $this->Sub_unit_model->get_by_id($id);

        if ($row) {
            $this->Sub_unit_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('sub_unit'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('sub_unit'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('unit_id', 'unit id', 'trim|required');
	$this->form_validation->set_rules('nama_sub_unit', 'nama sub unit', 'trim|required');

	$this->form_validation->set_rules('sub_unit_id', 'sub_unit_id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        is_allowed($this->uri->segment(1),'export');
        $this->load->helper('exportexcel');
        $namaFile = "sub_unit.xls";
        $judul = "sub_unit";
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
	xlsWriteLabel($tablehead, $kolomhead++, "Unit Id");
	xlsWriteLabel($tablehead, $kolomhead++, "Nama Sub Unit");

	foreach ($this->Sub_unit_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteNumber($tablebody, $kolombody++, $data->unit_id);
	    xlsWriteLabel($tablebody, $kolombody++, $data->nama_sub_unit);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

}

/* End of file Sub_unit.php */
/* Location: ./application/controllers/Sub_unit.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-07-06 10:11:15 */
/* http://harviacode.com */