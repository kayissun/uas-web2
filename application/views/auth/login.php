<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login · Hotel Reservasi</title>

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
            --text-dark: #23272F;
            --text-muted: #6B7280;
            --border: #E8E6E1;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--paper);
            color: var(--text-dark);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .brand-font { font-family: 'Fraunces', serif; letter-spacing: -0.01em; }

        .login-card {
            border: none;
            border-radius: 1.1rem;
            overflow: hidden;
            box-shadow: 0 20px 50px rgba(20, 33, 61, .12);
        }

        /* left panel — signature: key-tag stripe pattern, no photo needed */
        .login-visual {
            position: relative;
            min-height: 100%;
            background: linear-gradient(200deg, var(--ink) 0%, var(--ink-soft) 100%);
            padding: 3rem 2.5rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            color: #fff;
            overflow: hidden;
        }

        .login-visual::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: repeating-linear-gradient(
                115deg,
                rgba(201,162,39,.10) 0px,
                rgba(201,162,39,.10) 2px,
                transparent 2px,
                transparent 34px
            );
            pointer-events: none;
        }

        .login-visual-icon {
            width: 3rem;
            height: 3rem;
            border-radius: .65rem;
            background: var(--brass);
            color: var(--ink);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            position: relative;
            z-index: 1;
        }

        .login-visual h2 {
            font-size: 1.9rem;
            font-weight: 600;
            line-height: 1.25;
            margin-top: 1.75rem;
            position: relative;
            z-index: 1;
        }

        .login-visual p {
            color: rgba(255,255,255,.72);
            font-size: .92rem;
            position: relative;
            z-index: 1;
        }

        .login-visual .foot-note {
            font-size: .78rem;
            color: rgba(255,255,255,.5);
            position: relative;
            z-index: 1;
        }

        .login-form-side { padding: 3rem 2.75rem; background: #fff; }

        .form-label {
            font-size: .8rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: .35rem;
        }

        .form-control {
            border-radius: .6rem;
            border-color: var(--border);
            padding: .65rem .9rem;
            font-size: .92rem;
        }

        .form-control:focus {
            border-color: var(--ink-soft);
            box-shadow: 0 0 0 .2rem rgba(31,58,95,.12);
        }

        .input-group .form-control { border-right: none; }
        .input-group .input-group-text {
            background: #fff;
            border-color: var(--border);
            border-left: none;
            border-radius: .6rem;
            cursor: pointer;
            color: var(--text-muted);
        }

        .btn-login {
            background: var(--ink);
            border-color: var(--ink);
            color: #fff;
            font-weight: 600;
            padding: .7rem;
            border-radius: .6rem;
            transition: background .15s ease;
        }

        .btn-login:hover { background: var(--ink-soft); color: #fff; }
    </style>
</head>

<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-8 col-lg-9">

                <div class="card login-card my-5">
                    <div class="row g-0">

                        <div class="col-lg-5 d-none d-lg-flex">
                            <div class="login-visual">
                                <div>
                                    <span class="login-visual-icon"><i class="fas fa-concierge-bell"></i></span>
                                    <h2 class="brand-font">Selamat datang<br>kembali.</h2>
                                    <p>Kelola kamar dan reservasi tamu dari satu dashboard.</p>
                                </div>
                                <div class="foot-note">Hotel Reservasi — Admin Panel</div>
                            </div>
                        </div>

                        <div class="col-lg-7">
                            <div class="login-form-side">

                                <h1 class="h4 brand-font mb-1">Masuk ke akun Anda</h1>
                                <p class="text-muted mb-4" style="font-size:.88rem;">Masukkan username dan password untuk melanjutkan.</p>

                                <?php if($this->session->flashdata('error')): ?>
                                    <div class="alert alert-danger py-2 small">
                                        <?= $this->session->flashdata('error') ?>
                                    </div>
                                <?php endif; ?>

                                <form method="post" action="<?= base_url('auth/login') ?>">

                                    <div class="mb-3">
                                        <label class="form-label">Username</label>
                                        <div class="input-group">
                                            <input type="text" name="username" class="form-control" placeholder="Masukkan username" required>
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Password</label>
                                        <div class="input-group">
                                            <input type="password" name="password" id="passwordField" class="form-control" placeholder="Masukkan password" required>
                                            <span class="input-group-text" id="togglePassword"><i class="fas fa-eye" id="toggleIcon"></i></span>
                                        </div>
                                    </div>

                                    <input type="hidden"
                                        name="<?= $this->security->get_csrf_token_name(); ?>"
                                        value="<?= $this->security->get_csrf_hash(); ?>" />

                                    <button type="submit" class="btn btn-login w-100 mt-2">Login</button>

                                </form>

                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        document.getElementById('togglePassword')?.addEventListener('click', function () {
            const field = document.getElementById('passwordField');
            const icon = document.getElementById('toggleIcon');
            const isPassword = field.type === 'password';
            field.type = isPassword ? 'text' : 'password';
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        });
    </script>

</body>
</html>