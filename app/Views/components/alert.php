<style>
    .toast-container {
        position: fixed;
        top: 24px;
        right: 24px;
        z-index: 9999;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .k3-toast {
        min-width: 280px;
        max-width: 340px;
        background: #ffffff;
        border-radius: 14px;
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12);
        display: flex;
        align-items: stretch;
        overflow: hidden;
        transform: translateY(-20px) scale(0.96);
        opacity: 0;
        transition: all .35s cubic-bezier(.4, 0, .2, 1);
        backdrop-filter: blur(6px);
        position: relative;
    }

    .k3-toast.show {
        transform: translateY(0) scale(1);
        opacity: 1;
    }

    .k3-toast.hide {
        transform: translateY(-10px) scale(0.96);
        opacity: 0;
    }

    .k3-toast .accent {
        width: 4px;
    }

    .k3-toast.success .accent {
        background: #22c55e;
    }

    .k3-toast.error .accent {
        background: #ef4444;
    }

    .k3-toast .body {
        padding: 14px 16px;
        display: flex;
        gap: 12px;
        flex: 1;
    }

    .k3-toast .icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.9rem;
    }

    .k3-toast.success .icon {
        background: rgba(34, 197, 94, 0.1);
        color: #16a34a;
    }

    .k3-toast.error .icon {
        background: rgba(239, 68, 68, 0.1);
        color: #dc2626;
    }

    .k3-toast .text {
        flex: 1;
    }

    .k3-toast .title {
        font-size: .85rem;
        font-weight: 600;
        color: #111827;
    }

    .k3-toast .msg {
        font-size: .78rem;
        color: #6b7280;
        margin-top: 2px;
    }

    .k3-toast .close {
        border: none;
        background: none;
        padding: 10px 12px;
        cursor: pointer;
        color: #9ca3af;
        transition: all .2s;
    }

    .k3-toast .close:hover {
        color: #111827;
    }

    .k3-toast .progress {
        position: absolute;
        bottom: 0;
        left: 4px;
        right: 0;
        height: 2px;
        background: rgba(0, 0, 0, 0.05);
    }

    .k3-toast .progress-fill {
        height: 100%;
        background: currentColor;
        opacity: 0.4;
        width: 100%;
    }
</style>

<div id="toastContainer" class="toast-container"></div>

<?php if (session()->getFlashdata('success')) : ?>
    <div id="flashSuccess" data-msg="<?= esc(session()->getFlashdata('success')) ?>" style="display:none"></div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')) : ?>
    <div id="flashError" data-msg="<?= esc(session()->getFlashdata('error')) ?>" style="display:none"></div>
<?php endif; ?>

