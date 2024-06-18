
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("form-mahasiswa").addEventListener("submit", function(event) {
            event.preventDefault();

            var nim = document.getElementById("nim").value.trim();
            var nama_lengkap = document.getElementById("nama_lengkap").value.trim();


            if (nim === "") {
                toastr.error("NIM harus diisi");
            } else if (!(/^\d+$/.test(nim))) {
                toastr.error("NIM harus berisi angka");
            }


            if (nama_lengkap === "") {
                toastr.error("Nama Lengkap harus diisi");
            }


            if (nim !== "" && /^\d+$/.test(nim) && nama_lengkap !== "") {
                this.submit();
            }
        });
    });

    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("formEditMhs").addEventListener("submit", function(event) {
            event.preventDefault();

            var nim_edit = document.getElementById("nim_edit").value.trim();
            var nama_lengkap_edit = document.getElementById("nama_lengkap_edit").value.trim();


            if (nim_edit === "") {
                toastr.error("NIM harus diisi");
            } else if (!(/^\d+$/.test(nim_edit))) {
                toastr.error("NIM harus berisi angka");
            }


            if (nama_lengkap_edit === "") {
                toastr.error("Nama Lengkap harus diisi");
            }


            if (nim_edit !== "" && /^\d+$/.test(nim_edit) && nama_lengkap_edit !== "") {
                this.submit();
            }
        });
    });

    function openEditModal(id) {

        document.getElementById('edit_id').value = id;


        document.getElementById('formEditMhs').action = "/data/mahasiswa/update/" + id;

        $.ajax({
            url: '/mahasiswa/get_detail/' + id,
            method: 'GET',
            success: function(data) {
                console.log(data);
                $('#editMhs').modal('show');
                populateEditModal(data);


                $('#editId').val(id);
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    }

    function populateEditModal(data) {

        $('#nim_edit').val(data.nim);
        $('#nama_lengkap_edit').val(data.nama_lengkap);

    }

    document.getElementById('select-all-checkbox').addEventListener('change', function() {
        var checkboxes = document.querySelectorAll('.checkbox-item');
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = document.getElementById('select-all-checkbox').checked;
        });
    });




    function deleteSelectedItems() {
        var selectedIds = [];


        $('.checkbox-item:checked').each(function() {
            selectedIds.push($(this).data('id'));
        });


        if (selectedIds.length > 0) {

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
                    showLoading();
                    $.ajax({
                        url: '/mahasiswa/hapus',
                        method: 'POST',
                        data: {
                            ids: selectedIds
                        },
                        success: function(response) {
                            hideLoading();

                            Swal.fire({
                                title: 'Berhasil!',
                                text: 'Data berhasil dihapus.',
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false,
                            }).then(() => {

                                window.location.replace("/data/mahasiswa");
                            });
                        },
                        error: function(error) {
                            hideLoading();

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
        const processText = document.getElementById("processText");
        const fileNameDisplay = document.getElementById("file_name_display");

        fileInput.addEventListener("change", function() {
            if (fileInput.files.length > 0) {

                fileNameDisplay.textContent = `File terpilih: ${fileInput.files[0].name}`;
            } else {

                fileNameDisplay.textContent = "";
            }
        });

        importButton.addEventListener("click", function() {
            if (fileInput.files.length > 0) {
                const allowedFileTypes = ["application/vnd.ms-excel", "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"];
                const selectedFileType = fileInput.files[0].type;

                if (allowedFileTypes.includes(selectedFileType)) {

                    loading.style.display = "inline-block";
                    processText.style.display = "inline-block";

                    const formData = new FormData();
                    formData.append("excel_file", fileInput.files[0]);


                    const fileNameDisplay = document.getElementById("excel_file");
                    fileNameDisplay.textContent = `File terpilih: ${fileInput.files[0].name}`;

                    fetch("/mahasiswa/importData", {
                            method: "POST",
                            body: formData,
                        })
                        .then(response => response.json())
                        .then(data => {
                            console.log(data);
                            loading.style.display = "none";
                            processText.style.display = "none";

                            if (data.status === "success") {
                                Swal.fire({
                                    icon: "success",
                                    title: "File Berhasil Diimpor!",
                                    text: data.message,
                                    timer: 5000,
                                    showConfirmButton: false,
                                }).then(() => {

                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: "error",
                                    title: "Gagal Impor File!",
                                    text: data.message,
                                    timer: 5000,
                                    showConfirmButton: false,
                                });
                            }
                        })
                        .catch(error => {
                            loading.style.display = "none";
                            processText.style.display = "none";
                            console.error(error);


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


        $('.checkbox-item:checked').each(function() {
            selectedIds.push($(this).data('id'));
        });


        if (selectedIds.length > 0) {

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
                    showLoading();

                    $.ajax({
                        url: '/data/mahasiswa/akun',
                        method: 'POST',
                        data: {
                            selected_ids: selectedIds
                        },

                        success: function(response) {
                            if (response.success) {

                                hideLoading();


                                setTimeout(function() {

                                    Swal.fire({
                                        title: 'Berhasil!',
                                        text: 'Akun login berhasil dibuat.',
                                        icon: 'success',
                                        timer: 2000,
                                        showConfirmButton: false,
                                    }).then(() => {

                                        window.location.replace("/data/pengguna");
                                    });
                                }, 500);
                            } else {

                                hideLoading();

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
              "url": `${baseUrl}mahasiswa/fetchData`,
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
                    "orderable": false
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
