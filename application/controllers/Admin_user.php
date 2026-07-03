<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_user extends MY_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('M_admin');
        $this->load->library('pagination');
    }

    public function index(){
        $keyword = $this->input->post('keyword', TRUE);

        $config['base_url'] = base_url('admin_user/index');
        $config['total_rows'] = $this->M_admin->countAll($keyword);
        $config['per_page'] = 10;

        $this->pagination->initialize($config);

        $data['start'] = $this->uri->segment(3) ?? 0;
        $data['admins'] = $this->M_admin->getData($config['per_page'], $data['start'], $keyword);
        $data['title'] = 'Manajemen Admin';

        $this->load->view('admin/admin_user/index', $data);
    }

    public function tambah(){
        $username = $this->input->post('username', TRUE);
        $password = $this->input->post('password', TRUE);
        $password_confirm = $this->input->post('password_confirm', TRUE);

        if(empty($username) || empty($password) || empty($password_confirm)){
            $this->session->set_flashdata('error', 'Semua field harus diisi.');
            redirect('admin_user');
            return;
        }

        if($password !== $password_confirm){
            $this->session->set_flashdata('error', 'Password konfirmasi tidak cocok.');
            redirect('admin_user');
            return;
        }

        if($this->M_admin->getByUsername($username)){
            $this->session->set_flashdata('error', 'Username sudah digunakan.');
            redirect('admin_user');
            return;
        }

        $this->M_admin->insert([
            'username' => $username,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'created_at' => date('Y-m-d H:i:s')
        ]);

        $this->session->set_flashdata('success', 'Admin berhasil ditambahkan.');
        redirect('admin_user');
    }

    public function edit($id){
        $username = $this->input->post('username', TRUE);
        $password = $this->input->post('password', TRUE);
        $password_confirm = $this->input->post('password_confirm', TRUE);

        if(empty($username)){
            $this->session->set_flashdata('error', 'Username wajib diisi.');
            redirect('admin_user');
            return;
        }

        $admin = $this->M_admin->getById($id);
        if(!$admin){
            $this->session->set_flashdata('error', 'Admin tidak ditemukan.');
            redirect('admin_user');
            return;
        }

        if($admin->username !== $username && $this->M_admin->getByUsername($username)){
            $this->session->set_flashdata('error', 'Username sudah digunakan.');
            redirect('admin_user');
            return;
        }

        $data = ['username' => $username];
        if(!empty($password)){
            if($password !== $password_confirm){
                $this->session->set_flashdata('error', 'Password konfirmasi tidak cocok.');
                redirect('admin_user');
                return;
            }
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $this->M_admin->update($id, $data);
        $this->session->set_flashdata('success', 'Data admin berhasil diperbarui.');
        redirect('admin_user');
    }

    public function hapus($id){
        $this->M_admin->delete($id);
        $this->session->set_flashdata('success', 'Admin berhasil dihapus.');
        redirect('admin_user');
    }

    public function reset($id){
        $this->M_admin->resetLogin($id);
        $this->session->set_flashdata('success', 'Status login gagal berhasil direset.');
        redirect('admin_user');
    }
}
