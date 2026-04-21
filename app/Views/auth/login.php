<?= $this->extend('auth/templates/index'); ?>

<?= $this->section('content'); ?>

<div class="d-flex align-items-center justify-content-center vh-100 bg-light">
    <div class="card shadow border-0" style="max-width:400px; width:100%; border-radius:14px;">
        <div class="card-body p-4">

            <!-- LOGO -->
            <div class="text-center mb-4">
                <div class="bg-primary d-inline-flex align-items-center justify-content-center mb-3"
                    style="width:60px;height:60px;border-radius:12px;">
                    <i class="fas fa-hard-hat text-white"></i>
                </div>
                <h6 class="font-weight-bold text-dark mb-1">Jayamas K3</h6>
                <small class="text-muted">Sistem Manajemen Keselamatan</small>
            </div>

            <?= view('Myth\Auth\Views\_message_block') ?>

            <form action="<?= url_to('login') ?>" method="post" novalidate>
                <?= csrf_field() ?>

                <!-- LOGIN -->
                <div class="form-group">
                    <label class="text-muted mb-1" style="font-size:12px;">Username/Email</label>

                    <input type="text"
                        name="login"
                        class="form-control <?= session('errors.login') ? 'is-invalid' : '' ?>"
                        placeholder="Username / Email"
                        value="<?= old('login') ?>"
                        autofocus
                        required>

                    <?php if (session('errors.login')): ?>
                        <div class="invalid-feedback">
                            <?= session('errors.login') ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- PASSWORD -->
                <div class="form-group position-relative">

                    <label class="text-muted mb-1" style="font-size:12px;">Password</label>

                    <input type="password"
                        name="password"
                        id="passwordInput"
                        class="form-control pr-5 <?= session('errors.password') ? 'is-invalid' : '' ?>"
                        placeholder="Masukkan password"
                        autocomplete="off"
                        required>

                    <!-- icon di dalam input -->
                    <span id="togglePassword"
                        style="position:absolute; right:12px; top:35px; cursor:pointer; color:#6c757d;">
                        <i class="fas fa-eye" id="toggleIcon"></i>
                    </span>

                    <?php if (session('errors.password')): ?>
                        <div class="invalid-feedback d-block">
                            <?= session('errors.password') ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- SUBMIT -->
                <button type="submit" class="btn btn-primary btn-block">
                    Masuk ke Sistem
                </button>
            </form>

            <div class="text-center text-muted mt-4" style="font-size:12px;">
                © <?= date('Y') ?> Jayamas IT Department
            </div>

        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggle = document.getElementById('togglePassword');
        const input = document.getElementById('passwordInput');
        const icon = document.getElementById('toggleIcon');

        toggle.addEventListener('click', function() {
            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';

            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        });
    });
</script>

<?= $this->endSection(); ?>