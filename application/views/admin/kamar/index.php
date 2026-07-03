<?php $this->load->view('templates/header'); ?>
<?php $this->load->view('templates/sidebar'); ?>
<?php $this->load->view('templates/navbar'); ?>

<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Manajemen Kamar</h1>

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
        <div class="card-body">
            <form method="post" action="<?= base_url('kamar') ?>" class="form-inline mb-3">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                <div class="form-group mr-2">
                    <input type="text" name="keyword" class="form-control" placeholder="Cari kamar..." value="<?= esc($keyword ?? '') ?>">
                </div>
                <div class="form-group mr-2">
                    <select name="type_id" class="form-control">
                        <option value="">Semua Tipe</option>
                        <?php foreach($types as $type): ?>
                            <option value="<?= $type->id ?>" <?= ($filter_type == $type->id) ? 'selected' : '' ?>><?= esc($type->type_name) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group mr-2">
                    <select name="status" class="form-control">
                        <option value="">Semua Status</option>
                        <option value="available" <?= ($filter_status=='available') ? 'selected' : '' ?>>Available</option>
                        <option value="occupied" <?= ($filter_status=='occupied') ? 'selected' : '' ?>>Occupied</option>
                        <option value="maintenance" <?= ($filter_status=='maintenance') ? 'selected' : '' ?>>Maintenance</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary mr-2">Filter</button>
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalTambah">Tambah Kamar</button>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="bg-dark text-white text-center">
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Tipe</th>
                            <th>Harga</th>
                            <th>Kapasitas</th>
                            <th>Status</th>
                            <th>Gambar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($rooms)): ?>
                        <tr><td colspan="9" class="text-center">Data kamar kosong</td></tr>
                        <?php endif; ?>
                        <?php foreach($rooms as $room): ?>
                        <tr>
                            <td class="text-center"><?= ++$start ?></td>
                            <td><?= esc($room->room_code) ?></td>
                            <td><?= esc($room->room_name) ?></td>
                            <td><?= esc($room->type_name) ?></td>
                            <td><?= number_format($room->price, 0, ',', '.') ?></td>
                            <td class="text-center"><?= esc($room->capacity) ?></td>
                            <td class="text-center">
                                <span class="badge badge-<?= ($room->status=='available') ? 'success' : (($room->status=='occupied') ? 'danger' : 'warning') ?>">
                                    <?= ucfirst($room->status) ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <?php if($room->image_path): ?>
                                    <img src="<?= base_url('uploads/room_images/'.$room->image_path) ?>" width="80" alt="<?= esc($room->room_name) ?>">
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#edit<?= $room->id ?>">Edit</button>
                                <form method="post" action="<?= base_url('kamar/hapus/'.$room->id) ?>" style="display:inline-block;">
                                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus kamar ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>

                        <div class="modal fade" id="edit<?= $room->id ?>" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <form method="post" action="<?= base_url('kamar/edit/'.$room->id) ?>" enctype="multipart/form-data">
                                        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Kamar</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label>Kode Kamar</label>
                                                <input type="text" name="room_code" class="form-control" value="<?= esc($room->room_code) ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Nama Kamar</label>
                                                <input type="text" name="room_name" class="form-control" value="<?= esc($room->room_name) ?>" required>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label>Tipe Kamar</label>
                                                    <select name="type_id" class="form-control" required>
                                                        <?php foreach($types as $type): ?>
                                                            <option value="<?= $type->id ?>" <?= ($room->type_id == $type->id) ? 'selected' : '' ?>><?= esc($type->type_name) ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label>Status</label>
                                                    <select name="status" class="form-control" required>
                                                        <option value="available" <?= ($room->status=='available') ? 'selected' : '' ?>>Available</option>
                                                        <option value="occupied" <?= ($room->status=='occupied') ? 'selected' : '' ?>>Occupied</option>
                                                        <option value="maintenance" <?= ($room->status=='maintenance') ? 'selected' : '' ?>>Maintenance</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label>Harga</label>
                                                    <input type="number" name="price" class="form-control" value="<?= esc($room->price) ?>" required>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label>Kapasitas</label>
                                                    <input type="number" name="capacity" class="form-control" value="<?= esc($room->capacity) ?>" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Gambar Kamar</label>
                                                <input type="file" name="image" class="form-control-file">
                                                <?php if($room->image_path): ?>
                                                    <small class="form-text text-muted">Biarkan kosong untuk mempertahankan gambar saat ini.</small>
                                                <?php endif; ?>
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
                    </tbody>
                </table>
            </div>

            <div class="mt-3"><?= $this->pagination->create_links(); ?></div>
        </div>
    </div>

</div>

<div class="modal fade" id="modalTambah" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" action="<?= base_url('kamar/tambah') ?>" enctype="multipart/form-data">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Kamar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Kode Kamar</label>
                        <input type="text" name="room_code" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Nama Kamar</label>
                        <input type="text" name="room_name" class="form-control" required>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Tipe Kamar</label>
                            <select name="type_id" class="form-control" required>
                                <option value="">Pilih tipe</option>
                                <?php foreach($types as $type): ?>
                                    <option value="<?= $type->id ?>"><?= esc($type->type_name) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Status</label>
                            <select name="status" class="form-control" required>
                                <option value="available">Available</option>
                                <option value="occupied">Occupied</option>
                                <option value="maintenance">Maintenance</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Harga</label>
                            <input type="number" name="price" class="form-control" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Kapasitas</label>
                            <input type="number" name="capacity" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Upload Gambar</label>
                        <input type="file" name="image" class="form-control-file">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $this->load->view('templates/footer'); ?>
<?php $this->load->view('templates/scripts'); ?>
