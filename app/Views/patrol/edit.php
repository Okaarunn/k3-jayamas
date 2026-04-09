<?= $this->extend('templates/index'); ?>

<?php $this->section('styles'); ?>
<style>
    .edit-header {
        background: #283593;
        border-radius: 16px;
        padding: 24px 32px;
        margin-bottom: 28px;
        display: flex;
        align-items: center;
        gap: 16px;
        box-shadow: 0 8px 32px rgba(74, 20, 140, 0.18);
    }

    .edit-header .back-btn {
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

    .edit-header .back-btn:hover {
        background: rgba(255, 255, 255, 0.25);
        color: #fff;
    }

    .edit-header h1 {
        color: #fff;
        font-size: 1.35rem;
        font-weight: 700;
        margin: 0;
    }

    .edit-header p {
        color: rgba(255, 255, 255, .65);
        font-size: .82rem;
        margin: 3px 0 0;
    }

    .form-card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 2px 20px rgba(0, 0, 0, 0.07);
        overflow: hidden;
        margin-bottom: 24px;
    }

    .form-card .card-header {
        background: #f9f4ff;
        border-bottom: 1px solid #e1bee7;
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
        color: #4a148c;
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
        border-color: #3949ab;
        box-shadow: 0 0 0 3px rgba(57, 73, 171, .1);
        outline: none;
    }

    .form-control-k3:disabled {
        background: #f5f5f5;
        color: #9e9e9e;
        cursor: not-allowed;
    }

    .invalid-feedback-k3 {
        font-size: .78rem;
        color: #c62828;
        margin-top: 4px;
    }

    .kode-display {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #f3e5f5;
        border: 1.5px solid #ce93d8;
        border-radius: 10px;
        padding: 10px 16px;
        font-family: monospace;
        font-size: 1.1rem;
        font-weight: 700;
        color: #4a148c;
        letter-spacing: 1px;
    }

    /* Current foto */
    .current-foto {
        border-radius: 12px;
        overflow: hidden;
        position: relative;
        border: 2px solid #e1bee7;
        margin-bottom: 10px;
    }

    .current-foto img {
        width: 100%;
        height: 140px;
        object-fit: cover;
        display: block;
    }

    .current-foto .foto-label {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(74, 20, 140, 0.7);
        color: #fff;
        font-size: .72rem;
        font-weight: 600;
        padding: 5px 10px;
        text-align: center;
    }

    .no-foto {
        background: #f5f5f5;
        border-radius: 12px;
        height: 80px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #bdbdbd;
        font-size: .8rem;
        margin-bottom: 10px;
        gap: 6px;
        border: 1.5px dashed #e0e0e0;
    }

    .upload-zone {
        border: 2px dashed #ce93d8;
        border-radius: 12px;
        padding: 16px 20px;
        text-align: center;
        cursor: pointer;
        transition: all .2s;
        position: relative;
        background: #fdf6ff;
    }

    .upload-zone:hover {
        border-color: #7b1fa2;
        background: #f3e5f5;
    }

    .upload-zone input[type="file"] {
        position: absolute;
        inset: 0;
        opacity: 0;
        cursor: pointer;
        width: 100%;
    }

    .upload-zone .upload-text {
        font-weight: 600;
        color: #6a1b9a;
        font-size: .82rem;
    }

    .upload-zone .upload-hint {
        font-size: .72rem;
        color: #9e9e9e;
        margin-top: 2px;
    }

    .file-preview {
        display: none;
        align-items: center;
        gap: 12px;
        background: #f3e5f5;
        border-radius: 10px;
        padding: 10px 14px;
        margin-top: 8px;
    }

    .file-preview.show {
        display: flex;
    }

    .file-preview .fp-thumb {
        width: 40px;
        height: 40px;
        border-radius: 6px;
        object-fit: cover;
    }

    .file-preview .fp-name {
        font-weight: 600;
        font-size: .8rem;
        color: #4a148c;
    }

    .file-preview .fp-size {
        font-size: .72rem;
        color: #9e9e9e;
    }

    .file-preview .fp-remove {
        margin-left: auto;
        background: none;
        border: none;
        color: #c62828;
        cursor: pointer;
        font-size: .82rem;
    }

    .btn-save {
        background: #3949ab;
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
        box-shadow: 0 4px 16px rgba(123, 31, 162, .35);
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
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .foto-section-label {
        font-size: .72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .8px;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .label-before {
        color: #e65100;
    }

    .label-after {
        color: #388e3c;
    }

    .dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
    }

    .dot-before {
        background: #e65100;
    }

    .dot-after {
        background: #388e3c;
    }

    @media (max-width: 768px) {
        .foto-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
<?php $this->endSection(); ?>


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

    <div class="edit-header">
        <a href="<?= base_url('patrol') ?>" class="back-btn"><i class="fas fa-arrow-left"></i></a>
        <div>
            <h1>Edit Laporan Patrol</h1>
            <p>Mengubah data laporan <strong style="color:#fff"><?= esc($patrol->kode) ?></strong></p>
        </div>
    </div>

    <form action="<?= base_url('patrol/update/' . $patrol->id) ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <!-- Info Dasar -->
        <div class="card form-card">
            <div class="card-header">
                <div class="section-icon"><i class="fas fa-info-circle"></i></div>
                <h6>Informasi Patrol</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-4">
                        <label class="form-label-k3">Kode Patrol</label>
                        <div class="kode-display">
                            <i class="fas fa-hashtag" style="font-size:.85rem"></i>
                            <?= esc($patrol->kode) ?>
                        </div>
                    </div>
                    <div class="col-md-5 mb-4">
                        <label class="form-label-k3">Nama Petugas <span style="color:#c62828">*</span></label>
                        <input type="text" name="nama_petugas"
                            class="form-control-k3 <?= isset($errors['nama_petugas']) ? 'is-invalid' : '' ?>"
                            value="<?= old('nama_petugas', $patrol->nama_petugas) ?>"
                            placeholder="Nama lengkap petugas" required>
                        <?php if (isset($errors['nama_petugas'])) : ?>
                            <div class="invalid-feedback-k3"><i class="fas fa-exclamation-circle mr-1"></i><?= $errors['nama_petugas'] ?></div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- tanggal -->
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <label class="form-label-k3">Tanggal Patrol <span style="color:#c62828">*</span></label>
                        <input type="date" name="tanggal_patrol"
                            class="form-control-k3"
                            value="<?= old('tanggal_patrol', $patrol->tanggal_patrol) ?>"
                            max="<?= date('Y-m-d') ?>" required>
                    </div>
                    <div class="col-md-4 mb-4">
                        <label class="form-label-k3">Tanggal Penyelesaian</label>
                        <input type="date" name="tanggal_penyelesaian"
                            class="form-control-k3"
                            value="<?= old('tanggal_penyelesaian', $patrol->tanggal_penyelesaian) ?>">
                    </div>
                </div>

                <!-- temuan -->
                <div class="mb-0">
                    <label class="form-label-k3">Temuan</label>
                    <textarea name="temuan" id="keterangan" rows="4"
                        class="form-control-k3" maxlength="2000"
                        placeholder="Uraikan temuan lapangan..."><?= old('temuan', $patrol->temuan) ?></textarea>
                    <div class="char-counter" id="charCounter">0 / 2000 karakter</div>
                </div>

                <!-- penyelesaian -->
                <div class="mb-0">
                    <label class="form-label-k3">Penyelesaian</label>
                    <textarea name="penyelesaian" id="keterangan" rows="4"
                        class="form-control-k3" maxlength="2000"
                        placeholder="Uraikan penyelesaian dan tindakan perbaikan..."><?= old('keterangan', $patrol->penyelesaian) ?></textarea>
                    <div class="char-counter" id="charCounter">0 / 2000 karakter</div>
                </div>
            </div>
        </div>

        <!-- Foto -->
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
                            <span class="dot dot-before"></span> Foto Before
                        </div>
                        <?php if (! empty($patrol->foto_before_filename)) : ?>
                            <div class="current-foto">
                                <img src="<?= base_url('uploads/patrol/' . $patrol->foto_before_filename) ?>" alt="Foto Before">
                                <div class="foto-label">Foto saat ini</div>
                            </div>
                        <?php else : ?>
                            <div class="no-foto"><i class="fas fa-image"></i> Belum ada foto before</div>
                        <?php endif; ?>
                        <div class="upload-zone" id="zoneB">
                            <input type="file" name="foto_before" id="inputBefore" accept=".jpg,.jpeg,.png">
                            <div class="upload-text">Ganti foto before (opsional)</div>
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
                    </div>

                    <!-- Foto After -->
                    <div>
                        <div class="foto-section-label label-after">
                            <span class="dot dot-after"></span> Foto After
                        </div>
                        <?php if (! empty($patrol->foto_after_filename)) : ?>
                            <div class="current-foto">
                                <img src="<?= base_url('uploads/patrol/' . $patrol->foto_after_filename) ?>" alt="Foto After">
                                <div class="foto-label">Foto saat ini</div>
                            </div>
                        <?php else : ?>
                            <div class="no-foto"><i class="fas fa-image"></i> Belum ada foto after</div>
                        <?php endif; ?>
                        <div class="upload-zone" id="zoneA">
                            <input type="file" name="foto_after" id="inputAfter" accept=".jpg,.jpeg,.png">
                            <div class="upload-text">Ganti foto after (opsional)</div>
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
                    </div>

                </div>
            </div>
        </div>

        <div class="d-flex align-items-center" style="gap:12px">
            <button type="submit" class="btn-save">
                <i class="fas fa-save mr-2"></i>Simpan Perubahan
            </button>
            <a href="<?= base_url('patrol') ?>" class="btn-cancel">Batal</a>
        </div>

    </form>
</div>
<?php $this->endSection(); ?>


<?php $this->section('scripts'); ?>
<script>
    $(document).ready(function() {

        const initLen = $('#keteranganInput').val().length;
        $('#charCounter').text(initLen + ' / 2000 karakter');

        $('#keterangan').on('input', function() {
            const len = $(this).val().length;
            const c = $('#charCounter');
            c.text(len + ' / 2000 karakter').removeClass('warn over');
            if (len > 1800) c.addClass('over');
            else if (len > 1500) c.addClass('warn');
        });

        function setupFoto(inputId, zoneId, previewId, thumbId, nameId, sizeId, removeId) {
            const $input = $('#' + inputId);
            const $zone = $('#' + zoneId);
            const $preview = $('#' + previewId);

            $input.on('change', function() {
                if (this.files[0]) showPreview(this.files[0]);
            });

            function showPreview(file) {
                if (file.size > 5 * 1024 * 1024) {
                    alert('Ukuran file melebihi 5MB.');
                    $input.val('');
                    return;
                }
                const reader = new FileReader();
                reader.onload = e => $('#' + thumbId).attr('src', e.target.result);
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