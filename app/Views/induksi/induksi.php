<?= $this->extend('templates/index'); ?>
<?php $this->section('page-content'); ?>

<div class="container-fluid pb-4">

    <?= $this->include('components/alert') ?>

    <div class="page-header">
        <div>
            <h1><i class="fas fa-user-check mr-2"></i> Data Induksi Keselamatan dan Kesehatan Kerja</h1>
            <p>Pencatatan dan manajemen hasil training / induksi K3</p>
        </div>
        <div class="d-flex" style="gap:10px">

            <a href="<?= base_url('induksi/exportpdf') ?>" class="btn-export">
                <i class="fas fa-file-download"></i> Export PDF
            </a>

            <a href="<?= base_url('induksi/export') ?>" class="btn-export">
                <i class="fas fa-file-download"></i> Export Excel
            </a>

            <?php if (has_permission('manage-data')) : ?>
                <a href="<?= base_url('induksi/create') ?>" class="btn-add">
                    <i class="fas fa-plus"></i> Tambah Induksi
                </a>
            <?php endif; ?>
        </div>
    </div>

    <!-- table -->
    <div class="card card-main">
        <div class="card-body">
            <div class="table-wrapper">

                <?php if (in_groups('administrator')) : ?>
                    <div class="filter-bar">
                        <select id="filterPlant">
                            <option value="">Semua Plant</option>
                            <?php
                            $plants = [];
                            foreach ($induksi as $i) {
                                if (!empty($i->nama_plant)) $plants[$i->nama_plant] = $i->nama_plant;
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

                <table id="induksiTable" class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tanggal</th>
                            <th>Keterangan</th>
                            <th>Peserta</th>
                            <th>Dokumentasi</th>
                            <th>Absensi</th>
                            <th>Dicatat Oleh</th>
                            <th>Plant</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1;
                        foreach ($induksi as $row) : ?>
                            <tr>
                                <td><?= $i++ ?></td>

                                <td><?= date('d M Y', strtotime($row->tanggal_induksi)) ?></td>

                                <td><?= esc($row->keterangan ?? '-') ?></td>

                                <td>
                                    <span class="peserta-badge">
                                        <?= number_format($row->jumlah_peserta) ?>
                                    </span>
                                </td>

                                <!-- DOKUMENTASI UTAMA -->
                                <td>
                                    <?php if (!empty($row->dokumentasi)) : ?>
                                        <div style="display:flex;flex-wrap:wrap;gap:6px">

                                            <?php foreach ($row->dokumentasi as $doc) : ?>
                                                <?php
                                                $url = base_url('uploads/induksi/' . $doc->filename);
                                                $isImage = str_contains($doc->mime, 'image');
                                                ?>

                                                <?php if ($isImage) : ?>
                                                    <img src="<?= $url ?>" class="foto-thumb preview-trigger"
                                                        data-url="<?= $url ?>" data-label="Dokumentasi — <?= date('d M Y', strtotime($row->tanggal_induksi)) ?>"
                                                        data-toggle="modal" data-target="#previewModal">
                                                <?php else : ?>
                                                    <a href="<?= $url ?>" target="_blank" class="doc-chip">
                                                        <?= esc($doc->original_name) ?>
                                                    </a>
                                                <?php endif; ?>

                                            <?php endforeach; ?>

                                        </div>
                                    <?php else : ?>
                                        <span class="no-doc">Tidak ada</span>
                                    <?php endif; ?>
                                </td>

                                <!-- ABSENSI (MULTIPLE) -->
                                <td>
                                    <?php if (!empty($row->absensi)) : ?>
                                        <div style="display:flex;flex-wrap:wrap;gap:6px">

                                            <?php foreach ($row->absensi as $abs) : ?>
                                                <?php
                                                $url = base_url('uploads/induksi/' . $abs->filename);
                                                $isImage = str_contains($abs->mime, 'image');
                                                ?>

                                                <?php if ($isImage) : ?>
                                                    <img src="<?= $url ?>" class="foto-thumb preview-trigger"
                                                        data-url="<?= $url ?>" data-label="Absensi — <?= date('d M Y', strtotime($row->tanggal_induksi)) ?>"
                                                        data-toggle="modal" data-target="#previewModal">
                                                <?php else : ?>
                                                    <a href="<?= $url ?>" target="_blank" class="doc-chip">
                                                        <?= esc($abs->original_name) ?>
                                                    </a>
                                                <?php endif; ?>

                                            <?php endforeach; ?>

                                        </div>
                                    <?php else : ?>
                                        <span class="no-doc">Tidak ada</span>
                                    <?php endif; ?>
                                </td>

                                <!-- DICATAT OLEH -->
                                <td>

                                    <?= esc($row->created_by_username) ?>
                                </td>

                                <!-- PLANT -->
                                <td> <span style="background:#e8eaf6;color:#3949ab;border-radius:8px;padding:3px 8px;font-size:.72rem;font-weight:600;white-space:nowrap">
                                        <?= esc(ucwords(strtolower($row->nama_plant))) ?>
                                    </span></td>

                                <!-- AKSI -->
                                <td>
                                    <?php
                                    $canModify = has_permission('manage-data') &&
                                        (in_groups('administrator') || $myPlantId == $row->creator_plant_id);
                                    ?>

                                    <?php if ($canModify): ?>
                                        <a href="<?= base_url('induksi/edit/' . $row->id) ?>" class="btn-action edit">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <a href="#" class="btn-action del"
                                            data-toggle="modal"
                                            data-target="#deleteModal"
                                            data-id="<?= $row->id ?>">
                                            <i class="fas fa-trash"></i>
                                        </a>
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

<!-- PREVIEW MODAL -->
<div class="modal fade" id="previewModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content" style="border:none;border-radius:16px;overflow:hidden">
            <div style="background:#283593;padding:18px 24px;display:flex;align-items:center;justify-content:space-between">
                <div>
                    <h6 style="color:#fff;margin:0;font-weight:700"><i class="fas fa-camera mr-2"></i>Pratinjau Foto Induksi</h6>
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

<!-- DELETE MODAL -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border:none;border-radius:16px;overflow:hidden">
            <div class="modal-body text-center p-4">
                <div style="width:64px;height:64px;background:#fce4ec;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 16px">
                    <i class="fas fa-trash" style="color:#c62828;font-size:1.4rem"></i>
                </div>
                <h5 style="font-weight:700;color:#212121">Hapus Laporan Induksi?</h5>
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

        $('#induksiTable').DataTable({
            pageLength: 10,
            lengthMenu: [10, 25, 50],
            order: [
                [3, 'desc']
            ],
            autoWidth: true,
            language: {
                search: '',
                searchPlaceholder: 'Cari data induksi...',
                lengthMenu: 'Tampilkan _MENU_ data',
                info: 'Menampilkan _START_–_END_ dari _TOTAL_ data',
                paginate: {
                    previous: '‹',
                    next: '›'
                },
                zeroRecords: 'Tidak ada data ditemukan',
                emptyTable: 'Belum ada laporan induksi'
            },
            columnDefs: [{
                    orderable: false,
                },
                {
                    width: '0px',
                    targets: [0]
                },
            ]

        });

        // preview
        $(document).on('click', '.preview-trigger', function() {
            const url = $(this).data('url');
            const label = $(this).data('label');
            $('#previewLabel').text(label);
            $('#previewContent').html('<img src="' + url + '" style="max-width:70%;border-radius:12px">');
            $('#previewModal').modal('show');
        });

        // delete
        $('#deleteModal').on('show.bs.modal', function(e) {
            const id = $(e.relatedTarget).data('id');

            $('#deleteInfo').text('Data Induksi akan dihapus permanen.');

            $('#confirmDeleteBtn').attr('href', '<?= base_url("induksi/delete/") ?>' + id);
        });

        // Filter plant
        $('#filterPlant').on('change', function() {
            table.column(7).search($(this).val()).draw();
        });


    });
</script>
<?php $this->endSection(); ?>