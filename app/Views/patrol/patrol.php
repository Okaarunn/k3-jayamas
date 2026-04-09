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
        box-shadow: 0 8px 32px rgba(74, 20, 140, 0.18);
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

    .btn-add {
        background: #fff;
        color: #283593;
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

    .btn-add:hover {
        background: #e8eaf6;
        color: #283593;
        transform: translateY(-1px);
        text-decoration: none;
    }

    .btn-export {
        background: rgba(255, 255, 255, 0.15);
        color: #fff;
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 10px;
        padding: 10px 18px;
        font-weight: 600;
        font-size: .82rem;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
        transition: all .15s;
        white-space: nowrap;
    }

    .btn-export:hover {
        background: rgba(255, 255, 255, 0.25);
        color: #fff;
        text-decoration: none;
    }

    .card-main {
        border: none;
        border-radius: 16px;
        box-shadow: 0 2px 20px rgba(0, 0, 0, 0.07);
        overflow: hidden;
    }

    .card-main .card-body {
        padding: 0;
    }

    /* Stats strip */
    .stats-strip {
        display: flex;
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
    }

    .stat-item .stat-label {
        font-size: 0.72rem;
        color: #9e9e9e;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        margin-top: 4px;
    }

    .stat-item.s1 .stat-num {
        color: #3949ab;
    }

    .stat-item.s2 .stat-num {
        color: #00695c;
    }

    .stat-item.s3 .stat-num {
        color: #f57c00;
    }

    /* Table wrapper */
    .table-wrapper {
        padding: 20px 24px 24px;
        overflow-x: auto;
    }

    /* Filter bar */
    .filter-bar {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 16px;
        padding-bottom: 16px;
        border-bottom: 1px solid #f0f0f0;
    }

    .filter-bar label {
        font-size: .78rem;
        font-weight: 600;
        color: #616161;
        text-transform: uppercase;
        letter-spacing: .5px;
        white-space: nowrap;
        margin: 0;
    }

    .filter-bar select {
        border: 1.5px solid #e0e0e0;
        border-radius: 8px;
        padding: 6px 12px;
        font-size: .82rem;
        color: #424242;
        background: #fff;
        min-width: 180px;
        outline: none;
        transition: border .2s;
    }

    .filter-bar select:focus {
        border-color: #3949ab;
    }

    /* Table */
    #patrolTable {
        width: 100% !important;
    }

    #patrolTable thead th {
        background: #f8f9ff;
        color: #5c6bc0;
        font-size: .68rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .8px;
        border: none;
        padding: 12px 10px;
        white-space: nowrap;
    }

    #patrolTable tbody tr {
        transition: background .15s;
        border-bottom: 1px solid #f5f5f5;
    }

    #patrolTable tbody tr:hover {
        background: #f9f4ff;
    }

    #patrolTable tbody td {
        padding: 10px;
        vertical-align: middle;
        border: none;
        font-size: .82rem;
        color: #424242;
    }

    /* Kode badge */
    .kode-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: #e8eaf6;
        color: #3949ab;
        border-radius: 8px;
        padding: 4px 10px;
        font-size: .75rem;
        font-weight: 700;
        font-family: monospace;
        letter-spacing: .5px;
        white-space: nowrap;
    }

    /* Status */
    .status-selesai {
        background: #e8f5e9;
        color: #388e3c;
        border-radius: 20px;
        padding: 3px 10px;
        font-size: .72rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        white-space: nowrap;
    }

    .status-proses {
        background: #fff8e1;
        color: #f57c00;
        border-radius: 20px;
        padding: 3px 10px;
        font-size: .72rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        white-space: nowrap;
    }

    /* Foto thumbnail */
    .foto-thumb {
        width: 36px;
        height: 36px;
        border-radius: 6px;
        object-fit: cover;
        cursor: pointer;
        border: 2px solid #e0e0e0;
        transition: border .15s;
        display: block;
    }

    .foto-thumb:hover {
        border-color: #3949ab;
    }

    .foto-placeholder {
        width: 36px;
        height: 36px;
        border-radius: 6px;
        background: #f5f5f5;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #bdbdbd;
        font-size: .75rem;
        border: 2px dashed #e0e0e0;
    }

    /* Action buttons */
    .btn-action {
        width: 30px;
        height: 30px;
        border-radius: 7px;
        border: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.72rem;
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

    .btn-action.del {
        background: #fce4ec;
        color: #c62828;
    }

    .btn-action.del:hover {
        background: #c62828;
        color: #fff;
    }

    /* Teks terpotong */
    .text-clamp {
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    /* DataTable overrides */
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
        background: #e8eaf6 !important;
        color: #3949ab !important;
        border: none !important;
        border-radius: 8px !important;
    }
</style>
<?php $this->endSection(); ?>


<?php $this->section('page-content'); ?>
<div class="container-fluid pb-4">

    <?= $this->include('components/alert') ?>

    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h1><i class="fas fa-route mr-2"></i> Data Patrol K3</h1>
            <p>Dokumentasi kegiatan patrol lapangan dengan foto Sebelum &amp; Sesudah</p>
        </div>
        <div class="d-flex align-items-center" style="gap:8px">
            <a href="<?= base_url('patrol/exportpdf') ?>" class="btn-export">
                <i class="fas fa-file-pdf"></i> PDF
            </a>
            <a href="<?= base_url('patrol/export') ?>" class="btn-export">
                <i class="fas fa-file-excel"></i> Excel
            </a>
            <?php if (in_groups(['administrator', 'editor'])) : ?>
                <a href="<?= base_url('patrol/create') ?>" class="btn-add">
                    <i class="fas fa-plus"></i> Tambah Patrol
                </a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Stats Strip -->
    <div class="card card-main mb-4">
        <div class="card-body">
            <div class="stats-strip">
                <?php
                $totalPatrol = count($patrol);
                $bulanIni    = date('Y-m');
                $patrolBulan = count(array_filter((array) $patrol, fn($p) => substr($p->tanggal_patrol, 0, 7) === $bulanIni));
                $selesai     = count(array_filter((array) $patrol, fn($p) => $p->status_patrol == 1));
                ?>
                <div class="stat-item s1">
                    <div class="stat-num"><?= $totalPatrol ?></div>
                    <div class="stat-label">Total Laporan</div>
                </div>
                <div class="stat-item s2">
                    <div class="stat-num"><?= $selesai ?></div>
                    <div class="stat-label">Sudah Selesai</div>
                </div>
                <div class="stat-item s3">
                    <div class="stat-num"><?= $patrolBulan ?></div>
                    <div class="stat-label">Bulan Ini</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="card card-main">
        <div class="card-body">
            <div class="table-wrapper">

                <!-- Filter plant — admin only -->
                <?php if (in_groups('administrator')) : ?>
                    <div class="filter-bar">
                        <label>Filter Plant</label>
                        <select id="filterPlant">
                            <option value="">Semua Plant</option>
                            <?php
                            $plants = [];
                            foreach ($patrol as $p) {
                                if (!empty($p->nama_plant)) $plants[$p->nama_plant] = $p->nama_plant;
                            }
                            ksort($plants);
                            foreach ($plants as $plant) : ?>
                                <option value="<?= esc($plant) ?>">
                                    <?= esc(ucwords(strtolower($plant))) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                <?php endif; ?>

                <table id="patrolTable" class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Kode</th>
                            <th>Petugas</th>
                            <th>Tgl Patrol</th>
                            <th>Temuan</th>
                            <th>Tgl Selesai</th>
                            <th>Penyelesaian</th>
                            <th>Status</th>
                            <th>Foto</th>
                            <th>Dicatat</th>
                            <th>Plant</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1;
                        foreach ($patrol as $row) :
                            $canModify = in_groups('administrator') || ($myPlantId == $row->creator_plant_id);
                        ?>
                            <tr>
                                <td class="text-muted" style="font-size:.75rem"><?= $i++ ?></td>

                                <td>
                                    <span class="kode-badge">
                                        <i class="fas fa-hashtag" style="font-size:.6rem"></i>
                                        <?= esc($row->kode) ?>
                                    </span>
                                </td>

                                <td>
                                    <div style="font-weight:600;color:#212121"><?= esc($row->nama_petugas) ?></div>
                                </td>

                                <td>
                                    <div style="font-weight:600;color:#212121;white-space:nowrap"><?= date('d M Y', strtotime($row->tanggal_patrol)) ?></div>
                                    <div style="font-size:.7rem;color:#9e9e9e"><?= date('D', strtotime($row->tanggal_patrol)) ?></div>
                                </td>

                                <td>
                                    <div class="text-clamp" title="<?= esc($row->temuan ?? '') ?>">
                                        <?= esc($row->temuan ?? '-') ?>
                                    </div>
                                </td>

                                <td>
                                    <?php if (!empty($row->tanggal_penyelesaian)) : ?>
                                        <div style="font-weight:600;color:#212121;white-space:nowrap"><?= date('d M Y', strtotime($row->tanggal_penyelesaian)) ?></div>
                                        <div style="font-size:.7rem;color:#9e9e9e"><?= date('D', strtotime($row->tanggal_penyelesaian)) ?></div>
                                    <?php else : ?>
                                        <span style="color:#bdbdbd">—</span>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <div class="text-clamp" title="<?= esc($row->penyelesaian ?? '') ?>">
                                        <?= esc($row->penyelesaian ?? '-') ?>
                                    </div>
                                </td>

                                <td>
                                    <?php if ($row->status_patrol == 1) : ?>
                                        <span class="status-selesai">
                                            <i class="fas fa-check-circle" style="font-size:.6rem"></i>
                                            Selesai
                                        </span>
                                    <?php else : ?>
                                        <span class="status-proses">
                                            <i class="fas fa-clock" style="font-size:.6rem"></i>
                                            Proses
                                        </span>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <div class="d-flex" style="gap:4px">
                                        <?php if (!empty($row->foto_before_filename)) : ?>
                                            <img src="<?= base_url('uploads/patrol/' . $row->foto_before_filename) ?>"
                                                class="foto-thumb preview-trigger"
                                                data-url="<?= base_url('uploads/patrol/' . $row->foto_before_filename) ?>"
                                                data-label="Foto Before — <?= esc($row->kode) ?>"
                                                data-toggle="modal" data-target="#previewModal"
                                                title="Before">
                                        <?php else : ?>
                                            <div class="foto-placeholder" title="Belum ada foto before">
                                                <i class="fas fa-image"></i>
                                            </div>
                                        <?php endif; ?>

                                        <?php if (!empty($row->foto_after_filename)) : ?>
                                            <img src="<?= base_url('uploads/patrol/' . $row->foto_after_filename) ?>"
                                                class="foto-thumb preview-trigger"
                                                data-url="<?= base_url('uploads/patrol/' . $row->foto_after_filename) ?>"
                                                data-label="Foto After — <?= esc($row->kode) ?>"
                                                data-toggle="modal" data-target="#previewModal"
                                                title="After">
                                        <?php else : ?>
                                            <div class="foto-placeholder" title="Belum ada foto after">
                                                <i class="fas fa-image"></i>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </td>

                                <td style="font-size:.78rem;color:#616161">
                                    <?= esc($row->created_by_username ?? '-') ?>
                                </td>

                                <td>
                                    <?php if (!empty($row->nama_plant)) : ?>
                                        <span style="background:#e8eaf6;color:#3949ab;border-radius:8px;padding:3px 8px;font-size:.72rem;font-weight:600;white-space:nowrap">
                                            <?= esc(ucwords(strtolower($row->nama_plant))) ?>
                                        </span>
                                    <?php else : ?>
                                        <span style="color:#bdbdbd;font-size:.78rem">—</span>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <?php if (in_groups(['administrator', 'editor']) && $canModify) : ?>
                                        <div class="d-flex" style="gap:5px">
                                            <a href="<?= base_url('patrol/edit/' . $row->id) ?>" class="btn-action edit" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="#" class="btn-action del"
                                                data-toggle="modal" data-target="#deleteModal"
                                                data-id="<?= $row->id ?>"
                                                data-kode="<?= esc($row->kode) ?>"
                                                title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Preview Foto -->
<div class="modal fade" id="previewModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content" style="border:none;border-radius:16px;overflow:hidden">
            <div style="background:#283593;padding:18px 24px;display:flex;align-items:center;justify-content:space-between">
                <div>
                    <h6 style="color:#fff;margin:0;font-weight:700"><i class="fas fa-camera mr-2"></i>Pratinjau Foto Patrol</h6>
                    <div style="color:rgba(255,255,255,.65);font-size:.78rem;margin-top:2px" id="previewLabel"></div>
                </div>
                <button type="button" data-dismiss="modal"
                    style="background:rgba(255,255,255,.15);border:none;border-radius:8px;width:32px;height:32px;color:#fff;cursor:pointer">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body p-4 text-center" id="previewContent"></div>
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
                <h5 style="font-weight:700;color:#212121">Hapus Laporan Patrol?</h5>
                <p style="color:#757575;font-size:.875rem" id="deleteInfo"></p>
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

        var table = $('#patrolTable').DataTable({
            pageLength: 10,
            lengthMenu: [10, 25, 50],
            order: [
                [3, 'desc']
            ],
            autoWidth: true,
            language: {
                search: '',
                searchPlaceholder: 'Cari data patrol...',
                lengthMenu: 'Tampilkan _MENU_ data',
                info: 'Menampilkan _START_–_END_ dari _TOTAL_ data',
                paginate: {
                    previous: '‹',
                    next: '›'
                },
                zeroRecords: 'Tidak ada data ditemukan',
                emptyTable: 'Belum ada laporan patrol'
            },
            columnDefs: [{
                    orderable: false,
                    targets: [8, 11]
                },
                {
                    width: '40px',
                    targets: [0]
                },
                {
                    width: '95px',
                    targets: [1]
                },
                {
                    width: '90px',
                    targets: [8]
                },
                {
                    width: '75px',
                    targets: [11]
                },
            ]
        });

        // Filter plant
        $('#filterPlant').on('change', function() {
            table.column(10).search($(this).val()).draw();
        });

        // Preview foto
        $(document).on('click', '.preview-trigger', function() {
            const url = $(this).data('url');
            const label = $(this).data('label');
            $('#previewLabel').text(label);
            $('#previewContent').html('<img src="' + url + '" style="max-width:100%;border-radius:12px">');
        });

        // Delete modal
        $('#deleteModal').on('show.bs.modal', function(e) {
            const btn = $(e.relatedTarget);
            const id = btn.data('id');
            const kode = btn.data('kode');
            $('#deleteInfo').text('Laporan patrol "' + kode + '" akan dihapus permanen.');
            $('#confirmDeleteBtn').attr('href', '<?= base_url("patrol/delete/") ?>' + id);
        });

    });
</script>
<?php $this->endSection(); ?>