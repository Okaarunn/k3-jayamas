<?= $this->extend('templates/index'); ?>
<?php $this->section('page-content'); ?>

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

    #plantTable thead th {
        background: #f8f9ff;
        color: #5c6bc0;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        border: none;
        padding: 14px 16px;
    }

    #plantTable tbody tr {
        transition: background .15s;
        border-bottom: 1px solid #f5f5f5;
    }

    #plantTable tbody tr:hover {
        background: #f8f9ff;
    }

    #plantTable tbody td {
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

    .dataTables_paginate .paginate_button.current,
    .dataTables_paginate .paginate_button.current:hover {
        background: #3949ab !important;
        color: #fff !important;
        border: none !important;
        border-radius: 8px !important;
    }

    .dataTables_paginate .paginate_button:hover {
        background: #e8eaf6 !important;
        color: #3949ab !important;
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

<div class="container-fluid pb-4">

    <?= $this->include('components/alert') ?>
    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h1><i class="fa fa-map-marker mr-2"></i>Manajemen Plant</h1>
            <p>Kelola lokasi plant untuk pengguna</p>
        </div>
        <a href="<?= base_url('admin/plant/create') ?>" class="btn-add-user">
            <i class="fa fa-map-marker"></i> Tambah Plant
        </a>
    </div>

    <!-- Table Card -->
    <div class="card card-users">
        <div class="card-body">
            <div class="table-wrapper">
                <table id="plantTable" class="table" style="width:100%">
                    <thead>
                        <tr>
                            <th style="width:50px">#</th>
                            <th>Kode Plant</th>
                            <th>Nama Plant</th>
                            <th style="width:120px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php

                        // no
                        $i = 1;

                        foreach ($plants as $plant) : ?>

                            <tr>
                                <td class="text-muted" style="font-size:.8rem"><?= $i++ ?></td>
                                <td><?= esc($plant->kode_plant) ?></td>

                                <td> <?= esc(ucwords(strtolower($plant->nama_plant))) ?></td>


                                <td>
                                    <div class="d-flex" style="gap:6px">
                                        <a
                                            href="<?= base_url('/admin/plant/edit/' . $plant->id) ?>"
                                            class="btn-action edit" title="Edit plant">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <a href="#"
                                            class="btn-action delete"
                                            data-toggle="modal"
                                            data-target="#deleteModal"
                                            data-id="<?= $plant->id ?>"
                                            data-nama_plant="<?= esc($plant->nama_plant) ?>"
                                            title="Hapus plant">
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
                <h5 style="font-weight:700;color:#212121">Hapus Plant?</h5>
                <p style="color:#757575;font-size:.875rem" id="deletePlant"></p>
                <div class="d-flex justify-content-center mt-3" style="gap:10px">
                    <button type="button" class="btn btn-light" style="border-radius:10px;padding:8px 24px" data-dismiss="modal">Batal</button>
                    <a id="confirmDeleteBtn" href="#" class="btn btn-danger" style="border-radius:10px;padding:8px 24px">Hapus</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->endSection(); ?>

<?php $this->section('scripts'); ?>
<script>
    $(document).ready(function() {

        // ── DataTable ──────────────────────────────────────────────────
        $('#plantTable').DataTable({
            pageLength: 10,
            lengthMenu: [10, 25, 50],
            language: {
                search: '',
                searchPlaceholder: 'Cari nama plant...',
                lengthMenu: 'Tampilkan _MENU_ data',
                info: 'Menampilkan _START_–_END_ dari _TOTAL_ plant',
                paginate: {
                    previous: '‹',
                    next: '›'
                },
                zeroRecords: 'Tidak ada data ditemukan',
                emptyTable: 'Belum ada pengguna terdaftar'
            },

        });

        // ── Delete modal ───────────────────────────────────────────────
        $('#deleteModal').on('show.bs.modal', function(e) {
            const btn = $(e.relatedTarget);
            const id = btn.data('id');
            const name = btn.data('nama_plant');
            $('#deletePlant').text('Data plant "' + name + '" akan dihapus permanen.');
            $('#confirmDeleteBtn').attr('href', '<?= base_url("admin/plant/delete/") ?>' + id);
        });
    });
</script>
<?php $this->endSection(); ?>