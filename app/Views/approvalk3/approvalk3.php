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
                    Data Approval K3 Permit Request
                </span>
            </h1>
            <p class="mb-0">
                Data approval k3
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
                <?php if (in_groups('administrator')) : ?>
                    <div class="filter-bar">
                        <select id="filterPlant">
                            <option value="">Semua Plant</option>
                            <?php
                            $plants = [];
                            foreach ($workPermits ?? [] as $wp) {
                                if (!empty($wp['nama_plant'])) {
                                    $plants[$wp['nama_plant']] = $wp['nama_plant'];
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

                <table id="approvalk3Table" class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tanggal</th>
                            <th>No WP/JSA</th>
                            <th>Pekerjaan</th>
                            <th>Lokasi</th>
                            <th>Tipe</th>
                            <th>Izin Lembur</th>
                            <th>K3</th>
                            <th>P2K3</th>
                            <th>Plant</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1;
                        foreach ($workPermits ?? [] as $workPermit) : ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= date('d M Y', strtotime($workPermit['created_at'])) ?></td>
                                <td><?= $workPermit['no_wp'] ?></td>
                                <td><?= $workPermit['nama_pekerjaan'] ?? '-' ?></td>

                                <td><?= $workPermit['lokasi_kerja'] ?></td>
                                <!-- tipe approval -->
                                <td>
                                    <?php
                                    $k3   = $workPermit['approved_k3_nama'];
                                    $p2k3 = $workPermit['approved_p2k3_nama'];

                                    if ($k3 && $p2k3) {
                                        echo '<span class="status-selesai"><i class="fas fa-check-circle" style="font-size:.6rem"></i> Approved K3 & P2K3</span>';
                                    } elseif ($k3) {
                                        echo '<span class="status-proses"><i class="fas fa-clock" style="font-size:.6rem"></i> Approved K3</span>';
                                    } elseif ($p2k3) {
                                        echo '<span class="status-proses"><i class="fas fa-clock" style="font-size:.6rem"></i> Approved P2K3</span>';
                                    } else {
                                        echo '<span class="status-proses"><i class="fas fa-clock" style="font-size:.6rem"></i> Waiting</span>';
                                    }
                                    ?>
                                </td>

                                <!-- izin lembur -->
                                <td>
                                    <?php if (!empty($workPermit['lembur_id'])) : ?>
                                        <span class="status-selesai">
                                            <i class="fas fa-check-circle" style="font-size:.6rem"></i>
                                            Ya
                                        </span>
                                    <?php else : ?>
                                        <span class="status-proses">
                                            <i class="fas fa-clock" style="font-size:.6rem"></i>
                                            Tidak
                                        </span>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <?php if (!empty($workPermit['approved_k3_nama'])) : ?>
                                        <span class="status-selesai">
                                            <i class="fas fa-check-circle" style="font-size:.6rem"></i>
                                            <?= $workPermit['approved_k3_nama'] ?>
                                        </span>
                                    <?php else : ?>
                                        <span class="status-proses">
                                            <i class="fas fa-clock" style="font-size:.6rem"></i>
                                            Waiting</span>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <?php if (!empty($workPermit['approved_p2k3_nama'])) : ?>
                                        <span class="status-selesai">
                                            <i class="fas fa-check-circle" style="font-size:.6rem"></i>
                                            <?= $workPermit['approved_p2k3_nama'] ?>
                                        </span>
                                    <?php else : ?>
                                        <span class="status-proses">
                                            <i class="fas fa-clock" style="font-size:.6rem"></i>
                                            Waiting</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= $workPermit['nama_plant'] ?? '-' ?></td>

                                <td>
                                    <a href="<?= site_url('approvalk3/preview/' . $workPermit['id']) ?>"
                                        target="_blank"
                                        class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye"></i> Preview
                                    </a>
                                    <button class="btn btn-sm btn-primary"
                                        data-toggle="modal"
                                        data-target="#accModal"
                                        data-id="<?= $workPermit['id'] ?>"
                                        data-no_wp="<?= $workPermit['no_wp'] ?>">
                                        Acc
                                    </button>
                                    <button class="btn btn-sm btn-warning"
                                        data-toggle="modal"
                                        data-target="#rejectModal"
                                        data-id="<?= $workPermit['id'] ?>"
                                        data-no_wp="<?= $workPermit['no_wp'] ?>">
                                        Reject
                                    </button>
                                    <button class="btn btn-sm btn-danger"
                                        data-toggle="modal"
                                        data-target="#deleteModal"
                                        data-id="<?= $workPermit['id'] ?>"
                                        data-no_wp="<?= $workPermit['no_wp'] ?>">
                                        Hapus
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<!-- modal: acc -->
<div class="modal fade" id="accModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border:none;border-radius:16px;overflow:hidden">
            <div class="modal-body text-center p-4">
                <div style="width:64px;height:64px;background:#e8f5e9;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 16px">
                    <i class="fas fa-check" style="color:#388e3c;font-size:1.4rem"></i>
                </div>
                <h5 style="font-weight:700;color:#212121">Setujui Work Permit??</h5>
                <p style="color:#757575;font-size:.875rem" id="accInfo"></p>
                <div class="d-flex justify-content-center mt-3" style="gap:10px">

                    <form id="approveForm" method="post">
                        <?= csrf_field() ?>
                        <div class="d-flex justify-content-center mt-3" style="gap:10px">
                            <button type="button" class="btn btn-light" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-success">Setujui</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- modal: reject -->
<div class="modal fade" id="rejectModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border:none;border-radius:16px;overflow:hidden">
            <div class="modal-body text-center p-4">
                <div style="width:64px;height:64px;background:#fce4ec;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 16px">
                    <i class="fa fa-times" style="color:#c62828;font-size:1.4rem"></i>
                </div>
                <h5 style="font-weight:700;color:#212121">Tolak Work Permit? </h5>
                <p style="color:#757575;font-size:.875rem" id="rejectInfo"></p>
                <div class="d-flex justify-content-center mt-3" style="gap:10px">
                    <button type="button" class="btn btn-light" style="border-radius:10px;padding:8px 24px" data-dismiss="modal">Batal</button>
                    <a id="confirmRejectBtn" href="#" class="btn btn-danger" style="border-radius:10px;padding:8px 24px">Tolak</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- modal: delete -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border:none;border-radius:16px;overflow:hidden">
            <div class="modal-body text-center p-4">
                <div style="width:64px;height:64px;background:#fce4ec;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 16px">
                    <i class="fas fa-trash" style="color:#c62828;font-size:1.4rem"></i>
                </div>
                <h5 style="font-weight:700;color:#212121">Hapus Work Permit? </h5>
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

        var table = $('#approvalk3Table').DataTable({
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
                    targets: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                },
                {
                    width: '0px',
                    targets: 0
                }
            ]
        });

        // Filter plant (FIX INDEX)
        $('#filterPlant').on('change', function() {
            table.column(9).search($(this).val()).draw();
        });



        // acc modal
        $(document).ready(function() {
            $('#accModal').on('show.bs.modal', function(e) {
                var btn = $(e.relatedTarget);
                var id = btn.data('id');
                var no_wp = btn.data('no_wp');

                $('#accInfo').text(
                    'Laporan work permit "' + no_wp + '" akan disetujui?'
                );

                $('#approveForm').attr(
                    'action',
                    '<?= base_url("approval-k3/approve/") ?>' + id
                );
            });
        });

        // reject modal
        $(document).ready(function() {
            $('#rejectModal').on('show.bs.modal', function(e) {
                var btn = $(e.relatedTarget);
                var id = btn.data('id');
                var no_wp = btn.data('no_wp');


                $('#rejectInfo').text('Laporan work permit "' + no_wp + '" akan ditolak?');
                $('#confirmApproveBtn').attr('href', '<?= base_url("patrol/delete/") ?>' + id);
            });
        });

        // Delete modal
        $(document).ready(function() {
            $('#deleteModal').on('show.bs.modal', function(e) {
                var btn = $(e.relatedTarget);
                var id = btn.data('id');
                var no_wp = btn.data('no_wp');


                $('#deleteInfo').text('Laporan work permit "' + no_wp + '" akan dihapus permanen?');
                $('#confirmDeleteBtn').attr('href', '<?= base_url("patrol/delete/") ?>' + id);
            });
        });



    });
</script>
<?php $this->endSection(); ?>