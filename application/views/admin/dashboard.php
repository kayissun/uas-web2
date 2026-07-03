<?php $this->load->view('templates/header'); ?>
<?php $this->load->view('templates/sidebar'); ?>
<?php $this->load->view('templates/navbar'); ?>

<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Dashboard</h1>

    <div class="row">

        <!-- Total Siswa -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <h5>Total Siswa</h5>
                    <h3><?= $total_siswa ?></h3>
                </div>
            </div>
        </div>

        <!-- Lulus -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <h5>Lulus</h5>
                    <h3><?= $lulus ?></h3>
                </div>
            </div>
        </div>

        <!-- Tidak Lulus -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <h5>Tidak Lulus</h5>
                    <h3><?= $tidak_lulus ?></h3>
                </div>
            </div>
        </div>

        <!-- Status Pengumuman -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <h5>Pengumuman</h5>
                    <h6><?= $status_pengumuman ?></h6>
                    <small><?= date('d M Y H:i', strtotime($tanggal_buka)) ?></small>
                </div>
            </div>
        </div>

    </div>

</div>

<?php $this->load->view('templates/footer'); ?>
<?php $this->load->view('templates/scripts'); ?>