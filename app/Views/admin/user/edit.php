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

    /* Avatar preview */
    .avatar-preview {
        width: 80px;
        height: 80px;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 1.5rem;
        color: #fff;
        margin: 0 auto 8px;
        transition: all .3s;
    }

    .avatar-preview.administrator {
        background: linear-gradient(135deg, #1a237e, #3949ab);
    }

    .avatar-preview.editor {
        background: linear-gradient(135deg, #00695c, #00897b);
    }

    .avatar-preview.viewer {
        background: linear-gradient(135deg, #e65100, #f57c00);
    }

    .avatar-label {
        font-size: .72rem;
        color: #9e9e9e;
        text-align: center;
        text-transform: uppercase;
        letter-spacing: .8px;
    }

    /* Form fields */
    .form-label-k3 {
        font-size: .75rem;
        font-weight: 700;
        color: #616161;
        text-transform: uppercase;
        letter-spacing: .6px;
        margin-bottom: 6px;
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

    .form-control-k3.is-invalid {
        border-color: #c62828;
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

    /* Role selector */
    .role-selector {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .role-option {
        display: none;
    }

    .role-option+label {
        flex: 1;
        min-width: 120px;
        padding: 14px 16px;
        border: 2px solid #e0e0e0;
        border-radius: 12px;
        cursor: pointer;
        transition: all .2s;
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: .85rem;
        font-weight: 600;
        color: #616161;
    }

    .role-option+label .role-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: .8rem;
        color: #fff;
        flex-shrink: 0;
    }

    .role-icon.admin-icon {
        background: linear-gradient(135deg, #1a237e, #3949ab);
    }

    .role-icon.editor-icon {
        background: linear-gradient(135deg, #00695c, #00897b);
    }

    .role-icon.viewer-icon {
        background: linear-gradient(135deg, #e65100, #f57c00);
    }

    .role-option:checked+label {
        border-color: #3949ab;
        background: #f3f4ff;
        color: #1a237e;
    }

    .role-option[value="editor"]:checked+label {
        border-color: #00897b;
        background: #f0faf9;
        color: #00695c;
    }

    .role-option[value="viewer"]:checked+label {
        border-color: #f57c00;
        background: #fff8f0;
        color: #e65100;
    }

    /* Status toggle */
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
        transition: background .2s;
    }

    .toggle-slider:before {
        content: '';
        position: absolute;
        left: 3px;
        top: 3px;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: #fff;
        transition: transform .2s;
        box-shadow: 0 1px 3px rgba(0, 0, 0, .2);
    }

    .toggle-switch input:checked~.toggle-slider {
        background: #3949ab;
    }

    .toggle-switch input:checked~.toggle-slider:before {
        transform: translateX(22px);
    }

    .toggle-label {
        font-size: .875rem;
        color: #424242;
        font-weight: 500;
    }

    /* Action buttons */
    .btn-save {
        background: linear-gradient(135deg, #1a237e, #3949ab);
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
        box-shadow: 0 4px 16px rgba(57, 73, 171, .35);
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

    select.form-control-k3 {
        appearance: none;
        -webkit-appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%239e9e9e' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 14px center;
        padding-right: 36px;
        cursor: pointer;
    }

    select.form-control-k3:focus {
        border-color: #3949ab;
        box-shadow: 0 0 0 3px rgba(57, 73, 171, .1);
        outline: none;
    }
</style>

<div class="container-fluid pb-4">

    <?php if (session()->getFlashdata('error')) : ?>
        <div style="background:#fce4ec;color:#c62828;border-radius:12px;padding:14px 18px;margin-bottom:20px;display:flex;align-items:center;gap:10px;font-size:.875rem">
            <i class="fas fa-exclamation-circle"></i>
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <!-- Header -->
    <div class="edit-header">
        <a href="<?= base_url('admin/users') ?>" class="back-btn">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h1>Edit Pengguna</h1>
            <p>Mengubah data akun: <strong style="color:#fff"><?= esc($user->username) ?></strong></p>
        </div>
    </div>

    <div class="row">
        <!-- Left: Avatar & Info -->
        <div class="col-lg-3 mb-4">
            <div class="card form-card">
                <div class="card-body text-center py-4">
                    <?php $role = $user->name ?? 'viewer'; ?>
                    <div class="avatar-preview <?= $role ?>" id="avatarPreview">
                        <?= strtoupper(substr($user->username, 0, 2)) ?>
                    </div>
                    <div class="avatar-label" id="roleLabel"><?= ucfirst($role) ?></div>
                    <div class="divider"></div>
                    <div style="font-size:.78rem;color:#9e9e9e;text-transform:uppercase;letter-spacing:.6px;margin-bottom:4px">ID Pengguna</div>
                    <div style="font-size:1rem;font-weight:700;color:#1a237e">#<?= $user->userid ?></div>
                </div>
            </div>
        </div>

        <!-- Right: Form -->
        <div class="col-lg-9 mb-4">
            <div class="card form-card">
                <div class="card-header">
                    <div class="section-icon"><i class="fas fa-user-edit"></i></div>
                    <h6>Informasi Akun</h6>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('admin/users/update/' . $user->userid) ?>" method="post" id="editForm">
                        <?= csrf_field() ?>

                        <div class="row">
                            <!-- Username -->
                            <div class="col-md-6 mb-4">
                                <label class="form-label-k3">Username</label>
                                <input type="text" name="username" class="form-control-k3 <?= isset($errors['username']) ? 'is-invalid' : '' ?>"
                                    value="<?= old('username', $user->username) ?>"
                                    placeholder="Masukkan username" required>
                                <?php if (isset($errors['username'])) : ?>
                                    <div class="invalid-feedback-k3"><i class="fas fa-exclamation-circle mr-1"></i><?= $errors['username'] ?></div>
                                <?php endif; ?>
                            </div>

                            <!-- Email -->
                            <div class="col-md-6 mb-4">
                                <label class="form-label-k3">Email</label>
                                <input type="email" name="email" class="form-control-k3 <?= isset($errors['email']) ? 'is-invalid' : '' ?>"
                                    value="<?= old('email', $user->email) ?>"
                                    placeholder="nama@perusahaan.com" required>
                                <?php if (isset($errors['email'])) : ?>
                                    <div class="invalid-feedback-k3"><i class="fas fa-exclamation-circle mr-1"></i><?= $errors['email'] ?></div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Plant -->
                            <div class="col-md-6 mb-4">
                                <label class="form-label-k3">Plant</label>
                                <select name="plant_id"
                                    class="form-control-k3 <?= isset($errors['plant_id']) ? 'is-invalid' : '' ?>">
                                    <option value="">— Pilih Plant —</option>
                                    <?php foreach ($plants as $plant) : ?>
                                        <option value="<?= $plant->id ?>"
                                            <?= old('plant_id', $user->plant_id) == $plant->id ? 'selected' : '' ?>>
                                            <?= esc($plant->kode_plant) ?> — <?= esc($plant->nama_plant) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <?php if (isset($errors['plant_id'])) : ?>
                                    <div class="invalid-feedback-k3">
                                        <i class="fas fa-exclamation-circle mr-1"></i><?= $errors['plant_id'] ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Role Selector -->
                        <div class="mb-4">
                            <label class="form-label-k3">Role Pengguna</label>
                            <div class="role-selector">

                                <input type="radio" name="role" id="role_admin" class="role-option"
                                    value="administrator" <?= old('role', $role) === 'administrator' ? 'checked' : '' ?>>
                                <label for="role_admin">
                                    <span class="role-icon admin-icon"><i class="fas fa-shield-alt"></i></span>
                                    <div>
                                        <div>Administrator</div>
                                        <div style="font-size:.72rem;font-weight:400;color:#9e9e9e">Akses penuh</div>
                                    </div>
                                </label>

                                <input type="radio" name="role" id="role_editor" class="role-option"
                                    value="editor" <?= old('role', $role) === 'editor' ? 'checked' : '' ?>>
                                <label for="role_editor">
                                    <span class="role-icon editor-icon"><i class="fas fa-pen"></i></span>
                                    <div>
                                        <div>Editor</div>
                                        <div style="font-size:.72rem;font-weight:400;color:#9e9e9e">CRUD data</div>
                                    </div>
                                </label>

                                <input type="radio" name="role" id="role_viewer" class="role-option"
                                    value="viewer" <?= old('role', $role) === 'viewer' ? 'checked' : '' ?>>
                                <label for="role_viewer">
                                    <span class="role-icon viewer-icon"><i class="fas fa-eye"></i></span>
                                    <div>
                                        <div>Viewer</div>
                                        <div style="font-size:.72rem;font-weight:400;color:#9e9e9e">Lihat & export</div>
                                    </div>
                                </label>

                            </div>
                        </div>

                        <!-- Status -->
                        <div class="mb-4">
                            <label class="form-label-k3">Status Akun</label>
                            <div class="toggle-wrapper">
                                <label class="toggle-switch">
                                    <input type="checkbox" name="is_active" id="statusToggle" value="1"
                                        <?= ($user->active ?? 1) ? 'checked' : '' ?>>
                                    <span class="toggle-slider"></span>
                                </label>
                                <span class="toggle-label" id="statusLabel">
                                    <?= ($user->active ?? 1) ? 'Aktif' : 'Nonaktif' ?>
                                </span>
                            </div>
                        </div>

                        <div class="divider"></div>

                        <!-- Action Buttons -->
                        <div class="d-flex align-items-center" style="gap:12px">
                            <button type="submit" class="btn-save">
                                <i class="fas fa-save mr-2"></i>Simpan Perubahan
                            </button>
                            <a href="<?= base_url('admin/users') ?>" class="btn-cancel">
                                Batal
                            </a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

        // Role change → update avatar color & label
        $('input[name="role"]').on('change', function() {
            const role = $(this).val();
            const labels = {
                'administrator': 'Administrator',
                'editor': 'Editor',
                'viewer': 'Viewer'
            };
            $('#avatarPreview').removeClass('administrator editor viewer').addClass(role);
            $('#roleLabel').text(labels[role] || role);
        });

        // Status toggle label
        $('#statusToggle').on('change', function() {
            $('#statusLabel').text($(this).is(':checked') ? 'Aktif' : 'Nonaktif');
        });

    });
</script>

<?php $this->endSection(); ?>