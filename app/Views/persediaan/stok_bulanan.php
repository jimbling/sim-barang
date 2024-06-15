<?php echo view('tema/header.php'); ?>
<style>
    /* CSS untuk mengatur ukuran font menjadi 13px */
    .table td,
    .table th {
        font-size: 14px;
    }
</style>
<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h5 class="m-0">Daftar Mutasi Barang Persediaan Bulan <?= $namaBulan ?> Tahun <?= $tahun ?></h5>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Riwayat Pinjam</li>
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

                        <div class="card-body">
                            <!-- Form untuk menyimpan data stok bulanan -->


                            <table class="table table-striped table-sm" id="tableStokBulanan" width="100%">
                                <thead class="thead">
                                    <tr>
                                        <th style="font-size: 14px;">#</th>
                                        <th style="font-size: 14px;">Nama Barang</th>
                                        <th style="font-size: 14px;">Harga Satuan</th>
                                        <th style="font-size: 14px;">Saldo Awal</th>
                                        <th style="font-size: 14px;">Jumlah Penerimaan</th>
                                        <th style="font-size: 14px;">Pengeluaran Dengan Peminjaman</th>
                                        <th style="font-size: 14px;">Pengeluaran Tanpa Peminjaman</th>
                                        <th style="font-size: 14px;">Sisa Stok</th>
                                        <th style="font-size: 14px;">Satuan</th>
                                    </tr>
                                    <tr>
                                        <th style="font-size: 10px; font-style: italic;">#</th>
                                        <th style="font-size: 10px; font-style: italic;">1</th>
                                        <th style="font-size: 10px; font-style: italic;">2</th>
                                        <th style="font-size: 10px; font-style: italic;">3</th>
                                        <th style="font-size: 10px; font-style: italic;">4</th>
                                        <th style="font-size: 10px; font-style: italic;">5</th>
                                        <th style="font-size: 10px; font-style: italic;">6</th>
                                        <th style="font-size: 10px; font-style: italic;">(3+4)-(5+6)</th>
                                        <th style="font-size: 10px; font-style: italic;"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($barangList as $index => $barang) : ?>
                                        <tr>
                                            <td><?= $index + 1; ?></td>
                                            <td style="text-align: left;"><?= $barang['nama_barang']; ?></td>
                                            <td style="text-align: right;">Rp. <?= number_format($barang['harga_satuan'], 0, ',', '.'); ?></td>
                                            <td><?= $barang['jumlah_saldo_awal']; ?></td>
                                            <td><?= $barang['jumlah_penerimaan']; ?></td>
                                            <td width="15%"><?= $barang['jumlah_pengeluaran']; ?></td>
                                            <td width="15%"><?= $barang['jumlah_pengeluaran_murni']; ?></td>
                                            <td><?= $barang['sisa_stok']; ?></td>
                                            <td><?= $barang['satuan']; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3"><strong>Total</strong></td>
                                        <td><strong><?= $totalSaldoAwal; ?></strong></td>
                                        <td><strong><?= $totalJumlahPenerimaan; ?></strong></td>
                                        <td><strong><?= $totalJumlahPengeluaran; ?></strong></td>
                                        <td><strong><?= $totalJumlahPengeluaranMurni; ?></strong></td>
                                        <td><strong><?= $totalSisaStok; ?></strong></td>
                                        <td><strong></strong></td>

                                    </tr>
                                </tfoot>
                            </table>

                            <form id="formStokBulanan" action="<?= base_url('persediaan/simpanStokBulanan') ?>" method="post">
                                <!-- CSRF Token -->
                                <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />

                                <!-- Input hidden untuk bulan dan tahun -->
                                <?php if (isset($bulanAngka)) : ?>
                                    <input type="hidden" name="bulan" value="<?= $bulanAngka ?>" />
                                <?php endif; ?>
                                <input type="hidden" name="tahun" value="<?= $tahun ?>" />

                                <!-- Input hidden untuk setiap barang dalam barangList -->
                                <?php foreach ($barangList as $barang) : ?>
                                    <input type="hidden" name="barang_id[]" value="<?= $barang['barang_id'] ?>" />
                                    <input type="hidden" name="harga_satuan[]" value="<?= $barang['harga_satuan'] ?>" />
                                    <input type="hidden" name="sisa_stok[]" value="<?= $barang['sisa_stok'] ?>" />
                                <?php endforeach; ?>

                                <!-- Tombol Submit dengan SweetAlert2 konfirmasi -->
                                <?php if ($isDataExists) : ?>
                                    <button type="button" class="btn btn-primary btn-sm" disabled>Data Sudah Ada</button>
                                    <p class="text-danger">Data stok untuk bulan dan tahun ini sudah ada.</p>
                                <?php else : ?>
                                    <button type="submit" class="btn btn-primary btn-sm" onclick="confirmSave()">Simpan Stok Bulanan</button>
                                <?php endif; ?>

                                <button type="button" class="btn btn-warning btn-sm" onclick="goToLaporanStock()">Kembali</button>
                            </form>


                        </div>
                    </div>



                </div>
            </div>
        </div>
    </div>

</div>



<?php echo view('tema/footer.php'); ?>
<script>
    function goToLaporanStock() {
        window.location.href = '<?= base_url('/laporan/mutasi') ?>';
    }
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mengambil form dengan ID formStokBulanan
        var formStokBulanan = document.getElementById('formStokBulanan');

        // Menambahkan event listener untuk menangani submit form
        formStokBulanan.addEventListener('submit', function(event) {
            event.preventDefault(); // Menghentikan pengiriman form secara langsung

            // Menampilkan konfirmasi SweetAlert
            Swal.fire({
                title: 'Simpan Stok Bulanan?',
                text: "Stok Bulan Ini akan menjadi saldo awal bulan berikutnya!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Simpan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika pengguna mengonfirmasi, lanjutkan dengan pengiriman form
                    formStokBulanan.submit();
                }
            });
        });
    });
</script>