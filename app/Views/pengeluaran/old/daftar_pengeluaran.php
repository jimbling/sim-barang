<?php echo view('tema/header.php'); ?>

<div class="content-wrapper">
    <div class="flash-data" data-flashdata="<?= (session()->getFlashData('pesanHapusPosts')); ?>"></div><!-- Page Heading -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h5 class="m-0">Daftar Pengeluaran Barang Persediaan</h5>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Data Barang</li>
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
                                        <a class="btn btn-success btn-sm" href="/pengeluaran/tambahBaru" role="button" data-toggle="tooltip" data-placement="top" title="Tambah Pengeluaran Dengan Peminjaman"> <i class='fas fa-cart-arrow-down spaced-icon'></i>Tambah Pengeluaran</a>
                                        </button>
                                    </div>
                                </div>
                                <div class="btn-toolbar">
                                    <div class="col-md-12 col-12">

                                        </button>
                                    </div>
                                </div>
                                <div class="btn-toolbar">
                                    <div class="col-md-12 col-12">
                                        <a class="btn btn-danger btn-sm" href="/pengeluaran/bhp" role="button" data-toggle="tooltip" data-placement="top" title="Tambah Pengeluaran Tanpa Peminjaman"> <i class='fas fa-cart-arrow-down spaced-icon'></i>Pengeluaran BHP</a>
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="card-body">
                            <table id="daftarPengeluaranPersediaanTable" class="table table-striped table-responsive">
                                <thead class="thead bg-danger table-bordered table-sm" style="font-size: 14px;">
                                    <tr>
                                        <th rowspan="2" width='3%' style="text-align: center;  vertical-align: middle;">No</th>
                                        <th colspan="3" style="text-align: center;  vertical-align: middle;">Informasi Peminjaman</th>
                                        <th rowspan="2" style="text-align: center;  vertical-align: middle;">Barang Persediaan</th>
                                        <th rowspan="2" style="text-align: center;  vertical-align: middle;">Aksi</th>
                                    </tr>
                                    <tr>
                                        <th style="text-align: center;">Kode Pinjam</th>
                                        <th style="text-align: center;">Nama Peminjam</th>
                                        <th style="text-align: center;">Tanggal Pinjam</th>


                                    </tr>
                                </thead>
                                <div id="alertContainer" class="mt-3"></div>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($data_pengeluaran as $peminjaman) : ?>
                                        <tr>
                                            <th class="text-center" scope="row" style="vertical-align: middle; font-size: 14px;"><?= $i++; ?></th>
                                            <td style="text-align: left; vertical-align: middle; font-size: 14px;"><?= $peminjaman['kode_pinjam']; ?></td>
                                            <td style="text-align: center; vertical-align: middle; font-size: 14px;"><?= $peminjaman['nama_peminjam']; ?></td>
                                            <td style="text-align: center; vertical-align: middle; font-size: 14px;">
                                                <?php
                                                $tanggal_pinjam = \CodeIgniter\I18n\Time::parse($peminjaman['tanggal_pinjam'])
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
                                            <td style="text-align: left; vertical-align: middle; font-size: 14px;">
                                                <?php $barangIndex = 1; ?>
                                                <?php foreach ($peminjaman['barang'] as $barang) : ?>
                                                    <?= $barangIndex++; ?>. <?= $barang['nama_barang']; ?> (Ambil: <?= $barang['ambil_barang']; ?>) <br>
                                                <?php endforeach; ?>
                                            </td>

                                            <td width='10%' style="text-align: center; vertical-align: middle; font-size: 14px;">
                                                <a onclick="hapus_data('<?= $peminjaman['peminjaman_id']; ?>')" class="btn btn-xs btn-danger mx-auto text-white" id="button" data-toggle="tooltip" data-placement="left" title="Hapus"> <i class='fas fa-trash'></i></a>
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




<script src="../../assets/dist/js/jquery-3.6.4.min.js"></script>


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

                let userLevel = "<?= session()->get('level') ?>";


                if (userLevel === "User") {

                    <?php if (isset($peminjaman) && isset($peminjaman['created_at'])) : ?>
                        let currentTime = <?= time() ?>;
                        let createdTime = <?= strtotime($peminjaman['created_at']) ?>;
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
                    <?php else : ?>

                        console.log('No data available for peminjaman created_at');

                        return;
                    <?php endif; ?>
                }


                showLoading();


                $.ajax({
                    type: 'POST',
                    url: '/pengeluaran/hapus/' + data_id,
                    success: function(response) {

                        hideLoading();
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Data berhasil dihapus.',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false,
                        }).then(() => {

                            window.location.replace("/pengeluaran/daftar");
                        });
                    },
                    error: function(xhr, status, error) {

                        hideLoading();

                        console.log(error);
                    }
                });
            }
        });
    }
</script>




<?php echo view('tema/footer.php'); ?>