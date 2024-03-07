<?php echo view('tema/header.php'); ?>

<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h5 class="m-0">Daftar Booking Alat</h5>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Booking Alat</li>
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
                        <?php
                        // Di bagian atas file atau tempat yang sesuai
                        $level = session()->get('level');
                        ?>
                        <?php if ($level === 'Admin') : ?>
                            <div class="card-header">

                                <div class="btn-toolbar justify-content-between" role="toolbar" aria-label="Toolbar with button groups">
                                    <div class="btn-group" role="group" aria-label="First group">
                                        <div class="col-md-12 col-12">
                                            <a class="btn btn-success btn-sm" href="/reservasi/tambah" role="button"> <i class='fas fa-truck-loading spaced-icon'></i>Isi Form Reservasi Peminjaman</a>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="btn-toolbar">
                                        <div class="col-md-12 col-12">

                                            </button>
                                        </div>
                                    </div>
                                    <div class="btn-toolbar">

                                    </div>
                                </div>
                                <div class="row">
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="card-body">
                            <table id="daftarReservasi" class="table table-striped table-responsive table-hover">
                                <thead class="thead bg-indigo" style="font-size: 13px;">
                                    <tr>
                                        <th style="text-align: center; font-size: 13px; vertical-align: middle;" width='3%'>No</th>
                                        <th style="text-align: center; font-size: 13px; vertical-align: middle;">Kode Reservasi</th>
                                        <th style="text-align: center; font-size: 13px; vertical-align: middle;">Nama Peminjam</th>
                                        <th style="text-align: center; font-size: 13px; vertical-align: middle;">Tanggal Penggunaan</th>
                                        <th style="text-align: center; font-size: 13px; vertical-align: middle;">Nama Barang</th>
                                        <?php if ($level === 'Admin') : ?>
                                            <th style="text-align: center; font-size: 13px; vertical-align: middle;">AKSI</th>
                                        <?php endif; ?>
                                    </tr>
                                </thead>
                                <div id="alertContainer" class="mt-3"></div>
                                <tbody>
                                    <?php $i = 1; // Deklarasi di luar loop foreach 
                                    ?>
                                    <?php foreach ($data_reservasi as $dataReservasi) : ?>
                                        <tr class="searchable-row">
                                            <!-- Kolom yang lain tetap seperti sebelumnya -->
                                            <th class="text-center" scope="row" style="vertical-align: middle; font-size: 13px;"><?= $i++; ?></th>
                                            <td style="text-align: left; vertical-align: middle; font-size: 13px;"><?= $dataReservasi['kode_reservasi']; ?></td>
                                            <td style="text-align: left; vertical-align: middle; font-size: 13px;">
                                                <?php
                                                $data = explode('-', $dataReservasi['nama_peminjam']);
                                                echo isset($data[1]) ? $data[1] : ''; // Menampilkan bagian nama dari array hasil explode
                                                ?>
                                            </td>
                                            <td width='20%' style="text-align: left; vertical-align: middle; font-size: 13px;">
                                                <?php
                                                $tanggal_penggunaan = \CodeIgniter\I18n\Time::parse($dataReservasi['tanggal_penggunaan'])
                                                    ->setTimezone('Asia/Jakarta');

                                                $nama_hari = [
                                                    'Sunday' => 'Minggu',
                                                    'Monday' => 'Senin',
                                                    'Tuesday' => 'Selasa',
                                                    'Wednesday' => 'Rabu',
                                                    'Thursday' => 'Kamis',
                                                    'Friday' => 'Jumat',
                                                    'Saturday' => 'Sabtu',
                                                ];

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

                                                $hari = $nama_hari[$tanggal_penggunaan->format('l')];
                                                $bulan = $nama_bulan[$tanggal_penggunaan->format('F')];

                                                echo $hari . ', ' . $tanggal_penggunaan->format('d ') . $bulan . $tanggal_penggunaan->format(' Y');
                                                ?>

                                            </td>
                                            <td style="text-align: left; vertical-align: middle; font-size: 13px;">
                                                <?php
                                                // Di bagian atas file atau tempat yang sesuai
                                                $level = session()->get('level');
                                                ?>
                                                <?php
                                                $barang_dipinjam = explode(',', $dataReservasi['barang_dipinjam']);
                                                $no_urut_barang = 1; // Reset nomor urut pada setiap baris barang
                                                foreach ($barang_dipinjam as $barang) {
                                                    echo $no_urut_barang . '. ' . $barang . '<br>';
                                                    $no_urut_barang++; // Increment nomor urut barang
                                                }
                                                ?>
                                            </td>
                                            <?php if ($level === 'Admin') : ?>
                                                <td class="text-center" style="text-align: center; vertical-align: middle;">

                                                    <a onclick=" proses_pinjam('<?= $dataReservasi['reservasi_id']; ?>')" class="btn btn-xs bg-success mx-auto text-white" id="prosesButton">Setujui</a>
                                                    <a onclick=" hapus_data('<?= $dataReservasi['reservasi_id']; ?>')" class="btn btn-xs btn-danger mx-auto text-white" id="hapusButton">Tolak</a>
                                                    <a class="btn btn-xs btn-info mx-auto text-white" href="<?= base_url('cetak_reservasi/' . $dataReservasi['reservasi_id']); ?>" target="_blank">Cetak</a>


                                                </td>
                                            <?php endif; ?>

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



<aside class="control-sidebar control-sidebar-dark">

    <div class="p-3">
        <h5>Title</h5>
        <p>Sidebar content</p>
    </div>
</aside>






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

        // Mendapatkan token CSRF dari cookie
        const csrfName = '<?= csrf_token() ?>';
        const csrfHash = '<?= csrf_hash() ?>';

        Swal.fire({
            title: 'Konfirmasi',
            text: 'Anda yakin menolak booking alat ini?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal',
            allowOutsideClick: false,
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Masukkan alasan penolakan',
                    input: 'textarea',
                    inputPlaceholder: 'Masukkan alasan di sini...',
                    inputAttributes: {
                        'aria-label': 'Masukkan alasan penolakan'
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Kirim',
                    cancelButtonText: 'Batal',
                    showLoaderOnConfirm: true,
                    allowOutsideClick: false,
                    preConfirm: (message) => {
                        // Mengirim permintaan AJAX dengan menyertakan token CSRF
                        return $.ajax({
                            type: 'POST',
                            url: '/reservasi/hapus/' + data_id,
                            data: {
                                message: message,
                                [csrfName]: csrfHash // Menyertakan token CSRF dalam data
                            },
                            dataType: 'json'
                        }).catch(error => {
                            Swal.showValidationMessage(`Request failed: ${error}`);
                        });
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Booking alat berhasil ditolak.',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false,
                        }).then(() => {
                            window.location.replace("/reservasi");
                        });
                    }
                });
            }
        });
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

    function proses_pinjam(data_id) {
        console.log('Data ID yang akan dihapus:', data_id);

        Swal.fire({
            title: 'Konfirmasi',
            text: 'Anda yakin ingin memproses pinjaman ini?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal',
            allowOutsideClick: false,
        }).then((result) => {
            if (result.isConfirmed) {
                // Check if $dataReservasi is set
                <?php if (isset($dataReservasi) && $dataReservasi !== null) : ?>
                    let userLevel = "<?= session()->get('level') ?>";

                    if (userLevel === "User") {
                        let currentTime = <?= time() ?>;
                        let createdTime = <?= strtotime($dataReservasi['created_at']) ?>;
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

                    showLoading();

                    $.ajax({
                        type: 'POST',
                        url: '/reservasi/pindah/' + data_id,
                        success: function(response) {
                            hideLoading();
                            Swal.fire({
                                title: 'Berhasil!',
                                text: 'Data booking berhasil diproses.',
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false,
                            }).then(() => {
                                window.location.replace("/pinjam/daftar");
                            });
                        },
                        error: function(xhr, status, error) {
                            hideLoading();
                            console.log(error);
                        }
                    });
                <?php else : ?>
                    // Handle the case where $dataReservasi is not set (no data available)
                    console.log('No data available for dataReservasi');
                    // Optionally, you can display a message to the user or perform other actions
                <?php endif; ?>
            }
        });
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
<?php echo view('tema/footer.php'); ?>