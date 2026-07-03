<?php
class M_pengumuman extends CI_Model {

    public function get(){
        return $this->db->get('pengumuman')->row(); // ini  menghasilkan sebuah query "SELECT * FROM pengumman"
    }

    public function insert($data){
        return $this->db->insert('pengumuman', $data);
    }

    public function update($data){
        return $this->db->where('id', 1)->update('pengumuman', $data);
         // ini menghasilkan sebuah query ke tabel pengumuman : "UPDATE pengumuman SET tanggal = 'VALUE', jam = 'VALUE' WHERE id = 1"
    }
}