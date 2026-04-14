<?= $this->extend('templates/index'); ?>
<?php $this->section('page-content'); ?>

<style>
    .page-header {
        background: #283593;
        border-radius: 16px;
        padding: 28px 32px;
        margin-bottom: 28px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 8px 32px rgba(26, 35, 126, 0.18);
    }

    .page-header h1 {
        color: #fff;
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0;
        letter-spacing: 0.3px;
    }

    .form-card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 2px 20px rgba(0, 0, 0, 0.07);
        overflow: hidden;
    }

    .card-header {
        background: #f8f9ff;
        border: none;
        padding: 20px 24px;
        border-bottom: 1px solid #e8eaf6;
    }

    .card-header h5 {
        margin: 0;
        color: #1a237e;
        font-weight: 700;
    }

    .card-body {
        padding: 30px;
    }

    .form-group {
        margin-bottom: 24px;
    }

    .form-label {
        font-weight: 700;
        color: #212121;
        margin-bottom: 8px;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .form-control {
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        padding: 10px 14px;
        font-size: 0.875rem;
        transition: all .2s;
    }

    .form-control:focus {
        border-color: #5c6bc0;
        box-shadow: 0 0 0 3px rgba(92, 107, 192, 0.1);
        outline: none;
    }

    .invalid-feedback {
        display: block;
        color: #c62828;
        font-size: 0.75rem;
        margin-top: 4px;
    }

    .form-control.is-invalid {
        border-color: #c62828;
    }

    .role-info {
        background: #f8f9ff;
        border: 1px solid #e8eaf6;
        border-radius: 8px;
        padding: 16px;
        margin-bottom: 24px;
    }

    .role-info .info-item {
        display: flex;
        justify-content: space-between;
        padding: 8px 0;
        font-size: 0.875rem;
    }

    .role-info .info-label {
        font-weight: 600;
        color: #5c6bc0;
    }

    .role-info .info-value {
        color: #212121;
    }

    .permissions-section {
        margin-top: 32px;
        padding-top: 32px;
        border-top: 2px solid #e8eaf6;
    }

    .permissions-section h6 {
        color: #1a237e;
        font-weight: 700;
        margin-bottom: 16px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-size: 0.875rem;
    }

    .permissions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 16px;
    }

    .permission-item {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 12px;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        transition: all .2s;
    }

    .permission-item:has(input:checked) {
        background: #e8eaf6;
        border-color: #5c6bc0;
    }

    .permission-item input[type="checkbox"] {
        margin-top: 4px;
        cursor: pointer;
        accent-color: #5c6bc0;
    }

    .permission-info {
        flex: 1;
    }

    .permission-label {
        display: block;
        font-weight: 600;
        color: #212121;
        cursor: pointer;
        font-size: 0.875rem;
    }

    .permission-description {
        display: block;
        font-size: 0.75rem;
        color: #9e9e9e;
        margin-top: 2px;
    }

    .form-actions {
        margin-top: 32px;
        display: flex;
        gap: 12px;
        justify-content: flex-end;
    }

    .btn {
        padding: 10px 22px;
        font-weight: 700;
        font-size: 0.875rem;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        transition: all .2s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-primary {
        background: #283593;
        color: #fff;
    }

    .btn-primary:hover {
        background: #1a237e;
        text-decoration: none;
    }

    .btn-secondary {
        background: #e0e0e0;
        color: #212121;
    }

    .btn-secondary:hover {
        background: #bdbdbd;
        text-decoration: none;
    }

    .alert {
        border-radius: 10px;
        border: none;
        margin-bottom: 20px;
    }

    .alert-danger {
        background: #ffebee;
        color: #c62828;
        padding: 12px 16px;
    }

    .alert-danger ul {
        margin: 8px 0 0 20px;
    }
</style>

<div class="container-fluid">
    <!-- Header -->
    <div class="page-header">
        <h1><?= esc($title) ?></h1>
    </div>

    <!-- Form Card -->
    <div class="card form-card">
        <div class="card-header">
            <h5><i class="fas fa-edit"></i> Edit Informasi Role</h5>
        </div>
        <div class="card-body">
            <!-- Show error alerts if any -->

            <?php if (session()->getFlashdata('errors')) : ?>
                <div style="background:#fce4ec;color:#c62828;border-radius:12px;padding:14px 18px;margin-bottom:20px;display:flex;align-items:center;gap:10px;font-size:.875rem">
                    <i class="fas fa-exclamation-circle"></i>
                    <?php foreach (session()->getFlashdata('errors') as $err) : ?>
                        <div><?= $err ?></div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>


            <form method="POST" action="/admin/roles/update/<?= $role->id ?>">
                <?= csrf_field() ?>



                <!-- Role Name -->
                <div class="form-group">
                    <label for="name" class="form-label">Nama Role</label>
                    <input type="text"
                        id="name"
                        name="name"
                        class="form-control <?= isset($errs['name']) ? 'is-invalid' : '' ?>"
                        value="<?= old('name', $role->name ?? '') ?>"
                        placeholder="Contoh: Manager, Supervisor, Staff"
                        required>
                    <?php if (isset($errs['name'])): ?>
                        <div class="invalid-feedback"><?= $errs['name'] ?></div>
                    <?php endif; ?>
                </div>

                <!-- Role Description -->
                <div class="form-group">
                    <label for="description" class="form-label">Deskripsi Role</label>
                    <textarea id="description"
                        name="description"
                        class="form-control <?= isset($errs['description']) ? 'is-invalid' : '' ?>"
                        rows="3"
                        placeholder="Jelaskan tujuan dan tanggung jawab role ini"><?= old('description', $role->description ?? '') ?></textarea>
                    <?php if (isset($errs['description'])): ?>
                        <div class="invalid-feedback"><?= session()->getFlashdata('errors')['description'] ?></div>
                    <?php endif; ?>
                </div>

                <!-- Permissions Section -->
                <?php if (!empty($permissions)): ?>
                    <div class="permissions-section">
                        <h6><i class="fas fa-key"></i> Izin (Permissions)</h6>
                        <div class="permissions-grid">
                            <?php foreach ($permissions as $permission): ?>
                                <div class="permission-item">
                                    <input type="checkbox"
                                        id="permission_<?= $permission->id ?>"
                                        name="permissions[]"
                                        value="<?= $permission->id ?>"
                                        <?= in_array($permission->id, $rolePermissionIds) ? 'checked' : '' ?>>
                                    <label for="permission_<?= $permission->id ?>" class="permission-info">
                                        <span class="permission-label"><?= esc($permission->name) ?></span>
                                        <span class="permission-description"><?= esc($permission->description ?? '') ?></span>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Form Actions -->
                <div class="form-actions">
                    <a href="/admin/roles" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $this->endSection(); ?>