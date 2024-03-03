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
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-indigo elevation-1"><i class="fas fa-calendar-alt"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Booking Peminjaman</span>
                        <h5><span class="info-box-number">
                                <?= $jumlah_booking; ?>
                            </span></h5>
                    </div>

                </div>

            </div>

            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-olive elevation-1"><i class="fas fa-clipboard-check"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Peminjaman Aktif</span>
                        <h5><span class="info-box-number">
                                <?= $jumlah_peminjaman; ?>
                            </span></h5>
                    </div>

                </div>

            </div>


            <div class="clearfix hidden-md-up"></div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-boxes"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Barang Inven (Baik)</span>
                        <h5><span class="info-box-number">
                                <?= number_format($jumlah_barangBaik, 0, ',', '.'); ?>
                            </span></h5>
                    </div>

                </div>

            </div>

            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-archive"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Barang Inven Rusak</span>
                        <h5><span class="info-box-number">
                                <?= $jumlah_barangRusak; ?>
                            </span></h5>
                    </div>

                </div>

            </div>

        </div>

        <div class="row">
            <div class="col-lg-7">
                <div class="card">
                    <div class="card-header border-0 bg-olive ">
                        <h3 class="card-title">Data Peminjaman dan Permintaan Barang Aktif</h3>
                    </div>
                    <div class="card-body table-responsive p-0 table-sm">
                        <table class="table table-striped">
                            <thead style="font-size: 13px;">
                                <tr>
                                    <th>Kode Pinjam</th>
                                    <th>Tanggal Pinjam</th>
                                    <th>Tanggal Kembali</th>
                                    <th>Nama</th>
                                    <th>Aksi</th>
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
                                            <td width="25%" style="text-align: left; vertical-align: middle; font-size: 13px;">
                                                <?= $dataPinjam['kode_pinjam']; ?>
                                                <?php
                                                $created_at = strtotime($dataPinjam['created_at']);
                                                $now = time(); // Waktu saat ini dalam detik

                                                // Hitung selisih waktu dalam detik
                                                $selisih_detik = $now - $created_at;

                                                // Tampilkan badge "Baru" jika selisih waktu kurang dari 60 menit
                                                if ($selisih_detik < 60 * 60) : // 60 detik * 60 menit = 1 jam
                                                ?>
                                                    <span class="badge badge-danger float-left">BARU</span>
                                                <?php endif; ?>
                                            </td>
                                            <td width="20%" style="text-align: center; vertical-align: middle; font-size: 13px;">
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
                                            <td width="20%" style="text-align: center; vertical-align: middle; font-size: 13px;">
                                                <?php
                                                $tanggal_kembali = \CodeIgniter\I18n\Time::parse($dataPinjam['tanggal_pengembalian'])->setTimezone('Asia/Jakarta');

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

                                                $bulan = $nama_bulan[$tanggal_kembali->format('F')];
                                                $waktu = $tanggal_kembali->format('d ') . $bulan . $tanggal_kembali->format(' Y - H:i') . ' WIB';

                                                // Jika tanggal pengembalian adalah hari ini atau melebihi tanggal saat ini, tambahkan badge "JATUH TEMPO"
                                                if ($tanggal_kembali->toDateString() === date('Y-m-d') || $tanggal_kembali < \CodeIgniter\I18n\Time::now('Asia/Jakarta')) {
                                                    $waktu .= '<br><span class="badge badge-danger">JATUH TEMPO</span>';
                                                }

                                                echo $waktu;
                                                ?>
                                            </td>
                                            <td style="text-align: center; vertical-align: middle; font-size: 13px;"><?= $dataPinjam['nama_peminjam']; ?></td>

                                            <td width='10%' class="text-center" style="text-align: center; vertical-align: middle;">
                                                <a href="<?= base_url('cetak_pinjam/' . $dataPinjam['peminjaman_id']); ?>" target="_blank">
                                                    <i class="fas fa-print" data-toggle="tooltip" data-placement="top" title="Cetak" style='color:#D24545'></i>
                                                </a>
                                                <?php
                                                $tanggal_pengembalian = \CodeIgniter\I18n\Time::parse($dataPinjam['tanggal_pengembalian'])->setTimezone('Asia/Jakarta');

                                                // Periksa apakah tanggal pengembalian adalah hari ini atau sudah melebihi tanggal saat ini
                                                if ($tanggal_pengembalian->toDateString() === date('Y-m-d') || $tanggal_pengembalian < \CodeIgniter\I18n\Time::now('Asia/Jakarta')) {
                                                ?>
                                                    <button class="btn editBtn" data-id="<?= $dataPinjam['peminjaman_id']; ?>" data-toggle="modal" data-target="#editModal">
                                                        <i class='fas fa-retweet' style='color:#1D24CA' data-toggle="tooltip" data-placement="top" title="Perpanjang"></i>
                                                    </button>
                                                <?php
                                                }
                                                ?>
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

                <div class="card mt-5">
                    <div class="card-header border-0 bg-warning ">
                        <h3 class="card-title">Peminjaman Baru oleh Pihak Luar</h3>
                    </div>
                    <div class="card-body table-responsive p-0 table-sm">
                        <table class="table table-striped">
                            <thead style="font-size: 13px;">
                                <tr>
                                    <th>Kode Pinjam</th>
                                    <th>Tanggal Pinjam</th>
                                    <th>Nama</th>
                                    <th>Detail</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php foreach ($data_pinjamLuar as $dataKembali) : ?>
                                    <tr>
                                        <!-- Kolom yang lain tetap seperti sebelumnya -->
                                        <td style="text-align: left; vertical-align: middle; font-size: 14px;">
                                            <?= $dataKembali['kode_pinjam']; ?>
                                            <?php
                                            $created_at = strtotime($dataKembali['pihakluar_created_at']);
                                            $now = time(); // Waktu saat ini dalam detik

                                            // Hitung selisih waktu dalam detik
                                            $selisih_detik = $now - $created_at;

                                            // Tampilkan badge "Baru" jika selisih waktu kurang dari 60 menit
                                            if ($selisih_detik < 60 * 60) : // 60 detik * 60 menit = 1 jam
                                            ?>
                                                <span class="badge badge-danger">BARU</span>
                                            <?php endif; ?>

                                        <td style="text-align: center; vertical-align: middle; font-size: 14px;">
                                            <?php
                                            $tanggal_pinjam = \CodeIgniter\I18n\Time::parse($dataKembali['tanggal_pinjam'])
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

                                            echo $tanggal_pinjam->format('d ') . $bulan . $tanggal_pinjam->format(' Y');
                                            ?>
                                        </td>
                                        <td style="text-align: center; vertical-align: middle; font-size: 14px;"><?= $dataKembali['nama_peminjam']; ?></td>


                                        <td width='20%' class="text-center" style="text-align: center; vertical-align: middle;">
                                            <a href=" <?= ('/pihakluar/invoice/' . $dataKembali['peminjaman_id']); ?>" class="btn btn-success btn-xs " target="_blank"><i class="fas fa-print "></i><b> Invoice</b></a>

                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>

                        </table>
                    </div>
                </div>


            </div>

            <div class="col-lg-5">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Grafik Peminjaman Berdasarkan Keperluan</h3>
                        <div class="card-tools">
                            <a href="#" class="btn btn-tool btn-sm" id="downloadButton">
                                <i class="fas fa-download"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="grafikKeperluan" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>



    </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Tanggal Kembali</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editForm">
                    <input type="hidden" id="editId" name="editId">
                    <div class="form-group">

                        <label for="tanggal_penggunaa" class="col-12 col-form-label">
                            Tanggal Pengembalian
                        </label>
                        <div class="col-12">
                            <div class="input-group date" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" data-target="#editTanggalKembali" id="editTanggalKembali" name="editTanggalKembali" />
                                <div class="input-group-append" data-target="#editTanggalKembali" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                            <small class="text-bold text-success"> AM: 00:00-11:59 | PM: 12:00-23:59</small>
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="updateTanggalKembali()">Simpan Perubahan</button>
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
<script src="../../assets/dist/js/jquery-3.6.4.min.js"></script>
<script>
    // Fungsi yang dipicu saat tombol edit ditekan
    $('.editBtn').click(function() {
        var id = $(this).data('id');

        // Menggunakan AJAX untuk memuat data dari server
        $.ajax({
            url: '/peminjaman/get_detail/' + id, // Ganti dengan URL yang sesuai
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                // Memasukkan data ke dalam input modal
                $('#editId').val(response.id);
                $('#editTanggalKembali').val(response.tanggal_pengembalian);

                // Set minDate for the datepicker
                $('#editTanggalKembali').datetimepicker('minDate', moment(response.tanggal_pengembalian).add(1, 'days'));
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });

    // Fungsi untuk menyimpan perubahan
    function updateTanggalKembali() {
        var id = $('#editId').val();
        var tanggalKembali = $('#editTanggalKembali').val();

        $.ajax({
            url: 'update_tanggal_kembali/' + id,
            method: 'POST',
            data: {
                tanggalKembali: tanggalKembali
            },
            success: function(response) {
                // Tutup modal setelah berhasil disimpan
                $('#editModal').modal('hide');

                // Tampilkan SweetAlert berhasil
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: 'Tanggal kembali berhasil diperbarui.',
                }).then((result) => {
                    // Lakukan reload halaman setelah SweetAlert ditutup
                    location.reload();
                });
            },
            error: function(xhr, status, error) {
                // Tampilkan SweetAlert gagal jika terjadi error
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Gagal memperbarui tanggal kembali.',
                });
            }
        });
    }
</script>



<script src="../../assets/dist/js/html2canvas.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var ctx = document.getElementById('grafikKeperluan').getContext('2d');

        // Increase the pixel density for better quality
        var devicePixelRatio = window.devicePixelRatio || 1;
        ctx.canvas.width *= devicePixelRatio;
        ctx.canvas.height *= devicePixelRatio;
        ctx.canvas.style.width = ctx.canvas.width / devicePixelRatio + 'px';
        ctx.canvas.style.height = ctx.canvas.height / devicePixelRatio + 'px';
        ctx.scale(devicePixelRatio, devicePixelRatio);

        var jumlah_data_by_keperluan = <?= json_encode(array_values($jumlah_data_by_keperluan)) ?>;

        var grafikKeperluan = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: <?= json_encode($keywords) ?>,
                datasets: [{
                    data: jumlah_data_by_keperluan,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.8)',
                        'rgba(54, 162, 235, 0.8)',
                        'rgba(255, 206, 86, 0.8)',
                        'rgba(80, 1, 192, 0.8)',
                        'rgba(153, 102, 255, 0.8)',
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(80, 1, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                    ],
                    borderWidth: 1,
                }]
            },
            options: {
                cutout: '100%',
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    display: true,
                    position: 'right',
                    labels: {
                        generateLabels: function(chart) {
                            var data = chart.data;
                            if (data.labels.length && data.datasets.length) {
                                return data.labels.map(function(label, i) {
                                    var meta = chart.getDatasetMeta(0);
                                    var ds = data.datasets[0];
                                    var arc = meta.data[i];
                                    var custom = arc && arc.custom || {};
                                    var getValue = ds.data[i];

                                    return {
                                        text: `${label} : ${getValue}`,
                                        fillStyle: ds.backgroundColor[i], // Menggunakan warna background dari dataset
                                        strokeStyle: ds.borderColor[i], // Menggunakan warna border dari dataset
                                        lineWidth: custom.borderWidth || ds.borderWidth,
                                        hidden: isNaN(ds.data[i]) || meta.data[i].hidden,
                                        index: i,
                                    };
                                });
                            } else {
                                return [];
                            }
                        }
                    },
                },
                title: {
                    display: true,
                    text: 'Grafik Peminjaman Berdasarkan Keperluan - Tahun ' + <?= $currentYear ?>,
                    fontSize: 16,
                },
                plugins: {
                    datalabels: {
                        display: false, // Membuat label data di grafik tidak terlihat
                    },
                },
            },
        });
    });
</script>
<script>
    document.getElementById('downloadButton').addEventListener('click', function() {
        // Mengunduh gambar dari canvas sebagai PNG
        var downloadLink = document.createElement('a');
        downloadLink.href = grafikKeperluan.toDataURL('image/png');
        downloadLink.download = 'grafik_keperluan.png';
        downloadLink.click();
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Check if $jumlah_peminjaman is not equal to 0
        if (<?= $jumlah_peminjaman; ?> !== 0) {
            // Trigger SweetAlert with dynamic data
            Swal.fire({
                text: 'Ada ' + <?= $jumlah_peminjaman; ?> + ' Peminjaman Aktif, Jangan Lupa Untuk Dikembalikan!',
                icon: 'info',
                confirmButtonText: 'OK',
                backdrop: 'static', // Set backdrop to static
                allowOutsideClick: false // Set allowOutsideClick to false
            });
        }
    });
</script>




<?php echo view('tema/footer.php'); ?>