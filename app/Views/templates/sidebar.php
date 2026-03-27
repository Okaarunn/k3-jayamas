<style>
    .bg-sidebar {
        background: linear-gradient(135deg, #1a237e 0%, #283593 60%, #3949ab 100%);
        display: flex;
        justify-content: space-between;
        box-shadow: 0 8px 32px rgba(26, 35, 126, 0.18);
    }
</style>

<ul class="navbar-nav bg-sidebar sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('/') ?>">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-hard-hat"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Jayamas <sup>K3</sup></div>
    </a>

    <hr class="sidebar-divider my-0" />

    <!-- Dashboard  -->
    <div class="sidebar-heading mt-2">Dashboard</div>
    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('/') ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Manajemen -->
    <div class="sidebar-heading mt-2">Manajemen</div>
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

    <!-- User Management  -->
    <?php if (in_groups('administrator')) : ?>
        <div class="sidebar-heading mt-2">Pengaturan</div>
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('admin/users') ?>">
                <i class="fas fa-fw fa-users"></i>
                <span>User</span>
            </a>
        </li>
    <?php endif; ?>

    <hr class="sidebar-divider d-none d-md-block" />

    <!-- Logout — tampil untuk semua role -->
    <li class="nav-item">
        <a class="nav-link" href="<?= url_to('logout') ?>">
            <i class="fas fa-fw fa-sign-out-alt"></i>
            <span>Logout</span>
        </a>
    </li>

    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>