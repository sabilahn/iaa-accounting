<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=neraca_penyesuaian_" . $nama_bulan . '_' . $tahun . ".xls");
?>
<link rel="stylesheet" href="<?= base_url() ?>assets/stisla/build/css/table-style.css">
<p></p>
<h2 class="text-center" style="font-size: 14px;"><b>NERACA PENYESUAIAN CV. DHARMA IAA <br> PERIODE : <?= $nama_bulan . ' ' . $tahun ?></b></h2>
<p></p>
<table border="1">
    <thead>
        <tr class="text-center">
            <th rowspan="2" style="vertical-align: middle;">Kode Akun</th>
            <th rowspan="2" style="vertical-align: middle;">Nama Perkiraan</th>
            <th colspan="2">Saldo Awal (Rp)</th>
            <th colspan="2">Penyesuaian (Rp)</th>
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
        $total_awal_debet = 0;
        $total_awal_kredit = 0;
        $total_debet = 0;
        $total_kredit = 0;
        $total_akhir_debet = 0;
        $total_akhir_kredit = 0;

        foreach ($data_jenis as $jenis) {
            $jml_awal = 0;
            $jml_debet = 0;
            $jml_kredit = 0;
            $jml_akhir = 0;
            $type = null;
            foreach ($neraca_penyesuaian as $penyesuaian) {
                if ($penyesuaian['jenis'] == $jenis['kode']) {

                    // $jml_awal += $penyesuaian['saldo_awal'];
                    // $jml_debet += $penyesuaian['penyesuaian_debet'];
                    // $jml_kredit += $penyesuaian['penyesuaian_kredit'];
                    // $jml_akhir += $penyesuaian['saldo_akhir'];
                    $type = $penyesuaian['type'];

                    if ($penyesuaian['kode'] != '3004') {
                        $jml_awal += $penyesuaian['saldo_awal'];
                        $jml_debet += $penyesuaian['penyesuaian_debet'];
                        $jml_kredit += $penyesuaian['penyesuaian_kredit'];
                        $jml_akhir += $penyesuaian['saldo_akhir'];
                        if ($penyesuaian['type'] == 'debet') {
                            $total_awal_debet += $penyesuaian['saldo_awal'];
                            $total_debet += $penyesuaian['penyesuaian_debet'];
                            $total_kredit += $penyesuaian['penyesuaian_kredit'];
                            $total_akhir_debet += $penyesuaian['saldo_akhir']; ?>
                            <tr>
                                <td class="tengah"><?= $penyesuaian['kode'] ?></td>
                                <td><?= $penyesuaian['nama'] ?></td>
                                <td class="kanan"><?= $penyesuaian['saldo_awal'] ?></td>
                                <td class="blok2"></td>
                                <td class="kanan"><?= $penyesuaian['penyesuaian_debet'] ?></td>
                                <td class="kanan"><?= $penyesuaian['penyesuaian_kredit'] ?></td>
                                <td class="kanan"><?= $penyesuaian['saldo_akhir'] ?></td>
                                <td class="blok2"></td>
                            </tr>
                        <?php
                        } else {
                            $total_awal_kredit += $penyesuaian['saldo_awal'];
                            $total_debet += $penyesuaian['penyesuaian_debet'];
                            $total_kredit += $penyesuaian['penyesuaian_kredit'];
                            $total_akhir_kredit += $penyesuaian['saldo_akhir']; ?>
                            <tr>
                                <td class="tengah"><?= $penyesuaian['kode'] ?></td>
                                <td><?= $penyesuaian['nama'] ?></td>
                                <td class="blok2"></td>
                                <td class="kanan"><?= $penyesuaian['saldo_awal'] ?></td>
                                <td class="kanan"><?= $penyesuaian['penyesuaian_debet'] ?></td>
                                <td class="kanan"><?= $penyesuaian['penyesuaian_kredit'] ?></td>
                                <td class="blok2"></td>
                                <td class="kanan"><?= $penyesuaian['saldo_akhir'] ?></td>
                            </tr>
                        <?php
                        }
                    } else {
                        // $saldo_akhir_shu = 0 - $penyesuaian['penyesuaian_debet'] + $penyesuaian['penyesuaian_kredit'];

                        // $jml_debet += $penyesuaian['penyesuaian_debet'];
                        // $jml_kredit += $penyesuaian['penyesuaian_kredit'];
                        // $jml_akhir += $saldo_akhir_shu;

                        // $total_awal_kredit += $penyesuaian['saldo_awal'];
                        // $total_debet += $penyesuaian['penyesuaian_debet'];
                        // $total_kredit += $penyesuaian['penyesuaian_kredit'];
                        // $total_akhir_kredit += $saldo_akhir_shu;

                        ?>
                        <tr>
                            <td class="tengah"><?= $penyesuaian['kode'] ?></td>
                            <td><?= $penyesuaian['nama'] ?></td>
                            <td class="blok2"></td>
                            <td class="kanan">0</td>
                            <td class="kanan">0</td>
                            <td class="kanan">0</td>
                            <td class="blok2"></td>
                            <td class="kanan">0</td>
                        </tr>
                <?php }
                }
            }
            if ($type == 'debet') { ?>
                <tr class="biru">
                    <td></td>
                    <td><?= $jenis['nama'] ?></td>
                    <td class="kanan"><?= $jml_awal ?></td>
                    <td class="blok2"></td>
                    <td class="kanan"><?= $jml_debet ?></td>
                    <td class="kanan"><?= $jml_kredit ?></td>
                    <td class="kanan"><?= $jml_akhir ?></td>
                    <td class="blok2"></td>
                </tr>
            <?php
            } else { ?>
                <tr class="biru">
                    <td></td>
                    <td><?= $jenis['nama'] ?></td>
                    <td class="blok2"></td>
                    <td class="kanan"><?= $jml_awal ?></td>
                    <td class="kanan"><?= $jml_debet ?></td>
                    <td class="kanan"><?= $jml_kredit ?></td>
                    <td class="blok2"></td>
                    <td class="kanan"><?= $jml_akhir ?></td>
                </tr>
        <?php
            }
        } ?>
        <tr>
            <td></td>
            <td><b>TOTAL</b></td>
            <td class="kanan"><b><?= $total_awal_debet ?></b></td>
            <td class="kanan"><b><?= $total_awal_kredit ?></b></td>
            <td class="kanan"><b><?= $total_debet ?></b></td>
            <td class="kanan"><b><?= $total_kredit ?></b></td>
            <td class="kanan"><b><?= $total_akhir_debet ?></b></td>
            <td class="kanan"><b><?= $total_akhir_kredit ?></b></td>
        </tr>
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