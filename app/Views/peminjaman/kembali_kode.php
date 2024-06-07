<?php echo view('tema/header.php'); ?>

<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h5 class="m-0">Detail Peminjaman dan Pengembalian</h5>
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


            <?php foreach ($grouped_data as $kode_pinjam => $data) : ?>
                <div class="card card-primary card-outline shadow-lg mb-4">
                    <div class="card-header">
                        <h5 class="card-title">Detail Peminjaman - Kode Pinjam: <?php echo $kode_pinjam; ?></h5>
                        <!-- Tombol Cetak -->
                        <a href="<?= base_url('cetak/detail_pinjam/' . $kode_pinjam); ?>" class="btn btn-success btn-sm float-right" target="_blank">Cetak</a>
                        <!-- Tombol Kembali -->
                        <a href="<?= base_url('/pinjam/riwayat') ?>" class="btn btn-secondary btn-sm mr-2 float-right">Kembali</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">

                            <h5>Identitas Peminjam:</h5>

                            <table class="table table-sm table-borderless">
                                <?php if (!empty($grouped_data)) : ?>
                                    <?php foreach ($grouped_data as $kode_pinjam => $data) : ?>
                                        <tr>
                                            <td width="20%" style="text-align: left; vertical-align: middle;">Kode Pinjam </td>
                                            <td width=" 5%" style="text-align: left; vertical-align: middle;">:</td>
                                            <td style="text-align: left; vertical-align: middle;"><?php echo $data[0]['kode_pinjam']; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="20%" style="text-align: left; vertical-align: middle;">Nama Peminjam </td>
                                            <td width="5%" style="text-align: left; vertical-align: middle;">:</td>
                                            <td style="text-align: left; vertical-align: middle;"><?php echo $data[0]['nama_peminjam']; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="20%" style="text-align: left; vertical-align: middle;">Tanggal Peminjaman </td>
                                            <td width="5%" style="text-align: left; vertical-align: middle;">:</td>
                                            <td style="text-align: left; vertical-align: middle;"><?php echo $data[0]['tanggal_pinjam']; ?></td>
                                        </tr>

                                        <tr>
                                            <td width="20%" style="text-align: left; vertical-align: middle;">Nama Dosen </td>
                                            <td width="5%" style="text-align: left; vertical-align: middle;">:</td>
                                            <td style="text-align: left; vertical-align: middle;"><?php echo $data[0]['nama_dosen']; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="20%" style="text-align: left; vertical-align: middle;">Tempat Penggunaan </td>
                                            <td width="5%" style="text-align: left; vertical-align: middle;">:</td>
                                            <td style="text-align: left; vertical-align: middle;"><?php echo $data[0]['nama_ruangan']; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="20%" style="text-align: left; vertical-align: middle;">Keperluan </td>
                                            <td width="5%" style="text-align: left; vertical-align: middle;">:</td>
                                            <td style="text-align: left; vertical-align: middle;"><?php echo $data[0]['keperluan']; ?></td>
                                        </tr>

                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="4">Data peminjaman tidak ditemukan.</td>
                                    </tr>
                                <?php endif; ?>
                            </table>

                            <br>
                            <div class="underlined-text mb-2">
                                <h5>
                                    <strong>Daftar barang yang dipinjam: </strong>
                                </h5>
                            </div>
                            <table class="table table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Kode Pinjam</th>
                                        <th>Nama Barang</th>
                                        <th>Kode Barang</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data as $item) : ?>
                                        <tr>
                                            <td><?php echo $item['kode_pinjam']; ?></td>
                                            <td><?php echo $item['nama_barang']; ?></td>
                                            <td><?php echo $item['kode_barang']; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>

                                        <td colspan="3" class="bg-secondary">JUMLAH BARANG DIPINJAM: <?php echo count($data); ?></td>
                                    </tr>
                                </tfoot>
                            </table>

                            <br>
                            <br>
                            <div class="underlined-text mb-2">
                                <h5>
                                    <strong>Daftar pengembalian barang: </strong>
                                </h5>
                            </div>

                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Kode Kembali</th>
                                        <th>Tanggal Pengembalian</th>
                                        <th>Nama Barang</th>
                                        <th>Kode Barang</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $prevKodeKembali = ''; ?>
                                    <?php foreach ($data as $item) : ?>
                                        <?php if ($item['kode_kembali'] != $prevKodeKembali) : ?>
                                            <tr>
                                                <td rowspan="<?= count(array_filter($data, function ($row) use ($item) {
                                                                    return $row['kode_kembali'] == $item['kode_kembali'];
                                                                })) ?>">
                                                    <?php echo $item['kode_kembali']; ?>
                                                </td>
                                                <td rowspan="<?= count(array_filter($data, function ($row) use ($item) {
                                                                    return $row['kode_kembali'] == $item['kode_kembali'];
                                                                })) ?>">
                                                    <?php echo $item['tanggal_kembali']; ?>
                                                </td>
                                                <?php $prevKodeKembali = $item['kode_kembali']; ?>
                                            <?php endif; ?>
                                            <td><?php echo $item['nama_barang']; ?></td>
                                            <td><?php echo $item['kode_barang']; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4" class="bg-secondary">JUMLAH BARANG YANG DIKEMBALIKAN: <?php echo count($data); ?></td> <!-- Menghitung total barang -->
                                    </tr>
                                </tfoot>
                            </table>
                            <br>

                        </div>
                    </div>
                </div>
            <?php endforeach; ?>



        </div>
    </div>

</div>



<?php echo view('tema/footer.php'); ?>