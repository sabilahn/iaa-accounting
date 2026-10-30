<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Item Akun</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="<?= site_url() ?>dashboard">Dashboard</a></div>
                <div class="breadcrumb-item">Data Master</div>
                <div class="breadcrumb-item">Item Akun</div>
            </div>
        </div>
        <div class="section-body">
            <div class="card card-primary">
                <div class="card-header">
                    <h2 class="section-title">Daftar Item Akun</h2>
                    <h4></h4>
                    <div class="card-header-action">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#tambahModal"><i class="fas fa-plus"> Tambah Item Akun</i></button>
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
                                        <th>Kode Item</th>
                                        <th>Nama Item</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 0;
                                    foreach ($data_item as $item) {
                                        $no += 1; ?>
                                        <tr>
                                            <td class="text-center"><?= $item['kode_parent'] ?></td>
                                            <td class="text-center"><?= $item['kode'] ?></td>
                                            <td><?= $item['nama'] ?></td>
                                            <td class="text-center"><?= $item['action'] ?></td>
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
            <form action="<?= site_url() ?>data_master/tambah_item" method="POST">
                <div class="modal-body">
                    <div class="card card-primary">
                        <br>
                        <div class="form-group mb-0">
                            <label>Jenis Akun</label><br>
                            <select name="kode" id="kode" class="form-control select2" style="width: 100%;">
                                <option value="">--Pilih Jenis Akun--</option>
                                <?php
                                foreach ($data_jenis as $jenis) { ?>
                                    <option value="<?= $jenis['kode'] ?>"><?= $jenis['kode'] . ' | ' . $jenis['nama'] ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group mb-0">
                            <label>Kode Item</label><br>
                            <input type="number" name="kode_item" id="kode_item" class="form-control" required>
                        </div>
                        <div class="form-group mb-0">
                            <label>Nama Item</label>
                            <input type="text" name="nama_item" id="nama_item" class="form-control" required>
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
foreach ($data_item as $item) :
    $kode_item = $item['kode'];
?>
    <div class="modal fade" tabindex="-1" role="dialog" id="editModal<?= $kode_item ?>">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ubah Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= site_url() ?>data_master/ubah_item" method="POST">
                    <div class="modal-body">
                        <div class="card card-primary">
                            <br>
                            <input type="hidden" id="id_item" name="id_item" value="<?= $item['kode'] ?>">
                            <div class="form-group mb-0">
                                <label>Jenis Akun</label><br>
                                <select name="kode_edt" id="kode_edt" class="form-control select2" style="width: 100%;">
                                    <option value="">--Pilih Jenis Akun--</option>
                                    <?php
                                    foreach ($data_jenis as $jenis) { ?>
                                        <option value="<?= $jenis['kode'] ?>" <?php if ($item['kode_parent'] == $jenis['kode']) {
                                                                                    echo "selected";
                                                                                } ?>><?= $jenis['kode'] . ' | ' . $jenis['nama'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group mb-0">
                                <label>Kode Item</label><br>
                                <input type="number" name="kode_item_edt" id="kode_item_edt" class="form-control" value="<?= $item['kode'] ?>" required>
                            </div>
                            <div class="form-group mb-0">
                                <label>Nama Item Akun</label>
                                <input type="text" name="nama_item_edt" id="nama_item_edt" class="form-control" value="<?= $item['nama'] ?>" required>
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
foreach ($data_item as $item) :
    $kode_item = $item['kode'];
?>
    <div class="modal fade" tabindex="-1" role="dialog" id="hapusModal<?= $kode_item ?>">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= site_url() ?>data_master/hapus_item" method="POST">
                    <div class="modal-body">
                        <div class="card card-danger">
                            <br>
                            <input type="hidden" name="id_item_hps" id="id_item_hps" value="<?= $kode_item ?>">
                            Yakin untuk menghapus data dengan kode <?= $kode_item ?> ?
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