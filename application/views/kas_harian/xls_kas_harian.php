<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=kas_harian_" . $tahun . ".xls");
?>
<link rel="stylesheet" href="<?= base_url() ?>assets/stisla/build/css/table-style.css">

<?php require_once('v_kas_harian.php') ?>