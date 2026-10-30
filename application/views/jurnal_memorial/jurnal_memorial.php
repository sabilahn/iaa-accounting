<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Jurnal Memorial</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="<?= site_url() ?>dashboard">Dashboard</a></div>
                <div class="breadcrumb-item">Jurnal Memorial</div>
                <div class="breadcrumb-item"><?= $nama_bulan . ' ' . $tahun ?></div>
            </div>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>Periode</h4>
                <div class="card-header-action">
                    <a data-collapse="#showPeriode" class="btn btn-icon btn-primary" href="#"><i class="fas fa-minus"></i></a>
                </div>
            </div>
            <div class="collapse show" id="showPeriode">
                <div class="card-body">
                    <form action="<?= site_url() ?>jurnal_memorial" method="POST">
                        <div class="form-group col-md-4 col-lg-4">
                            <?php
                            $nama_bulan = array(
                                'Januari',
                                'Februari',
                                'Maret',
                                'April',
                                'Mei',
                                'Juni',
                                'Juli',
                                'Agustus',
                                'September',
                                'Oktober',
                                'November',
                                'Desember'
                            );
                            ?>
                            <label>Bulan</label>
                            <div class="input-group">
                                <select class="custom-select" id="bulan" name="bulan">
                                    <option value="">--Pilih Bulan--</option>
                                    <?php
                                    for ($i = 0; $i < count($nama_bulan); $i++) {
                                    ?>
                                        <option value="<?= $i + 1 ?>" <?php if ($bulan == $i + 1) {
                                                                            echo "selected";
                                                                        } ?>><?= $nama_bulan[$i] ?></option>
                                    <?php
                                    } ?>
                                </select>
                            </div>
                            <label>Tahun</label>
                            <div class="input-group">
                                <select class="custom-select" id="tahun" name="tahun">
                                    <option value="">--Pilih Tahun--</option>
                                    <?php
                                    $thn_skr = date('Y');
                                    for ($x = $thn_skr; $x >= $thn_skr - 5; $x--) {
                                    ?>
                                        <option value="<?= $x ?>" <?php if ($tahun == $x) {
                                                                        echo "selected";
                                                                    } ?>><?= $x ?></option>
                                    <?php
                                    } ?>
                                </select>
                            </div>
                            <br>
                            <button class="btn btn-primary" type="submit">Lihat</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="section-body">
            <div class="card card-primary">
                <div class="card-header">
                    <h2 class="section-title">Perkiraan-perkiraan</h2>
                    <h4></h4>
                    <div class="card-header-action">
                        <?= $action ?>
                    </div>
                </div>
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
                                    <th>Kode Akun</th>
                                    <th>Nama Perkiraan</th>
                                    <th>Debet (Rp)</th>
                                    <!-- <th>Aksi</th> -->
                                    <th>Kredit (Rp)</th>
                                    <!-- <th>Aksi</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $jml_debet = 0;
                                $jml_kredit = 0;
                                foreach ($data_jurnal as $jurnal) {
                                    $jml_debet += $jurnal['debet'];
                                    $jml_kredit += $jurnal['kredit']; ?>
                                    <tr>
                                        <td class="text-center"><?= $jurnal['kode'] ?></td>
                                        <td><?= $jurnal['nama'] ?></td>
                                        <td class="text-right"><?= number_format($jurnal['debet'], 2, ',', '.'); ?></td>
                                        <!-- <td class="text-center"><button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editModalDebet<?= $jurnal['id'] ?>"><i class=" fas fa-pencil-alt"></i></button></td> -->
                                        <td class="text-right"><?= number_format($jurnal['kredit'], 2, ',', '.'); ?></td>
                                        <!-- <td class="text-center"><button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editModalKredit<?= $jurnal['id'] ?>"><i class="fas fa-pencil-alt"></i></button></td> -->
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- </div> -->
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <table class="col-lg 12">
                    <tr>
                        <td><b>Jumlah Perkiraan Debet</b></td>
                        <td><b>:</b></td>
                        <td class="text-right"><b><?= number_format($jml_debet, 2, ',', '.'); ?></b></td>
                    </tr>
                    <tr>
                        <td><b>Jumlah Perkiraan Kredit</b></td>
                        <td><b>:</b></td>
                        <td class="text-right"><b><?= number_format($jml_kredit, 2, ',', '.'); ?></b></td>
                    </tr>
                </table>
            </div>
        </div>
    </section>
</div>
<!-- Update -->

<!-- Debet -->
<?php
foreach ($data_jurnal as $jurnal) :
    $id = $jurnal['id'];
?>
    <div class="modal fade" tabindex="-1" role="dialog" id="editModalDebet<?= $id ?>">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ubah Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= site_url() ?>jurnal_memorial/ubah_debet" method="POST">
                    <div class="modal-body">
                        <div class="card card-primary">
                            <br>
                            <input type="hidden" id="id_debet_edt" name="id_debet_edt" value="<?= $jurnal['id'] ?>">
                            <div class="form-group mb-0">
                                <label>Jumlah</label>
                                <input type="number" name="jml_debet_edt" id="jml_debet_edt" class="form-control" value="<?= $jurnal['debet'] ?>" required>
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

<!-- Kredit -->
<?php
foreach ($data_jurnal as $jurnal) :
    $id = $jurnal['id'];
?>
    <div class="modal fade" tabindex="-1" role="dialog" id="editModalKredit<?= $id ?>">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ubah Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= site_url() ?>jurnal_memorial/ubah_kredit" method="POST">
                    <div class="modal-body">
                        <div class="card card-primary">
                            <br>
                            <input type="hidden" id="id_kredit_edt" name="id_kredit_edt" value="<?= $jurnal['id'] ?>">
                            <div class="form-group mb-0">
                                <label>Jumlah</label>
                                <input type="number" name="jml_kredit_edt" id="jml_kredit_edt" class="form-control" value="<?= $jurnal['kredit'] ?>" required>
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