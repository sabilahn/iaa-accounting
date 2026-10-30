<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Aktivitas User</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="<?= site_url() ?>dashboard">Dashboard</a></div>
                <div class="breadcrumb-item">Setting</div>
                <div class="breadcrumb-item">Aktivitas User</div>
            </div>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h2 class="section-title">Aktivitas User</h2>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="table-1">
                            <thead>
                                <tr class="text-center">
                                    <th>No.</th>
                                    <th>Kode</th>
                                    <th>Nama</th>
                                    <th>Aktivitas</th>
                                    <th>Waktu</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 0;
                                foreach ($activities as $activity) {
                                    $no++
                                ?>
                                    <tr>
                                        <td class="text-center"><?= $no ?></td>
                                        <td><?= $activity['user_id'] ?></td>
                                        <td><?= $activity['username'] ?></td>
                                        <td><?= $activity['activity'] ?></td>
                                        <td class="text-center"><?= $activity['times'] ?></td>
                                    </tr>
                                <?php
                                }
                                ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
    </section>
</div>