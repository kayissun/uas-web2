<?php
class M_admin extends CI_Model {

    public function getData($limit, $start, $keyword = null){
        if($keyword){
            $this->db->like('username', $keyword);
        }
        return $this->db->get('users', $limit, $start)->result();
    }

    public function countAll($keyword = null){
        if($keyword){
            $this->db->like('username', $keyword);
        }
        return $this->db->count_all_results('users');
    }

    public function getById($id){
        return $this->db->get_where('users', ['id'=>$id])->row();
    }

    public function getByUsername($username){
        return $this->db->get_where('users',['username'=>$username])->row();
    }

    public function insert($data){
        return $this->db->insert('users', $data);
    }

    public function update($id, $data){
        $this->db->where('id', $id);
        return $this->db->update('users', $data);
    }

    public function delete($id){
        $this->db->where('id', $id);
        return $this->db->delete('users');
    }

    public function resetLogin($id){
        $this->db->where('id', $id);
        return $this->db->update('users', [
            'failed_login' => 0,
            'last_attempt' => NULL
        ]);
    }
}