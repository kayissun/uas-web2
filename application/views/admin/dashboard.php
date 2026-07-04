<?php $this->load->view('templates/header'); ?>
<?php $this->load->view('templates/sidebar'); ?>
<?php $this->load->view('templates/navbar'); ?>

<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Dashboard</h1>

    <?php if($this->session->userdata('role') === 'petugas'): ?>
    <div class="alert alert-info" role="alert">
        <strong>Hak Akses Petugas</strong><br>
        Petugas dapat login, melihat dashboard, data kamar, reservasi, menambah reservasi, mengubah status reservasi, check-in/check-out tamu, melihat data tamu, upload bukti pembayaran, search, filter, pagination, export PDF, cetak laporan, dan logout.<br>
        Petugas tidak dapat menambah/menghapus akun, mengubah data user, menghapus data master, atau mengakses menu pengaturan sistem.
    </div>
    <?php endif; ?>

    <div class="row">

        <!-- Total Kamar -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <h5>Total Kamar</h5>
                    <h3><?= $total_rooms ?></h3>
                </div>
            </div>
        </div>

        <!-- Kamar Tersedia -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <h5>Kamar Available</h5>
                    <h3><?= $available_rooms ?></h3>
                </div>
            </div>
        </div>

        <!-- Reservasi Aktif -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <h5>Reservasi Aktif</h5>
                    <h3><?= $reserved_rooms ?></h3>
                </div>
            </div>
        </div>

        <!-- Reservasi Dibatalkan -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <h5>Reservasi Cancelled</h5>
                    <h3><?= $cancelled_reservations ?></h3>
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-xl-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Statistik Reservasi</h6>
                </div>
                <div class="card-body">
                    <canvas id="reservasiChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Status Terkini</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <span class="font-weight-bold">Checked In:</span> <?= $checkin_reservations ?>
                    </div>
                    <div class="mb-3">
                        <span class="font-weight-bold">Checked Out:</span> <?= $checkout_reservations ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<?php $this->load->view('templates/footer'); ?>
<?php $this->load->view('templates/scripts'); ?>

<script>
var ctx = document.getElementById('reservasiChart');
if(ctx){
    var labels = [
        <?php foreach($chart_data as $item): ?>
            '<?= ucfirst(str_replace('_', ' ', $item->status)) ?>',
        <?php endforeach; ?>
    ];
    var data = [
        <?php foreach($chart_data as $item): ?>
            <?= $item->total ?>,
        <?php endforeach; ?>
    ];

    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                data: data,
                backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#e74a3b'],
                hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf', '#be2617'],
                hoverBorderColor: 'rgba(234, 236, 244, 1)'
            }]
        },
        options: {
            maintainAspectRatio: false,
            legend: {
                position: 'bottom'
            },
            cutoutPercentage: 60
        }
    });
}
</script>