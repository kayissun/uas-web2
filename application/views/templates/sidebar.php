<?php $__seg1 = $this->uri->segment(1); ?>
<ul class="navbar-nav" id="accordionSidebar">

    <a class="sidebar-brand" href="<?= base_url('dashboard') ?>">
        <span class="sidebar-brand-icon"><i class="fas fa-concierge-bell"></i></span>
        <span class="sidebar-brand-text">Hotel<br>Reservasi</span>
    </a>

    <hr class="sidebar-divider">

    <li class="nav-item">
        <a class="nav-link <?= $__seg1 === 'dashboard' ? 'active' : '' ?>" href="<?= base_url('dashboard') ?>">
            <i class="fas fa-fw fa-gauge-high"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link <?= $__seg1 === 'kamar' ? 'active' : '' ?>" href="<?= base_url('kamar') ?>">
            <i class="fas fa-fw fa-bed"></i>
            <span>Data Kamar</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link <?= $__seg1 === 'reservasi' ? 'active' : '' ?>" href="<?= base_url('reservasi') ?>">
            <i class="fas fa-fw fa-calendar-check"></i>
            <span>Reservasi</span>
        </a>
    </li>

    <?php if($this->session->userdata('role') === 'admin'): ?>
    <li class="nav-item">
        <a class="nav-link <?= $__seg1 === 'admin_user' ? 'active' : '' ?>" href="<?= base_url('admin_user') ?>">
            <i class="fas fa-fw fa-users-gear"></i>
            <span>Manajemen User</span>
        </a>
    </li>
    <?php endif; ?>

    <hr class="sidebar-divider">

</ul>