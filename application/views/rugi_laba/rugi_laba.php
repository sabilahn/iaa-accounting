<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Rugi Laba</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="<?= site_url() ?>dashboard">Dashboard</a></div>
                <div class="breadcrumb-item">Rugi Laba</div>
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
                    <form action="<?= site_url() ?>rugi_laba" method="POST">
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
                    <h2 class="section-title">Rugi Laba</h2>
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
                                    <th>Kode Akun</th>
                                    <th>Nama Akun</th>
                                    <th>Jumlah (Rp)</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($data_rugi_laba as $rugi_laba) {
                                    if ($rugi_laba['type'] == 'kredit') { ?>
                                        <tr>
                                            <td class="text-center"><?= $rugi_laba['kode'] ?></td>
                                            <td><?= $rugi_laba['nama'] ?></td>
                                            <td class="text-right"><?= number_format($rugi_laba['jml_kredit'], 2, ',', '.'); ?></td>
                                            <td></td>
                                        </tr>
                                    <?php } else {
                                    ?>
                                        <tr>
                                            <td class="text-center"><?= $rugi_laba['kode'] ?></td>
                                            <td><?= $rugi_laba['nama'] ?></td>
                                            <td class="text-right"><?= number_format($rugi_laba['jml_debet'], 2, ',', '.'); ?></td>
                                            <td></td>
                                        </tr>
                                <?php }
                                } ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <table class="col-lg 12">
                        <?php
                        foreach ($data_jumlah as $jumlah) {
                            $pendapatan = $jumlah['pendapatan'];
                            $biaya = $jumlah['biaya'];
                            $laba_blm_pajak = $pendapatan - $biaya;
                            $pajak = 0;
                            $laba_sdh_pajak = $laba_blm_pajak - $pajak;
                        ?>
                            <tr>
                                <td><b>Laba Usaha Sebelum Pajak</b></td>
                                <td><b>:</b></td>
                                <td class="text-right"><b><?= number_format($laba_blm_pajak, 2, ',', '.'); ?></b></td>
                            </tr>
                            <tr>
                                <td><b>Pajak</b></td>
                                <td><b>:</b></td>
                                <td class="text-right"><b><?= number_format($pajak, 2, ',', '.'); ?></b></td>
                            </tr>
                            <tr>
                                <td><b>Laba Usaha Sesudah Pajak</b></td>
                                <td><b>:</b></td>
                                <td class="text-right"><b><?= number_format($laba_sdh_pajak, 2, ',', '.'); ?></b></td>
                            </tr>
                            <tr>
                                <td><b>Laba Bersih</b></td>
                                <td><b>:</b></td>
                                <td class="text-right"><b><?= number_format($laba_sdh_pajak, 2, ',', '.'); ?></b></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </table>
                </div>
            </div>
    </section>
</div>