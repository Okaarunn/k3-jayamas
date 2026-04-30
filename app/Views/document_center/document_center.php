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
                    Document Center K3
                </span>
            </h1>
            <p class="mb-0">
                Di sini Anda dapat mengakses berbagai dokumen terkait K3, seperti prosedur keselamatan, panduan kerja, dan laporan insiden.
            </p>
        </div>

        <!-- button -->
        <div class="d-flex flex-wrap header-actions" style="gap:8px">

            <a href="<?= base_url('f') ?>" class="btn-export">
                <i class="fas fa-file-pdf mr-1"></i>
                <span>Export PDF</span>
            </a>

            <a href="<?= base_url('') ?>" class="btn-export">
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


                <table id="approvalk3Table" class="table">
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
                            <th>Plant</th>
                        </tr>
                    </thead>
                    <tbody>


                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>






<?php $this->endSection(); ?>