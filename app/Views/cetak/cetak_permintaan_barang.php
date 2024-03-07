<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form_Permintaan_<?php
                            // Pastikan $peminjamanBarangDetails memiliki data sebelum mengakses indeks 0
                            if (!empty($peminjamanBarangDetails) && isset($peminjamanBarangDetails[0])) {
                                $namaPenggunaBarang = $peminjamanBarangDetails[0]->nama_pengguna_barang;
                                echo $namaPenggunaBarang;
                            }
                            ?>
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
</head>

<body>
    <div class="col-sm-10">
        <img src="../../assets/dist/img/<?php echo $dataPengaturan['kop_surat'] ?>" width="450px">
    </div>
    <div class="container-fluid">
        <div class="container mt-2">
            <h3>
                <center><b>F O R M U L I R

                        </h4>
                        <h5>
                            <center><b>PERMINTAAN BARANG HABIS PAKAI LABORATORIUM KEPERAWATAN
                                </b></CENTER>
                        </h5>
        </div>
        <div class="gradient-line"></div>
        <br>
        <div>
            <h6>Identitas Pengguna:</h6>

            <table class="table table-sm table-borderless">

                <?php if (!empty($peminjamanBarangDetails)) : ?>
                    <tr>
                        <td width="30%">Nama Pengguna </td>
                        <td width="5%">:</td>
                        <td><?php
                            // Pastikan $peminjamanBarangDetails memiliki data sebelum mengakses indeks 0
                            if (!empty($peminjamanBarangDetails) && isset($peminjamanBarangDetails[0])) {
                                $namaPenggunaBarang = $peminjamanBarangDetails[0]->nama_pengguna_barang;
                                echo $namaPenggunaBarang;
                            }
                            ?></td>
                    </tr>
                    <tr>
                        <td width="30%">Tanggal Permintaan </td>
                        <td width="5%">:</td>
                        <td><?php
                            $tanggal_penggunaan = \CodeIgniter\I18n\Time::parse($peminjamanBarangDetails[0]->tanggal_penggunaan)
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

                            $bulan = $nama_bulan[$tanggal_penggunaan->format('F')];

                            // Format the date without using Carbon
                            $formattedDate = $tanggal_penggunaan->format('d ') . $bulan . $tanggal_penggunaan->format(' Y');

                            echo $formattedDate;
                            ?>

                        </td>
                    </tr>
                    <tr>
                        <td width="30%">Keperluan </td>
                        <td width="5%">:</td>
                        <td><?php
                            // Pastikan $peminjamanBarangDetails memiliki data sebelum mengakses indeks 0
                            if (!empty($peminjamanBarangDetails) && isset($peminjamanBarangDetails[0])) {
                                $keperluan = $peminjamanBarangDetails[0]->keperluan;
                                echo $keperluan;
                            }
                            ?></td>
                    </tr>
                <?php else : ?>
                    <tr>
                        <td colspan="4">Data peminjaman tidak ditemukan.</td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>

        <br>



        <br>
        <div class="underlined-text mb-2">
            <h5>
                <strong>Daftar Permintaan Barang Persediaan Laboratorium: </strong>
            </h5>
        </div>
        <br>
        <table class="table table-border">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Barang</th>
                    <th>Satuan</th>
                    <th>Jumlah Barang</th>

                    <!-- Add other table headers here -->
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; // Deklarasi di luar loop foreach 
                ?>
                <?php
                $previousUserId = null; // Inisialisasi variabel untuk menyimpan ID pengguna sebelumnya
                $totalBarang = 0; // Inisialisasi variabel untuk menyimpan total barang

                ?>
                <?php foreach ($peminjamanBarangDetails as $index => $detail) : ?>
                    <tr>
                        <th class="text-center" scope="row" style="vertical-align: middle; font-size: 13px;"><?= $i++; ?></th><!-- Cek apakah pengguna_id sudah ditampilkan sebelumnya -->
                        <td><?= $detail->nama_barang; ?></td>
                        <td><?= $detail->satuan; ?></td>
                        <td><?= $detail->ambil_barang_murni; ?></td>


                        <!-- Tambahkan jumlah barang dan total harga -->
                        <?php
                        $totalBarang += (int)$detail->ambil_barang_murni;

                        ?>
                    </tr>
                <?php endforeach; ?>

                <!-- Tampilkan total barang dan total harga di bagian bawah tabel -->
                <tr>
                    <td colspan="3" style="text-align: center; font-weight: bold;">Total</td>
                    <td style="text-align: center; font-weight: bold;"><?= $totalBarang; ?></td>

                </tr>
            </tbody>
            <!--  -->
        </table>





    </div>


    <div class="container mt-2">
        <div class="row">
            <div class="col page-break">
                <p> </p>
                <p> Pengguna Barang </p>

                <br>

                <br>
                </br>
                <p class="underlined-text"><b>
                        <?php
                        // Pastikan $peminjamanBarangDetails memiliki data sebelum mengakses indeks 0
                        if (!empty($peminjamanBarangDetails) && isset($peminjamanBarangDetails[0])) {
                            $namaPenggunaBarang = $peminjamanBarangDetails[0]->nama_pengguna_barang;
                            echo $namaPenggunaBarang;
                        }
                        ?>
                    </b></p>

            </div>
            <div class="col page-break">

                <p> Mengetahui,</p>
                <p> Laboran </p>

                <br>
                </br>
                <p class="underlined-text"><b> <?php echo $dataPengaturan['nama_laboran'] ?></b></p>
                NIK. <?php echo $dataPengaturan['nik_laboran'] ?>
            </div>
        </div>
    </div>


</body>

</html>