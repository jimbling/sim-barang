<?php echo view('tema/header.php'); ?>
<div class="content-wrapper">
    <div class="container-fluid">
        <div class="flash-data" data-flashdata="<?= (session()->getFlashData('pesanAkun')); ?>"></div><!-- Page Heading -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h5>Backup Database</h5>
                    </div>
                    <div class="col-sm-6">

                        <ol class="breadcrumb float-sm-right">
                            <a id="backupBtn" class="btn btn-primary" href="/backup" role="button">Buat Cadangan Database .sql</a>
                        </ol>
                    </div>
                </div>
            </div>
        </section>


        <div class="card shadow card-danger card-outline">
            <div class="card-body">
                <table class="table table-sm table-borderless">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama File .sql</th>
                            <th>Tanggal Backup</th>
                            <th>Ukuran File (KB)</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($backup_db as $backup) : ?>
                            <tr>
                                <th class="text-center" scope="row" style="vertical-align: middle; font-size: 14px;"><?= $i++; ?></th>
                                <td><?= $backup['nama_file']; ?></td>
                                <td><?= $backup['created_at']; ?></td>
                                <td>
                                    <?php
                                    // Konversi ukuran file dari byte ke kilobyte
                                    $ukuran_kb = round($backup['ukuran'] / 1024, 2);
                                    echo $ukuran_kb . " KB";
                                    ?>
                                </td>
                                <td>
                                    <a class="btn btn-success btn-sm" href="<?= base_url('/backup/unduh/' . $backup['nama_file']); ?>" role="button" data-toggle="tooltip" data-placement="top" title="Unduh Backup .sql">
                                        <i class="fas fa-download"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                    </tbody>
                </table>


            </div>

        </div>

    </div>
    <div class="card-body">
        <div class="alert alert-danger">

            <h5><i class="icon fas fa-info"></i> PENTING!</h5>
            Fasilitas ini berguna untuk melakukan proses pencadangan database .sql, jika suatu hal aplikasi ada kesalahan, backup database ini bisa digunakan untuk mengembalikan data keposisi terakhir kali dilakukan backup.
            Diharapkan untuk rutin melakukan proses pencadangan secara berkala dan menyimpan file .sql ke tempat yang aman, untuk mengantisipasi hal-hal yang tidak diinginkan dikemudian hari.
        </div>
    </div>
</div>


<?php echo view('tema/footer.php'); ?>

<script>
    document.getElementById('backupBtn').addEventListener('click', function(event) {
        event.preventDefault();

        // Tampilkan loading
        showLoading();

        // Lakukan request AJAX untuk membuat backup
        fetch('/backup', {
                method: 'GET',
            })
            .then(response => response.json())
            .then(data => {
                // Sembunyikan loading
                hideLoading();

                // Tampilkan SweetAlert dengan nama file hasil backup
                Swal.fire({
                    icon: 'success',
                    title: 'Backup Berhasil',
                    text: 'Nama File: ' + data.nama_file,
                }).then(() => {
                    // Reload halaman setelah SweetAlert terkonfirmasi
                    location.reload();
                });
            })
            .catch(error => {
                // Sembunyikan loading
                hideLoading();

                // Tampilkan SweetAlert dengan pesan error
                Swal.fire({
                    icon: 'error',
                    title: 'Backup Gagal',
                    text: 'Error: ' + error.message,
                });
            });
    });

    function showLoading() {
        let timerInterval
        Swal.fire({
            title: 'membackup database ....',
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
</script>