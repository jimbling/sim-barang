
    document.addEventListener("DOMContentLoaded", function() {
        const showAllBackupBtn = document.getElementById('showAllBackupBtn');
        const tableBody = document.querySelector('tbody');
        const backupBtn = document.getElementById('backupBtn');
        let initialData;


        function displayLimitedBackupData(data) {

            tableBody.innerHTML = '';


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


            $('[data-toggle="tooltip"]').tooltip();
        }


        function displayAllBackupData(data) {

            tableBody.innerHTML = '';


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


            $('[data-toggle="tooltip"]').tooltip();
        }


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


        showAllBackupBtn.addEventListener('click', function(e) {
            e.preventDefault();


            if (!initialData) {
                fetchInitialData();
            } else {

                displayAllBackupData(initialData);


                showAllBackupBtn.classList.add('d-none');


                backupBtn.classList.add('d-none');
            }
        });


        function fetchInitialData() {
          // Gunakan baseUrl yang sudah didefinisikan di view
          const apiUrl = `${baseUrl}/backup/latest`;

          fetch(apiUrl)
              .then(response => response.json())
              .then(data => {
                  // Proses data yang diterima dari API
                  initialData = data;

                  // Tampilkan data yang diterima sesuai dengan kebutuhan Anda
                  displayLimitedBackupData(data);
              })
              .catch(error => console.error('Error:', error));
      }


        fetchInitialData();
    });



    document.addEventListener("DOMContentLoaded", function() {
        const showAllBackupBtn = document.getElementById('showAllBackupBtn');
        const tableBody = document.querySelector('tbody');
        const backupBtn = document.getElementById('backupBtn');



        function displayAllBackupData(data) {

            tableBody.innerHTML = '';


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

            $('[data-toggle="tooltip"]').tooltip();

            const reloadBtnContainer = document.getElementById('reloadBtnContainer');
            reloadBtnContainer.innerHTML = '<a class="btn btn-danger btn-sm" href="#" role="button" onclick="window.location.reload();"><i class="fas fa-sync-alt spaced-icon"></i> Reload Halaman</a>';
        }


        function fetchAllBackupData() {
          fetch(`${baseUrl}/backup/all`)
                .then(response => response.json())
                .then(data => {

                    displayAllBackupData(data);


                    showAllBackupBtn.classList.add('d-none');


                    backupBtn.classList.add('d-none');
                })
                .catch(error => console.error('Error:', error));
        }


        showAllBackupBtn.addEventListener('click', function(e) {
            e.preventDefault();


            fetchAllBackupData();
        });


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


    document.getElementById('backupBtn').addEventListener('click', function(event) {
        event.preventDefault();


        showLoading();


        fetch('/backup', {
                method: 'GET',
            })
            .then(response => response.json())
            .then(data => {

                hideLoading();


                Swal.fire({
                    icon: 'success',
                    title: 'Backup Berhasil',
                }).then(() => {

                    location.reload();
                });
            })
            .catch(error => {

                hideLoading();


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



    document.addEventListener('DOMContentLoaded', function() {

        const element = document.getElementById('elementId');


        if (element) {

            element.addEventListener('click', function() {

                console.log('Element clicked!');
            });
        }
    });


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




