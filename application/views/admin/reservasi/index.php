<?php $this->load->view('templates/header'); ?>
<?php $this->load->view('templates/sidebar'); ?>
<?php $this->load->view('templates/navbar'); ?>

<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Manajemen Reservasi</h1>

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
            <form method="post" action="<?= base_url('reservasi') ?>" class="form-inline mb-3">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                <div class="form-group mr-2">
                    <input type="text" name="keyword" class="form-control" placeholder="Cari reservasi..." value="<?= esc($keyword ?? '') ?>">
                </div>
                <div class="form-group mr-2">
                    <select name="status" class="form-control">
                        <option value="">Semua Status</option>
                        <?php foreach($status_options as $key => $label): ?>
                        <option value="<?= $key ?>" <?= ($filter_status == $key) ? 'selected' : '' ?>><?= $label ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary mr-2">Filter</button>
                <button type="button" class="btn btn-success mr-2" data-toggle="modal" data-target="#modalTambah">Tambah Reservasi</button>
                <a href="<?= base_url('reservasi/export_excel') ?>" class="btn btn-outline-success mr-2">Export Excel</a>
                <a href="<?= base_url('reservasi/export_pdf') ?>" class="btn btn-outline-danger mr-2">Export PDF</a>
                <a href="<?= base_url('reservasi/print_report') ?>" target="_blank" class="btn btn-outline-secondary">Cetak</a>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
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
                            <th>Total</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($reservations)): ?>
                        <tr><td colspan="11" class="text-center">Reservasi kosong</td></tr>
                        <?php endif; ?>
                        <?php foreach($reservations as $reservation): ?>
                        <tr>
                            <td class="text-center"><?= ++$start ?></td>
                            <td><?= esc($reservation->room_code) ?></td>
                            <td><?= esc($reservation->room_name) ?></td>
                            <td><?= esc($reservation->username) ?></td>
                            <td><?= esc($reservation->guest_name) ?></td>
                            <td><?= esc($reservation->guest_phone) ?></td>
                            <td><?= esc($reservation->check_in) ?></td>
                            <td><?= esc($reservation->check_out) ?></td>
                            <td><?= number_format($reservation->total_price, 0, ',', '.') ?></td>
                            <td class="text-center">
                                <span class="badge badge-<?= ($reservation->status == 'booked') ? 'secondary' : (($reservation->status == 'checked_in') ? 'primary' : (($reservation->status == 'checked_out') ? 'success' : 'danger')) ?>">
                                    <?= ucfirst(str_replace('_', ' ', $reservation->status)) ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <form method="post" action="<?= base_url('reservasi/hapus/'.$reservation->id) ?>" style="display:inline-block;">
                                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus reservasi ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
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
            <form method="post" action="<?= base_url('reservasi/tambah') ?>">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Reservasi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Kamar</label>
                        <select name="room_id" class="form-control" required>
                            <option value="">Pilih kamar</option>
                            <?php foreach($rooms as $room): ?>
                            <option value="<?= $room->id ?>"><?= esc($room->room_code.' - '.$room->room_name.' ('.ucfirst($room->status).')') ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Nama Tamu</label>
                        <input type="text" name="guest_name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>No. Telepon</label>
                        <input type="text" name="guest_phone" class="form-control" required>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Check-in</label>
                            <input type="date" name="check_in" class="form-control" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Check-out</label>
                            <input type="date" name="check_out" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Simpan Reservasi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $this->load->view('templates/footer'); ?>
<?php $this->load->view('templates/scripts'); ?>
