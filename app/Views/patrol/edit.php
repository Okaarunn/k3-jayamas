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
                        <label class="form-label-k3">Lokasi Patrol <span style="color:#c62828">*</span></label>
                        <input type="text" name="lokasi"
                            class="form-control-k3"
                            value="<?= old('nama_petugas', $patrol->lokasi) ?>"
                            placeholder="Lokasi patol" required>
                    </div>

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
                    <textarea name="temuan" id="temuan" rows="4"
                        class="form-control-k3" maxlength="2000"
                        placeholder="Uraikan temuan lapangan..."><?= old('temuan', $patrol->temuan) ?></textarea>
                    <div class="char-counter" id="charCounterTemuan">0 / 2000 karakter</div>
                </div>

                <!-- penyelesaian -->
                <div class="mb-0">
                    <label class="form-label-k3">Penyelesaian</label>
                    <textarea name="penyelesaian" id="penyelesaian" rows="4"
                        class="form-control-k3" maxlength="2000"
                        placeholder="Uraikan penyelesaian dan tindakan perbaikan..."><?= old('penyelesaian', $patrol->penyelesaian) ?></textarea>
                    <div class="char-counter" id="charCounterPenyelesaian">0 / 2000 karakter</div>
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

        // Char counter for temuan
        const initLenTemuan = $('#temuan').val().length;
        $('#charCounterTemuan').text(initLenTemuan + ' / 2000 karakter');

        $('#temuan').on('input', function() {
            const len = $(this).val().length;
            const c = $('#charCounterTemuan');
            c.text(len + ' / 2000 karakter').removeClass('warn over');
            if (len > 1800) c.addClass('over');
            else if (len > 1500) c.addClass('warn');
        });

        // Char counter for penyelesaian
        const initLenPenyelesaian = $('#penyelesaian').val().length;
        $('#charCounterPenyelesaian').text(initLenPenyelesaian + ' / 2000 karakter');

        $('#penyelesaian').on('input', function() {
            const len = $(this).val().length;
            const c = $('#charCounterPenyelesaian');
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