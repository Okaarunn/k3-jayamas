<?= $this->extend('templates/index'); ?>

<?php $this->section('styles'); ?>
<style>
    .page-header {
        background: #283593;
        border-radius: 16px;
        padding: 28px 32px;
        margin-bottom: 28px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 8px 32px rgba(26, 35, 126, 0.18);
    }

    .page-header h1 {
        color: #fff;
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0;
        letter-spacing: 0.3px;
    }

    .page-header p {
        color: rgba(255, 255, 255, 0.7);
        margin: 4px 0 0;
        font-size: 0.85rem;
    }

    .btn-add-user {
        background: #fff;
        color: #1a237e;
        border: none;
        border-radius: 10px;
        padding: 10px 22px;
        font-weight: 700;
        font-size: 0.875rem;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all .2s;
        text-decoration: none;
        white-space: nowrap;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.12);
    }

    .btn-add-user:hover {
        background: #e8eaf6;
        color: #1a237e;
        transform: translateY(-1px);
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
        text-decoration: none;
    }

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

    .stat-item.editor .stat-num {
        color: #00897b;
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

    .avatar-editor {
        background: linear-gradient(135deg, #00695c, #00897b);
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

    .role-badge.editor {
        background: #e0f2f1;
        color: #00695c;
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
    <div class="page-header">
        <div>
            <h1><i class="fas fa-users mr-2"></i>User Logs</h1>
            <p>Catatan aksi yang dilakukan terhadap suatu akun k3</p>
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
                            <th>Tanggal</th>
                            <th>Pelaku</th>
                            <th>Target</th>
                            <th>Aksi</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1;
                        foreach ($userlogs as $userlog) : ?>
                            <tr>
                                <td class="text-muted" style="font-size:.8rem"><?= $i++ ?></td>

                                <td><?= esc($userlog->created_at) ?></td>

                                <td>
                                    <div class="user-info">
                                        <div>
                                            <div class="user-name"><?= esc($userlog->actor_name) ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td><?= esc($userlog->target_name) ?></td>
                                <td><?= esc($userlog->action) ?></td>
                                <td><?= esc($userlog->description) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
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
                searchPlaceholder: 'Cari data log...',
                lengthMenu: 'Tampilkan _MENU_ data',
                info: 'Menampilkan _START_–_END_ dari _TOTAL_ data logs',
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
    });
</script>
<?php $this->endSection(); ?>