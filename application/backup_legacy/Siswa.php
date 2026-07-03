<?php
class Siswa extends MY_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('M_siswa');
        $this->load->library('pagination');
    }

    public function index() {
        $keyword = $this->input->post('keyword', TRUE);

        $config['base_url'] = base_url('siswa/index');
        $config['total_rows'] = $this->M_siswa->countData($keyword);
        $config['per_page'] = 10;

        $this->pagination->initialize($config);

        $data['start'] = $this->uri->segment(3) ?? 0;
        $data['siswa'] = $this->M_siswa->getData($config['per_page'], $data['start'], $keyword);

        $data['title'] = 'Data Siswa';
        $this->load->view('admin/siswa/index', $data);
    }

    public function hapus($id) {
        $this->M_siswa->delete($id);
        $this->session->set_flashdata('success', 'Data siswa berhasil dihapus');
        redirect(base_url('siswa'));
    }

    public function tambah() {
        $data = array(
            'nis' => $this->input->post('nis', TRUE),
            'nama' => $this->input->post('nama', TRUE),
            'kelas' => $this->input->post('kelas', TRUE),
            'jurusan' => $this->input->post('jurusan', TRUE),
            'status' => $this->input->post('status', TRUE)
        );

        $this->M_siswa->insert($data);
        $this->session->set_flashdata('success', 'Data siswa berhasil ditambahkan');
        redirect(base_url('siswa'));
    }

    public function edit($id) {
        $data = array(
            'nis' => $this->input->post('nis', TRUE),
            'nama' => $this->input->post('nama', TRUE),
            'kelas' => $this->input->post('kelas', TRUE),
            'jurusan' => $this->input->post('jurusan', TRUE),
            'status' => $this->input->post('status', TRUE)
        );

        $this->M_siswa->update($id, $data);
        $this->session->set_flashdata('success', 'Data siswa berhasil diperbarui');
        redirect(base_url('siswa'));
    }
}