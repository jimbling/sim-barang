<?php echo view('tema/header.php'); ?>
<style>
    /* CSS untuk mengatur ukuran font menjadi 13px */
    .table td,
    .table th {
        font-size: 14px;
    }
</style>
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
                            <table id="daftarRiwayatPengembalian" class="table table-striped table-sm table-hover">
                                <thead class="thead-dark" style="font-size: 14px;">
                                    <tr>
                                        <th width='3%'>No</th>
                                        <th style="text-align: center; font-size: 13px;">Kode Kembali</th>
                                        <th style="text-align: center; font-size: 13px;">Nama Peminjam</th>
                                        <th style="text-align: center; font-size: 13px;">Tanggal</th>
                                        <th style="text-align: center; font-size: 13px;">Digunakan untuk</th>
                                        <th style="text-align: center; font-size: 13px;">Nama Barang</th>
                                        <th style="text-align: center; font-size: 13px;">AKSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $counter = 1;
                                    $bulanIndonesia = array(
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
                                        'December' => 'Desember'
                                    );
                                    ?>
                                    <?php foreach ($groupedRiwayatPengembalian as $kodeKembali => $riwayat) : ?>
                                        <?php $counterRow = 1; ?>
                                        <tr>
                                            <td><?= $counter++ ?></td>
                                            <td><?= $riwayat['kode_kembali'] ?>
                                                <br>
                                                <div class="badge badge-secondary"><?= $riwayat['kode_pinjam'] ?></div>
                                            </td>
                                            <td><?= explode('-', $riwayat['nama_peminjam'])[1] ?></td>
                                            <td width='10%'>
                                                <div class="badge bg-olive">Pinjam:<br><?= date('d', strtotime($riwayat['tanggal_pinjam'])) ?> <?= $bulanIndonesia[date('F', strtotime($riwayat['tanggal_pinjam']))] ?> <?= date('Y - H:i', strtotime($riwayat['tanggal_pinjam'])) ?> WIB</div><br>
                                                <div class="badge bg-orange"> Kembali:<br><?= date('d', strtotime($riwayat['tanggal_kembali'])) ?> <?= $bulanIndonesia[date('F', strtotime($riwayat['tanggal_kembali']))] ?> <?= date('Y - H:i', strtotime($riwayat['tanggal_kembali'])) ?> WIB</div>
                                            </td>
                                            <td width='20%'><?= $riwayat['keperluan'] ?></td>
                                            <td style="text-align: left; vertical-align: middle;">
                                                <?php foreach ($riwayat['riwayat'] as $barang) : ?>
                                                    <div><?= $counterRow++ ?>. <?= $barang['nama_barang'] ?> - <?= $barang['kode_barang'] ?></div>
                                                <?php endforeach; ?>
                                                <!-- Tampilkan peminjaman_id di sini -->

                                            </td>
                                            <td style="text-align: center; vertical-align: middle;">
                                                <?php if ($riwayat['peminjaman_exists']) : ?>
                                                    <!-- Jangan tampilkan tombol Hapus jika peminjaman_id masih ada -->
                                                    <button class="btn btn-xs btn-info mx-auto text-white batalButton spaced-icon" onclick="batal_data('<?= $riwayat['kode_kembali'] ?>')">Batal</button>
                                                <?php else : ?>
                                                    <button class="btn btn-xs btn-danger mx-auto text-white spaced-icon" id="hapusButton" onclick="hapus_data('<?= $riwayat['kode_kembali'] ?>')">Hapus</button>
                                                <?php endif; ?>
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





<script>
    function showLoading() {
        Swal.fire({
            title: 'Sedang memproses data ....',
            timerProgressBar: true,
            didOpen: () => {
                Swal.showLoading();
            }
        });
    }

    function hideLoading() {
        Swal.close();
    }

    function hapus_data(kodeKembali) {


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
            title: 'Apakah anda yakin?',
            text: "Data pengembalian akan dihapus beserta data Peminjaman, gunakan Batal jika ingin membatalkan transaksi!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                showLoading();

                // Lakukan permintaan penghapusan ke server dengan menggunakan AJAX
                $.ajax({
                    type: 'GET', // Menggunakan metode GET
                    url: '<?= base_url('kembali/hapus_kode') ?>/' + kodeKembali, // Menambahkan kode_kembali sebagai bagian dari URL
                    success: function(response) {
                        hideLoading();
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Data berhasil dihapus.',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false,
                        }).then(() => {
                            window.location.replace("<?= base_url('/kembali/riwayat') ?>");
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

<script>
    function batal_data(kodeKembali) {
        // Menggunakan SweetAlert untuk konfirmasi
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data akan dikembalikan ke data Peminjaman",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, batalkan!',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                // Jika pengguna mengonfirmasi, lanjutkan dengan permintaan fetch
                fetch('<?= base_url('/pengembalian/batal') ?>', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-Token': '<?= csrf_hash() ?>' // Pastikan token CSRF ditambahkan
                        },
                        body: JSON.stringify({
                            kode_kembali: kodeKembali
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire(
                                'Dibatalkan!',
                                'Data berhasil dibatalkan.',
                                'success'
                            ).then(() => {
                                location.reload(); // Memuat ulang halaman untuk memperbarui tampilan
                            });
                        } else {
                            Swal.fire(
                                'Gagal!',
                                'Gagal membatalkan data: ' + data.message,
                                'error'
                            );
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire(
                            'Error!',
                            'Terjadi kesalahan dalam membatalkan data.',
                            'error'
                        );
                    });
            }
        });
    }
</script>



<?php echo view('tema/footer.php'); ?>