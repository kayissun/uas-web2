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

    .form-section { background: var(--paper); padding: 1.5rem; border-radius: .9rem; margin-bottom: 2rem; border: 1px solid var(--border); }

    .form-section h6 { font-family: 'Fraunces', serif; font-size: 1rem; font-weight: 600; margin-bottom: 1rem; color: var(--ink); }

    .form-row-compact { display: flex; gap: 1rem; align-items: flex-end; flex-wrap: wrap; }

    .form-row-compact > div { flex: 1; min-width: 140px; }

    .form-control, .form-select {
        border-radius: .6rem;
        border-color: var(--border);
        font-size: .9rem;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--ink-soft);
        box-shadow: 0 0 0 .2rem rgba(31,58,95,.12);
    }

    .btn-submit { background: var(--brass); border: none; color: var(--ink); font-weight: 600; padding: .55rem 1.2rem; border-radius: .6rem; cursor: pointer; }

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

    .btn-action { padding: .35rem .65rem; font-size: .8rem; border-radius: .4rem; border: none; cursor: pointer; }

    .btn-action-edit { background: var(--warning); color: #fff; }
    .btn-action-reset { background: var(--info); color: #fff; }
    .btn-action-delete { background: var(--danger); color: #fff; }

    .action-stack { display: flex; gap: .4rem; align-items: center; flex-wrap: wrap; justify-content: flex-start; }

    .action-stack form { display: inline-flex; margin: 0; }

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

    .pagination .page-link:hover { background: var(--paper); }

    .pagination .page-item.active .page-link { background: var(--ink); border-color: var(--ink); }
</style>

<div class="container-fluid">

    <div class="mb-4">
        <h1 class="page-title">Manajemen User</h1>
        <p style="color: var(--text-muted); font-size: .95rem;">Kelola akun admin dan petugas hotel</p>
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

    <!-- Form Tambah User -->
    <div class="form-section">
        <h6><i class="fas fa-user-plus me-2"></i>Tambah User Baru</h6>
        <form method="post" action="<?= base_url('admin_user/tambah') ?>">
            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
            <div class="form-row-compact">
                <div>
                    <input type="text" name="username" class="form-control" placeholder="Username" required>
                </div>
                <div>
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>
                <div>
                    <input type="password" name="password_confirm" class="form-control" placeholder="Konfirmasi Password" required>
                </div>
                <div style="min-width: 140px;">
                    <select name="role" class="form-select" required>
                        <option value="petugas">Petugas</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <div>
                    <button type="submit" class="btn-submit w-100">
                        <i class="fas fa-plus me-1"></i>Tambah User
                    </button>
                </div>
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
                        <th>Username</th>
                        <th>Login Gagal</th>
                        <th>Percobaan Terakhir</th>
                        <th style="width: 200px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($admins)): ?>
                    <tr><td colspan="5" class="text-center py-4"><i class="fas fa-inbox text-muted me-2"></i>Tidak ada user</td></tr>
                    <?php endif; ?>
                    <?php foreach($admins as $admin): ?>
                    <tr>
                        <td class="text-center"><?= ++$start ?></td>
                        <td>
                            <div style="font-weight: 600; color: var(--ink);"><?= $admin->username ?></div>
                        </td>
                        <td class="text-center"><?= $admin->failed_login ?? 0 ?></td>
                        <td class="text-center">
                            <small style="color: var(--text-muted);">
                                <?= $admin->last_attempt ? date('d M Y H:i', strtotime($admin->last_attempt)) : '-' ?>
                            </small>
                        </td>
                        <td>
                            <div class="action-stack">
                                <button class="btn-action btn-action-edit" data-bs-toggle="modal" data-bs-target="#edit<?= $admin->id ?>">
                                    <i class="fas fa-pen me-1"></i>Edit
                                </button>
                                <form method="post" action="<?= base_url('admin_user/reset/'.$admin->id) ?>">
                                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                                    <button class="btn-action btn-action-reset">
                                        <i class="fas fa-redo me-1"></i>Reset
                                    </button>
                                </form>
                                <form method="post" action="<?= base_url('admin_user/hapus/'.$admin->id) ?>">
                                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                                    <button class="btn-action btn-action-delete" onclick="return confirm('Yakin hapus user ini?')">
                                        <i class="fas fa-trash me-1"></i>Hapus
                                    </button>
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

<!-- Modal Edit User -->
<?php foreach($admins as $admin): ?>
<div class="modal fade" id="edit<?= $admin->id ?>" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-custom">
                <h5 class="modal-title">Edit User</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="post" action="<?= base_url('admin_user/edit/'.$admin->id) ?>">
                <div class="modal-body">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                    
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" value="<?= $admin->username ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password Baru</label>
                        <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak diubah">
                        <small class="form-text text-muted">Biarkan kosong jika tidak ingin mengubah password</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Konfirmasi Password</label>
                        <input type="password" name="password_confirm" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <select name="role" class="form-select" required>
                            <option value="petugas" <?= ($admin->role == 'petugas') ? 'selected' : '' ?>>Petugas</option>
                            <option value="admin" <?= ($admin->role == 'admin') ? 'selected' : '' ?>>Admin</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn" style="background: var(--brass); color: var(--ink); border: none; font-weight: 600;">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endforeach; ?>

<?php $this->load->view('templates/footer'); ?>
<?php $this->load->view('templates/scripts'); ?>