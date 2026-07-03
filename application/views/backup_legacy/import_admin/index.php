<?php $this->load->view('templates/header'); ?>
<?php $this->load->view('templates/sidebar'); ?>
<?php $this->load->view('templates/navbar'); ?>

<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Import Excel Siswa</h1>

    <!-- ALERT SUCCESS -->
    <?php if($this->session->flashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= $this->session->flashdata('success') ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php endif; ?>

    <!-- ALERT ERROR -->
    <?php if($this->session->flashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= $this->session->flashdata('error') ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php endif; ?>

    <!-- CARD UTAMA -->
    <div class="card shadow mb-4">
        <div class="card-header bg-primary">
            <h6 class="m-0 font-weight-bold text-white">
                <i class="fas fa-upload"></i> Import Data Siswa dari Excel
            </h6>
        </div>

        <div class="card-body">

            <!-- LANGKAH 1: DOWNLOAD TEMPLATE -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <h5><i class="fas fa-file-download"></i> Langkah 1: Download Template</h5>
                    <p class="text-muted mb-3">
                        Unduh template Excel terlebih dahulu untuk memastikan format data yang benar.
                    </p>
                    <a href="<?= base_url('import/template') ?>" class="btn btn-success">
                        <i class="fas fa-download"></i> Download Template Excel
                    </a>
                </div>
                <div class="col-md-6">
                    <div class="alert alert-info">
                        <strong>Petunjuk Template:</strong>
                        <ul class="mb-0 mt-2">
                            <li>Kolom A: NIS (Nomor Induk Siswa)</li>
                            <li>Kolom B: Nama Lengkap</li>
                            <li>Kolom C: Kelas (Contoh: XII A)</li>
                            <li>Kolom D: Jurusan (Contoh: IPA)</li>
                            <li>Kolom E: Status (LULUS / TIDAK LULUS)</li>
                        </ul>
                    </div>
                </div>
            </div>

            <hr>

            <!-- LANGKAH 2: UPLOAD FILE -->
            <div class="row">
                <div class="col-md-6">
                    <h5><i class="fas fa-upload"></i> Langkah 2: Upload File Excel</h5>
                    <p class="text-muted mb-3">
                        Setelah mengisi template, upload file Excel Anda di sini.
                    </p>

                    <form method="post" action="<?= base_url('import/proses') ?>" enctype="multipart/form-data">
                        
                        <input type="hidden" 
                        name="<?= $this->security->get_csrf_token_name(); ?>" 
                        value="<?= $this->security->get_csrf_hash(); ?>">

                        <div class="form-group">
                            <label for="file" class="font-weight-bold">Pilih File Excel</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="file" name="file" 
                                accept=".xlsx,.xls,.csv" required>
                                <label class="custom-file-label" for="file">Pilih file...</label>
                            </div>
                            <small class="form-text text-muted">Format: .xlsx, .xls, atau .csv (Max: 5MB)</small>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg btn-block" id="btnUpload">
                            <i class="fas fa-file-import"></i> Upload & Import
                        </button>

                    </form>
                </div>

                <div class="col-md-6">
                    <div class="alert alert-warning">
                        <strong>⚠️ Perhatian:</strong>
                        <ul class="mb-0 mt-2">
                            <li>Jangan ubah nama kolom di template</li>
                            <li>Pastikan semua data wajib diisi</li>
                            <li>NIS tidak boleh duplikat dengan data yang sudah ada</li>
                            <li>Status hanya menerima: LULUS atau TIDAK LULUS</li>
                            <li>Jika ada error, perbaiki data dan upload ulang</li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- CARD INFO TAMBAHAN -->
    <!-- <div class="card shadow">
        <div class="card-header bg-danger">
            <h6 class="m-0 font-weight-bold text-white">
                <i class="fas fa-circle-info"></i> Informasi Penting
            </h6>
        </div>
        <div class="card-body">
            <p><strong>Format Data yang Diterima:</strong></p>
            <table class="table table-sm table-bordered">
                <thead class="thead-light">
                    <tr>
                        <th>Kolom</th>
                        <th>Tipe</th>
                        <th>Contoh</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>NIS</td>
                        <td>Text</td>
                        <td>001, 12345</td>
                        <td>Wajib, unik, tidak boleh duplikat</td>
                    </tr>
                    <tr>
                        <td>Nama</td>
                        <td>Text</td>
                        <td>Budi Santoso</td>
                        <td>Wajib diisi</td>
                    </tr>
                    <tr>
                        <td>Kelas</td>
                        <td>Text</td>
                        <td>XII A, XII IPA 1</td>
                        <td>Wajib diisi</td>
                    </tr>
                    <tr>
                        <td>Jurusan</td>
                        <td>Text</td>
                        <td>IPA, IPS, TKJ</td>
                        <td>Wajib diisi</td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td>Text</td>
                        <td>LULUS / TIDAK LULUS</td>
                        <td>Wajib, hanya 2 pilihan</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div> -->

</div>

<?php $this->load->view('templates/footer'); ?>
<?php $this->load->view('templates/scripts'); ?>

<script>
// UBAH LABEL SAAT FILE DIPILIH
document.getElementById('file').addEventListener('change', function(e) {
    var fileName = e.target.files[0].name;
    var label = document.querySelector('.custom-file-label');
    label.textContent = fileName;
});

// VALIDASI UKURAN FILE
document.getElementById('btnUpload').addEventListener('click', function(e) {
    var file = document.getElementById('file').files[0];
    if(file && file.size > 5242880) { // 5MB
        e.preventDefault();
        alert('Ukuran file terlalu besar! Maximum 5MB');
    }
});
</script>
?>
