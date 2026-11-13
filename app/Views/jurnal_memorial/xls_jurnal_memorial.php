<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=jurnal_memorial_" . $nama_bulan . "_" . $tahun . ".xls");
?>
<link rel="stylesheet" href="<?= base_url() ?>assets/stisla/build/css/table-style.css">

<?php require_once('v_jurnal_memorial.php') ?>