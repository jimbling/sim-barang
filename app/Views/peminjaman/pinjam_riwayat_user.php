<?php echo view('tema/header.php'); ?>
<style>
    /* CSS untuk mengatur ukuran font menjadi 13px */
    .table td,
    .table th {
        font-size: 13px;
    }
</style>
<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h5 class="m-0">Riwayat Peminjaman Barang</h5>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Riwayat Pinjam</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>


    <div class="content">
        <div class="container-fluid">


            <div class="row">
                <div class="col-md-12 col-12">
                    <div class="card card-primary card-outline shadow-lg">

                        <div class="card-body">


                            <table id="daftarRiwayatPeminjamanUser" class="table table-striped table-sm table-hover" width="100%">
                                <thead class="thead-dark" style="font-size: 13px;">
                                    <tr>
                                        <th width='3%'>No</th>
                                        <th style="text-align: center; font-size: 13px;">Kode Pinjam</th>
                                        <th style="text-align: center; font-size: 13px;">Nama Peminjam</th>
                                        <th style="text-align: center; font-size: 13px;">Tanggal Pinjam</th>
                                        <th style="text-align: center; font-size: 13px;">Digunakan untuk</th>
                                        <th style="text-align: center; font-size: 13px;">Nama Barang</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php $i = 1; // Deklarasi di luar loop foreach 
                                    ?>
                                    <?php if (isset($data_peminjaman) && count($data_peminjaman) > 0) : ?>
                                        <?php foreach ($data_peminjaman as $index => $peminjaman) : ?>
                                            <tr>
                                                <!-- Nomor urut -->
                                                <th class="text-center" scope="row" style="vertical-align: middle; font-size: 13px;"><?= $i++; ?></th>
                                                <!-- Kode Pinjam -->
                                                <td style="text-align: center; font-size: 13px; vertical-align: middle;">
                                                    <?= $peminjaman['kode_pinjam'] ?>
                                                </td>
                                                <!-- Nama Peminjam -->
                                                <td style="text-align: center; font-size: 13px; vertical-align: middle;">
                                                    <?= $peminjaman['nama_peminjam'] ?>
                                                </td>
                                                <!-- Tanggal Pinjam dengan format Indonesia -->
                                                <td width='11%' style="text-align: center; vertical-align: middle; font-size: 13px;">
                                                    <?php
                                                    // Konversi tanggal ke format Indonesia
                                                    $tanggal_pinjam = \CodeIgniter\I18n\Time::parse($peminjaman['tanggal_pinjam'])->setTimezone('Asia/Jakarta');

                                                    $nama_bulan = [
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
                                                        'December' => 'Desember',
                                                    ];

                                                    $bulan = $nama_bulan[$tanggal_pinjam->format('F')];
                                                    echo $tanggal_pinjam->format('d ') . $bulan . $tanggal_pinjam->format(' Y - H:i') . ' WIB';
                                                    ?>
                                                </td>
                                                <!-- Keperluan -->
                                                <td style="text-align: center; font-size: 13px; vertical-align: middle;">
                                                    <?= $peminjaman['keperluan'] ?>
                                                </td>
                                                <!-- Barang yang Dipinjam -->
                                                <td width="30%" style="text-align: left; font-size: 13px; vertical-align: middle;">
                                                    <?php
                                                    if (isset($peminjaman['barang_dipinjam']) && count($peminjaman['barang_dipinjam']) > 0) {
                                                        echo '<ol>';
                                                        foreach ($peminjaman['barang_dipinjam'] as $barangIndex => $barang) {
                                                            echo '<li>' . $barang . '</li>';
                                                        }
                                                        echo '</ol>';
                                                    } else {
                                                        echo 'Tidak ada barang dipinjam';
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <tr>
                                            <td colspan="6">Tidak ada data peminjaman.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>






<script src="../../assets/dist/js/jquery-3.6.4.min.js"></script>



<?php echo view('tema/footer.php'); ?>