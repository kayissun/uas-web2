<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reservasi extends MY_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('M_reservasi');
        $this->load->model('M_kamar');
        $this->load->library(['pagination','form_validation']);
    }

    public function index(){
        $keyword = $this->input->post('keyword', TRUE);
        $status = $this->input->post('status', TRUE);

        $config['base_url'] = base_url('reservasi/index');
        $config['total_rows'] = $this->M_reservasi->countAll($keyword, $status);
        $config['per_page'] = 10;
        $this->pagination->initialize($config);

        $data['start'] = $this->uri->segment(3) ?? 0;
        $data['reservations'] = $this->M_reservasi->getData($config['per_page'], $data['start'], $keyword, $status);
        $data['rooms'] = $this->M_kamar->getAvailableRooms();
        $data['status_options'] = ['booked' => 'Booked', 'checked_in' => 'Checked In', 'checked_out' => 'Checked Out', 'cancelled' => 'Cancelled'];
        $data['title'] = 'Manajemen Reservasi';
        $data['keyword'] = $keyword;
        $data['filter_status'] = $status;

        $this->load->view('admin/reservasi/index', $data);
    }

    public function tambah(){
        $this->form_validation->set_rules('room_id', 'Kamar', 'required|integer');
        $this->form_validation->set_rules('guest_name', 'Nama Tamu', 'required|trim');
        $this->form_validation->set_rules('guest_phone', 'No. Telepon', 'required|trim');
        $this->form_validation->set_rules('check_in', 'Tanggal Check-in', 'required');
        $this->form_validation->set_rules('check_out', 'Tanggal Check-out', 'required');

        if($this->form_validation->run() === FALSE){
            $this->session->set_flashdata('error', validation_errors());
            redirect('reservasi');
            return;
        }

        $room_id = $this->input->post('room_id', TRUE);
        $room = $this->M_kamar->getById($room_id);

        if(!$room){
            $this->session->set_flashdata('error', 'Kamar tidak ditemukan.');
            redirect('reservasi');
            return;
        }

        $check_in = $this->input->post('check_in', TRUE);
        $check_out = $this->input->post('check_out', TRUE);
        if(strtotime($check_out) <= strtotime($check_in)){
            $this->session->set_flashdata('error', 'Tanggal check-out harus lebih besar dari check-in.');
            redirect('reservasi');
            return;
        }

        $nights = (strtotime($check_out) - strtotime($check_in)) / 86400;
        $total_price = $room->price * $nights;

        $this->M_reservasi->insert([
            'room_id' => $room_id,
            'user_id' => $this->session->userdata('user_id'),
            'guest_name' => $this->input->post('guest_name', TRUE),
            'guest_phone' => $this->input->post('guest_phone', TRUE),
            'check_in' => $check_in,
            'check_out' => $check_out,
            'total_price' => $total_price,
            'status' => 'booked'
        ]);

        $this->session->set_flashdata('success', 'Reservasi berhasil dibuat.');
        redirect('reservasi');
    }

    public function hapus($id){
        $this->M_reservasi->delete($id);
        $this->session->set_flashdata('success', 'Reservasi berhasil dihapus.');
        redirect('reservasi');
    }

    public function export_excel(){
        try {
            require_once APPPATH . '../vendor/autoload.php';
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            $headers = ['No','Kode Kamar','Nama Kamar','Petugas','Tamu','Telepon','Check-in','Check-out','Total Harga','Status'];
            $sheet->fromArray($headers, NULL, 'A1');

            $reservations = $this->M_reservasi->getData(1000, 0, null, null);
            $row = 2;
            foreach($reservations as $item){
                $sheet->setCellValue('A'.$row, $row-1);
                $sheet->setCellValue('B'.$row, $item->room_code);
                $sheet->setCellValue('C'.$row, $item->room_name);
                $sheet->setCellValue('D'.$row, $item->username);
                $sheet->setCellValue('E'.$row, $item->guest_name);
                $sheet->setCellValue('F'.$row, $item->guest_phone);
                $sheet->setCellValue('G'.$row, $item->check_in);
                $sheet->setCellValue('H'.$row, $item->check_out);
                $sheet->setCellValue('I'.$row, $item->total_price);
                $sheet->setCellValue('J'.$row, ucfirst(str_replace('_',' ',$item->status)));
                $row++;
            }

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="Laporan_Reservasi.xlsx"');
            header('Cache-Control: max-age=0');
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            $writer->save('php://output');
            exit;

        } catch(Exception $e){
            $this->session->set_flashdata('error', 'Export Excel gagal: ' . $e->getMessage());
            redirect('reservasi');
        }
    }

    public function export_pdf(){
        try {
            if(!class_exists('Dompdf\\Dompdf')){
                throw new Exception('Dompdf tidak ditemukan. Jalankan composer install dompdf/dompdf.');
            }

            require_once APPPATH . '../vendor/autoload.php';
            $reservations = $this->M_reservasi->getData(1000, 0, null, null);
            $html = $this->load->view('admin/reservasi/report_print', ['reservations' => $reservations, 'pdf' => true], TRUE);

            $dompdf = new Dompdf\Dompdf();
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'landscape');
            $dompdf->render();
            $dompdf->stream('Laporan_Reservasi.pdf', ['Attachment' => 1]);
            exit;

        } catch(Exception $e){
            $this->session->set_flashdata('error', 'Export PDF gagal: ' . $e->getMessage());
            redirect('reservasi');
        }
    }

    public function print_report(){
        $data['reservations'] = $this->M_reservasi->getData(1000, 0, null, null);
        $this->load->view('admin/reservasi/report_print', $data);
    }
}
