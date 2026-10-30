<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Kas Harian</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="<?= site_url() ?>dashboard">Dashboard</a></div>
                <div class="breadcrumb-item">Kas Harian</div>
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
                    <form action="<?= site_url() ?>kas_harian" method="POST">
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
                    <h2 class="section-title">Kas Harian</h2>
                    <h4></h4>
                    <div class="card-header-action">
                        <?= $action ?>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="table-1">
                            <thead>
                                <tr class="text-center">
                                    <th style=width:15%;>Tanggal</th>
                                    <th style=width:10%;>Kode Akun</th>
                                    <th style=width:30%;>Uraian</th>
                                    <th style=width:15%;>Uang Masuk (Rp)</th>
                                    <th style=width:15%;>Uang Keluar (Rp)</th>
                                    <th style=width:15%;>Saldo (Rp)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td><b>Saldo Awal</b></td>
                                    <td></td>
                                    <td></td>
                                    <td class="text-right"><b><?= number_format($saldo_awal, 2, ',', '.') ?></b></td>
                                </tr>
                                <?php

                                foreach ($data_kas as $kas) {
                                ?>
                                    <tr>
                                        <td class="text-center"><?= $kas[0] ?></td>
                                        <td class="text-center"><?= $kas[1] ?></td>
                                        <td><?= $kas[2] ?></td>
                                        <?php
                                        if ($kas[3] != '-') {
                                            echo '<td  class="text-right">' . number_format($kas[3], 2, ',', '.') . '</td>';
                                        } else {
                                            echo '<td></td>';
                                        }

                                        if ($kas[4] != '-') {
                                            echo '<td  class="text-right">' . number_format($kas[4], 2, ',', '.') . '</td>';
                                        } else {
                                            echo '<td></td>';
                                        } ?>
                                        <td class="text-right"><?= number_format($kas[5], 2, ',', '.'); ?></td>
                                    </tr>
                                <?php
                                } ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
    </section>
</div>