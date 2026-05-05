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
                    Data Approval P2K3 Work Permit Request
                </span>
            </h1>
            <p class="mb-0">
                Data approval k3
            </p>
        </div>
    </div>

    <!-- Table Card -->
    <div class="card card-main">
        <div class="card-body">
            <div class="table-wrapper table-responsive">
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

                <table id="approvalp2k3Table" class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tanggal</th>
                            <th>No WP/JSA</th>
                            <th>Identitas Pengaju</th>
                            <th>Nama Pekerjaan</th>
                            <th>Lokasi</th>
                            <th>Status</th>
                            <th>Lembur</th>
                            <th>K3</th>
                            <th>P2K3</th>

                            <?php if (in_groups('administrator')) : ?>
                                <th>Plant</th>
                            <?php endif; ?>
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
                                <td><?= $workPermit['nama_pengaju'] ?></td>
                                <td><?= $workPermit['nama_pekerjaan'] ?? '-' ?></td>

                                <td><?= $workPermit['lokasi_kerja'] ?></td>
                                <!-- status approval -->
                                <td>
                                    <?php
                                    $status = $workPermit['status_approval'];

                                    switch ($status) {
                                        case 'approve_by_p2k3':
                                            echo '<span class="text-success">Approved P2K3</span>';
                                            break;

                                        case 'approve_by_k3':
                                            echo '<span class="text-success">Approved K3</span>';
                                            break;

                                        case 'reject_by_k3':
                                            echo '<span class="text-danger">Rejected K3</span>';
                                            break;
                                        case 'reject_by_p2k3':
                                            echo '<span class="text-danger">Rejected P2K3</span>';
                                            break;

                                        case 'pending':
                                        default:
                                            echo '<span class="text-warning">Pending</span>';
                                            break;
                                    }
                                    ?>
                                </td>

                                <!-- izin lembur -->
                                <td>
                                    <?php if (!empty($workPermit['lembur_id'])) : ?>
                                        Ya
                                        </span>
                                    <?php else : ?>
                                        Tidak
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <?= $workPermit['approved_k3_nama'] ?>
                                </td>

                                <td>
                                    <?php if (!empty($workPermit['approved_p2k3_nama'])) : ?>

                                        <?= $workPermit['approved_p2k3_nama'] ?>
                                    <?php else : ?>
                                        Menunggu P2K3
                                    <?php endif; ?>
                                </td>

                                <?php if (in_groups('administrator')) : ?>
                                    <td> <span style="background:#e8eaf6;color:#3949ab;border-radius:8px;padding:3px 8px;font-size:.72rem;font-weight:600;white-space:nowrap">
                                            <?= ucwords(strtolower($workPermit['nama_plant'])) ?>
                                        </span>
                                    </td>
                                <?php endif; ?>

                                <td>
                                    <a href="<?= site_url('approvalk3/preview/' . $workPermit['id']) ?>"
                                        target="_blank"
                                        class="btn btn-sm btn-success">
                                        Preview
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
                                        Rej
                                    </button>

                                    <?php if (has_permission('manage-data')) : ?>
                                        <button class="btn btn-sm btn-danger"
                                            data-toggle="modal"
                                            data-target="#deleteModal"
                                            data-id="<?= $workPermit['id'] ?>"
                                            data-no_wp="<?= $workPermit['no_wp'] ?>">
                                            Hapus
                                        </button>
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
                <div class="d-flex justify-content-center mt-3">
                    <form id="approveForm" method="post" style="width: 100%;">
                        <?= csrf_field() ?>
                        <div class="d-flex justify-content-center" style="gap:10px">
                            <button type="button" class="btn btn-light" style="border-radius:10px;padding:8px 24px" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-success" style="border-radius:10px;padding:8px 24px">Setujui</button>
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
            <form id="rejectForm" method="post">
                <?= csrf_field() ?> <div class="modal-body text-center p-4">
                    <div style="width:64px;height:64px;background:#fce4ec;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 16px">
                        <i class="fa fa-times" style="color:#c62828;font-size:1.4rem"></i>
                    </div>
                    <h5 style="font-weight:700;color:#212121">Tolak Work Permit?</h5>
                    <p style="color:#757575;font-size:.875rem" id="rejectInfo"></p>

                    <div class="form-group text-left mt-3">
                        <label style="font-size: .875rem; font-weight: 600; color: #424242;">Alasan Penolakan</label>
                        <textarea name="keterangan_ditolak" class="form-control" rows="3" placeholder="Masukkan alasan penolakan..." style="border-radius:10px; font-size: .875rem;" required></textarea>
                    </div>

                    <div class="d-flex justify-content-center mt-4" style="gap:10px">
                        <button type="button" class="btn btn-light" style="border-radius:10px;padding:8px 24px" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger" style="border-radius:10px;padding:8px 24px">Konfirmasi Tolak</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- modal: delete -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border:none;border-radius:16px;overflow:hidden">
            <form id="deleteForm" method="post">
                <?= csrf_field() ?>
                <div class="modal-body text-center p-4">
                    <div style="width:64px;height:64px;background:#fce4ec;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 16px">
                        <i class="fas fa-trash" style="color:#c62828;font-size:1.4rem"></i>
                    </div>
                    <h5 style="font-weight:700;color:#212121">Hapus Work Permit?</h5>
                    <p style="color:#757575;font-size:.875rem" id="deleteInfo"></p>
                    <div class="d-flex justify-content-center mt-3" style="gap:10px">
                        <button type="button" class="btn btn-light" style="border-radius:10px;padding:8px 24px" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger" style="border-radius:10px;padding:8px 24px">Hapus</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $this->endSection(); ?>


<?php $this->section('scripts'); ?>
<script>
    $(document).ready(function() {

        var table = $('#approvalp2k3Table').DataTable({
            pageLength: 10,
            lengthMenu: [10, 25, 50],
            autoWidth: false,
            scrollX: true,
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
            table.column(10).search($(this).val()).draw();
        });



        // acc modal
        $(document).ready(function() {
            $('#accModal').on('show.bs.modal', function(e) {
                var btn = $(e.relatedTarget);
                var id = btn.data('id');
                var no_wp = btn.data('no_wp');

                $('#accInfo').html(
                    'Laporan work permit <strong>' + no_wp + '</strong> akan disetujui?'
                );

                // Pastikan URL memiliki slash di akhir sebelum ID
                var actionUrl = "<?= base_url('approval-p2k3/approve') ?>/" + id;
                $('#approveForm').attr('action', actionUrl);
            });
        });

        // reject modal
        $(document).ready(function() {
            $('#rejectModal').on('show.bs.modal', function(e) {
                var btn = $(e.relatedTarget);
                var id = btn.data('id');
                var no_wp = btn.data('no_wp');

                $('#rejectInfo').text('Laporan work permit "' + no_wp + '" akan ditolak?');

                $('#rejectForm').attr('action', '<?= base_url('approval-p2k3/reject') ?>/' + id);
            });
        });

        // Delete modal
        $(document).ready(function() {
            $('#deleteModal').on('show.bs.modal', function(e) {
                var btn = $(e.relatedTarget);
                var id = btn.data('id');
                var no_wp = btn.data('no_wp');

                $('#deleteInfo').text('Laporan work permit "' + no_wp + '" akan dihapus permanen?');

                $('#deleteForm').attr('action', '<?= base_url("approval-p2k3/delete") ?>/' + id);
            });
        });
    });
</script>
<?php $this->endSection(); ?>