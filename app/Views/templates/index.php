<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title><?= $title; ?></title>



    <!-- Custom fonts for this template-->

    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet" />


    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="<?= base_url(); ?>/css/sb-admin-2.min.css" rel="stylesheet" />

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" />


    <?= $this->renderSection('styles') ?>
</head>

<style>
    .sidebar {
        position: fixed !important;
        top: 0;
        left: 0;
        height: 100vh !important;
        overflow-y: auto;
    }

    #content-wrapper {
        margin-left: 224px;
        /* lebar sidebar SB Admin 2 default */
    }

    body.sidebar-toggled #content-wrapper {
        margin-left: 6.5rem;
        /* saat sidebar dikecilkan */
    }

    @media (max-width: 768px) {
        #content-wrapper {
            margin-left: 0;
        }
    }
</style>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?= $this->include('templates/sidebar.php'); ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?= $this->include('templates/topbar.php'); ?>
                <!-- End of Topbar -->

                <!-- ▼ Konten halaman ▼ -->
                <?= $this->renderSection('page-content'); ?>

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Jayamas IT Department <?= date('Y'); ?></span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button -->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logoutModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    Select "Logout" below if you are ready to end your current session.
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="<?= url_to('logout') ?>">Logout</a>
                </div>
            </div>
        </div>
    </div>


    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Bootstrap 4 (SB Admin 2 compatible) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery Easing -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>

    <!-- SB Admin 2 -->
    <script src="<?= base_url('js/sb-admin-2.min.js') ?>"></script>

    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <?= $this->renderSection('scripts') ?>

    <script>
        const toastTimers = {}

        function escapeHtml(str) {
            return $('<div>').text(str).html();
        }

        function showToast(type, title, msg, duration = 4000) {
            const id = 'toast-' + Date.now() + '-' + Math.random().toString(16).slice(2);
            const icon = type === 'success' ? 'fa-check' : 'fa-xmark';
            $('#toastContainer').append(`
                <div class="k3-toast ${type}" id="${id}">
                    <div class="accent"></div>
                    <div class="body">
                        <div class="icon"><i class="fas ${icon}"></i></div>
                        <div class="text">
                            <div class="title">${escapeHtml(title)}</div>
                            <div class="msg">${escapeHtml(msg)}</div>
                        </div>
                    </div>
                    <button class="close" onclick="closeToast('${id}')"><i class="fas fa-times"></i></button>
                    <div class="progress"><div class="progress-fill" id="prog-${id}"></div></div>
                </div>
            `);
            requestAnimationFrame(() => {
                $(`#${id}`).addClass('show');
            });
            const prog = $(`#prog-${id}`);
            prog.css('transition', `width ${duration}ms linear`);
            setTimeout(() => {
                prog.css('width', '0%');
            }, 50);
            toastTimers[id] = setTimeout(() => closeToast(id), duration);
        }

        function closeToast(id) {
            clearTimeout(toastTimers[id]);
            const el = $(`#${id}`);
            el.removeClass('show').addClass('hide');
            setTimeout(() => {
                el.remove();
                delete toastTimers[id];
            }, 300);
        }

        $(document).on('mouseenter', '.k3-toast', function() {
            clearTimeout(toastTimers[$(this).attr('id')]);
        });
        $(document).on('mouseleave', '.k3-toast', function() {
            const id = $(this).attr('id');
            toastTimers[id] = setTimeout(() => closeToast(id), 2000);
        });

        $(document).ready(function() {
            const success = $('#flashSuccess').data('msg');
            const error = $('#flashError').data('msg');
            if (success) showToast('success', 'Berhasil', success);
            if (error) showToast('error', 'Gagal', error);
        });

        window.toast = showToast;

        function setupFoto(config, themeColor) {
            const {
                inputId,
                zoneId,
                previewId,
                thumbId,
                nameId,
                sizeId,
                removeId
            } = config;

            const $input = $('#' + inputId);
            const $zone = $('#' + zoneId);
            const $preview = $('#' + previewId);

            $input.on('change', function() {
                if (this.files[0]) showPreview(this.files[0]);
            });

            document.getElementById(zoneId).addEventListener('dragover', e => {
                e.preventDefault();
                $zone.addClass('dragover');
            });

            document.getElementById(zoneId).addEventListener('dragleave', () => {
                $zone.removeClass('dragover');
            });

            document.getElementById(zoneId).addEventListener('drop', e => {
                e.preventDefault();
                $zone.removeClass('dragover');

                const file = e.dataTransfer.files[0];
                if (file) {
                    const dt = new DataTransfer();
                    dt.items.add(file);
                    $input[0].files = dt.files;
                    showPreview(file);
                }
            });

            function showPreview(file) {
                if (file.size > 5 * 1024 * 1024) {
                    toast('error', 'File terlalu besar', 'Maksimal 5MB');
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
                    borderColor: themeColor,
                    background: '#e0f2f1'
                });
            }

            $('#' + removeId).on('click', () => {
                $input.val('');
                $preview.removeClass('show');
                $zone.css({
                    borderColor: '#b2dfdb',
                    background: '#f9fdfc'
                });
            });
        }
    </script>

</body>

</html>