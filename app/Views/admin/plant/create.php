<?= $this->extend('templates/index'); ?>
<?php $this->section('page-content'); ?>

<style>
    .edit-header {
        background: linear-gradient(135deg, #1a237e 0%, #283593 60%, #3949ab 100%);
        border-radius: 16px;
        padding: 24px 32px;
        margin-bottom: 28px;
        display: flex;
        align-items: center;
        gap: 16px;
        box-shadow: 0 8px 32px rgba(26, 35, 126, 0.18);
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
        background: #f8f9ff;
        border-bottom: 1px solid #eef0ff;
        padding: 18px 28px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .form-card .card-header .section-icon {
        width: 32px;
        height: 32px;
        background: linear-gradient(135deg, #1a237e, #3949ab);
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
        color: #1a237e;
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
        margin-bottom: 6px;
    }

    .form-control-k3 {
        border: 1.5px solid #e0e0e0;
        border-radius: 10px;
        padding: 10px 14px;
        font-size: .875rem;
        width: 100%;
        transition: .2s;
    }

    .form-control-k3:focus {
        border-color: #5c6bc0;
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

    .toggle-wrapper {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .toggle-switch {
        position: relative;
        width: 48px;
        height: 26px;
    }

    .toggle-switch input {
        display: none;
    }

    .toggle-slider {
        position: absolute;
        inset: 0;
        background: #e0e0e0;
        border-radius: 13px;
        cursor: pointer;
    }

    .toggle-slider:before {
        content: '';
        position: absolute;
        left: 3px;
        top: 3px;
        width: 20px;
        height: 20px;
        background: #fff;
        border-radius: 50%;
        transition: .2s;
    }

    .toggle-switch input:checked~.toggle-slider {
        background: #1C2580;
    }

    .toggle-switch input:checked~.toggle-slider:before {
        transform: translateX(22px);
    }

    .btn-save {
        background: #283593;
        color: #fff;
        border: none;
        border-radius: 10px;
        padding: 10px 24px;
        font-weight: 700;
        font-size: .85rem;
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
</style>

<div class="container-fluid pb-4">

    <?php
    $errors = session('errors') ?? [];
    ?>

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


    <!-- header -->
    <div class="edit-header">
        <a href="<?= base_url('admin/plant') ?>" class="back-btn">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h1>Tambah Plant</h1>
            <p>Tambahkan data plant baru untuk sistem</p>
        </div>
    </div>

    <div class="card form-card">
        <div class="card-header">
            <div class="section-icon">
                <i class="fa fa-building"></i>
            </div>
            <h6>Informasi Plant</h6>
        </div>

        <div class="card-body">
            <form action="<?= base_url('admin/plant/store') ?>" method="post">
                <?= csrf_field() ?>

                <div class="row">
                    <!-- nama plant -->
                    <div class="col-md-6 mb-4">
                        <label class="form-label-k3">Nama Plant</label>
                        <input type="text" name="nama_plant"
                            class="form-control-k3 <?= isset($errors['nama_plant']) ? 'is-invalid' : '' ?>"
                            value="<?= old('nama_plant') ?>"
                            placeholder="Krian" required>

                        <?php if (isset($errors['nama_plant'])) : ?>
                            <div class="invalid-feedback-k3"><?= $errors['nama_plant'] ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- kode plant -->
                    <div class="col-md-6 mb-4">
                        <label class="form-label-k3">Kode Plant</label>
                        <input type="text" name="kode_plant"
                            class="form-control-k3 <?= isset($errors['kode_plant']) ? 'is-invalid' : '' ?>"
                            value="<?= old('kode_plant') ?>"
                            placeholder="1000" required>

                        <?php if (isset($errors['kode_plant'])) : ?>
                            <div class="invalid-feedback-k3"><?= $errors['kode_plant'] ?></div>
                        <?php endif; ?>
                    </div>
                </div>


                <div class="d-flex" style="gap:10px">
                    <button type="submit" class="btn-save">
                        <i class="fas fa-save mr-1"></i> Simpan
                    </button>

                    <a href="<?= base_url('admin/plant') ?>" class="btn-cancel">
                        Batal
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>

<?php $this->endSection(); ?>