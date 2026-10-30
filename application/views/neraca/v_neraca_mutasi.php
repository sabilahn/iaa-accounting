<p></p>
<h2 class="text-center" style="font-size: 14px;"><b>NERACA MUTASI CV. DHARMA IAA <br> PERIODE : <?= strtoupper($nama_bulan) . ' ' . $tahun ?></b></h2>
<p></p>
<table border="1">
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
            foreach ($neraca_mutasi as $mutasi) {
                if ($mutasi['jenis'] == $jenis['kode']) {

                    // $jml_awal += $mutasi['saldo_awal'];
                    // $jml_debet += $mutasi['mutasi_debet'];
                    // $jml_kredit += $mutasi['mutasi_kredit'];
                    // $jml_akhir += $mutasi['saldo_akhir'];
                    $type = $mutasi['type'];

                    if ($mutasi['kode'] != '3004') {
                        $jml_awal += $mutasi['saldo_awal'];
                        $jml_debet += $mutasi['mutasi_debet'];
                        $jml_kredit += $mutasi['mutasi_kredit'];
                        $jml_akhir += $mutasi['saldo_akhir'];
                        if ($mutasi['type'] == 'debet') {
                            $total_awal_debet += $mutasi['saldo_awal'];
                            $total_debet += $mutasi['mutasi_debet'];
                            $total_kredit += $mutasi['mutasi_kredit'];
                            $total_akhir_debet += $mutasi['saldo_akhir']; ?>
                            <tr>
                                <td class="tengah"><?= $mutasi['kode'] ?></td>
                                <td><?= $mutasi['nama'] ?></td>
                                <td class="kanan"><?= number_format($mutasi['saldo_awal'], 2, ',', '.'); ?></td>
                                <td class="blok2"></td>
                                <td class="kanan"><?= number_format($mutasi['mutasi_debet'], 2, ',', '.'); ?></td>
                                <td class="kanan"><?= number_format($mutasi['mutasi_kredit'], 2, ',', '.'); ?></td>
                                <td class="kanan"><?= number_format($mutasi['saldo_akhir'], 2, ',', '.'); ?></td>
                                <td class="blok2"></td>
                            </tr>
                        <?php
                        } else {
                            $total_awal_kredit += $mutasi['saldo_awal'];
                            $total_debet += $mutasi['mutasi_debet'];
                            $total_kredit += $mutasi['mutasi_kredit'];
                            $total_akhir_kredit += $mutasi['saldo_akhir']; ?>
                            <tr>
                                <td class="tengah"><?= $mutasi['kode'] ?></td>
                                <td><?= $mutasi['nama'] ?></td>
                                <td class="blok2"></td>
                                <td class="kanan"><?= number_format($mutasi['saldo_awal'], 2, ',', '.'); ?></td>
                                <td class="kanan"><?= number_format($mutasi['mutasi_debet'], 2, ',', '.'); ?></td>
                                <td class="kanan"><?= number_format($mutasi['mutasi_kredit'], 2, ',', '.'); ?></td>
                                <td class="blok2"></td>
                                <td class="kanan"><?= number_format($mutasi['saldo_akhir'], 2, ',', '.'); ?></td>
                            </tr>
                        <?php
                        }
                    } else {
                        // $saldo_akhir_shu = 0 - $mutasi['mutasi_debet'] + $mutasi['mutasi_kredit'];

                        // $jml_debet += $mutasi['mutasi_debet'];
                        // $jml_kredit += $mutasi['mutasi_kredit'];
                        // $jml_akhir += $saldo_akhir_shu;

                        // $total_awal_kredit += $mutasi['saldo_awal'];
                        // $total_debet += $mutasi['mutasi_debet'];
                        // $total_kredit += $mutasi['mutasi_kredit'];
                        // $total_akhir_kredit += $saldo_akhir_shu;

                        ?>
                        <tr>
                            <td class="tengah"><?= $mutasi['kode'] ?></td>
                            <td><?= $mutasi['nama'] ?></td>
                            <td class="blok2"></td>
                            <td class="kanan"><?= number_format(0, 2, ',', '.'); ?></td>
                            <td class="kanan"><?= number_format(0, 2, ',', '.'); ?></td>
                            <td class="kanan"><?= number_format(0, 2, ',', '.'); ?></td>
                            <td class="blok2"></td>
                            <td class="kanan"><?= number_format(0, 2, ',', '.'); ?></td>
                        </tr>
                <?php }
                }
            }
            if ($type == 'debet') { ?>
                <tr class="biru">
                    <td></td>
                    <td><?= $jenis['nama'] ?></td>
                    <td class="kanan"><?= number_format($jml_awal, 2, ',', '.'); ?></td>
                    <td class="blok2"></td>
                    <td class="kanan"><?= number_format($jml_debet, 2, ',', '.'); ?></td>
                    <td class="kanan"><?= number_format($jml_kredit, 2, ',', '.'); ?></td>
                    <td class="kanan"><?= number_format($jml_akhir, 2, ',', '.'); ?></td>
                    <td class="blok2"></td>
                </tr>
            <?php
            } else { ?>
                <tr class="biru">
                    <td></td>
                    <td><?= $jenis['nama'] ?></td>
                    <td class="blok2"></td>
                    <td class="kanan"><?= number_format($jml_awal, 2, ',', '.'); ?></td>
                    <td class="kanan"><?= number_format($jml_debet, 2, ',', '.'); ?></td>
                    <td class="kanan"><?= number_format($jml_kredit, 2, ',', '.'); ?></td>
                    <td class="blok2"></td>
                    <td class="kanan"><?= number_format($jml_akhir, 2, ',', '.'); ?></td>
                </tr>
        <?php
            }
        } ?>
        <tr>
            <td></td>
            <td><b>TOTAL</b></td>
            <td class="kanan"><b><?= number_format($total_awal_debet, 2, ',', '.'); ?></b></td>
            <td class="kanan"><b><?= number_format($total_awal_kredit, 2, ',', '.'); ?></b></td>
            <td class="kanan"><b><?= number_format($total_debet, 2, ',', '.'); ?></b></td>
            <td class="kanan"><b><?= number_format($total_kredit, 2, ',', '.'); ?></b></td>
            <td class="kanan"><b><?= number_format($total_akhir_debet, 2, ',', '.'); ?></b></td>
            <td class="kanan"><b><?= number_format($total_akhir_kredit, 2, ',', '.'); ?></b></td>
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