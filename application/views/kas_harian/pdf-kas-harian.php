<!DOCTYPE html>
<html>

<head>
    <meta charset='UTF-8'>
    <title>Export <?= $title ?></title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">

    <link rel="stylesheet" href="<?= base_url() ?>assets/stisla/vendors/fontawesome/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
        }

        body {
            /*font: 10px/1.0 Georgia, Serif; */
            font: 10px/1.0 Calibri;
            /*text-align: center;*/
        }

        #page-wrap {
            margin: 50px;
        }

        p {
            margin: 20px 0;
        }

        h1 {
            text-align: center;
        }

        h2 {
            text-align: center;
        }

        h3 {
            text-align: left;
        }

        /*
	Generic Styling, for Desktops/Laptops
	*/
        table {
            width: 100%;
            border-collapse: collapse;
        }

        td.no-border {
            border: 0;
        }

        /* Zebra striping */
        tr:nth-of-type(odd) {
            background: #eee;
        }

        th {
            background: #333;
            color: white;
            font-weight: bold;
            padding: 6px;
            border: 1px solid #ccc;
            text-align: center;

        }

        td {
            padding: 6px;
            border: 1px solid #ccc;
            /*text-align: left; 	*/
        }

        tr.putih {
            background: #fff;
        }

        tr.biru {
            background: #05f0fc;
            font-weight: bold;
        }

        .kiri {
            text-align: left;
        }

        .tengah {
            text-align: center;
        }

        .kanan {
            text-align: right;
        }

        .prg {
            text-align: left;
            font-weight: bold;
        }

        .black {
            background: #000;
        }

        .red {
            color: red;
        }

        @page {
            margin: 70px;
        }

        body {
            margin: 70px;
        }

        .no-background {
            background: white;
            border: white;
        }
    </style>
</head>

<body>
    <table width=100%; style="padding-bottom: 20px;">
        <tr>
            <td style="text-align: center;" class="no-background">
                <h2 class="tengah" style="font-size: 14px;"><b>LAPORAN KAS CV. DHARMA IAA <br> <?= strtoupper($nama_bulan) . " " . $tahun ?></b></h2>
            </td>
        </tr>
    </table>
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
                <td class="kanan"><b><?= number_format($saldo_awal, 2, ',', '.') ?></b></td>
            </tr>
            <?php

            foreach ($data_kas as $kas) {
            ?>
                <tr>
                    <td class="tengah"><?= $kas[0] ?></td>
                    <td class="tengah"><?= $kas[1] ?></td>
                    <td><?= $kas[2] ?></td>
                    <?php
                    if ($kas[3] != '-') {
                        echo '<td  class="kanan">' . number_format($kas[3], 2, ',', '.') . '</td>';
                    } else {
                        echo '<td></td>';
                    }

                    if ($kas[4] != '-') {
                        echo '<td  class="kanan">' . number_format($kas[4], 2, ',', '.') . '</td>';
                    } else {
                        echo '<td></td>';
                    } ?>
                    <td class="kanan"><?= number_format($kas[5], 2, ',', '.'); ?></td>
                </tr>
            <?php
            } ?>

        </tbody>
    </table>
    <table class="no-background">
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
</body>

</html>