<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Landing extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('M_kamar');
        $this->load->model('M_reservasi');
    }

    public function index(){
        $data['rooms'] = $this->M_kamar->getData(12, 0, null, null, 'available');
        $this->load->view('landing/index', $data);
    }

    public function pesan(){
        $this->load->library('form_validation');

        $this->form_validation->set_rules('room_id', 'Kamar', 'required|integer');
        $this->form_validation->set_rules('guest_name', 'Nama Tamu', 'required|trim');
        $this->form_validation->set_rules('guest_phone', 'No. Telepon', 'required|trim');
        $this->form_validation->set_rules('check_in', 'Tanggal Check-in', 'required');
        $this->form_validation->set_rules('check_out', 'Tanggal Check-out', 'required');

        if($this->form_validation->run() === FALSE){
            $this->session->set_flashdata('error', validation_errors());
            redirect('/');
            return;
        }

        $room_id = $this->input->post('room_id', TRUE);
        $room = $this->M_kamar->getById($room_id);

        if(!$room || $room->status !== 'available'){
            $this->session->set_flashdata('error', 'Kamar yang dipilih tidak tersedia.');
            redirect('/');
            return;
        }

        $check_in = $this->input->post('check_in', TRUE);
        $check_out = $this->input->post('check_out', TRUE);

        if(strtotime($check_out) <= strtotime($check_in)){
            $this->session->set_flashdata('error', 'Tanggal check-out harus lebih besar dari check-in.');
            redirect('/');
            return;
        }

        $nights = (strtotime($check_out) - strtotime($check_in)) / 86400;
        $total_price = $room->price * $nights;

        $user_id = $this->session->userdata('user_id');
        if(empty($user_id)){
            $default_user = $this->db->select('id')->order_by('id', 'ASC')->limit(1)->get('users')->row();
            if(!$default_user){
                $this->session->set_flashdata('error', 'Tidak ada akun pengguna yang tersedia untuk mencatat reservasi.');
                redirect('/');
                return;
            }
            $user_id = $default_user->id;
        }

        $this->M_reservasi->insert([
            'room_id' => $room_id,
            'user_id' => $user_id,
            'guest_name' => $this->input->post('guest_name', TRUE),
            'guest_phone' => $this->input->post('guest_phone', TRUE),
            'check_in' => $check_in,
            'check_out' => $check_out,
            'total_price' => $total_price,
            'status' => 'booked'
        ]);

        $this->M_kamar->syncStatusFromReservation($room_id, 'booked');
        $this->session->set_flashdata('success', 'Pemesanan kamar berhasil dikirim. Tim kami akan segera menghubungi Anda.');
        redirect('/');
    }
}
