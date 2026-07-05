<?php
class MY_Controller extends CI_Controller {

    public function __construct(){
        parent::__construct();

        if(!$this->session->userdata('login')){
            redirect('login');
        }
    }

    protected function requireAdmin(){
        if($this->session->userdata('role') !== 'admin'){
            $this->session->set_flashdata('error', 'Akses ditolak. Hanya admin yang dapat mengakses halaman ini.');
            redirect('dashboard');
            exit;
        }
    }

    protected function requirePetugasOrAdmin(){
        $role = $this->session->userdata('role');
        if($role !== 'petugas' && $role !== 'admin'){
            $this->session->set_flashdata('error', 'Akses ditolak.');
            redirect('logout');
            exit;
        }
    }
}
