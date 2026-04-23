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
                <button type="submit" class="btn btn-success" id="submitBtn" style="display:none;">
                    <i class="fas fa-check mr-2"></i>Submit Work Permit
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