<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title><?= $title; ?></title>

    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url(); ?>/css/sb-admin-2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="<?= base_url(); ?>/css/style.css" />

    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }

        .bg-sidebar {
            background: linear-gradient(135deg, #1a237e 0%, #283593 60%, #3949ab 100%) !important;
        }
    </style>

    <?= $this->renderSection('styles') ?>
</head>

<body id="page-top">
    <div id="wrapper">

        <?= $this->include('templates/sidebar.php'); ?>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">

                <?= $this->include('templates/topbar.php'); ?>

                <?= $this->renderSection('page-content'); ?>
            </div>

            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="text-center my-auto">
                        <span>© <?= date('Y'); ?> Jayamas IT Department</span>
                    </div>
                </div>
            </footer>
        </div>

    </div>

    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('js/sb-admin-2.min.js') ?>"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script>
        // Scroll to top button
        $(window).scroll(function() {
            $(this).scrollTop() > 100 ? $('.scroll-to-top').fadeIn() : $('.scroll-to-top').fadeOut();
        });
        $('a.scroll-to-top').on('click', function(e) {
            e.preventDefault();
            $('html, body').animate({
                scrollTop: 0
            }, 400);
        });
    </script>

    <?= $this->renderSection('scripts') ?>

</body>

</html>