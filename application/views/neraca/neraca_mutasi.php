<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Neraca Mutasi</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="<?= site_url() ?>dashboard">Dashboard</a></div>
                <div class="breadcrumb-item">Neraca Mutasi</div>
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
                    <form action="<?= site_url() ?>neraca/neraca_mutasi" method="POST">
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
                    <h2 class="section-title">Neraca Mutasi</h2>
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
                                    <th colspan="2">Mutasi (Rp)</th>
                                    <th colspan="2">Saldo Akhir (Rp)</th>
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
                                foreach ($neraca_mutasi as $mutasi) {
                                    if ($mutasi['kode'] != '3004') {
                                        if ($mutasi['type'] == 'debet') { ?>
                                            <tr>
                                                <td class="text-center"><?= $mutasi['kode'] ?></td>
                                                <td><?= $mutasi['nama'] ?></td>
                                                <td class="text-right"><?= number_format($mutasi['saldo_awal'], 2, ',', '.'); ?></td>
                                                <td style="background-color:#fdeec5;"></td>
                                                <td class="text-right"><?= number_format($mutasi['mutasi_debet'], 2, ',', '.'); ?></td>
                                                <td class="text-right"><?= number_format($mutasi['mutasi_kredit'], 2, ',', '.'); ?></td>
                                                <td class="text-right"><?= number_format($mutasi['saldo_akhir'], 2, ',', '.'); ?></td>
                                                <td style="background-color:#fdeec5;"></td>
                                            </tr>
                                        <?php
                                        } else { ?>
                                            <tr>
                                                <td class="text-center"><?= $mutasi['kode'] ?></td>
                                                <td><?= $mutasi['nama'] ?></td>
                                                <td style="background-color:#fdeec5;"></td>
                                                <td class="text-right"><?= number_format($mutasi['saldo_awal'], 2, ',', '.'); ?></td>
                                                <td class="text-right"><?= number_format($mutasi['mutasi_debet'], 2, ',', '.'); ?></td>
                                                <td class="text-right"><?= number_format($mutasi['mutasi_kredit'], 2, ',', '.'); ?></td>
                                                <td style="background-color:#fdeec5;"></td>
                                                <td class="text-right"><?= number_format($mutasi['saldo_akhir'], 2, ',', '.'); ?></td>
                                            </tr>
                                        <?php }
                                    } else { ?>
                                        <tr>
                                            <td class="text-center"><?= $mutasi['kode'] ?></td>
                                            <td><?= $mutasi['nama'] ?></td>
                                            <td style="background-color:#fdeec5;"></td>
                                            <td class="text-right"><?= number_format(0, 2, ',', '.'); ?></td>
                                            <td class="text-right"><?= number_format(0, 2, ',', '.'); ?></td>
                                            <td class="text-right"><?= number_format(0, 2, ',', '.'); ?></td>
                                            <td style="background-color:#fdeec5;"></td>
                                            <td class="text-right"><?= number_format(0, 2, ',', '.'); ?></td>
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