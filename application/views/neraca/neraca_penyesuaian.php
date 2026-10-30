<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Neraca Penyesuaian</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="<?= site_url() ?>dashboard">Dashboard</a></div>
                <div class="breadcrumb-item">Neraca Penyesuaian</div>
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
                    <form action="<?= site_url() ?>neraca/neraca_penyesuaian" method="POST">
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
                    <h2 class="section-title">Neraca Penyesuaian</h2>
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
                        <table class="table table-striped" id="table-1" width=100%>
                            <thead>
                                <tr class="text-center">
                                    <th rowspan="2" style="vertical-align: middle;">Kode Akun</th>
                                    <th rowspan="2" style="vertical-align: middle;">Nama Perkiraan</th>
                                    <th colspan="2">Saldo Awal (Rp)</th>
                                    <th colspan="2">Penyesuaian (Rp)</th>
                                    <th colspan="2">Saldo Akhir (Rp)</th>
                                    <th rowspan="2" style="vertical-align: middle;">Aksi</th>
                                </tr>
                                <tr class="text-center">
                                    <th>Debet</th>
                                    <th>Kredit</th>
                                    <th>Debet</th>
                                    <th>Kredit</th>
                                    <th>Debet</th>
                                    <th>Kredit</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                foreach ($neraca_penyesuaian as $penyesuaian) {
                                    if ($penyesuaian['kode'] != '3004') {
                                        if ($penyesuaian['type'] == 'debet') { ?>
                                            <tr>
                                                <td class="text-center"><?= $penyesuaian['kode'] ?></td>
                                                <td><?= $penyesuaian['nama'] ?></td>
                                                <td class="text-right"><?= number_format($penyesuaian['saldo_awal'], 2, ',', '.'); ?></td>
                                                <td style="background-color:#fdeec5;"></td>
                                                <td class="text-right"><?= number_format($penyesuaian['penyesuaian_debet'], 2, ',', '.'); ?></td>
                                                <td class="text-right"><?= number_format($penyesuaian['penyesuaian_kredit'], 2, ',', '.'); ?></td>
                                                <td class="text-right"><?= number_format($penyesuaian['saldo_akhir'], 2, ',', '.'); ?></td>
                                                <td style="background-color:#fdeec5;"></td>
                                                <td><button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editModal<?= $penyesuaian['kode'] ?>"><i class="fas fa-pencil-alt"></i></button></td>
                                                <!-- <td><button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editModal<?= $penyesuaian['kode'].'|'. $penyesuaian['bulan'].'|'. $penyesuaian['tahun'] ?>"><i class="fas fa-pencil-alt"></i></button></td> -->
                                            </tr>
                                        <?php
                                        } else { ?>
                                            <tr>
                                                <td class="text-center"><?= $penyesuaian['kode'] ?></td>
                                                <td><?= $penyesuaian['nama'] ?></td>
                                                <td style="background-color:#fdeec5;"></td>
                                                <td class="text-right"><?= number_format($penyesuaian['saldo_awal'], 2, ',', '.'); ?></td>
                                                <td class="text-right"><?= number_format($penyesuaian['penyesuaian_debet'], 2, ',', '.'); ?></td>
                                                <td class="text-right"><?= number_format($penyesuaian['penyesuaian_kredit'], 2, ',', '.'); ?></td>
                                                <td style="background-color:#fdeec5;"></td>
                                                <td class="text-right"><?= number_format($penyesuaian['saldo_akhir'], 2, ',', '.'); ?></td>
                                                <td><button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editModal<?= $penyesuaian['kode'] ?>"><i class="fas fa-pencil-alt"></i></button></td>
                                            </tr>
                                        <?php }
                                    } else { ?>
                                        <tr>
                                            <td class="text-center"><?= $penyesuaian['kode'] ?></td>
                                            <td><?= $penyesuaian['nama'] ?></td>
                                            <td style="background-color:#fdeec5;"></td>
                                            <td class="text-right"><?= number_format(0, 2, ',', '.'); ?></td>
                                            <td class="text-right"><?= number_format(0, 2, ',', '.'); ?></td>
                                            <td class="text-right"><?= number_format(0, 2, ',', '.'); ?></td>
                                            <td style="background-color:#fdeec5;"></td>
                                            <td class="text-right"><?= number_format(0, 2, ',', '.'); ?></td>
                                            <td><button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editModal<?= $penyesuaian['kode'] ?>"><i class="fas fa-pencil-alt"></i></button></td>
                                        </tr>
                                <?php }
                                } ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
    </section>
</div>

<!-- Modal -->
<?php
foreach ($neraca_penyesuaian as $penyesuaian) :
    $kode = $penyesuaian['kode'];
    $bulan = $penyesuaian['bulan'];
    $tahun = $penyesuaian['tahun'];

    $debet = $penyesuaian['penyesuaian_debet'];
    $kredit = $penyesuaian['penyesuaian_kredit'];
?>
    <!-- <div class="modal fade" tabindex="-1" role="dialog" id="editModal<?= $kode.'|'.$bulan.'|'.$tahun ?>"> -->
    <div class="modal fade" tabindex="-1" role="dialog" id="editModal<?= $kode ?>">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ubah Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= site_url() ?>neraca/update_penyesuaian" method="POST">
                    <div class="modal-body">
                        <div class="card card-primary">
                            <br>
                            <input type="hidden" id="kode" name="kode" value="<?= $kode ?>">
                            <input type="hidden" id="bulan" name="bulan" value="<?= $bulan ?>">
                            <input type="hidden" id="tahun" name="tahun" value="<?= $tahun ?>">
                            <div class="form-group mb-0">
                                <label>Debet</label>
                                <input type="number" name="jml_debet" id="jml_debet" class="form-control" value="<?= $debet ?>" required>
                            </div>
                            <div class="form-group mb-0">
                                <label>Kredit</label>
                                <input type="number" name="jml_kredit" id="jml_kredit" class="form-control" value="<?= $kredit ?>" required>
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

