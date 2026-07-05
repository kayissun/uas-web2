<?php
class M_kamar extends CI_Model {

    public function getTypes(){
        return $this->db->order_by('type_name', 'ASC')->get('room_types')->result();
    }

    public function getData($limit, $start, $keyword = null, $type_id = null, $status = null){
        $this->db->select('rooms.*, room_types.type_name');
        $this->db->from('rooms');
        $this->db->join('room_types', 'room_types.id = rooms.type_id', 'left');

        if($keyword){
            $this->db->group_start();
            $this->db->like('rooms.room_code', $keyword);
            $this->db->or_like('rooms.room_name', $keyword);
            $this->db->or_like('room_types.type_name', $keyword);
            $this->db->group_end();
        }

        if($type_id){
            $this->db->where('type_id', $type_id);
        }

        if($status){
            $this->db->where('status', $status);
        }

        return $this->db->order_by('rooms.id', 'DESC')->get('', $limit, $start)->result();
    }

    public function countAll($keyword = null, $type_id = null, $status = null){
        if($keyword){
            $this->db->group_start();
            $this->db->like('rooms.room_code', $keyword);
            $this->db->or_like('rooms.room_name', $keyword);
            $this->db->or_like('room_types.type_name', $keyword);
            $this->db->group_end();
        }

        if($type_id){
            $this->db->where('type_id', $type_id);
        }

        if($status){
            $this->db->where('status', $status);
        }

        $this->db->from('rooms');
        $this->db->join('room_types', 'room_types.id = rooms.type_id', 'left');
        return $this->db->count_all_results();
    }

    public function getById($id){
        return $this->db->get_where('rooms', ['id' => $id])->row();
    }

    public function getByCode($code){
        return $this->db->get_where('rooms', ['room_code' => $code])->row();
    }

    public function insert($data){
        return $this->db->insert('rooms', $data);
    }

    public function update($id, $data){
        $this->db->where('id', $id);
        return $this->db->update('rooms', $data);
    }

    public function delete($id){
        $this->db->where('id', $id);
        return $this->db->delete('rooms');
    }

    public function syncStatusFromReservation($room_id, $reservation_status){
        if(!$room_id){
            return false;
        }

        $active_reservations = $this->db->where('room_id', $room_id)
            ->where_in('status', ['booked', 'checked_in'])
            ->count_all_results('reservations');

        $current_room = $this->getById($room_id);
        if($current_room && $current_room->status === 'maintenance'){
            return true;
        }

        $new_status = $active_reservations > 0 ? 'occupied' : 'available';
        return $this->update($room_id, ['status' => $new_status]);
    }

    public function countByStatus($status){
        return $this->db->where('status', $status)->count_all_results('rooms');
    }

    public function countAllRooms(){
        return $this->db->count_all('rooms');
    }

    public function getAvailableRooms(){
        return $this->db->where('status', 'available')->order_by('room_code', 'ASC')->get('rooms')->result();
    }
}
