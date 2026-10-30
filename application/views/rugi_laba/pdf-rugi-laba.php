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
                <h2 class="text-center" style="font-size: 14px;"><b>RUGI LABA CV. DHARMA IAA <br> PERIODE : <?= strtoupper($nama_bulan) . ' ' . $tahun ?></b></h2>
            </td>
        </tr>
    </table>
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
                            <td class="kanan"><?= number_format($rugi_laba['mutasi_kredit'], 2, ',', '.'); ?></td>
                        </tr>
                <?php
                    }
                }
                ?>
                <tr class="biru">
                    <td></td>
                    <td>Pendapatan</td>
                    <td class="kanan"><?= number_format($pendapatan, 2, ',', '.'); ?></td>
                </tr>
                <?php
                foreach ($data_rugi_laba as $rugi_laba) {
                    if ($rugi_laba['jenis'] == '50') { ?>
                        <tr>
                            <td class="tengah"><?= $rugi_laba['kode'] ?></td>
                            <td><?= $rugi_laba['nama'] ?></td>
                            <td class="kanan"><?= number_format($rugi_laba['mutasi_debet'], 2, ',', '.'); ?></td>
                        </tr>
                <?php
                    }
                }
                ?>
                <tr class="biru">
                    <td></td>
                    <td>Biaya</td>
                    <td class="kanan"><?= number_format($biaya, 2, ',', '.'); ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>Laba Sebelum Pajak</td>
                    <td class="kanan"><?= number_format($laba_blm_pajak, 2, ',', '.'); ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>Pajak</td>
                    <td class="kanan"><?= number_format($pajak, 2, ',', '.'); ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>Laba Sesudah Pajak</td>
                    <td class="kanan"><?= number_format($laba_sdh_pajak, 2, ',', '.'); ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>Laba Bersih</td>
                    <td class="kanan"><?= number_format($laba_sdh_pajak, 2, ',', '.'); ?></td>
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