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
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-header text-center text-white 
                    <?= ($siswa->status === 'LULUS') ? 'bg-success' : 'bg-danger'; ?>">
                    <h3 class="mb-0">
                        <i class="fas fa-check-circle"></i> Hasil Kelulusan
                    </h3>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <?php if($siswa->status === 'LULUS'): ?>
                            <h4 class="text-success">Selamat, Anda dinyatakan <strong>LULUS</strong>!</h4>
                            <p class="text-muted">Silakan lanjutkan dengan mengikuti petunjuk sekolah berikutnya.</p>
                        <?php else: ?>
                            <h4 class="text-danger">Maaf, Anda dinyatakan <strong>TIDAK LULUS</strong>.</h4>
                            <p class="text-muted">Tetap semangat dan ikuti arahan sekolah untuk langkah selanjutnya.</p>
                        <?php endif; ?>
                    </div>

                    <div class="row text-center">
                        <div class="col-6 mb-3">
                            <div class="border rounded p-3">
                                <h6 class="text-muted">NIS</h6>
                                <strong><?= htmlspecialchars($siswa->nis, ENT_QUOTES, 'UTF-8') ?></strong>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="border rounded p-3">
                                <h6 class="text-muted">Nama</h6>
                                <strong><?= htmlspecialchars($siswa->nama, ENT_QUOTES, 'UTF-8') ?></strong>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="border rounded p-3">
                                <h6 class="text-muted">Kelas</h6>
                                <strong><?= htmlspecialchars($siswa->kelas, ENT_QUOTES, 'UTF-8') ?></strong>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="border rounded p-3">
                                <h6 class="text-muted">Jurusan</h6>
                                <strong><?= htmlspecialchars($siswa->jurusan, ENT_QUOTES, 'UTF-8') ?></strong>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 text-center">
                        <span class="badge badge-<?= ($siswa->status === 'LULUS') ? 'success' : 'danger' ?> px-4 py-2" style="font-size:1rem;">
                            <?= esc($siswa->status) ?>
                        </span>
                    </div>

                    <div class="mt-4 text-center">
                        <a href="<?= base_url('home') ?>" class="btn btn-primary mr-2">
                            <i class="fas fa-arrow-left"></i> Cek Lagi
                        </a>
                        <a href="<?= base_url() ?>" class="btn btn-secondary">
                            <i class="fas fa-home"></i> Beranda
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('templates_siswa/footer'); ?>