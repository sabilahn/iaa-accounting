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

        .column {
            float: left;
            width: 40%;
            padding: 10px;
            height: 300px;
        }

        .row:after {
            content: "";
            display: table;
            clear: both;
        }

        .left {
            width: 45%;
            float: left;
        }

        .right {
            margin-left: 50%;
            width: 45%;
        }

        .clear {
            clear: both;
        }
    </style>
</head>

<body>
    <table width=100%; style="padding-bottom: 20px;">
        <tr>
            <td style="text-align: center;" class="no-background">
                <h2 class="text-center" style="font-size: 14px;"><b>JURNAL MEMORIAL CV. DHARMA IAA <br> PERIODE : <?= strtoupper($nama_bulan) . " " . $tahun ?></b></h2>
            </td>
        </tr>
    </table>
    <div>
        <table border="1">
            <thead>
                <tr class=" text-center">
                    <th>Kode Akun</th>
                    <th>Nama Perkiraan</th>
                    <th>Jumlah (Rp)</th>
                    <th>Kode Akun</th>
                    <th>Nama Perkiraan</th>
                    <th>Jumlah (Rp)</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $jml_debet = 0;
                $jml_kredit = 0;
                foreach ($data_jurnal as $jurnal) {
                    $jml_debet += $jurnal['debet'];
                    $jml_kredit += $jurnal['kredit']; ?>
                    <tr>
                        <td class="tengah"><?= $jurnal['kode'] ?></td>
                        <td><?= $jurnal['nama'] ?></td>
                        <td class="kanan"><?= number_format($jurnal['debet'], 2, ',', '.'); ?></td>
                        <td class="tengah"><?= $jurnal['kode'] ?></td>
                        <td><?= $jurnal['nama'] ?></td>
                        <td class="kanan"><?= number_format($jurnal['kredit'], 2, ',', '.'); ?></td>
                    </tr>
                <?php } ?>

                <tr class="biru">
                    <td></td>
                    <td><b>JUMLAH</b></td>
                    <td class="kanan"><b><?= number_format($jml_debet, 2, ',', '.'); ?></b></td>
                    <td></td>
                    <td><b>JUMLAH</b></td>
                    <td class="kanan"><b><?= number_format($jml_kredit, 2, ',', '.'); ?></b></td>
                </tr>
            </tbody>
        </table>
    </div>
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