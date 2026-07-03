<?php if(empty($pdf)): ?>
<?php $this->load->view('templates/header'); ?>
<?php $this->load->view('templates/sidebar'); ?>
<?php $this->load->view('templates/navbar'); ?>
<?php endif; ?>

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="font-weight-bold">Laporan Reservasi</h4>
                    <p class="text-muted">Tanggal: <?= date('d M Y H:i') ?></p>
                </div>
                <?php if(empty($pdf)): ?>
                <button onclick="window.print()" class="btn btn-secondary">Cetak</button>
                <?php endif; ?>
            </div>

            <div class="table-responsive">
                <table class="table table-sm table-bordered">
                    <thead class="bg-dark text-white text-center">
                        <tr>
                            <th>No</th>
                            <th>Kode Kamar</th>
                            <th>Nama Kamar</th>
                            <th>Petugas</th>
                            <th>Nama Tamu</th>
                            <th>Telepon</th>
                            <th>Check-in</th>
                            <th>Check-out</th>
                            <th>Total Harga</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach($reservations as $reservation): ?>
                        <tr>
                            <td class="text-center"><?= $no++ ?></td>
                            <td><?= esc($reservation->room_code) ?></td>
                            <td><?= esc($reservation->room_name) ?></td>
                            <td><?= esc($reservation->username) ?></td>
                            <td><?= esc($reservation->guest_name) ?></td>
                            <td><?= esc($reservation->guest_phone) ?></td>
                            <td><?= esc($reservation->check_in) ?></td>
                            <td><?= esc($reservation->check_out) ?></td>
                            <td><?= number_format($reservation->total_price, 0, ',', '.') ?></td>
                            <td><?= ucfirst(str_replace('_', ' ', $reservation->status)) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php if(empty($pdf)): ?>
<?php $this->load->view('templates/footer'); ?>
<?php $this->load->view('templates/scripts'); ?>
<?php endif; ?>
