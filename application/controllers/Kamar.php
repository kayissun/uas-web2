<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kamar extends MY_Controller {

    public function __construct(){
        parent::__construct();
        $this->requirePetugasOrAdmin();
        $this->load->model('M_kamar');
        $this->load->library(['pagination','form_validation','upload']);
    }

    public function index(){
        $keyword = $this->input->post('keyword', TRUE);
        $type_id = $this->input->post('type_id', TRUE);
        $status = $this->input->post('status', TRUE);

        $config['base_url'] = base_url('kamar/index');
        $config['total_rows'] = $this->M_kamar->countAll($keyword, $type_id, $status);
        $config['per_page'] = 10;
        $this->pagination->initialize($config);

        $data['start'] = $this->uri->segment(3) ?? 0;
        $data['rooms'] = $this->M_kamar->getData($config['per_page'], $data['start'], $keyword, $type_id, $status);
        $data['types'] = $this->M_kamar->getTypes();
        $data['title'] = 'Manajemen Kamar';
        $data['keyword'] = $keyword;
        $data['filter_type'] = $type_id;
        $data['filter_status'] = $status;

        $this->load->view('admin/kamar/index', $data);
    }

    public function tambah(){
        $this->form_validation->set_rules('room_code', 'Kode Kamar', 'required|trim');
        $this->form_validation->set_rules('room_name', 'Nama Kamar', 'required|trim');
        $this->form_validation->set_rules('type_id', 'Tipe Kamar', 'required|integer');
        $this->form_validation->set_rules('price', 'Harga', 'required|numeric');
        $this->form_validation->set_rules('capacity', 'Kapasitas', 'required|integer');
        $this->form_validation->set_rules('status', 'Status', 'required');

        if($this->form_validation->run() === FALSE){
            $this->session->set_flashdata('error', validation_errors());
            redirect('kamar');
            return;
        }

        $room_code = $this->input->post('room_code', TRUE);
        if($this->M_kamar->getByCode($room_code)){
            $this->session->set_flashdata('error', 'Kode kamar sudah digunakan.');
            redirect('kamar');
            return;
        }

        $image_path = $this->_uploadImage();

        $this->M_kamar->insert([
            'room_code' => $room_code,
            'room_name' => $this->input->post('room_name', TRUE),
            'type_id' => $this->input->post('type_id', TRUE),
            'price' => $this->input->post('price', TRUE),
            'capacity' => $this->input->post('capacity', TRUE),
            'status' => $this->input->post('status', TRUE),
            'image_path' => $image_path
        ]);

        $this->session->set_flashdata('success', 'Kamar berhasil ditambahkan.');
        redirect('kamar');
    }

    public function edit($id){
        $this->form_validation->set_rules('room_code', 'Kode Kamar', 'required|trim');
        $this->form_validation->set_rules('room_name', 'Nama Kamar', 'required|trim');
        $this->form_validation->set_rules('type_id', 'Tipe Kamar', 'required|integer');
        $this->form_validation->set_rules('price', 'Harga', 'required|numeric');
        $this->form_validation->set_rules('capacity', 'Kapasitas', 'required|integer');
        $this->form_validation->set_rules('status', 'Status', 'required');

        if($this->form_validation->run() === FALSE){
            $this->session->set_flashdata('error', validation_errors());
            redirect('kamar');
            return;
        }

        $room = $this->M_kamar->getById($id);
        if(!$room){
            $this->session->set_flashdata('error', 'Kamar tidak ditemukan.');
            redirect('kamar');
            return;
        }

        $data = [
            'room_code' => $this->input->post('room_code', TRUE),
            'room_name' => $this->input->post('room_name', TRUE),
            'type_id' => $this->input->post('type_id', TRUE),
            'price' => $this->input->post('price', TRUE),
            'capacity' => $this->input->post('capacity', TRUE),
            'status' => $this->input->post('status', TRUE)
        ];

        $image_path = $this->_uploadImage();
        if($image_path){
            if($room->image_path && file_exists(FCPATH . 'uploads/room_images/' . $room->image_path)){
                @unlink(FCPATH . 'uploads/room_images/' . $room->image_path);
            }
            $data['image_path'] = $image_path;
        }

        $this->M_kamar->update($id, $data);
        $this->session->set_flashdata('success', 'Kamar berhasil diperbarui.');
        redirect('kamar');
    }

    public function hapus($id){
        $room = $this->M_kamar->getById($id);
        if($room && $room->image_path && file_exists(FCPATH . 'uploads/room_images/' . $room->image_path)){
            @unlink(FCPATH . 'uploads/room_images/' . $room->image_path);
        }

        $this->M_kamar->delete($id);
        $this->session->set_flashdata('success', 'Kamar berhasil dihapus.');
        redirect('kamar');
    }

    private function _uploadImage(){
        if(empty($_FILES['image']['name'])){
            return null;
        }

        $config['upload_path'] = './uploads/room_images/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['max_size'] = 2048;
        $config['encrypt_name'] = TRUE;

        $this->upload->initialize($config);

        if(!$this->upload->do_upload('image')){
            $this->session->set_flashdata('error', $this->upload->display_errors('', ''));
            redirect('kamar');
            exit;
        }

        $upload_data = $this->upload->data();
        return $upload_data['file_name'];
    }
}
