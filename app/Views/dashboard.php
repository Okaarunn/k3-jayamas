<?= $this->extend('templates/index'); ?>

<?php $this->section('styles'); ?>
<style>
    /* ── Page header ── */
    .dash-header {
        background: #283593;
        border-radius: 16px;
        padding: 24px 32px;
        margin-bottom: 28px;
        box-shadow: 0 8px 32px rgba(40, 53, 147, 0.18);
    }

    .dash-header h1 {
        color: #fff;
        font-size: 1.4rem;
        font-weight: 700;
        margin: 0;
    }

    .dash-header p {
        color: rgba(255, 255, 255, .65);
        font-size: .85rem;
        margin: 4px 0 0;
    }

    /* ── Stat cards ── */
    .stat-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 16px;
        margin-bottom: 24px;
    }

    .stat-card {
        background: #fff;
        border-radius: 14px;
        padding: 20px 22px;
        box-shadow: 0 2px 16px rgba(0, 0, 0, 0.06);
        display: flex;
        align-items: center;
        gap: 16px;
        transition: transform .15s, box-shadow .15s;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 24px rgba(0, 0, 0, 0.1);
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        flex-shrink: 0;
    }

    .icon-induksi {
        background: #e8eaf6;
        color: #3949ab;
    }

    .icon-patrol {
        background: #e8f5e9;
        color: #388e3c;
    }

    .icon-selesai {
        background: #e0f2f1;
        color: #00695c;
    }

    .icon-proses {
        background: #fff8e1;
        color: #f57c00;
    }

    .icon-users {
        background: #fce4ec;
        color: #c62828;
    }

    .stat-info .stat-value {
        font-size: 1.75rem;
        font-weight: 800;
        line-height: 1;
        color: #212121;
    }

    .stat-info .stat-label {
        font-size: .72rem;
        color: #9e9e9e;
        text-transform: uppercase;
        letter-spacing: .7px;
        margin-top: 4px;
    }

    /* ── Chart cards ── */
    .chart-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 24px;
    }

    @media (max-width: 768px) {
        .chart-row {
            grid-template-columns: 1fr;
        }
    }

    .chart-card {
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 2px 16px rgba(0, 0, 0, 0.06);
        overflow: hidden;
    }

    .chart-card-header {
        padding: 16px 20px 14px;
        border-bottom: 1px solid #f0f0f0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .chart-card-header .ch-icon {
        width: 30px;
        height: 30px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: .8rem;
    }

    .ch-icon-blue {
        background: #e8eaf6;
        color: #3949ab;
    }

    .ch-icon-green {
        background: #e8f5e9;
        color: #388e3c;
    }

    .chart-card-header h6 {
        margin: 0;
        font-weight: 700;
        color: #212121;
        font-size: .9rem;
    }

    .chart-card-header p {
        margin: 0;
        font-size: .72rem;
        color: #9e9e9e;
    }

    .chart-card-body {
        padding: 16px 20px 20px;
    }

    /* ── Activity table ── */
    .activity-card {
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 2px 16px rgba(0, 0, 0, 0.06);
        overflow: hidden;
        margin-bottom: 24px;
    }

    .activity-header {
        padding: 16px 20px 14px;
        border-bottom: 1px solid #f0f0f0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .activity-header .ch-icon {
        width: 30px;
        height: 30px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: .8rem;
    }

    .ch-icon-purple {
        background: #f3e5f5;
        color: #7b1fa2;
    }

    .activity-header h6 {
        margin: 0;
        font-weight: 700;
        color: #212121;
        font-size: .9rem;
    }

    .activity-table {
        width: 100%;
    }

    .activity-table thead th {
        background: #f8f9ff;
        color: #5c6bc0;
        font-size: .67rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .8px;
        padding: 10px 16px;
        border: none;
    }

    .activity-table tbody tr {
        border-bottom: 1px solid #f5f5f5;
        transition: background .15s;
    }

    .activity-table tbody tr:hover {
        background: #f9f4ff;
    }

    .activity-table tbody td {
        padding: 10px 16px;
        border: none;
        font-size: .82rem;
        color: #424242;
        vertical-align: middle;
    }

    .type-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: .68rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .5px;
        white-space: nowrap;
    }

    .type-induksi {
        background: #e8eaf6;
        color: #3949ab;
    }

    .type-patrol {
        background: #e8f5e9;
        color: #388e3c;
    }

    .plant-badge {
        display: inline-block;
        background: #f3e5f5;
        color: #7b1fa2;
        border-radius: 8px;
        padding: 2px 8px;
        font-size: .7rem;
        font-weight: 600;
    }
</style>
<?php $this->endSection(); ?>


<?php $this->section('page-content'); ?>
<div class="container-fluid pb-4">

    <?= $this->include('components/alert') ?>

    <!-- Header -->
    <div class="dash-header">
        <h1><i class="fas fa-tachometer-alt mr-2"></i> Dashboard K3</h1>
        <p>Ringkasan data Keselamatan dan Kesehatan Kerja — <?= date('d F Y') ?></p>
    </div>

    <!-- Stat Cards -->
    <div class="stat-cards">

        <div class="stat-card">
            <div class="stat-icon icon-induksi">
                <i class="fas fa-user-check"></i>
            </div>
            <div class="stat-info">
                <div class="stat-value"><?= number_format($totalInduksi) ?></div>
                <div class="stat-label">Sesi Induksi</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon icon-patrol">
                <i class="fas fa-route"></i>
            </div>
            <div class="stat-info">
                <div class="stat-value"><?= number_format($totalPatrol) ?></div>
                <div class="stat-label">Total Patrol</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon icon-selesai">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-info">
                <div class="stat-value"><?= number_format($totalSelesai) ?></div>
                <div class="stat-label">Patrol Selesai</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon icon-proses">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-info">
                <div class="stat-value"><?= number_format($totalBelumSelesai) ?></div>
                <div class="stat-label">Belum Selesai</div>
            </div>
        </div>

        <?php if (has_permission('manage-users') && $totalUsers !== null) : ?>
            <div class="stat-card">
                <div class="stat-icon icon-users">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-value"><?= number_format($totalUsers) ?></div>
                    <div class="stat-label">Pengguna</div>
                </div>
            </div>
        <?php endif; ?>

    </div>

    <!-- Charts -->
    <div class="chart-row">

        <!-- Grafik Induksi -->
        <div class="chart-card">
            <div class="chart-card-header">
                <div class="ch-icon ch-icon-blue"><i class="fas fa-user-check"></i></div>
                <div>
                    <h6>Tren Peserta Induksi</h6>
                    <p>Jumlah peserta per bulan (12 bulan terakhir)</p>
                </div>
            </div>
            <div class="chart-card-body">
                <canvas id="chartInduksi" height="220"></canvas>
            </div>
        </div>

        <!-- Grafik Patrol -->
        <div class="chart-card">
            <div class="chart-card-header">
                <div class="ch-icon ch-icon-green"><i class="fas fa-route"></i></div>
                <div>
                    <h6>Tren Laporan Patrol</h6>
                    <p>Jumlah laporan patrol per bulan (12 bulan terakhir)</p>
                </div>
            </div>
            <div class="chart-card-body">
                <canvas id="chartPatrol" height="220"></canvas>
            </div>
        </div>

    </div>

    <!-- Aktivitas Terbaru -->
    <div class="activity-card">
        <div class="activity-header">
            <div class="ch-icon ch-icon-purple"><i class="fas fa-history"></i></div>
            <h6>Aktivitas Terbaru</h6>
        </div>
        <div style="overflow-x:auto">
            <table class="activity-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tipe</th>
                        <th>Tanggal</th>
                        <th>Deskripsi</th>
                        <th>Dicatat Oleh</th>
                        <th>Plant</th>
                        <th>Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($activities)) : ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4" style="font-size:.85rem">
                                Belum ada aktivitas
                            </td>
                        </tr>
                    <?php else : ?>
                        <?php $i = 1;
                        foreach ($activities as $act) : ?>
                            <tr>
                                <td class="text-muted" style="font-size:.75rem"><?= $i++ ?></td>
                                <td>
                                    <span class="type-badge type-<?= $act->tipe ?>">
                                        <i class="fas <?= $act->tipe === 'induksi' ? 'fa-user-check' : 'fa-route' ?>" style="font-size:.6rem"></i>
                                        <?= ucfirst($act->tipe) ?>
                                    </span>
                                </td>
                                <td style="white-space:nowrap">
                                    <?= date('d M Y', strtotime($act->tanggal)) ?>
                                </td>
                                <td style="max-width:240px">
                                    <div style="overflow:hidden;display:-webkit-box;-webkit-line-clamp:1;-webkit-box-orient:vertical;">
                                        <?= esc($act->deskripsi ?? '-') ?>
                                    </div>
                                </td>
                                <td style="font-size:.78rem;color:#616161">
                                    <?= esc($act->username ?? '-') ?>
                                </td>
                                <td>
                                    <?php if (!empty($act->nama_plant)) : ?>
                                        <span class="plant-badge">
                                            <?= esc(ucwords(strtolower($act->nama_plant))) ?>
                                        </span>
                                    <?php else : ?>
                                        <span style="color:#bdbdbd">—</span>
                                    <?php endif; ?>
                                </td>
                                <td style="font-size:.75rem;color:#9e9e9e;white-space:nowrap">
                                    <?= date('d M, H:i', strtotime($act->created_at)) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
<?php $this->endSection(); ?>


<?php $this->section('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    $(document).ready(function() {

        const induksiLabels = <?= $induksiLabels ?>;
        const induksiValues = <?= $induksiValues ?>;
        const patrolLabels = <?= $patrolLabels ?>;
        const patrolValues = <?= $patrolValues ?>;

        // Chart defaults
        Chart.defaults.font.family = "'Nunito', sans-serif";
        Chart.defaults.font.size = 11;
        Chart.defaults.color = '#9e9e9e';

        // Grafik Induksi
        new Chart(document.getElementById('chartInduksi'), {
            type: 'bar',
            data: {
                labels: induksiLabels,
                datasets: [{
                    label: 'Jumlah Peserta',
                    data: induksiValues,
                    backgroundColor: 'rgba(57, 73, 171, 0.15)',
                    borderColor: '#3949ab',
                    borderWidth: 2,
                    borderRadius: 6,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: ctx => ' ' + ctx.parsed.y + ' peserta'
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            maxRotation: 45
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#f5f5f5'
                        },
                        ticks: {
                            stepSize: 1,
                            precision: 0
                        }
                    }
                }
            }
        });

        // Grafik Patrol
        new Chart(document.getElementById('chartPatrol'), {
            type: 'bar',
            data: {
                labels: patrolLabels,
                datasets: [{
                    label: 'Jumlah Patrol',
                    data: patrolValues,
                    backgroundColor: 'rgba(56, 142, 60, 0.15)',
                    borderColor: '#388e3c',
                    borderWidth: 2,
                    borderRadius: 6,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: ctx => ' ' + ctx.parsed.y + ' laporan'
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            maxRotation: 45
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#f5f5f5'
                        },
                        ticks: {
                            stepSize: 1,
                            precision: 0
                        }
                    }
                }
            }
        });

    });
</script>
<?php $this->endSection(); ?>