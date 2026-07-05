<?php if(empty($pdf)): ?>
<?php $this->load->view('templates/header'); ?>
<?php $this->load->view('templates/sidebar'); ?>
<?php $this->load->view('templates/navbar'); ?>
<?php endif; ?>

<style>
    :root {
        --ink: #14213D;
        --ink-soft: #1F3A5F;
        --brass: #C9A227;
        --paper: #F7F5F0;
        --text-dark: #23272F;
        --text-muted: #6B7280;
        --border: #E8E6E1;
    }

    .report-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 2rem 0;
        border-bottom: 2px solid var(--border);
        margin-bottom: 2rem;
    }

    .report-header h4 {
        font-family: 'Poppins', serif;
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--ink);
        margin: 0;
    }

    .report-meta {
        text-align: right;
    }

    .report-meta p {
        margin: 0.25rem 0;
        font-size: 0.9rem;
        color: var(--text-muted);
    }

    .table-wrapper { border: 1px solid var(--border); border-radius: .6rem; overflow: hidden; margin-bottom: 2rem; }

    .table { margin: 0; font-size: .85rem; }

    .table thead {
        background: var(--ink);
        color: #fff;
    }

    .table thead th {
        font-size: .7rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .05em;
        padding: .8rem;
        border: none;
        text-align: center;
    }

    .table tbody td {
        padding: .75rem .8rem;
        border-color: var(--border);
        font-size: .85rem;
    }

    .table tbody tr { border-bottom: 1px solid var(--border); }

    .table tbody tr:nth-child(even) { background: var(--paper); }

    .text-center { text-align: center; }
    .text-right { text-align: right; }

    .btn-print {
        background: var(--ink);
        color: #fff;
        border: none;
        padding: .55rem 1.2rem;
        border-radius: .6rem;
        font-weight: 600;
        cursor: pointer;
        font-size: .9rem;
        transition: background .15s ease;
    }

    .btn-print:hover { background: var(--ink-soft); }

    @media print {
        .btn-print { display: none; }
        body { background: #fff; }
        .report-header { border-bottom: 1px solid var(--border); }
    }

    @media (max-width: 768px) {
        .report-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }

        .report-meta { text-align: left; }

        .table { font-size: .8rem; }
        .table thead th { padding: .6rem; }
        .table tbody td { padding: .6rem; }
    }
</style>

<div class="container-fluid">

    <div class="report-header">
        <div>
            <h4><i class="fas fa-file-alt me-2" style="color: var(--brass);"></i>Laporan Reservasi</h4>
        </div>
        <div class="report-meta">
            <p><strong>Tanggal Cetak:</strong> <?= date('d M Y H:i') ?></p>
            <?php if(empty($pdf)): ?>
            <button type="button" class="btn-print" onclick="window.print()">
                <i class="fas fa-print me-1"></i>Cetak Halaman
            </button>
            <?php endif; ?>
        </div>
    </div>

    <div class="table-wrapper">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 40px;">No</th>
                        <th>Kamar</th>
                        <th>Nama Kamar</th>
                        <th>Petugas</th>
                        <th>Nama Tamu</th>
                        <th>Telepon</th>
                        <th>Check-in</th>
                        <th>Check-out</th>
                        <th class="text-right">Total Harga</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $status_labels = [
                        'booked' => 'Dipesan',
                        'checked_in' => 'Check In',
                        'checked_out' => 'Check Out',
                        'cancelled' => 'Dibatalkan'
                    ];
                    $no = 1;
                    foreach($reservations as $reservation):
                    ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td style="font-weight: 600; color: var(--brass);"><?= esc($reservation->room_code) ?></td>
                        <td><?= esc($reservation->room_name) ?></td>
                        <td><?= esc($reservation->username) ?></td>
                        <td><?= esc($reservation->guest_name) ?></td>
                        <td><?= esc($reservation->guest_phone) ?></td>
                        <td><?= esc($reservation->check_in) ?></td>
                        <td><?= esc($reservation->check_out) ?></td>
                        <td class="text-right">Rp <?= number_format($reservation->total_price, 0, ',', '.') ?></td>
                        <td><?= esc($status_labels[$reservation->status] ?? ucfirst(str_replace('_', ' ', $reservation->status))) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php if(empty($reservations)): ?>
    <div style="text-align: center; padding: 2rem; color: var(--text-muted);">
        <i class="fas fa-inbox" style="font-size: 2rem; margin-bottom: 1rem;"></i>
        <p>Tidak ada data reservasi untuk ditampilkan</p>
    </div>
    <?php endif; ?>

</div>

<?php if(empty($pdf)): ?>
<?php $this->load->view('templates/footer'); ?>
<?php $this->load->view('templates/scripts'); ?>
<?php endif; ?>