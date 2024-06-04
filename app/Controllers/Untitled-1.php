<?php echo view('template/header.php'); ?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard v1</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">


        <div class="row">
            <div class="col-lg-3 col-6">

                <div class="small-box bg-info">
                    <div class="inner">
                        <h3><?= $siswa_pip; ?></h3>
                        <p>Program Indonesia Pintar</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="#" class="small-box-footer">PIP <?= $currentYear; ?> </a>
                </div>
            </div>

            <div class="col-lg-3 col-6">

                <div class="small-box bg-success">
                    <div class="inner">
                        <h3><?= $jmlBSM; ?><sup style="font-size: 20px"></sup></h3>
                        <p>Bantuan Siswa Miskin</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="#" class="small-box-footer">BSM <?= $currentYear; ?> </a>
                </div>
            </div>

            <div class="col-lg-3 col-6">

                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3><?= $jmlSiabazku; ?></h3>
                        <p>Baznas Kulon Progo</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="#" class="small-box-footer">SiabazKu <?= $currentYear; ?> </a>
                </div>
            </div>

            <div class="col-lg-3 col-6">

                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3><?= $jmlLainnya; ?></h3>
                        <p>Bantuan Lainnya</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="#" class="small-box-footer">Bantuan Lainnya <?= $currentYear; ?> </a>
                </div>
            </div>
        </div>

        <div class="row">
            <section class="col-md-6 connectedSortable">
                <div class="card">
                    <div class="card-header bg-primary">
                        <h3 class="card-title">Pencarian dengan NISN</h3>
                    </div>
                    <div class="card-footer">
                        <form action="<?= base_url('search'); ?>" method="post">
                            <div class="input-group">
                                <input type="text" name="nisn" id="nisn" placeholder="Masukkan NISN ..." class="form-control" required>
                                <span class="input-group-append">
                                    <button type="submit" class="btn btn-primary">Cari</button>
                                </span>
                            </div>
                        </form>
                    </div>

                    <div class="card-body">
                        <?php if (!empty($_POST['nisn']) && empty($result)) : ?>
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'Tidak ditemukan',
                                        text: 'Maaf, peserta didik tidak ditemukan.'
                                    });
                                });
                            </script>
                        <?php endif; ?>
                        <?php if (!empty($result)) : ?>
                            <div class="container-fluid">
                                <?php $i = 1; ?>
                                <?php

                                $prevNISN = null;
                                $prevNama = null;

                                foreach ($result as $row) : ?>
                                    <?php if ($row['nisn'] !== $prevNISN || $row['nama_pd'] !== $prevNama) : ?>
                                        <dl class="row">
                                            <dt class="col-sm-4">NISN</dt>
                                            <dd class="col-sm-8"><?= $row['nisn']; ?></dd>
                                            <dt class="col-sm-4">Nama Peserta Didik</dt>
                                            <dd class="col-sm-8"><?= $row['nama_pd']; ?></dd>
                                        </dl>
                                        <table class="table">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Jenis Bantuan</th>
                                                    <th scope="col">Tanggal SK</th>
                                                    <th scope="col">Tahap</th>
                                                </tr>
                                            </thead>
                                        <?php endif; ?>
                                        <tbody>

                                            <tr>
                                                <th class="text-center" scope="row" style="font-size: 14px;"><?= $i++; ?></th>
                                                <td style="text-align: center; font-size: 14px;"><?= $row['jenis_bantuan']; ?></td>
                                                <td style="text-align: center; font-size: 14px;">
                                                    <?php
                                                    // Tanggal dari format database
                                                    $tanggal_database = $row['tanggal_sk'];

                                                    // Konversi tanggal ke format Indonesia
                                                    $tanggal_indonesia = date("d F Y", strtotime($tanggal_database));

                                                    // Daftar nama bulan dalam bahasa Indonesia
                                                    $bulan_indonesia = [
                                                        'January' => 'Januari',
                                                        'February' => 'Februari',
                                                        'March' => 'Maret',
                                                        'April' => 'April',
                                                        'May' => 'Mei',
                                                        'June' => 'Juni',
                                                        'July' => 'Juli',
                                                        'August' => 'Agustus',
                                                        'September' => 'September',
                                                        'October' => 'Oktober',
                                                        'November' => 'November',
                                                        'December' => 'Desember'
                                                    ];

                                                    // Ganti nama bulan dalam format Indonesia
                                                    $tanggal_indonesia = strtr($tanggal_indonesia, $bulan_indonesia);

                                                    // Tampilkan tanggal dalam format Indonesia
                                                    echo $tanggal_indonesia;
                                                    ?>
                                                </td>
                                                <td style="text-align: center; font-size: 14px;"><?= $row['tahap_id']; ?></td>

                                            </tr>
                                            <?php $prevNISN = $row['nisn'];
                                            $prevNama = $row['nama_pd']; ?>
                                        <?php endforeach; ?>
                                        </tbody>
                                        </table>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

            </section>


            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-danger">
                        <h3 class="card-title">Progres Pencairan PIP Tahun: <?= $currentYear; ?> </h3>
                    </div>
                    <div class="card-body">
                        <div class="progress" style="height: 30px;">
                            <?php if ($jumlah_siswa['sudah_diambil'] > 0) : ?>
                                <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: <?= ($jumlah_siswa['sudah_diambil'] / $jumlah_siswa['total']) * 100; ?>%;" aria-valuenow="<?= $jumlah_siswa['sudah_diambil']; ?>" aria-valuemin="0" aria-valuemax="<?= $jumlah_siswa['total']; ?>">
                                    <span class="progress-text"><?= $jumlah_siswa['sudah_diambil'] . ' / ' . $jumlah_siswa['total']; ?></span>
                                </div>
                            <?php else : ?>
                                <div class="progress-bar bg-secondary" role="progressbar" style="width: 100%;">
                                    <span class="progress-text">Belum Ada Peserta Didik (PD) yang mengambil dana di Bank</span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="card-footer row">
                        <div class="col-md-6">
                            <button type="button" class="btn btn-success btn-block btn-sm" data-toggle="modal" data-target="#modalSiswaSudah"> <?= ($jumlah_siswa['sudah_diambil']) ?> PD Sudah Mengambil </button>
                        </div>
                        <div class="col-md-6">
                            <button type="button" class="btn btn-danger btn-block btn-sm" data-toggle="modal" data-target="#modalSiswaBelum"> <?= ($jumlah_siswa['belum_diambil']) ?> PD Belum Mengambil Dana</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalSiswaSudah" tabindex="-1" role="dialog" aria-labelledby="modalSiswaSudahLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalSiswaSudahLabel">Siswa Sudah Mengambil Dana Di Bank Tahun: <?= $currentYear; ?> </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table-bordered table-striped table-responsive table-sm">
                        <thead class="thead-grey" style="font-size: 14px;">
                            <tr style="text-align: center;">
                                <th width='3%'>No</th>
                                <th>Nama Siswa</th>
                                <th>Kelas</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>

                            <?php
                            foreach ($sudah_mengambil as $ssw_sudah) : ?>
                                <tr>
                                    <td style="text-align: center;"><?= $i++; ?></td>
                                    <td style="text-align: left;">
                                        <?= $ssw_sudah['nama_pd']; ?>
                                    </td>
                                    <td style="text-align: center;"><?= $ssw_sudah['kelas']; ?></td>
                                    <td style="text-align: center;"><?= $ssw_sudah['ambil_dibank']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk siswa yang belum mengambil -->
<div class="modal fade" id="modalSiswaBelum" tabindex="-1" role="dialog" aria-labelledby="modalSiswaBelumLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalSiswaBelumLabel">Siswa Belum Mengambil Dana Di Bank Tahun: <?= $currentYear; ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table-bordered table-striped table-responsive table-sm">
                    <thead class="thead-grey" style="font-size: 14px;">
                        <tr style="text-align: center;">
                            <th width='3%'>No</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>

                        <?php
                        foreach ($belum_mengambil as $ssw_belum) : ?>
                            <tr>
                                <td style="text-align: center;"><?= $i++; ?></td>
                                <td style="text-align: left;">
                                    <?= $ssw_belum['nama_pd']; ?>
                                </td>
                                <td style="text-align: center;"><?= $ssw_belum['kelas']; ?></td>
                                <td style="text-align: center;"><?= $ssw_belum['ambil_dibank']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<?php echo view('template/footer.php'); ?>