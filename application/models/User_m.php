<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User_m extends CI_Model {
    public function login ($post)
    {
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('username',$post['username']);
        $this->db->where('password',sha1($post['password']));
        $query=$this->db->get();
        return $query;
    }

    public function get($id = null)
    {
        $this->db->select('user.*,level.nama_level');
        $this->db->from('user');
        $this->db->join('level', 'level.level_id = user.level_id');
        if ($id !=null){
            $this->db->where('user_id', $id);
        }
        $query = $this->db->get();
        return $query;
    }

    public function get_nilai($id = null)
    {
        $this->db->from('user');
        if ($id !=null){
            $this->db->where('user_id', $id);
        }
        $this->db->where('level_id', 3);
        $query = $this->db->get();
        return $query;
    }

    public function add($post)
    {
        $params['nama_user'] = $post['nama_user'];
        $params['username'] = $post['username'];
        $params['password'] = sha1($post['password']);
        $params['email'] = $post['email'];
        $params['alamat_user'] = $post['alamat_user'];
        $params['level_id'] = $post['level_id'];
        $params['no_hp_user'] = $post['no_hp_user'];
        $this->db->insert('user',$params);
    }

     public function del($id)
    {
      $this->db->where('user_id',$id);
      $this->db->delete('user');
    }

     public function edit($post)
    {
        $params['name'] = $post['fullname'];
        $params['username'] = $post['username'];
        $params['email'] = $post['email'];
        if(!empty($post['password']))
        {
            $params['password'] = sha1($post['password']);
        }
        $params['address'] = $post['address'];
        $params['level_id'] = $post['level_id'];
        $this->db->where('user_id',$post['user_id']);
        $this->db->update('user',$params);
    }

    public function addHistory($name, $info, $tanggal, $user_agent) {
        return $this->db->insert('history_karyawan', array('nama' => $name, 'info' => $info, 'tanggal' => $tanggal, 'user_agent' =>$user_agent));
    }

    public function ubah_data($data,$id){
        $this->db->where('user_id',$id);
        $this->db->update ('user',$data);
    }

    public function user_token($user_token){
        $this->db->insert('user_token',$user_token);
    }

}