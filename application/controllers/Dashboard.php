<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('M_dashboard');
        $this->load->model('M_reservasi');
    }

    public function index(){

        $data['title'] = 'Dashboard';

        $data['total_rooms'] = $this->M_dashboard->countRooms();
        $data['reserved_rooms'] = $this->M_dashboard->countReserved();
        $data['available_rooms'] = $this->M_dashboard->countAvailableRooms();
        $data['cancelled_reservations'] = $this->M_dashboard->countReservationsByStatus('cancelled');
        $data['checkin_reservations'] = $this->M_dashboard->countReservationsByStatus('checked_in');
        $data['checkout_reservations'] = $this->M_dashboard->countReservationsByStatus('checked_out');
        $data['chart_data'] = $this->M_dashboard->getReservationChartData();

        $this->load->view('admin/dashboard', $data);
    }
}