<?= $this->extend('templates/index'); ?>
<?php $this->section('page-content'); ?>
<div class="container-fluid">
    <!-- Header -->
    <div class="page-header">
        <div>
            <h1><i class="fas fa-fw fa-lock"></i>Manajemen Roles</h1>
            <p>Kelola akses role untuk pengguna</p>
        </div>
        <div class="page-header-actions">

            <a href="/admin/roles/create" class="btn-add">
                <i class="fas fa-plus"></i> Tambah Role
            </a>
        </div>
    </div>

    <!-- Alerts -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle"></i> <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <!-- Roles Table Card -->
    <div class="card card-roles">
        <div class="card-body">
            <div>
                <?php if (!empty($roles)): ?>
                    <table id="rolesTable" class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Role</th>
                                <th>Deskripsi</th>
                                <th>Jumlah Pengguna</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1;
                            foreach ($roles as $role): ?>

                                <tr>
                                    <td>
                                        <span class="badge-role"><?= $i++ ?></span>
                                    </td>
                                    <td>
                                        <span class="role-name"><?= esc($role->name) ?></span>
                                    </td>
                                    <td>
                                        <?= esc($role->description ?? '-') ?>
                                    </td>
                                    <td>
                                        <?php
                                        $userCount = db_connect()->table('auth_groups_users')
                                            ->where('group_id', $role->id)
                                            ->countAllResults();
                                        ?>
                                        <span class="badge-role bg-primary text-white"><?= $userCount ?></span>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="/admin/roles/edit/<?= $role->id ?>" class="btn-sm btn-edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="#" class="btn-action delete"
                                                data-toggle="modal" data-target="#modalRoleDelete"
                                                data-id="<?= $role->id ?>"
                                                data-name="<?= esc($role->name) ?>"
                                                title="Hapus role">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="empty-state">
                        <i class="fas fa-inbox"></i>
                        <h5>Tidak ada role</h5>
                        <p>Belum ada role yang dibuat. <a href="/admin/roles/create">Buat role baru</a></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- modal delete -->
<div class="modal fade" id="modalRoleDelete" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border:none;border-radius:16px;overflow:hidden">
            <div class="modal-body text-center p-4">
                <div style="width:64px;height:64px;background:#fce4ec;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 16px">
                    <i class="fas fa-trash" style="color:#c62828;font-size:1.4rem"></i>
                </div>

                <h5 style="font-weight:700;color:#212121">
                    Hapus Role
                </h5>

                <p style="color:#757575;font-size:.875rem" id="deleteRole"></p>

                <div class="d-flex justify-content-center mt-3" style="gap:10px">
                    <button type="button" class="btn btn-light"
                        style="border-radius:10px;padding:8px 24px"
                        data-dismiss="modal">
                        Batal
                    </button>

                    <a id="confirmDeleteBtn"
                        href="#"
                        class="btn btn-danger"
                        style="border-radius:10px;padding:8px 24px">
                        Hapus
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->endSection(); ?>


<?php $this->section('scripts'); ?>

<script>
    // Initialize DataTables
    $(document).ready(function() {
        $('#rolesTable').DataTable({
            pageLength: 5,
            lengthMenu: [5, 10, 25, 50],
            language: {
                search: '',
                searchPlaceholder: 'Cari role...',
                lengthMenu: 'Tampilkan _MENU_ data',
                info: 'Menampilkan _START_–_END_ dari _TOTAL_ role',
                paginate: {
                    previous: '‹',
                    next: '›'
                },
                zeroRecords: 'Tidak ada data ditemukan',
                emptyTable: 'Belum ada role'
            },
            columnDefs: [{
                orderable: false,
                targets: [1, 2, 3, 4]
            }]
        });

        $('#modalRoleDelete').on('show.bs.modal', function(e) {
            const btn = $(e.relatedTarget);
            const id = btn.data('id');
            const name = btn.data('name');

            $('#deleteRole').text(`Role "${name}" akan dihapus secara permanen.`);
            $('#confirmDeleteBtn').attr('href', '<?= base_url("admin/roles/delete/") ?>' + id);
        });
    });
</script>
<?php $this->endSection(); ?>