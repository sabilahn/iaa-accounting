<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title><?= $title ?></title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/stisla/vendors/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/stisla/vendors/fontawesome/css/all.min.css">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/stisla/vendors/bootstrap-social/bootstrap-social.css">

  <!-- Template CSS -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/stisla/build/css/style.css">
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/stisla/build/css/components.css">
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

            <h2 class="text-center" style="color: #116754;"><i class="fa fa-lock" style="color: rgba(0, 0, 0, 0.4)"></i> IAA Accounting</h2>
            </h5><br>

            <div class="card card-primary">
              <div class="card-header">
                <h4>Login</h4>
              </div>
              <div class="card-body">
                <?php if ($this->session->flashdata('gagal')) : ?>
                  <div class="alert alert-danger alert-dismissible show fade">
                    <div class="alert-body">
                      <button class="close" data-dismiss="alert">
                        <span>&times;</span>
                      </button>
                      <?= $this->session->flashdata('gagal'); ?>
                    </div>
                  </div>
                <?php endif; ?>
                <form method="POST" action="<?= site_url('auth/login') ?>" class="needs-validation">
                  <div class="form-group">
                    <label>Username</label>
                    <select id="username" type="text" class="form-control select" name="username" tabindex="1" required="" autofocus>
                      <option value="">--Pilih Username--</option>
                      <!-- <option value="operator">Operator</option>
                      <option value="manager">Manager</option>
                      <option value="administrator">Administrator</option> -->

                      <?php
                      foreach ($user_list as $user) {
                        // var_dump($user);
                        // die; 
                      ?>
                        <option value="<?= $user['username'] ?>"><?= ucwords($user['username']) ?></option>
                      <?php }
                      ?>
                    </select>
                  </div>

                  <div class="form-group">
                    <!-- <div class="d-block"> -->
                    <label>Password</label>
                    <!-- </div> -->
                    <input id="userpass" type="password" class="form-control" name="userpass" tabindex="2" required="">
                  </div>
                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4"><i class="fas fa-key"></i>
                      Login
                    </button>
                  </div>
                </form>

              </div>
            </div>
            <div class="simple-footer">
              Copyright &copy; True Tech Solution
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>


  <!-- General JS Scripts -->
  <script src="<?php echo base_url() ?>assets/stisla/vendors/jquery.min.js"></script>
  <script src="<?php echo base_url() ?>assets/stisla/vendors/popper.js"></script>
  <script src="<?php echo base_url() ?>assets/stisla/vendors/tooltip.js"></script>
  <script src="<?php echo base_url() ?>assets/stisla/vendors/bootstrap/js/bootstrap.min.js"></script>
  <script src="<?php echo base_url() ?>assets/stisla/vendors/nicescroll/jquery.nicescroll.min.js"></script>
  <script src="<?php echo base_url() ?>assets/stisla/vendors/moment.min.js"></script>
  <script src="<?php echo base_url() ?>assets/stisla/build/js/stisla.js"></script>

  <!-- JS Libraies -->

  <!-- Page Specific JS File -->

  <!-- Template JS File -->
  <script src="<?php echo base_url() ?>assets/stisla/build/js/scripts.js"></script>
  <script src="<?php echo base_url() ?>assets/stisla/build/js/custom.js"></script>
</body>

</html>