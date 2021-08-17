<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pelanggan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Pelanggan_model');
        $this->load->library('form_validation');
        $this->load->library('pdf');
    }

    public function index()
    {

        is_allowed($this->uri->segment(1),null);
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->uri->segment(3));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . '.php/c_url/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'index.php/pelanggan/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'index.php/pelanggan/index/';
            $config['first_url'] = base_url() . 'index.php/pelanggan/index/';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = FALSE;
        $config['total_rows'] = $this->Pelanggan_model->total_rows($q);
        $pelanggan = $this->Pelanggan_model->get_limit_data($config['per_page'], $start, $q);
        $config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin pull-right">';
        $config['full_tag_close'] = '</ul>';
        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'pelanggan_data' => $pelanggan,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'menu_accessed' => $this->uri->segment(1),
        );
        $this->template->load('template','pelanggan/pelanggan_list', $data);
    }

    public function read($id) 
    {
        block();
        is_allowed($this->uri->segment(1),'read');
        $id = decrypt_url($id);
        $row = $this->Pelanggan_model->get_by_id($id);
        if ($row) {
            $data = array(
    		'pelanggan_id' => $row->pelanggan_id,
            'berkas' =>$this->Pelanggan_model->get_berkas($id),
    		'no_ktp' => $row->no_ktp,
    		'no_kk' => $row->no_kk,
    		'nama_pelanggan' => $row->nama_pelanggan,
    		'no_hp_pelanggan' => $row->no_hp_pelanggan,
    		'jenis_kelamin' => $row->jenis_kelamin,
    		'alamat_ktp' => $row->alamat_ktp,
    		'alamat_domisili' => $row->alamat_domisili,
    		'nama_saudara' => $row->nama_saudara,
    		'alamat_saudara' => $row->alamat_saudara,
    		'no_hp_saudara' => $row->no_hp_saudara,
	    );
            $this->template->load('template','pelanggan/pelanggan_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('pelanggan'));
        }
    }

    public function create() 
    {
        is_allowed($this->uri->segment(1),'create');
        $data = array(
            'button' => 'Create',
            'action' => site_url('pelanggan/create_action'),
	    'pelanggan_id' => set_value('pelanggan_id'),
	    'no_ktp' => set_value('no_ktp'),
	    'no_kk' => set_value('no_kk'),
	    'nama_pelanggan' => set_value('nama_pelanggan'),
	    'no_hp_pelanggan' => set_value('no_hp_pelanggan'),
	    'jenis_kelamin' => set_value('jenis_kelamin'),
	    'alamat_ktp' => set_value('alamat_ktp'),
	    'alamat_domisili' => set_value('alamat_domisili'),
	    'nama_saudara' => set_value('nama_saudara'),
	    'alamat_saudara' => set_value('alamat_saudara'),
	    'no_hp_saudara' => set_value('no_hp_saudara'),
	);
        $this->template->load('template','pelanggan/pelanggan_form', $data);
    }
    
    public function create_action() 
    {
        is_allowed($this->uri->segment(1),'create');
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'no_ktp' => $this->input->post('no_ktp',TRUE),
        'unit_id' => $this->input->post('unit_id',TRUE),
		'no_kk' => $this->input->post('no_kk',TRUE),
		'nama_pelanggan' => $this->input->post('nama_pelanggan',TRUE),
		'no_hp_pelanggan' => $this->input->post('no_hp_pelanggan',TRUE),
		'jenis_kelamin' => $this->input->post('jenis_kelamin',TRUE),
		'alamat_ktp' => $this->input->post('alamat_ktp',TRUE),
		'alamat_domisili' => $this->input->post('alamat_domisili',TRUE),
		'nama_saudara' => $this->input->post('nama_saudara',TRUE),
		'alamat_saudara' => $this->input->post('alamat_saudara',TRUE),
		'no_hp_saudara' => $this->input->post('no_hp_saudara',TRUE),
	    );

            $this->Pelanggan_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('pelanggan'));
        }
    }
    
    public function update($id) 
    {
        is_allowed($this->uri->segment(1),'update');
        $id = decrypt_url($id);
        $row = $this->Pelanggan_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('pelanggan/update_action'),
		'pelanggan_id' => set_value('pelanggan_id', $row->pelanggan_id),
		'no_ktp' => set_value('no_ktp', $row->no_ktp),
		'no_kk' => set_value('no_kk', $row->no_kk),
        'unit_id' => set_value('unit_id', $row->unit_id),
		'nama_pelanggan' => set_value('nama_pelanggan', $row->nama_pelanggan),
		'no_hp_pelanggan' => set_value('no_hp_pelanggan', $row->no_hp_pelanggan),
		'jenis_kelamin' => set_value('jenis_kelamin', $row->jenis_kelamin),
		'alamat_ktp' => set_value('alamat_ktp', $row->alamat_ktp),
		'alamat_domisili' => set_value('alamat_domisili', $row->alamat_domisili),
		'nama_saudara' => set_value('nama_saudara', $row->nama_saudara),
		'alamat_saudara' => set_value('alamat_saudara', $row->alamat_saudara),
		'no_hp_saudara' => set_value('no_hp_saudara', $row->no_hp_saudara),
	    );
            $this->template->load('template','pelanggan/pelanggan_form_update', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('pelanggan'));
        }
    }
    
    public function update_action() 
    {
        is_allowed($this->uri->segment(1),'update');
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('pelanggan_id', TRUE));
        } else {
            $data = array(
		'no_ktp' => $this->input->post('no_ktp',TRUE),
		'no_kk' => $this->input->post('no_kk',TRUE),
		'nama_pelanggan' => $this->input->post('nama_pelanggan',TRUE),
		'no_hp_pelanggan' => $this->input->post('no_hp_pelanggan',TRUE),
		'jenis_kelamin' => $this->input->post('jenis_kelamin',TRUE),
		'alamat_ktp' => $this->input->post('alamat_ktp',TRUE),
		'alamat_domisili' => $this->input->post('alamat_domisili',TRUE),
		'nama_saudara' => $this->input->post('nama_saudara',TRUE),
		'alamat_saudara' => $this->input->post('alamat_saudara',TRUE),
		'no_hp_saudara' => $this->input->post('no_hp_saudara',TRUE),
        'unit_id' => $this->input->post('unit_id',TRUE),
	    );

            $this->Pelanggan_model->update($this->input->post('pelanggan_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('pelanggan'));
        }
    }
    
    public function delete($id) 
    {
        is_allowed($this->uri->segment(1),'delete');
        $id = decrypt_url($id);
        $row = $this->Pelanggan_model->get_by_id($id);
        if ($row) {
            $this->Pelanggan_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('pelanggan'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('pelanggan'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('no_ktp', 'no ktp', 'trim|required');
	$this->form_validation->set_rules('no_kk', 'no kk', 'trim|required');
	$this->form_validation->set_rules('nama_pelanggan', 'nama pelanggan', 'trim|required');
	$this->form_validation->set_rules('no_hp_pelanggan', 'no hp pelanggan', 'trim|required');
	$this->form_validation->set_rules('jenis_kelamin', 'jenis kelamin', 'trim|required');
	$this->form_validation->set_rules('alamat_ktp', 'alamat ktp', 'trim|required');
	$this->form_validation->set_rules('alamat_domisili', 'alamat domisili', 'trim|required');
	$this->form_validation->set_rules('nama_saudara', 'nama saudara', 'trim|required');
	$this->form_validation->set_rules('alamat_saudara', 'alamat saudara', 'trim|required');
	$this->form_validation->set_rules('no_hp_saudara', 'no hp saudara', 'trim|required');

	$this->form_validation->set_rules('pelanggan_id', 'pelanggan_id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        is_allowed($this->uri->segment(1),'export');
        $this->load->helper('exportexcel');
        $namaFile = "pelanggan.xls";
        $judul = "pelanggan";
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
    	xlsWriteLabel($tablehead, $kolomhead++, "No Ktp");
    	xlsWriteLabel($tablehead, $kolomhead++, "No Kk");
    	xlsWriteLabel($tablehead, $kolomhead++, "Nama Pelanggan");
    	xlsWriteLabel($tablehead, $kolomhead++, "No Hp Pelanggan");
    	xlsWriteLabel($tablehead, $kolomhead++, "Jenis Kelamin");
    	xlsWriteLabel($tablehead, $kolomhead++, "Alamat Ktp");
    	xlsWriteLabel($tablehead, $kolomhead++, "Alamat Domisili");
    	xlsWriteLabel($tablehead, $kolomhead++, "Nama Saudara");
    	xlsWriteLabel($tablehead, $kolomhead++, "Alamat Saudara");
    	xlsWriteLabel($tablehead, $kolomhead++, "No Hp Saudara");

    	foreach ($this->Pelanggan_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
    	    xlsWriteLabel($tablebody, $kolombody++, $data->no_ktp);
    	    xlsWriteLabel($tablebody, $kolombody++, $data->no_kk);
    	    xlsWriteLabel($tablebody, $kolombody++, $data->nama_pelanggan);
    	    xlsWriteLabel($tablebody, $kolombody++, $data->no_hp_pelanggan);
    	    xlsWriteLabel($tablebody, $kolombody++, $data->jenis_kelamin);
    	    xlsWriteLabel($tablebody, $kolombody++, $data->alamat_ktp);
    	    xlsWriteLabel($tablebody, $kolombody++, $data->alamat_domisili);
    	    xlsWriteLabel($tablebody, $kolombody++, $data->nama_saudara);
    	    xlsWriteLabel($tablebody, $kolombody++, $data->alamat_saudara);
    	    xlsWriteLabel($tablebody, $kolombody++, $data->no_hp_saudara);

    	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function cetak($id)
    {
        $berkas = $this->Pelanggan_model->get_berkas(decrypt_url($id))->result();
        $data = $this->Pelanggan_model->get_by_id(decrypt_url($id));
        if ($data) {
            $pdf = new FPDF('p','mm','A4');

            $pdf->AddPage();

            $pdf->setXY(0, 40);
            $pdf->SetFont('Arial','B',16);$pdf->Cell(0,7,'DATA PELANGGAN',0,0,'C');
            
            $pdf->setY(60);
            $pdf->SetFont('Arial','',11);
            $pdf->Cell(10,8,'1.',0,0,'L');
            $pdf->Cell(50,8,'No. KTP',0,0,'L');
            $pdf->Cell(4,8,':',0,0,'L');
            $pdf->Cell(100,8,$data->no_ktp,0,1,'L');
            $pdf->Cell(10,8,'2.',0,0,'L');
            $pdf->Cell(50,8,'No. KK',0,0,'L');
            $pdf->Cell(4,8,':',0,0,'L');
            $pdf->Cell(100,8,$data->no_kk,0,1,'L');
            $pdf->Cell(10,8,'3.',0,0,'L');
            $pdf->Cell(50,8,'Nama Pelanggan',0,0,'L');
            $pdf->Cell(4,8,':',0,0,'L');
            $pdf->Cell(100,8,$data->nama_pelanggan,0,1,'L');
            $pdf->Cell(10,8,'4.',0,0,'L');
            $pdf->Cell(50,8,'No. HP Pelanggan',0,0,'L');
            $pdf->Cell(4,8,':',0,0,'L');
            $pdf->Cell(100,8,$data->no_hp_pelanggan,0,1,'L');
            $pdf->Cell(10,8,'5.',0,0,'L');
            $pdf->Cell(50,8,'Jenis Kelamin',0,0,'L');
            $pdf->Cell(4,8,':',0,0,'L');
            $pdf->Cell(100,8,$data->jenis_kelamin,0,1,'L');
            $pdf->Cell(10,8,'6.',0,0,'L');
            $pdf->Cell(50,8,'Alamat KTP',0,0,'L');
            $pdf->Cell(4,8,':',0,0,'L');
            $pdf->Cell(100,8,$data->alamat_ktp,0,1,'L');
            $pdf->Cell(10,8,'7.',0,0,'L');
            $pdf->Cell(50,8,'Alamat Domisili',0,0,'L');
            $pdf->Cell(4,8,':',0,0,'L');
            $pdf->Cell(100,8,$data->alamat_domisili,0,1,'L');
            $pdf->Cell(10,8,'8.',0,0,'L');
            $pdf->Cell(50,8,'Nama Saudara',0,0,'L');
            $pdf->Cell(4,8,':',0,0,'L');
            $pdf->Cell(100,8,$data->nama_saudara,0,1,'L');
            $pdf->Cell(10,8,'9.',0,0,'L');
            $pdf->Cell(50,8,'Alamat Saudara',0,0,'L');
            $pdf->Cell(4,8,':',0,0,'L');
            $pdf->Cell(100,8,$data->alamat_saudara,0,1,'L');
            $pdf->Cell(10,8,'10.',0,0,'L');
            $pdf->Cell(50,8,'No. HP Saudara',0,0,'L');
            $pdf->Cell(4,8,':',0,0,'L');
            $pdf->Cell(100,8,$data->no_hp_saudara,0,1,'L');
            $pdf->Cell(10,8,'11.',0,0,'L');
            $pdf->Cell(50,8,'Kelengkapan Berkas',0,0,'L');
            $pdf->Cell(4,8,':',0,0,'L');
            $pdf->Cell(50,8,'',0,1,'L');
            
            if (!empty($berkas)) {
                foreach($berkas as $key => $p) {
                    $pdf->setX(30);
                    $pdf->Cell(50,10,$p->nama_berkas,0,0,'L');
                    $pdf->Image(base_url().'/assets/img/checkmark.png',$pdf->GetX()-55, $pdf->GetY()+2.8,4,4);
                    $pdf->Cell(50,10,'',0,1,'L');
                }   
            } else {
                $pdf->setX(40);
                $pdf->Cell(50,8,'Belum ada berkas',0,0,'L');
            }

            $pdf->setXY(130, 220);
            $pdf->Cell(50,10,'Mengetahui',0,2,'C');
            $pdf->Cell(50,30,'',0,2,'C');
            $pdf->Cell(50,10,'(_______________________)',0,2,'C');

            $pdf->Output('pelanggan'.$data->pelanggan_id.'.pdf', 'D');
        } else {
            echo 'no data';
        }
    }

    public function download_berkas($gambar){
        force_download('assets/img/berkas/'.$gambar,NULL);
    }

    public function upload($id){
        $id = decrypt_url($id);
        is_allowed($this->uri->segment(1),'create');  
        $this->template->load('template','pelanggan/upload');
    }


    // public function action_update_harga(){
    //     $nama_harga    = $_POST['nama_harga'];
    //     $nominal       = $_POST['nominal'];
    //     $item_id       = $_POST['item_id'];
    //     $jumlah_data = count($nama_harga);
    // for($i = 0; $i < $jumlah_data;$i++)
    //     {       
    //                 $data['nama_harga'] = $nama_harga[$i];
    //                 $data['nominal'] = $nominal[$i];
    //                 $data['item_id'] = $item_id[$i];
    //                 $this->db->insert('harga',$data);
    //     }
    //     redirect(site_url('item'));
    // }

    public function upload_berkas(){
        $nama               = $_POST['nama_berkas'];
        $pelanggan_id       = $_POST['pelanggan_id'];         
        $config['upload_path']          = './assets/img/berkas'; 
        $config['allowed_types']        = 'jpg|png|pdf|docx|doc';
        $config['max_size']             = 10000;
        $config['encrypt_name']         = true;
        $this->load->library('upload',$config);
        
        $jumlah_data = count($pelanggan_id);

        for($i = 0; $i < $jumlah_data;$i++)
        {
            if(!empty($_FILES['berkas']['name'][$i])){
 
                $_FILES['file']['name'] = $_FILES['berkas']['name'][$i];
                $_FILES['file']['type'] = $_FILES['berkas']['type'][$i];
                $_FILES['file']['tmp_name'] = $_FILES['berkas']['tmp_name'][$i];
                $_FILES['file']['error'] = $_FILES['berkas']['error'][$i];
                $_FILES['file']['size'] = $_FILES['berkas']['size'][$i];
       
                if($this->upload->do_upload('file')){
                    $uploadData = $this->upload->data();
                    $data['nama_berkas'] = $nama[$i];
                    $data['photo'] = $uploadData['file_name'];
                    $data['pelanggan_id'] = $pelanggan_id[$i];
                    $this->db->insert('berkas',$data);
                }
            }
        }

        redirect(site_url('pelanggan'));

    }

    public function del_berkas($id,$uri) 
    {
        is_allowed($this->uri->segment(1),'delete');   
        $row = $this->Pelanggan_model->get_berkas_by_id($id);

        if ($row) {
            if($row->photo==null || $row->photo==''){
                }else{
                $target_file = './assets/img/berkas/'.$row->photo;
                unlink($target_file);
                }
            $this->Pelanggan_model->delete_berkas($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('pelanggan/read/'.$uri));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('pelanggan/read/'.$uri));
        }
    }
}

/* End of file Pelanggan.php */
/* Location: ./application/controllers/Pelanggan.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-07-01 09:21:03 */
/* http://harviacode.com */