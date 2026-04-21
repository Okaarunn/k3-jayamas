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

    <style>
        .create-header {
            background: #283593;
            border-radius: 16px;
            padding: 24px 32px;
            margin-bottom: 28px;
            display: flex;
            align-items: center;
            gap: 16px;
            box-shadow: 0 8px 32px rgba(74, 20, 140, 0.18);
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
            transition: background 0.2s;
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
            color: rgba(255, 255, 255, 0.65);
            font-size: 0.82rem;
            margin: 3px 0 0;
        }
    </style>

    <!-- Header -->
    <div class="create-header">
        <a href="<?= base_url('patrol') ?>" class="back-btn">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h1>Tambah Laporan Patrol</h1>
            <p>Dokumentasikan kegiatan patrol lapangan beserta foto kondisi Before &amp; After</p>
        </div>
    </div>

    <form action="<?= base_url('patrol/store') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <!-- Info Dasar -->
        <div class="card form-card">
            <div class="card-header">
                <div class="section-icon"><i class="fas fa-info-circle"></i></div>
                <h6>Informasi Patrol</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Kode (auto) -->
                    <div class="col-md-3 mb-4">
                        <label class="form-label-k3">Kode Patrol</label>
                        <div class="kode-display">
                            <i class="fas fa-hashtag" style="font-size:.85rem"></i>
                            <?= esc($kode) ?>
                        </div>
                        <div style="font-size:.72rem;color:#9e9e9e;margin-top:4px">Auto-generate oleh sistem</div>
                    </div>

                    <!-- Nama Petugas -->
                    <div class="col-md-5 mb-4">
                        <label class="form-label-k3">Nama Petugas <span style="color:#c62828">*</span></label>
                        <input type="text" name="nama_petugas"
                            class="form-control-k3 <?= isset($errors['nama_petugas']) ? 'is-invalid' : '' ?>"
                            value="<?= old('nama_petugas') ?>"
                            placeholder="Nama lengkap petugas patrol" required>
                        <?php if (isset($errors['nama_petugas'])) : ?>
                            <div class="invalid-feedback-k3"><i class="fas fa-exclamation-circle mr-1"></i><?= $errors['nama_petugas'] ?></div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="row">

                    <!-- lokasi patrol -->
                    <div class="col-md-4 mb-4">
                        <label class="form-label-k3">Lokasi Patrol <span style="color:#c62828">*</span></label>
                        <input type="text" name="lokasi"
                            class="form-control-k3"
                            value="<?= old('lokasi') ?>"
                            placeholder="Lokasi patol" required>
                    </div>

                    <!-- Tanggal Patrol -->
                    <div class="col-md-4 mb-4">
                        <label class="form-label-k3">Tanggal Patrol <span style="color:#c62828">*</span></label>
                        <input type="date" name="tanggal_patrol"
                            class="form-control-k3 <?= isset($errors['tanggal_patrol']) ? 'is-invalid' : '' ?>"
                            value="<?= old('tanggal_patrol', date('Y-m-d')) ?>"
                            max="<?= date('Y-m-d') ?>" required>
                        <?php if (isset($errors['tanggal_patrol'])) : ?>
                            <div class="invalid-feedback-k3"><i class="fas fa-exclamation-circle mr-1"></i><?= $errors['tanggal_patrol'] ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- Tanggal Penyelesaian -->
                    <div class="col-md-4 mb-4">
                        <label class="form-label-k3">Tanggal Penyelesaian</label>
                        <input type="date" name="tanggal_penyelesaian"
                            class="form-control-k3 <?= isset($errors['tanggal_penyelesaian']) ? 'is-invalid' : '' ?>"
                            value="<?= old('tanggal_penyelesaian') ?>">
                        <div style="font-size:.72rem;color:#9e9e9e;margin-top:4px">Opsional — isi jika tindakan sudah selesai</div>
                    </div>
                </div>

                <!-- Keterangan -->
                <div class="mb-0">
                    <label class="form-label-k3">Temuan</label>
                    <textarea name="temuan" id="temuan" rows="4"
                        class="form-control-k3"
                        placeholder="Uraikan temuan lapangan..."
                        maxlength="2000"><?= old('temuan') ?></textarea>
                    <div class="char-counter" id="charCounterTemuan">0 / 2000 karakter</div>
                </div>

                <!-- penyelesaian -->
                <div class="mb-0">
                    <label class="form-label-k3">Penyelesaian</label>
                    <textarea name="penyelesaian" id="penyelesaian" rows="4"
                        class="form-control-k3"
                        placeholder="Uraikan penyelesaian lapangan dan tindakan perbaikan yang diambil..."
                        maxlength="2000"><?= old('penyelesaian') ?></textarea>
                    <div class="char-counter" id="charCounterPenyelesaian">0 / 2000 karakter</div>
                </div>
            </div>
        </div>

        <!-- Upload Foto -->
        <div class="card form-card">
            <div class="card-header">
                <div class="section-icon"><i class="fas fa-camera"></i></div>
                <h6>Dokumentasi Foto</h6>
            </div>
            <div class="card-body">
                <div class="foto-grid">

                    <!-- Foto Before -->
                    <div>
                        <div class="foto-section-label label-before">
                            <span class="dot dot-before"></span> Foto Before (Kondisi Awal)
                        </div>
                        <div class="upload-zone" id="zoneB">
                            <input type="file" name="foto_before" id="inputBefore" accept=".jpg,.jpeg,.png">
                            <i class="fas fa-cloud-upload-alt upload-icon" style="color:#f9a825"></i>
                            <div class="upload-text" style="color:#e65100">Upload foto kondisi awal</div>
                            <div class="upload-hint">JPG / PNG — Maks. 5MB</div>
                        </div>
                        <div class="file-preview" id="previewB">
                            <img src="" class="fp-thumb" id="thumbB" alt="">
                            <div>
                                <div class="fp-name" id="nameB"></div>
                                <div class="fp-size" id="sizeB"></div>
                            </div>
                            <button type="button" class="fp-remove" id="removeB"><i class="fas fa-times-circle"></i></button>
                        </div>
                        <?php if (isset($errors['foto_before'])) : ?>
                            <div class="invalid-feedback-k3 mt-1"><i class="fas fa-exclamation-circle mr-1"></i><?= $errors['foto_before'] ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- Foto After -->
                    <div>
                        <div class="foto-section-label label-after">
                            <span class="dot dot-after"></span> Foto After (Setelah Tindakan)
                        </div>
                        <div class="upload-zone" id="zoneA">
                            <input type="file" name="foto_after" id="inputAfter" accept=".jpg,.jpeg,.png">
                            <i class="fas fa-cloud-upload-alt upload-icon" style="color:#81c784"></i>
                            <div class="upload-text" style="color:#388e3c">Upload foto setelah tindakan</div>
                            <div class="upload-hint">JPG / PNG — Maks. 5MB</div>
                        </div>
                        <div class="file-preview" id="previewA">
                            <img src="" class="fp-thumb" id="thumbA" alt="">
                            <div>
                                <div class="fp-name" id="nameA"></div>
                                <div class="fp-size" id="sizeA"></div>
                            </div>
                            <button type="button" class="fp-remove" id="removeA"><i class="fas fa-times-circle"></i></button>
                        </div>
                        <?php if (isset($errors['foto_after'])) : ?>
                            <div class="invalid-feedback-k3 mt-1"><i class="fas fa-exclamation-circle mr-1"></i><?= $errors['foto_after'] ?></div>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
        </div>

        <div class="d-flex align-items-center justify-content-end" style="gap:12px">
            <button type="submit" class="btn-save">
                <i class="fas fa-save mr-2"></i>Simpan Laporan
            </button>
            <a href="<?= base_url('patrol') ?>" class="btn-cancel">Batal</a>
        </div>

    </form>
</div>
<?php $this->endSection(); ?>


<?php $this->section('scripts'); ?>
<script>
    $(document).ready(function() {

        // Char counter
        $('#temuan').on('input', function() {
            const len = $(this).val().length;
            const c = $('#charCounterTemuan');
            c.text(len + ' / 2000 karakter').removeClass('warn over');
            if (len > 1800) c.addClass('over');
            else if (len > 1500) c.addClass('warn');
        });

        $('#penyelesaian').on('input', function() {
            const len = $(this).val().length;
            const c = $('#charCounterPenyelesaian');
            c.text(len + ' / 2000 karakter').removeClass('warn over');
            if (len > 1800) c.addClass('over');
            else if (len > 1500) c.addClass('warn');
        });

        // Generic foto preview setup
        function setupFoto(inputId, zoneId, previewId, thumbId, nameId, sizeId, removeId) {
            const $input = $('#' + inputId);
            const $zone = $('#' + zoneId);
            const $preview = $('#' + previewId);

            $input.on('change', function() {
                const file = this.files[0];
                if (file) showPreview(file);
            });

            // Drag & drop
            document.getElementById(zoneId).addEventListener('dragover', function(e) {
                e.preventDefault();
                $(this).addClass('dragover');
            });
            document.getElementById(zoneId).addEventListener('dragleave', function() {
                $(this).removeClass('dragover');
            });
            document.getElementById(zoneId).addEventListener('drop', function(e) {
                e.preventDefault();
                $(this).removeClass('dragover');
                const file = e.dataTransfer.files[0];
                if (file) {
                    $input[0].files = e.dataTransfer.files;
                    showPreview(file);
                }
            });

            function showPreview(file) {
                if (file.size > 5 * 1024 * 1024) {
                    toast('error', 'File terlalu besar', 'Ukuran file melebihi 5MB');
                    $input.val('');
                    return;
                }
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#' + thumbId).attr('src', e.target.result);
                };
                reader.readAsDataURL(file);
                $('#' + nameId).text(file.name);
                $('#' + sizeId).text((file.size / (1024 * 1024)).toFixed(2) + ' MB');
                $preview.addClass('show');
                $zone.css({
                    'border-color': '#7b1fa2',
                    'background': '#f3e5f5'
                });
            }

            $('#' + removeId).on('click', function() {
                $input.val('');
                $preview.removeClass('show');
                $zone.css({
                    'border-color': '#ce93d8',
                    'background': '#fdf6ff'
                });
            });
        }

        setupFoto('inputBefore', 'zoneB', 'previewB', 'thumbB', 'nameB', 'sizeB', 'removeB');
        setupFoto('inputAfter', 'zoneA', 'previewA', 'thumbA', 'nameA', 'sizeA', 'removeA');
    });
</script>
<?php $this->endSection(); ?>