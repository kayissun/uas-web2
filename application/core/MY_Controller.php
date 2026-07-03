<?php
class MY_Controller extends CI_Controller {

    public function __construct(){
        parent::__construct();

        if(!$this->session->userdata('login')){
            redirect('auth');
        }
    }

    protected function requireAdmin(){
        if($this->session->userdata('role') !== 'admin'){
            $this->session->set_flashdata('error', 'Akses ditolak. Hanya admin yang dapat mengakses halaman ini.');
            redirect('dashboard');
            exit;
        }
    }
}
