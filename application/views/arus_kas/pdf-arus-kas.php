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
                <h2 class="text-center" style="font-size: 14px;"><b>LAPORAN ARUS KAS (CASH FLOW) CV. DHARMA IAA <br> PERIODE : <?= strtoupper($nama_bulan) . " " . $tahun ?></b></h2>
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
            $jml_masuk = 0;
            $jml_keluar = 0;

            foreach ($data_jumlah as $jumlah) {
            ?>

                <tr class="biru">
                    <td></td>
                    <td><b>PENERIMAAN</b></td>
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