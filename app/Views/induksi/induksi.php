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
        box-shadow: 0 8px 32px rgba(0, 77, 64, 0.18);
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
        background: #e0f2f1;
        color: #283593;
        transform: translateY(-1px);
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
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
        color: #00695c;
    }

    .stat-item.s2 .stat-num {
        color: #1a237e;
    }

    .stat-item.s3 .stat-num {
        color: #f57c00;
    }

    /* Table */
    .table-wrapper {
        padding: 20px 24px 24px;
    }

    #induksiTable thead th {
        background: #f0faf9;
        color: #5c6bc0;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        border: none;
        padding: 14px 16px;
    }

    #induksiTable tbody tr {
        transition: background .15s;
        border-bottom: 1px solid #f5f5f5;
    }

    #induksiTable tbody tr:hover {
        background: #f0faf9;
    }

    #induksiTable tbody td {
        padding: 14px 16px;
        vertical-align: middle;
        border: none;
        font-size: 0.875rem;
        color: #424242;
    }

    /* Doc preview chip */
    .doc-chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #f0faf9;
        border: 1px solid #b2dfdb;
        border-radius: 8px;
        padding: 5px 10px;
        font-size: .78rem;
        color: #00695c;
        text-decoration: none;
        max-width: 180px;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
        transition: background .15s;
    }

    .doc-chip:hover {
        background: #b2dfdb;
        color: #004d40;
        text-decoration: none;
    }

    .doc-chip i {
        flex-shrink: 0;
    }

    .no-doc {
        font-size: .78rem;
        color: #bdbdbd;
        font-style: italic;
    }

    /* Action buttons */
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

    .btn-action.del {
        background: #fce4ec;
        color: #c62828;
    }

    .btn-action.del:hover {
        background: #c62828;
        color: #fff;
    }

    .btn-action.preview {
        background: #e0f2f1;
        color: #00695c;
    }

    .btn-action.preview:hover {
        background: #00695c;
        color: #fff;
    }

    /* DataTable override */
    div.dataTables_wrapper div.dataTables_filter input {
        border: 1.5px solid #e0e0e0;
        border-radius: 8px;
        padding: 6px 12px;
        font-size: 0.85rem;
        outline: none;
        transition: border .2s;
    }

    div.dataTables_wrapper div.dataTables_filter input:focus {
        border-color: #00897b;
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
        background: #e0f2f1 !important;
        color: #00695c !important;
        border: none !important;
        border-radius: 8px !important;
    }

    /* Export btn */
    .btn-export {
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

    .btn-export:hover {
        background: rgba(255, 255, 255, 0.25);
        color: #fff;
        text-decoration: none;
    }

    /* Peserta badge */
    .peserta-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: #e8eaf6;
        color: #3949ab;
        border-radius: 20px;
        padding: 3px 10px;
        font-size: .78rem;
        font-weight: 700;
    }

    /* Preview modal image */
    #previewImg {
        max-width: 100%;
        border-radius: 12px;
    }

    .foto-thumb {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        object-fit: cover;
        cursor: pointer;
        border: 2px solid #e0e0e0;
        transition: border .15s;
    }

    .foto-thumb:hover {
        border-color: #00897b;
    }

    .foto-placeholder {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        background: #f5f5f5;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #bdbdbd;
    }
</style>

<div class="container-fluid pb-4">

    <?= $this->include('components/alert') ?>

    <!-- page header-->
    <div class="page-header">
        <div>
            <h1><i class="fas fa-user-check mr-2"></i> Data Induksi Keselamatan dan Kesehatan Kerja</h1>
            <p>Pencatatan dan manajemen hasil training / induksi Keselamatan dan Kesehatan Kerja</p>
        </div>
        <div class="d-flex" style="gap:10px">

            <!-- export pdf -->
            <a href="<?= base_url('induksi/exportpdf') ?>" class="btn-export">
                <i class="fas fa-file-download"></i> Export PDF
            </a>

            <!-- button export -->
            <a href="<?= base_url('induksi/export') ?>" class="btn-export">
                <i class="fas fa-file-download"></i> Export Excel
            </a>
            <!-- button add data induksi -->
            <?php if (in_groups(['administrator', 'editor'])) : ?>
                <a href="<?= base_url('induksi/create') ?>" class="btn-add">
                    <i class="fas fa-plus"></i> Tambah Induksi
                </a>
            <?php endif; ?>
        </div>
    </div>

    <!-- card total data -->
    <div class="card card-main mb-4">
        <div class="card-body">
            <div class="stats-strip">
                <?php
                $totalInduksi  = count($induksi);
                $totalPeserta  = array_sum(array_column((array) $induksi, 'jumlah_peserta'));
                $bulanIni      = date('Y-m');
                $induksiBulan  = count(array_filter((array) $induksi, fn($i) => substr($i->tanggal_induksi, 0, 7) === $bulanIni));
                ?>
                <div class="stat-item s1">
                    <div class="stat-num"><?= $totalInduksi ?></div>
                    <div class="stat-label">Total Sesi Induksi</div>
                </div>
                <div class="stat-item s2">
                    <div class="stat-num"><?= number_format($totalPeserta) ?></div>
                    <div class="stat-label">Total Peserta</div>
                </div>
                <div class="stat-item s3">
                    <div class="stat-num"><?= $induksiBulan ?></div>
                    <div class="stat-label">Sesi Bulan Ini</div>
                </div>
            </div>
        </div>
    </div>

    <!-- data table -->
    <div class="card card-main">
        <div class="card-body">
            <div class="table-wrapper">

                <!-- FILTER PLANT -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <select id="filterPlant" class="form-control" style="min-width:200px">
                            <option value="">Semua Plant</option>
                            <?php
                            $plants = [];
                            foreach ($induksi as $i) {
                                if (!empty($i->nama_plant)) {
                                    $plants[$i->nama_plant] = $i->nama_plant;
                                }
                            }
                            ksort($plants);
                            foreach ($plants as $plant) :
                            ?>
                                <option value="<?= esc($plant) ?>">
                                    <?= esc(ucwords(strtolower($plant))) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <table id="induksiTable" class="table" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tanggal</th>
                            <th>Keterangan</th>
                            <th>Peserta</th>
                            <th>Dokumentasi</th>
                            <th>Dicatat</th>
                            <th>Plant</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1;
                        foreach ($induksi as $row) : ?>
                            <tr>
                                <td><?= $i++ ?></td>

                                <td>
                                    <div style="font-weight:600">
                                        <?= date('d M Y', strtotime($row->tanggal_induksi)) ?>
                                    </div>
                                    <div style="font-size:.72rem;color:#9e9e9e">
                                        <?= date('l', strtotime($row->tanggal_induksi)) ?>
                                    </div>
                                </td>

                                <td style="max-width:200px">
                                    <div style="-webkit-line-clamp:2;display:-webkit-box;-webkit-box-orient:vertical;overflow:hidden; line-clamp: 2;">
                                        <?= esc($row->keterangan ?? '-') ?>
                                    </div>
                                </td>

                                <td>
                                    <span class="peserta-badge">
                                        <?= number_format($row->jumlah_peserta) ?>
                                    </span>
                                </td>

                                <!-- DOKUMENTASI -->
                                <td>
                                    <?php if (!empty($row->dokumentasi_filename)) : ?>
                                        <?php
                                        $url = base_url('uploads/induksi/' . $row->dokumentasi_filename);
                                        $isImage = str_contains($row->dokumentasi_mime, 'image');
                                        ?>

                                        <?php if ($isImage) : ?>
                                            <img src="<?= $url ?>"
                                                class="foto-thumb preview-trigger"
                                                data-url="<?= $url ?>"
                                                data-label="Dokumentasi"
                                                data-toggle="modal" data-target="#previewModal">
                                        <?php else : ?>
                                            <a href="<?= $url ?>" target="_blank" class="doc-chip">
                                                <?= esc($row->dokumentasi_original_name) ?>
                                            </a>
                                        <?php endif; ?>
                                    <?php else : ?>
                                        <div class="foto-placeholder">
                                            <i class="fas fa-image"></i>
                                        </div>
                                    <?php endif; ?>

                                    <?php if (!empty($row->dokumentasi_absensi_filename)) : ?>
                                        <?php
                                        $url = base_url('uploads/induksi/' . $row->dokumentasi_absensi_filename);
                                        $isImage = str_contains($row->dokumentasi_absensi_mime, 'image');
                                        ?>

                                        <?php if ($isImage) : ?>
                                            <img src="<?= $url ?>"
                                                class="foto-thumb preview-trigger"
                                                data-url="<?= $url ?>"
                                                data-label="Dokumentasi"
                                                data-toggle="modal" data-target="#previewModal">
                                        <?php else : ?>
                                            <a href="<?= $url ?>" target="_blank" class="doc-chip">
                                                <?= esc($row->dokumentasi_absensi_original_name) ?>
                                            </a>
                                        <?php endif; ?>
                                    <?php else : ?>
                                        <div class="foto-placeholder">
                                            <i class="fas fa-image"></i>
                                        </div>
                                    <?php endif; ?>
                                </td>



                                <td><?= esc($row->created_by_username ?? '-') ?></td>

                                <!-- PLANT -->
                                <td>
                                    <?php if (!empty($row->nama_plant)) : ?>
                                        <span style="background:#f3e5f5;color:#6a1b9a;border-radius:8px;padding:3px 10px;font-size:.75rem">
                                            <?= esc($row->nama_plant) ?>
                                        </span>
                                    <?php else : ?>
                                        -
                                    <?php endif; ?>
                                </td>

                                <!-- AKSI -->
                                <td>
                                    <div class="d-flex" style="gap:6px">
                                        <?php
                                        $canModify = in_groups('administrator') || ($myPlantId == $row->creator_plant_id);
                                        ?>

                                        <?php if ($canModify && in_groups(['administrator', 'editor'])) : ?>
                                            <a href="<?= base_url('induksi/edit/' . $row->id) ?>" class="btn-action edit">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <a href="#" class="btn-action del"
                                                data-toggle="modal"
                                                data-target="#deleteModal"
                                                data-id="<?= $row->id ?>"
                                                data-keterangan="<?= esc($row->keterangan) ?>">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        <?php endif; ?>
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

<!-- Modal: Preview Dokumentasi -->
<div class="modal fade" id="previewModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content" style="border:none;border-radius:16px;overflow:hidden">
            <div style="background:linear-gradient(135deg,#004d40,#00897b);padding:18px 24px;display:flex;align-items:center;justify-content:space-between">
                <div>
                    <h6 style="color:#fff;margin:0;font-weight:700"><i class="fas fa-file-image mr-2"></i>Pratinjau Dokumentasi</h6>
                    <div style="color:rgba(255,255,255,.65);font-size:.78rem;margin-top:2px" id="previewLabel"></div>
                </div>
                <button type="button" data-dismiss="modal"
                    style="background:rgba(255,255,255,.15);border:none;border-radius:8px;width:32px;height:32px;color:#fff;cursor:pointer">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body p-4 text-center" id="previewContent">
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
                <h5 style="font-weight:700;color:#212121">Hapus Data Induksi?</h5>
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

        var table = $('#induksiTable').DataTable({
            pageLength: 5,
            lengthMenu: [5, 10, 25, 50],
            order: [
                [1, 'desc']
            ],
            columnDefs: [{
                orderable: false,
                targets: [4, 6, 7]
            }],
            language: {
                search: '',
                searchPlaceholder: 'Cari data induksi...',
                paginate: {
                    previous: '‹',
                    next: '›'
                },

                zeroRecords: 'Tidak ada data ditemukan',
                emptyTable: 'Belum ada data induksi'
            }
        });

        $('#filterPlant').on('change', function() {
            var val = $(this).val();

            table.column(6).search(val).draw();
        });


        // preview photo
        $(document).on('click', '.preview-trigger', function() {
            const url = $(this).data('url');
            const label = $(this).data('label');

            $('#previewLabel').text(label);
            $('#previewContent').html('<img src="' + url + '" style="max-width:60%">');
        });

        // show delete modal
        $('#deleteModal').on('show.bs.modal', function(e) {
            const btn = $(e.relatedTarget);
            const id = btn.data('id');
            const ket = btn.data('keterangan');

            $('#deleteInfo').text('Data "' + (ket || id) + '" akan dihapus.');
            $('#confirmDeleteBtn').attr('href', '<?= base_url("induksi/delete/") ?>' + id);
        });

    });
</script>
<?php $this->endSection(); ?>