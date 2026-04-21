<?= $this->extend('templates/index'); ?>

<?php $this->section('styles'); ?>
<style>
    .card-users {
        border: none;
        border-radius: 16px;
        box-shadow: 0 2px 20px rgba(0, 0, 0, 0.07);
        overflow: hidden;
    }

    .card-users .card-body {
        padding: 0;
    }

    .stats-strip {
        display: flex;
        gap: 0;
        border-bottom: 1px solid #f0f0f0;
    }

    .stat-item {
        flex: 1;
        padding: 18px 24px;
        border-right: 1px solid #f0f0f0;
        text-align: center;
    }

    .stat-item:last-child {
        border-right: none;
    }

    .stat-item .stat-num {
        font-size: 1.6rem;
        font-weight: 800;
        line-height: 1;
        color: #1a237e;
    }

    .stat-item .stat-label {
        font-size: 0.72rem;
        color: #9e9e9e;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        margin-top: 4px;
    }

    .stat-item.admin .stat-num {
        color: #1a237e;
    }

    .stat-item.k3 .stat-num {
        color: #00897b;
    }

    .stat-item.p2k3 .stat-num {
        color: red;
    }

    .stat-item.viewer .stat-num {
        color: #f57c00;
    }

    .table-wrapper {
        padding: 20px 24px 24px;
    }

    #usersTable thead th {
        background: #f8f9ff;
        color: #5c6bc0;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        border: none;
        padding: 14px 16px;
    }

    #usersTable tbody tr {
        transition: background .15s;
        border-bottom: 1px solid #f5f5f5;
    }

    #usersTable tbody tr:hover {
        background: #f8f9ff;
    }

    #usersTable tbody td {
        padding: 14px 16px;
        vertical-align: middle;
        border: none;
        font-size: 0.875rem;
        color: #424242;
    }

    .user-avatar {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.8rem;
        color: #fff;
        flex-shrink: 0;
    }

    .avatar-administrator {
        background: linear-gradient(135deg, #1a237e, #3949ab);
    }

    .avatar-k3 {
        background: linear-gradient(135deg, #00695c, #00897b);
    }

    .avatar-p2k3 {
        background: linear-gradient(135deg, #C62828, #C62812);
    }

    .avatar-viewer {
        background: linear-gradient(135deg, #e65100, #f57c00);
    }

    .user-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .user-info .user-name {
        font-weight: 600;
        color: #212121;
        font-size: 0.875rem;
    }

    .user-info .user-username {
        font-size: 0.75rem;
        color: #9e9e9e;
    }

    .role-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .role-badge.administrator {
        background: #e8eaf6;
        color: #3949ab;
    }

    .role-badge.k3 {
        background: #e0f2f1;
        color: #00695c;
    }

    .role-badge.p2k3 {
        background: #FCE4EC;
        color: #C62828;
    }

    .role-badge.viewer {
        background: #fff3e0;
        color: #e65100;
    }

    .role-badge i {
        font-size: 0.65rem;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 0.72rem;
        font-weight: 600;
    }

    .status-badge.active {
        background: #e8f5e9;
        color: #388e3c;
    }

    .status-badge.inactive {
        background: #fce4ec;
        color: #c62828;
    }

    .status-badge .dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        display: inline-block;
    }

    .active .dot {
        background: #388e3c;
    }

    .inactive .dot {
        background: #c62828;
    }

    .btn-action {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        border: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        transition: all .15s;
        text-decoration: none;
    }

    .btn-action.edit {
        background: #e8eaf6;
        color: #3949ab;
    }

    .btn-action.edit:hover {
        background: #3949ab;
        color: #fff;
    }

    .btn-action.delete {
        background: #fce4ec;
        color: #c62828;
    }

    .btn-action.delete:hover {
        background: #c62828;
        color: #fff;
    }

    .btn-action.password {
        background: #e0f2f1;
        color: #00695c;
    }

    .btn-action.password:hover {
        background: #00695c;
        color: #fff;
    }

    div.dataTables_wrapper div.dataTables_filter input {
        border: 1.5px solid #e0e0e0;
        border-radius: 8px;
        padding: 6px 12px;
        font-size: 0.85rem;
        outline: none;
        transition: border .2s;
    }

    div.dataTables_wrapper div.dataTables_filter input:focus {
        border-color: #3949ab;
    }

    div.dataTables_wrapper div.dataTables_length select {
        border: 1.5px solid #e0e0e0;
        border-radius: 8px;
        padding: 4px 8px;
        font-size: 0.85rem;
    }

    div.dataTables_wrapper .dataTables_paginate .paginate_button.current,
    div.dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
        background: #3949ab !important;
        color: #fff !important;
        border: none !important;
        border-radius: 8px !important;
    }

    .dataTables_paginate .paginate_button:hover {
        background: #3949ab !important;
        color: #6a1b9a !important;
        border: none !important;
        border-radius: 8px !important;
    }

    .password-wrapper {
        position: relative;
    }

    .password-toggle {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #9e9e9e;
        cursor: pointer;
        padding: 4px;
        font-size: .85rem;
        transition: color .15s;
        line-height: 1;
    }

    .password-toggle:hover {
        color: #3949ab;
    }
</style>
<?php $this->endSection(); ?>


<?php $this->section('page-content'); ?>

<div class="container-fluid pb-4">

    <?= $this->include('components/alert') ?>
    <!-- Page Header -->
    <div class="flex-column flex-md-row page-header">
        <!-- content -->
        <div class="mb-3 mb-md-0">
            <h1 class="mb-1">
                <i class="fas fa-user-check mr-2"></i>
                <span class="d-block d-md-inline">
                    Data Induksi Keselamatan dan Kesehatan Kerja
                </span>
            </h1>
            <p class="mb-0">
                Pencatatan dan manajemen hasil training / induksi K3
            </p>
        </div>

        <!-- button -->
        <div class="d-flex flex-wrap header-actions" style="gap:8px">
            <a href="<?= base_url('admin/users/create') ?>" class="btn-add">
                <i class="fas fa-user-plus"></i>
                <span>Tambah Pengguna</span>
            </a>

        </div>
    </div>

    <!-- Stats Strip -->
    <div class="card card-users mb-4">
        <div class="card-body">
            <div class="stats-strip">
                <?php
                $total   = count($users);
                $cAdmin  = count(array_filter($users, fn($u) => $u->name === 'administrator'));
                $cK3 = count(array_filter($users, fn($u) => $u->name === 'k3'));
                $cP2k3 = count(array_filter($users, fn($u) => $u->name === 'p2k3'));
                $cViewer = count(array_filter($users, fn($u) => $u->name === 'viewer'));
                ?>
                <div class="stat-item">
                    <div class="stat-num"><?= $total ?></div>
                    <div class="stat-label">Total Pengguna</div>
                </div>
                <div class="stat-item admin">
                    <div class="stat-num"><?= $cAdmin ?></div>
                    <div class="stat-label">Administrator</div>
                </div>
                <div class="stat-item k3">
                    <div class="stat-num"><?= $cK3 ?></div>
                    <div class="stat-label">K3</div>
                </div>

                <div class="stat-item p2k3">
                    <div class="stat-num"><?= $cP2k3 ?></div>
                    <div class="stat-label">P2K3</div>
                </div>

                <div class="stat-item viewer">
                    <div class="stat-num"><?= $cViewer ?></div>
                    <div class="stat-label">Viewer</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="card card-users">
        <div class="card-body">
            <div class="table-wrapper">
                <table id="usersTable" class="table" style="width:100%">
                    <thead>
                        <tr>
                            <th style="width:50px">#</th>
                            <th>Pengguna</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th style="width:120px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1;
                        foreach ($users as $user) : ?>
                            <?php
                            $role     = $user->name ?? 'viewer';
                            $initials = strtoupper(substr($user->username, 0, 2));
                            $isActive = $user->active ?? 1;
                            ?>
                            <tr>
                                <td class="text-muted" style="font-size:.8rem"><?= $i++ ?></td>
                                <td>
                                    <div class="user-info">
                                        <div class="user-avatar avatar-<?= $role ?>"><?= $initials ?></div>
                                        <div>
                                            <div class="user-name"><?= esc($user->username) ?></div>
                                            <div class="user-username">ID #<?= $user->userid ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td><?= esc($user->email) ?></td>
                                <td>
                                    <span class="role-badge <?= $role ?>">
                                        <?php if ($role === 'administrator') : ?><i class="fas fa-shield-alt"></i>
                                        <?php elseif ($role === 'k3') : ?><i class="fas fa-pen"></i>
                                        <?php else : ?><i class="fas fa-eye"></i>
                                        <?php endif; ?>
                                        <?= ucfirst($role) ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="status-badge <?= $isActive ? 'active' : 'inactive' ?>">
                                        <span class="dot"></span>
                                        <?= $isActive ? 'Aktif' : 'Nonaktif' ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex" style="gap:6px">
                                        <a href="<?= base_url('admin/users/edit/' . $user->userid) ?>"
                                            class="btn-action edit" title="Edit Pengguna">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="#" class="btn-action password"
                                            data-toggle="modal" data-target="#passwordModal"
                                            data-id="<?= $user->userid ?>"
                                            data-name="<?= esc($user->username) ?>"
                                            title="Reset Password">
                                            <i class="fas fa-key"></i>
                                        </a>
                                        <a href="#" class="btn-action delete"
                                            data-toggle="modal" data-target="#deleteModal"
                                            data-id="<?= $user->userid ?>"
                                            data-name="<?= esc($user->username) ?>"
                                            title="Hapus Pengguna">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Hapus -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border:none;border-radius:16px;overflow:hidden">
            <div class="modal-body text-center p-4">
                <div style="width:64px;height:64px;background:#fce4ec;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 16px">
                    <i class="fas fa-trash" style="color:#c62828;font-size:1.4rem"></i>
                </div>
                <h5 style="font-weight:700;color:#212121">Hapus Pengguna?</h5>
                <p style="color:#757575;font-size:.875rem" id="deleteUserName"></p>
                <div class="d-flex justify-content-center mt-3" style="gap:10px">
                    <button type="button" class="btn btn-light" style="border-radius:10px;padding:8px 24px" data-dismiss="modal">Batal</button>
                    <a id="confirmDeleteBtn" href="#" class="btn btn-danger" style="border-radius:10px;padding:8px 24px">Hapus</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Reset Password -->
<div class="modal fade" id="passwordModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border:none;border-radius:16px;overflow:hidden">
            <div style="background:linear-gradient(135deg,#1a237e,#3949ab);padding:20px 24px">
                <h5 style="color:#fff;margin:0;font-weight:700"><i class="fas fa-key mr-2"></i>Reset Password</h5>
                <p style="color:rgba(255,255,255,.7);margin:4px 0 0;font-size:.82rem" id="passwordModalSubtitle"></p>
            </div>
            <form action="<?= base_url('admin/users/reset-password') ?>" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="user_id" id="passwordUserId">
                <div class="modal-body p-4">
                    <div class="form-group mb-3">
                        <label style="font-size:.8rem;font-weight:600;color:#616161;text-transform:uppercase;letter-spacing:.5px">Password Baru</label>
                        <div class="password-wrapper">
                            <input type="password" name="new_password" id="newPasswordInput" class="form-control"
                                style="border-radius:10px;border:1.5px solid #e0e0e0;padding:10px 40px 10px 14px"
                                placeholder="Min. 8 karakter" required minlength="8">
                            <button type="button" class="password-toggle" id="toggleNewPassword">
                                <i class="fas fa-eye" id="toggleNewIcon"></i>
                            </button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label style="font-size:.8rem;font-weight:600;color:#616161;text-transform:uppercase;letter-spacing:.5px">Konfirmasi Password</label>
                        <div class="password-wrapper">
                            <input type="password" name="confirm_password" id="confirmPasswordInput" class="form-control"
                                style="border-radius:10px;border:1.5px solid #e0e0e0;padding:10px 40px 10px 14px"
                                placeholder="Ulangi password baru" required minlength="8">
                            <button type="button" class="password-toggle" id="toggleConfirmPassword">
                                <i class="fas fa-eye" id="toggleConfirmIcon"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 px-4 pb-4" style="gap:8px">
                    <button type="button" class="btn btn-light" style="border-radius:10px" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" style="border-radius:10px;background:#3949ab;border:none">Simpan Password</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $this->endSection(); ?>


<?php $this->section('scripts'); ?>
<script>
    $(document).ready(function() {

        // ── DataTable ──────────────────────────────────────────────────
        $('#usersTable').DataTable({
            pageLength: 5,
            lengthMenu: [5, 10, 25, 50],
            language: {
                search: '',
                searchPlaceholder: 'Cari pengguna...',
                lengthMenu: 'Tampilkan _MENU_ data',
                info: 'Menampilkan _START_–_END_ dari _TOTAL_ pengguna',
                paginate: {
                    previous: '‹',
                    next: '›'
                },
                zeroRecords: 'Tidak ada data ditemukan',
                emptyTable: 'Belum ada pengguna terdaftar'
            },
            columnDefs: [{
                orderable: false,
                targets: [5]
            }]
        });

        // ── Delete modal ───────────────────────────────────────────────
        $('#deleteModal').on('show.bs.modal', function(e) {
            const btn = $(e.relatedTarget);
            const id = btn.data('id');
            const name = btn.data('name');
            $('#deleteUserName').text('Pengguna "' + name + '" akan dihapus permanen.');
            $('#confirmDeleteBtn').attr('href', '<?= base_url("admin/users/delete/") ?>' + id);
        });

        // ── Password modal ─────────────────────────────────────────────
        $('#passwordModal').on('show.bs.modal', function(e) {
            const btn = $(e.relatedTarget);
            const id = btn.data('id');
            const name = btn.data('name');
            $('#passwordUserId').val(id);
            $('#passwordModalSubtitle').text('Atur ulang password untuk: ' + name);
        });


        // ── Password toggle ────────────────────────────────────────────
        $('#toggleNewPassword').on('click', function() {
            const input = $('#newPasswordInput');
            const icon = $('#toggleNewIcon');
            input.attr('type', input.attr('type') === 'password' ? 'text' : 'password');
            icon.toggleClass('fa-eye fa-eye-slash');
        });

        $('#toggleConfirmPassword').on('click', function() {
            const input = $('#confirmPasswordInput');
            const icon = $('#toggleConfirmIcon');
            input.attr('type', input.attr('type') === 'password' ? 'text' : 'password');
            icon.toggleClass('fa-eye fa-eye-slash');
        });

    });
</script>
<?php $this->endSection(); ?>