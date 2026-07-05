<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Reservasi — Manjakan diri Anda</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600;9..144,700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url('assets/sbadmin/vendor/fontawesome-free/css/all.min.css') ?>" rel="stylesheet">

    <style>
        :root {
            --ink: #14213D;
            --ink-soft: #1F3A5F;
            --brass: #C9A227;
            --brass-soft: #E4C766;
            --paper: #F7F5F0;
            --paper-card: #FFFFFF;
            --text-dark: #23272F;
            --text-muted: #6B7280;
            --border: #E8E6E1;
            --success: #10B981;
            --radius: 0.9rem;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--paper);
            color: var(--text-dark);
            min-height: 100vh;
        }

        h1, h2, h3, h4, h5, h6, .brand-font, .display-6 {
            font-family: 'Poppins', serif;
            letter-spacing: -0.01em;
            color: var(--text-dark);
        }

        /* Navbar */
        .navbar-custom {
            background: var(--paper-card);
            border-bottom: 1px solid var(--border);
            padding: 0.95rem 0;
            box-shadow: 0 1px 2px rgba(20, 33, 61, .04);
        }

        .navbar-brand {
            font-family: 'Poppins', serif;
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--ink) !important;
        }

        .navbar-brand span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 2rem;
            height: 2rem;
            background: var(--brass);
            color: var(--ink);
            border-radius: .5rem;
            margin-right: .6rem;
            font-size: .9rem;
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, var(--ink) 0%, var(--ink-soft) 100%);
            color: #fff;
            padding: 4.5rem 0;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: repeating-linear-gradient(
                115deg,
                rgba(201,162,39,.08) 0px,
                rgba(201,162,39,.08) 2px,
                transparent 2px,
                transparent 38px
            );
            pointer-events: none;
        }

        .hero-content {
            position: relative;
            z-index: 1;
        }

        .hero h1 {
            font-size: 2.75rem;
            font-weight: 700;
            line-height: 1.2;
            color: #fff;
        }

        .hero .lead {
            font-size: 1.1rem;
            color: rgba(255,255,255,.85);
            line-height: 1.5;
        }

        /* Booking Card */
        .booking-card {
            background: var(--paper-card);
            border: none;
            border-radius: var(--radius);
            box-shadow: 0 20px 50px rgba(20, 33, 61, .12);
            padding: 2rem;
        }

        .booking-card h5 {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-size: .8rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: .4rem;
            text-transform: uppercase;
            letter-spacing: .03em;
        }

        .form-control, .form-select {
            border-radius: .6rem;
            border-color: var(--border);
            padding: .65rem .9rem;
            font-size: .92rem;
            transition: border-color .15s ease, box-shadow .15s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--ink-soft);
            box-shadow: 0 0 0 .2rem rgba(31, 58, 95, .12);
        }

        .btn-book {
            background: var(--ink);
            border: none;
            color: #fff;
            font-weight: 600;
            padding: .8rem;
            border-radius: .6rem;
            transition: background .15s ease;
            text-transform: uppercase;
            letter-spacing: .02em;
            font-size: .85rem;
        }

        .btn-book:hover {
            background: var(--ink-soft);
            color: #fff;
        }

        /* Catalog Section */
        .section-catalog {
            padding: 5rem 0;
        }

        .section-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 3rem;
            position: relative;
            padding-bottom: 1rem;
        }

        .section-title::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 3.5rem;
            height: .3rem;
            background: var(--brass);
            border-radius: .15rem;
        }

        /* Room Card */
        .room-card {
            border: 1px solid var(--border);
            border-radius: var(--radius);
            overflow: hidden;
            transition: transform .25s ease, box-shadow .25s ease;
            background: var(--paper-card);
            height: 100%;
        }

        .room-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 24px 48px rgba(20, 33, 61, .15);
        }

        .room-card-img {
            position: relative;
            height: 240px;
            overflow: hidden;
            background: linear-gradient(135deg, var(--ink), var(--ink-soft));
        }

        .room-card-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform .3s ease;
        }

        .room-card:hover .room-card-img img {
            transform: scale(1.05);
        }

        .room-badge {
            position: absolute;
            top: 1rem;
            right: 1rem;
            font-size: .72rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .05em;
            padding: .35rem .75rem;
            border-radius: .4rem;
            z-index: 2;
        }

        .room-badge.available { background: var(--success); color: #fff; }

        .room-card-body {
            padding: 1.5rem;
        }

        .room-code {
            font-family: 'Poppins', monospace;
            font-size: .75rem;
            color: var(--brass);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .04em;
            margin-bottom: .3rem;
        }

        .room-name {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: .5rem;
        }

        .room-info {
            display: flex;
            gap: 1.5rem;
            margin: .75rem 0 1rem;
            font-size: .85rem;
            color: var(--text-muted);
        }

        .room-info span { display: flex; align-items: center; gap: .35rem; }

        .room-price {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--ink);
            margin-top: 1rem;
        }

        /* Footer */
        footer {
            background: var(--ink);
            color: rgba(255,255,255,.8);
            padding: 3rem 0 1.5rem;
            margin-top: 5rem;
        }

        footer h6 { color: #fff; font-weight: 600; margin-bottom: 1rem; }

        footer ul { list-style: none; padding: 0; }

        footer ul li { margin-bottom: .4rem; }

        footer a { color: rgba(255,255,255,.8); text-decoration: none; transition: color .15s ease; }

        footer a:hover { color: var(--brass); }

        .footer-divider {
            border-top: 1px solid rgba(201,162,39,.2);
            padding-top: 1.5rem;
            margin-top: 1.5rem;
            font-size: .85rem;
            color: rgba(255,255,255,.6);
        }

        /* Alert Styling */
        .alert {
            border: none;
            border-radius: .6rem;
            padding: .75rem 1rem;
            font-size: .9rem;
        }

        .alert-success { background: rgba(16,185,129,.1); color: #047857; }
        .alert-danger { background: rgba(239,68,68,.1); color: #991B1B; }

        @media (max-width: 767.98px) {
            .hero h1 { font-size: 2rem; }
            .hero .lead { font-size: 1rem; }
            .section-title { font-size: 1.6rem; }
            .booking-card { padding: 1.5rem; }
        }

        @media (prefers-reduced-motion: reduce) {
            * { transition: none !important; }
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url() ?>">
                <span><i class="fas fa-concierge-bell"></i></span>
                Hotel Reservasi
            </a>
        </div>
    </nav>

    <!-- Hero & Booking Form -->
    <section class="hero">
        <div class="container">
            <div class="row align-items-center g-4">
                <div class="col-lg-6 hero-content">
                    <h1>Manjakan diri Anda di hotel kami</h1>
                    <p class="lead mt-3">Temukan kamar yang nyaman dan pesan langsung dari halaman ini. Proses cepat, transparan, dan aman.</p>
                </div>
                <div class="col-lg-6">
                    <div class="booking-card">
                        <h5><i class="fas fa-calendar-check" style="color: var(--brass); margin-right: .5rem;"></i>Pesan Kamar Anda</h5>

                        <?php if($this->session->flashdata('success')): ?>
                            <div class="alert alert-success"><i class="fas fa-check-circle me-2"></i><?= $this->session->flashdata('success') ?></div>
                        <?php endif; ?>
                        <?php if($this->session->flashdata('error')): ?>
                            <div class="alert alert-danger"><i class="fas fa-exclamation-circle me-2"></i><?= $this->session->flashdata('error') ?></div>
                        <?php endif; ?>

                        <form method="post" action="<?= base_url('landing/pesan') ?>">
                            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">

                            <div class="mb-3">
                                <label class="form-label"><i class="fas fa-door-open me-1"></i>Pilih Kamar</label>
                                <select name="room_id" class="form-select" required>
                                    <option value="">-- Pilih kamar --</option>
                                    <?php foreach($rooms as $room): ?>
                                        <option value="<?= $room->id ?>"><?= esc($room->room_code . ' — ' . $room->room_name . ' (Rp ' . number_format($room->price, 0, ',', '.') . ')') ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label"><i class="fas fa-user me-1"></i>Nama Tamu</label>
                                <input type="text" name="guest_name" class="form-control" placeholder="Nama lengkap" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label"><i class="fas fa-phone me-1"></i>No. Telepon</label>
                                <input type="text" name="guest_phone" class="form-control" placeholder="08xx xxxx xxxx" required>
                            </div>

                            <div class="row g-2">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label"><i class="fas fa-calendar-day me-1"></i>Check-in</label>
                                    <input type="date" name="check_in" id="check_in" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label"><i class="fas fa-calendar-day me-1"></i>Check-out</label>
                                    <input type="date" name="check_out" class="form-control" required>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-book w-100">
                                <i class="fas fa-lock me-2"></i>Pesan Sekarang
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Catalog Section -->
    <section class="section-catalog">
        <div class="container">
            <h2 class="section-title">Katalog Kamar</h2>
            <div class="row g-4">
                <?php foreach($rooms as $room): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="room-card">
                        <div class="room-card-img">
                            <img src="<?= base_url('uploads/room_images/' . $room->image_path) ?>" alt="<?= esc($room->room_name) ?>">
                            <span class="room-badge available">Tersedia</span>
                        </div>
                        <div class="room-card-body">
                            <div class="room-code"><?= esc($room->room_code) ?></div>
                            <h5 class="room-name"><?= esc($room->room_name) ?></h5>
                            <div class="room-info">
                                <span><i class="fas fa-users"></i><?= esc($room->capacity) ?> tamu</span>
                            </div>
                            <div class="room-price">Rp <?= number_format($room->price, 0, ',', '.') ?><span style="font-size: .65rem; color: var(--text-muted);">/malam</span></div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row g-4 mb-3">
                <div class="col-md-4">
                    <h6><i class="fas fa-concierge-bell me-2" style="color: var(--brass);"></i>Hotel Reservasi</h6>
                    <p style="font-size: .9rem; line-height: 1.6;">Platform reservasi modern untuk pengalaman menginap yang nyaman dan berkesan.</p>
                </div>
                <div class="col-md-4">
                    <h6>Menu</h6>
                    <ul>
                        <li><a href="<?= base_url() ?>">Beranda</a></li>
                        <li><a href="<?= base_url() ?>#kamar">Katalog Kamar</a></li>
                        <li><a href="<?= base_url() ?>#map">Lokasi</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h6>Hubungi Kami</h6>
                    <ul style="font-size: .9rem;">
                        <li><i class="fas fa-phone me-1"></i>+62 813 2938 2932</li>
                        <li><i class="fas fa-envelope me-1"></i>info@hotelreservasi.com</li>
                        <li><i class="fas fa-map-marker-alt me-1"></i>Jl. Sawunggalih, Kutoarjo</li>
                    </ul>
                </div>
            </div>
            <div class="footer-divider text-center">
                <p class="mb-0">© <?= date('Y') ?> Hotel Reservasi - Dikelola Mahasiswa</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<!-- Script untuk mengisi tanggal check-in dengan tanggal hari ini -->
<script>
  const dateInput = document.getElementById('check_in');
  
  // tanggal hari ini
  const today = new Date().toISOString().split('T')[0];

  dateInput.value = today;
</script>