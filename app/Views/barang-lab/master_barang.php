<?php echo view('tema/header.php'); ?>
<style>
    /* CSS untuk mengatur ukuran font menjadi 13px */
    .table td,
    .table th {
        font-size: 13px;
    }
</style>
<div class="content-wrapper">
    <div class="flash-data" data-flashdata="<?= (session()->getFlashData('pesanEditBarang')); ?>"></div><!-- Page Heading -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="alert alert-info" style="font-size: 14px;" role="alert">
                Pada halaman ini, menampilkan seluruh data barang dengan jumlah satuan, beserta dengan kode untuk masing-masing barang.
                <p><strong>Setiap barang, memiliki kode/no inventaris yang unik, meskipun nama barangnya sama.</strong>
                <p>Untuk menambahkan barang dalam jumlah banyak, disarankan menggunakan fasilitas Import Data
            </div>
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4 class="m-0">Data Barang</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Data Barang</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>


    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-9 col-12">
                    <div class="card card-primary card-outline shadow-lg">

                        <div class="card-header">
                            <div class="btn-toolbar justify-content-between" role="toolbar" aria-label="Toolbar with button groups">
                                <div class="btn-group" role="group" aria-label="First group">
                                    <button type="button" class="btn btn-warning btn-sm float-right" data-toggle="modal" data-target="#importBarangModal">
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
                            <table id="dataBarangTable" class="table table-striped table-responsive table-sm">
                                <thead class="thead-grey" style="font-size: 14px;">
                                    <tr>
                                        <th width='3%' style="text-align: center; vertical-align: middle; font-size: 14px;">No</th>
                                        <th style="text-align: center; vertical-align: middle; font-size: 14px;">Kode Barang</th>
                                        <th style="text-align: center; vertical-align: middle; font-size: 14px;">Nama Barang</th>
                                        <th style="text-align: center; vertical-align: middle; font-size: 14px;">Jumlah Barang</th>
                                        <th width='10%' style="text-align: center; vertical-align: middle; font-size: 14px;">Kondisi Barang</th>
                                        <th width='10%' style="text-align: center; vertical-align: middle; font-size: 14px;">Disewakan</th>
                                        <th width='5%' style="text-align: center; vertical-align: middle;">

                                            <input type="checkbox" id="select-all-checkbox">
                                        </th> <!-- Checkbox master -->
                                        <th style="text-align: center; vertical-align: middle;">AKSI</th>
                                    </tr>
                                </thead>

                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-12">
                    <div class="card card-danger card-outline shadow-lg">
                        <div class="card-header">
                            Tambah Barang Baru
                        </div>
                        <div class="card-body">
                            <form action="/barang/tambah" method="post">
                                <input type="hidden" name="<?= csrf_token() ?>" value="<?= $csrfToken ?>">
                                <div class="form-group">
                                    <label for="inputAddress">Kode Barang:</label>
                                    <input type="text" class="form-control" id="kode_barang" name="kode_barang" placeholder="Masukkan no. inventaris barang" required>
                                </div>
                                <div class="form-group">
                                    <label for="inputAddress">Nama Barang:</label>
                                    <input type="text" class="form-control" id="nama_barang" name="nama_barang" placeholder="Masukkan nama barang" required>
                                </div>
                                <div class="form-group">
                                    <label for="inputAddress2">Jumlah Barang:</label>
                                    <input type="number" class="form-control" id="jumlah_barang" name="jumlah_barang" placeholder="Masukkan jumlah barang" oninput="validateNumberInput(this)" required>
                                    <small id="jumlah_barang_error" class="text-danger"></small>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-10">
                                        <button type="submit" class="btn btn-primary btn-sm"><i class='fas fa-sign-in-alt spaced-icon'></i>Tambah</button>
                                    </div>
                                </div>
                            </form>
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
<div class="modal fade" id="importBarangModal" tabindex="-1" aria-labelledby="importBarangModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="importBarangModalLabel">Import Data Barang</h5>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <form action="/siswa/importData" method="post" enctype="multipart/form-data" id="uploadForm">
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
<div class="modal fade" id="editBarang" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/barang/update" method="post" id="formEditBarang">
                <input type="hidden" name="edit_id" id="edit_id" value="">
                <div class="modal-body">
                    <input type="hidden" name="<?= csrf_token() ?>" value="<?= $csrfToken ?>">

                    <div class="form-group row">
                        <label for="nama_barang_edit" class="col-sm-4 col-form-label">Nama Barang</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="nama_barang_edit" id="nama_barang_edit">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="jumlah_barang_edit" class="col-sm-4 col-form-label">Jumlah Barang</label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" name="jumlah_barang_edit" id="jumlah_barang_edit">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="kondisi_barang_edit" class="col-sm-4 col-form-label">Kondisi Barang</label>
                        <div class="col-sm-8">
                            <select class="form-control" id="kondisi_barang_edit" name="kondisi_barang_edit">
                                <option value="baik">Baik</option>
                                <option value="rusak">Rusak</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="disewakan_edit" class="col-sm-4 col-form-label">Disewakan</label>
                        <div class="col-sm-8">
                            <select class="form-control" id="disewakan_edit" name="disewakan_edit">
                                <option value="Ya">Ya</option>
                                <option value="Tidak">Tidak</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="harga_sewa_edit" class="col-sm-4 col-form-label">Harga Sewa</label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" name="harga_sewa_edit" id="harga_sewa_edit">
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
    function openEditModal(id) {
        // Set nilai input hidden dengan ID yang diambil dari tombol edit
        document.getElementById('edit_id').value = id;

        // Perbarui aksi formulir sesuai dengan ID
        document.getElementById('formEditBarang').action = "/barang/update/" + id;
        // Fetch data using AJAX
        $.ajax({
            url: '/barang/get_detail/' + id,
            method: 'GET',
            success: function(data) {
                console.log(data); // Periksa data yang diterima di konsol browser
                // Populate the modal with the fetched data
                $('#editBarang').modal('show');
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
        $('#nama_barang_edit').val(data.nama_barang);
        $('#jumlah_barang_edit').val(data.jumlah_barang);
        $('#kondisi_barang_edit').val(data.kondisi_barang);
        $('#disewakan_edit').val(data.disewakan);
        $('#harga_sewa_edit').val(data.harga_sewa);

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
                        url: '/barang/hapus', // Update with your actual controller and method
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
                                window.location.replace("/barang/master");
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
                text: 'Pilih setidaknya satu data barang untuk dihapus.'
            });
        }
    }
</script>

<!-- Akhir fungsi hapus barang -->

<script>
    function validateNumberInput(input) {
        var inputValue = input.value.trim();
        var errorMessage = document.getElementById('jumlah_barang_error');

        // Gunakan ekspresi reguler untuk memeriksa apakah nilai hanya berisi angka
        if (/^\d+$/.test(inputValue)) {
            // Hapus pesan kesalahan jika ada
            errorMessage.textContent = '';
        } else {
            // Tampilkan pesan kesalahan jika nilai tidak valid
            errorMessage.textContent = 'Harap masukkan hanya angka.';
        }
    }
</script>

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

                    fetch("/barang/importData", {
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
<script src="../../assets/dist/js/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function() {
        $('#dataBarangTable').DataTable({
            "processing": true,
            "ajax": {
                "url": "<?= base_url('barang/fetchData') ?>", // Ganti dengan URL yang sesuai
                "type": "POST"
            },
            "columns": [{
                    "data": null,
                    "className": "text-center",
                    "orderable": false,
                    "render": function(data, type, row, meta) {
                        // Mengatur nomor urut di kolom pertama
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    "data": "kode_barang",
                    "className": "text-center"
                },
                {
                    "data": "nama_barang",
                    "className": "text-center"
                },
                {
                    "data": "jumlah_barang",
                    "className": "text-center"
                },
                {
                    "data": "kondisi_barang",
                    "className": "text-center"
                },
                {
                    "data": "disewakan",
                    "className": "text-center"
                },
                {
                    "data": null,
                    "className": "text-center",
                    "orderable": false,
                    "render": function(data, type, row) {
                        var checkbox = '<input type="checkbox" class="checkbox-item" data-id="' + row.id + '">';
                        return checkbox;
                    }
                },
                {
                    "data": null,
                    "className": "text-center",
                    "orderable": false,
                    "render": function(data, type, row) {
                        var editButton = '<button type="button" class="btn btn-info btn-xs edit-btn" style="vertical-align: middle;" onclick="openEditModal(' + row.id + ')">Edit</button>';
                        return editButton;
                    }
                }
            ]
        });

        // Checkbox item
        $('.checkbox-item').change(function() {
            if (!$(this).prop('checked')) {
                $('#select-all-checkbox').prop('checked', false);
            }
        });
    });
</script>



<?php echo view('tema/footer.php'); ?>