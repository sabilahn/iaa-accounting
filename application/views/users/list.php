<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Daftar User</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="<?= site_url() ?>dashboard">Dashboard</a></div>
                <div class="breadcrumb-item">Setting</div>
                <div class="breadcrumb-item">Daftar User</div>
            </div>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h2 class="section-title">Daftar User</h2>
                <h4></h4>
                <div class="card-header-action">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#tambahModal"><i class="fas fa-plus"> Tambah User</i></button>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <?php if ($this->session->flashdata('success')) : ?>
                        <div class="alert alert-success alert-dismissible show fade">
                            <div class="alert-body text-center">
                                <button class="close" data-dismiss="alert">
                                    <span>&times;</span>
                                </button>
                                <b><?= $this->session->flashdata('success') ?></b>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if ($this->session->flashdata('error')) : ?>
                        <div class="alert alert-danger alert-dismissible show fade">
                            <div class="alert-body text-center">
                                <button class="close" data-dismiss="alert">
                                    <span>&times;</span>
                                </button>
                                <b><?= $this->session->flashdata('error') ?></b>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="table-responsive">
                        <table class="table table-striped" id="table-1">
                            <thead>
                                <tr class="text-center">
                                    <th>Kode</th>
                                    <th>Username</th>
                                    <th>Password</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($user_list as $user) {
                                    if ($user['user_id'] != 'admin') {
                                ?>
                                        <tr>
                                            <td><?= $user['user_id'] ?></td>
                                            <td><?= $user['username'] ?></td>
                                            <td class="text-right"><?= $user['userpass'] ?></td>
                                            <td class="text-center"><?= $user['action'] ?></td>
                                        </tr>
                                <?php
                                    }
                                }
                                ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
    </section>
</div>
<!-- Tambah -->
<div class="modal fade" role="dialog" id="tambahModal">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= site_url() ?>users/tambah" method="POST">
                <div class="modal-body">
                    <div class="card card-primary">
                        <br>
                        <div class="form-group mb-0">
                            <label>Kode</label>
                            <input type="text" name="id_user" id="id_user" class="form-control" required="">
                        </div>
                        <div class="form-group mb-0">
                            <label>Username</label>
                            <input type="text" name="username" id="username" class="form-control" required="">
                        </div>
                        <div class="form-group mb-0">
                            <label>Password</label>
                            <input type="text" name="userpass" id="userpass" class="form-control" required="">
                        </div>
                        <div class="modal-footer bg-whitesmoke br">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Tambah</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Reset -->
<?php
foreach ($user_list as $user) : ?>
    <div class="modal fade" tabindex="-1" role="dialog" id="resetModal<?= $user['user_id'] ?>">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Reset Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= site_url() ?>users/reset" method="POST">
                    <div class="modal-body">
                        <div class="card card-primary">
                            <br>
                            <input type="hidden" name="id_reset" id="id_reset" value="<?= $user['user_id'] ?>">
                            <p>Password akan dikembalikan menjadi <i>12345</i>, yakin untuk melanjutkan ?</p>
                        </div>
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">OK</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>