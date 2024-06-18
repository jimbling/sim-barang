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
                    </div>
                </div>
            </div>
        </section>


        <div class="row">
            <div class="col-md-12">
                <div class="card shadow card-primary card-outline">

                    <div class="card-body">
                        <a id="showAllBackupBtn" class="btn bg-indigo btn-sm" href="#" role="button"><i class='fas fa-sync-alt spaced-icon'></i> Tampilkan Semua</a>
                        <div id="reloadBtnContainer"></div>
                        <table class="table table-sm table-borderless">
                            <thead>
                                <tr style="vertical-align: middle; font-size: 14px;">
                                    <th>#</th>
                                    <th>Nama File .sql</th>
                                    <th>Nama File .zip</th>
                                    <th>Tanggal Backup</th>
                                    <th>File .sql</th>
                                    <th>File .zip</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>

                    </div>

                    <div class="card-footer">

                        <a id="backupBtn" class="btn btn-primary btn-block" href="/backup" role="button">Buat Cadangan Database dan Files</a>
                    </div>
                </div>



            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="card shadow card-danger card-outline">
                    <div class="card-body">
                        <?php if (empty($backup_kadaluarsa)) : ?>
                            <div class="alert alert-warning" role="alert">
                                Tidak Ada Backup yang Kadaluarsa
                            </div>
                        <?php else : ?>
                            <table class="table table-sm table-borderless">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama File .sql</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($backup_kadaluarsa as $backupKadaluarsa) : ?>
                                        <tr>
                                            <th class="text-center" scope="row" style="vertical-align: middle; font-size: 14px;"><?= $i++; ?></th>
                                            <td><?= $backupKadaluarsa['nama_file']; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php endif; ?>
                        <span class="row" style="font-size: 13px;">
                            File backup yang sudah 30 hari sejak tanggal dibuat, akan tampil disini. Silahkan melakukan penghapusan secara berkala agar tidak membebani kapasitas server!
                            <p>PASTIKAN ANDA SUDAH MENGAMANKAN FILE BACKUP DITEMPAT LAINNYA.</p>
                        </span>
                        <form id="hapusForm" action="<?= base_url('/hapus/backup') ?>" method="post">
                            <button type="button" class="btn btn-danger btn-block" id="hapusButton">Hapus Backup Kadaluarsa</button>
                        </form>
                    </div>

                </div>
            </div>
            <div class="col-md-4">
                <!-- Card untuk Restore Database SQL -->
                <div class="card shadow card-primary card-outline">
                    <div class="card-body">
                        <h5 class="card-title">Restore Database</h5>
                        <p class="card-text">Silakan unggah file SQL untuk merestore database.</p>

                        <form id="restoreSqlForm" action="/restore/sql" method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="sqlFile">Upload SQL File:</label>
                                <input type="file" class="form-control-file" name="sqlFile" id="sqlFile" accept=".sql" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Restore Database</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <!-- Card untuk Restore File ZIP -->
                <div class="card shadow card-primary card-outline">
                    <div class="card-body">
                        <h5 class="card-title">Restore Files</h5>
                        <p class="card-text">Silakan unggah file ZIP untuk merestore file-file terkait.</p>

                        <form id="restoreZipForm" action="restore/files" method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="fileZip">Upload ZIP File:</label>
                                <input type="file" class="form-control-file" name="fileZip" id="fileZip" accept=".zip" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Restore Files</button>
                        </form>

                    </div>
                </div>
            </div>


        </div>

    </div>

    <div class="card-body">
        <div class="alert alert-danger">
            <h5><i class="icon fas fa-info" style="font-size: 14px;"></i> PENTING!</h5>
            Fasilitas ini berguna untuk melakukan proses pencadangan database .sql dan file-file yang terkait, jika suatu hal aplikasi ada kesalahan, backup database dan file ini bisa digunakan untuk mengembalikan data keposisi terakhir kali dilakukan backup.
            Diharapkan untuk rutin melakukan proses pencadangan secara berkala dan menyimpan file .sql dan file .zip ke tempat yang aman, untuk mengantisipasi hal-hal yang tidak diinginkan dikemudian hari.
        </div>
    </div>
</div>


<?php echo view('tema/footer.php'); ?>
<script>
    const unduhUrl = '<?= base_url('/backup/unduh/') ?>';
    const unduhFilesUrl = '<?= base_url('/files/unduh/') ?>';
    const baseUrl = "<?= base_url() ?>/";
</script>
<script src="<?= base_url('assets/dist/js/frontend-js/pemeliharaan.js') ?>"></script>












<script>
    var backup_kadaluarsa = <?php echo json_encode($backup_kadaluarsa); ?>;

    document.getElementById('hapusButton').addEventListener('click', function() {
        if (backup_kadaluarsa.length === 0) {

            Swal.fire({
                title: 'NIHIL',
                text: 'Tidak ada backup yang kadaluarsa untuk dihapus.',
                icon: 'info',
                confirmButtonText: 'OK'
            });
        } else {

            Swal.fire({
                title: 'Konfirmasi',
                text: 'Apakah Anda yakin ingin menghapus semua backup yang sudah kadaluarsa?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {

                    document.getElementById('hapusForm').submit();
                }
            });
        }
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        const element = document.getElementById('elementId');


        if (element) {

            element.addEventListener('click', function() {

                console.log('Element clicked!');
            });
        }
    });
</script>


<script>
    document.addEventListener('DOMContentLoaded', function() {

        const form = document.getElementById('restoreForm');
        const restoreButton = document.getElementById('restoreButton');


        if (restoreButton) {
            restoreButton.addEventListener('click', function() {

                const sqlFile = document.getElementById('sqlFile');
                const fileName = sqlFile.value;
                if (!fileName.endsWith('.sql')) {

                    Swal.fire({
                        icon: 'error',
                        title: 'Invalid File',
                        text: 'File yang diunggah harus berformat .sql!',
                    });
                    return;
                }


                Swal.fire({
                    icon: 'warning',
                    title: 'Konfirmasi Restore',
                    text: 'Semua data yang ada akan terhapus dan akan digantikan dengan data baru. Lanjutkan?',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Lanjutkan!',
                    cancelButtonText: 'Batal'
                }).then((result) => {

                    if (result.isConfirmed) {

                        form.submit();
                    }
                });
            });
        }
    });
</script>


<script>
    document.addEventListener('DOMContentLoaded', function() {

        <?php if (session()->getFlashdata('success')) : ?>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '<?= session()->getFlashdata('success') ?>',
                onClose: () => {
                    window.location.href = '/pemeliharaan';
                }
            });
        <?php elseif (session()->getFlashdata('error')) : ?>
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '<?= session()->getFlashdata('error') ?>'
            });
        <?php endif; ?>
    });
</script>