<p></p>
<h2 class="text-center" style="font-size: 14px;"><b>LAPORAN ARUS KAS (CASH FLOW) CV. DHARMA IAA <br> PERIODE : <?= strtoupper($nama_bulan) . " " . $tahun ?></b></h2>
<p></p>
<table border="1">
    <thead>
        <tr class="text-center">
            <th>Kode Akun</th>
            <th>Nama Akun</th>
            <th>Jumlah (Rp)</th>
        </tr>
    </thead>
    <tbody>

        <?php
        $jml_masuk = 0;
        $jml_keluar = 0;
        // foreach ($data_jumlah_sekarang as $jumlah_sekarang) {
        //     $jml_masuk = $jumlah_sekarang['penerimaan'];
        //     $jml_keluar = $jumlah_sekarang['pengeluaran'];
        // }
        foreach ($data_jumlah as $jumlah) {
            // $defisit = $jml_masuk - $jml_keluar;
            // $saldo_awal = $jumlah['penerimaan_sebelumnya'] - $jumlah['pengeluaran_sebelumnya'];
            // $saldo_akhir = $defisit + $saldo_awal; 
        ?>

            <tr class="biru">
                <td></td>
                <td><b>PENERIMAAN</b></td>
                <!-- <td class="kanan"><b><?= number_format($jml_masuk, 2, ',', '.'); ?></b></td> -->
                <td></td>
            </tr>

            <?php foreach ($data_kas_masuk as $kas_masuk) {
                if ($kas_masuk['jenis'] != '50') {
                    $jml_masuk += $kas_masuk['penerimaan'];
            ?>
                    <tr>
                        <td class="tengah"><?= $kas_masuk['kode'] ?></td>
                        <td><?= $kas_masuk['nama'] ?></td>
                        <td class="kanan"><?= number_format($kas_masuk['penerimaan'], 2, ',', '.'); ?></td>
                    </tr>
            <?php }
            } ?>

            <tr class="biru">
                <td></td>
                <td><b>PENGELUARAN</b></td>
                <!-- <td class="kanan"><b><?= number_format($jml_keluar, 2, ',', '.'); ?></b></td> -->
                <td></td>
            </tr>

            <?php foreach ($data_kas_keluar as $kas_keluar) {
                if ($kas_keluar['jenis'] != '40') {
                    $jml_keluar += $kas_keluar['pengeluaran'];
            ?>
                    <tr>
                        <td class="tengah"><?= $kas_keluar['kode'] ?></td>
                        <td><?= $kas_keluar['nama'] ?></td>
                        <td class="kanan"><?= number_format($kas_keluar['pengeluaran'], 2, ',', '.'); ?></td>
                    </tr>
            <?php }
            } ?>
            <tr>
                <td></td>
                <td><b>Jumlah Penerimaan s/d Bulan Ini</b></td>
                <td class="kanan"><b><?= number_format($jml_masuk, 2, ',', '.');
                                        ?></b></td>
            </tr>

            <?php
            $defisit = $jml_masuk - $jml_keluar;
            $saldo_awal = $jumlah['penerimaan_sebelumnya'];
            $saldo_akhir = $jumlah['penerimaan_sebelumnya'] + $defisit;
            ?>

            <tr>
                <td></td>
                <td><b>Jumlah Pengeluaran s/d Bulan Ini</b></td>
                <td class="kanan"><b><?= number_format($jml_keluar, 2, ',', '.');
                                        ?></b></td>
            </tr>
            <tr>
                <td></td>
                <td><b>Defisit/Surplus (Saldo Sementara)</b></td>
                <td class="kanan"><b><?= number_format($defisit, 2, ',', '.'); ?></b></td>
            </tr>
            <tr>
                <td></td>
                <td><b>Saldo Awal Bulan</b></td>
                <td class="kanan"><b><?= number_format($saldo_awal, 2, ',', '.'); ?></b></td>
            </tr>
            <tr class="biru">
                <td></td>
                <td><b>Saldo Akhir Bulan</b></td>
                <td class="kanan"><b><?= number_format($saldo_akhir, 2, ',', '.'); ?></b></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<table>
    <thead>
        <tr class="putih">
            <td class="no-border"></td>
        </tr>
        <tr class="putih">
            <td class="no-border kanan">Sumenep, <?= date('d-m-Y') ?>
        </tr>
        </td>
    </thead>
    <tbody>
        <tr class="putih">
            <td class="no-border kanan">
                Bendahara,</td>
        </tr>
        <tr class="putih">
            <td class="no-border"></td>
        </tr>
        <tr class="putih">
            <td class="no-border"></td>
        </tr>
        <tr class="putih">
            <td class="no-border kanan"><b>
                    Abd. Basith</b>
        </tr>
        </td>
    </tbody>
</table>