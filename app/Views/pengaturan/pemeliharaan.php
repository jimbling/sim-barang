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
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const showAllBackupBtn = document.getElementById('showAllBackupBtn');
        const tableBody = document.querySelector('tbody');
        const backupBtn = document.getElementById('backupBtn');
        let initialData; // Menyimpan data awal yang dimuat secara default

        // Fungsi untuk menampilkan data backup terbatas (limit 2)
        function displayLimitedBackupData(data) {
            // Kosongkan isi tabel
            tableBody.innerHTML = '';

            // Tampilkan dua data pertama
            for (let i = 0; i < Math.min(data.length, 4); i++) {
                const backup = data[i];
                const row = `
                    <tr>
                        <th class="text-center" scope="row" style="vertical-align: middle; font-size: 14px;">${i + 1}</th>
                        <td style="vertical-align: middle; font-size: 14px;">${backup.nama_file} - ${(backup.ukuran / 1024).toFixed(2)} KB</td>
                        <td style="vertical-align: middle; font-size: 14px;">${backup.file_zip} - ${(backup.ukuran_zip / 1024).toFixed(2)} KB</td>
                        <td style="vertical-align: middle; font-size: 14px;">${formatDateTime(backup.created_at)}</td>

                        <td>
                            <a class="btn btn-success btn-sm" href="${unduhUrl}/${encodeURIComponent(backup.nama_file)}" role="button" data-toggle="tooltip" data-placement="top" title="Unduh Backup .sql">
                                <i class="fas fa-download"></i>
                            </a>
                        </td>
                        <td>
                            <a class="btn btn-warning btn-sm" href="${unduhFilesUrl}/${encodeURIComponent(backup.file_zip)}" role="button" data-toggle="tooltip" data-placement="top" title="Unduh Backup .zip">
                                <i class="fas fa-download"></i>
                            </a>
                        </td>
                    </tr>
                `;
                tableBody.innerHTML += row;
            }

            // Aktifkan tooltips dengan jQuery setelah tabel dimuat
            $('[data-toggle="tooltip"]').tooltip();
        }

        // Fungsi untuk menampilkan data backup lengkap
        function displayAllBackupData(data) {
            // Kosongkan isi tabel
            tableBody.innerHTML = '';

            // Tampilkan semua data backup
            data.forEach((backup, index) => {
                const row = `
                    <tr>
                        <th class="text-center" scope="row" style="vertical-align: middle; font-size: 14px;">${index + 1}</th>
                        <td style="vertical-align: middle; font-size: 14px;">${backup.nama_file} - ${(backup.ukuran / 1024).toFixed(2)} KB</td>
                        <td style="vertical-align: middle; font-size: 14px;">${backup.file_zip} - ${(backup.ukuran_zip / 1024).toFixed(2)} KB</td>
                        <td style="vertical-align: middle; font-size: 14px;">${formatDateTime(backup.created_at)}</td>

                        <td>
                            <a class="btn btn-success btn-sm" href="${unduhUrl}/${encodeURIComponent(backup.nama_file)}" role="button" data-toggle="tooltip" data-placement="top" title="Unduh Backup .sql">
                                <i class="fas fa-download"></i>
                            </a>
                        </td>
                        <td>
                            <a class="btn btn-warning btn-sm" href="${unduhFilesUrl}/${encodeURIComponent(backup.file_zip)}" role="button" data-toggle="tooltip" data-placement="top" title="Unduh Backup .zip">
                                <i class="fas fa-download"></i>
                            </a>
                        </td>
                    </tr>
                `;
                tableBody.innerHTML += row;
            });

            // Aktifkan tooltips dengan jQuery setelah tabel dimuat
            $('[data-toggle="tooltip"]').tooltip();
        }

        // Fungsi untuk memformat waktu
        function formatDateTime(dateTimeStr) {
            const dateTime = new Date(dateTimeStr);
            const options = {
                day: 'numeric',
                month: 'long',
                year: 'numeric',
                hour: 'numeric',
                minute: 'numeric',
                hour12: false
            };
            return dateTime.toLocaleDateString('id-ID', options);
        }

        // Tambahkan event listener untuk tombol 'Tampilkan Semua Backup'
        showAllBackupBtn.addEventListener('click', function(e) {
            e.preventDefault(); // Hindari perilaku default dari tombol

            // Jika data awal belum dimuat, lakukan pemanggilan data awal
            if (!initialData) {
                fetchInitialData();
            } else {
                // Tampilkan semua data backup
                displayAllBackupData(initialData);

                // Sembunyikan tombol 'Tampilkan Semua Backup'
                showAllBackupBtn.classList.add('d-none');

                // Sembunyikan tombol 'Buat Cadangan Database .sql'
                backupBtn.classList.add('d-none');
            }
        });

        // Fungsi untuk memuat data awal dengan batasan
        function fetchInitialData() {
            fetch('<?= base_url('/backup/latest'); ?>') // Ganti URL dengan URL yang sesuai untuk memuat data backup terbaru
                .then(response => response.json())
                .then(data => {
                    initialData = data; // Simpan data awal yang dimuat secara default

                    // Tampilkan data backup terbatas (limit 2)
                    displayLimitedBackupData(data);
                })
                .catch(error => console.error('Error:', error));
        }

        // Memuat data awal secara default dengan batasan
        fetchInitialData();
    });
</script>



<script>
    document.addEventListener("DOMContentLoaded", function() {
        const showAllBackupBtn = document.getElementById('showAllBackupBtn');
        const tableBody = document.querySelector('tbody');
        const backupBtn = document.getElementById('backupBtn');


        // Fungsi untuk menampilkan semua data backup
        function displayAllBackupData(data) {
            // Kosongkan isi tabel
            tableBody.innerHTML = '';

            // Tampilkan semua data backup
            data.forEach((backup, index) => {

                const row = `
                    <tr>
                        <th class="text-center" scope="row" style="vertical-align: middle; font-size: 14px;">${index + 1}</th>
                        <td style="vertical-align: middle; font-size: 14px;">${backup.nama_file} - ${(backup.ukuran / 1024).toFixed(2)} KB</td>
                        <td style="vertical-align: middle; font-size: 14px;">${backup.file_zip} - ${(backup.ukuran_zip / 1024).toFixed(2)} KB</td>
                        <td style="vertical-align: middle; font-size: 14px;">${formatDateTime(backup.created_at)}</td>
                        
                        <td style="vertical-align: middle; font-size: 14px;">
                            <a class="btn btn-success btn-sm" href="${unduhUrl}/${encodeURIComponent(backup.nama_file)}" role="button" data-toggle="tooltip" data-placement="top" title="Unduh Backup .sql">
                                <i class="fas fa-download"></i>
                            </a>
                        </td>
                        <td style="vertical-align: middle; font-size: 14px;">
                            <a class="btn btn-warning btn-sm" href="${unduhFilesUrl}/${encodeURIComponent(backup.file_zip)}" role="button" data-toggle="tooltip" data-placement="top" title="Unduh Backup .zip">
                                <i class="fas fa-download"></i>
                            </a>
                        </td>
                    </tr>
                `;
                tableBody.innerHTML += row;
            });
            // Aktifkan tooltips dengan jQuery setelah tabel dimuat
            $('[data-toggle="tooltip"]').tooltip();
            // Tampilkan tombol 'Reload Halaman'
            const reloadBtnContainer = document.getElementById('reloadBtnContainer');
            reloadBtnContainer.innerHTML = '<a class="btn btn-danger btn-sm" href="#" role="button" onclick="window.location.reload();"><i class="fas fa-sync-alt spaced-icon"></i> Reload Halaman</a>';
        }

        // Fungsi untuk memuat semua data backup menggunakan AJAX
        function fetchAllBackupData() {
            fetch('<?= base_url('/backup/all'); ?>') // Ganti URL dengan URL yang sesuai untuk memuat semua data backup
                .then(response => response.json())
                .then(data => {
                    // Tampilkan semua data backup
                    displayAllBackupData(data);

                    // Sembunyikan tombol 'Tampilkan Semua Backup'
                    showAllBackupBtn.classList.add('d-none');

                    // Sembunyikan tombol 'Buat Cadangan Database .sql'
                    backupBtn.classList.add('d-none');
                })
                .catch(error => console.error('Error:', error));
        }

        // Tambahkan event listener untuk tombol 'Tampilkan Semua Backup'
        showAllBackupBtn.addEventListener('click', function(e) {
            e.preventDefault(); // Hindari perilaku default dari tombol

            // Memuat semua data backup
            fetchAllBackupData();
        });

        // Fungsi untuk memformat waktu
        function formatDateTime(dateTimeStr) {
            const dateTime = new Date(dateTimeStr);
            const options = {
                day: 'numeric',
                month: 'long',
                year: 'numeric',
                hour: 'numeric',
                minute: 'numeric',
                hour12: false
            };
            return dateTime.toLocaleDateString('id-ID', options);
        }
    });
</script>






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
            title: 'membuat cadangan ....',
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

<script>
    var backup_kadaluarsa = <?php echo json_encode($backup_kadaluarsa); ?>;

    document.getElementById('hapusButton').addEventListener('click', function() {
        if (backup_kadaluarsa.length === 0) {
            // Jika tidak ada data yang kadaluarsa, tampilkan peringatan
            Swal.fire({
                title: 'NIHIL',
                text: 'Tidak ada backup yang kadaluarsa untuk dihapus.',
                icon: 'info',
                confirmButtonText: 'OK'
            });
        } else {
            // Jika ada data yang kadaluarsa, tampilkan konfirmasi penghapusan
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Apakah Anda yakin ingin menghapus semua backup yang sudah kadaluarsa?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika pengguna menekan "Ya, Hapus!", kirimkan formulir
                    document.getElementById('hapusForm').submit();
                }
            });
        }
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Ambil elemen berdasarkan id
        const element = document.getElementById('elementId');

        // Pastikan elemen ditemukan sebelum melakukan operasi
        if (element) {
            // Lakukan operasi dengan elemen
            element.addEventListener('click', function() {


            });
        }
    });
</script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mengambil elemen form dan tombol restore
        const form = document.getElementById('restoreForm');
        const restoreButton = document.getElementById('restoreButton');

        // Menambahkan event listener pada tombol restore jika elemen ditemukan
        if (restoreButton) {
            restoreButton.addEventListener('click', function() {
                // Memeriksa apakah file yang dipilih adalah file SQL
                const sqlFile = document.getElementById('sqlFile');
                const fileName = sqlFile.value;
                if (!fileName.endsWith('.sql')) {
                    // Menampilkan pesan SweetAlert jika bukan file SQL
                    Swal.fire({
                        icon: 'error',
                        title: 'Invalid File',
                        text: 'File yang diunggah harus berformat .sql!',
                    });
                    return; // Menghentikan proses jika bukan file SQL
                }

                // Menampilkan konfirmasi SweetAlert sebelum restore
                Swal.fire({
                    icon: 'warning',
                    title: 'Konfirmasi Restore',
                    text: 'Semua data yang ada akan terhapus dan akan digantikan dengan data baru. Lanjutkan?',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Lanjutkan!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    // Jika pengguna mengonfirmasi restore
                    if (result.isConfirmed) {
                        // Submit form untuk melakukan restore
                        form.submit();
                    }
                });
            });
        }
    });
</script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Periksa apakah ada pesan sukses atau error di flash data
        <?php if (session()->getFlashdata('success')) : ?>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '<?= session()->getFlashdata('success') ?>',
                onClose: () => {
                    window.location.href = '/pemeliharaan'; // Redirect ke halaman pemeliharaan setelah alert ditutup
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