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
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="<?= base_url(); ?>/css/style.css" />
    <link rel="icon" type="image/x-icon" href="/logo.png">

    <style>
        /* Tab Styling */
        .nav-tabs-k3 {
            border-bottom: 2px solid #f0f0f0 !important;
            margin-bottom: 30px;
        }

        .nav-tabs-k3 .nav-link {
            color: #757575;
            border: none;
            border-bottom: 3px solid transparent;
            padding: 12px 20px;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .nav-tabs-k3 .nav-link:hover {
            color: #3949ab;
            border-bottom-color: rgba(57, 73, 171, 0.3);
        }

        .nav-tabs-k3 .nav-link.active {
            color: #3949ab;
            border-bottom-color: #3949ab;
        }

        .tab-number {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 24px;
            height: 24px;
            background: currentColor;
            color: white;
            border-radius: 50%;
            font-size: 0.75rem;
            font-weight: 700;
        }

        .nav-tabs-k3 .nav-link.active .tab-number {
            background: #3949ab;
        }

        .tab-label {
            display: none;
        }

        @media (min-width: 768px) {
            .tab-label {
                display: inline;
            }
        }

        /* Tab Form Content */
        .tab-form-content {
            min-height: 300px;
        }

        /* Form Elements */
        .form-check-inline-group {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .form-check {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-check-input {
            width: 18px;
            height: 18px;
            margin-top: 0;
            cursor: pointer;
            border: 2px solid #ccc;
            border-radius: 50%;
        }

        .form-check-input:checked {
            background-color: #3949ab;
            border-color: #3949ab;
        }

        .form-check-label {
            cursor: pointer;
            margin: 0;
            font-weight: 500;
            color: #424242;
        }

        /* Alert Info Custom */
        .alert-info-custom {
            background: #e3f2fd;
            color: #1565c0;
            border: 1px solid #90caf9;
            border-radius: 8px;
            padding: 12px 16px;
            margin-bottom: 20px;
        }

        /* Tab Navigation Buttons */
        .tab-navigation-buttons {
            display: flex;
            gap: 12px;
            justify-content: flex-end;
            padding-top: 20px;
            border-top: 1px solid #f0f0f0;
        }

        .btn-outline-secondary {
            color: #757575;
            border-color: #e0e0e0;
        }

        .btn-outline-secondary:hover {
            color: #424242;
            background-color: #f5f5f5;
            border-color: #bdbdbd;
        }

        /* Tahap Pekerjaan Card */
        .tahap-card {
            border: 1px solid #e0e0e0;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            background: #fafafa;
            position: relative;
        }

        .tahap-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .tahap-header h5 {
            margin: 0;
            color: #3949ab;
            font-weight: 700;
            font-size: 1rem;
        }

        .btn-remove-tahap {
            background: #ffebee;
            color: #c62828;
            border: 1px solid #ffcdd2;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 0.85rem;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-remove-tahap:hover {
            background: #ffcdd2;
            color: #b71c1c;
        }

        /* Custom Form Controls */
        .form-control-k3,
        .form-check-input {
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            padding: 10px 12px;
            font-size: 0.95rem;
            transition: border-color 0.2s;
        }

        .form-control-k3:focus,
        .form-check-input:focus {
            border-color: #3949ab;
            box-shadow: 0 0 0 0.2rem rgba(57, 73, 171, 0.25);
        }

        .form-label-k3 {
            font-weight: 600;
            color: #424242;
            margin-bottom: 8px;
            font-size: 0.95rem;
        }

        .invalid-feedback-k3 {
            color: #c62828;
            font-size: 0.85rem;
            margin-top: 4px;
            display: block;
        }

        /* Disabled Tab */
        .nav-link[style*="pointer-events: none"] {
            cursor: not-allowed;
        }

        @media (max-width: 768px) {
            .nav-tabs-k3 .nav-link {
                padding: 10px 12px;
                font-size: 0.8rem;
                background: #e8eaf6;
                border-radius: 8px 8px 0 0;
                margin-right: 4px;
                color: #5c6bc0;
            }

            /* Tab number - tidak aktif */
            .nav-tabs-k3 .nav-link .tab-number {
                background: #e8eaf6;
                color: #a5b3d9;
                border: 2px solid #d1d5e8;
            }

            /* Tab number - aktif */
            .nav-tabs-k3 .nav-link.active .tab-number {
                background: #3949ab;
                color: #fff;
                border: 2px solid #3949ab;
            }

            .nav-tabs-k3 .nav-link.active {
                background: #3949ab;
                color: #fff;
                border-bottom-color: #3949ab;
            }

            .nav-tabs-k3 .nav-link:hover {
                background: #d1d5e8;
                color: #3949ab;
            }

            .tab-navigation-buttons {
                flex-direction: column-reverse;
            }

            .tab-navigation-buttons button {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="container-wrapper mt-5">
        <div class="container-fluid pb-4">

            <!-- Header -->
            <div class="create-header">
                <a href="<?= base_url('work-permit') ?>" class="back-btn">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h1>Work Permit Request K3</h1>
                    <p>Buat permintaan izin kerja dengan penilaian keselamatan kerja</p>
                </div>
            </div>

            <!-- Error Messages -->
            <?php if (!empty($errors)) : ?>
                <div style="background:#fce4ec;color:#c62828;border-radius:12px;padding:14px 18px;margin-bottom:20px">
                    <strong><i class="fas fa-exclamation-circle mr-1"></i>Terdapat kesalahan:</strong>
                    <ul style="margin:8px 0 0;padding-left:20px">
                        <?php foreach ($errors as $e) : ?>
                            <li style="font-size:.875rem"><?= esc($e) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <!-- Tab Navigation -->
            <div class="card form-card">
                <div class="card-header">
                    <div class="section-icon"><i class="fas fa-file-alt"></i></div>
                    <h6>Work Permit Request</h6>
                </div>
                <div class="card-body">
                    <!-- Nav Tabs -->
                    <ul class="nav nav-tabs nav-tabs-k3" id="workPermitTabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="tab-vendor-link" data-toggle="tab" href="#tab-vendor" role="tab">
                                <span class="tab-number">1</span>
                                <span class="tab-label">Identitas Vendor</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tab-checklist-link" data-toggle="tab" href="#tab-checklist" role="tab">
                                <span class="tab-number">2</span>
                                <span class="tab-label">Checklist Work Permit</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tab-jsa-link" data-toggle="tab" href="#tab-jsa" role="tab">
                                <span class="tab-number">3</span>
                                <span class="tab-label">Job Safety Analyst (JSA)</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tab-lembur-link" data-toggle="tab" href="#tab-lembur" role="tab" style="opacity: 0.5; pointer-events: none;">
                                <span class="tab-number">4</span>
                                <span class="tab-label">Form Lembur</span>
                            </a>
                        </li>
                    </ul>


                    <?= $this->include('components/form-work-permit') ?>

                </div>
            </div>

        </div>


    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('js/sb-admin-2.min.js') ?>"></script>

    <script>
        // Initialize first tahap pekerjaan on page load
        document.addEventListener('DOMContentLoaded', function() {
            addTahapPekerjaan();

            // Setup event listeners
            document.getElementById('addTahapBtn').addEventListener('click', function() {
                addTahapPekerjaan();
            });

            // Event listener untuk waktu lembur
            document.querySelector('input[name="jam_mulai_lembur"]')?.addEventListener('change', calculateDurasi);
            document.querySelector('input[name="jam_selesai_lembur"]')?.addEventListener('change', calculateDurasi);
        });

        // Tab Navigation
        let currentTab = 0;
        const tabs = ['tab-vendor', 'tab-checklist', 'tab-jsa', 'tab-lembur'];

        function showTab(n) {
            const tabContents = document.querySelectorAll('.tab-pane');
            const tabLinks = document.querySelectorAll('.nav-tabs-k3 .nav-link');

            if (n >= tabs.length) {
                n = tabs.length - 1;
            }
            if (n < 0) {
                n = 0;
            }

            // Hide all tabs
            tabContents.forEach(tab => {
                tab.classList.remove('active', 'show');
            });
            tabLinks.forEach(link => {
                link.classList.remove('active');
            });

            // Show current tab
            const activeTab = document.getElementById(tabs[n]);
            activeTab?.classList.add('active', 'show');

            const activeLink = document.getElementById(tabs[n] + '-link');
            activeLink?.classList.add('active');

            currentTab = n;
        }

        function nextTab() {
            if (validateCurrentTab()) {
                showTab(currentTab + 1);
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            }
        }

        function previousTab() {
            showTab(currentTab - 1);
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        function validateCurrentTab() {
            const form = document.getElementById('workPermitForm');
            const inputs = form.querySelectorAll(`#${tabs[currentTab]} input, #${tabs[currentTab]} textarea`);

            let isValid = true;
            inputs.forEach(input => {
                if (!input.checkValidity()) {
                    input.classList.add('is-invalid');
                    isValid = false;
                } else {
                    input.classList.remove('is-invalid');
                }
            });

            return isValid;
        }

        // Tahap Pekerjaan Dynamic Form
        let tahapCount = 0;

        function addTahapPekerjaan() {
            tahapCount++;
            const container = document.getElementById('tahapPekerjaanContainer');

            const tahapHTML = `
            <div class="tahap-card" id="tahap-${tahapCount}">
                <div class="tahap-header">
                    <h5>Tahap Pekerjaan ${tahapCount}</h5>
                    ${tahapCount > 1 ? `<button type="button" class="btn-remove-tahap" onclick="removeTahapPekerjaan(${tahapCount})">
                        <i class="fas fa-trash mr-2"></i>Hapus
                    </button>` : ''}
                </div>

                <div class="row">
                    <div class="col-md-12 mb-4">
                        <label class="form-label-k3">Tahapan Pekerjaan <span style="color:#c62828">*</span></label>
                        <textarea name="tahapan_pekerjaan[]" class="form-control-k3" 
                            placeholder="Deskripsi tahapan pekerjaan..." rows="3" required></textarea>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label class="form-label-k3">Potensi Bahaya <span style="color:#c62828">*</span></label>
                        <textarea name="potensi_bahaya[]" class="form-control-k3" 
                            placeholder="Jelaskan potensi bahaya..." rows="3" required></textarea>
                    </div>
                    <div class="col-md-6 mb-4">
                        <label class="form-label-k3">Pengendalian Risiko <span style="color:#c62828">*</span></label>
                        <textarea name="pengendalian_risiko[]" class="form-control-k3" 
                            placeholder="Jelaskan pengendalian risiko..." rows="3" required></textarea>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-4">
                        <label class="form-label-k3">Masih ada tahap pekerjaan?</label>
                        <div class="form-check-inline-group">
                            <div class="form-check">
                                <input type="radio" class="form-check-input" id="tahap_lagi_${tahapCount}_ya" 
                                    name="tahap_lagi_${tahapCount}" value="ya" onchange="handleTahapLagi(${tahapCount})">
                                <label class="form-check-label" for="tahap_lagi_${tahapCount}_ya">Ya</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" id="tahap_lagi_${tahapCount}_tidak" 
                                    name="tahap_lagi_${tahapCount}" value="tidak" onchange="handleTahapLagi(${tahapCount})">
                                <label class="form-check-label" for="tahap_lagi_${tahapCount}_tidak">Tidak</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;

            container.insertAdjacentHTML('beforeend', tahapHTML);
        }

        function removeTahapPekerjaan(tahapNum) {
            document.getElementById('tahap-' + tahapNum)?.remove();
            tahapCount--;
        }

        function handleTahapLagi(tahapNum) {
            const value = document.querySelector(`input[name="tahap_lagi_${tahapNum}"]:checked`)?.value;

            if (value === 'ya') {
                document.getElementById('addTahapBtn').style.display = 'block';
            }
        }

        // Toggle Lembur Tab & Buttons
        function toggleLemburTab() {
            const adaLembur = document.querySelector('input[name="ada_lembur"]:checked')?.value;
            const lemburTab = document.getElementById('tab-lembur-link');
            const submitBtn = document.getElementById('submitBtn');
            const continueBtn = document.getElementById('continueBtn');

            if (adaLembur === 'ya') {
                // Enable lembur tab & show continue button
                lemburTab.style.opacity = '1';
                lemburTab.style.pointerEvents = 'auto';
                submitBtn.style.display = 'none';
                continueBtn.style.display = 'inline-block';
            } else if (adaLembur === 'tidak') {
                // Disable lembur tab & show submit button
                lemburTab.style.opacity = '0.5';
                lemburTab.style.pointerEvents = 'none';
                submitBtn.style.display = 'inline-block';
                continueBtn.style.display = 'none';
            }
        }

        function continueLembur() {
            if (validateCurrentTab()) {
                showTab(3); // Go to tab 4 (index 3)
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            }
        }

        // Calculate Durasi Lembur
        function calculateDurasi() {
            const jamMulai = document.querySelector('input[name="jam_mulai_lembur"]').value;
            const jamSelesai = document.querySelector('input[name="jam_selesai_lembur"]').value;
            const durasiInput = document.querySelector('input[name="durasi_lembur"]');

            if (jamMulai && jamSelesai) {
                const [jamM, menitM] = jamMulai.split(':').map(Number);
                const [jamS, menitS] = jamSelesai.split(':').map(Number);

                let durasi = (jamS * 60 + menitS) - (jamM * 60 + menitM);
                if (durasi < 0) durasi += 24 * 60; // Handle overnight

                durasi = Math.round((durasi / 60) * 2) / 2; // Round to nearest 0.5
                durasiInput.value = durasi > 0 ? durasi : '';
            }
        }

        // Form Submission Validation
        document.getElementById('workPermitForm').addEventListener('submit', function(e) {
            const form = this;
            const inputs = form.querySelectorAll('input, textarea, select');
            let isValid = true;

            inputs.forEach(input => {
                if (input.hasAttribute('required') && input.offsetParent !== null) { // Only check visible inputs
                    if (!input.value.trim()) {
                        input.classList.add('is-invalid');
                        isValid = false;
                    } else {
                        input.classList.remove('is-invalid');
                    }
                }
            });

            const adaLembur = document.querySelector('input[name="ada_lembur"]:checked')?.value;
            if (adaLembur === 'ya') {
                // Validate lembur form
                const lemburInputs = document.querySelectorAll('#tab-lembur input[required], #tab-lembur textarea[required]');
                lemburInputs.forEach(input => {
                    if (!input.value.trim()) {
                        input.classList.add('is-invalid');
                        isValid = false;
                    }
                });
            }

            if (!isValid) {
                e.preventDefault();
                alert('Mohon isi semua field yang wajib diisi');
            }
        });
    </script>
</body>

</html>