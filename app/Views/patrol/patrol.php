<?= $this->extend('templates/index'); ?>

<?php $this->section('styles'); ?>

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
                <i class="fas fa-file-download"></i> Export PDF
            </a>

            <a href="<?= base_url('patrol/export') ?>" class="btn-export">
                <i class="fas fa-file-download"></i> Export Excel
            </a>
            <?php if (in_groups(['administrator', 'editor'])) : ?>
                <a href="<?= base_url('patrol/create') ?>" class="btn-add">
                    <i class="fas fa-plus"></i> Tambah Patrol
                </a>
            <?php endif; ?>
        </div>
    </div>



    <!-- Table Card -->
    <div class="card card-main">
        <div class="card-body">
            <div class="table-wrapper">

                <!-- Filter plant — admin only -->
                <?php if (in_groups('administrator')) : ?>
                    <div class="filter-bar">
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
                            <th>Lokasi</th>
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
                                <td class="text-muted" style="font-size:.75rem;"><?= $i++ ?></td>

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
                                    <div style="font-weight:600;color:#212121"><?= esc($row->lokasi) ?></div>
                                </td>

                                <td>
                                    <div style="font-weight:600;color:#212121;white-space:nowrap"><?= date('d M Y', strtotime($row->tanggal_patrol)) ?></div>

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
                                    <?php if (!empty($row->penyelesaian)) : ?>
                                        <?= esc($row->penyelesaian ?? '-') ?>
                                    <?php else : ?>
                                        <span style="color:#bdbdbd">—</span>
                                    <?php endif; ?>
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
                                    <span style="background:#e8eaf6;color:#3949ab;border-radius:8px;padding:3px 8px;font-size:.72rem;font-weight:600;white-space:nowrap">
                                        <?= esc(ucwords(strtolower($row->nama_plant))) ?>
                                    </span>

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
                    targets: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
                },
                {
                    width: '0px',
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
            $('#previewContent').html('<img src="' + url + '" style="max-width:70%;border-radius:12px">');
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