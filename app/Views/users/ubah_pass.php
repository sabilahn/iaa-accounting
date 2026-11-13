<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>IAA Accounting | Ubah Password</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="<?= base_url('assets/stisla/vendors/bootstrap/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/stisla/vendors/fontawesome/css/all.min.css') ?>">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="<?= base_url('assets/stisla/vendors/bootstrap-social/bootstrap-social.css') ?>">

    <!-- Template CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/stisla/build/css/style.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/stisla/build/css/components.css') ?>">
    <!-- Start GA -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-94034622-3');
    </script>
    <!-- /END GA -->
    <style>
        body {
            background-image: url('<?= base_url('assets/stisla/images/bg-lg.png') ?>');
            background-size: cover;
        }
    </style>
</head>

<body>
    <div id="app">
        <section class="section">
            <div class="container mt-5">
                <div class="row">
                    <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                        <h2 class="text-center" style="color: #116754;"><i class="fa fa-key" style="color: rgba(0, 0, 0, 0.4)"></i> Ubah Password</h2><br>

                        <div class="card card-primary">
                            <div class="card-body">
                                <?php if (session()->getFlashdata('error')) : ?>
                                    <div class="alert alert-danger alert-dismissible show fade">
                                        <div class="alert-body">
                                            <button class="close" data-dismiss="alert">
                                                <span>&times;</span>
                                            </button>
                                            <?= session()->getFlashdata('error'); ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <?php if (session()->getFlashdata('error1')) : ?>
                                    <div class="alert alert-danger alert-dismissible show fade">
                                        <div class="alert-body">
                                            <button class="close" data-dismiss="alert">
                                                <span>&times;</span>
                                            </button>
                                            <?= session()->getFlashdata('error1'); ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <form action="<?= site_url('auth/update_password') ?>" method="POST">
                                    <div class="form-group">
                                        <label for="o_userpass">Password</label>
                                        <input name="o_userpass" id="o_userpass" type="password" class="form-control pwstrength" data-indicator="pwindicator" tabindex="2" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="n_userpass">Password Baru</label>
                                        <input name="n_userpass" id="n_userpass" type="password" class="form-control pwstrength" data-indicator="pwindicator" tabindex="2" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="c_userpass">Konfirmasi Password</label>
                                        <input name="c_userpass" id="c_userpass" type="password" class="form-control" tabindex="2" required>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4" id="ubah_password">
                                            Simpan
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="simple-footer">
                            Copyright &copy; Stisla 2018
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- General JS Scripts -->
    <script src="<?= base_url('assets/stisla/vendors/jquery.min.js') ?>"></script>
    <script src="<?= base_url('assets/stisla/vendors/popper.js') ?>"></script>
    <script src="<?= base_url('assets/stisla/vendors/tooltip.js') ?>"></script>
    <script src="<?= base_url('assets/stisla/vendors/bootstrap/js/bootstrap.min.js') ?>"></script>
    <script src="<?= base_url('assets/stisla/vendors/nicescroll/jquery.nicescroll.min.js') ?>"></script>
    <script src="<?= base_url('assets/stisla/vendors/moment.min.js') ?>"></script>
    <script src="<?= base_url('assets/stisla/build/js/stisla.js') ?>"></script>

    <!-- Template JS File -->
    <script src="<?= base_url('assets/stisla/build/js/scripts.js') ?>"></script>
    <script src="<?= base_url('assets/stisla/build/js/custom.js') ?>"></script>
</body>

</html>

