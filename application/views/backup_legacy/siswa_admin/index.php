<?php $this->load->view('templates/header'); ?>
<?php $this->load->view('templates/sidebar'); ?>
<?php $this->load->view('templates/navbar'); ?>

<div class="container-fluid">

<h1 class="h3 mb-4 text-gray-800">Data Siswa</h1>

<!-- ALERT -->
<?php if($this->session->flashdata('success')): ?>
<div class="alert alert-success">
    <?= $this->session->flashdata('success') ?>
</div>
<?php endif; ?>

<?php if($this->session->flashdata('error')): ?>
<div class="alert alert-danger">
    <?= $this->session->flashdata('error') ?>
</div>
<?php endif; ?>

<!-- SEARCH -->
<form method="post" action="<?= base_url('siswa') ?>">
    <input type="hidden" 
    name="<?= $this->security->get_csrf_token_name(); ?>" 
    value="<?= $this->security->get_csrf_hash(); ?>">

    <div class="input-group mb-3">
        <input type="text" name="keyword" class="form-control" placeholder="Cari siswa...">
        <div class="input-group-append">
            <button class="btn btn-primary">Search</button>
        </div>
    </div>
</form>

<!-- BUTTON TAMBAH -->
<button class="btn btn-primary mb-3" data-toggle="modal" data-target="#modalTambah">
    Tambah Siswa
</button>

<!-- TABLE -->
<div class="card shadow">
<div class="card-body">

<table class="table table-bordered table-striped">

<thead class="text-center">
<tr>
    <th>No</th>
    <th>NIS</th>
    <th>Nama</th>
    <th>Kelas</th>
    <th>Jurusan</th>
    <th>Status</th>
    <th>Aksi</th>
</tr>
</thead>

<tbody>

<?php if(empty($siswa)): ?>
<tr><td colspan="7" class="text-center">Data kosong</td></tr>
<?php endif; ?>

<?php foreach($siswa as $s): ?>
<tr>
    <td><?= ++$start ?></td>
    <td><?= $s->nis ?></td>
    <td><?= $s->nama ?></td>
    <td><?= $s->kelas ?></td>
    <td><?= $s->jurusan ?></td>
    <td>
        <span class="badge badge-<?= ($s->status=='LULUS') ? 'success':'danger' ?>">
            <?= $s->status ?>
        </span>
    </td>
    <td>

        <!-- EDIT -->
        <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#edit<?= $s->id ?>">
            Edit
        </button>

        <!-- HAPUS -->
        <form method="post" action="<?= base_url('siswa/hapus/'.$s->id) ?>" style="display:inline">

        <input type="hidden" 
        name="<?= $this->security->get_csrf_token_name(); ?>" 
        value="<?= $this->security->get_csrf_hash(); ?>">

        <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">
            Hapus
        </button>

        </form>

    </td>
</tr>

<!-- MODAL EDIT -->
<div class="modal fade" id="edit<?= $s->id ?>">
<div class="modal-dialog">
<div class="modal-content">

<form method="post" action="<?= base_url('siswa/edit/'.$s->id) ?>">

<input type="hidden" 
name="<?= $this->security->get_csrf_token_name(); ?>" 
value="<?= $this->security->get_csrf_hash(); ?>">

<div class="modal-header">
    <h5 class="modal-title">Edit Siswa</h5>
    <button type="button" class="close" data-dismiss="modal">&times;</button>
</div>

<div class="modal-body">

<input type="text" name="nis" class="form-control mb-2" value="<?= $s->nis ?>" required>
<input type="text" name="nama" class="form-control mb-2" value="<?= $s->nama ?>" required>
<input type="text" name="kelas" class="form-control mb-2" value="<?= $s->kelas ?>">
<input type="text" name="jurusan" class="form-control mb-2" value="<?= $s->jurusan ?>">

<select name="status" class="form-control">
    <option value="LULUS" <?= ($s->status=='LULUS')?'selected':'' ?>>LULUS</option>
    <option value="TIDAK LULUS" <?= ($s->status=='TIDAK LULUS')?'selected':'' ?>>TIDAK LULUS</option>
</select>

</div>

<div class="modal-footer">
    <button class="btn btn-primary">Update</button>
</div>

</form>

</div>
</div>
</div>

<?php endforeach; ?>

</tbody>

</table>

<!-- PAGINATION -->
<div class="mt-3">
<?= $this->pagination->create_links(); ?>
</div>

</div>
</div>

</div>

<!-- MODAL TAMBAH -->
<div class="modal fade" id="modalTambah">
<div class="modal-dialog">
<div class="modal-content">

<form method="post" action="<?= base_url('siswa/tambah') ?>">

<input type="hidden" 
name="<?= $this->security->get_csrf_token_name(); ?>" 
value="<?= $this->security->get_csrf_hash(); ?>">

<div class="modal-header">
    <h5 class="modal-title">Tambah Siswa</h5>
    <button type="button" class="close" data-dismiss="modal">&times;</button>
</div>

<div class="modal-body">

<input type="text" name="nis" class="form-control mb-2" placeholder="NIS" required>
<input type="text" name="nama" class="form-control mb-2" placeholder="Nama" required>
<input type="text" name="kelas" class="form-control mb-2" placeholder="Kelas">
<input type="text" name="jurusan" class="form-control mb-2" placeholder="Jurusan">

<select name="status" class="form-control">
    <option value="LULUS">LULUS</option>
    <option value="TIDAK LULUS">TIDAK LULUS</option>
</select>

</div>

<div class="modal-footer">
    <button class="btn btn-success">Simpan</button>
</div>

</form>

</div>
</div>
</div>

<?php $this->load->view('templates/footer'); ?>
<?php $this->load->view('templates/scripts'); ?>