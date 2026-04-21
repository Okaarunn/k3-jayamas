<ul class="navbar-nav bg-sidebar sidebar sidebar-dark accordion" id="accordionSidebar">

    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('/') ?>">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-hard-hat"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Jayamas <sup>K3</sup></div>
    </a>

    <hr class="sidebar-divider my-0">

    <hr class="sidebar-divider">
    <div class="sidebar-heading">Dashboard</div>
    <li class="nav-item active">
        <a class="nav-link" href="<?= base_url('/') ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <hr class="sidebar-divider">
    <div class="sidebar-heading">Manajemen</div>

    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('induksi') ?>">
            <i class="fas fa-fw fa-user-check"></i>
            <span>Induksi</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('patrol') ?>">
            <i class="fas fa-fw fa-route"></i>
            <span>Patrol</span>
        </a>
    </li>

    <?php if (in_groups('administrator')) : ?>
        <hr class="sidebar-divider">
        <div class="sidebar-heading">Pengaturan</div>

        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('admin/roles') ?>">
                <i class="fas fa-fw fa-lock"></i>
                <span>Roles</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('admin/users') ?>">
                <i class="fas fa-fw fa-users"></i>
                <span>User</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('admin/userlogs') ?>">
                <i class="fas fa-fw fa-clipboard-list"></i>
                <span>Logs</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('admin/plant') ?>">
                <i class="fas fa-fw fa-map-marker-alt"></i>
                <span>Plant</span>
            </a>
        </li>
    <?php endif; ?>

    <hr class="sidebar-divider">

    <li class="nav-item">
        <a class="nav-link" href="<?= url_to('logout') ?>">
            <i class="fas fa-fw fa-sign-out-alt"></i>
            <span>Logout</span>
        </a>
    </li>

    <hr class="sidebar-divider d-none d-md-block">

    <div class="text-center">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>