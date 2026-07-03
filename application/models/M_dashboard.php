<?php
class M_dashboard extends CI_Model {

    public function countRooms(){
        return $this->db->count_all('rooms');
    }

    public function countReserved(){
        return $this->db->where('status !=', 'cancelled')->count_all_results('reservations');
    }

    public function countAvailableRooms(){
        return $this->db->where('status', 'available')->count_all_results('rooms');
    }

    public function countReservationsByStatus($status){
        return $this->db->where('status', $status)->count_all_results('reservations');
    }

    public function getReservationChartData(){
        $query = $this->db->select('status, COUNT(*) as total')
            ->from('reservations')
            ->group_by('status')
            ->get();
        return $query->result();
    }
}
