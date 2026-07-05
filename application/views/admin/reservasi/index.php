<?php $this->load->view('templates/header'); ?>
<?php $this->load->view('templates/sidebar'); ?>
<?php $this->load->view('templates/navbar'); ?>

<style>
    :root {
        --ink: #14213D;
        --ink-soft: #1F3A5F;
        --brass: #C9A227;
        --brass-soft: #E4C766;
        --paper: #F7F5F0;
        --text-dark: #23272F;
        --text-muted: #6B7280;
        --border: #E8E6E1;
        --success: #10B981;
        --warning: #F59E0B;
        --info: #3B82F6;
        --danger: #EF4444;
    }

    .filter-section { background: var(--paper); padding: 1.5rem; border-radius: .9rem; margin-bottom: 2rem; }

    .filter-group { display: flex; gap: 1rem; align-items: flex-end; flex-wrap: wrap; }

    .form-control, .form-select {
        border-radius: .6rem;
        border-color: var(--border);
        font-size: .9rem;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--ink-soft);
        box-shadow: 0 0 0 .2rem rgba(31,58,95,.12);
    }

    .btn-filter { background: var(--ink); border: none; color: #fff; font-weight: 600; padding: .55rem 1.2rem; border-radius: .6rem; cursor: pointer; transition: background .15s ease; }

    .btn-filter:hover { background: var(--ink-soft); }

    .btn-add { background: var(--brass); border: none; color: var(--ink); font-weight: 600; padding: .55rem 1.2rem; border-radius: .6rem; cursor: pointer; transition: background .15s ease; }

    .btn-add:hover { background: var(--brass-soft); }

    .btn-export { background: transparent; border: 1px solid var(--border); color: var(--text-dark); font-weight: 600; padding: .55rem 1.2rem; border-radius: .6rem; cursor: pointer; transition: all .15s ease; }

    .btn-export:hover { background: var(--paper); }

    .table-wrapper { border: 1px solid var(--border); border-radius: .9rem; overflow: hidden; }

    .table { margin: 0; font-size: .9rem; }

    .table thead {
        background: var(--ink);
        color: #fff;
    }

    .table thead th {
        font-size: .75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .05em;
        padding: .9rem .8rem;
        border: none;
    }

    .table tbody td { padding: .8rem; border-color: var(--border); }

    .table tbody tr { border-bottom: 1px solid var(--border); }

    .table tbody tr:hover { background: var(--paper); }

    .badge-custom {
        font-size: .7rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .04em;
        padding: .35rem .7rem;
        border-radius: .4rem;
    }

    .badge-booked { background: rgba(59,130,246,.1); color: var(--info); }
    .badge-checked_in { background: rgba(16,185,129,.1); color: var(--success); }
    .badge-checked_out { background: rgba(16,185,129,.1); color: var(--success); }
    .badge-cancelled { background: rgba(239,68,68,.1); color: var(--danger); }

    .btn-action { padding: .35rem .65rem; font-size: .8rem; border-radius: .4rem; border: none; cursor: pointer; transition: all .15s ease; }

    .btn-action-update { background: var(--info); color: #fff; }
    .btn-action-update:hover { background: #2563EB; }

    .btn-action-delete { background: var(--danger); color: #fff; }
    .btn-action-delete:hover { background: #DC2626; }

    .action-stack { display: flex; gap: .45rem; align-items: center; flex-wrap: wrap; justify-content: flex-start; }

    .action-stack form { display: inline-flex; margin: 0; }

    .action-stack select { padding: .4rem .6rem; font-size: .85rem; border-radius: .4rem; border: 1px solid var(--border); min-width: 118px; }

    .alert-custom {
        border: none;
        border-radius: .6rem;
        padding: 1rem;
        margin-bottom: 1.5rem;
    }

    .alert-success-custom { background: rgba(16,185,129,.1); color: #047857; }
    .alert-danger-custom { background: rgba(239,68,68,.1); color: #991B1B; }

    .modal-header-custom { background: var(--ink); color: #fff; }

    .modal-title { font-family: 'Fraunces', serif; font-weight: 600; }

    .form-label { font-size: .8rem; font-weight: 600; color: var(--text-dark); text-transform: uppercase; letter-spacing: .03em; margin-bottom: .4rem; }

    .pagination { justify-content: center; margin-top: 2rem; }

    .pagination .page-link {
        color: var(--text-dark);
        border-color: var(--border);
        border-radius: .4rem;
        margin: 0 .2rem;
    }

    .pagination .page-link:hover { background: var(--paper); border-color: var(--ink); }

    .pagination .page-item.active .page-link { background: var(--ink); border-color: var(--ink); }
</style>

<div class="container-fluid">

    <div class="mb-4">
        <h1 class="page-title">Manajemen Reservasi</h1>
        <p style="color: var(--text-muted); font-size: .95rem;">Kelola semua reservasi tamu hotel Anda</p>
    </div>

    <?php if($this->session->flashdata('success')): ?>
    <div class="alert alert-custom alert-success-custom">
        <i class="fas fa-check-circle me-2"></i><?= $this->session->flashdata('success') ?>
    </div>
    <?php endif; ?>
    <?php if($this->session->flashdata('error')): ?>
    <div class="alert alert-custom alert-danger-custom">
        <i class="fas fa-exclamation-circle me-2"></i><?= $this->session->flashdata('error') ?>
    </div>
    <?php endif; ?>

    <!-- Filter Section -->
    <div class="filter-section">
        <form method="post" action="<?= base_url('reservasi') ?>">
            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
            <div class="filter-group">
                <div style="flex: 1; min-width: 200px;">
                    <input type="text" name="keyword" class="form-control" placeholder="Cari nama tamu atau kamar..." value="<?= esc($keyword ?? '') ?>">
                </div>
                <div style="min-width: 160px;">
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <?php foreach($status_options as $key => $label): ?>
                        <option value="<?= $key ?>" <?= ($filter_status == $key) ? 'selected' : '' ?>><?= $label ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="btn-filter"><i class="fas fa-filter me-1"></i>Filter</button>
                <button type="button" class="btn-add" data-bs-toggle="modal" data-bs-target="#modalTambah"><i class="fas fa-plus me-1"></i>Tambah</button>
                <a href="<?= base_url('reservasi/export_excel') ?>" class="btn-export"><i class="fas fa-file-excel me-1"></i>Excel</a>
                <a href="<?= base_url('reservasi/export_pdf') ?>" class="btn-export"><i class="fas fa-file-pdf me-1"></i>PDF</a>
                <a href="<?= base_url('reservasi/print_report') ?>" target="_blank" class="btn-export"><i class="fas fa-print me-1"></i>Cetak</a>
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="table-wrapper">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Kamar</th>
                        <th>Petugas</th>
                        <th>Nama Tamu</th>
                        <th>Telepon</th>
                        <th>Check-in</th>
                        <th>Check-out</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th style="width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($reservations)): ?>
                    <tr><td colspan="10" class="text-center py-4"><i class="fas fa-inbox text-muted me-2"></i>Tidak ada reservasi</td></tr>
                    <?php endif; ?>
                    <?php foreach($reservations as $reservation): ?>
                    <tr>
                        <td class="text-center"><?= ++$start ?></td>
                        <td>
                            <div style="font-weight: 600; color: var(--brass);"><?= esc($reservation->room_code) ?></div>
                            <div style="font-size: .8rem; color: var(--text-muted);"><?= esc($reservation->room_name) ?></div>
                        </td>
                        <td><?= esc($reservation->username) ?></td>
                        <td><?= esc($reservation->guest_name) ?></td>
                        <td><?= esc($reservation->guest_phone) ?></td>
                        <td><?= esc($reservation->check_in) ?></td>
                        <td><?= esc($reservation->check_out) ?></td>
                        <td>Rp <?= number_format($reservation->total_price, 0, ',', '.') ?></td>
                        <td>
                            <span class="badge-custom badge-<?= $reservation->status ?>">
                                <?= esc($status_options[$reservation->status] ?? ucfirst(str_replace('_', ' ', $reservation->status))) ?>
                            </span>
                        </td>
                        <td>
                            <div class="action-stack">
                                <form method="post" action="<?= base_url('reservasi/update_status/'.$reservation->id) ?>">
                                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                                    <select name="status" class="form-select form-select-sm">
                                        <?php foreach($status_options as $key => $label): ?>
                                        <option value="<?= $key ?>" <?= ($reservation->status == $key) ? 'selected' : '' ?>><?= $label ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <button class="btn-action btn-action-update" style="white-space: nowrap;">Update</button>
                                </form>
                                <form method="post" action="<?= base_url('reservasi/hapus/'.$reservation->id) ?>">
                                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                                    <button class="btn-action btn-action-delete" onclick="return confirm('Yakin hapus?')">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <nav aria-label="Page navigation">
        <ul class="pagination">
            <?= $this->pagination->create_links(); ?>
        </ul>
    </nav>

</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-custom">
                <h5 class="modal-title">Tambah Reservasi Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="post" action="<?= base_url('reservasi/tambah') ?>">
                <div class="modal-body">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                    
                    <div class="mb-3">
                        <label class="form-label">Kamar</label>
                        <select name="room_id" class="form-select" required>
                            <option value="">Pilih kamar</option>
                            <?php foreach($rooms as $room): ?>
                            <option value="<?= $room->id ?>"><?= esc($room->room_code.' — '.$room->room_name) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama Tamu</label>
                        <input type="text" name="guest_name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">No. Telepon</label>
                        <input type="text" name="guest_phone" class="form-control" required>
                    </div>

                    <div class="row g-2">
                        <div class="col-md-6">
                            <label class="form-label">Check-in</label>
                            <input type="date" name="check_in" id="check_in" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Check-out</label>
                            <input type="date" name="check_out" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn" style="background: var(--brass); color: var(--ink); border: none; font-weight: 600;">Simpan Reservasi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $this->load->view('templates/footer'); ?>
<?php $this->load->view('templates/scripts'); ?>

<script>
const dateInput = document.getElementById('check_in');
const today = new Date().toISOString().split('T')[0];
dateInput.value = today;
</script>