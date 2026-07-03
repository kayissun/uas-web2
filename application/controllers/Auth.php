<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('M_auth');
    }

    public function index(){
        $this->load->view('auth/login');
    }

    public function login(){

        $username = $this->input->post('username', TRUE);
        $password = $this->input->post('password', TRUE);

        $user = $this->M_auth->getUser($username);

        if($user){

            // 🔒 CEK BRUTE FORCE (max 5x dalam 5 menit)
            if($user->failed_login >= 5 && strtotime($user->last_attempt) > strtotime('-5 minutes')){
                $this->session->set_flashdata('error', 'Terlalu banyak percobaan login. Coba lagi nanti.');
                redirect('auth');
            }

            // 🔑 VERIFIKASI PASSWORD
            if(password_verify($password, $user->password)){

                $this->session->set_userdata([
                    'login' => true,
                    'username' => $user->username
                ]);

                // reset failed login
                $this->M_auth->resetLogin($user->id);

                redirect('dashboard');

            } else {

                // tambah failed login
                $this->M_auth->updateFailed($user->id);

                $this->session->set_flashdata('error', 'Password salah');
                redirect('auth');
            }

        } else {
            $this->session->set_flashdata('error', 'Username tidak ditemukan');
            redirect('auth');
        }
    }

    public function logout(){
        $this->session->sess_destroy();
        redirect('auth');
    }
}