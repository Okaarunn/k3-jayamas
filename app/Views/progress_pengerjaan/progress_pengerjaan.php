<?= $this->extend('templates/index'); ?>
<?php $this->section('page-content'); ?>

<div class="container-fluid pb-4">
    <?= $this->include('components/alert') ?>
    <div class="flex-column flex-md-row page-header">
        <div class="mb-3 mb-md-0">
            <h1 class="mb-1">
                <i class="fas fa-tasks mr-2"></i>
                <span class="d-block d-md-inline">Monitoring Progress Pengerjaan</span>
            </h1>
            <p class="mb-0">Pantau dan perbarui status penyelesaian setiap work permit yang sedang berjalan</p>
        </div>
    </div>

    <div class="card card-main">
        <div class="card-body">
            <div class="table-wrapper">
                <div class="row mb-3 align-items-center">
                    <div class="col-md-4">
                        <?php if (in_groups('administrator')) : ?>
                            <div class="filter-bar">
                                <select id="filterPlant">
                                    <option value="">Semua Plant</option>
                                    <?php
                                    $plants = [];
                                    foreach ($progressPengerjaans ?? [] as $pp) {
                                        if (!empty($pp['nama_plant'])) {
                                            $plants[$pp['nama_plant']] = $pp['nama_plant'];
                                        }
                                    }
                                    ksort($plants);
                                    foreach ($plants as $plant) : ?>
                                        <option value="<?= $plant ?>">
                                            <?= esc(ucwords(strtolower($plant))) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-8 text-right">
                        <button type="button" id="btnFinish" class="btn btn-success btn-sm py-2 px-3"
                            data-toggle="modal" data-target="#batchModal" disabled
                            style="border-radius: 8px; font-weight: 600;">
                            <span>Tandai Selesai</span>
                        </button>
                    </div>
                </div>

                <form id="formFinish" action="<?= base_url('progress-pengerjaan/finish-batch') ?>" method="post">
                    <?= csrf_field() ?>
                    <table id="progressTable" class="table table-hover w-100">
                        <thead>
                            <tr>
                                <th width="10"><input type="checkbox" id="checkAll"></th>
                                <th>NO WP/JSA</th>
                                <th>No Lembur</th>
                                <th>Identitas Pengaju</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Selesai</th>
                                <th>Status</th>
                                <th>Pekerjaan</th>
                                <th>Plant</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($progressPengerjaans as $prosesPengerjaan) : ?>
                                <tr>
                                    <td>
                                        <?php if ($prosesPengerjaan['status_pengerjaan'] == 'ongoing') : ?>
                                            <input type="checkbox" name="ids[]" value="<?= $prosesPengerjaan['id'] ?>" class="checkItem">
                                        <?php endif; ?>
                                    </td>
                                    <td class="font-weight-bold text-primary"><?= $prosesPengerjaan['no_wp'] ?></td>
                                    <td><?= $prosesPengerjaan['no_lembur'] ?? '<span class="text-muted small">Tanpa Lembur</span>' ?></td>
                                    <td class="vendor-column"><?= $prosesPengerjaan['nama_pengaju'] ?? '-' ?></td>
                                    <td><?= date('d M Y', strtotime($prosesPengerjaan['tgl_mulai'])) ?></td>
                                    <td>
                                        <?= (!empty($prosesPengerjaan['tgl_selesai']))
                                            ? date('d M Y', strtotime($prosesPengerjaan['tgl_selesai']))
                                            : '-' ?>
                                    </td>

                                    <td>
                                        <?php if ($prosesPengerjaan['status_pengerjaan'] == 'ongoing') : ?>
                                            <span class="badge badge-warning" style="padding: 5px 10px; border-radius: 6px;">ONGOING</span>
                                        <?php else : ?>
                                            <span class="badge badge-success" style="padding: 5px 10px; border-radius: 6px;">FINISHED</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= $prosesPengerjaan['nama_pekerjaan'] ?></td>
                                    <td>
                                        <span class="badge" style="background:#e8eaf6;color:#3949ab;border-radius:8px;padding:3px 8px;font-size:.72rem;font-weight:600;">
                                            <?= ucwords(strtolower($prosesPengerjaan['nama_plant'])) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php if ($prosesPengerjaan['status_pengerjaan'] == 'ongoing') : ?>
                                            <button type="button"
                                                class="btn btn-sm btn-success btn-finish-single"
                                                title="Tandai Selesai"
                                                data-toggle="modal"
                                                data-target="#singleModal"
                                                data-id="<?= $prosesPengerjaan['id'] ?>"
                                                data-nowp="<?= esc($prosesPengerjaan['no_wp']) ?>">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        <?php else : ?>
                                            <button type="button" class="btn btn-sm btn-light border" disabled title="Sudah selesai">
                                                <i class="fas fa-check-double text-success"></i>
                                            </button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Finish Single -->
<div class="modal fade" id="singleModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border:none;border-radius:16px;overflow:hidden">
            <div class="modal-body text-center p-4">
                <div style="width:64px;height:64px;background:#e8f5e9;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 16px">
                    <i class="fas fa-check" style="color:#388e3c;font-size:1.4rem"></i>
                </div>
                <h5 style="font-weight:700;color:#212121">Tandai Selesai?</h5>
                <p style="color:#757575;font-size:.875rem" id="singleInfo"></p>
                <div class="d-flex justify-content-center mt-3">
                    <form id="formFinishSingle" action="<?= base_url('progress-pengerjaan/finish-single') ?>" method="post" style="width:100%">
                        <?= csrf_field() ?>
                        <input type="hidden" name="id" id="finishSingleId">
                        <div class="d-flex justify-content-center" style="gap:10px">
                            <button type="button" class="btn btn-light" style="border-radius:10px;padding:8px 24px" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-success" style="border-radius:10px;padding:8px 24px">Selesaikan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Finish Batch -->
<div class="modal fade" id="batchModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border:none;border-radius:16px;overflow:hidden">
            <div class="modal-body text-center p-4">
                <div style="width:64px;height:64px;background:#e8f5e9;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 16px">
                    <i class="fas fa-check-double" style="color:#388e3c;font-size:1.4rem"></i>
                </div>
                <h5 style="font-weight:700;color:#212121">Tandai Selesai?</h5>
                <p style="color:#757575;font-size:.875rem" id="batchInfo"></p>
                <div class="d-flex justify-content-center mt-3" style="gap:10px">
                    <button type="button" class="btn btn-light" style="border-radius:10px;padding:8px 24px" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-success" style="border-radius:10px;padding:8px 24px" id="btnBatchConfirm">Selesaikan</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->endSection(); ?>


<?php $this->section('scripts'); ?>

<script>
    var table = $('#progressTable').DataTable({
        pageLength: 10,
        lengthMenu: [10, 25, 50],
        autoWidth: false,
        language: {
            search: '',
            searchPlaceholder: 'Cari work permit...',
            lengthMenu: 'Tampilkan _MENU_ data',
            info: 'Menampilkan _START_–_END_ dari _TOTAL_ data',
            paginate: {
                previous: '‹',
                next: '›'
            },
            zeroRecords: 'Tidak ada data ditemukan',
            emptyTable: 'Belum ada data work permit'
        },
        columnDefs: [{
                orderable: false,
                targets: [0, 9]
            },
            {
                width: '0px',
                targets: 0
            }
        ]
    });

    // ── Check All ──────────────────────────────────────────
    $('#checkAll').on('change', function() {
        var checked = $(this).is(':checked');
        table.rows({
                page: 'current'
            }).nodes().to$()
            .find('.checkItem').prop('checked', checked);
        updateFinishBtn();
    });

    // Update state #checkAll jika item diceklis manual
    $(document).on('change', '.checkItem', function() {
        var total = table.rows({
            page: 'current'
        }).nodes().to$().find('.checkItem').length;
        var checked = table.rows({
            page: 'current'
        }).nodes().to$().find('.checkItem:checked').length;
        $('#checkAll').prop('indeterminate', checked > 0 && checked < total);
        $('#checkAll').prop('checked', checked === total && total > 0);
        updateFinishBtn();
    });

    // Aktifkan / nonaktifkan tombol sesuai jumlah yang terceklis
    function updateFinishBtn() {
        var count = $('.checkItem:checked').length;
        var $btn = $('#btnFinish');
        $btn.prop('disabled', count === 0);
        $btn.find('span').text(count > 0 ? 'Tandai Selesai (' + count + ')' : 'Tandai Selesai');
    }

    $(document).ready(function() {

        // ── Modal: Finish Single ───────────────────────────
        $('#singleModal').on('show.bs.modal', function(e) {
            var btn = $(e.relatedTarget);
            var id = btn.data('id');
            var noWp = btn.data('nowp');
            $('#singleInfo').html('Work permit <strong>' + noWp + '</strong> akan ditandai sebagai FINISHED.');
            $('#finishSingleId').val(id);
        });

        // ── Modal: Finish Batch ────────────────────────────
        $('#batchModal').on('show.bs.modal', function() {
            var count = $('.checkItem:checked').length;
            $('#batchInfo').html('<strong>' + count + ' data</strong> yang dipilih akan ditandai sebagai FINISHED.');
        });

        $('#btnBatchConfirm').on('click', function() {
            $('#batchModal').modal('hide');
            $('#formFinish').submit();
        });

    });

    updateFinishBtn(); // inisialisasi saat load
</script>

<?php $this->endSection(); ?>