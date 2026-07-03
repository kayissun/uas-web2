<?php
class M_auth extends CI_Model {

    public function getUser($username){
        return $this->db->get_where('users', ['username'=>$username])->row();
    }

    public function updateFailed($id){
        $this->db->set('failed_login', 'failed_login+1', FALSE);
        $this->db->set('last_attempt', date('Y-m-d H:i:s'));
        $this->db->where('id', $id);
        $this->db->update('users');
    }

    public function resetLogin($id){
        $this->db->where('id', $id);
        $this->db->update('users', [
            'failed_login' => 0,
            'last_attempt' => NULL
        ]);
    }
}