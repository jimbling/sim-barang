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
                <div class="card card-outline card-primary shadow-lg mt-3">
                    <div class="card-header border-0">
                        <h3 class="card-title">Data Peminjaman dan Permintaan Barang</h3>
                    </div>
                    <div class="card-body table-responsive p-0 table-sm">
                        <?php if (count($data_peminjaman) > 0) : ?>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Kode Pinjam</th>
                                        <th>Tanggal Peminjaman</th>
                                        <th>Tanggal Pengembalian</th>
                                        <th>Nama Peminjam</th>
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
                                                        <span class="badge badge-primary">Baru</span>
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
                                                <td width='20%' style="text-align: center; vertical-align: middle; font-size: 13px;">
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

                                                    // Mendapatkan waktu sekarang dengan timezone Asia/Jakarta
                                                    $now = \CodeIgniter\I18n\Time::now('Asia/Jakarta');

                                                    // Membandingkan apakah tanggal pengembalian sama dengan hari ini
                                                    if ($tanggal_kembali->toDateString() === $now->toDateString()) {
                                                        // Mendapatkan selisih waktu dalam menit antara waktu sekarang dan tanggal pengembalian
                                                        $selisihMenit = $now->difference($tanggal_kembali)->getMinutes();

                                                        // Jika selisih waktu kurang dari atau sama dengan 0, maka tanggal pengembalian telah lewat
                                                        if ($selisihMenit <= 0) {
                                                            $waktu .= '<br><span class="badge badge-danger">JATUH TEMPO</span>';
                                                        }
                                                    }

                                                    echo $waktu;
                                                    ?>
                                                </td>
                                                <td style="text-align: center; vertical-align: middle; font-size: 13px;"><?= $dataPinjam['nama_peminjam']; ?></td>

                                                <td width='10%' class="text-center" style="text-align: center; vertical-align: middle;">
                                                    <a href="<?= base_url('cetak_pinjam/' . $dataPinjam['peminjaman_id']); ?>" target="_blank">
                                                        <i class="fas fa-print" style='color:#D24545' data-toggle="tooltip" data-placement="left" title="Cetak"></i>
                                                    </a>
                                                    <?php
                                                    $tanggal_pengembalian = \CodeIgniter\I18n\Time::parse($dataPinjam['tanggal_pengembalian'])->setTimezone('Asia/Jakarta');

                                                    // Periksa apakah tanggal pengembalian adalah hari ini atau sudah melebihi tanggal dan waktu saat ini
                                                    if ($tanggal_pengembalian->toDateTimeString() <= \CodeIgniter\I18n\Time::now('Asia/Jakarta')->toDateTimeString()) {
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
                        <?php else : ?>
                            <!-- Tampilkan pesan jika tidak ada data peminjaman -->
                            <table class="table table-striped">
                                <tbody>

                                    <tr>
                                        <th>Tidak ada data peminjaman</th>
                                    </tr>
                                </tbody>
                            </table>
                        <?php endif; ?>
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
                <h5 class="modal-title" id="editModalLabel">Perpanjang Peminjaman</h5>
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


<!-- Modal -->
<!-- Modal -->
<div class="modal fade" id="myModal" data-backdrop="static">
    <div class="modal-dialog ">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header bg-danger">
                <h6 class="modal-title">Notifikasi</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body text-center">
                <div>

                </div>
                <div>
                    <p id="jumlahPeminjaman"></p>

                    <p id="kodePinjam"></p>

                    <p><span class="small blockquote-footer">Lakukan pengembalian pada menu Sirkulasi, atau bisa untuk diperpanjang! <i class='fas fa-retweet spa' style='color:#1D24CA;'></i></span></p>
                </div>
            </div>

        </div>
    </div>
</div>










<script src="../../assets/dist/js/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function() {
        // AJAX request untuk mendapatkan notifikasi berdasarkan user_id
        $.ajax({
            url: "<?php echo base_url('notification/getUserNotifications'); ?>",
            type: "POST",
            data: {
                user_id: <?php echo session()->get('id'); ?>
            },
            dataType: "json",
            success: function(response) {
                // Jika ada notifikasi, tampilkan dengan SweetAlert
                if (response.length > 0) {
                    $.each(response, function(index, notification) {
                        // Tentukan ikon berdasarkan jenis_pesan
                        var icon = (notification.jenis_pesan === 'disetujui') ? 'success' : 'error';

                        // Tampilkan notifikasi dengan SweetAlert
                        Swal.fire({
                            title: (notification.jenis_pesan === 'disetujui') ? 'Booking Alat Disetujui' : 'Booking Alat Ditolak',
                            text: notification.message,
                            icon: icon,
                            showCancelButton: false,
                            confirmButtonText: 'OK',
                            allowOutsideClick: false,
                            allowEscapeKey: false
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Panggilan AJAX untuk menandai notifikasi sebagai telah dibaca
                                $.ajax({
                                    url: "<?php echo base_url('notification/markAsRead'); ?>",
                                    type: "POST",
                                    data: {
                                        notification_id: notification.id
                                    },
                                    success: function(response) {
                                        // Tindakan setelah notifikasi ditandai sebagai telah dibaca
                                        console.log('Notifikasi ditandai sebagai telah dibaca.');
                                    },
                                    error: function(xhr, status, error) {
                                        console.error("Terjadi kesalahan saat menandai notifikasi sebagai telah dibaca:", error);
                                    }
                                });
                            }
                        });
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error("Terjadi kesalahan saat mengambil notifikasi:", error);
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        <?php if (!empty($jumlah_peminjaman)) : ?>
            // Tampilkan modal jika ada data peminjaman
            $('#myModal').modal('show');

            // Menghitung jumlah total peminjaman
            var totalPeminjaman = 0;
            <?php foreach ($jumlah_peminjaman as $peminjaman) : ?>
                totalPeminjaman += <?= $peminjaman['jumlah_peminjaman'] ?>;
            <?php endforeach; ?>

            // Menampilkan jumlah total peminjaman
            $('#jumlahPeminjaman').text('Anda memiliki peminjaman yang jatuh tempo sebanyak: ' + totalPeminjaman);

            // Menampilkan daftar kode pinjam
            var kodePinjamArray = [];
            <?php foreach ($jumlah_peminjaman as $peminjaman) : ?>
                kodePinjamArray.push('<?= $peminjaman['kode_pinjam'] ?>');
            <?php endforeach; ?>
            var kodePinjamText = kodePinjamArray.join(', ');
            $('#kodePinjam').text('Kode Pinjam: ' + kodePinjamText);
        <?php endif; ?>
    });
</script>
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
        // Tampilkan pesan loading sementara
        Swal.fire({
            title: 'Mohon tunggu...',
            onBeforeOpen: () => {
                Swal.showLoading();
            },
            allowOutsideClick: false,
            showConfirmButton: false
        });
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
                    text: 'Peminjaman berhasil diperpanjang.',
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
<?php echo view('tema/footer.php'); ?>