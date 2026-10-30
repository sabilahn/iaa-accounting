<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Arus Kas</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="<?= site_url() ?>dashboard">Dashboard</a></div>
                <div class="breadcrumb-item">Arus Kas</div>
                <div class="breadcrumb-item"><?= $nama_bulan . " " . $tahun ?></div>
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
                    <form action="<?= site_url() ?>arus_kas" method="POST">
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
        <div class="card card-primary">
            <div class="card-header">
                <h4>Penerimaan</h4>
                <div class="card-header-action">
                    <a data-collapse="#showPenerimaan" class="btn btn-icon btn-primary" href="#"><i class="fas fa-minus"></i></a>
                </div>
            </div>
            <div class="collapse show" id="showPenerimaan">
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
                                    <th>Kode Akun</th>
                                    <th>Nama Akun</th>
                                    <th>Jumlah (Rp)</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $jml_masuk = 0;
                                foreach ($data_kas_masuk as $kas_masuk) {
                                    if ($kas_masuk['jenis'] != '50') {
                                        $jml_masuk += $kas_masuk['penerimaan'];
                                ?>
                                        <tr>
                                            <td class="text-center"><?= $kas_masuk['kode'] ?></td>
                                            <td><?= $kas_masuk['nama'] ?></td>
                                            <td class="text-right"><?= number_format($kas_masuk['penerimaan'], 2, ',', '.'); ?></td>
                                            <td></td>
                                        </tr>
                                <?php }
                                } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>Pengeluaran</h4>
                <div class="card-header-action">
                    <a data-collapse="#showPengeluaran" class="btn btn-icon btn-primary" href="#"><i class="fas fa-minus"></i></a>
                </div>
            </div>
            <div class="collapse show" id="showPengeluaran">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="table-2">
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
                                $jml_keluar = 0;
                                foreach ($data_kas_keluar as $kas_keluar) {
                                    if ($kas_keluar['jenis'] != '40') {
                                        $jml_keluar += $kas_keluar['pengeluaran'];
                                ?>
                                        <tr>
                                            <td class="text-center"><?= $kas_keluar['kode'] ?></td>
                                            <td><?= $kas_keluar['nama'] ?></td>
                                            <td class="text-right"><?= number_format($kas_keluar['pengeluaran'], 2, ',', '.'); ?></td>
                                            <td></td>
                                        </tr>
                                <?php }
                                } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <table class="col-lg 12">

                    <?php
                    // $jml_masuk = 0;
                    // $jml_keluar = 0;
                    // foreach ($data_jumlah_sekarang as $jumlah_sekarang) {
                    //     $jml_masuk = $jumlah_sekarang['penerimaan'];
                    //     $jml_keluar = $jumlah_sekarang['pengeluaran'];
                    // }
                    foreach ($data_jumlah as $jumlah) {
                        $defisit = $jml_masuk - $jml_keluar;
                        $saldo_awal = $jumlah['penerimaan_sebelumnya'];
                        // $saldo_awal = $jumlah['penerimaan_sebelumnya'] - $jumlah['pengeluaran_sebelumnya'];
                        $saldo_akhir = $jumlah['penerimaan_sebelumnya'] + $defisit; ?>
                        <tr>
                            <td><b>Jumlah Penerimaan Bulan Ini</b></td>
                            <td><b>:</b></td>
                            <td class="kanan"><b><?= number_format($jml_masuk, 2, ',', '.');
                                                    ?></b></td>
                        </tr>
                        <tr>
                            <td><b>Jumlah Pengeluaran Bulan Ini</b></td>
                            <td><b>:</b></td>
                            <td class="kanan"><b><?= number_format($jml_keluar, 2, ',', '.');
                                                    ?></b></td>
                        </tr>
                        <tr>
                            <td><b>Defisit/Surplus (Saldo Sementara)</b></td>
                            <td><b>:</b></td>
                            <td class="kanan"><b><?= number_format($defisit, 2, ',', '.'); ?></b></td>
                        </tr>
                        <tr>
                            <td><b>Saldo Awal Bulan</b></td>
                            <td><b>:</b></td>
                            <td class="kanan"><b><?= number_format($saldo_awal, 2, ',', '.'); ?></b></td>
                        </tr>
                        <tr>
                            <td><b>Saldo Akhir Bulan</b></td>
                            <td><b>:</b></td>
                            <td class="kanan"><b><?= number_format($saldo_akhir, 2, ',', '.'); ?></b></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
            <div class="card-footer text-right">
                <?= $action ?>
            </div>
        </div>
    </section>
</div>