<p></p>
<h2 class="text-center" style="font-size: 14px;"><b>NERACA SALDO CV. DHARMA IAA <br> PERIODE : <?= strtoupper($nama_bulan) . ' ' . $tahun ?></b></h2>
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
        $laba_sdh_pajak = 0;
        $rugi_laba_akhir = 0;

        foreach ($data_jumlah as $jumlah) {
            $laba_blm_pajak = $jumlah['pendapatan'] - $jumlah['biaya'];
            $pajak = 0;
            $laba_sdh_pajak = $laba_blm_pajak - $pajak;
        }

        $total_awal_debet = 0;
        $total_awal_kredit = 0;
        $total_debet = 0;
        $total_kredit = 0;
        $total_akhir_debet = 0;
        $total_akhir_kredit = 0;

        foreach ($data_jenis as $jenis) {
            if ($jenis['kode'] != '40' && $jenis['kode'] != '50') {
                $jml_awal = 0;
                $jml_debet = 0;
                $jml_kredit = 0;
                $jml_akhir = 0;
                $type = null;
                foreach ($neraca_mutasi as $mutasi) {
                    if ($mutasi['jenis'] == $jenis['kode']) {
                        $jml_awal += $mutasi['saldo_awal'];
                        // $jml_debet += $mutasi['debet'];

                        if ($mutasi['kode'] != '3004') {
                            // $jml_kredit += mutasi['kredit'];
                            // $jml_debet += mutasi['debet'];
                            $jml_akhir += $mutasi['saldo_akhir'];
                            $type = $mutasi['type'];

                            if ($mutasi['type'] == 'debet') {
                                $total_awal_debet += $mutasi['saldo_awal'];
                                // $total_debet += $mutasi['debet'];
                                // $total_kredit += $mutasi['kredit'];
                                $total_akhir_debet += $mutasi['saldo_akhir'];
                                ?>
                                <tr>
                                    <td class="tengah"><?= $mutasi['kode'] ?></td>
                                    <td><?= $mutasi['nama'] ?></td>
                                    <td class="kanan"><?= number_format($mutasi['saldo_awal'], 2, ',', '.'); ?></td>
                                    <td class="blok2"></td>
                                    <td class="kanan"><?= number_format(0, 2, ',', '.'); ?></td>
                                    <td class="kanan"><?= number_format(0, 2, ',', '.'); ?></td>
                                    <td class="kanan"><?= number_format($mutasi['saldo_awal'], 2, ',', '.'); ?></td>
                                    <td class="blok2"></td>
                                </tr>
                            <?php
                            } else {
                                $total_awal_kredit += $mutasi['saldo_awal'];
                                // $total_debet += $mutasi['debet'];
                                // $total_kredit += $mutasi['kredit'];
                                $total_akhir_kredit += $mutasi['saldo_akhir'];
                            ?>
                                <tr>
                                    <td class="tengah"><?= $mutasi['kode'] ?></td>
                                    <td><?= $mutasi['nama'] ?></td>
                                    <td class="blok2"></td>
                                    <td class="kanan"><?= number_format($mutasi['saldo_awal'], 2, ',', '.'); ?></td>
                                    <td class="kanan"><?= number_format(0, 2, ',', '.'); ?></td>
                                    <td class="kanan"><?= number_format(0, 2, ',', '.'); ?></td>
                                    <td class="blok2"></td>
                                    <td class="kanan"><?= number_format($mutasi['saldo_awal'], 2, ',', '.'); ?></td>
                                </tr>
                            <?php
                            }
                        } else {
                            $shu_awal = $mutasi['saldo_awal'];
                            $rugi_laba_akhir = $shu_awal - $mutasi['debet'] + $laba_sdh_pajak;
                            // $rugi_laba_akhir = $shu_awal - $mutasi['debet'];

                            $total_awal_kredit += $shu_awal;
                            $total_kredit += $laba_sdh_pajak;
                            $total_akhir_kredit += $rugi_laba_akhir;
                            ?>

                            <tr>
                                <td class="tengah"><?= $mutasi['kode'] ?></td>
                                <td><?= $mutasi['nama'] ?></td>
                                <td class="blok2"></td>
                                <td class="kanan"><?= number_format($shu_awal, 2, ',', '.'); ?></td>
                                <td class="kanan"><?= number_format($mutasi['debet'], 2, ',', '.'); ?></td>
                                <!-- <td class="kanan"><?= number_format($mutasi['kredit'], 2, ',', '.'); ?></td> -->
                                <td class="kanan"><?= number_format($laba_sdh_pajak, 2, ',', '.'); ?></td>
                                <td class="blok2"></td>
                                <td class="kanan"><?= number_format($rugi_laba_akhir, 2, ',', '.'); ?></td>
                            </tr>

                        <?php
                        }
                    }
                }
                if ($jenis['kode'] != '30') {
                    if ($type == 'debet') { ?>
                        <tr class="biru">
                            <td></td>
                            <td><?= $jenis['nama'] ?></td>
                            <td class="kanan"><?= number_format($jml_awal, 2, ',', '.'); ?></td>
                            <td class="blok2"></td>
                            <td class="kanan"><?= number_format($jml_debet, 2, ',', '.'); ?></td>
                            <td class="kanan"><?= number_format($jml_kredit, 2, ',', '.'); ?></td>
                            <td class="kanan"><?= number_format($jml_awal, 2, ',', '.'); ?></td>
                            <td class="blok2"></td>
                        </tr>
                    <?php } else { ?>
                        <tr class="biru">
                            <td></td>
                            <td><?= $jenis['nama'] ?></td>
                            <td class="blok2"></td>
                            <td class="kanan"><?= number_format($jml_awal, 2, ',', '.'); ?></td>
                            <td class="kanan"><?= number_format($jml_debet, 2, ',', '.'); ?></td>
                            <td class="kanan"><?= number_format($jml_kredit, 2, ',', '.'); ?></td>
                            <td class="blok2"></td>
                            <td class="kanan"><?= number_format($jml_awal, 2, ',', '.'); ?></td>
                        </tr>
                    <?php
                    }
                } else {
                    $jml_kredit_equitas = $jml_kredit + $laba_sdh_pajak;

                    // $total_kredit = $total_kredit + $jml_kredit_equitas;

                    $jml_akhir_equitas = $jml_akhir + $rugi_laba_akhir;
                    // $total_akhir_kredit = $total_akhir_kredit + $jml_akhir_equitas;
                    // var_dump($jml_akhir_equitas);
                    // die;
                    ?>
                    <tr class="biru">
                        <td></td>
                        <td><?= $jenis['nama'] ?></td>
                        <td class="blok2"></td>
                        <td class="kanan"><?= number_format($jml_awal, 2, ',', '.'); ?></td>
                        <td class="kanan"><?= number_format($jml_debet, 2, ',', '.'); ?></td>
                        <td class="kanan"><?= number_format($jml_kredit_equitas, 2, ',', '.'); ?></td>
                        <!-- <td class="kanan"><?= number_format($jml_kredit, 2, ',', '.'); ?></td> -->
                        <td class="blok2"></td>
                        <td class="kanan"><?= number_format($jml_akhir_equitas, 2, ',', '.'); ?></td>
                        <!-- <td class="kanan"><?= number_format($jml_awal, 2, ',', '.'); ?></td> -->
                    </tr>

        <?php }
            }
        }
        
        if ($total_debet < 0) {
            $modifier_debet = -1;
        } else {
            $modifier_debet = 1;
        }
        
        if ($total_kredit < 0) {
            $modifier_kredit = -1;
        } else {
            $modifier_kredit = 1;
        }
?>
        <tr>
            <td></td>
            <td><b>TOTAL</b></td>
            <td class="kanan"><b><?= number_format($total_awal_debet, 2, ',', '.'); ?></b></td>
            <td class="kanan"><b><?= number_format($total_awal_kredit, 2, ',', '.'); ?></b></td>
            <td class="kanan"><b><?= number_format($total_debet, 2, ',', '.'); ?></b></td>
            <td class="kanan"><b><?= number_format($total_kredit, 2, ',', '.'); ?></b></td>
            <!--<td class="kanan"><b><?= number_format($total_akhir_debet, 2, ',', '.'); ?></b></td>-->
            <!--<td class="kanan"><b><?= number_format($total_akhir_kredit, 2, ',', '.'); ?></b></td>-->
            <td class="kanan"><b><?= number_format($total_awal_debet-($total_debet * $modifier_debet), 2, ',', '.'); ?></b></td>
            <td class="kanan"><b><?= number_format($total_awal_kredit-($total_kredit * $modifier_kredit), 2, ',', '.'); ?></b></td>
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