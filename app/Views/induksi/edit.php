<?= $this->extend('templates/index'); ?>
<?php $this->section('page-content'); ?>

<style>
    .edit-header {
        background: #283593;
        border-radius: 16px;
        padding: 24px 32px;
        margin-bottom: 28px;
        display: flex;
        align-items: center;
        gap: 16px;
        box-shadow: 0 8px 32px rgba(0, 77, 64, 0.18);
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

    /* Current doc */
    .current-doc {
        display: flex;
        align-items: center;
        gap: 10px;
        background: #e0f2f1;
        border-radius: 10px;
        padding: 10px 14px;
        margin-bottom: 10px;
    }

    .current-doc .cd-icon {
        font-size: 1.2rem;
        color: #00695c;
    }

    .current-doc .cd-name {
        font-weight: 600;
        font-size: .85rem;
        color: #004d40;
    }

    .current-doc .cd-hint {
        font-size: .72rem;
        color: #9e9e9e;
    }

    .current-doc .cd-preview {
        margin-left: auto;
        color: #00695c;
        font-size: .8rem;
        font-weight: 600;
        text-decoration: none;
    }

    .current-doc .cd-preview:hover {
        color: #004d40;
    }

    .upload-zone {
        border: 2px dashed #b2dfdb;
        border-radius: 12px;
        padding: 24px 20px;
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
        color: #b2dfdb;
        margin-bottom: 6px;
        display: block;
    }

    .upload-zone .upload-text {
        font-weight: 600;
        color: #00695c;
        font-size: .85rem;
    }

    .upload-zone .upload-hint {
        font-size: .72rem;
        color: #9e9e9e;
        margin-top: 3px;
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

    .file-preview .fp-icon {
        font-size: 1.4rem;
        color: #00695c;
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

    .file-preview-multi {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
    }

    .file-item {
        position: relative;
        width: 100px;
        height: 100px;
    }

    .file-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 10px;
    }

    .file-item button {
        position: absolute;
        top: -6px;
        right: -6px;
        background: #e53935;
        color: #fff;
        border: none;
        width: 22px;
        height: 22px;
        border-radius: 50%;
        font-size: 12px;
        cursor: pointer;
    }

    .file-item button:hover {
        background: #c62828;
    }

    .section-title {
        font-size: .85rem;
        font-weight: 700;
        color: #283593;
        margin-bottom: 10px;
        margin-top: 10px;
    }

    .upload-zone {
        margin-top: 10px;
    }
</style>

<div class="container-fluid pb-4">

    <!-- HEADER -->
    <div class="edit-header">
        <a href="<?= base_url('induksi') ?>" class="back-btn">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h1>Edit Data Induksi</h1>
            <p>Mengubah data induksi tanggal <?= date('d M Y', strtotime($induksi->tanggal_induksi)) ?></p>
        </div>
    </div>

    <div class="card form-card">

        <div class="card-header">
            <div class="section-icon"><i class="fas fa-edit"></i></div>
            <h6>Form Edit Induksi</h6>
        </div>

        <div class="card-body">
            <form action="<?= base_url('induksi/update/' . $induksi->id) ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>

                <div class="row">
                    <div class="col-md-4 mb-4">
                        <label class="form-label-k3">Tanggal</label>
                        <input type="date" name="tanggal_induksi"
                            class="form-control-k3"
                            value="<?= old('tanggal_induksi', $induksi->tanggal_induksi) ?>">
                    </div>

                    <div class="col-md-4 mb-4">
                        <label class="form-label-k3">Jumlah Peserta</label>
                        <input type="number" name="jumlah_peserta"
                            class="form-control-k3"
                            value="<?= old('jumlah_peserta', $induksi->jumlah_peserta) ?>">
                    </div>
                </div>

                <!-- KETERANGAN -->
                <div class="mb-4">
                    <label class="form-label-k3">Keterangan</label>
                    <textarea name="keterangan" id="keteranganInput" rows="4"
                        class="form-control-k3"><?= old('keterangan', $induksi->keterangan) ?></textarea>
                    <div class="char-counter" id="charCounter"></div>
                </div>




                <div class="mt-4">

                    <div class="section-title">Foto Dokumentasi</div>
                    <div style="margin-bottom:8px;font-size:.78rem;color:#616161;">
                        Klik tombol × untuk menghapus gambar
                    </div>

                    <!-- SATU CONTAINER -->
                    <div class="file-preview-multi mb-3" id="dokumentasiContainer">

                        <!-- GAMBAR LAMA -->
                        <?php if (!empty($documentations)) : ?>
                            <?php foreach ($documentations as $documentation) : ?>
                                <div class="file-item existing-file" data-id="<?= $documentation->id ?>">
                                    <img src="<?= base_url('uploads/induksi/' . $documentation->filename) ?>">
                                    <button type="button" class="remove-existing-file">×</button>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>

                    </div>

                    <!-- UPLOAD -->
                    <div class="upload-zone">
                        <input type="file" name="dokumentasi[]" id="inputD" multiple accept=".jpg,.jpeg,.png">
                        <i class="fas fa-cloud-upload-alt upload-icon"></i>
                        <div class="upload-text">Upload dokumentasi</div>
                    </div>

                </div>

                <!-- ABSENSI -->
                <div class="mt-4">

                    <div class="section-title">Foto Absensi</div>
                    <div style="margin-bottom:8px;font-size:.78rem;color:#616161;">
                        Klik tombol × untuk menghapus gambar
                    </div>

                    <!-- SATU CONTAINER -->
                    <div class="file-preview-multi mb-3" id="absensiContainer">

                        <!-- GAMBAR LAMA -->
                        <?php if (!empty($absensi)) : ?>
                            <?php foreach ($absensi as $documentation) : ?>
                                <div class="file-item existing-file" data-id="<?= $documentation->id ?>">
                                    <img src="<?= base_url('uploads/induksi/' . $documentation->filename) ?>">
                                    <button type="button" class="remove-existing-file">×</button>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>

                    </div>

                    <!-- UPLOAD -->
                    <div class="upload-zone">
                        <input type="file" name="absensi[]" id="inputA" multiple accept=".jpg,.jpeg,.png">
                        <i class="fas fa-cloud-upload-alt upload-icon"></i>
                        <div class="upload-text">Upload absensi</div>
                    </div>

                </div>

                <button class="btn-save mt-2">Simpan</button>

            </form>
        </div>
    </div>
</div>
<?php $this->endSection(); ?>


<?php $this->section('scripts'); ?>
<script>
    $(document).ready(function() {

        function setupMultiPreview(inputId, containerId) {
            const input = document.getElementById(inputId);
            const container = document.getElementById(containerId);

            let fileStore = [];

            input.addEventListener('change', function(e) {
                fileStore = Array.from(e.target.files);
                renderPreview();
            });

            function renderPreview() {

                // ambil existing dulu
                const existing = container.querySelectorAll('.existing-file');

                // reset container
                container.innerHTML = '';

                // balikin existing
                existing.forEach(el => container.appendChild(el));

                // tambahkan file baru
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
                        container.appendChild(wrapper);
                    };

                    reader.readAsDataURL(file);
                });
            }

            function updateInputFiles() {
                const dt = new DataTransfer();
                fileStore.forEach(f => dt.items.add(f));
                input.files = dt.files;
            }
        }

        setupMultiPreview('inputD', 'dokumentasiContainer');
        setupMultiPreview('inputA', 'absensiContainer');

        const dokumentasiContainer = document.getElementById('dokumentasiContainer');

        if (dokumentasiContainer) {
            dokumentasiContainer.addEventListener('click', function(e) {
                if (!e.target.classList.contains('remove-existing-file')) return;

                const fileItem = e.target.closest('.file-item');
                const fileId = fileItem?.dataset?.id;

                if (!fileId) return;

                const hidden = document.createElement('input');
                hidden.type = 'hidden';
                hidden.name = 'delete_dokumentasi_ids[]';
                hidden.value = fileId;
                document.querySelector('form').appendChild(hidden);

                fileItem.remove();
            });
        }

        const absensiContainer = document.getElementById('absensiContainer');

        if (absensiContainer) {
            absensiContainer.addEventListener('click', function(e) {
                if (!e.target.classList.contains('remove-existing-file')) return;

                const fileItem = e.target.closest('.file-item');
                const fileId = fileItem?.dataset?.id;

                if (!fileId) return;

                const hidden = document.createElement('input');
                hidden.type = 'hidden';
                hidden.name = 'delete_absensi_ids[]';
                hidden.value = fileId;
                document.querySelector('form').appendChild(hidden);

                fileItem.remove();
            });
        }

        // char counter
        const textarea = $('#keteranganInput');
        const counter = $('#charCounter');

        function updateCounter() {
            const len = textarea.val().length;
            counter.text(len + ' / 1000');
        }

        textarea.on('input', updateCounter);
        updateCounter();
    });
</script>
<?php $this->endSection(); ?>