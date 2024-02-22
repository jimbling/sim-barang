<?php echo view('tema/header.php'); ?>

<div class="content-wrapper">
    <div class="flash-data" data-flashdata="<?= (session()->getFlashData('pesanAddPengembalian')); ?>"></div><!-- Page Heading -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h5 class="m-0">Riwayat Pengembalian Barang</h5>
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
                                        <a class="btn btn-success btn-sm" href="/kembali/tambah" role="button"> <i class='fas fa-truck-loading spaced-icon'></i>Isi Form Pengembalian Barang</a>
                                        </button>
                                    </div>
                                </div>

                            </div>
                            <div class="row">



                            </div>
                        </div>
                        <div class="card-body">
                            <?php
                            // Di bagian atas file atau tempat yang sesuai
                            $level = session()->get('level');
                            ?>
                            <?php if ($level === 'Admin') : ?>
                                <form action="<?= base_url('kembali/riwayat') ?>" method="get" class="form-inline">
                                    <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Pilih Tahun</label>
                                    <select class="custom-select my-1 mr-sm-2 custom-select-sm" name="tahun" id="tahun">
                                        <?php foreach ($availableYears as $year) : ?>
                                            <option value="<?= $year ?>" <?= $year == $selectedYear ? 'selected' : '' ?>><?= $year ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <button type="submit" class="btn btn-primary my-1 btn-sm">Filter</button>
                                    </select>
                                </form>
                            <?php endif; ?>
                            <table id="daftarRiwayatPengembalian" class="table table-striped table-responsive table-sm table-hover">
                                <thead class="thead-dark" style="font-size: 13px;">
                                    <tr>
                                        <th width='3%'>No</th>
                                        <th style="text-align: center; font-size: 13px;">Kode</th>
                                        <th style="text-align: center; font-size: 13px;">Nama Peminjam</th>
                                        <th style="text-align: center; font-size: 13px;">Tanggal Pinjam</th>
                                        <th style="text-align: center; font-size: 13px;">Tanggal Kembali</th>
                                        <th style="text-align: center; font-size: 13px;">Digunakan untuk</th>
                                        <th style="text-align: center; font-size: 13px;">Nama Barang</th>
                                        <th style="text-align: center; font-size: 13px;">AKSI</th>
                                    </tr>
                                </thead>
                                <div id="alertContainer" class="mt-3"></div>
                                <tbody>
                                    <?php $i = 1; // Deklarasi di luar loop foreach 
                                    ?>
                                    <?php foreach ($data_kembali as $dataKembali) : ?>
                                        <tr>
                                            <!-- Kolom yang lain tetap seperti sebelumnya -->
                                            <th class="text-center" scope="row" style="vertical-align: middle; font-size: 13px;"><?= $i++; ?></th>
                                            <td style="text-align: left; vertical-align: middle; font-size: 13px;"><?= $dataKembali['kode_pinjam']; ?>
                                                <?= $dataKembali['kode_kembali']; ?></td>
                                            <td style="text-align: left; vertical-align: middle; font-size: 13px;"><?= $dataKembali['nama_peminjam']; ?></td>
                                            <td width='11%' style="text-align: left; vertical-align: middle; font-size: 13px;">
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

                                                echo $tanggal_pinjam->format('d ') . $bulan . $tanggal_pinjam->format(' Y - H:i') . ' WIB';
                                                ?>
                                            </td>
                                            <td width='11%' style="text-align: left; vertical-align: middle; font-size: 13px;">
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

                                                echo $tanggal_kembali->format('d ') . $bulan . $tanggal_kembali->format(' Y - H:i') . ' WIB';
                                                ?>
                                            </td>
                                            <td width='20%' style="text-align: left; vertical-align: middle; font-size: 13px;"><?= $dataKembali['keperluan']; ?></td>
                                            <td style="text-align: left; vertical-align: middle; font-size: 11px;">
                                                <?php
                                                // Pisahkan string nama_barang berdasarkan koma
                                                $barangArray = explode(",", $dataKembali['nama_barang']);

                                                // Tampilkan setiap barang dengan nomor urut menggunakan <p>
                                                foreach ($barangArray as $key => $barang) {
                                                    echo '<p>' . ($key + 1) . '. ' . htmlspecialchars($barang) . '</p>';
                                                }
                                                ?>
                                            </td>
                                            <td width='5%' class="text-center" style="text-align: center; vertical-align: middle;">
                                                <a onclick=" hapus_data('<?= $dataKembali['riwayat_id']; ?>')" class="btn btn-xs btn-danger mx-auto text-white" id="button">Hapus</a>
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
                    url: '/kembali/hapus/' + data_id,
                    success: function(response) {
                        hideLoading();
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Data berhasil dihapus.',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false,
                        }).then(() => {
                            window.location.replace("/kembali/riwayat");
                        });
                    },
                    error: function(xhr, status, error) {
                        hideLoading();
                        console.log(error);
                        Swal.fire({
                            title: 'Gagal!',
                            text: 'Gagal menghapus data. Silakan coba lagi.',
                            icon: 'error',
                        });
                    }
                });
            }
        });
    }
</script>
<?php echo view('tema/footer.php'); ?>