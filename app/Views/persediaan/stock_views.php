<?php echo view('tema/header.php'); ?>

<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">

            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4 class="m-0">Data Stok Bulanan Tahun <?= esc($currentYear) ?></h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Stok Opname</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">


            <!-- Form untuk memilih tahun -->
            <form method="get" action="" class="form-inline mb-3">
                <label class="mr-2" for="year">Pilih Tahun:</label>
                <select class="form-control" name="year" id="year" onchange="this.form.submit()">
                    <?php
                    $currentYear = date('Y'); // Mendapatkan tahun berjalan

                    // Tampilkan opsi tahun berjalan
                    echo '<option value="' . $currentYear . '" selected>' . $currentYear . '</option>';
                    ?>
                </select>
            </form>
            <div class="row">

                <!-- Loop untuk menampilkan 12 Info Box, 4 vertikal dan 3 horizontal -->
                <?php for ($i = 1; $i <= 12; $i++) : ?>
                    <?php
                    $found = false;
                    $total_stok = '-';
                    foreach ($data_stock as $row) {
                        if ($row['bulan'] == $i) {
                            $found = true;
                            // Pastikan hanya angka yang diformat
                            $total_stok = is_numeric($row['total_stok']) ? number_format($row['total_stok'], 0, ',', '.') : esc($row['total_stok']);
                            break;
                        }
                    }
                    ?>
                    <div class="col-md-3 col-sm-6">
                        <div class="info-box shadow-lg <?= $found ? '' : 'bg-light' ?>">
                            <span class="info-box-icon <?= $found ? 'bg-info' : 'bg-secondary' ?>"><i class="fas fa-boxes"></i></span>
                            <div class="info-box-content">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="info-box-text"><?= getBulanName($i) ?></span>
                                    <!-- Tombol Close untuk menghapus data stok dengan SweetAlert konfirmasi -->
                                    <?php if ($found) : ?>
                                        <form action="<?= base_url('persediaan/hapusStokBulanan') ?>" method="post" id="hapusStokForm<?= $i ?>">
                                            <input type="hidden" name="bulan" value="<?= $i ?>">
                                            <input type="hidden" name="tahun" value="<?= $currentYear ?>">
                                            <button type="button" class="btn btn-danger btn-xs" onclick="confirmDelete(<?= $i ?>)">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                                <span class="info-box-number">Total Stok: <?= $total_stok ?></span>
                            </div>
                        </div>
                    </div>
                <?php endfor; ?>

            </div>

        </div>
    </div>

</div>

<?php echo view('tema/footer.php'); ?>

<!-- Script untuk SweetAlert -->
<script>
    function confirmDelete(bulan) {
        Swal.fire({
            title: 'Anda yakin?',
            text: "Anda akan menghapus data stok bulan ini!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit form untuk menghapus data
                document.getElementById('hapusStokForm' + bulan).submit();
            }
        });
    }
</script>