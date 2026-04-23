<?= $this->extend('templates/index'); ?>
<?php $this->section('page-content'); ?>
<div class="container-fluid pb-4">

    <!-- Header -->
    <div class="create-header">
        <a href="<?= base_url('work-permit-request') ?>" class="back-btn">
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

            <!-- Tab Content -->
            <form action="<?= base_url('work-permit-request/store') ?>" method="post" id="workPermitForm">
                <?= csrf_field() ?>

                <div class="tab-content" id="workPermitTabContent">

                    <!-- TAB 1: IDENTITAS VENDOR -->
                    <div class="tab-pane fade show active" id="tab-vendor" role="tabpanel">
                        <div class="tab-form-content pt-4">
                            <div class="row">
                                <!-- Nama Vendor -->
                                <div class="col-md-6 mb-4">
                                    <label class="form-label-k3">Nama Vendor / Kontraktor <span style="color:#c62828">*</span></label>
                                    <input type="text" name="nama_vendor"
                                        class="form-control-k3 <?= isset($errors['nama_vendor']) ? 'is-invalid' : '' ?>"
                                        value="<?= old('nama_vendor') ?>"
                                        placeholder="Contoh: PT. Jaya Mandiri"
                                        required>
                                    <?php if (isset($errors['nama_vendor'])) : ?>
                                        <div class="invalid-feedback-k3"><i class="fas fa-exclamation-circle mr-1"></i><?= $errors['nama_vendor'] ?></div>
                                    <?php endif; ?>
                                </div>

                                <!-- Nama PIC -->
                                <div class="col-md-6 mb-4">
                                    <label class="form-label-k3">Nama PIC (Person In Charge) <span style="color:#c62828">*</span></label>
                                    <input type="text" name="nama_pic"
                                        class="form-control-k3 <?= isset($errors['nama_pic']) ? 'is-invalid' : '' ?>"
                                        value="<?= old('nama_pic') ?>"
                                        placeholder="Contoh: Budi Santoso"
                                        required>
                                    <?php if (isset($errors['nama_pic'])) : ?>
                                        <div class="invalid-feedback-k3"><i class="fas fa-exclamation-circle mr-1"></i><?= $errors['nama_pic'] ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="row">
                                <!-- No. Telepon -->
                                <div class="col-md-6 mb-4">
                                    <label class="form-label-k3">No. Telepon <span style="color:#c62828">*</span></label>
                                    <input type="tel" name="no_telepon"
                                        class="form-control-k3 <?= isset($errors['no_telepon']) ? 'is-invalid' : '' ?>"
                                        value="<?= old('no_telepon') ?>"
                                        placeholder="Contoh: 0812-3456-7890"
                                        required>
                                    <?php if (isset($errors['no_telepon'])) : ?>
                                        <div class="invalid-feedback-k3"><i class="fas fa-exclamation-circle mr-1"></i><?= $errors['no_telepon'] ?></div>
                                    <?php endif; ?>
                                </div>

                                <!-- Tanggal Pekerjaan -->
                                <div class="col-md-6 mb-4">
                                    <label class="form-label-k3">Tanggal Pekerjaan <span style="color:#c62828">*</span></label>
                                    <input type="date" name="tanggal_pekerjaan"
                                        class="form-control-k3 <?= isset($errors['tanggal_pekerjaan']) ? 'is-invalid' : '' ?>"
                                        value="<?= old('tanggal_pekerjaan') ?>"
                                        required>
                                    <?php if (isset($errors['tanggal_pekerjaan'])) : ?>
                                        <div class="invalid-feedback-k3"><i class="fas fa-exclamation-circle mr-1"></i><?= $errors['tanggal_pekerjaan'] ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Lokasi Pekerjaan -->
                                <div class="col-md-12 mb-4">
                                    <label class="form-label-k3">Lokasi Pekerjaan <span style="color:#c62828">*</span></label>
                                    <input type="text" name="lokasi_kerja"
                                        class="form-control-k3 <?= isset($errors['lokasi_kerja']) ? 'is-invalid' : '' ?>"
                                        value="<?= old('lokasi_kerja') ?>"
                                        placeholder="Contoh: Area Produksi - Lantai 2"
                                        required>
                                    <?php if (isset($errors['lokasi_kerja'])) : ?>
                                        <div class="invalid-feedback-k3"><i class="fas fa-exclamation-circle mr-1"></i><?= $errors['lokasi_kerja'] ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Jenis Pekerjaan -->
                                <div class="col-md-12 mb-4">
                                    <label class="form-label-k3">Jenis Pekerjaan <span style="color:#c62828">*</span></label>
                                    <textarea name="jenis_pekerjaan"
                                        class="form-control-k3 <?= isset($errors['jenis_pekerjaan']) ? 'is-invalid' : '' ?>"
                                        rows="3"
                                        placeholder="Deskripsi jenis pekerjaan yang akan dilakukan..."
                                        required><?= old('jenis_pekerjaan') ?></textarea>
                                    <?php if (isset($errors['jenis_pekerjaan'])) : ?>
                                        <div class="invalid-feedback-k3"><i class="fas fa-exclamation-circle mr-1"></i><?= $errors['jenis_pekerjaan'] ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Tab Navigation Buttons -->
                        <div class="tab-navigation-buttons mt-4">
                            <button type="button" class="btn btn-outline-secondary" onclick="previousTab()">
                                <i class="fas fa-chevron-left mr-2"></i>Sebelumnya
                            </button>
                            <button type="button" class="btn btn-primary" onclick="nextTab()">
                                Berikutnya<i class="fas fa-chevron-right ml-2"></i>
                            </button>
                        </div>
                    </div>

                    <!-- TAB 2: CHECKLIST WORK PERMIT -->
                    <div class="tab-pane fade" id="tab-checklist" role="tabpanel">
                        <div class="tab-form-content pt-4">
                            <div class="row">
                                <!-- Pemeriksaan Bahaya -->
                                <div class="col-md-12 mb-4">
                                    <label class="form-label-k3">Pemeriksaan Bahaya <span style="color:#c62828">*</span></label>
                                    <div class="form-check-inline-group">
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input" id="pemeriksaan_bahaya_ya"
                                                name="pemeriksaan_bahaya" value="ya" <?= old('pemeriksaan_bahaya') === 'ya' ? 'checked' : '' ?> required>
                                            <label class="form-check-label" for="pemeriksaan_bahaya_ya">Ya</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input" id="pemeriksaan_bahaya_tidak"
                                                name="pemeriksaan_bahaya" value="tidak" <?= old('pemeriksaan_bahaya') === 'tidak' ? 'checked' : '' ?> required>
                                            <label class="form-check-label" for="pemeriksaan_bahaya_tidak">Tidak</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Penyediaan APD -->
                                <div class="col-md-12 mb-4">
                                    <label class="form-label-k3">Penyediaan APD <span style="color:#c62828">*</span></label>
                                    <div class="form-check-inline-group">
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input" id="penyediaan_apd_ya"
                                                name="penyediaan_apd" value="ya" <?= old('penyediaan_apd') === 'ya' ? 'checked' : '' ?> required>
                                            <label class="form-check-label" for="penyediaan_apd_ya">Ya</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input" id="penyediaan_apd_tidak"
                                                name="penyediaan_apd" value="tidak" <?= old('penyediaan_apd') === 'tidak' ? 'checked' : '' ?> required>
                                            <label class="form-check-label" for="penyediaan_apd_tidak">Tidak</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Alat Pemapasan -->
                                <div class="col-md-12 mb-4">
                                    <label class="form-label-k3">Alat Pemapasan <span style="color:#c62828">*</span></label>
                                    <div class="form-check-inline-group">
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input" id="alat_pemapasan_ya"
                                                name="alat_pemapasan" value="ya" <?= old('alat_pemapasan') === 'ya' ? 'checked' : '' ?> required>
                                            <label class="form-check-label" for="alat_pemapasan_ya">Ya</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input" id="alat_pemapasan_tidak"
                                                name="alat_pemapasan" value="tidak" <?= old('alat_pemapasan') === 'tidak' ? 'checked' : '' ?> required>
                                            <label class="form-check-label" for="alat_pemapasan_tidak">Tidak</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Pemeriksaan Jelajakan -->
                                <div class="col-md-12 mb-4">
                                    <label class="form-label-k3">Pemeriksaan Jelajakan <span style="color:#c62828">*</span></label>
                                    <div class="form-check-inline-group">
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input" id="pemeriksaan_jelajakan_ya"
                                                name="pemeriksaan_jelajakan" value="ya" <?= old('pemeriksaan_jelajakan') === 'ya' ? 'checked' : '' ?> required>
                                            <label class="form-check-label" for="pemeriksaan_jelajakan_ya">Ya</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input" id="pemeriksaan_jelajakan_tidak"
                                                name="pemeriksaan_jelajakan" value="tidak" <?= old('pemeriksaan_jelajakan') === 'tidak' ? 'checked' : '' ?> required>
                                            <label class="form-check-label" for="pemeriksaan_jelajakan_tidak">Tidak</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tanda Peringatan -->
                                <div class="col-md-12 mb-4">
                                    <label class="form-label-k3">Tanda Peringatan <span style="color:#c62828">*</span></label>
                                    <div class="form-check-inline-group">
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input" id="tanda_peringatan_ya"
                                                name="tanda_peringatan" value="ya" <?= old('tanda_peringatan') === 'ya' ? 'checked' : '' ?> required>
                                            <label class="form-check-label" for="tanda_peringatan_ya">Ya</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input" id="tanda_peringatan_tidak"
                                                name="tanda_peringatan" value="tidak" <?= old('tanda_peringatan') === 'tidak' ? 'checked' : '' ?> required>
                                            <label class="form-check-label" for="tanda_peringatan_tidak">Tidak</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Perlengkapan Pabrik -->
                                <div class="col-md-12 mb-4">
                                    <label class="form-label-k3">Perlengkapan Pabrik <span style="color:#c62828">*</span></label>
                                    <div class="form-check-inline-group">
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input" id="perlengkapan_pabrik_ya"
                                                name="perlengkapan_pabrik" value="ya" <?= old('perlengkapan_pabrik') === 'ya' ? 'checked' : '' ?> required>
                                            <label class="form-check-label" for="perlengkapan_pabrik_ya">Ya</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input" id="perlengkapan_pabrik_tidak"
                                                name="perlengkapan_pabrik" value="tidak" <?= old('perlengkapan_pabrik') === 'tidak' ? 'checked' : '' ?> required>
                                            <label class="form-check-label" for="perlengkapan_pabrik_tidak">Tidak</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tab Navigation Buttons -->
                        <div class="tab-navigation-buttons mt-4">
                            <button type="button" class="btn btn-outline-secondary" onclick="previousTab()">
                                <i class="fas fa-chevron-left mr-2"></i>Sebelumnya
                            </button>
                            <button type="button" class="btn btn-primary" onclick="nextTab()">
                                Berikutnya<i class="fas fa-chevron-right ml-2"></i>
                            </button>
                        </div>
                    </div>

                    <!-- TAB 3: JOB SAFETY ANALYST (JSA) -->
                    <div class="tab-pane fade" id="tab-jsa" role="tabpanel">
                        <div class="tab-form-content pt-4">
                            <div class="alert alert-info-custom" role="alert">
                                <i class="fas fa-info-circle mr-2"></i>
                                <strong>Informasi:</strong> Tambahkan tahap pekerjaan sesuai dengan prosedur yang akan dilakukan
                            </div>

                            <!-- Tahap Pekerjaan - Dynamic Container -->
                            <div id="tahapPekerjaanContainer">
                                <!-- Tahap pertama ditambahkan dengan JavaScript -->
                            </div>

                            <!-- Tombol Tambah Tahap -->
                            <div class="mb-4">
                                <button type="button" class="btn btn-outline-primary" id="addTahapBtn">
                                    <i class="fas fa-plus mr-2"></i>Tambah Tahap Pekerjaan
                                </button>
                            </div>

                            <!-- Pertanyaan Lembur -->
                            <div class="card form-card mt-4">
                                <div class="card-header">
                                    <div class="section-icon"><i class="fas fa-clock"></i></div>
                                    <h6>Status Lembur</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12 mb-4">
                                            <label class="form-label-k3">Apakah ada lembur? <span style="color:#c62828">*</span></label>
                                            <div class="form-check-inline-group">
                                                <div class="form-check">
                                                    <input type="radio" class="form-check-input" id="ada_lembur_ya"
                                                        name="ada_lembur" value="ya" onchange="toggleLemburTab()"
                                                        <?= old('ada_lembur') === 'ya' ? 'checked' : '' ?> required>
                                                    <label class="form-check-label" for="ada_lembur_ya">Ya</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="radio" class="form-check-input" id="ada_lembur_tidak"
                                                        name="ada_lembur" value="tidak" onchange="toggleLemburTab()"
                                                        <?= old('ada_lembur') === 'tidak' ? 'checked' : '' ?> required>
                                                    <label class="form-check-label" for="ada_lembur_tidak">Tidak</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tab Navigation Buttons -->
                        <div class="tab-navigation-buttons mt-4">
                            <button type="button" class="btn btn-outline-secondary" onclick="previousTab()">
                                <i class="fas fa-chevron-left mr-2"></i>Sebelumnya
                            </button>
                            <button type="button" class="btn btn-primary" id="nextTabBtn" onclick="nextTab()" style="display:none;">
                                Berikutnya<i class="fas fa-chevron-right ml-2"></i>
                            </button>
                            <button type="button" class="btn btn-primary" id="continueBtn" onclick="continueLembur()" style="display:none;">
                                Continue ke Form Lembur<i class="fas fa-chevron-right ml-2"></i>
                            </button>
                        </div>
                    </div>

                    <!-- TAB 4: FORM LEMBUR -->
                    <div class="tab-pane fade" id="tab-lembur" role="tabpanel">
                        <div class="tab-form-content pt-4">
                            <div class="row">
                                <!-- Tanggal Lembur -->
                                <div class="col-md-6 mb-4">
                                    <label class="form-label-k3">Tanggal Lembur <span style="color:#c62828">*</span></label>
                                    <input type="date" name="tanggal_lembur"
                                        class="form-control-k3 <?= isset($errors['tanggal_lembur']) ? 'is-invalid' : '' ?>"
                                        value="<?= old('tanggal_lembur') ?>">
                                    <?php if (isset($errors['tanggal_lembur'])) : ?>
                                        <div class="invalid-feedback-k3"><i class="fas fa-exclamation-circle mr-1"></i><?= $errors['tanggal_lembur'] ?></div>
                                    <?php endif; ?>
                                </div>

                                <!-- Jam Mulai Lembur -->
                                <div class="col-md-6 mb-4">
                                    <label class="form-label-k3">Jam Mulai <span style="color:#c62828">*</span></label>
                                    <input type="time" name="jam_mulai_lembur"
                                        class="form-control-k3 <?= isset($errors['jam_mulai_lembur']) ? 'is-invalid' : '' ?>"
                                        value="<?= old('jam_mulai_lembur') ?>">
                                    <?php if (isset($errors['jam_mulai_lembur'])) : ?>
                                        <div class="invalid-feedback-k3"><i class="fas fa-exclamation-circle mr-1"></i><?= $errors['jam_mulai_lembur'] ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Jam Selesai Lembur -->
                                <div class="col-md-6 mb-4">
                                    <label class="form-label-k3">Jam Selesai <span style="color:#c62828">*</span></label>
                                    <input type="time" name="jam_selesai_lembur"
                                        class="form-control-k3 <?= isset($errors['jam_selesai_lembur']) ? 'is-invalid' : '' ?>"
                                        value="<?= old('jam_selesai_lembur') ?>">
                                    <?php if (isset($errors['jam_selesai_lembur'])) : ?>
                                        <div class="invalid-feedback-k3"><i class="fas fa-exclamation-circle mr-1"></i><?= $errors['jam_selesai_lembur'] ?></div>
                                    <?php endif; ?>
                                </div>

                                <!-- Durasi Lembur -->
                                <div class="col-md-6 mb-4">
                                    <label class="form-label-k3">Durasi Lembur (Jam) <span style="color:#c62828">*</span></label>
                                    <input type="number" name="durasi_lembur" min="0.5" step="0.5"
                                        class="form-control-k3 <?= isset($errors['durasi_lembur']) ? 'is-invalid' : '' ?>"
                                        value="<?= old('durasi_lembur') ?>"
                                        placeholder="Contoh: 2" readonly>
                                    <?php if (isset($errors['durasi_lembur'])) : ?>
                                        <div class="invalid-feedback-k3"><i class="fas fa-exclamation-circle mr-1"></i><?= $errors['durasi_lembur'] ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Uasan Lembur -->
                                <div class="col-md-12 mb-4">
                                    <label class="form-label-k3">Alasan Lembur <span style="color:#c62828">*</span></label>
                                    <textarea name="alasan_lembur"
                                        class="form-control-k3 <?= isset($errors['alasan_lembur']) ? 'is-invalid' : '' ?>"
                                        rows="4"
                                        placeholder="Jelaskan alasan/keperluan lembur..."><?= old('alasan_lembur') ?></textarea>
                                    <?php if (isset($errors['alasan_lembur'])) : ?>
                                        <div class="invalid-feedback-k3"><i class="fas fa-exclamation-circle mr-1"></i><?= $errors['alasan_lembur'] ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Tab Navigation Buttons -->
                        <div class="tab-navigation-buttons mt-4">
                            <button type="button" class="btn btn-outline-secondary" onclick="previousTab()">
                                <i class="fas fa-chevron-left mr-2"></i>Sebelumnya
                            </button>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-check mr-2"></i>Submit Work Permit
                            </button>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>

</div>

<?php $this->endSection(); ?>

<?php $this->section('scripts'); ?>
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
        }

        .tab-navigation-buttons {
            flex-direction: column-reverse;
        }

        .tab-navigation-buttons button {
            width: 100%;
        }
    }
</style>

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

    // Toggle Lembur Tab
    function toggleLemburTab() {
        const adaLembur = document.querySelector('input[name="ada_lembur"]:checked')?.value;
        const lemburTab = document.getElementById('tab-lembur-link');
        const nextBtn = document.getElementById('nextTabBtn');
        const continueBtn = document.getElementById('continueBtn');

        if (adaLembur === 'ya') {
            // Enable lembur tab
            lemburTab.style.opacity = '1';
            lemburTab.style.pointerEvents = 'auto';
            nextBtn.style.display = 'none';
            continueBtn.style.display = 'inline-block';
        } else {
            // Disable lembur tab
            lemburTab.style.opacity = '0.5';
            lemburTab.style.pointerEvents = 'none';
            nextBtn.style.display = 'inline-block';
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
<?php $this->endSection(); ?>