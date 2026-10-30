<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Uang Masuk</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="<?= site_url() ?>dashboard">Dashboard</a></div>
                <div class="breadcrumb-item">Rincian dan Rangkuman</div>
                <div class="breadcrumb-item">Uang Masuk</div>
            </div>
        </div>
        <div class="section-body">

            <div class="card card-primary">
                <div class="card-header">
                    <h2 class="section-title">Daftar Uang Masuk</h2>
                    <h4></h4>
                    <div class="card-header-action">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#tambahModal"><i class="fas fa-plus"> Tambah Uang Masuk</i></button>
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
                                        <th>No.</th>
                                        <th>Tanggal</th>
                                        <th>Kode Akun</th>
                                        <th>Nama Akun</th>
                                        <th>Uraian</th>
                                        <th>Jumlah (Rp)</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 0;
                                    foreach ($data_uang_masuk as $uang_masuk) {
                                        $no += 1; ?>
                                        <tr>
                                        <td class="text-center"><?= $no ?></td>
                                            <td class="text-center"><?= $uang_masuk['tanggal'] ?></td>
                                            <td class="text-center"><?= $uang_masuk['kode'] ?></td>
                                            <td><?= $uang_masuk['nama'] ?></td>
                                            <td><?= $uang_masuk['uraian'] ?></td>
                                            <td class="text-right"><?= number_format($uang_masuk['jumlah'], 2, ',', '.'); ?></td>
                                            <td class="text-center"><?= $uang_masuk['action'] ?></td>
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
            <form action="<?= site_url() ?>rincian_dan_rangkuman/tambah_uang_masuk" method="POST">
                <div class="modal-body">
                    <div class="card card-primary">
                        <br>
                        <div class="form-group mb-0">
                            <label>Kode Akun</label><br>
                            <select name="kode_masuk" id="kode_masuk" class="form-control select2" style="width: 100%;">
                                <option value="">--Pilih Kode Akun--</option>
                                <?php
                                foreach ($data_item as $item) { ?>
                                    <option value="<?= $item['kode'] ?>"><?= $item['kode'] . ' | ' . $item['nama'] ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group mb-0">
                            <label>Tanggal</label><br>
                            <input type="text" name="tgl_masuk" id="tgl_masuk" class="form-control datepicker">
                        </div>
                        <div class="form-group mb-0">
                            <label>Uraian</label>
                            <input type="text" name="uraian_masuk" id="uraian_masuk" class="form-control" required>
                        </div>
                        <div class="form-group mb-0">
                            <label>Jumlah</label>
                            <input type="number" name="jml_masuk" id="jml_masuk" class="form-control" required>
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
foreach ($data_uang_masuk as $uang_masuk) :
    $id = $uang_masuk['id'];
?>
    <div class="modal fade" tabindex="-1" role="dialog" id="editModal<?= $id ?>">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ubah Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= site_url() ?>rincian_dan_rangkuman/ubah_uang_masuk" method="POST">
                    <div class="modal-body">
                        <div class="card card-primary">
                            <br>
                            <input type="hidden" id="id_masuk_edt" name="id_masuk_edt" value="<?= $uang_masuk['id'] ?>">
                            <div class="form-group mb-0">
                                <label>Tanggal</label><br>
                                <input type="text" name="tgl_masuk_edt" id="tgl_masuk_edt" class="form-control datepicker" value="<?= $uang_masuk['tanggal'] ?>">
                            </div>
                            <div class="form-group mb-0">
                                <label>Uraian</label>
                                <input type="text" name="uraian_masuk_edt" id="uraian_masuk_edt" class="form-control" value="<?= $uang_masuk['uraian'] ?>" required>
                            </div>
                            <div class="form-group mb-0">
                                <label>Jumlah</label>
                                <input type="number" name="jml_masuk_edt" id="jml_masuk_edt" class="form-control" value="<?= $uang_masuk['jumlah'] ?>" required>
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
foreach ($data_uang_masuk as $uang_masuk) :
    $id = $uang_masuk['id'];
?>
    <div class="modal fade" tabindex="-1" role="dialog" id="hapusModal<?= $id ?>">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= site_url() ?>rincian_dan_rangkuman/hapus_uang_masuk" method="POST">
                    <div class="modal-body">
                        <div class="card card-danger">
                            <br>
                            <input type="hidden" name="id_masuk_hps" id="id_masuk_hps" value="<?= $id ?>">
                            Yakin untuk menghapus data dengan kode <?= $uang_masuk['kode_akun'] ?> ?
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