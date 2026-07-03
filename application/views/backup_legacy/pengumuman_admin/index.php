<?php $this->load->view('templates/header'); ?>
<?php $this->load->view('templates/sidebar'); ?>
<?php $this->load->view('templates/navbar'); ?>

<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Pengumuman</h1>

    <?php if($this->session->flashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= $this->session->flashdata('success') ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php endif; ?>

    <?php if($this->session->flashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= $this->session->flashdata('error') ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Atur Jadwal Pengumuman</h6>
                </div>
                <div class="card-body">
                    <p class="text-muted">Setel waktu pembukaan pengumulan kelulusan untuk siswa.</p>

                    <form method="post" action="<?= base_url('pengumuman/simpan') ?>">
                        <input type="hidden"
                            name="<?= $this->security->get_csrf_token_name(); ?>"
                            value="<?= $this->security->get_csrf_hash(); ?>">

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="tanggal_buka">Tanggal Buka</label>
                                <input type="date" class="form-control" id="tanggal_buka" name="tanggal_buka"
                                    value="<?= isset($pengumuman->tanggal_buka) ? date('Y-m-d', strtotime($pengumuman->tanggal_buka)) : '' ?>" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="waktu_buka">Waktu Buka</label>
                                <input type="time" class="form-control" id="waktu_buka" name="waktu_buka"
                                    value="<?= isset($pengumuman->tanggal_buka) ? date('H:i', strtotime($pengumuman->tanggal_buka)) : '' ?>" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan Jadwal</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow mb-4 border-left-warning">
                <div class="card-body">
                    <h5 class="font-weight-bold">Status Saat Ini</h5>
                    <?php if(isset($pengumuman->tanggal_buka) && strtotime($pengumuman->tanggal_buka) > time()): ?>
                        <span class="badge badge-warning fs-">BELUM DIBUKA</span>
                    <?php endif; ?>
                    <?php if(isset($pengumuman->tanggal_buka) && strtotime($pengumuman->tanggal_buka) <= time()): ?>
                        <span class="badge badge-success">SUDAH DIBUKA</span>
                    <?php endif; ?>
                    <p class="mb-2">Jadwal aktif: <strong><?= isset($pengumuman->tanggal_buka) ? date('d M Y H:i', strtotime($pengumuman->tanggal_buka)) : 'Belum diatur' ?></strong></p>
                    <p class="mb-0">Waktu server: <strong><?= date('d M Y H:i') ?></strong></p>
                </div>
            </div>
        </div>
    </div>

</div>

<?php $this->load->view('templates/footer'); ?>
<?php $this->load->view('templates/scripts'); ?>
