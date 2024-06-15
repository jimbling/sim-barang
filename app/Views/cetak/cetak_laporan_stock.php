<?php echo view('tema/header.php'); ?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h6 class="m-0">Laporan Mutasi Barang Habis Pakai Laboratorium Keperawatan</h6>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Rekapitulasi</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">



                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Daftar Mutasi Barang Persediaan</h6>
                    </div>
                    <div class="card-body">
                        <form id="formLihatMutasi" method="get" action="<?= site_url('/laporan/lihat-mutasi'); ?>" target="_self">
                            <table class="table table-borderless table-sm">
                                <tbody>
                                    <thead>
                                        <th style="text-align: left;">Pilih Bulan</th>
                                        <th style="text-align: left;">Pilih Tahun</th>
                                        <th></th>
                                        <th></th> <!-- Kolom tambahan untuk tombol Cetak -->
                                    </thead>
                                    <tr>
                                        <td>
                                            <select class="form-control form-control-sm" id="bulanLihatMutasi" name="bulan">
                                                <option value="01">Januari</option>
                                                <option value="02">Februari</option>
                                                <option value="03">Maret</option>
                                                <option value="04">April</option>
                                                <option value="05">Mei</option>
                                                <option value="06">Juni</option>
                                                <option value="07">Juli</option>
                                                <option value="08">Agustus</option>
                                                <option value="09">September</option>
                                                <option value="10">Oktober</option>
                                                <option value="11">November</option>
                                                <option value="12">Desember</option>
                                                <!-- Tambahkan opsi bulan lainnya jika diperlukan -->
                                            </select>
                                        </td>
                                        <td>
                                            <select class="form-control form-control-sm" id="tahunLihatMutasi" name="tahun">
                                                <?php foreach ($years as $year) : ?>
                                                    <option value="<?= $year ?>"><?= $year ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </td>
                                        <td style="text-align: center; vertical-align: middle;">
                                            <button type="submit" class="btn btn-primary btn-sm">
                                                <span class="icon text-white-100">
                                                    <i class="fas fa-print spaced-icon"></i>
                                                </span>
                                                <span class="text">Lihat Mutasi</span>
                                            </button>
                                        </td>
                                        <td style="text-align: center; vertical-align: middle;">
                                            <!-- Tombol Cetak -->
                                            <button id="btnCetakMutasi" class="btn btn-success btn-sm">
                                                <span class="icon text-white-100">
                                                    <i class="fas fa-print spaced-icon"></i>
                                                </span>
                                                <span class="text">Cetak</span>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </form>


                        <hr>


                    </div>
                </div>

            </div>

            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Hapus Saldo Stock Barang Persediaan</h6>
                    </div>
                    <div class="card-body">
                        <form id="formHapusStok" action="<?= base_url('persediaan/hapusStokBulanan') ?>" method="post">
                            <!-- CSRF Token -->
                            <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />

                            <!-- Pilihan Bulan -->
                            <label for="bulan">Pilih Bulan:</label>
                            <select class="form-control form-control-sm" name="bulan" id="bulan" required>
                                <?php foreach ($bulanOptions as $bulanAngka => $bulanNama) : ?>
                                    <option value="<?= $bulanAngka ?>"><?= $bulanNama ?></option>
                                <?php endforeach; ?>
                            </select>

                            <!-- Pilihan Tahun -->
                            <label for="tahun">Pilih Tahun:</label>
                            <select class="form-control form-control-sm" name="tahun" id="tahun" required>
                                <?php foreach ($years as $year) : ?>
                                    <option value="<?= $year ?>"><?= $year ?></option>
                                <?php endforeach; ?>
                            </select>

                            <!-- Tombol Hapus -->
                            <button type="submit" class="btn btn-danger btn-sm btn-block mt-2">Hapus Stock Bulanan</button>
                        </form>

                    </div>

                </div>

            </div>
        </div>

        <div class="card shadow">
            <div class="card-body bg-success">
                <dl class="row">

                    <dt class="col-sm-3">Daftar Mutasi BHP</dt>
                    <dd class="col-sm-9">Untuk melihat dan mencetak barang habis pakai yang masuk dan keluar setiap bulan dan tahun yang dipilih.</dd>

                    <dt class="col-sm-3 text-truncate">Hapus Saldo Stock BHP</dt>
                    <dd class="col-sm-9">Untuk menghapus stock BHP yang sudah tersimpan berdasarkan bulan dan tahun yang terpilih</dd>

                </dl>
            </div>
        </div>


    </div>
</div>


<?php echo view('tema/footer.php'); ?>
<script>
    // Fungsi untuk konfirmasi penghapusan dengan SweetAlert
    function confirmDelete(event) {
        event.preventDefault(); // Mencegah form submit langsung

        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data stok bulanan untuk bulan dan tahun yang dipilih akan dihapus secara permanen.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit form jika dikonfirmasi
                document.getElementById('formHapusStok').submit();
            }
        });
    }

    // Mengaitkan fungsi confirmDelete() dengan klik tombol Hapus
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelector('.btn-danger').addEventListener('click', confirmDelete);
    });
</script>

<!-- Script untuk menangani alert setelah penghapusan berhasil -->
<?php if (session()->has('message')) : ?>
    <script>
        Swal.fire({
            title: 'Sukses!',
            text: '<?= session('message') ?>',
            icon: 'success',
            confirmButtonText: 'OK'
        });
    </script>
<?php endif; ?>
<script>
    // Ambil nilai bulan dan tahun saat form disubmit untuk tombol Lihat Mutasi
    document.getElementById('formLihatMutasi').addEventListener('submit', function(e) {
        e.preventDefault(); // Hentikan proses submit sementara

        var bulan = document.getElementById('bulanLihatMutasi').value;
        var tahun = document.getElementById('tahunLihatMutasi').value;

        var url = "<?= site_url('/laporan/lihat-mutasi') ?>?bulan=" + bulan + "&tahun=" + tahun;

        // Redirect ke halaman lihat-mutasi dengan parameter bulan dan tahun
        window.location.href = url;
    });

    // Tambahkan event listener untuk tombol Cetak
    document.getElementById('btnCetakMutasi').addEventListener('click', function(e) {
        e.preventDefault(); // Hentikan default action dari tombol

        var bulan = document.getElementById('bulanLihatMutasi').value;
        var tahun = document.getElementById('tahunLihatMutasi').value;

        var url = "<?= site_url('/cetak/daftar-mutasi-bhp') ?>?bulan=" + bulan + "&tahun=" + tahun;

        // Buka halaman cetak di tab baru
        window.open(url, '_blank');
    });
</script>