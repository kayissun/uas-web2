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

        <!-- KOLOM KIRI -->
        <div class="col-md-5 mb-3">

            <div class="card shadow-lg">
                <div class="card-body text-center">

                    <h3 class="mb-4">Cek Kelulusan</h3>

                    <?php if($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger">
                            <?= $this->session->flashdata('error') ?>
                        </div>
                    <?php endif; ?>

                    <form method="post" action="<?= base_url('home/hasil') ?>">
                        
                        <!-- CSRF -->
                        <input type="hidden" 
                        name="<?= $this->security->get_csrf_token_name(); ?>" 
                        value="<?= $this->security->get_csrf_hash(); ?>" />

                        <input type="text" name="nis" class="form-control text-center" 
                               placeholder="Masukkan NIS" required>

                        <button class="btn btn-primary btn-block mt-3">
                            <i class="fas fa-search"></i> Cek Kelulusan
                        </button>

                    </form>

                </div>
            </div>

        </div>

        <!-- KOLOM KANAN -->
        <div class="col-md-7 mb-3">

            <div class="card shadow-lg h-100">
                <div class="card-body">

                    <h5 class="text-danger font-weight-bold text-center">
                        ⚠️ Informasi Penting
                    </h5>

                    <p class="mt-3 text-center">
                        Berikut Kami Sampaikan Beberapa Informasi Yang Harus Dipatuhi & Dilaksanakan :
                    </p>

                    <ol class="text-left">
                        <li>Murid dilarang melakukan kegiatan yang dapat mengganggu ketertiban umum seperti konvoi dan berkerumun yg menimbulkan kegaduhan</li>
                        <li>Tidak melakukan kegiatan vandalisme (corat-coret) pada pakaian, mengecat rambut dan sarana di lingkungan umum.</li>
                        <li>Murid tidak diperkenankan keluar dari WA grup kelas masing-masing.</li>
                        <li>Bagi yang berkepentingan dengan sekolah terkait pengurusan surat-surat dan administrasi lainnya(Raport, fotocopy raport, SKL, ijazah, dll) maka kehadiran di sekolah wajib mengenakan seragam OSIS, sopan dan bersepatu</li>
                    </ol>

                    <div class="alert alert-danger text-center">
                        <strong>
                            Pelanggaran akan dikenakan sanksi saat pengambilan dokumen sekolah. SKL dan Ijazah akan ditunda 12 bulan.
                        </strong>
                    </div>

                </div>
            </div>

        </div>

    </div>

</div>

<?php $this->load->view('templates_siswa/footer'); ?>