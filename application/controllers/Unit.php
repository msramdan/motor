<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Unit extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Grup_model');
        $this->load->model('Unit_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->uri->segment(3));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . '.php/c_url/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'index.php/unit/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'index.php/unit/index/';
            $config['first_url'] = base_url() . 'index.php/unit/index/';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = FALSE;
        $config['total_rows'] = $this->Unit_model->total_rows($q);
        $unit = $this->Unit_model->get_limit_data($config['per_page'], $start, $q);
        $config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin pull-right">';
        $config['full_tag_close'] = '</ul>';
        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'unit_data' => $unit,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'menu_accessed' => $this->uri->segment(1),
        );
        $this->template->load('template','unit/unit_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Unit_model->get_by_id($id);
        if ($row) {
            $data = array(
		'unit_id' => $row->unit_id,
		'grup_id' => $row->grup_id,
		'nama_unit' => $row->nama_unit,
	    );
            $this->template->load('template','unit/unit_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('unit'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'kodeunik' =>$this->Unit_model->buat_kode(),
            'grup' =>$this->Grup_model->get_all(),
            'action' => site_url('unit/create_action'),
	    'unit_id' => set_value('unit_id'),
        'kd_unit' => set_value('kd_unit'),
	    'grup_id' => set_value('grup_id'),
	    'nama_unit' => set_value('nama_unit'),
	);
        $this->template->load('template','unit/unit_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $grup_id = $this->input->post('grup_id');
            $cek = $this->db->get_where('grup', ['grup_id' =>$grup_id])->row_array();
            $q = $this->db->query("SELECT MAX(RIGHT(kd_unit,3)) AS kd_max FROM unit WHERE grup_id='$grup_id'");
            $kd = "";
            if($q->num_rows()>0){
                foreach($q->result() as $k){
                    $tmp = ((int)$k->kd_max)+1;
                    $kd = sprintf("%03s", $tmp);
                    $buat_kode = $cek['kd_grup'].$kd;
                }
            }else{
                $kd = "001";
                $buat_kode = $cek['kd_grup'].$kd;
            }



            $data = array(
        'kd_unit' => $buat_kode,
		'grup_id' => $this->input->post('grup_id',TRUE),
		'nama_unit' => $this->input->post('nama_unit',TRUE),
	    );

            $this->Unit_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('unit'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Unit_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'grup' =>$this->Grup_model->get_all(),
                'action' => site_url('unit/update_action'),
		'unit_id' => set_value('unit_id', $row->unit_id),
        'kd_unit' => set_value('kd_unit', $row->kd_unit),
		'grup_id' => set_value('grup_id', $row->grup_id),
		'nama_unit' => set_value('nama_unit', $row->nama_unit),
	    );
            $this->template->load('template','unit/unit_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('unit'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('unit_id', TRUE));
        } else {
            $data = array(
                'kd_unit' => $this->input->post('kd_unit',TRUE),
		'grup_id' => $this->input->post('grup_id',TRUE),
		'nama_unit' => $this->input->post('nama_unit',TRUE),
	    );

            $this->Unit_model->update($this->input->post('unit_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('unit'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Unit_model->get_by_id($id);

        if ($row) {
            $this->Unit_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('unit'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('unit'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('grup_id', 'grup id', 'trim|required');
	$this->form_validation->set_rules('nama_unit', 'nama unit', 'trim|required');

	$this->form_validation->set_rules('unit_id', 'unit_id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "unit.xls";
        $judul = "unit";
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
	xlsWriteLabel($tablehead, $kolomhead++, "Grup Id");
	xlsWriteLabel($tablehead, $kolomhead++, "Nama Unit");

	foreach ($this->Unit_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteNumber($tablebody, $kolombody++, $data->grup_id);
	    xlsWriteLabel($tablebody, $kolombody++, $data->nama_unit);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

}

/* End of file Unit.php */
/* Location: ./application/controllers/Unit.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-07-06 10:09:22 */
/* http://harviacode.com */