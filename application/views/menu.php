<?php
$thisPage = $this->uri->segment(1);
$thisPage1 = $this->uri->segment(2);

?>
<!-- sidebar -->
<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <br>
        <div class="sidebar-brand">
            <a href="<?= base_url() ?>dashboard"><img src="<?= base_url() ?>assets/stisla/images/iaa.png" alt="logo" width="120">
                <h4></h4>
                <h6 style="color: #fff;">ACCOUNTING</h6>
            </a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="<?= base_url() ?>dashboard"><img src="<?= base_url() ?>assets/stisla/images/iaa.png" alt="logo" width="50">
            </a>
        </div>
        <br><br>
        <ul class="sidebar-menu">
            <li class="<?= ($thisPage == 'dashboard') ? 'active' : ''; ?>"><a class="nav-link" href="<?= site_url('dashboard') ?>"><i class="fas fa-home"></i><span>Dashboard</span></a></li>
            <li class="<?= ($thisPage == 'data_master') ? 'dropdown active' : 'dropdown'; ?>">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-university"></i>
                    <span>Data Master</span></a>
                <ul class="dropdown-menu">
                    <li class="<?= ($thisPage1 == 'jenis_akun') ? 'active' : ''; ?>"><a class="nav-link" href="<?= site_url() ?>data_master/jenis_akun">Jenis Akun</a></li>
                    <li class="<?= ($thisPage1 == 'item_akun') ? 'active' : ''; ?>"><a class="nav-link" href="<?= site_url() ?>data_master/item_akun">Item Akun</a></li>
                </ul>
            </li>
            <li class="<?= ($thisPage == 'rincian_dan_rangkuman') ? 'dropdown active' : 'dropdown'; ?>">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-clipboard"></i>
                    <span>Rincian & Rangkuman</span></a>
                <ul class="dropdown-menu">
                    <li class="<?= ($thisPage1 == 'uang_masuk') ? 'active' : ''; ?>"><a class="nav-link" href="<?= site_url() ?>rincian_dan_rangkuman/uang_masuk">Uang Masuk</a></li>
                    <li class="<?= ($thisPage1 == 'uang_keluar') ? 'active' : ''; ?>"><a class="nav-link" href="<?= site_url() ?>rincian_dan_rangkuman/uang_keluar">Uang Keluar</a></li>
                </ul>
            </li>
            <li class="<?= ($thisPage == 'arus_kas') ? 'active' : ''; ?>"><a class="nav-link" href="<?= site_url() ?>arus_kas"><i class="fas fa-exchange-alt"></i> <span>Arus Kas</span></a>
            <li class="<?= ($thisPage == 'kas_harian') ? 'active' : ''; ?>"><a class="nav-link" href="<?= site_url() ?>kas_harian"><i class="fas fa-file"></i> <span>Kas Harian</span></a>
            <li class="<?= ($thisPage == 'jurnal_memorial') ? 'active' : ''; ?>"><a class="nav-link" href="<?= site_url() ?>jurnal_memorial"><i class="fas fa-journal-whills"></i> <span>Jurnal Memorial</span></a>
            <li class="<?= ($thisPage1 == 'neraca_mutasi') ? 'active' : ''; ?>"><a class="nav-link" href="<?= site_url() ?>neraca/neraca_mutasi"><i class="fas fa-balance-scale"></i> <span>Neraca Mutasi</span></a>
            <li class="<?= ($thisPage1 == 'neraca_penyesuaian') ? 'active' : ''; ?>"><a class="nav-link" href="<?= site_url() ?>neraca/neraca_penyesuaian"><i class="fas fa-angle-double-right"></i> <span>Neraca Penyesuaian</span></a>
            <li class="<?= ($thisPage == 'rugi_laba') ? 'active' : ''; ?>"><a class="nav-link" href="<?= site_url() ?>rugi_laba"><i class="fas fa-coins"></i> <span>Rugi Laba</span></a></li>
            <li class="<?= ($thisPage1 == 'neraca_saldo') ? 'active' : ''; ?>"><a class="nav-link" href="<?= site_url() ?>neraca/neraca_saldo"><i class="fas fa-balance-scale"></i> <span>Neraca Saldo</span></a>
                <!-- <li class="<?= ($thisPage == 'neraca') ? 'dropdown active' : 'dropdown'; ?>">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-balance-scale"></i>
                    <span>Neraca</span></a>
                <ul class="dropdown-menu">
                    <li class="<?= ($thisPage1 == 'neraca_mutasi') ? 'active' : ''; ?>"><a class="nav-link" href="<?= site_url() ?>neraca/neraca_mutasi">Neraca Mutasi</a></li>
                    <li class="<?= ($thisPage1 == 'neraca_saldo') ? 'active' : ''; ?>"><a class="nav-link" href="<?= site_url() ?>neraca/neraca_saldo">Neraca Saldo</a></li>
                </ul>
            </li> -->
                <?php
                if ($this->session->userdata('role') == 'super_user') { ?>
            <li class="<?= ($thisPage == 'users') ? 'dropdown active' : 'dropdown'; ?>">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-cog"></i>
                    <span>Setting</span></a>
                <ul class="dropdown-menu">
                    <li class="<?= ($thisPage1 == 'list') ? 'active' : ''; ?>"><a class="nav-link" href="<?= site_url() ?>users/list">Daftar User</a></li>
                    <li class="<?= ($thisPage1 == 'activity') ? 'active' : ''; ?>"><a class="nav-link" href="<?= site_url() ?>users/activity">Aktivitas User</a></li>
                </ul>
            </li>
        </ul>
    <?php
                }
    ?>
    <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
        <a href="<?= site_url('auth/logout') ?>" class="btn btn-light btn-lg btn-block btn-icon-split">
            <i class="fas fa-sign-out-alt"></i> <b>Logout</b>
        </a>
    </div>
    </aside>
</div>
<!-- /sidebar -->