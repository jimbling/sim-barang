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