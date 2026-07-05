<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Reservasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: Inter, Arial, sans-serif; background: #f7f5f0; color: #172033; }
        .hero { background: linear-gradient(135deg, #14213d, #1f3a5f); color: #fff; padding: 80px 0; }
        .card-room { border: 0; border-radius: 1rem; overflow: hidden; box-shadow: 0 12px 32px rgba(0,0,0,.08); }
        .card-room img { height: 220px; object-fit: cover; }
        .badge-available { background: #198754; }
        .badge-maintenance { background: #ffc107; color: #000; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand fw-bold" href="<?= base_url() ?>">Hotel Reservasi</a>
            <div class="ms-auto">
                <a class="btn btn-outline-light btn-sm" href="<?= base_url('login') ?>">Login Admin</a>
            </div>
        </div>
    </nav>

    <section class="hero">
        <div class="container">
            <div class="row align-items-center g-4">
                <div class="col-lg-7">
                    <h1 class="display-6 fw-bold">Temukan kamar nyaman untuk istirahat Anda</h1>
                    <p class="lead mt-3">Cek katalog kamar kami, lalu pesan langsung dari halaman depan.</p>
                </div>
                <div class="col-lg-5">
                    <div class="card p-4 shadow-sm">
                        <h5 class="mb-3">Pesan Kamar</h5>
                        <?php if($this->session->flashdata('success')): ?>
                            <div class="alert alert-success py-2"><?= $this->session->flashdata('success') ?></div>
                        <?php endif; ?>
                        <?php if($this->session->flashdata('error')): ?>
                            <div class="alert alert-danger py-2"><?= $this->session->flashdata('error') ?></div>
                        <?php endif; ?>
                        <form method="post" action="<?= base_url('landing/pesan') ?>">
                            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                            <div class="mb-3">
                                <label class="form-label">Pilih Kamar</label>
                                <select name="room_id" class="form-select" required>
                                    <option value="">-- Pilih kamar --</option>
                                    <?php foreach($rooms as $room): ?>
                                        <option value="<?= $room->id ?>"><?= esc($room->room_code . ' - ' . $room->room_name . ' (Rp ' . number_format($room->price, 0, ',', '.') . ')') ?></option>
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
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Check-in</label>
                                    <input type="date" name="check_in" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Check-out</label>
                                    <input type="date" name="check_out" class="form-control" required>
                                </div>
                            </div>
                            <button class="btn btn-primary w-100">Pesan Sekarang</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <h2 class="fw-bold mb-4">Katalog Kamar</h2>
            <div class="row g-4">
                <?php foreach($rooms as $room): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card card-room h-100">
                        <img src="<?= base_url('uploads/room_images/' . $room->image_path) ?>" alt="<?= esc($room->room_name) ?>">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5 class="card-title mb-0"><?= esc($room->room_name) ?></h5>
                                <span class="badge badge-available">Tersedia</span>
                            </div>
                            <p class="text-muted small mb-2">Kode: <?= esc($room->room_code) ?></p>
                            <p class="text-muted small">Kapasitas: <?= esc($room->capacity) ?> tamu</p>
                            <p class="fw-bold text-primary">Rp <?= number_format($room->price, 0, ',', '.') ?>/malam</p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
