<p></p>
<h2 class="tengah" style="font-size: 14px;"><b>LAPORAN KAS CV. DHARMA IAA <br> PERIODE : <?= strtoupper($nama_bulan) . " " . $tahun ?></b></h2>
<p></p>
<table>
    <thead>
        <tr class="tengah">
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