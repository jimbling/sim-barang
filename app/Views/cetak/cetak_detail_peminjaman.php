<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Peminjaman_<?php foreach ($grouped_data as $kode_pinjam => $data) : ?>
        <?php echo $kode_pinjam; ?>
    <?php endforeach; ?>
    </title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../../assets/dist/css/adminlte.min.css?v=3.2.0">
    <link href="../../assets/dist/css/cetak.css" rel="stylesheet" type="text/css">
    <script>
        // Jalankan pencetakan saat halaman dimuat
        window.onload = function() {
            window.print();
        };
    </script>

    <style>
        th.center,
        td.center {
            padding: 10px;
            text-align: center;
        }
    </style>
</head>

<body>

    <div class="col-sm-10">

        <img src="../../assets/dist/img/<?php echo $dataPengaturan['kop_surat'] ?>" width="450px">
    </div>
    <div class="container-fluid">
        <div class="container mt-2">

            <h5>
                <CENTER><b>DETAIL PEMINJAMAN BARANG
                    </b></CENTER>
            </h5>
        </div>
        <div class="gradient-line"></div>
        <br>
        <div>
            <h5>Identitas Peminjam:</h5>

            <table class="table table-sm table-borderless">
                <?php if (!empty($grouped_data)) : ?>
                    <?php foreach ($grouped_data as $kode_pinjam => $data) : ?>
                        <tr>
                            <td width="30%">Kode Pinjam </td>
                            <td width="5%">:</td>
                            <td><?php echo $data[0]['kode_pinjam']; ?></td>
                        </tr>
                        <tr>
                            <td width="30%">Nama Peminjam </td>
                            <td width="5%">:</td>
                            <td><?php echo $data[0]['nama_peminjam']; ?></td>
                        </tr>
                        <tr>
                            <td width="30%">Tanggal Peminjaman </td>
                            <td width="5%">:</td>
                            <td>
                                <?php
                                $tanggal_pinjam = \CodeIgniter\I18n\Time::parse($data[0]['tanggal_pinjam'])
                                    ->setTimezone('Asia/Jakarta');

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

                                // Format the date without using Carbon
                                $formattedDate = $tanggal_pinjam->format('d ') . $bulan . $tanggal_pinjam->format(' Y - H:i') . ' WIB';

                                echo $formattedDate;
                                ?>

                            </td>
                        </tr>

                        <tr>
                            <td width="30%">Nama Dosen </td>
                            <td width="5%">:</td>
                            <td><?php echo $data[0]['nama_dosen']; ?></td>
                        </tr>
                        <tr>
                            <td width="30%">Tempat Penggunaan </td>
                            <td width="5%">:</td>
                            <td><?php echo $data[0]['nama_ruangan']; ?></td>
                        </tr>
                        <tr>
                            <td width="30%">Keperluan </td>
                            <td width="5%">:</td>
                            <td><?php echo $data[0]['keperluan']; ?></td>
                        </tr>

                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="4">Data peminjaman tidak ditemukan.</td>
                    </tr>
                <?php endif; ?>
            </table>

        </div>

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
                <?php foreach ($semua_data as $data_pinjam) : ?>
                    <tr>
                        <td class="center"><?= $data_pinjam['kode_pinjam']; ?></td>
                        <td class="center"><?= $data_pinjam['nama_barang']; ?></td>
                        <td class="center"><?= $data_pinjam['kode_barang']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="bg-secondary center">JUMLAH BARANG DIPINJAM: <?php echo count($semua_data); ?></td>
                </tr>
            </tfoot>
        </table>

        <div class="container page-break"> <br>
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
                                    <?php
                                    $timestamp = strtotime($item['tanggal_kembali']);
                                    $bulan = date('F', $timestamp);
                                    $bulanIndonesia = [
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
                                    $bulan = isset($bulanIndonesia[$bulan]) ? $bulanIndonesia[$bulan] : $bulan;
                                    echo date('d ', $timestamp) . $bulan . date(' Y H.i T', $timestamp);
                                    ?>
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
                        <td colspan="4" class="bg-secondary center">JUMLAH BARANG YANG DIKEMBALIKAN: <?php echo count($data); ?></td> <!-- Menghitung total barang -->
                    </tr>
                </tfoot>
            </table>
            <br>
        </div>

    </div>
    </div>
    </div>







    </div>
</body>

</html>