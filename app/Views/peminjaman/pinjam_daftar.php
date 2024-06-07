<?php echo view('tema/header.php'); ?>

<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h5 class="m-0">Daftar Peminjaman Barang</h5>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Data Pinjam</li>
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
                        <div class="card-header">
                            <div class="btn-toolbar justify-content-between" role="toolbar" aria-label="Toolbar with button groups">
                                <?php
                                // Di bagian atas file atau tempat yang sesuai
                                $level = session()->get('level');
                                ?>
                                <?php if ($level === 'Admin') : ?>
                                    <div class="btn-group" role="group" aria-label="First group">
                                        <div class="col-md-12 col-12">
                                            <a class="btn btn-success btn-sm" href="/pinjam/tambah" role="button"> <i class='fas fa-truck-loading spaced-icon'></i>Isi Form Peminjaman Barang</a>
                                        </div>
                                    </div>
                                    <div class="btn-toolbar">
                                        <div class="col-md-12 col-12">
                                            <a class="btn btn-warning btn-sm" href="/pinjam/riwayat" role="button"> <i class='fas fa-history spaced-icon'></i>Riwayat Peminjaman Barang</a>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="row">
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-light" style="font-size: 13px;" role="alert">
                                Setelah Booking Peminjaman Barang disetujui oleh Laboran, jika menginginkan untuk menggunakan barang-barang habis pakai Labaoratorium, silahkan mengisi Form pengeluaran barang persediaan : <a class="btn bg-indigo btn-sm" href="/pengeluaran/tambahBaru" role="button" style="text-decoration: none;">
                                    <i class='fas fa-external-link-alt spaced-icon'></i>Form Barang Persediaan
                                </a> Jangan lupa untuk mencatat Kode Pinjam masing-masing.
                            </div>
                            <table id="daftarPeminjamanTable" class="table table-striped table-responsive table-sm table-hover">
                                <thead class="thead bg-success" style="font-size: 13px;">
                                    <tr>
                                        <th style="text-align: center; font-size: 13px; vertical-align: middle;" width='3%'>No</th>
                                        <th style="text-align: center; font-size: 13px; vertical-align: middle;">Kode Pinjam</th>
                                        <th style="text-align: center; font-size: 13px; vertical-align: middle;">Nama Peminjam</th>
                                        <th style="text-align: center; font-size: 13px; vertical-align: middle;">Tanggal Pinjam</th>
                                        <th style="text-align: center; font-size: 13px; vertical-align: middle;">Tanggal Kembali</th>
                                        <th style="text-align: center; font-size: 13px; vertical-align: middle;">Uraian</th>
                                        <th style="text-align: center; font-size: 13px; vertical-align: middle;">Nama Barang</th>
                                        <th style="text-align: center; font-size: 13px; vertical-align: middle;">AKSI</th>
                                    </tr>
                                </thead>
                                <div id="alertContainer" class="mt-3"></div>
                                <tbody>
                                    <?php $i = 1; // Deklarasi di luar loop foreach 
                                    ?>
                                    <?php foreach ($data_peminjaman as $dataPinjam) : ?>
                                        <tr class="searchable-row">
                                            <!-- Kolom yang lain tetap seperti sebelumnya -->
                                            <th class="text-center" scope="row" style="vertical-align: middle; font-size: 13px;"><?= $i++; ?></th>
                                            <td style="text-align: left; vertical-align: middle; font-size: 13px;"><?= $dataPinjam['kode_pinjam']; ?></td>
                                            <td style="text-align: left; vertical-align: middle; font-size: 13px;"><?= $dataPinjam['nama_peminjam']; ?></td>
                                            <td width='11%' style="text-align: left; vertical-align: middle; font-size: 13px;">
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
                                            <td width='11%' style="text-align: left; vertical-align: middle; font-size: 13px;">
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
                                            <td width='20%' style="text-align: left; vertical-align: middle; font-size: 13px;">Digunakan di: <?= $dataPinjam['nama_ruangan']; ?>
                                                <p> Untuk: <?= $dataPinjam['keperluan']; ?>
                                            </td>
                                            <td style="text-align: left; vertical-align: middle; font-size: 13px;">
                                                <?php
                                                $barang_dipinjam = explode(',', $dataPinjam['barang_dipinjam']);
                                                $no_urut_barang = 1; // Reset nomor urut pada setiap baris barang
                                                foreach ($barang_dipinjam as $barang) {
                                                    echo $no_urut_barang . '. ' . $barang . '<br>';
                                                    $no_urut_barang++; // Increment nomor urut barang
                                                }
                                                ?>
                                            </td>
                                            <td width='5%' class="text-center" style="text-align: center; vertical-align: middle;">
                                                <a onclick=" hapus_data('<?= $dataPinjam['peminjaman_id']; ?>')" class="btn btn-xs btn-danger mx-auto text-white" id="button">Hapus</a>
                                                <a class="btn btn-xs btn-info mx-auto text-white" href="<?= base_url('cetak_pinjam/' . $dataPinjam['peminjaman_id']); ?>" target="_blank">
                                                    F. Pinjam
                                                </a>

                                                <?php
                                                $tanggal_pengembalian = \CodeIgniter\I18n\Time::parse($dataPinjam['tanggal_pengembalian'])->setTimezone('Asia/Jakarta');

                                                // Periksa apakah tanggal pengembalian adalah hari ini atau sudah melebihi tanggal dan waktu saat ini
                                                if ($tanggal_pengembalian->toDateTimeString() <= \CodeIgniter\I18n\Time::now('Asia/Jakarta')->toDateTimeString()) {
                                                ?>
                                                    <button class="btn btn-xs editBtn btn-warning mx-auto text-dark" data-id="<?= $dataPinjam['peminjaman_id']; ?>" data-toggle="modal" data-target="#editModal">
                                                        Perpanjang
                                                    </button>
                                                <?php
                                                }
                                                ?>


                                                <a class="btn btn-xs btn-success mx-auto text-white" href="<?= base_url('form_kembali/' . $dataPinjam['peminjaman_id']); ?>" target="_blank">
                                                    F. Kembali
                                                </a>


                                            </td>

                                        </tr>

                                    <?php endforeach; ?>
                                </tbody>

                            </table>
                        </div>
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






<script src="../../assets/dist/js/jquery-3.6.4.min.js"></script>



<script>
    $(document).ready(function() {
        <?php if (!empty($jumlah_peminjaman)) : ?>
            // Tampilkan modal jika ada data peminjaman
            $('#myModal').modal('show');

            // Tampilkan jumlah peminjaman jika ada
            $('#jumlahPeminjaman').text('Anda memiliki peminjaman yang jatuh tempo sebanyak: <?= $jumlah_peminjaman[0]['jumlah_peminjaman'] ?>');

        <?php endif; ?>

        // Fungsi untuk menyalin kode pinjam ke clipboard
        $('#copyButton').click(function() {
            var kodePinjam = $('#kodePinjam').text().trim().split(':')[1].trim(); // mengambil hanya nilai kode pinjam
            copyToClipboard(kodePinjam);
            toastr.success('Kode Pinjam telah disalin ke clipboard!', 'Sukses');
        });

        // Fungsi untuk menyalin teks ke clipboard
        function copyToClipboard(text) {
            var dummy = document.createElement("textarea");
            document.body.appendChild(dummy);
            dummy.value = text;
            dummy.select();
            document.execCommand("copy");
            document.body.removeChild(dummy);
        }
    });
</script>



<script>
    function showLoading() {
        let timerInterval
        Swal.fire({
            title: 'Sedang memproses data ....',
            timerProgressBar: true,
            didOpen: () => {
                Swal.showLoading()
                const b = Swal.getHtmlContainer().querySelector('b')
                timerInterval = setInterval(() => {
                    b.textContent = Swal.getTimerLeft()
                }, 100)
            }
        });
    }

    function hideLoading() {
        Swal.close();
    }

    function hapus_data(data_id) {
        console.log('Data ID yang akan dihapus:', data_id);

        // Check if $dataPinjam is set
        <?php if (isset($dataPinjam) && $dataPinjam !== null) : ?>
            let userLevel = "<?= session()->get('level') ?>";

            if (userLevel === "User") {
                let currentTime = <?= time() ?>;
                let createdTime = <?= strtotime($dataPinjam['created_at']) ?>;
                let timeDifference = currentTime - createdTime;
                let timeLimit = 24 * 3600;

                if (timeDifference > timeLimit) {
                    Swal.fire({
                        title: 'Gagal!',
                        text: 'Batas waktu 1x24 jam untuk menghapus data telah terlampaui. Silahkan hubungi Laboran',
                        icon: 'error',
                        timer: 3000,
                        showConfirmButton: false,
                    });
                    return;
                }
            }

            // Menampilkan pesan konfirmasi sebelum menghapus data
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Apakah Anda yakin ingin menghapus data ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    showLoading();

                    $.ajax({
                        type: 'POST',
                        url: '/pinjam/hapus/' + data_id,
                        success: function(response) {
                            hideLoading();
                            Swal.fire({
                                title: 'Berhasil!',
                                text: 'Data berhasil dihapus.',
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false,
                            }).then(() => {
                                window.location.replace("/pinjam/daftar");
                            });
                        },
                        error: function(xhr, status, error) {
                            console.log('AJAX Error:', xhr); // Memeriksa objek XHR
                            console.log('Status:', status); // Memeriksa status HTTP
                            console.log('Error:', error); // Memeriksa pesan error

                            hideLoading();
                            let errorMessage = xhr.responseText; // Mengambil pesan kesalahan dari respons

                            Swal.fire({
                                title: 'Gagal!',
                                text: 'Tidak dapat menghapus data. Hapus dahulu Pengeluaran Persediaan yang terkait!', // Menampilkan pesan kesalahan dari server
                                icon: 'error',
                                timer: 3000,
                                showConfirmButton: false,
                            });
                        }
                    });
                }
            });
        <?php else : ?>
            // Handle the case where $dataPinjam is not set (no data available)
            console.log('No data available for dataPinjam');
            // Optionally, you can display a message to the user or perform other actions
        <?php endif; ?>
    }
</script>


<script>
    function logPeminjamanId(peminjamanId) {
        console.log('Peminjaman ID:', peminjamanId);

        // Mengambil elemen tabel di dalam modal
        var tabelDetail = document.getElementById('tabelDetail');

        // Membersihkan isi tabel (jika ada)
        tabelDetail.innerHTML = '';

        // Mengambil detail dari server menggunakan AJAX
        fetch('/pengeluaran/get_detail/' + peminjamanId)
            .then(response => response.json())
            .then(data => {
                // Iterasi melalui setiap objek dalam array detail dan menambahkannya ke dalam tabel
                data.detail.forEach(function(detail) {
                    // Membuat baris baru di dalam tabel
                    var newRow = tabelDetail.insertRow();

                    // Menambahkan sel-sel ke dalam baris
                    newRow.insertCell().textContent = detail.id;
                    newRow.insertCell().textContent = detail.nama_barang;
                    newRow.insertCell().textContent = detail.ambil_barang;
                    newRow.insertCell().textContent = detail.harga_satuan;
                    newRow.insertCell().textContent = detail.jumlah_harga;
                });
            })
            .catch(error => console.error('Error:', error));
    }
</script>

<?php if (session()->getFlashData('success')) : ?>
    <script>
        // Tampilkan SweetAlert berdasarkan flash data success
        Swal.fire({
            icon: 'success',
            title: '<?= session()->getFlashData('success') ?>',
            showConfirmButton: false,
            timer: 1500 // Atur waktu tampil SweetAlert (ms)
        });
    </script>
<?php endif; ?>

<script>
    // Fungsi yang dipicu saat tombol edit ditekan
    $('.editBtn').click(function() {
        var id = $(this).data('id');

        // Menggunakan AJAX untuk memuat data dari server
        $.ajax({
            url: '/ambil_tanggal/' + id, // Ganti dengan URL yang sesuai
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
            url: '/update_tanggal_kembali/' + id,
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