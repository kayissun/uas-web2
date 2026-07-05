<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">

        <nav class="navbar navbar-expand topbar d-flex align-items-center">

            <button id="sidebarToggleTop" class="btn btn-link text-dark p-0 me-3" type="button" aria-label="Toggle sidebar">
                <i class="fa fa-bars"></i>
            </button>

            <h5 class="page-title mb-0 me-auto"><?= $title ?? 'Dashboard' ?></h5>

            <ul class="navbar-nav align-items-center">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="d-none d-md-inline text-dark small fw-semibold">
                            <?= $this->session->userdata('username') ?? 'User' ?>
                        </span>
                        <span class="d-inline-flex align-items-center justify-content-center rounded-circle"
                              style="width:2.1rem;height:2.1rem;background:var(--ink);color:#fff;font-size:.8rem;font-weight:600;">
                            <?= strtoupper(substr($this->session->userdata('username') ?? 'U', 0, 1)) ?>
                        </span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="<?= base_url('auth/logout') ?>">
                            <i class="fas fa-fw fa-right-from-bracket me-2 text-muted"></i>Logout
                        </a></li>
                    </ul>
                </li>
            </ul>

        </nav>