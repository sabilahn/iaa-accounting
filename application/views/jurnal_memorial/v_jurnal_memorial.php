<p></p>
<h2 class="text-center" style="font-size: 14px;"><b>JURNAL MEMORIAL CV. DHARMA IAA <br> PERIODE : <?= strtoupper($nama_bulan) . " " . $tahun ?></b></h2>
<p></p>

<div class="row">
    <div class="col-6">
        <table border="1">
            <thead>
                <tr class=" text-center">
                    <th>Kode Akun</th>
                    <th>Nama Perkiraan</th>
                    <th>Jumlah (Rp)</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $jml_debet = 0;
                foreach ($data_jurnal as $jurnal) {
                    $jml_debet += $jurnal['debet']; ?>
                    <tr>
                        <td class="tengah"><?= $jurnal['kode'] ?></td>
                        <td><?= $jurnal['nama'] ?></td>
                        <td class="kanan"><?= number_format($jurnal['debet'], 2, ',', '.'); ?></td>
                    </tr>
                <?php } ?>

                <tr class="biru">
                    <td></td>
                    <td><b>JUMLAH</b></td>
                    <td class="kanan"><b><?= number_format($jml_debet, 2, ',', '.'); ?></b></td>
                </tr>
            </tbody>
        </table>

    </div>
    <div class="col-6">
        <table border="1">
            <thead>
                <tr class=" text-center">
                    <th>Kode Akun</th>
                    <th>Nama Perkiraan</th>
                    <th>Jumlah (Rp)</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $jml_kredit = 0;
                foreach ($data_jurnal as $jurnal) {
                    $jml_kredit += $jurnal['kredit']; ?>
                    <tr>
                        <td class="tengah"><?= $jurnal['kode'] ?></td>
                        <td><?= $jurnal['nama'] ?></td>
                        <td class="kanan"><?= number_format($jurnal['kredit'], 2, ',', '.'); ?></td>
                    </tr>
                <?php } ?>

                <tr class="biru">
                    <td></td>
                    <td><b>JUMLAH</b></td>
                    <td class="kanan"><b><?= number_format($jml_kredit, 2, ',', '.'); ?></b></td>
                </tr>
            </tbody>
        </table>
    </div>

</div>
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