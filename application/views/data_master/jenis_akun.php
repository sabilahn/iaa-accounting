<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Jenis Akun</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="<?= site_url() ?>dashboard">Dashboard</a></div>
                <div class="breadcrumb-item">Data Master</div>
                <div class="breadcrumb-item">Jenis Akun</div>
            </div>
        </div>
        <div class="section-body">
            <div class="card card-primary">
                <div class="card-header">
                    <h2 class="section-title">Daftar Jenis Akun</h2>
                    <h4></h4>
                    <div class="card-header-action">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#tambahModal"><i class="fas fa-plus"> Tambah Jenis Akun</i></button>
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
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-1">
                                <thead>
                                    <tr class="text-center">
                                        <th>Kode Jenis</th>
                                        <th>Nama Jenis</th>
                                        <th></th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($data_jenis as $jenis) { ?>
                                        <tr>
                                            <td class="text-center"><?= $jenis['kode'] ?></td>
                                            <td><?= $jenis['nama'] ?></td>
                                            <td class="text-center"></td>
                                            <td class="text-center"><?= $jenis['action'] ?></td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
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
                <h5 class="modal-title">Tambah Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= site_url() ?>data_master/tambah_jenis" method="POST">
                <div class="modal-body">
                    <div class="card card-primary">
                        <br>
                        <div class="form-group mb-0">
                            <label>Nomor Kode</label><br>
                            <select name="kode" id="kode" class="form-control select">
                                <option value="">--Pilih Kode--</option>
                                <?php
                                $nama = array(
                                    '1' => 'Aktiva',
                                    '2' => 'Passiva',
                                    '3' => 'Equitas',
                                    '4' => 'Pendapatan',
                                    '5' => 'Biaya'
                                );
                                for ($i = 1; $i <= count($nama); $i++) { ?>
                                    <option value="<?= $i ?>"><?= $i . ' | ' . $nama[$i] ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group mb-0">
                            <label>Kode Jenis</label><br>
                            <input type="number" name="kode_jenis" id="kode_jenis" class="form-control" required>
                        </div>
                        <div class="form-group mb-0">
                            <label>Nama Jenis Akun</label>
                            <input type="text" name="nama_jenis" id="nama_jenis" class="form-control" required>
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
<!-- Update -->
<?php
foreach ($data_jenis as $jenis) :
    $kode_jenis = $jenis['kode'];
?>
    <div class="modal fade" tabindex="-1" role="dialog" id="editModal<?= $kode_jenis ?>">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ubah Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= site_url() ?>data_master/ubah_jenis" method="POST">
                    <div class="modal-body">
                        <div class="card card-primary">
                            <br>
                            <input type="hidden" id="id_jenis" name="id_jenis" value="<?= $jenis['kode'] ?>">
                            <div class="form-group mb-0">
                                <label>Nomor Kode</label><br>
                                <select name="kode_edt" id="kode_edt" class="form-control select">
                                    <option value="">--Pilih Kode--</option>
                                    <?php
                                    $nama = array(
                                        '1' => 'Aktiva',
                                        '2' => 'Passiva',
                                        '3' => 'Equitas',
                                        '4' => 'Pendapatan',
                                        '5' => 'Biaya'
                                    );
                                    for ($i = 1; $i <= count($nama); $i++) { ?>
                                        <option value="<?= $i ?>" <?php if ($jenis['kode_parent'] == $i) {
                                                                        echo "selected";
                                                                    } ?>><?= $i . ' | ' . $nama[$i] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group mb-0">
                                <label>Kode Jenis</label><br>
                                <input type="number" name="kode_jenis_edt" id="kode_jenis_edt" class="form-control" value="<?= $jenis['kode'] ?>" required>
                            </div>
                            <div class="form-group mb-0">
                                <label>Nama Jenis Akun</label>
                                <input type="text" name="nama_jenis_edt" id="nama_jenis_edt" class="form-control" value="<?= $jenis['nama'] ?>" required>
                            </div>
                            <div class="modal-footer bg-whitesmoke br">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Perbarui</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>
<!-- Hapus -->
<?php
foreach ($data_jenis as $jenis) :
    $kode_jenis = $jenis['kode'];
?>
    <div class="modal fade" tabindex="-1" role="dialog" id="hapusModal<?= $kode_jenis ?>">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= site_url() ?>data_master/hapus_jenis" method="POST">
                    <div class="modal-body">
                        <div class="card card-danger">
                            <br>
                            <input type="hidden" name="id_jenis_hps" id="id_jenis_hps" value="<?= $kode_jenis ?>">
                            Yakin untuk menghapus data dengan kode <?= $kode_jenis ?> ?
                        </div>
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>