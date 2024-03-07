<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form_Booking_<?php foreach ($data_reservasi as $peminjamanBarangDetail) : ?>
        <?= $data_reservasi[0]['kode_reservasi']; ?>
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
                            <center><b>BOOKING ALAT LABORATORIUM KEPERAWATAN AKPER "YKY" YOGYAKARTA
                                </b></CENTER>
                        </h5>
        </div>
        <div class="gradient-line"></div>
        <br>
        <div>
            <h5>Identitas Peminjam:</h5>

            <table class="table table-sm table-borderless">
                <?php if (!empty($data_reservasi)) : ?>
                    <tr>
                        <td width="30%">Kode Reservasi </td>
                        <td width="5%">:</td>
                        <td><?= $data_reservasi[0]['kode_reservasi']; ?></td>
                    </tr>
                    <tr>
                        <td width="30%">Nama Peminjam </td>
                        <td width="5%">:</td>
                        <td><?= $data_reservasi[0]['nama_peminjam']; ?></td>
                    </tr>

                    <tr>
                        <td width="30%">Tanggal Penggunaan </td>
                        <td width="5%">:</td>
                        <td><?php
                            $tanggal_penggunaan = \CodeIgniter\I18n\Time::parse($data_reservasi[0]['tanggal_penggunaan'])
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

                            $nama_hari = [
                                'Sunday' => 'Minggu',
                                'Monday' => 'Senin',
                                'Tuesday' => 'Selasa',
                                'Wednesday' => 'Rabu',
                                'Thursday' => 'Kamis',
                                'Friday' => 'Jumat',
                                'Saturday' => 'Sabtu',
                            ];

                            $bulan = $nama_bulan[$tanggal_penggunaan->format('F')];
                            $hari = $nama_hari[$tanggal_penggunaan->format('l')];

                            // Format the date without using Carbon
                            $formattedDate = $hari . ', ' . $tanggal_penggunaan->format('d ') . $bulan . $tanggal_penggunaan->format(' Y - H:i') . ' WIB';

                            echo $formattedDate;
                            ?>

                        </td>
                    </tr>
                    <tr>
                        <td width="30%">Tanggal Kembali </td>
                        <td width="5%">:</td>
                        <td><?php
                            $tanggal_kembali = \CodeIgniter\I18n\Time::parse($data_reservasi[0]['tanggal_pengembalian'])
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

                            $nama_hari = [
                                'Sunday' => 'Minggu',
                                'Monday' => 'Senin',
                                'Tuesday' => 'Selasa',
                                'Wednesday' => 'Rabu',
                                'Thursday' => 'Kamis',
                                'Friday' => 'Jumat',
                                'Saturday' => 'Sabtu',
                            ];

                            $bulan = $nama_bulan[$tanggal_kembali->format('F')];
                            $hari = $nama_hari[$tanggal_kembali->format('l')];

                            // Format the date without using Carbon
                            $formattedDate = $hari . ', ' . $tanggal_kembali->format('d ') . $bulan . $tanggal_kembali->format(' Y - H:i') . ' WIB';

                            echo $formattedDate;
                            ?>

                        </td>
                    </tr>
                    <tr>
                        <td width="30%">Nama Dosen </td>
                        <td width="5%">:</td>
                        <td><?= $data_reservasi[0]['nama_dosen']; ?></td>
                    </tr>
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
                <strong>Daftar Booking Alat Laboratorium Keperawatan: </strong>
            </h5>
        </div>
        <table class="table table-border">
            <thead class="table table-border">
                <tr>
                    <th>#</th>
                    <th>Tempat Penggunaan</th>
                    <th>Keperluan</th>
                    <th>Nama Barang Yang Akan Dipinjam</th>
                </tr>
            </thead>
            <tbody class="table-border">
                <?php
                $counter = 1; // Initialize a counter variable

                foreach ($data_reservasi as $peminjamanBarangDetail) :
                ?>
                    <tr>
                        <td style=" text-align: center; vertical-align: middle;"><?= $counter; ?></td>
                        <td style="text-align: center; vertical-align: middle;"><?= $peminjamanBarangDetail['nama_ruangan']; ?></td>
                        <td style="text-align: center; vertical-align: middle;"><?= $peminjamanBarangDetail['keperluan']; ?></td>
                        <td style="text-align: left;">
                            <?php
                            // Split the values by comma
                            $barang_dipinjam_values = explode(',', $peminjamanBarangDetail['barang_dipinjam']);

                            // Loop through the values and display each on a new line
                            foreach ($barang_dipinjam_values as $value) {
                                echo $counter . '. ' . $value . "<br>";
                                $counter++;
                            }
                            ?>
                        </td>
                    </tr>
                <?php
                endforeach;
                ?>
            </tbody>
        </table>


        <br>






    </div>


    <div class="container mt-2">
        <div class="row">

            <div class="col-8 page-break">

            </div>
            <div class="col-4 page-break">
                <tr>
                    <td width="30%">Bantul, </td>
                    <td><?php
                        $tanggal_pinjam = \CodeIgniter\I18n\Time::parse($data_reservasi[0]['tanggal_pinjam'])
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
                        $formattedDate = $tanggal_pinjam->format('d ') . $bulan . $tanggal_pinjam->format(' Y');

                        echo $formattedDate;
                        ?>

                    </td>
                </tr>
                <p> </p>
                <p> Peminjam </p>

                <br>

                <br>
                </br>
                <p class="underlined-text"><b><?php
                                                // Contoh data
                                                $peminjamanData = $data_reservasi[0]['nama_peminjam'];

                                                // Memisahkan string berdasarkan tanda "-"
                                                $splitData = explode('-', $peminjamanData);

                                                // Mengambil elemen kedua setelah pemisahan
                                                $namaPeminjam = isset($splitData[1]) ? trim($splitData[1]) : '';

                                                // Menampilkan nama peminjam
                                                echo $namaPeminjam;
                                                ?></b></p>

            </div>
        </div>
    </div>


</body>

</html>