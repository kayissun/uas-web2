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

    .btn-filter { background: var(--ink); border: none; color: #fff; font-weight: 600; padding: .55rem 1.2rem; border-radius: .6rem; cursor: pointer; }

    .btn-add { background: var(--brass); border: none; color: var(--ink); font-weight: 600; padding: .55rem 1.2rem; border-radius: .6rem; cursor: pointer; }

    .table-wrapper { border: 1px solid var(--border); border-radius: .9rem; overflow: hidden; }

    .table { margin: 0; font-size: .9rem; }

    .table thead { background: var(--ink); color: #fff; }

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

    .room-img { width: 80px; height: 80px; object-fit: cover; border-radius: .5rem; }

    .badge-status {
        font-size: .7rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .04em;
        padding: .35rem .7rem;
        border-radius: .4rem;
    }

    .badge-available { background: rgba(16,185,129,.1); color: var(--success); }
    .badge-occupied { background: rgba(239,68,68,.1); color: var(--danger); }
    .badge-maintenance { background: rgba(245,158,11,.1); color: var(--warning); }

    .dropdown-menu { border: 1px solid var(--border); border-radius: .6rem; box-shadow: 0 4px 12px rgba(0,0,0,.1); }

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

    .form-file-label { display: flex; align-items: center; justify-content: center; width: 100%; padding: 2rem; border: 2px dashed var(--border); border-radius: .6rem; cursor: pointer; transition: all .15s ease; background: var(--paper); }

    .form-file-label:hover { border-color: var(--brass); background: rgba(201,162,39,.05); }

    .form-file-label i { color: var(--brass); margin-right: .5rem; }

    .pagination { justify-content: center; margin-top: 2rem; }

    .pagination .page-link {
        color: var(--text-dark);
        border-color: var(--border);
        border-radius: .4rem;
        margin: 0 .2rem;
    }

    .pagination .page-link:hover { background: var(--paper); }

    .pagination .page-item.active .page-link { background: var(--ink); border-color: var(--ink); }
</style>

<div class="container-fluid">

    <div class="mb-4">
        <h1 class="page-title">Manajemen Kamar</h1>
        <p style="color: var(--text-muted); font-size: .95rem;">Kelola data kamar dan inventory hotel</p>
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
        <form method="post" action="<?= base_url('kamar') ?>">
            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
            <div class="filter-group">
                <div style="flex: 1; min-width: 200px;">
                    <input type="text" name="keyword" class="form-control" placeholder="Cari kode atau nama kamar..." value="<?= esc($keyword ?? '') ?>">
                </div>
                <div style="min-width: 160px;">
                    <select name="type_id" class="form-select">
                        <option value="">Semua Tipe</option>
                        <?php foreach($types as $type): ?>
                        <option value="<?= $type->id ?>" <?= ($filter_type == $type->id) ? 'selected' : '' ?>><?= esc($type->type_name) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div style="min-width: 160px;">
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="available" <?= ($filter_status=='available') ? 'selected' : '' ?>>Tersedia</option>
                        <option value="occupied" <?= ($filter_status=='occupied') ? 'selected' : '' ?>>Digunakan</option>
                        <option value="maintenance" <?= ($filter_status=='maintenance') ? 'selected' : '' ?>>Perbaikan</option>
                    </select>
                </div>
                <button type="submit" class="btn-filter"><i class="fas fa-filter me-1"></i>Filter</button>
                <button type="button" class="btn-add" data-bs-toggle="modal" data-bs-target="#modalTambah"><i class="fas fa-plus me-1"></i>Tambah</button>
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
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Tipe</th>
                        <th>Harga</th>
                        <th>Kapasitas</th>
                        <th>Status</th>
                        <th>Gambar</th>
                        <th style="width: 90px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($rooms)): ?>
                    <tr><td colspan="9" class="text-center py-4"><i class="fas fa-inbox text-muted me-2"></i>Tidak ada kamar</td></tr>
                    <?php endif; ?>
                    <?php foreach($rooms as $room): ?>
                    <tr>
                        <td class="text-center"><?= ++$start ?></td>
                        <td><span style="font-weight: 600; color: var(--brass);"><?= esc($room->room_code) ?></span></td>
                        <td><?= esc($room->room_name) ?></td>
                        <td><?= esc($room->type_name) ?></td>
                        <td>Rp <?= number_format($room->price, 0, ',', '.') ?></td>
                        <td class="text-center"><?= esc($room->capacity) ?> tamu</td>
                        <td>
                            <span class="badge-status badge-<?= $room->status ?>">
                                <?= ($room->status=='available') ? 'Tersedia' : (($room->status=='occupied') ? 'Digunakan' : 'Perbaikan') ?>
                            </span>
                        </td>
                        <td>
                            <?php if($room->image_path): ?>
                                <img src="<?= base_url('uploads/room_images/'.$room->image_path) ?>" alt="<?= esc($room->room_name) ?>" class="room-img">
                            <?php else: ?>
                                <span style="font-size: .8rem; color: var(--text-muted);">-</span>
                            <?php endif; ?>
                        </td>
                        <td style="text-align: center;">
                            <div class="dropdown" style="display: inline-block;">
                                <button class="btn btn-sm" style="background: var(--ink); color: #fff; border: none; border-radius: .4rem;" type="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-cog"></i> Akses
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" style="font-size: .85rem;">
                                    <li>
                                        <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#edit<?= $room->id ?>">
                                            <i class="fas fa-pen me-2" style="color: var(--warning);"></i>Edit Kamar
                                        </button>
                                    </li>
                                    <li><hr class="dropdown-divider" style="margin: .3rem 0;"></li>
                                    <li>
                                        <form method="post" action="<?= base_url('kamar/hapus/'.$room->id) ?>" onsubmit="return confirm('Yakin hapus kamar ini?')">
                                            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                                            <button type="submit" class="dropdown-item text-danger" style="padding: .5rem 1rem;">
                                                <i class="fas fa-trash me-2"></i>Hapus Kamar
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>

                    <!-- Modal Edit -->
                    <div class="modal fade" id="edit<?= $room->id ?>" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header modal-header-custom">
                                    <h5 class="modal-title">Edit Kamar</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                </div>
                                <form method="post" action="<?= base_url('kamar/edit/'.$room->id) ?>" enctype="multipart/form-data">
                                    <div class="modal-body">
                                        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                                        
                                        <div class="mb-3">
                                            <label class="form-label">Kode Kamar</label>
                                            <input type="text" name="room_code" class="form-control" value="<?= esc($room->room_code) ?>" required>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Nama Kamar</label>
                                            <input type="text" name="room_name" class="form-control" value="<?= esc($room->room_name) ?>" required>
                                        </div>

                                        <div class="row g-2">
                                            <div class="col-md-6">
                                                <label class="form-label">Tipe Kamar</label>
                                                <select name="type_id" class="form-select" required>
                                                    <?php foreach($types as $type): ?>
                                                    <option value="<?= $type->id ?>" <?= ($room->type_id == $type->id) ? 'selected' : '' ?>><?= esc($type->type_name) ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Status</label>
                                                <select name="status" class="form-select" required>
                                                    <option value="available" <?= ($room->status=='available') ? 'selected' : '' ?>>Tersedia</option>
                                                    <option value="occupied" <?= ($room->status=='occupied') ? 'selected' : '' ?>>Digunakan</option>
                                                    <option value="maintenance" <?= ($room->status=='maintenance') ? 'selected' : '' ?>>Perbaikan</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row g-2">
                                            <div class="col-md-6">
                                                <label class="form-label">Harga/Malam</label>
                                                <input type="number" name="price" class="form-control" value="<?= esc($room->price) ?>" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Kapasitas Tamu</label>
                                                <input type="number" name="capacity" class="form-control" value="<?= esc($room->capacity) ?>" required>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Gambar Kamar</label>
                                            <input type="file" name="image" class="form-control" accept="image/*">
                                            <small class="form-text text-muted">Biarkan kosong untuk mempertahankan gambar.</small>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn" style="background: var(--brass); color: var(--ink); border: none; font-weight: 600;">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

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
                <h5 class="modal-title">Tambah Kamar Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="post" action="<?= base_url('kamar/tambah') ?>" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                    
                    <div class="mb-3">
                        <label class="form-label">Kode Kamar</label>
                        <input type="text" name="room_code" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama Kamar</label>
                        <input type="text" name="room_name" class="form-control" required>
                    </div>

                    <div class="row g-2">
                        <div class="col-md-6">
                            <label class="form-label">Tipe Kamar</label>
                            <select name="type_id" class="form-select" required>
                                <option value="">Pilih tipe</option>
                                <?php foreach($types as $type): ?>
                                <option value="<?= $type->id ?>"><?= esc($type->type_name) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select" required>
                                <option value="available">Tersedia</option>
                                <option value="occupied">Digunakan</option>
                                <option value="maintenance">Perbaikan</option>
                            </select>
                        </div>
                    </div>

                    <div class="row g-2">
                        <div class="col-md-6">
                            <label class="form-label">Harga/Malam</label>
                            <input type="number" name="price" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Kapasitas Tamu</label>
                            <input type="number" name="capacity" class="form-control" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Upload Gambar</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn" style="background: var(--brass); color: var(--ink); border: none; font-weight: 600;">Simpan Kamar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $this->load->view('templates/footer'); ?>
<?php $this->load->view('templates/scripts'); ?>