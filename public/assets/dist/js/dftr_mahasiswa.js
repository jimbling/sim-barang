
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("form-mahasiswa").addEventListener("submit", function(event) {
            event.preventDefault(); // Mencegah formulir dikirim secara langsung

            var nim = document.getElementById("nim").value.trim();
            var nama_lengkap = document.getElementById("nama_lengkap").value.trim();

            // Validasi NIM harus diisi dan berisi hanya angka
            if (nim === "") {
                toastr.error("NIM harus diisi");
            } else if (!(/^\d+$/.test(nim))) {
                toastr.error("NIM harus berisi angka");
            }

            // Validasi Nama Lengkap harus diisi
            if (nama_lengkap === "") {
                toastr.error("Nama Lengkap harus diisi");
            }

            // Kirim formulir jika semua validasi terpenuhi
            if (nim !== "" && /^\d+$/.test(nim) && nama_lengkap !== "") {
                this.submit(); // Kirim formulir jika valid
            }
        });
    });



    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("formEditMhs").addEventListener("submit", function(event) {
            event.preventDefault(); // Mencegah formulir dikirim secara langsung

            var nim_edit = document.getElementById("nim_edit").value.trim();
            var nama_lengkap_edit = document.getElementById("nama_lengkap_edit").value.trim();

            // Validasi NIM harus diisi dan berisi hanya angka
            if (nim_edit === "") {
                toastr.error("NIM harus diisi");
            } else if (!(/^\d+$/.test(nim_edit))) {
                toastr.error("NIM harus berisi angka");
            }

            // Validasi Nama Lengkap harus diisi
            if (nama_lengkap_edit === "") {
                toastr.error("Nama Lengkap harus diisi");
            }

            // Kirim formulir jika semua validasi terpenuhi
            if (nim_edit !== "" && /^\d+$/.test(nim_edit) && nama_lengkap_edit !== "") {
                this.submit(); // Kirim formulir jika valid
            }
        });
    });




    function openEditModal(id) {
        // Set nilai input hidden dengan ID yang diambil dari tombol edit
        document.getElementById('edit_id').value = id;

        // Perbarui aksi formulir sesuai dengan ID
        document.getElementById('formEditMhs').action = "/data/mahasiswa/update/" + id;
        // Fetch data using AJAX
        $.ajax({
            url: '/mahasiswa/get_detail/' + id,
            method: 'GET',
            success: function(data) {
                console.log(data); // Periksa data yang diterima di konsol browser
                // Populate the modal with the fetched data
                $('#editMhs').modal('show');
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
        $('#nim_edit').val(data.nim);
        $('#nama_lengkap_edit').val(data.nama_lengkap);

    }





    // JavaScript untuk mengontrol checkbox master
    document.getElementById('select-all-checkbox').addEventListener('change', function() {
        var checkboxes = document.querySelectorAll('.checkbox-item');
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = document.getElementById('select-all-checkbox').checked;
        });
    });




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
                        url: '/mahasiswa/hapus', // Update with your actual controller and method
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
                                window.location.replace("/data/mahasiswa");
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

                    fetch("/mahasiswa/importData", {
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
                        url: '/data/mahasiswa/akun', // Update with your actual controller and method
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
                text: 'Pilih setidaknya satu data mahasiswa untuk dibuatkan akun login.'
            });
        }
    }



    $(document).ready(function() {
        $('#dataMhsTable').DataTable({
            "ajax": {
                "url": "<?php echo base_url('mahasiswa/fetchData'); ?>",
                "type": "POST"
            },
            "columns": [{
                    "data": "id"
                },
                {
                    "data": "nim"
                },
                {
                    "data": "nama_lengkap"
                },
                {
                    "data": null,
                    "render": function(data, type, row) {
                        return '<input type="checkbox" class="checkbox-item" data-id="' + row.id + '">';
                    },
                    "className": "text-center"
                },
                {
                    "data": null,
                    "render": function(data, type, row) {
                        return '<button type="button" class="btn btn-info btn-xs edit-btn" data-toggle="tooltip" data-placement="left" title="Edit" onclick="openEditModal(' + row.id + ')"><i class="fas fa-edit"></i></button>';
                    },
                    "className": "text-center",
                    "orderable": false // Non-sortable column
                }
            ],
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": false,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "processing": true,

        });

    });
