    <?= $this->extend('templates/index'); ?>
    <?php $this->section('page-content'); ?>
    <div class="container-fluid pb-4">

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

        <!-- Header -->
        <div class="create-header">
            <a href="<?= base_url('induksi') ?>" class="back-btn">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1>Tambah Data Induksi</h1>
                <p>Catat hasil kegiatan training / induksi K3 baru</p>
            </div>
        </div>

        <div class="card form-card">
            <div class="card-header">
                <div class="section-icon"><i class="fas fa-user-check"></i></div>
                <h6>Form Input Induksi</h6>
            </div>
            <div class="card-body">
                <form action="<?= base_url('induksi/store') ?>" method="post" enctype="multipart/form-data" id="induksiForm">
                    <?= csrf_field() ?>

                    <div class="row">
                        <!-- Tanggal -->
                        <div class="col-md-4 mb-4">
                            <label class="form-label-k3">Tanggal Induksi <span style="color:#c62828">*</span></label>
                            <input type="date" name="tanggal_induksi"
                                class="form-control-k3 <?= isset($errors['tanggal_induksi']) ? 'is-invalid' : '' ?>"
                                value="<?= old('tanggal_induksi', date('Y-m-d')) ?>"
                                max="<?= date('Y-m-d') ?>" required>
                            <?php if (isset($errors['tanggal_induksi'])) : ?>
                                <div class="invalid-feedback-k3"><i class="fas fa-exclamation-circle mr-1"></i><?= $errors['tanggal_induksi'] ?></div>
                            <?php endif; ?>
                        </div>

                        <!-- Jumlah Peserta -->
                        <div class="col-md-4 mb-4">
                            <label class="form-label-k3">Jumlah Peserta <span style="color:#c62828">*</span></label>
                            <input type="number" name="jumlah_peserta" min="1"
                                class="form-control-k3 <?= isset($errors['jumlah_peserta']) ? 'is-invalid' : '' ?>"
                                value="<?= old('jumlah_peserta') ?>"
                                placeholder="Contoh: 25" required>
                            <?php if (isset($errors['jumlah_peserta'])) : ?>
                                <div class="invalid-feedback-k3"><i class="fas fa-exclamation-circle mr-1"></i><?= $errors['jumlah_peserta'] ?></div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Keterangan -->
                    <div class="mb-4">
                        <label class="form-label-k3">Keterangan / Materi</label>
                        <textarea name="keterangan" id="keteranganInput" rows="4"
                            class="form-control-k3 <?= isset($errors['keterangan']) ? 'is-invalid' : '' ?>"
                            placeholder="Deskripsi materi, tujuan, atau catatan pelaksanaan induksi..."
                            maxlength="1000"><?= old('keterangan') ?></textarea>
                        <div class="char-counter" id="charCounter">0 / 1000 karakter</div>
                        <?php if (isset($errors['keterangan'])) : ?>
                            <div class="invalid-feedback-k3"><i class="fas fa-exclamation-circle mr-1"></i><?= $errors['keterangan'] ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- Upload Dokumentasi -->
                    <!-- Upload Foto -->
                    <div class="card form-card">
                        <div class="card-header">
                            <div class="section-icon"><i class="fas fa-camera"></i></div>
                            <h6>Dokumentasi Foto</h6>
                        </div>
                        <div class="card-body">
                            <div class="foto-grid">

                                <!-- Foto Dokumentasi -->
                                <div>
                                    <div class="foto-section-label" style="color:#00695c">
                                        <span class="dot" style="background:#00695c"></span>
                                        Foto Dokumentasi Induksi
                                    </div>

                                    <div class="upload-zone" id="zoneD">
                                        <input type="file" name="dokumentasi[]" id="inputD" accept=".jpg,.jpeg,.png" multiple>
                                        <i class="fas fa-cloud-upload-alt upload-icon" style="color:#80cbc4"></i>
                                        <div class="upload-text" style="color:#004d40">
                                            Upload dokumentasi kegiatan
                                        </div>
                                        <div class="upload-hint">JPG / PNG — Maks. 5MB</div>
                                    </div>

                                    <div id="previewD" class="file-preview-multi"></div>

                                    <?php if (isset($errors['dokumentasi'])) : ?>
                                        <div class="invalid-feedback-k3 mt-1">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            <?= $errors['dokumentasi'] ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                            </div>

                            <!-- Foto Absensi -->
                            <div class="mt-5">
                                <div class="foto-section-label" style="color:#3949ab">
                                    <span class="dot" style="background:#3949ab"></span>
                                    Foto Absensi Peserta
                                </div>

                                <div class="upload-zone" id="zoneA">
                                    <input type="file" name="absensi[]" id="inputA" accept=".jpg,.jpeg,.png" multiple>
                                    <i class="fas fa-cloud-upload-alt upload-icon" style="color:#9fa8da"></i>
                                    <div class="upload-text" style="color:#1a237e">
                                        Upload foto absensi
                                    </div>
                                    <div class="upload-hint">JPG / PNG — Maks. 5MB</div>
                                </div>

                                <div id="previewA" class="file-preview-multi"></div>

                                <?php if (isset($errors['absensi'])) : ?>
                                    <div class="invalid-feedback-k3 mt-1">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        <?= $errors['absensi'] ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                        </div>
                    </div>


                    <div class="divider"></div>

                    <div class="d-flex align-items-center justify-content-end" style="gap:12px">
                        <button type="submit" class="btn-save">
                            <i class="fas fa-save mr-2"></i>Simpan Data
                        </button>
                        <a href="<?= base_url('induksi') ?>" class="btn-cancel">Batal</a>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <?php $this->endSection(); ?>


    <?php $this->section('scripts'); ?>

    <script>
        $(document).ready(function() {

            function setupMultiPreview(inputId, previewId) {
                const input = document.getElementById(inputId);
                const preview = document.getElementById(previewId);

                let fileStore = [];

                input.addEventListener('change', function(e) {
                    fileStore = Array.from(e.target.files);
                    renderPreview();
                });

                function renderPreview() {
                    preview.innerHTML = '';

                    fileStore.forEach((file, index) => {
                        const reader = new FileReader();

                        reader.onload = function(e) {
                            const wrapper = document.createElement('div');
                            wrapper.classList.add('file-item');

                            const img = document.createElement('img');
                            img.src = e.target.result;

                            const btn = document.createElement('button');
                            btn.innerHTML = '×';

                            btn.onclick = function() {
                                fileStore.splice(index, 1);
                                updateInputFiles();
                                renderPreview();
                            };

                            wrapper.appendChild(img);
                            wrapper.appendChild(btn);
                            preview.appendChild(wrapper);
                        };

                        reader.readAsDataURL(file);
                    });
                }

                function updateInputFiles() {
                    const dataTransfer = new DataTransfer();

                    fileStore.forEach(file => dataTransfer.items.add(file));

                    input.files = dataTransfer.files;
                }
            }

            // init
            setupMultiPreview('inputD', 'previewD');
            setupMultiPreview('inputA', 'previewA');

        });
    </script>

    <style>
        .create-header {
            background: #283593;
            border-radius: 16px;
            padding: 24px 32px;
            margin-bottom: 28px;
            display: flex;
            align-items: center;
            gap: 16px;
            box-shadow: 0 8px 32px rgba(0, 77, 64, 0.18);
        }

        .create-header .back-btn {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            text-decoration: none;
            transition: background .2s;
            flex-shrink: 0;
        }

        .create-header .back-btn:hover {
            background: rgba(255, 255, 255, 0.25);
            color: #fff;
        }

        .create-header h1 {
            color: #fff;
            font-size: 1.35rem;
            font-weight: 700;
            margin: 0;
        }

        .create-header p {
            color: rgba(255, 255, 255, .65);
            font-size: .82rem;
            margin: 3px 0 0;
        }

        .form-card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.07);
            overflow: hidden;
        }

        .form-card .card-header {
            background: #f0faf9;
            border-bottom: 1px solid #b2dfdb;
            padding: 18px 28px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-card .card-header .section-icon {
            width: 32px;
            height: 32px;
            background: #283593;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: .8rem;
        }

        .form-card .card-header h6 {
            margin: 0;
            font-weight: 700;
            color: #004d40;
            font-size: .9rem;
        }

        .form-card .card-body {
            padding: 28px;
        }

        .form-label-k3 {
            font-size: .75rem;
            font-weight: 700;
            color: #616161;
            text-transform: uppercase;
            letter-spacing: .6px;
            margin-bottom: 6px;
            display: block;
        }

        .form-control-k3 {
            border: 1.5px solid #e8e8e8;
            border-radius: 10px;
            padding: 10px 14px;
            font-size: .875rem;
            color: #212121;
            transition: border .2s, box-shadow .2s;
            width: 100%;
        }

        .form-control-k3:focus {
            border-color: #00897b;
            box-shadow: 0 0 0 3px rgba(0, 137, 123, .1);
            outline: none;
        }

        .form-control-k3.is-invalid {
            border-color: #c62828;
        }

        .invalid-feedback-k3 {
            font-size: .78rem;
            color: #c62828;
            margin-top: 4px;
        }

        /* Upload zone */
        .upload-zone {
            border: 2px dashed #b2dfdb;
            border-radius: 12px;
            padding: 24px 20px;
            /* samakan dengan patrol */
            text-align: center;
            cursor: pointer;
            transition: all .2s;
            position: relative;
            background: #f9fdfc;
        }

        .upload-zone:hover,
        .upload-zone.dragover {
            border-color: #00897b;
            background: #e0f2f1;
        }

        .upload-zone input[type="file"] {
            position: absolute;
            inset: 0;
            opacity: 0;
            cursor: pointer;
            width: 100%;
        }

        .upload-zone .upload-icon {
            font-size: 1.6rem;
            /* samakan */
            margin-bottom: 6px;
        }

        .upload-zone .upload-text {
            font-weight: 600;
            font-size: .85rem;
        }

        .upload-zone .upload-hint {
            font-size: .72rem;
        }

        .file-preview {
            display: none;
            align-items: center;
            gap: 12px;
            background: #e0f2f1;
            border-radius: 10px;
            padding: 12px 16px;
            margin-top: 10px;
        }

        .file-preview.show {
            display: flex;
        }



        .file-preview .fp-thumb {
            width: 48px;
            height: 48px;
            border-radius: 8px;
            object-fit: cover;
            flex-shrink: 0;
        }

        .file-preview .fp-name {
            font-weight: 600;
            font-size: .85rem;
            color: #004d40;
        }

        .file-preview .fp-size {
            font-size: .75rem;
            color: #9e9e9e;
        }

        .file-preview .fp-remove {
            margin-left: auto;
            background: none;
            border: none;
            color: #c62828;
            cursor: pointer;
            font-size: .85rem;
            padding: 4px;
        }

        .btn-save {
            background: #283593;
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 10px 28px;
            font-weight: 700;
            font-size: .875rem;
            transition: all .2s;
            cursor: pointer;
        }

        .btn-save:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 16px rgba(0, 137, 123, .35);
            color: #fff;
        }

        .btn-cancel {
            background: #f5f5f5;
            color: #616161;
            border: none;
            border-radius: 10px;
            padding: 10px 24px;
            font-weight: 600;
            font-size: .875rem;
            text-decoration: none;
            display: inline-block;
            transition: background .15s;
        }

        .btn-cancel:hover {
            background: #eeeeee;
            color: #424242;
            text-decoration: none;
        }

        .divider {
            height: 1px;
            background: #f0f0f0;
            margin: 24px 0;
        }

        /* Char counter */
        .char-counter {
            font-size: .72rem;
            color: #9e9e9e;
            text-align: right;
            margin-top: 4px;
        }

        .char-counter.warn {
            color: #f57c00;
        }

        .char-counter.over {
            color: #c62828;
        }

        .foto-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .foto-section-label {
            font-size: .8rem;
            font-weight: 700;
            color: #ef6c00;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .foto-section-label .dot {
            width: 6px;
            height: 6px;
            background: #ef6c00;
            border-radius: 50%;
        }

        .file-preview-multi {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 12px;
        }

        .file-item {
            position: relative;
        }

        .file-item img {
            width: 70px;
            height: 70px;
            border-radius: 10px;
            object-fit: cover;
            border: 2px solid #e0e0e0;
        }

        .file-item button {
            position: absolute;
            top: -6px;
            right: -6px;
            background: #c62828;
            border: none;
            color: #fff;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 10px;
            cursor: pointer;
        }
    </style>

    <?php $this->endSection(); ?>