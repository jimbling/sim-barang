<?php echo view('tema/header.php'); ?>

<div class="content-wrapper">
    <div class="flash-data" data-flashdata="<?= (session()->getFlashData('pesanAddBarangSatuan')); ?>"></div>
    <div class="content-header">
        <div class="container-fluid">
            <!-- <div class="alert alert-info" style="font-size: 13px;" role="alert">
                Pada halaman ini, menampilkan seluruh data barang dengan jumlah satuan, beserta dengan kode untuk masing-masing barang.
                <p><strong>Setiap barang, memiliki kode/no inventaris yang unik, meskipun nama barangnya sama.</strong>
                <p>Untuk menambahkan barang dalam jumlah banyak, disarankan menggunakan fasilitas Import Data
            </div> -->
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4 class="m-0">Input Master Barang Persedian</h4>
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
                <div class="col-md-12 col-12">
                    <div class="card card-primary card-outline shadow-lg">

                        <div class="card-header">
                            <div class="btn-toolbar justify-content-between" role="toolbar" aria-label="Toolbar with button groups">
                                <div class="btn-group" role="group" aria-label="First group">
                                    <button type="button" class="btn btn-warning btn-sm float-right" data-toggle="modal" data-target="#importBarangPersediaanModal">
                                        <i class='fas fa-upload spaced-icon'></i>Import</a>
                                    </button>
                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalTambahBarangSatuan">
                                        <i class='fas fa-plus spaced-icon'></i> Tambah Barang
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
                            <table id="masterBarangPersediaan" class="table table-striped table-responsive">
                                <thead class="thead-grey" style="font-size: 13px;">
                                    <tr>
                                        <th width='3%' style="text-align: center; vertical-align: middle; font-size: 13px;">No</th>
                                        <th style="text-align: center; vertical-align: middle; font-size: 13px;">Prodi/Jursan</th>
                                        <th style="text-align: center; vertical-align: middle; font-size: 13px;">Kelompok Barang</th>
                                        <th style="text-align: center; vertical-align: middle; font-size: 13px;">Kode Barang</th>
                                        <th style="text-align: center; vertical-align: middle; font-size: 13px;">Nama Barang</th>
                                        <th style="text-align: center; vertical-align: middle; font-size: 13px;">Satuan</th>
                                        <th width='10%' style="text-align: center; vertical-align: middle;">

                                            <input type="checkbox" id="select-all-checkbox">
                                        </th> <!-- Checkbox master -->

                                    </tr>
                                </thead>
                                <div id="alertContainer" class="mt-3"></div>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($data_barang_persediaan as $brgPersediaan) : ?>
                                        <tr class="searchable-row">
                                            <th class="text-center" scope="row" style="vertical-align: middle; font-size: 13px;"><?= $i++; ?></th>
                                            <td style="text-align: center; vertical-align: middle; font-size: 13px;"><?= $brgPersediaan['prodi']; ?></td>
                                            <td style="text-align: center; vertical-align: middle; font-size: 13px;"><?= $brgPersediaan['kelompok_barang']; ?></td>
                                            <td style="text-align: center; vertical-align: middle; font-size: 13px;"><?= $brgPersediaan['kode_barang']; ?></td>
                                            <td style="text-align: center; vertical-align: middle; font-size: 13px;"><?= $brgPersediaan['nama_barang']; ?></td>
                                            <td width='10%' style="text-align: center; vertical-align: middle; font-size: 13px;"><?= $brgPersediaan['satuan']; ?></td>
                                            <td style="text-align: center;">
                                                <input type="checkbox" class="checkbox-item" data-id="<?= $brgPersediaan['id']; ?>">
                                            </td>

                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
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
<div class="modal fade" id="importBarangPersediaanModal" tabindex="-1" aria-labelledby="importBarangPersediaanModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="importBarangPersediaanModal">Import Data Barang</h5>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <form action="/barang/persediaan/importData" method="post" enctype="multipart/form-data" id="uploadForm">
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="excel_file_persediaan" aria-describedby="excel_file_persediaan" name="excel_file_persediaan">
                                <label class="custom-file-label" for="excel_file_persediaan">Pilih file Excel</label>
                            </div>
                        </div>
                        <span id="excel_file_persediaan"></span>
                        <!-- Tambahkan elemen ini untuk menampilkan nama file -->
                        <span id="file_name_display"></span>
                    </form>

                    <div class="alert alert-info mt-3" role="alert">
                        <p><strong>Informasi</strong></p>
                        <p>Gunakan hanya file ber ekstensi <strong>.xls</strong> atau <strong>.xlsx </strong>. Kosongkan bari pertama pada tabel Excel</p>
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

<!-- Modal Tambah Barang Satuan -->
<div class="modal fade" id="modalTambahBarangSatuan" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Tambah Barang Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/barang/persediaan/tambah" method="post">
                    <input type="hidden" name="<?= csrf_token() ?>" value="<?= $csrfToken ?>">
                    <div class="form-group">
                        <label for="prodi">Prodi/Jursan</label>
                        <select class="form-control" id="prodi" name="prodi">
                            <option>Pilih Prodi/Jurusan ... </option>
                            <option value="AKPER YKY Yogyakarta">Akper YKY Yogyakarta</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="prodi">Kelompok Barang</label>
                        <select class="form-control" id="kelompok_barang" name="kelompok_barang">
                            <option>Pilih Kelompok Barang ... </option>
                            <option value="Barang Habis Pakai Lab">Barang Habis Pakai Lab</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="inputAddress">Nama Barang:</label>
                        <input type="text" class="form-control" id="nama_barang" name="nama_barang" placeholder="Masukkan nama barang" required>
                    </div>
                    <div class="form-group">
                        <label for="satuan" class="col-12 col-form-label">Satuan Barang</label>
                        <select class="form-control" id="satuan" name="satuan" required>
                            <option value="">Pilih satuan ... </option>
                            <?php foreach ($data_satuan as $satuan) : ?>
                                <option value="<?= $satuan['nama_satuan'] ?>"><?= $satuan['nama_satuan'] ?></option>
                            <?php endforeach; ?>
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
    </div>
</div>
<!-- AKhir -->



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
                        url: '/barang/persediaan/hapus', // Update with your actual controller and method
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
                                window.location.replace("/barang/persediaan/master");
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
        const fileInput = document.getElementById("excel_file_persediaan");
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
                    formData.append("excel_file_persediaan", fileInput.files[0]);
                    // Set teks pada elemen dengan ID "file_name_display"

                    const fileNameDisplay = document.getElementById("excel_file_persediaan");
                    fileNameDisplay.textContent = `File terpilih: ${fileInput.files[0].name}`;

                    fetch("/barang/persediaan/importData", {
                            method: "POST",
                            body: formData,
                        })
                        .then(response => response.json())
                        .then(data => {

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


<script>
    $(document).ready(function() {
        // Inisialisasi Select2 ketika modal ditampilkan
        $('#myModal').on('shown.bs.modal', function() {
            $('#pembelajaran').select2({
                // Konfigurasi Select2
            });
        });
    });
</script>

<?php echo view('tema/footer.php'); ?>