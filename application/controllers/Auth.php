<?php defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class Auth extends CI_Controller {

  public function __construct()
    {
      parent::__construct();
      $this->load->model('user_m');
    }

  public function index()
  {
    check_already_login();

    $options = array(
        'img_path'=>'./captcha/', #folder captcha yg sudah dibuat tadi
        'img_url'=>base_url('captcha'), #ini arahnya juga ke folder captcha
        'img_width'=>'145', #lebar image captcha
        'img_height'=>'45', #tinggi image captcha
        'expiration'=>7200, #waktu expired
        'font_path' => FCPATH . 'assets/font/coolvetica.ttf', #load font jika mau ganti fontnya
        'pool' => '0123456789', #tipe captcha (angka/huruf, atau kombinasi dari keduanya)

        # atur warna captcha-nya di sini ya.. gunakan kode RGB
        'colors' => array(
                'background' => array(242, 242, 242),
                'border' => array(255, 255, 255),
                'text' => array(0, 0, 0),
                'grid' => array(255, 40, 40)
            )
    );
    
    $cap = create_captcha($options);
    $data['image'] = $cap['image'];
    $this->session->set_userdata('mycaptcha', $cap['word']);
    $data['word'] = $this->session->userdata('mycaptcha');

    $this->load->view('login',$data);
  }


  public function profile()
  {
    $this->template->load('template','profile');
  }

  public function process()
  {

    $captcha = $this->input->post('captcha_code'); #mengambil value inputan pengguna
    $word = $this->session->userdata('mycaptcha'); #mengambil value captcha
    if (isset($captcha)) { #cek variabel $captcha kosong/tidak
       if (strtoupper($captcha)==strtoupper($word)) { #proses pencocokan captcha
            $post =$this->input->post(null, TRUE);
            if (isset($post['login'])){
                $this->load->model('user_m');
                $query =$this->user_m->login($post);
                if($query->num_rows() >0){
                    $row =$query->row();
                    $params = array(
                    'userid'=>$row->user_id,
                    'level_id' =>$row->level_id
                );
                $this->session->set_userdata($params);

                $this->user_m->addHistory($this->fungsi->user_login()->user_id, $this->fungsi->user_login()->nama_user.' Telah melakukan login', $_SERVER['HTTP_USER_AGENT']);

                echo "<script>window.location='".site_url('dashboard')."'</script>";

            } else {
                echo "<script>
                alert('Login Gagal');
                window.location='".site_url('auth')."'</script>";
            }
        }
    } else {
        echo "<script>
            alert('Kode captcha salah');
            window.location='".site_url('auth')."'</script>";
    }
 }

    
  }

  public function logout()
  {
    $params = array('userid','level_id');
    $this->session->unset_userdata($params);
    redirect('auth');

  }

  public function edit_profil($id){
        $data = array(
            'name'            =>$this->input->post('name',true),
            'address'         =>$this->input->post('address',true),
            'email'         =>$this->input->post('email',true),
        );
        $this->user_m->ubah_data($data,$id);
         echo "<script> alert('Data Berhasil diupdate')</script>";
         echo"<script>window.location='".site_url('auth/profile')."'</script>";
         
    }

    public function edit_password($id){
        if (sha1($this->input->post('lama'))==$this->fungsi->user_login()->password) {
            $data = array(
                'password'          => sha1($this->input->post('password',true)),
            );
            $this->user_m->ubah_data($data,$id);
            echo "<script> alert('Data Password Berhasil diupdate')</script>";
            echo"<script>window.location='".site_url('auth/logout')."'</script>";
        }else{
            echo "<script> alert('Password Lama Salah')</script>";
            echo"<script>window.location='".site_url('auth/profile')."'</script>";
        } 
    }


}