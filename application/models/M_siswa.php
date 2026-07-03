<?php
class M_siswa extends CI_Model {

    // =========================
    // UNTUK HALAMAN SISWA (PUBLIC)
    // =========================
    public function getByNIS($nis){
        return $this->db->get_where('siswa', ['nis'=>$nis])->row();
    }

    // =========================
    // UNTUK DASHBOARD
    // =========================
    public function countAll(){
        return $this->db->count_all('siswa');
    }

    public function countByStatus($status){
        return $this->db->where('status', $status)->count_all_results('siswa');
    }

    // =========================
    //      CRUD + PAGINATION
    // =========================
    public function getData($limit, $start, $keyword = null){

        if($keyword){
            $this->db->group_start();
            $this->db->like('nis', $keyword);
            $this->db->or_like('nama', $keyword);
            $this->db->or_like('kelas', $keyword);
            $this->db->or_like('jurusan', $keyword);
            $this->db->group_end();
        }

        return $this->db->get('siswa', $limit, $start)->result();
    }


    public function countData($keyword = null){

        if($keyword){
            $this->db->group_start();
            $this->db->like('nis', $keyword);
            $this->db->or_like('nama', $keyword);
            $this->db->or_like('kelas', $keyword);
            $this->db->or_like('jurusan', $keyword);
            $this->db->group_end();
        }

        return $this->db->count_all_results('siswa');
    }

    // =========================
    //          CRUD
    // =========================
    public function getById($id){
        return $this->db->get_where('siswa', ['id'=>$id])->row();
    }

    public function insert($data){
        $this->db->insert('siswa', $data);
    }

    public function update($id, $data){
        $this->db->where('id', $id)->update('siswa', $data);
    }

    public function delete($id){
        $this->db->where('id', $id)->delete('siswa');
    }

    // =========================
    // IMPORT BATCH (dari Excel)
    // =========================
    public function insertBatch($data){
        return $this->db->insert_batch('siswa', $data);
    }
}