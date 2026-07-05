<?php
class M_reservasi extends CI_Model {

    public function getData($limit, $start, $keyword = null, $status = null){
        $this->db->select('reservations.*, rooms.room_code, rooms.room_name, users.username');
        $this->db->from('reservations');
        $this->db->join('rooms', 'rooms.id = reservations.room_id', 'left');
        $this->db->join('users', 'users.id = reservations.user_id', 'left');

        if($keyword){
            $this->db->group_start();
            $this->db->like('reservations.guest_name', $keyword);
            $this->db->or_like('reservations.guest_phone', $keyword);
            $this->db->or_like('rooms.room_code', $keyword);
            $this->db->or_like('rooms.room_name', $keyword);
            $this->db->or_like('users.username', $keyword);
            $this->db->group_end();
        }

        if($status){
            $this->db->where('reservations.status', $status);
        }

        return $this->db->order_by('reservations.created_at', 'DESC')->get('', $limit, $start)->result();
    }

    public function countAll($keyword = null, $status = null){
        if($keyword){
            $this->db->group_start();
            $this->db->like('reservations.guest_name', $keyword);
            $this->db->or_like('reservations.guest_phone', $keyword);
            $this->db->or_like('rooms.room_code', $keyword);
            $this->db->or_like('rooms.room_name', $keyword);
            $this->db->or_like('users.username', $keyword);
            $this->db->group_end();
        }

        if($status){
            $this->db->where('reservations.status', $status);
        }

        $this->db->from('reservations');
        $this->db->join('rooms', 'rooms.id = reservations.room_id', 'left');
        $this->db->join('users', 'users.id = reservations.user_id', 'left');
        return $this->db->count_all_results();
    }

    public function getById($id){
        return $this->db->get_where('reservations', ['id' => $id])->row();
    }

    public function insert($data){
        return $this->db->insert('reservations', $data);
    }

    public function update($id, $data){
        $this->db->where('id', $id);
        return $this->db->update('reservations', $data);
    }

    public function delete($id){
        $this->db->where('id', $id);
        return $this->db->delete('reservations');
    }

    public function countActiveByRoom($room_id){
        $this->db->where('room_id', $room_id);
        $this->db->where_in('status', ['booked', 'checked_in']);
        return $this->db->count_all_results('reservations');
    }

    public function countByStatus($status){
        return $this->db->where('status', $status)->count_all_results('reservations');
    }
}
