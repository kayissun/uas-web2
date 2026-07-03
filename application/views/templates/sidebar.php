<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
        <div class="sidebar-brand-text">Hotel Reservasi</div>
    </a>

    <hr class="sidebar-divider">

    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('dashboard') ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('kamar') ?>">
            <i class="fas fa-bed"></i>
            <span>Data Kamar</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('reservasi') ?>">
            <i class="fas fa-calendar-check"></i>
            <span>Reservasi</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('admin_user') ?>">
            <i class="fas fa-users-cog"></i>
            <span>Manajemen User</span>
        </a>
    </li>

    <hr class="sidebar-divider">

</ul>