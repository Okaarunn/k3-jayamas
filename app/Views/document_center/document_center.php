<?= $this->extend('templates/index'); ?>
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
                    Pusat Dokumen K3
                </span>
            </h1>
            <p class="mb-0">
                Arsip lengkap work permit, izin lembur, dan status pengerjaan seluruh plant
            </p>
        </div>

        <!-- button -->
        <div class="d-flex flex-wrap header-actions" style="gap:8px">

            <a href="<?= base_url('document-center/exportpdf') ?>" class="btn-export">
                <i class="fas fa-file-pdf mr-1"></i>
                <span>Export PDF</span>
            </a>

            <a href="<?= base_url('document-center/exportexcel') ?>" class="btn-export">
                <i class="fas fa-file-excel mr-1"></i>
                <span>Export Excel</span>
            </a>
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

                            foreach ($documentCenters ?? [] as $dc) {
                                if (!empty($dc['nama_plant'])) {
                                    $plants[$dc['nama_plant']] = $dc['nama_plant'];
                                }
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

                <table id="documentCenterTable" class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>NO WP/JSA</th>
                            <th>No Lembur</th>
                            <th>Identitas Pengaju</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                            <th>Pekerjaan</th>
                            <th>Lokasi</th>
                            <th>Status</th>

                            <?php if (in_groups('administrator')) : ?>
                                <th>Plant</th>
                            <?php endif; ?>

                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($documentCenters as $i => $documentCenter): ?>
                            <tr>
                                <td><?= $i + 1 ?></td>
                                <td><?= esc($documentCenter['no_wp']) ?></td>
                                <td><?= esc($documentCenter['no_lembur'] ?? '-') ?></td>
                                <td><?= esc($documentCenter['nama_pengaju']) ?></td>
                                <td><?= esc($documentCenter['tgl_mulai'] ?? '-') ?></td>
                                <td><?= esc($documentCenter['tgl_selesai'] ?? '-') ?></td>
                                <td><?= esc($documentCenter['nama_pekerjaan']) ?></td>
                                <td><?= esc($documentCenter['lokasi_kerja']) ?></td>
                                <td><?= esc($documentCenter['status_pengerjaan']) ?></td>

                                <?php if (in_groups('administrator')) : ?>
                                    <td><?= esc($documentCenter['nama_plant']) ?></td>
                                <?php endif; ?>
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
    var table = $('#documentCenterTable').DataTable({
        pageLength: 10,
        lengthMenu: [10, 25, 50],
        autoWidth: false,
        language: {
            search: '',
            searchPlaceholder: 'Cari document center...',
            lengthMenu: 'Tampilkan _MENU_ data',
            info: 'Menampilkan _START_–_END_ dari _TOTAL_ data',
            paginate: {
                previous: '‹',
                next: '›'
            },
            zeroRecords: 'Tidak ada data ditemukan',
            emptyTable: 'Belum ada data document center'
        },
        columnDefs: [{
                orderable: false,
                targets: [0]
            },
            {
                width: '0px',
                targets: 0
            }
        ]
    });
</script>
<?php $this->endSection(); ?>