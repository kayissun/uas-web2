<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengumuman extends MY_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('M_pengumuman');
        date_default_timezone_set('Asia/Jakarta');
    }

    public function index(){
        $pengumuman = $this->M_pengumuman->get();

        if(!$pengumuman){
            $pengumuman = (object) [
                'tanggal_buka' => date('Y-m-d H:i')
            ];
        }

        $data['title'] = 'Pengumuman';
        $data['pengumuman'] = $pengumuman;

        $this->load->view('admin/pengumuman/index', $data);
    }

    public function simpan(){
        $tanggal = $this->input->post('tanggal_buka', TRUE);
        $waktu = $this->input->post('waktu_buka', TRUE);

        if(empty($tanggal) || empty($waktu)){
            $this->session->set_flashdata('error', 'Tanggal dan waktu pengumuman wajib diisi.');
            redirect('pengumuman');
            return;
        }

        $timestamp = strtotime($tanggal . ' ' . $waktu);
        if($timestamp === false){
            $this->session->set_flashdata('error', 'Format tanggal atau waktu tidak valid.');
            redirect('pengumuman');
            return;
        }

        $data = [
            'tanggal_buka' => date('Y-m-d H:i:s', $timestamp)
        ];

        $existing = $this->M_pengumuman->get();

        if($existing){
            $this->M_pengumuman->update($data);
            $message = 'Jadwal pengumuman berhasil diperbarui.';
        } else {
            $this->M_pengumuman->insert($data);
            $message = 'Jadwal pengumuman berhasil disimpan.';
        }

        $this->session->set_flashdata('success', $message);
        redirect('pengumuman');
    }
}
