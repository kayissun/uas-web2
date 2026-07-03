<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Import extends MY_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('M_siswa');
        $this->load->database();
    }

    // HALAMAN UTAMA IMPORT
    public function index() {
        $data['title'] = 'Import Excel';
        $this->load->view('admin/import/index', $data);
    }

    // PROSES UPLOAD DAN IMPORT EXCEL
    public function proses() {
        log_message('debug', 'Import proses started');
        
        // CEK FILE UPLOAD
        if(!isset($_FILES['file'])) {
            log_message('error', 'File not isset');
            $this->session->set_flashdata('error', 'File tidak dipilih');
            redirect('import');
            return;
        }

        log_message('debug', 'File uploaded: ' . $_FILES['file']['name']);

        if($_FILES['file']['error'] !== UPLOAD_ERR_OK) {
            log_message('error', 'Upload error: ' . $_FILES['file']['error']);
            $error_msg = 'Upload error';
            $this->session->set_flashdata('error', $error_msg);
            redirect('import');
            return;
        }

        // VALIDASI EKSTENSI
        $file_name = $_FILES['file']['name'];
        $file_tmp = $_FILES['file']['tmp_name'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        
        log_message('debug', 'File ext: ' . $file_ext);

        if(!in_array($file_ext, ['xlsx', 'xls', 'csv'])) {
            log_message('error', 'Invalid file format: ' . $file_ext);
            $this->session->set_flashdata('error', 'Format file hanya .xlsx, .xls, atau .csv');
            redirect('import');
            return;
        }

        // LOAD LIBRARY
        try {
            log_message('debug', 'Loading autoload');
            require_once APPPATH . '../vendor/autoload.php';
            
            log_message('debug', 'Loading Excel file');
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file_tmp);
            $sheet = $spreadsheet->getActiveSheet();
            
            log_message('debug', 'Excel loaded, reading data');
            
            $data_siswa = [];
            $error_rows = [];

            // BACA DATA
            foreach($sheet->getRowIterator(2) as $row) {
                $cells = [];
                $col = 0;
                
                foreach($row->getCellIterator() as $cell) {
                    if($col < 5) {
                        $cells[] = trim((string)$cell->getValue());
                    }
                    $col++;
                }

                // SKIP ROW KOSONG
                if(empty(implode('', $cells))) continue;

                $nis = $cells[0] ?? '';
                $nama = $cells[1] ?? '';
                $kelas = $cells[2] ?? '';
                $jurusan = $cells[3] ?? '';
                $status = strtoupper($cells[4] ?? '');

                // VALIDASI
                if(empty($nis) || empty($nama) || empty($kelas) || empty($jurusan) || empty($status)) {
                    $error_rows[] = 'Row ' . $row->getRowIndex() . ': Ada field kosong';
                    continue;
                }

                if($status !== 'LULUS' && $status !== 'TIDAK LULUS') {
                    $error_rows[] = 'Row ' . $row->getRowIndex() . ': Status invalid';
                    continue;
                }

                // CEK DUPLIKAT
                log_message('debug', 'Check NIS: ' . $nis);
                $check = $this->M_siswa->getByNIS($nis);
                if($check) {
                    log_message('debug', 'NIS duplikat: ' . $nis);
                    $error_rows[] = 'Row ' . $row->getRowIndex() . ': NIS sudah ada';
                    continue;
                }

                $data_siswa[] = [
                    'nis' => $nis,
                    'nama' => $nama,
                    'kelas' => $kelas,
                    'jurusan' => $jurusan,
                    'status' => $status
                ];
            }

            log_message('debug', 'Data parsed. Errors: ' . count($error_rows) . ', Valid: ' . count($data_siswa));

            // ERROR
            if(count($error_rows) > 0) {
                log_message('error', 'Validation errors found');
                $msg = '<strong>Error di ' . count($error_rows) . ' row:</strong><ul>';
                foreach(array_slice($error_rows, 0, 10) as $e) {
                    $msg .= '<li>' . $e . '</li>';
                }
                if(count($error_rows) > 10) $msg .= '<li>... dan ' . (count($error_rows)-10) . ' lagi</li>';
                $msg .= '</ul>';
                $this->session->set_flashdata('error', $msg);
                redirect('import');
                return;
            }

            if(empty($data_siswa)) {
                log_message('error', 'No valid data to import');
                $this->session->set_flashdata('error', 'Tidak ada data valid');
                redirect('import');
                return;
            }

            // INSERT
            log_message('debug', 'Inserting ' . count($data_siswa) . ' rows');
            $this->M_siswa->insertBatch($data_siswa);
            
            log_message('info', 'Import success: ' . count($data_siswa) . ' rows');
            $this->session->set_flashdata('success', 'Import OK! ' . count($data_siswa) . ' data ditambah');
            redirect('siswa');

        } catch(Exception $e) {
            log_message('error', 'Exception: ' . $e->getMessage());
            log_message('error', 'File: ' . $e->getFile() . ' Line: ' . $e->getLine());
            $this->session->set_flashdata('error', 'Error: ' . $e->getMessage());
            redirect('import');
        }
    }

    // DOWNLOAD TEMPLATE EXCEL
    public function template() {
        try {
            $autoload_path = APPPATH . '../vendor/autoload.php';
            if(!file_exists($autoload_path)) {
                throw new Exception('Library tidak ditemukan');
            }
            require_once $autoload_path;
            
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // HEADER
            $headers = ['NIS', 'Nama', 'Kelas', 'Jurusan', 'Status'];
            foreach($headers as $col => $header) {
                $col_letter = chr(65 + $col); // A=65
                $sheet->setCellValue($col_letter . '1', $header);
            }

            // STYLE HEADER
            for($col = 0; $col < 5; $col++) {
                $col_letter = chr(65 + $col);
                $cell = $col_letter . '1';
                $sheet->getStyle($cell)->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                    'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '4472C4']],
                    'alignment' => ['horizontal' => 'center', 'vertical' => 'center']
                ]);
            }

            // SET WIDTH
            $sheet->getColumnDimension('A')->setWidth(15);
            $sheet->getColumnDimension('B')->setWidth(25);
            $sheet->getColumnDimension('C')->setWidth(12);
            $sheet->getColumnDimension('D')->setWidth(15);
            $sheet->getColumnDimension('E')->setWidth(15);

            // CONTOH DATA
            $sheet->setCellValue('A2', '001');
            $sheet->setCellValue('B2', 'Budi Santoso');
            $sheet->setCellValue('C2', 'XII A');
            $sheet->setCellValue('D2', 'IPA');
            $sheet->setCellValue('E2', 'LULUS');

            // DOWNLOAD
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="Template_Import_Siswa.xlsx"');
            header('Cache-Control: no-cache, no-store, must-revalidate');
            
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            $writer->save('php://output');
            exit();

        } catch(Exception $e) {
            $this->session->set_flashdata('error', 'Error: ' . $e->getMessage());
            redirect('import');
        }
    }
}
?>
