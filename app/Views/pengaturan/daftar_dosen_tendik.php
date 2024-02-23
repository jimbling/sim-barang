<?php echo view('tema/header.php'); ?>

<div class="content-wrapper">
    <div class="flash-data" data-flashdata="<?= (session()->getFlashData('pesanEditDosenTendik')); ?>"></div><!-- Page Heading -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4 class="m-0">Data Mahasiswa</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Data Mahasiswa</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>


    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-8 col-12">
                    <div class="card card-primary card-outline shadow-lg">

                        <div class="card-header">
                            <div class="btn-toolbar justify-content-between" role="toolbar" aria-label="Toolbar with button groups">
                                <div class="btn-group" role="group" aria-label="First group">
                                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#importMhsModal">
                                        <i class='fas fa-upload spaced-icon'></i>Import</a>
                                    </button>
                                </div>
                                <div class="btn-toolbar">
                                    <td style="text-align: center;">
                                        <button type="button" class="btn btn-danger btn-sm" onclick="deleteSelectedItems()"><i class='fas fa-trash-alt spaced-icon'></i>Hapus</button>
                                    </td>
                                </div>

                            </div>
                            <div class="row">
                            </div>
                        </div>


                        <div class="card-body">
                            <table id="daftarDosenTendik" class="table table-striped table-responsive table-sm">
                                <thead class="thead bg-success" style="font-size: 14px;">
                                    <tr>
                                        <th width='3%'>No</th>
                                        <th style="text-align: center;">NIK</th>
                                        <th style="text-align: center;">Nama Lengkap</th>
                                        <th style="text-align: center;">Jabatan</th>
                                        <th width='10%' style="text-align: center;">

                                            <input type="checkbox" id="select-all-checkbox">
                                        </th> <!-- Checkbox master -->
                                        <th style="text-align: center;">AKSI</th>
                                    </tr>
                                </thead>
                                <div id="alertContainer" class="mt-3"></div>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($dosen_tendik as $data_dosen_tendik) : ?>
                                        <tr class="searchable-row">
                                            <th class="text-center" scope="row" style="vertical-align: middle; font-size: 14px;"><?= $i++; ?></th>
                                            <td width='20%' style="text-align: center; vertical-align: middle; font-size: 14px;"><?= $data_dosen_tendik['nik']; ?></td>
                                            <td style="text-align: left; vertical-align: middle; font-size: 14px;"><?= $data_dosen_tendik['nama_lengkap']; ?></td>
                                            <td style="text-align: center; vertical-align: middle; font-size: 14px;"><?= $data_dosen_tendik['jabatan']; ?></td>
                                            <td style="text-align: center;">
                                                <input type="checkbox" class="checkbox-item" data-id="<?= $data_dosen_tendik['id']; ?>">
                                            </td>
                                            <td width='10%' class="text-center">
                                                <button type="button" class="btn btn-info btn-xs edit-btn" style="vertical-align: middle;" data-toggle="tooltip" data-placement="left" title="Edit" onclick="openEditModal(<?= $data_dosen_tendik['id']; ?>)"><i class='fas fa-edit'></i></button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-12">
                    <div class="card card-danger card-outline shadow-lg">
                        <div class="card-header">
                            Tambah Dosen dan Tendik
                        </div>
                        <div class="card-body">
                            <form action="/data/dosen_tendik/tambah" method="post" id="form-dosentendik">
                                <input type="hidden" name="<?= csrf_token() ?>" value="<?= $csrfToken ?>">
                                <div class="form-group">
                                    <label for="nik">NIK:</label>
                                    <input type="text" class="form-control" id="nik" name="nik" placeholder="Masukkan Nomor Induk Kepegawaian">
                                </div>
                                <div class="form-group">
                                    <label for="nama_lengkao">Nama Lengkap:</label>
                                    <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" placeholder="Masukkan nama lengkap Dosen/Tendik">
                                </div>
                                <div class="form-group">
                                    <label for="jabatan">Jabatan:</label>
                                    <select class="form-control" id="jabatan" name="jabatan">
                                        <option value="Dosen">Dosen</option>
                                        <option value="Tenaga Kependidikan">Tenaga Kependidikan</option>
                                    </select>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-10">
                                        <button type="submit" class="btn btn-primary btn-sm"><i class='fas fa-sign-in-alt spaced-icon'></i>Tambah</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card card-warning card-outline shadow-lg">
                        <div class="card-header">
                            <strong>Buat Akun Dosen dan Tendik</strong>
                        </div>
                        <div class="card-body">
                            <p>
                                Untuk membuat Akun Login Dosen dan Tendik, silahkan pilih Dosen dan Tendik dengan Checkbox, kemudian tekan tombol Buat Akun dibawah ini.
                            </p>
                            <div class="btn-toolbar">
                                <td style="text-align: center;">
                                    <button type="button" class="btn bg-indigo btn-sm" onclick="copySelectedItems()"><i class='fas fa-user-shield spaced-icon'></i>Buat Akun</button>
                                </td>
                            </div>
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

<!-- Modal untuk import data barang -->
<div class="modal fade" id="importMhsModal" tabindex="-1" aria-labelledby="importMhsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="importMhsModalLabel">Import Data Dosen dan Tendik</h5>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <form action="#" method="post" enctype="multipart/form-data" id="uploadForm">
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="excel_file" aria-describedby="excel_file" name="excel_file">
                                <label class="custom-file-label" for="excel_file">Pilih file Excel</label>
                            </div>
                        </div>
                        <span id="excel_file"></span>
                        <!-- Tambahkan elemen ini untuk menampilkan nama file -->
                        <span id="file_name_display"></span>
                    </form>

                    <div class="alert alert-info mt-3" role="alert">
                        <p><strong>Informasi</strong></p>
                        <p>Gunakan hanya file ber ekstensi <strong>.xls</strong> atau <strong>.xlsx </strong>. </p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="input-group-append">
                    <style>
                        button {
                            margin-right: 10px;
                            /* Atur jarak kanan antara tombol */
                        }
                    </style>
                    <button type="button" class="btn btn-warning mt-2" data-dismiss="modal"><i class='fas fa-reply-all' style="margin-right: 5px;"></i></i>Batal</button>
                    <button class="btn btn-outline-primary mt-2" type="button" id="importButton"><i class='fas fa-upload' style="margin-right: 5px;"></i> Impor</button>
                    <div class="spinner-container">
                        <div id="loading" class="spinner-border text-primary" role="status" style="display: none;">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <span id="processText" style="display: none;">Proses kirim data...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal untuk Import Data Barang -->

<!-- Modal Edit Data Barang -->
<div class="modal fade" id="editDosenTendik" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/data/mahasiswa/update" method="post" id="formEditDosenTendik">
                <input type="hidden" name="edit_id" id="edit_id" value="">
                <div class="modal-body">
                    <input type="hidden" name="<?= csrf_token() ?>" value="<?= $csrfToken ?>">

                    <div class="form-group row">
                        <label for="nik_edit" class="col-sm-4 col-form-label">NIK</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="nik_edit" id="nik_edit">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nama_lengkap_edit" class="col-sm-4 col-form-label">Nama Lengkap</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="nama_lengkap_edit" id="nama_lengkap_edit">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nama_lengkap_edit" class="col-sm-4 col-form-label">Jabatan</label>
                        <div class="col-sm-8">
                            <select class="form-control" id="jabatan_edit" name="jabatan_edit">
                                <option value="Dosen">Dosen</option>
                                <option value="Tenaga Kependidikan">Tenaga Kependidikan</option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("form-dosentendik").addEventListener("submit", function(event) {
            event.preventDefault(); // Mencegah formulir dikirim secara langsung

            var nik = document.getElementById("nik").value.trim();
            var nama_lengkap = document.getElementById("nama_lengkap").value.trim();

            if (nik === "") {
                toastr.error("NIK harus diisi");
            }
            if (nama_lengkap === "") {
                toastr.error("Nama Lengkap harus diisi");
            }
            if (nik !== "" && nama_lengkap !== "") {
                this.submit(); // Kirim formulir jika valid
            }
        });
    });
</script>

<script>
    function openEditModal(id) {
        // Set nilai input hidden dengan ID yang diambil dari tombol edit
        document.getElementById('edit_id').value = id;

        // Perbarui aksi formulir sesuai dengan ID
        document.getElementById('formEditDosenTendik').action = "/data/dosen_tendik/update/" + id;
        // Fetch data using AJAX
        $.ajax({
            url: '/dosen_tendik/get_detail/' + id,
            method: 'GET',
            success: function(data) {
                console.log(data); // Periksa data yang diterima di konsol browser
                // Populate the modal with the fetched data
                $('#editDosenTendik').modal('show');
                populateEditModal(data);

                // Set nilai input tersembunyi dengan nilai 'id'
                $('#editId').val(id);
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    }

    function populateEditModal(data) {
        // Populate the form fields with the fetched data
        $('#nik_edit').val(data.nik);
        $('#nama_lengkap_edit').val(data.nama_lengkap);
        $('#jabatan_edit').val(data.jabatan);

    }
</script>

<!-- Akhir edit Barang -->

<script>
    // JavaScript untuk mengontrol checkbox master
    document.getElementById('select-all-checkbox').addEventListener('change', function() {
        var checkboxes = document.querySelectorAll('.checkbox-item');
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = document.getElementById('select-all-checkbox').checked;
        });
    });
</script>


<!-- Fungsi Hapus Barang -->
<script>
    function deleteSelectedItems() {
        var selectedIds = [];

        // Get all selected checkboxes
        $('.checkbox-item:checked').each(function() {
            selectedIds.push($(this).data('id'));
        });

        // Check if any checkbox is selected
        if (selectedIds.length > 0) {
            // Use SweetAlert for confirmation
            Swal.fire({
                title: 'Anda yakin?',
                text: 'Data yang dipilih akan dihapus!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    showLoading(); // Show loading indicator
                    // Send AJAX request to delete the items
                    $.ajax({
                        url: '/data/dosen_tendik/hapus', // Update with your actual controller and method
                        method: 'POST',
                        data: {
                            ids: selectedIds
                        },
                        success: function(response) {
                            hideLoading(); // Hide loading indicator

                            Swal.fire({
                                title: 'Berhasil!',
                                text: 'Data berhasil dihapus.',
                                icon: 'success',
                                timer: 2000, // Durasi tampilan dalam milidetik (misalnya, 5000 milidetik = 5 detik)
                                showConfirmButton: false, // Sembunyikan tombol OK (jika tidak diinginkan)
                            }).then(() => {
                                // Arahkan pengguna ke halaman baru setelah SweetAlert ditutup
                                window.location.replace("/data/dosen_tendik");
                            });
                        },
                        error: function(error) {
                            hideLoading(); // Hide loading indicator

                            console.error('Error:', error);
                            Swal.fire({
                                title: 'Error!',
                                text: 'Terjadi kesalahan saat menghapus data.',
                                icon: 'error',
                            });
                        }
                    });
                }
            });
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'Peringatan',
                text: 'Pilih setidaknya satu data mahasiswa untuk dihapus.'
            });
        }
    }
</script>

<!-- Akhir fungsi hapus barang -->


<!-- Script Modal untuk fasilitas upload -->

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const fileInput = document.getElementById("excel_file");
        const importButton = document.getElementById("importButton");
        const loading = document.getElementById("loading");
        const processText = document.getElementById("processText"); // Teks "Proses kirim data..."
        const fileNameDisplay = document.getElementById("file_name_display"); // Menambahkan elemen untuk menampilkan nama file

        fileInput.addEventListener("change", function() {
            if (fileInput.files.length > 0) {
                // Menampilkan nama file yang dipilih dalam elemen label
                fileNameDisplay.textContent = `File terpilih: ${fileInput.files[0].name}`;
            } else {
                // Mengosongkan teks elemen label jika tidak ada file yang dipilih
                fileNameDisplay.textContent = "";
            }
        });

        importButton.addEventListener("click", function() {
            if (fileInput.files.length > 0) {
                const allowedFileTypes = ["application/vnd.ms-excel", "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"];
                const selectedFileType = fileInput.files[0].type;

                if (allowedFileTypes.includes(selectedFileType)) {
                    // Jenis file diijinkan, lanjutkan dengan pengiriman
                    loading.style.display = "inline-block"; // Menampilkan spinner
                    processText.style.display = "inline-block"; // Menampilkan teks "Proses kirim data..."

                    const formData = new FormData();
                    formData.append("excel_file", fileInput.files[0]);
                    // Set teks pada elemen dengan ID "file_name_display"

                    const fileNameDisplay = document.getElementById("excel_file");
                    fileNameDisplay.textContent = `File terpilih: ${fileInput.files[0].name}`;

                    fetch("/data/dosen_tendik/importData", {
                            method: "POST",
                            body: formData,
                        })
                        .then(response => response.json())
                        .then(data => {
                            console.log(data); // Tampilkan data JSON ke dalam konsol
                            loading.style.display = "none"; // Menyembunyikan spinner
                            processText.style.display = "none"; // Menyembunyikan teks "Proses kirim data..."

                            if (data.status === "success") {
                                Swal.fire({
                                    icon: "success",
                                    title: "File Berhasil Diimpor!",
                                    text: data.message,
                                    timer: 5000, // Durasi tampilan dalam milidetik (misalnya, 5000 milidetik = 5 detik)
                                    showConfirmButton: false, // Sembunyikan tombol OK (jika tidak diinginkan)
                                }).then(() => {
                                    // Refresh halaman setelah pengguna menutup SweetAlert
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: "error",
                                    title: "Gagal Impor File!",
                                    text: data.message,
                                    timer: 5000, // Durasi tampilan dalam milidetik (misalnya, 5000 milidetik = 5 detik)
                                    showConfirmButton: false, // Sembunyikan tombol OK (jika tidak diinginkan)
                                });
                            }
                        })
                        .catch(error => {
                            loading.style.display = "none"; // Menyembunyikan spinner
                            processText.style.display = "none"; // Menyembunyikan teks "Proses kirim data..."
                            console.error(error);

                            // Tampilkan pesan kesalahan kustom
                            Swal.fire({
                                icon: "error",
                                title: "Terjadi Kesalahan!",
                                text: "Terjadi kesalahan saat mengimpor file. Pastikan file yang Anda unggah adalah file Excel yang valid.",
                            });
                        });

                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Jenis File Tidak Diijinkan!",
                        text: "Anda hanya dapat mengimpor file dengan format XLS atau XLSX.",
                    });
                }
            } else {
                Swal.fire({
                    icon: "error",
                    title: "File Belum Dipilih!",
                    text: "Anda harus memilih file terlebih dahulu sebelum mengimpor.",
                });
            }
        });
    });
</script>

<!-- <script>
    function copySelectedItems() {
        var selectedIds = [];

        // Get all selected checkboxes
        $('.checkbox-item:checked').each(function() {
            selectedIds.push($(this).data('id'));
        });

        // Log selected IDs to console
        console.log(selectedIds);

        // Check if any checkbox is selected
        if (selectedIds.length > 0) {
            // Use SweetAlert for confirmation
            Swal.fire({
                title: 'Anda yakin?',
                text: 'Data yang dipilih akan dibuatkan Akun Login!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Buat!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    showLoading(); // Show loading indicator
                    // Send AJAX request to copy the items
                    $.ajax({
                        url: '/data/dosen_tendik/copy', // Update with your actual controller and method
                        method: 'POST',
                        data: {
                            selected_ids: selectedIds
                        },
                        success: function(response) {
                            if (response.success) {
                                // Hide loading indicator
                                hideLoading();
                                // Jika sukses, tampilkan pesan berhasil
                                Swal.fire({
                                    title: 'Berhasil!',
                                    text: 'Akun login berhasil dibuat.',
                                    icon: 'success',
                                    timer: 2000,
                                    showConfirmButton: false,
                                }).then(() => {
                                    // Redirect to specified page
                                    window.location.replace("/data/pengguna");
                                });
                            } else {
                                // Hide loading indicator
                                hideLoading();
                                // Jika terjadi kesalahan, gabungkan pesan kesalahan menjadi satu pesan dengan format HTML dan tampilkan
                                var errorMessage = '<div style="text-align: left;">Terjadi kesalahan:<br><ul>';
                                for (var i = 0; i < response.errors.length; i++) {
                                    errorMessage += '<li>' + response.errors[i] + '</li>';
                                }
                                errorMessage += '</ul></div>';
                                Swal.fire({
                                    title: 'Error!',
                                    html: errorMessage,
                                    icon: 'error',
                                    showCloseButton: true,
                                    showCancelButton: false,
                                    showConfirmButton: false
                                });
                            }
                        },
                        error: function(error) {
                            console.error('Error:', error);
                            // Hide loading indicator
                            hideLoading();
                            Swal.fire({
                                title: 'Error!',
                                text: 'Terjadi kesalahan saat menyalin data.',
                                icon: 'error',
                            });
                        }
                    });
                }
            });
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'Peringatan',
                text: 'Pilih setidaknya satu data dosen/tendik untuk disalin.'
            });
        }
    }

    function showLoading() {
        // Show loading indicator
        // Implement your loading indicator display logic here
        // For example:
        $('#loadingIndicator').show();
    }

    function hideLoading() {
        // Hide loading indicator
        // Implement your loading indicator hide logic here
        // For example:
        $('#loadingIndicator').hide();
    }
</script> -->

<script>
    function copySelectedItems() {
        var selectedIds = [];

        // Get all selected checkboxes
        $('.checkbox-item:checked').each(function() {
            selectedIds.push($(this).data('id'));
        });

        // Check if any checkbox is selected
        if (selectedIds.length > 0) {
            // Use SweetAlert for confirmation
            Swal.fire({
                title: 'Anda yakin?',
                text: 'Data yang dipilih akan dibuatkan Akun Login!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Buat!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    showLoading(); // Show loading indicator
                    // Send AJAX request to copy the items
                    $.ajax({
                        url: '/data/dosen_tendik/copy', // Update with your actual controller and method
                        method: 'POST',
                        data: {
                            selected_ids: selectedIds
                        },

                        success: function(response) {
                            if (response.success) {
                                // Hide loading indicator
                                hideLoading();

                                // Delay before showing SweetAlert
                                setTimeout(function() {
                                    // Jika sukses, tampilkan pesan berhasil
                                    Swal.fire({
                                        title: 'Berhasil!',
                                        text: 'Akun login berhasil dibuat.',
                                        icon: 'success',
                                        timer: 2000, // Durasi tampilan dalam milidetik (misalnya, 5000 milidetik = 5 detik)
                                        showConfirmButton: false, // Sembunyikan tombol OK (jika tidak diinginkan)
                                    }).then(() => {
                                        // Redirect to specified page
                                        window.location.replace("/data/pengguna");
                                    });
                                }, 500); // Adjust delay time as needed
                            } else {
                                // Hide loading indicator
                                hideLoading();
                                // Jika terjadi kesalahan, gabungkan pesan kesalahan menjadi satu pesan dengan format HTML dan tampilkan
                                var errorMessage = '<div style="text-align: left;">Terjadi kesalahan:<br><ul>';
                                for (var i = 0; i < response.errors.length; i++) {
                                    errorMessage += '<li>' + response.errors[i] + '</li>';
                                }
                                errorMessage += '</ul></div>';
                                Swal.fire({
                                    title: 'Error!',
                                    html: errorMessage,
                                    icon: 'error',
                                    showCloseButton: true,
                                    showCancelButton: false,
                                    showConfirmButton: false
                                });
                            }
                        },


                        error: function(error) {
                            console.error('Error:', error);
                            // Hide loading indicator
                            hideLoading();
                            Swal.fire({
                                title: 'Error!',
                                text: 'Terjadi kesalahan saat menyalin data.',
                                icon: 'error',
                            });
                        }
                    });
                }
            });
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'Peringatan',
                text: 'Pilih setidaknya satu data dosen/tendik untuk dibuatkan akun login.'
            });
        }
    }
</script>

<?php echo view('tema/footer.php'); ?>