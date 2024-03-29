<?php echo view('tema/header.php'); ?>

<div class="content-wrapper">
    <div class="flash-data" data-flashdata="<?= (session()->getFlashData('pesanAddPengembalian')); ?>"></div><!-- Page Heading -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h5 class="m-0">Daftar Peminjaman Oleh Pihak Luar</h5>
                </div>

                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Data Kembali</li>
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
                                <div class="btn-group" role="group" aria-label="First group">
                                    <div class="col-md-12 col-12">
                                        <a class="btn btn-info btn-sm" href="/pinjam/pihakluar/riwayat" role="button"> <i class='fas fa-truck-loading spaced-icon'></i>Riwayat Pinjam Pihak Luar</a>
                                        </button>
                                    </div>
                                </div>
                                <div class="btn-group" role="group" aria-label="First group">

                                </div>
                            </div>
                            <div class="row">



                            </div>
                        </div>
                        <div class="card-body">
                            <table id="daftarPinjamLuar" class="table table-striped table-responsive table-sm table-hover">
                                <thead class="thead-dark" style="font-size: 14px;">
                                    <tr>
                                        <th style="text-align: center; font-size: 14px; vertical-align: middle;" width='3%'>No</th>
                                        <th style="text-align: center; font-size: 14px; vertical-align: middle;">Kode</th>
                                        <th style="text-align: center; font-size: 14px; vertical-align: middle;">Nama Peminjam</th>
                                        <th style="text-align: center; font-size: 14px; vertical-align: middle;">Nama Instansi</th>
                                        <th style="text-align: center; font-size: 14px; vertical-align: middle;">Tanggal Pinjam</th>
                                        <th style="text-align: center; font-size: 14px; vertical-align: middle;">Tanggal Kembali</th>
                                        <th style="text-align: center; font-size: 14px; vertical-align: middle;">Nama Barang</th>
                                        <th style="text-align: center; font-size: 14px; vertical-align: middle;">AKSI</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php $i = 1; // Deklarasi di luar loop foreach 
                                    ?>
                                    <?php foreach ($data_pinjamLuar as $dataKembali) : ?>
                                        <tr>
                                            <!-- Kolom yang lain tetap seperti sebelumnya -->
                                            <th class="text-center" scope="row" style="vertical-align: middle; font-size: 14px;"><?= $i++; ?></th>
                                            <td style="text-align: left; vertical-align: middle; font-size: 14px;"><?= $dataKembali['kode_pinjam']; ?>

                                            <td style="text-align: left; vertical-align: middle; font-size: 14px;"><?= $dataKembali['nama_peminjam']; ?></td>
                                            <td style="text-align: left; vertical-align: middle; font-size: 14px;"><?= $dataKembali['nama_instansi']; ?></td>
                                            <td width='11%' style="text-align: left; vertical-align: middle; font-size: 14px;">
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
                                            <td width='11%' style="text-align: left; vertical-align: middle; font-size: 14px;">
                                                <?php
                                                $tanggal_kembali = \CodeIgniter\I18n\Time::parse($dataKembali['tanggal_kembali'])
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

                                                $bulan = $nama_bulan[$tanggal_kembali->format('F')];

                                                echo $tanggal_kembali->format('d ') . $bulan . $tanggal_kembali->format(' Y');
                                                ?>
                                            </td>
                                            <td style="text-align: left; vertical-align: middle; font-size: 13px;">
                                                <?php
                                                // Pisahkan string nama_barang berdasarkan koma
                                                $barangArray = explode(",", $dataKembali['nama_barangs']);

                                                // Tampilkan setiap barang dengan nomor urut menggunakan <p>
                                                foreach ($barangArray as $key => $barang) {
                                                    echo '<p>' . ($key + 1) . '. ' . htmlspecialchars($barang) . '</p>';
                                                }
                                                ?>
                                            </td>
                                            <td width='10%' class="text-center" style="text-align: center; vertical-align: middle;">
                                                <a onclick=" hapus_data('<?= $dataKembali['peminjaman_id']; ?>')" class="btn btn-xs btn-danger mx-auto text-white" id="button">Hapus</a>
                                                <a onclick=" kembali('<?= $dataKembali['peminjaman_id']; ?>')" class="btn btn-xs btn-info mx-auto text-white" id="button">Kembali</a>
                                                <a href=" <?= ('/pihakluar/invoice/' . $dataKembali['peminjaman_id']); ?>" class="btn btn-success btn-xs " target="_blank"><i class="fas fa-print "></i><b> Invoice</b></a>

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



<aside class="control-sidebar control-sidebar-dark">

    <div class="p-3">
        <h5>Title</h5>
        <p>Sidebar content</p>
    </div>
</aside>


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

    function kembali(data_id) {
        console.log('Data ID yang akan dihapus:', data_id);

        // Pemeriksaan level pengguna di sisi klien
        let userLevel = '<?= session()->get("level") ?>';
        if (userLevel === 'User') {
            Swal.fire({
                title: 'Gagal!',
                text: 'Anda tidak memiliki izin untuk menghapus data.',
                icon: 'error',
            });
            return; // Berhenti di sini jika level pengguna bukan 'Admin'
        }

        Swal.fire({
            title: 'KEMBALI?',
            text: "Yakin akan mengembalikan barang?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Kembalikan!'
        }).then((result) => {
            if (result.isConfirmed) {
                showLoading();

                // Lakukan permintaan penghapusan ke server, misalnya dengan AJAX.
                $.ajax({
                    type: 'POST',
                    url: '/pihakluar/kembalikan/' + data_id,
                    success: function(response) {
                        hideLoading();
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Data berhasil dikembalikan.',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false,
                        }).then(() => {
                            window.location.replace("/pinjam/pihakluar");
                        });
                    },
                    error: function(xhr, status, error) {
                        hideLoading();
                        console.log(error);
                        Swal.fire({
                            title: 'Gagal!',
                            text: 'Gagal mengembalikan barang. Silakan coba lagi.',
                            icon: 'error',
                        });
                    }
                });
            }
        });
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

    function hapus_data(data_id) {
        console.log('Data ID yang akan dihapus:', data_id);

        // Pemeriksaan level pengguna di sisi klien
        let userLevel = '<?= session()->get("level") ?>';
        if (userLevel === 'User') {
            Swal.fire({
                title: 'Gagal!',
                text: 'Anda tidak memiliki izin untuk menghapus data.',
                icon: 'error',
            });
            return; // Berhenti di sini jika level pengguna bukan 'Admin'
        }

        Swal.fire({
            title: 'HAPUS?',
            text: "Yakin akan menghapus data ini?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                showLoading();

                // Lakukan permintaan penghapusan ke server, misalnya dengan AJAX.
                $.ajax({
                    type: 'POST',
                    url: '/pihakluar/hapus/' + data_id,
                    success: function(response) {
                        hideLoading();
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Data berhasil dikembalikan.',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false,
                        }).then(() => {
                            window.location.replace("/pinjam/pihakluar");
                        });
                    },
                    error: function(xhr, status, error) {
                        hideLoading();
                        console.log(error);
                        Swal.fire({
                            title: 'Gagal!',
                            text: 'Gagal mengembalikan barang. Silakan coba lagi.',
                            icon: 'error',
                        });
                    }
                });
            }
        });
    }
</script>

<?php echo view('tema/footer.php'); ?>