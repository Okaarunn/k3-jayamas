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

    <style>
        /* ── Root ── */
        :root {
            --blue-deep: #1a237e;
            --blue-mid: #283593;
            --blue-main: #3949ab;
            --blue-light: #e8eaf6;
            --blue-soft: #f5f6ff;
            --border: #e0e3f0;
            --text-main: #212121;
            --text-sub: #616161;
            --text-muted: #9e9e9e;
            --success: #388e3c;
            --warning: #f57c00;
            --danger: #c62828;
            --radius: 12px;
        }

        body {
            font-family: 'Nunito', sans-serif;
            background: #f4f6f9;
        }

        /* ── Layout ── */
        .page-wrapper {
            max-width: 960px;
            margin: 0 auto;
            padding: 24px 16px 80px;
        }

        /* ── Page header ── */
        .create-header {
            background: linear-gradient(135deg, var(--blue-deep), var(--blue-mid), var(--blue-main));
            border-radius: 16px;
            padding: 22px 28px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 16px;
            box-shadow: 0 8px 28px rgba(26, 35, 126, .22);
        }

        .back-btn {
            width: 38px;
            height: 38px;
            background: rgba(255, 255, 255, .15);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            text-decoration: none;
            transition: background .2s;
            flex-shrink: 0;
        }

        .back-btn:hover {
            background: rgba(255, 255, 255, .25);
            color: #fff;
        }

        .create-header h1 {
            color: #fff;
            font-size: 1.3rem;
            font-weight: 800;
            margin: 0;
        }

        .create-header p {
            color: rgba(255, 255, 255, .65);
            font-size: .8rem;
            margin: 3px 0 0;
        }

        /* ── Card ── */
        .form-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 2px 20px rgba(0, 0, 0, .07);
            overflow: hidden;
        }

        .card-header {
            background: #f8f9ff;
            border-bottom: 1px solid var(--border);
            padding: 16px 24px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-icon {
            width: 30px;
            height: 30px;
            background: linear-gradient(135deg, var(--blue-mid), var(--blue-main));
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: .8rem;
        }

        .card-header h6 {
            margin: 0;
            font-weight: 700;
            color: var(--blue-deep);
            font-size: .9rem;
        }

        .card-body {
            padding: 0;
        }

        /* ── Sticky progress tab bar ── */
        .tabs-sticky {
            position: sticky;
            top: 0;
            z-index: 100;
            background: #fff;
            border-bottom: 2px solid var(--border);
        }

        .nav-tabs-k3 {
            border: none !important;
            padding: 0 20px;
            gap: 0;
            flex-wrap: nowrap;
            overflow-x: auto;
        }

        .nav-tabs-k3::-webkit-scrollbar {
            display: none;
        }

        .nav-tabs-k3 .nav-link {
            color: var(--text-muted);
            border: none !important;
            border-bottom: 3px solid transparent !important;
            padding: 14px 18px;
            font-weight: 700;
            font-size: .82rem;
            transition: all .25s;
            display: flex;
            align-items: center;
            gap: 8px;
            white-space: nowrap;
            border-radius: 0 !important;
            cursor: pointer;
        }

        .nav-tabs-k3 .nav-link:hover {
            color: var(--blue-main);
        }

        .nav-tabs-k3 .nav-link.active {
            color: var(--blue-main) !important;
            border-bottom-color: var(--blue-main) !important;
            background: transparent !important;
        }

        .nav-tabs-k3 .nav-link.done {
            color: var(--success) !important;
        }

        .nav-tabs-k3 .nav-link.tab-locked {
            opacity: .4;
            pointer-events: none;
            cursor: not-allowed;
        }

        .tab-num {
            width: 22px;
            height: 22px;
            border-radius: 50%;
            background: #f0f0f0;
            color: var(--text-muted);
            font-size: .7rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            flex-shrink: 0;
            transition: all .25s;
        }

        .nav-link.active .tab-num {
            background: var(--blue-main);
            color: #fff;
        }

        .nav-link.done .tab-num {
            background: var(--success);
            color: #fff;
        }

        /* ── Progress bar (thin) ── */
        .wp-progress {
            height: 3px;
            background: var(--border);
        }

        .wp-progress-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--blue-mid), var(--blue-main));
            transition: width .4s ease;
        }

        /* ── Tab content ── */
        .tab-content {
            padding: 0;
        }

        .tab-pane {
            padding: 28px 28px 8px;
        }

        /* ── Section title ── */
        .section-title {
            font-size: .7rem;
            font-weight: 800;
            color: var(--blue-main);
            text-transform: uppercase;
            letter-spacing: .8px;
            margin: 0 0 16px;
            padding-bottom: 8px;
            border-bottom: 1px solid var(--blue-light);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* ── Form controls ── */
        .form-label-k3 {
            font-weight: 700;
            color: #424242;
            margin-bottom: 6px;
            font-size: .82rem;
            display: block;
        }

        .form-label-k3 .req {
            color: var(--danger);
            margin-left: 2px;
        }

        .form-control-k3 {
            border: 1.5px solid var(--border);
            border-radius: 10px;
            padding: 9px 14px;
            font-size: .875rem;
            color: var(--text-main);
            width: 100%;
            transition: border .2s, box-shadow .2s;
            background: #fff;
            font-family: 'Nunito', sans-serif;
        }

        .form-control-k3:focus {
            border-color: var(--blue-main);
            box-shadow: 0 0 0 3px rgba(57, 73, 171, .1);
            outline: none;
        }

        .form-control-k3.is-invalid {
            border-color: var(--danger) !important;
        }

        .form-control-k3.is-valid {
            border-color: var(--success) !important;
        }

        select.form-control-k3 {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%239e9e9e' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 14px center;
            padding-right: 36px;
            cursor: pointer;
        }

        .invalid-feedback-k3 {
            color: var(--danger);
            font-size: .75rem;
            margin-top: 4px;
            display: none;
        }

        .form-control-k3.is-invalid~.invalid-feedback-k3 {
            display: block;
        }

        /* ── Checklist grid ── */
        .checklist-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 10px;
        }

        .checklist-item {
            border: 1.5px solid var(--border);
            border-radius: 10px;
            padding: 12px 14px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            background: #fff;
            transition: border .15s;
        }

        .checklist-item:hover {
            border-color: #c5cae9;
        }

        .checklist-label {
            font-size: .8rem;
            font-weight: 600;
            color: #424242;
            flex: 1;
        }

        .checklist-radios {
            display: flex;
            gap: 12px;
        }

        .checklist-radios label {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: .78rem;
            font-weight: 600;
            cursor: pointer;
            color: var(--text-sub);
        }

        .checklist-radios input[type="radio"] {
            width: 15px;
            height: 15px;
            accent-color: var(--blue-main);
            cursor: pointer;
        }

        /* ── JSA Tahap card ── */
        .tahap-card {
            border: 1.5px solid var(--border);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 16px;
            background: var(--blue-soft);
            transition: border .2s;
        }

        .tahap-card:hover {
            border-color: #c5cae9;
        }

        .tahap-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
        }

        .tahap-label {
            font-size: .72rem;
            font-weight: 800;
            color: var(--blue-main);
            text-transform: uppercase;
            letter-spacing: .5px;
            background: var(--blue-light);
            padding: 4px 10px;
            border-radius: 20px;
        }

        .btn-remove-tahap {
            background: #ffebee;
            color: var(--danger);
            border: 1.5px solid #ffcdd2;
            padding: 5px 12px;
            border-radius: 8px;
            font-size: .78rem;
            font-weight: 700;
            cursor: pointer;
            transition: all .15s;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .btn-remove-tahap:hover {
            background: #ffcdd2;
        }

        .btn-add-tahap {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 9px 18px;
            background: var(--blue-light);
            color: var(--blue-main);
            border: 1.5px dashed #c5cae9;
            border-radius: 10px;
            font-size: .8rem;
            font-weight: 700;
            cursor: pointer;
            transition: all .15s;
            margin-top: 4px;
        }

        .btn-add-tahap:hover {
            background: var(--blue-main);
            color: #fff;
            border-color: var(--blue-main);
        }

        /* ── Lembur toggle ── */
        .lembur-toggle-box {
            border: 1.5px solid #ffe082;
            border-radius: 12px;
            padding: 14px 18px;
            background: #fff8e1;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 0;
        }

        .lembur-toggle-label {
            font-size: .875rem;
            font-weight: 700;
            color: var(--warning);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .toggle-switch {
            position: relative;
            width: 44px;
            height: 24px;
            flex-shrink: 0;
        }

        .toggle-switch input {
            display: none;
        }

        .toggle-slider {
            position: absolute;
            inset: 0;
            background: #e0e0e0;
            border-radius: 12px;
            cursor: pointer;
            transition: background .2s;
        }

        .toggle-slider:before {
            content: '';
            position: absolute;
            left: 3px;
            top: 3px;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: #fff;
            transition: transform .2s;
            box-shadow: 0 1px 3px rgba(0, 0, 0, .2);
        }

        .toggle-switch input:checked~.toggle-slider {
            background: var(--warning);
        }

        .toggle-switch input:checked~.toggle-slider:before {
            transform: translateX(20px);
        }

        .lembur-info-box {
            display: none;
            margin-top: 12px;
            padding: 12px 16px;
            background: #fffde7;
            border: 1.5px solid #ffe082;
            border-radius: 10px;
            font-size: .8rem;
            color: var(--warning);
            font-weight: 600;
        }

        .lembur-info-box.show {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* ── Bottom nav bar ── */
        .tab-nav-bar {
            position: sticky;
            bottom: 0;
            background: #fff;
            border-top: 1px solid var(--border);
            padding: 16px 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            z-index: 99;
        }

        .step-indicator {
            font-size: .75rem;
            color: var(--text-muted);
            font-weight: 600;
        }

        .btn-nav {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 9px 20px;
            border-radius: 10px;
            font-size: .82rem;
            font-weight: 700;
            cursor: pointer;
            transition: all .2s;
            border: none;
            text-decoration: none;
        }

        .btn-nav-prev {
            background: #fff;
            color: #616161;
            border: 1.5px solid var(--border) !important;
        }

        .btn-nav-prev:hover {
            border-color: var(--blue-main) !important;
            color: var(--blue-main);
        }

        .btn-nav-next {
            background: linear-gradient(135deg, var(--blue-mid), var(--blue-main));
            color: #fff;
            box-shadow: 0 2px 10px rgba(57, 73, 171, .3);
        }

        .btn-nav-next:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 18px rgba(57, 73, 171, .4);
        }

        .btn-nav-submit {
            background: linear-gradient(135deg, #1b5e20, var(--success));
            color: #fff;
            box-shadow: 0 2px 10px rgba(56, 142, 60, .3);
        }

        .btn-nav-submit:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 18px rgba(56, 142, 60, .4);
        }

        /* ── Validation error banner ── */
        .validation-banner {
            display: none;
            background: #fce4ec;
            color: var(--danger);
            border-radius: 10px;
            padding: 10px 16px;
            margin: 0 28px 16px;
            font-size: .8rem;
            font-weight: 700;
            align-items: center;
            gap: 8px;
        }

        .validation-banner.show {
            display: flex;
        }

        @media (max-width: 576px) {
            .tab-pane {
                padding: 20px 16px 8px;
            }

            .tab-nav-bar {
                padding: 12px 16px;
            }

            .create-header {
                padding: 16px;
            }

            .create-header h1 {
                font-size: 1.1rem;
            }

            .checklist-grid {
                grid-template-columns: 1fr;
            }
        }

        /* ── Bottom Navigation Bar ── */
        .tab-nav-bar {
            position: sticky;
            bottom: 0;
            z-index: 90;
            background: rgba(255, 255, 255, 0.97);
            backdrop-filter: blur(10px);
            border-top: 1px solid var(--border);
            padding: 16px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            margin-top: 24px;
        }

        .tab-nav-info {
            display: flex;
            align-items: center;
        }

        .step-indicator {
            font-size: .85rem;
            font-weight: 700;
            color: var(--text-sub);
            background: var(--blue-soft);
            padding: 8px 14px;
            border-radius: 999px;
        }

        .tab-nav-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .btn-nav {
            border: none;
            border-radius: 12px;
            padding: 12px 22px;
            font-size: .9rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all .25s ease;
            cursor: pointer;
        }

        @media (max-width: 576px) {
            .tab-nav-bar {
                padding: 14px 16px;
                flex-direction: column;
                align-items: stretch;
            }

            .tab-nav-actions {
                width: 100%;
                justify-content: space-between;
            }

            .btn-nav {
                flex: 1;
                justify-content: center;
            }
        }
    </style>
</head>

<body>
    <div class="page-wrapper">

        <!-- Header -->
        <div class="create-header">
            <a href="<?= base_url('work-permit') ?>" class="back-btn">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1><i class="fas fa-file-signature mr-2"></i> Work Permit Request K3</h1>
                <p>Buat permintaan izin kerja dengan penilaian keselamatan kerja</p>
            </div>
        </div>

        <!-- Server-side errors -->
        <?php if (!empty($errors)) : ?>
            <div style="background:#fce4ec;color:#c62828;border-radius:12px;padding:14px 18px;margin-bottom:20px">
                <strong><i class="fas fa-exclamation-circle mr-1"></i> Terdapat kesalahan:</strong>
                <ul style="margin:8px 0 0;padding-left:20px">
                    <?php foreach ($errors as $e) : ?>
                        <li style="font-size:.875rem"><?= esc($e) ?></li>
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
            <div class="validation-banner" id="validationBanner">
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

    <script>
        // ═══════════════════════════════════════════════
        //  WORK PERMIT TAB CONTROLLER
        // ═══════════════════════════════════════════════
        (function() {
            'use strict';

            const TABS = ['tab-vendor', 'tab-checklist', 'tab-jsa', 'tab-lembur'];
            const TAB_LINKS = ['tab-vendor-link', 'tab-checklist-link', 'tab-jsa-link', 'tab-lembur-link'];
            const DAYS_ID = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

            let currentTab = 0; // active tab index (0-based)
            let adaLembur = false; // toggle state
            let tahapCount = 0; // JSA tahap counter

            // ── Init ──────────────────────────────────
            function init() {
                addTahapPekerjaan(); // first tahap
                bindEvents();
                renderNavButtons();
                updateProgressBar();
            }

            // ── Tab switching ─────────────────────────
            function switchTab(index, skipValidation) {
                if (index === 3 && !adaLembur) return; // lembur locked
                if (index > currentTab && !skipValidation) {
                    if (!validateTab(currentTab)) return;
                }

                // Deactivate current
                var curPane = document.getElementById(TABS[currentTab]);
                if (curPane) {
                    curPane.classList.remove('active', 'show');
                }
                var curLink = document.getElementById(TAB_LINKS[currentTab]);
                if (curLink) {
                    curLink.classList.remove('active');
                }

                // Mark previous as done
                if (index > currentTab) {
                    var doneLink = document.getElementById(TAB_LINKS[currentTab]);
                    if (doneLink) doneLink.classList.add('done');
                }

                currentTab = index;

                // Activate new
                var newPane = document.getElementById(TABS[currentTab]);
                if (newPane) {
                    newPane.classList.add('active', 'show');
                }
                var newLink = document.getElementById(TAB_LINKS[currentTab]);
                if (newLink) {
                    newLink.classList.remove('tab-locked');
                    newLink.classList.add('active');
                }

                hideBanner();
                renderNavButtons();
                updateProgressBar();
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            }

            // ── Validation ────────────────────────────
            function validateTab(index) {
                var pane = document.getElementById(TABS[index]);
                if (!pane) return true;

                var inputs = pane.querySelectorAll('input[required], select[required], textarea[required]');
                var valid = true;

                inputs.forEach(function(el) {
                    // Skip hidden elements
                    if (el.offsetParent === null) return;

                    var val = el.value.trim();
                    if (!val) {
                        el.classList.add('is-invalid');
                        valid = false;
                    } else {
                        el.classList.remove('is-invalid');
                        el.classList.add('is-valid');
                    }
                });

                // Radio groups validation
                var radioGroups = {};
                var radios = pane.querySelectorAll('input[type="radio"][required]');
                radios.forEach(function(r) {
                    if (r.offsetParent === null) return;
                    radioGroups[r.name] = radioGroups[r.name] || [];
                    radioGroups[r.name].push(r);
                });
                Object.keys(radioGroups).forEach(function(name) {
                    var group = radioGroups[name];
                    var checked = group.some(function(r) {
                        return r.checked;
                    });
                    if (!checked) {
                        group.forEach(function(r) {
                            r.classList.add('is-invalid');
                        });
                        valid = false;
                    } else {
                        group.forEach(function(r) {
                            r.classList.remove('is-invalid');
                        });
                    }
                });

                if (!valid) {
                    showBanner('Mohon lengkapi semua field yang wajib diisi sebelum melanjutkan.');
                }
                return valid;
            }

            function showBanner(msg) {
                var b = document.getElementById('validationBanner');
                document.getElementById('validationMsg').textContent = msg;
                b.classList.add('show');
            }

            function hideBanner() {
                document.getElementById('validationBanner').classList.remove('show');
            }

            // ── Render nav buttons ────────────────────
            function renderNavButtons() {
                const step = document.getElementById('stepIndicator');
                const prevBtn = document.getElementById('btnPrev');
                const nextArea = document.getElementById('btnNextArea');

                if (!nextArea) return;

                const effectiveTotal = adaLembur ? 4 : 3;
                const isFirst = currentTab === 0;
                const isLast = currentTab === (effectiveTotal - 1);

                if (step) {
                    step.textContent = `Langkah ${currentTab + 1} dari ${effectiveTotal}`;
                }

                if (prevBtn) {
                    prevBtn.style.display = isFirst ? 'none' : 'inline-flex';
                }

                let buttonHTML = '';

                if (isLast) {
                    buttonHTML = `
            <button type="submit" form="workPermitForm" class="btn-nav btn-nav-submit">
                <i class="fas fa-paper-plane"></i>
                Submit Work Permit
            </button>
        `;
                } else if (currentTab === 2 && adaLembur) {
                    buttonHTML = `
            <button type="button" class="btn-nav btn-nav-next" id="btnNext">
                <i class="fas fa-moon"></i>
                Continue ke Lembur
            </button>
        `;
                } else {
                    buttonHTML = `
            <button type="button" class="btn-nav btn-nav-next" id="btnNext">
                Selanjutnya
                <i class="fas fa-arrow-right"></i>
            </button>
        `;
                }

                nextArea.innerHTML = buttonHTML;

                const nextBtn = document.getElementById('btnNext');
                if (nextBtn) {
                    nextBtn.addEventListener('click', function() {
                        if (validateTab(currentTab)) {
                            switchTab(currentTab + 1, true);
                        }
                    });
                }
            }

            // ── Progress bar ──────────────────────────
            function updateProgressBar() {
                var total = adaLembur ? 4 : 3;
                var pct = ((currentTab + 1) / total) * 100;
                var bar = document.getElementById('progressBar');
                if (bar) bar.style.width = pct + '%';
            }

            // ── Lembur toggle ─────────────────────────
            function handleLemburToggle(checked) {
                adaLembur = checked;

                var tabLink = document.getElementById('tab-lembur-link');
                if (checked) {
                    tabLink.classList.remove('tab-locked');
                    tabLink.style.opacity = '';
                } else {
                    tabLink.classList.add('tab-locked');
                    tabLink.style.opacity = '';
                    // If currently on lembur tab, go back to JSA
                    if (currentTab === 3) switchTab(2, true);
                }

                var infoBox = document.getElementById('lemburInfoBox');
                if (infoBox) infoBox.classList.toggle('show', checked);

                renderNavButtons();
                updateProgressBar();
            }

            // ── JSA Tahap dynamic ─────────────────────
            function addTahapPekerjaan() {
                tahapCount++;
                var idx = tahapCount;
                var container = document.getElementById('tahapPekerjaanContainer');
                if (!container) return;

                var div = document.createElement('div');
                div.className = 'tahap-card';
                div.id = 'tahap-' + idx;
                div.innerHTML =
                    '<div class="tahap-header">' +
                    '<span class="tahap-label">Tahap ' + idx + '</span>' +
                    (idx > 1 ? '<button type="button" class="btn-remove-tahap" onclick="WP.removeTahap(' + idx + ')">' +
                        '<i class="fas fa-trash"></i> Hapus' +
                        '</button>' : '') +
                    '</div>' +
                    '<div class="row">' +
                    '<div class="col-12 mb-3">' +
                    '<label class="form-label-k3">Tahapan Pekerjaan <span class="req">*</span></label>' +
                    '<textarea name="tahapan_pekerjaan[]" class="form-control-k3" rows="2" ' +
                    'placeholder="Deskripsi tahapan pekerjaan..." required></textarea>' +
                    '</div>' +
                    '<div class="col-md-6 mb-3">' +
                    '<label class="form-label-k3">Potensi Bahaya <span class="req">*</span></label>' +
                    '<textarea name="potensi_bahaya[]" class="form-control-k3" rows="2" ' +
                    'placeholder="Sebutkan potensi bahaya..." required></textarea>' +
                    '</div>' +
                    '<div class="col-md-6 mb-3">' +
                    '<label class="form-label-k3">Pengendalian Risiko <span class="req">*</span></label>' +
                    '<textarea name="pengendalian_risiko[]" class="form-control-k3" rows="2" ' +
                    'placeholder="Tindakan pengendalian risiko..." required></textarea>' +
                    '</div>' +
                    '</div>';

                container.appendChild(div);
            }

            function removeTahap(idx) {
                var el = document.getElementById('tahap-' + idx);
                if (el) el.remove();
            }

            // ── Auto-fill hari dari tanggal lembur ────
            function handleTanggalLembur(val) {
                var hariInput = document.getElementById('hariLembur');
                if (!hariInput || !val) return;
                var d = new Date(val);
                hariInput.value = DAYS_ID[d.getDay()];
            }

            // ── Auto hitung durasi lembur ─────────────
            function calculateDurasi() {
                var mulai = document.querySelector('input[name="jam_mulai_lembur"]');
                var selesai = document.querySelector('input[name="jam_selesai_lembur"]');
                var durasi = document.querySelector('input[name="durasi_lembur"]');
                if (!mulai || !selesai || !durasi || !mulai.value || !selesai.value) return;

                var [jm, mm] = mulai.value.split(':').map(Number);
                var [js, ms] = selesai.value.split(':').map(Number);
                var diff = (js * 60 + ms) - (jm * 60 + mm);
                if (diff < 0) diff += 24 * 60;
                durasi.value = Math.round((diff / 60) * 2) / 2 || '';
            }

            // ── Bind events ───────────────────────────
            function bindEvents() {
                // Tab header clicks
                document.querySelectorAll('.nav-tabs-k3 .nav-link').forEach(function(link) {
                    link.addEventListener('click', function() {
                        if (this.classList.contains('tab-locked')) return;
                        var idx = parseInt(this.getAttribute('data-tab-index'));
                        if (idx === 3 && !adaLembur) return;
                        if (idx <= currentTab) {
                            switchTab(idx, true); // going back — no validation
                        } else {
                            switchTab(idx);
                        }
                    });
                });
                document.querySelectorAll('#workPermitForm input, #workPermitForm select, #workPermitForm textarea').forEach(function(el) {
                    el.addEventListener('change', function() {
                        if (this.hasAttribute('required')) {
                            if (this.value.trim()) {
                                this.classList.remove('is-invalid');
                                this.classList.add('is-valid');
                            }
                        }
                    });
                });

                // Prev button
                var prevBtn = document.getElementById('btnPrev');
                if (prevBtn) {
                    prevBtn.addEventListener('click', function() {
                        if (currentTab > 0) switchTab(currentTab - 1, true);
                    });
                }

                // Add tahap button
                var addBtn = document.getElementById('addTahapBtn');
                if (addBtn) addBtn.addEventListener('click', addTahapPekerjaan);

                // Lembur toggle switch
                var lemburSwitch = document.getElementById('lemburToggle');
                if (lemburSwitch) {
                    lemburSwitch.addEventListener('change', function() {
                        handleLemburToggle(this.checked);
                    });
                }

                // Tanggal lembur → auto hari
                var tanggalLembur = document.querySelector('input[name="tanggal_lembur"]');
                if (tanggalLembur) {
                    tanggalLembur.addEventListener('change', function() {
                        handleTanggalLembur(this.value);
                    });
                }

                // Durasi lembur auto-calc
                var jamMulai = document.querySelector('input[name="jam_mulai_lembur"]');
                var jamSelesai = document.querySelector('input[name="jam_selesai_lembur"]');
                if (jamMulai) jamMulai.addEventListener('change', calculateDurasi);
                if (jamSelesai) jamSelesai.addEventListener('change', calculateDurasi);

                // Clear invalid on input
                document.getElementById('workPermitForm').addEventListener('input', function(e) {
                    if (e.target.classList.contains('is-invalid') && e.target.value.trim()) {
                        e.target.classList.remove('is-invalid');
                        e.target.classList.add('is-valid');
                    }
                });

                // Final form submit validation
                document.getElementById('workPermitForm').addEventListener('submit', function(e) {
                    var allValid = true;
                    var tabs = adaLembur ? [0, 1, 2, 3] : [0, 1, 2];
                    tabs.forEach(function(i) {
                        if (!validateTabSilent(i)) allValid = false;
                    });
                    if (!allValid) {
                        e.preventDefault();
                        showBanner('Masih ada field yang belum diisi. Periksa kembali setiap tab.');
                    }
                });
            }

            // Silent validate (no banner, just mark fields)
            function validateTabSilent(index) {
                var pane = document.getElementById(TABS[index]);
                if (!pane) return true;
                var inputs = pane.querySelectorAll('input[required], select[required], textarea[required]');
                var valid = true;
                inputs.forEach(function(el) {
                    if (el.offsetParent === null) return;
                    if (!el.value.trim()) {
                        el.classList.add('is-invalid');
                        valid = false;
                    }
                });
                return valid;
            }

            // ── Public API ────────────────────────────
            window.WP = {
                addTahap: addTahapPekerjaan,
                removeTahap: removeTahap,
                handleLemburToggle: handleLemburToggle,
            };

            // ── Boot ─────────────────────────────────
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', init);
            } else {
                init();
            }

        })();
    </script>
</body>

</html>