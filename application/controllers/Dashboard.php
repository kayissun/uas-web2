<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('M_siswa');
        $this->load->model('M_pengumuman');
    }

    public function index(){

        $data['title'] = 'Dashboard';

        // statistik siswa
        $data['total_siswa'] = $this->M_siswa->countAll();
        $data['lulus'] = $this->M_siswa->countByStatus('LULUS');
        $data['tidak_lulus'] = $this->M_siswa->countByStatus('TIDAK LULUS');

        // pengumuman
        $pengumuman = $this->M_pengumuman->get();
        $data['tanggal_buka'] = $pengumuman->tanggal_buka;
        $data['status_pengumuman'] = (strtotime(date('Y-m-d H:i:s')) >= strtotime($pengumuman->tanggal_buka)) ? 'SUDAH DIBUKA' : 'BELUM DIBUKA';

        $this->load->view('admin/dashboard', $data);
    }
}