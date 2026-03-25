<?= $this->extend('auth/templates/index'); ?>

<?= $this->section('content'); ?>

<style>
    body {
        background: #f4f6f8;
        min-height: 100vh;
    }

    .auth-wrapper {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .auth-card {
        width: 100%;
        max-width: 400px;
        border-radius: 14px;
        padding: 32px 28px;
        background: #ffffff;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06);
    }

    /* Logo jadi simple, no gradient */
    .auth-logo {
        width: 52px;
        height: 52px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 12px;
    }

    .auth-logo i {
        color: #fff;
        font-size: 1.2rem;
    }

    /* Typography lebih soft */
    .auth-title {
        text-align: center;
        font-weight: 600;
        font-size: 1.05rem;
        color: #263238;
    }

    .auth-sub {
        text-align: center;
        font-size: .75rem;
        color: #90a4ae;
        margin-bottom: 22px;
    }

    /* Input clean */
    .form-control-k3 {
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        padding: 9px 12px;
        font-size: .82rem;
        transition: all .15s;
        width: 100%;
        background: #fafafa;
    }

    .form-control-k3:focus {
        border-color: #00897b;
        background: #fff;
        box-shadow: 0 0 0 2px rgba(0, 137, 123, .08);
        outline: none;
    }

    .form-control-k3.is-invalid {
        border-color: #d32f2f;
    }

    .invalid-feedback-k3 {
        font-size: .72rem;
        color: #d32f2f;
        margin-top: 4px;
    }

    /* Button dibuat flat (no gradient) */
    .btn-login {
        border: none;
        border-radius: 8px;
        padding: 10px;
        font-weight: 600;
        font-size: .85rem;
        color: #fff;
        transition: all .15s;
    }

    /* Icon toggle lebih subtle */
    .password-wrapper {
        position: relative;
    }

    .password-toggle {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #b0bec5;
        cursor: pointer;
    }

    .password-toggle:hover {
        color: #607d8b;
    }

    /* Footer */
    .auth-footer {
        text-align: center;
        font-size: .7rem;
        color: #b0bec5;
        margin-top: 18px;
    }
</style>

<div class="auth-wrapper">
    <div class="auth-card">

        <div class="auth-logo bg-primary">
            <i class="fas fa-hard-hat"></i>
        </div>

        <div class="auth-title">Jayamas K3</div>
        <div class="auth-sub">Sistem Manajemen Keselamatan</div>

        <?= view('Myth\Auth\Views\_message_block') ?>

        <form action="<?= url_to('login') ?>" method="post" novalidate>
            <?= csrf_field() ?>

            <!-- LOGIN -->
            <div class="mb-3">
                <input type="text"
                    name="login"
                    class="form-control-k3 <?= session('errors.login') ? 'is-invalid' : '' ?>"
                    placeholder="Username / Email"
                    value="<?= old('login') ?>"
                    autofocus
                    required>

                <?php if (session('errors.login')): ?>
                    <div class="invalid-feedback-k3">
                        <?= session('errors.login') ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- PASSWORD -->
            <div class="mb-3 password-wrapper">
                <input type="password"
                    name="password"
                    id="passwordInput"
                    class="form-control-k3 <?= session('errors.password') ? 'is-invalid' : '' ?>"
                    placeholder="Password"
                    autocomplete="off"
                    required>

                <button type="button" class="password-toggle" id="togglePassword">
                    <i class="fas fa-eye" id="toggleIcon"></i>
                </button>

                <?php if (session('errors.password')): ?>
                    <div class="invalid-feedback-k3">
                        <?= session('errors.password') ?>
                    </div>
                <?php endif; ?>
            </div>


            <!-- SUBMIT -->
            <button type="submit" class="btn-login w-100 btn-primary">
                Masuk ke Sistem
            </button>
        </form>

        <div class="auth-footer">
            © <?= date('Y') ?> Jayamas IT Department
        </div>

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggle = document.getElementById('togglePassword');
        const input = document.getElementById('passwordInput');
        const icon = document.getElementById('toggleIcon');

        if (toggle) {
            toggle.addEventListener('click', function() {
                const isPassword = input.type === 'password';
                input.type = isPassword ? 'text' : 'password';
                icon.classList.toggle('fa-eye');
                icon.classList.toggle('fa-eye-slash');
            });
        }
    });
</script>

<?= $this->endSection(); ?>