<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=rugi_laba_" . $nama_bulan . '_' . $tahun . ".xls");
?>
<link rel="stylesheet" href="<?= base_url() ?>assets/stisla/build/css/table-style.css">
<p></p>
<h2 class="text-center" style="font-size: 14px;"><b>RUGI LABA CV. DHARMA IAA <br> PERIODE : <?= $nama_bulan . ' ' . $tahun ?></b></h2>
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
        foreach ($data_jumlah as $jumlah) {
            $pendapatan = $jumlah['pendapatan'];
            $biaya = $jumlah['biaya'];
            $laba_blm_pajak = $pendapatan - $biaya;
            $pajak = 0;
            $laba_sdh_pajak = $laba_blm_pajak - $pajak;

            foreach ($data_rugi_laba as $rugi_laba) {
                if ($rugi_laba['jenis'] == '40') { ?>
                    <tr>
                        <td class="tengah"><?= $rugi_laba['kode'] ?></td>
                        <td><?= $rugi_laba['nama'] ?></td>
                        <td class="kanan"><?= $rugi_laba['mutasi_kredit'] ?></td>
                    </tr>
            <?php
                }
            }
            ?>
            <tr class="biru">
                <td></td>
                <td>Pendapatan</td>
                <td class="kanan"><?= $pendapatan ?></td>
            </tr>
            <?php
            foreach ($data_rugi_laba as $rugi_laba) {
                if ($rugi_laba['jenis'] == '50') { ?>
                    <tr>
                        <td class="tengah"><?= $rugi_laba['kode'] ?></td>
                        <td><?= $rugi_laba['nama'] ?></td>
                        <td class="kanan"><?= $rugi_laba['mutasi_debet'] ?></td>
                    </tr>
            <?php
                }
            }
            ?>
            <tr class="biru">
                <td></td>
                <td>Biaya</td>
                <td class="kanan"><?= $biaya ?></td>
            </tr>
            <tr>
                <td></td>
                <td>Laba Sebelum Pajak</td>
                <td class="kanan"><?= $laba_blm_pajak ?></td>
            </tr>
            <tr>
                <td></td>
                <td>Pajak</td>
                <td class="kanan"><?= $pajak ?></td>
            </tr>
            <tr>
                <td></td>
                <td>Laba Sesudah Pajak</td>
                <td class="kanan"><?= $laba_sdh_pajak ?></td>
            </tr>
            <tr>
                <td></td>
                <td>Laba Bersih</td>
                <td class="kanan"><?= $laba_sdh_pajak ?></td>
            </tr>
        <?php
        } ?>
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