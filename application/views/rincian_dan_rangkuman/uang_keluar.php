<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Uang Keluar</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="<?= site_url() ?>dashboard">Dashboard</a></div>
                <div class="breadcrumb-item">Rincian dan Rangkuman</div>
                <div class="breadcrumb-item">Uang Keluar</div>
            </div>
        </div>
        <div class="section-body">
            <div class="card card-primary">
                <div class="card-header">
                    <h2 class="section-title">Daftar Uang Keluar</h2>
                    <h4></h4>
                    <div class="card-header-action">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#tambahModal"><i class="fas fa-plus"> Tambah Uang Keluar</i></button>
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
                                    foreach ($data_uang_keluar as $uang_keluar) {
                                        $no += 1; ?>
                                        <tr>
                                            <td class="text-center"><?= $no ?></td>
                                            <td class="text-center"><?= $uang_keluar['tanggal'] ?></td>
                                            <td class="text-center"><?= $uang_keluar['kode'] ?></td>
                                            <td><?= $uang_keluar['nama'] ?></td>
                                            <td><?= $uang_keluar['uraian'] ?></td>
                                            <td class="text-right"><?= number_format($uang_keluar['jumlah'], 2, ',', '.'); ?></td>
                                            <td class="text-center"><?= $uang_keluar['action'] ?></td>
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
            <form action="<?= site_url() ?>rincian_dan_rangkuman/tambah_uang_keluar" method="POST">
                <div class="modal-body">
                    <div class="card card-primary">
                        <br>
                        <div class="form-group mb-0">
                            <label>Kode Akun</label><br>
                            <select name="kode_keluar" id="kode_keluar" class="form-control select2" style="width: 100%;">
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
                            <input type="text" name="tgl_keluar" id="tgl_keluar" class="form-control datepicker">
                        </div>
                        <div class="form-group mb-0">
                            <label>Uraian</label>
                            <input type="text" name="uraian_keluar" id="uraian_keluar" class="form-control" required>
                        </div>
                        <div class="form-group mb-0">
                            <label>Jumlah</label>
                            <input type="number" name="jml_keluar" id="jml_keluar" class="form-control" required>
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
foreach ($data_uang_keluar as $uang_keluar) :
    $id = $uang_keluar['id'];
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
                <form action="<?= site_url() ?>rincian_dan_rangkuman/ubah_uang_keluar" method="POST">
                    <div class="modal-body">
                        <div class="card card-primary">
                            <br>
                            <input type="hidden" id="id_keluar_edt" name="id_keluar_edt" value="<?= $uang_keluar['id'] ?>">
                            <div class="form-group mb-0">
                                <label>Tanggal</label><br>
                                <input type="text" name="tgl_keluar_edt" id="tgl_keluar_edt" class="form-control datepicker" value="<?= $uang_keluar['tanggal'] ?>">
                            </div>
                            <div class="form-group mb-0">
                                <label>Uraian</label>
                                <input type="text" name="uraian_keluar_edt" id="uraian_keluar_edt" class="form-control" value="<?= $uang_keluar['uraian'] ?>" required>
                            </div>
                            <div class="form-group mb-0">
                                <label>Jumlah</label>
                                <input type="number" name="jml_keluar_edt" id="jml_keluar_edt" class="form-control" value="<?= $uang_keluar['jumlah'] ?>" required>
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
foreach ($data_uang_keluar as $uang_keluar) :
    $id = $uang_keluar['id'];
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
                <form action="<?= site_url() ?>rincian_dan_rangkuman/hapus_uang_keluar" method="POST">
                    <div class="modal-body">
                        <div class="card card-danger">
                            <br>
                            <input type="hidden" name="id_keluar_hps" id="id_keluar_hps" value="<?= $id ?>">
                            Yakin untuk menghapus data dengan kode <?= $uang_keluar['kode_akun'] ?> ?
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
<!-- <script type="text/javascript">
    getData();

    function getData() {
        $.ajax({
            type: 'POST',
            url: '<?= base_url() ?>rincian_dan_rangkuman/data_keluar',
            dataType: 'json',
            success: function(data) {
                console.log(data);
            }

        });
    }
</script> -->