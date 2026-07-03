<?php $this->load->view('templates_siswa/header'); ?>

<style>
    .full-height {
        min-height: 100vh;
        display: flex;
        align-items: center;
    }
</style>

<div class="container-fluid full-height">
    <div class="row justify-content-center w-100">
        <div class="col-md-6">
            <div class="card shadow-lg border-left-warning">
                <div class="card-body text-center">
                    <div class="mb-4">
                        <i class="fas fa-clock fa-3x text-warning"></i>
                    </div>
                    <h3 class="text-warning mb-3">Pengumuman Belum Dibuka</h3>
                    <p class="text-muted mb-4">
                        Hasil kelulusan belum dapat ditampilkan karena pengumuman resmi belum dibuka.
                    </p>

                    <div class="alert alert-warning">
                        <strong>Jadwal pembukaan:</strong>
                        <div class="mt-2"><strong><?= date('d M Y H:i', strtotime($pengumuman->tanggal_buka)) ?></strong></div>
                    </div>

                    <p class="text-secondary">
                        Silakan kembali setelah waktu pengumuman. Pastikan NIS sudah benar saat mencoba lagi.
                    </p>

                    <a href="<?= base_url('home') ?>" class="btn btn-primary mt-3">
                        <i class="fas fa-arrow-left"></i> Kembali ke Form Cek
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('templates_siswa/footer'); ?>