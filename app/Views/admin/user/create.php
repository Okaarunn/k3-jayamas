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

    .avatar-preview.default {
        background: linear-gradient(135deg, #546e7a, #78909c);
    }

    .avatar-label {
        font-size: .72rem;
        color: #9e9e9e;
        text-align: center;
        text-transform: uppercase;
        letter-spacing: .8px;
    }

    .avatar-hint {
        font-size: .72rem;
        color: #bdbdbd;
        text-align: center;
        margin-top: 6px;
        font-style: italic;
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

    .invalid-feedback-k3 {
        font-size: .78rem;
        color: #c62828;
        margin-top: 4px;
    }

    /* Tambahkan ini di dalam <style> yang sudah ada */
    .password-wrapper {
        position: relative;
        display: block;
    }

    .password-toggle {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #9e9e9e;
        cursor: pointer;
        padding: 4px;
        font-size: .85rem;
        transition: color .15s;
        z-index: 10;
        /* tambahkan ini */
        line-height: 1;
    }

    .password-toggle:hover {
        color: #3949ab;
    }

    .strength-bar {
        height: 4px;
        border-radius: 2px;
        margin-top: 8px;
        background: #e0e0e0;
        overflow: hidden;
    }

    .strength-fill {
        height: 100%;
        border-radius: 2px;
        width: 0%;
        transition: width .3s, background .3s;
    }

    .strength-text {
        font-size: .72rem;
        margin-top: 4px;
        color: #9e9e9e;
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

    /* New badge on avatar card */
    .new-badge {
        display: inline-block;
        background: linear-gradient(135deg, #1a237e, #3949ab);
        color: #fff;
        font-size: .65rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .8px;
        padding: 3px 10px;
        border-radius: 20px;
        margin-top: 12px;
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

    <?php if (session()->getFlashdata('errors')) : ?>
        <div style="background:#fce4ec;color:#c62828;border-radius:12px;padding:14px 18px;margin-bottom:20px;display:flex;align-items:center;gap:10px;font-size:.875rem">
            <i class="fas fa-exclamation-circle"></i>
            <?php foreach (session()->getFlashdata('errors') as $err) : ?>
                <div><?= $err ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- Header -->
    <div class="edit-header">
        <a href="<?= base_url('admin/users') ?>" class="back-btn">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h1>Tambah Pengguna</h1>
            <p>Buat akun baru dan tentukan hak akses pengguna</p>
        </div>
    </div>

    <div class="row">
        <!-- Left: Avatar Preview -->
        <div class="col-lg-3 mb-4">
            <div class="card form-card">
                <div class="card-body text-center py-4">
                    <div class="avatar-preview default" id="avatarPreview">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="avatar-label" id="roleLabel">Belum dipilih</div>
                    <div class="avatar-hint">Preview akan berubah saat Anda mengisi form</div>
                    <div class="new-badge">Pengguna Baru</div>
                </div>
            </div>
        </div>

        <!-- Right: Form -->
        <div class="col-lg-9 mb-4">
            <div class="card form-card">
                <div class="card-header">
                    <div class="section-icon"><i class="fas fa-user-plus"></i></div>
                    <h6>Informasi Akun Baru</h6>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('admin/users/store') ?>" method="post" id="createForm">
                        <?= csrf_field() ?>

                        <div class="row">
                            <!-- Username -->
                            <div class="col-md-6 mb-4">
                                <label class="form-label-k3">Username</label>
                                <input type="text" name="username" id="usernameInput"
                                    class="form-control-k3 <?= isset($errors['username']) ? 'is-invalid' : '' ?>"
                                    value="<?= old('username') ?>"
                                    placeholder="contoh: k3_budi" required>
                                <?php if (isset($errors['username'])) : ?>
                                    <div class="invalid-feedback-k3">
                                        <i class="fas fa-exclamation-circle mr-1"></i><?= $errors['username'] ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Email -->
                            <div class="col-md-6 mb-4">
                                <label class="form-label-k3">Email</label>
                                <input type="email" name="email"
                                    class="form-control-k3 <?= isset($errors['email']) ? 'is-invalid' : '' ?>"
                                    value="<?= old('email') ?>"
                                    placeholder="nama@perusahaan.com" required>
                                <?php if (isset($errors['email'])) : ?>
                                    <div class="invalid-feedback-k3">
                                        <i class="fas fa-exclamation-circle mr-1"></i><?= $errors['email'] ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- plant -->
                        <div class="row">
                            <!-- Plant -->
                            <div class="col-md-6 mb-4">
                                <label class="form-label-k3">Plant</label>
                                <select name="plant_id" required
                                    class="form-control-k3 <?= isset($errors['plant_id']) ? 'is-invalid' : '' ?>">
                                    <option value="" disabled selected>Pilih Plant</option>
                                    <?php foreach ($plants as $plant) : ?>
                                        <option class="capitalize" value="<?= $plant->id ?>"
                                            <?= old('plant_id') == $plant->id ? 'selected' : '' ?>>
                                            <?= esc(ucwords(strtolower($plant->nama_plant))) ?>
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

                        <div class="row">
                            <!-- Password -->
                            <div class="col-md-6 mb-4">
                                <label class="form-label-k3">Password</label>
                                <div class="password-wrapper">
                                    <input type="password" name="password" id="passwordInput"
                                        class="form-control-k3 <?= isset($errors['password']) ? 'is-invalid' : '' ?>"
                                        placeholder="Min. 8 karakter" required minlength="8"
                                        style="padding-right: 40px">
                                    <button type="button" class="password-toggle" id="togglePassword">
                                        <i class="fas fa-eye" id="togglePasswordIcon"></i>
                                    </button>
                                </div>
                                <div class="strength-bar">
                                    <div class="strength-fill" id="strengthFill"></div>
                                </div>
                                <div class="strength-text" id="strengthText">Masukkan password</div>
                                <?php if (isset($errors['password'])) : ?>
                                    <div class="invalid-feedback-k3">
                                        <i class="fas fa-exclamation-circle mr-1"></i><?= $errors['password'] ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Konfirmasi Password -->
                            <div class="col-md-6 mb-4">
                                <label class="form-label-k3">Konfirmasi Password</label>
                                <div class="password-wrapper">
                                    <input type="password" name="confirm_password" id="confirmInput"
                                        class="form-control-k3 <?= isset($errors['confirm_password']) ? 'is-invalid' : '' ?>"
                                        placeholder="Ulangi password" required minlength="8"
                                        style="padding-right: 40px">
                                    <button type="button" class="password-toggle" id="toggleConfirm">
                                        <i class="fas fa-eye" id="toggleConfirmIcon"></i>
                                    </button>
                                </div>
                                <div class="strength-text" id="matchText"></div>
                                <?php if (isset($errors['confirm_password'])) : ?>
                                    <div class="invalid-feedback-k3">
                                        <i class="fas fa-exclamation-circle mr-1"></i><?= $errors['confirm_password'] ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Role Selector -->
                        <div class="mb-4">
                            <label class="form-label-k3">Role Pengguna</label>
                            <div class="role-selector">

                                <input type="radio" name="role" id="role_admin" class="role-option"
                                    value="administrator" <?= old('role') === 'administrator' ? 'checked' : '' ?>>
                                <label for="role_admin">
                                    <span class="role-icon admin-icon"><i class="fas fa-shield-alt"></i></span>
                                    <div>
                                        <div>Administrator</div>
                                        <div style="font-size:.72rem;font-weight:400;color:#9e9e9e">Akses penuh</div>
                                    </div>
                                </label>

                                <input type="radio" name="role" id="role_editor" class="role-option"
                                    value="editor" <?= old('role') === 'editor' ? 'checked' : '' ?>>
                                <label for="role_editor">
                                    <span class="role-icon editor-icon"><i class="fas fa-pen"></i></span>
                                    <div>
                                        <div>Editor</div>
                                        <div style="font-size:.72rem;font-weight:400;color:#9e9e9e">CRUD data</div>
                                    </div>
                                </label>

                                <input type="radio" name="role" id="role_viewer" class="role-option"
                                    value="viewer" <?= old('role') === 'viewer' ? 'checked' : '' ?>>
                                <label for="role_viewer">
                                    <span class="role-icon viewer-icon"><i class="fas fa-eye"></i></span>
                                    <div>
                                        <div>Viewer</div>
                                        <div style="font-size:.72rem;font-weight:400;color:#9e9e9e">Lihat & export</div>
                                    </div>
                                </label>

                            </div>
                            <?php if (isset($errors['role'])) : ?>
                                <div class="invalid-feedback-k3 mt-2">
                                    <i class="fas fa-exclamation-circle mr-1"></i><?= $errors['role'] ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Status -->
                        <div class="mb-4">
                            <label class="form-label-k3">Status Akun</label>
                            <div class="toggle-wrapper">
                                <label class="toggle-switch">
                                    <input type="checkbox" name="is_active" id="statusToggle" value="1" checked>
                                    <span class="toggle-slider"></span>
                                </label>
                                <span class="toggle-label" id="statusLabel">Aktif</span>
                            </div>
                        </div>

                        <div class="divider"></div>

                        <!-- Action Buttons -->
                        <div class="d-flex align-items-center" style="gap:12px">
                            <button type="submit" class="btn-save">
                                <i class="fas fa-user-plus mr-2"></i>Buat Pengguna
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

<?php $this->endSection(); ?>

<?php $this->section('scripts'); ?>
<script>
    $(document).ready(function() {

        // Avatar preview — update inisial dari username
        $('#usernameInput').on('input', function() {
            const val = $(this).val().trim();
            if (val.length >= 1) {
                $('#avatarPreview').html(val.substring(0, 2).toUpperCase());
            } else {
                $('#avatarPreview').html('<i class="fas fa-user"></i>');
            }
        });

        // Role change → update avatar warna & label
        $('input[name="role"]').on('change', function() {
            const role = $(this).val();
            const labels = {
                administrator: 'Administrator',
                editor: 'Editor',
                viewer: 'Viewer'
            };
            $('#avatarPreview').removeClass('default administrator editor viewer').addClass(role);
            $('#roleLabel').text(labels[role] || role);
        });

        // Trigger role jika ada old input (saat validasi gagal)
        const checkedRole = $('input[name="role"]:checked').val();
        if (checkedRole) {
            const labels = {
                administrator: 'Administrator',
                editor: 'Editor',
                viewer: 'Viewer'
            };
            $('#avatarPreview').removeClass('default').addClass(checkedRole);
            $('#roleLabel').text(labels[checkedRole]);
        }

        // Status toggle label
        $('#statusToggle').on('change', function() {
            $('#statusLabel').text($(this).is(':checked') ? 'Aktif' : 'Nonaktif');
        });

        // Toggle show/hide password
        $('#togglePassword').on('click', function() {
            const input = $('#passwordInput');
            const icon = $('#togglePasswordIcon');
            input.attr('type', input.attr('type') === 'password' ? 'text' : 'password');
            icon.toggleClass('fa-eye fa-eye-slash');
        });

        $('#toggleConfirm').on('click', function() {
            const input = $('#confirmInput');
            const icon = $('#toggleConfirmIcon');
            input.attr('type', input.attr('type') === 'password' ? 'text' : 'password');
            icon.toggleClass('fa-eye fa-eye-slash');
        });

        // Password strength meter
        $('#passwordInput').on('input', function() {
            const val = $(this).val();
            let score = 0;
            if (val.length >= 8) score++;
            if (/[A-Z]/.test(val)) score++;
            if (/[0-9]/.test(val)) score++;
            if (/[^A-Za-z0-9]/.test(val)) score++;

            const levels = [{
                    width: '0%',
                    color: '#e0e0e0',
                    text: 'Masukkan password',
                    textColor: '#9e9e9e'
                },
                {
                    width: '25%',
                    color: '#c62828',
                    text: 'Lemah',
                    textColor: '#c62828'
                },
                {
                    width: '50%',
                    color: '#f57c00',
                    text: 'Cukup',
                    textColor: '#f57c00'
                },
                {
                    width: '75%',
                    color: '#fbc02d',
                    text: 'Baik',
                    textColor: '#fbc02d'
                },
                {
                    width: '100%',
                    color: '#388e3c',
                    text: 'Kuat',
                    textColor: '#388e3c'
                },
            ];

            const level = val.length === 0 ? levels[0] : levels[score];
            $('#strengthFill').css({
                width: level.width,
                background: level.color
            });
            $('#strengthText').text(level.text).css('color', level.textColor);
            checkMatch();
        });

        // Password match check
        function checkMatch() {
            const pass = $('#passwordInput').val();
            const confirm = $('#confirmInput').val();
            if (confirm.length === 0) {
                $('#matchText').text('').css('color', '#9e9e9e');
                return;
            }
            if (pass === confirm) {
                $('#matchText').html('<i class="fas fa-check-circle mr-1"></i>Password cocok').css('color', '#388e3c');
                $('#confirmInput').css('border-color', '#388e3c');
            } else {
                $('#matchText').html('<i class="fas fa-times-circle mr-1"></i>Password tidak cocok').css('color', '#c62828');
                $('#confirmInput').css('border-color', '#c62828');
            }
        }

        $('#confirmInput').on('input', checkMatch);

    });
</script>
<?php $this->endSection(); ?>