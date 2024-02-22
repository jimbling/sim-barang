<?php echo view('tema/header.php'); ?>

<div class="content-wrapper">
    <div class="container-fluid">

        <div id="layoutSidenav_content">
            <main>
                <header class="page-header bg-primary pb-10">
                    <div class="container-xl px-4">
                        <div class="page-header-content pt-0">
                            <div class="row align-items-center justify-content-between">

                            </div>
                        </div>
                    </div>
                </header>
                <!-- Main page content-->
                <div class="container-xl px-4 mt-n10">
                    <div class="row">
                        <div class="col-xl-4 mb-4">
                            <!-- Dashboard example card 1-->
                            <a class="card lift h-100">
                                <div class="circle circle-1">
                                    <span class="number">01</span>
                                </div>
                                <div class="card-body d-flex justify-content-center flex-column">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="me-3">
                                            <h5 class="text-primary">Booking Alat</h5>
                                            <div class="text-muted small">Mahasiswa, Dosen dan Tendik mengisi form Peminjaman barang laboratorium Keperawatan, ditambah dengan barang Habis Pakai jika memerlukan sebagai pendukung kegiatan.</div>
                                        </div>
                                        <img src="../../assets/dist/img/ilustrasi/browser-stats.svg" alt="..." style="width: 5rem" />
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-xl-4 mb-4">
                            <!-- Dashboard example card 2-->
                            <a class="card lift h-100">
                                <div class="circle circle-2">
                                    <span class="number">02</span>
                                </div>
                                <div class="card-body d-flex justify-content-center flex-column">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="me-3">
                                            <h5 class="text-primary">Verifikasi Laboran</h5>
                                            <div class="text-muted small">Laboran akan memeriksa ketersediaan barang dan menyiapkan barang sesuai pada form peminjaman dan permintaan barang.</div>
                                        </div>
                                        <img src="../../assets/dist/img/ilustrasi/fill.svg" alt="..." style="width: 5rem" />
                                    </div>
                                </div>
                            </a>

                        </div>

                        <div class="col-xl-4 mb-4">
                            <!-- Dashboard example card 3-->
                            <a class="card lift h-100">
                                <div class="circle circle-3">
                                    <span class="number">03</span>
                                </div>
                                <div class=" card-body d-flex justify-content-center flex-column">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="me-3">
                                            <h5 class="text-primary">Ambil dan Gunakan</h5>
                                            <div class="text-muted small">Mahasiswa, Dosen, dan Tendik bisa mengambil barang-barang yang diperlukan sesuai dengan form peminjaman dan permintaan barang.</div>
                                        </div>
                                        <img src="../../assets/dist/img/ilustrasi/print.svg" alt="..." style="width: 5rem" />
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card mt-3">
                    <div class="card-header border-0">
                        <h3 class="card-title">Data Peminjaman dan Permintaan Barang</h3>
                        <div class="card-tools">
                            <a href="#" class="btn btn-tool btn-sm">
                                <i class="fas fa-download"></i>
                            </a>
                            <a href="#" class="btn btn-tool btn-sm">
                                <i class="fas fa-bars"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0 table-sm">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Kode Pinjam</th>
                                    <th>Tanggal Peminjaman</th>
                                    <th>Nama Peminjam</th>
                                    <th>Detail</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                // Fungsi untuk membandingkan dua data berdasarkan created_at
                                function compareCreatedAt($a, $b)
                                {
                                    return strtotime($b['created_at']) - strtotime($a['created_at']);
                                }

                                // Menggunakan usort untuk menyortir array $data_peminjaman berdasarkan created_at
                                usort($data_peminjaman, 'compareCreatedAt');

                                $counter = 0; // Menambahkan variabel hitungan

                                foreach ($data_peminjaman as $dataPinjam) :
                                    if ($counter < 3) : // Menambahkan kondisi untuk membatasi tampilan hanya 3 data
                                ?>
                                        <tr>
                                            <!-- Kolom yang lain tetap seperti sebelumnya -->
                                            <td style="text-align: center; vertical-align: middle; font-size: 13px;">
                                                <?= $dataPinjam['kode_pinjam']; ?>
                                                <?php
                                                $created_at = strtotime($dataPinjam['created_at']);
                                                $now = time(); // Waktu saat ini dalam detik

                                                // Hitung selisih waktu dalam detik
                                                $selisih_detik = $now - $created_at;

                                                // Tampilkan badge "Baru" jika selisih waktu kurang dari 60 menit
                                                if ($selisih_detik < 60 * 60) : // 60 detik * 60 menit = 1 jam
                                                ?>
                                                    <span class="badge badge-danger">Baru</span>
                                                <?php endif; ?>
                                            </td>
                                            <td style="text-align: center; vertical-align: middle; font-size: 13px;">
                                                <?php
                                                $tanggal_pinjam = \CodeIgniter\I18n\Time::parse($dataPinjam['tanggal_pinjam'])
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

                                                echo $tanggal_pinjam->format('d ') . $bulan . $tanggal_pinjam->format(' Y - H:i') . ' WIB';
                                                ?>
                                            </td>
                                            <td style="text-align: center; vertical-align: middle; font-size: 13px;"><?= $dataPinjam['nama_peminjam']; ?></td>

                                            <td width='10%' class="text-center" style="text-align: center; vertical-align: middle;">
                                                <a href="<?= base_url('cetak_pinjam/' . $dataPinjam['peminjaman_id']); ?>" target="_blank">
                                                    <i class="fas fa-print" style='color:#CE5A67'></i>
                                                </a>
                                            </td>

                                        </tr>
                                <?php
                                        $counter++; // Menambahkan hitungan setiap kali loop berjalan
                                    endif;
                                endforeach;
                                ?>

                            </tbody>

                        </table>
                    </div>
                </div>

            </div>



        </div>
    </div>
</div>

<aside class="control-sidebar control-sidebar-dark">

    <div class="p-3">
        <h5>Title</h5>
        <p>Sidebar content</p>
    </div>
</aside>
<?php echo view('tema/footer.php'); ?>