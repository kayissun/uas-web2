<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('M_siswa');
        $this->load->model('M_pengumuman');

        // timezone wajib
        date_default_timezone_set('Asia/Jakarta');
    }

    // =========================
    // HALAMAN INPUT NIS
    // =========================
    public function index(){
        $this->load->view('siswa/cek');
    }

    // =========================
    // PROSES CEK KELULUSAN
    // =========================
    public function hasil(){

        // ambil input
        $nis = htmlspecialchars($this->input->post('nis', TRUE));

        // validasi
        if(empty($nis)){
            $this->session->set_flashdata('error', 'NIS wajib diisi');
            redirect('home');
        }

        // ambil jadwal pengumuman
        $pengumuman = $this->M_pengumuman->get();

        // fallback jika data kosong
        if(!$pengumuman){
            show_error('Jadwal pengumuman belum diatur');
        }

        $now = date('Y-m-d H:i:s');

        // =========================
        // CEK WAKTU (LOCK SYSTEM)
        // =========================
        if($now < $pengumuman->tanggal_buka){

            $data['pengumuman'] = $pengumuman;

            $this->load->view('siswa/belum_buka', $data);
            return;
        }

        // =========================
        // AMBIL DATA SISWA
        // =========================
        $siswa = $this->M_siswa->getByNIS($nis);

        // jika tidak ditemukan
        if(!$siswa){
            $this->session->set_flashdata('error', 'NIS tidak ditemukan');
            redirect('home');
        }

        // =========================
        // LOGGING AKSES
        // =========================
        $this->db->insert('log_akses', [
            'nis' => $nis,
            'waktu_akses' => $now,
            'ip_address' => $this->input->ip_address(),
            'user_agent' => $this->input->user_agent()
        ]);

        // =========================
        // TAMPILKAN HASIL
        // =========================
        $data['siswa'] = $siswa;

        $this->load->view('siswa/hasil', $data);
    }
}