<!DOCTYPE html>
<html>

<head>
    <meta charset='UTF-8'>
    <title>Cetak <?= $title ?></title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <link rel="stylesheet" href="<?= base_url() ?>assets/stisla/vendors/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/stisla/build/css/custom.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/stisla/build/css/table-style.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/stisla/vendors/fontawesome/css/all.min.css">
    
    <style>
      body{
        font-family: Calibri;
        font-size: 14px;
        }
    </style>
    
</head>

<body>
    <div id="page-wrap">
        <div>
            <?= $action ?>
        </div>
        <br>
        <div id="print">
            <?php
            require_once('v_rugi_laba.php'); ?>

        </div>
        <script type="text/javascript">
            function cetak() {
                var printContents = document.getElementById('print').innerHTML;
                var originalContents = document.body.innerHTML;
                document.body.innerHTML = printContents;
                window.print();
                document.body.innerHTML = originalContents;
            }
        </script>
    </div>
</body>

</html>