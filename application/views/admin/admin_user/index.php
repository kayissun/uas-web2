<?php $this->load->view('templates/header'); ?>
<?php $this->load->view('templates/sidebar'); ?>
<?php $this->load->view('templates/navbar'); ?>

<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Manajemen User Admin</h1>

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

    <div class="card shadow mb-4">
        <div class="card-body p-4">
            <p>Tambah Admin</p>
            <form method="post" action="<?= base_url('admin_user/tambah') ?>">
                <input type="hidden" 
                    name="<?= $this->security->get_csrf_token_name(); ?>" 
                    value="<?= $this->security->get_csrf_hash(); ?>">
                <div class="form-row align-items-center">
                    <div class="col-md-4 mb-2">
                        <input type="text" name="username" 
                            class="form-control form-control-sm" 
                            placeholder="Username" required>
                    </div>
                    <div class="col-md-4 mb-2">
                        <input type="password" name="password" 
                            class="form-control form-control-sm" 
                            placeholder="Password" required>
                    </div>
                    <div class="col-md-2 mb-2">
                        <button type="submit" 
                            class="btn btn-primary btn-sm btn-block">
                            <i class="fas fa-plus pr-1"></i>Tambah
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="text-center bg-dark text-white">
                        <tr>
                            <th>No</th>
                            <th>Username</th>
                            <th>Login Gagal</th>
                            <th>Last Attempt</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($admins)): ?>
                            <tr><td colspan="5" class="text-center">Data admin kosong</td></tr>
                        <?php endif; ?>
                        <?php foreach($admins as $admin): ?>
                        <tr>
                            <td><?= ++$start ?></td>
                            <td><?= $admin->username ?></td>
                            <td class="text-center"><?= $admin->failed_login ?? 0 ?></td>
                            <td class="text-center"><?= $admin->last_attempt ? date('d M Y H:i', strtotime($admin->last_attempt)) : '-' ?></td>
                            <td class="text-center">
                                <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#edit<?= $admin->id ?>">
                                    Edit
                                </button>
                                <form method="post" action="<?= base_url('admin_user/hapus/'.$admin->id) ?>" style="display:inline-block; margin-left:5px;">
                                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus admin ini?')">Hapus</button>
                                </form>
                                <form method="post" action="<?= base_url('admin_user/reset/'.$admin->id) ?>" style="display:inline-block; margin-left:5px;">
                                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                                    <button class="btn btn-info btn-sm">Reset Login</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                <?= $this->pagination->create_links(); ?>
            </div>
        </div>
    </div>

    <?php foreach($admins as $admin): ?>
    <div class="modal fade" id="edit<?= $admin->id ?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="<?= base_url('admin_user/edit/'.$admin->id) ?>">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Admin</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" value="<?= $admin->username ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Password Baru 
                                <span class="text-danger"><br>
                                    <small>kosongkan bila tidak diganti*</small>
                                </span>
                            </label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Konfirmasi Password</label>
                            <input type="password" name="password_confirm" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php endforeach; ?>

</div>

<?php $this->load->view('templates/footer'); ?>
<?php $this->load->view('templates/scripts'); ?>