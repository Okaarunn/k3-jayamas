<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Work Permit Request - K3 Management System</title>

    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url(); ?>/css/sb-admin-2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?= base_url(); ?>/css/style.css" />
    <link rel="icon" type="image/x-icon" href="/logo.png">

    <link rel="stylesheet" href="<?= base_url(); ?>/css/work-permit.css" />

</head>

<body>
    <div class="page-wrapper">

        <?= $this->include('components/alert') ?>


        <!-- Header -->
        <div class="create-header">
            <div>
                <h1><i class="fas fa-file-signature mr-2"></i> Pengajuan Izin Kerja (Work Permit)</h1>
                <p>Lengkapi formulir berikut untuk mengajukan izin kerja beserta analisis keselamatan</p>
            </div>
        </div>

        <!-- Server-side errors -->
        <?php if (!empty($errors)) : ?>
            <div style="background:#fce4ec;color:#c62828;border-radius:12px;padding:14px 18px;margin-bottom:20px">
                <strong><i class="fas fa-exclamation-circle mr-1"></i> Terdapat kesalahan:</strong>
                <ul style="margin:8px 0 0;padding-left:20px">
                    <?php foreach ($errors as $e) : ?>
                        <li style="font-size:.875rem"><?= $e ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <!-- Card -->
        <div class="form-card">
            <div class="card-header">
                <div class="section-icon"><i class="fas fa-file-alt"></i></div>
                <h6>Work Permit Request</h6>
            </div>

            <!-- Sticky tab bar -->
            <div class="tabs-sticky">
                <div class="wp-progress">
                    <div class="wp-progress-fill" id="progressBar" style="width:25%"></div>
                </div>
                <ul class="nav nav-tabs-k3" id="workPermitTabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="tab-vendor-link" data-tab-index="0" role="tab">
                            <span class="tab-num">1</span>
                            <span class="tab-label d-none d-sm-inline">Identitas Pengisi</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link tab-locked" id="tab-checklist-link" data-tab-index="1" role="tab">
                            <span class="tab-num">2</span>
                            <span class="tab-label d-none d-sm-inline">Checklist WP</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link tab-locked" id="tab-jsa-link" data-tab-index="2" role="tab">
                            <span class="tab-num">3</span>
                            <span class="tab-label d-none d-sm-inline">Job Safety Analyst</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link tab-locked" id="tab-lembur-link" data-tab-index="3" role="tab">
                            <span class="tab-num">4</span>
                            <span class="tab-label d-none d-sm-inline">Lembur</span>
                            <span class="d-none d-md-inline" style="font-size:.65rem;color:var(--text-muted);font-weight:400">(jika ada)</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Validation banner -->
            <div class="validation-banner mt-3" id="validationBanner">
                <i class="fas fa-exclamation-circle"></i>
                <span id="validationMsg">Mohon lengkapi semua field yang wajib diisi sebelum melanjutkan.</span>
            </div>

            <!-- Form component -->
            <?= $this->include('components/form-work-permit') ?>

        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('js/sb-admin-2.min.js') ?>"></script>
    <script src="<?= base_url('js/work-permit.js') ?>"></script>

</body>

</html>