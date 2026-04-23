<ul class="navbar-nav bg-sidebar sidebar sidebar-dark accordion" id="accordionSidebar">

    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('/') ?>">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-hard-hat"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Jayamas <sup>K3</sup></div>
    </a>

    <hr class="sidebar-divider my-0">

    <!-- DASHBOARD -->
    <hr class="sidebar-divider">
    <div class="sidebar-heading">Dashboard</div>

    <li class="nav-item active">
        <a class="nav-link" href="<?= base_url('/') ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- MANAJEMEN -->
    <hr class="sidebar-divider">
    <div class="sidebar-heading">Manajemen</div>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseManajemen"
            aria-expanded="false" aria-controls="collapseManajemen">
            <i class="fas fa-fw fa-cogs"></i>
            <span>Manajemen</span>
        </a>

        <div id="collapseManajemen" class="collapse" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="<?= base_url('induksi') ?>">
                    <i class="fas fa-user-check mr-2"></i> Induksi
                </a>
                <a class="collapse-item" href="<?= base_url('patrol') ?>">
                    <i class="fas fa-route mr-2"></i> Patrol
                </a>
            </div>
        </div>
    </li>


    <!-- approval -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#"
            data-toggle="collapse"
            data-target="#collapseApproval"
            aria-expanded="false"
            aria-controls="collapseApproval">

            <i class="fas fa-clipboard-check"></i>
            <span>Approval Center</span>
        </a>


        <div id="collapseApproval" class="collapse" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <!-- just editor & approval -->

                <!-- just permission manage data can access -->
                <?php if (has_permission('manage-data')) : ?>
                    <a class="collapse-item" href="#">
                        <i class="fas fa-user-check mr-2"></i> Approval K3
                    </a>
                <?php endif; ?>


                <!-- just role p2k3 can access -->
                <?php if (in_groups('p2k3')) : ?>
                    <a class="collapse-item" href="#">
                        <i class="fas fa-users-cog mr-2"></i> Approval P2K3
                    </a>
                <?php endif; ?>


                <?php if (has_permission('manage-data')) : ?>
                    <a class="collapse-item" href="#">
                        <i class="fas fa-tasks mr-2"></i> Proses Pengerjaan
                    </a>
                <?php endif; ?>


                <a class="collapse-item" href="#">
                    <i class="fas fa-folder-open mr-2"></i> Document Center
                </a>

            </div>
        </div>
    </li>


    <!-- PENGATURAN -->
    <?php if (in_groups('administrator')) : ?>
        <hr class="sidebar-divider">
        <div class="sidebar-heading">Pengaturan</div>

        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSetting"
                aria-expanded="false" aria-controls="collapseSetting">
                <i class="fas fa-fw fa-cog"></i>
                <span>Pengaturan</span>
            </a>

            <div id="collapseSetting" class="collapse" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="<?= base_url('admin/roles') ?>">
                        <i class="fas fa-lock mr-2"></i> Roles
                    </a>
                    <a class="collapse-item" href="<?= base_url('admin/users') ?>">
                        <i class="fas fa-users mr-2"></i> User
                    </a>
                    <a class="collapse-item" href="<?= base_url('admin/userlogs') ?>">
                        <i class="fas fa-clipboard-list mr-2"></i> Logs
                    </a>
                    <a class="collapse-item" href="<?= base_url('admin/plant') ?>">
                        <i class="fas fa-map-marker-alt mr-2"></i> Plant
                    </a>
                </div>
            </div>
        </li>
    <?php endif; ?>

    <!-- LOGOUT -->
    <hr class="sidebar-divider">

    <li class="nav-item">
        <a class="nav-link" href="<?= url_to('logout') ?>">
            <i class="fas fa-fw fa-sign-out-alt"></i>
            <span>Logout</span>
        </a>
    </li>

    <hr class="sidebar-divider d-none d-md-block">

    <!-- Toggle button — hanya tampil di desktop -->
    <div class="text-center d-none d-md-block">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>