<?php echo view('tema/header.php'); ?>
<div class="content-wrapper">
    <div class="container-fluid">
        <div class="flash-data" data-flashdata="<?= (session()->getFlashData('pesanAkun')); ?>"></div><!-- Page Heading -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h5>Data Pengguna</h5>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                            <li class="breadcrumb-item active">Data Pengguna</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow mb-4">

                    <div class="card-body">



                        <div class="table-responsive">

                            <table class="table table-sm table-striped text-gray-900" id="penggunaTabel" width="100%" cellspacing="0">

                                <thead class="text-gray-900">
                                    <tr>
                                        <th>Nama Pengguna</th>
                                        <th>Username</th>
                                        <th>Level</th>
                                        <th>Type</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($data_pengguna !== null) : ?>
                                        <tr>
                                            <td><?= $data_pengguna['full_nama']; ?></td>
                                            <td><?= $data_pengguna['user_nama']; ?></td>
                                            <td><?= $data_pengguna['level']; ?></td>
                                            <td><?= $data_pengguna['type']; ?></td>

                                            <td>
                                                <button class="btn btn-xs btn-primary text-white edit-button" data-toggle="modal" data-target="#editModal" data-id="<?= $data_pengguna['id']; ?>"><i class="fas fa-edit"></i> Ubah Password</button>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>




                </div>


            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Pengguna</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editForm">
                    <div class="form-group">
                        <label for="editNama">Nama Pengguna</label>
                        <input type="text" class="form-control" id="editNama" name="full_nama" readonly>
                    </div>
                    <div class="form-group">
                        <label for="editUserNama">Username</label>
                        <input type="text" class="form-control" id="editUserNama" name="user_nama" readonly>
                    </div>
                    <div class="form-group">
                        <label for="editUserPass">Password</label>
                        <input type="password" class="form-control" id="editUserPass" name="user_password">
                        <small id="passwordHelp" class="form-text">
                            Password harus memiliki panjang minimal 8 karakter dan mengandung setidaknya satu huruf besar, satu huruf kecil, satu angka, dan satu karakter khusus.
                            <p><b>contoh: P@ssw0rd </b>
                        </small>
                    </div>
                    <!-- Hidden field untuk menyimpan ID -->
                    <input type="hidden" id="editId" name="id">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="simpan_editAkun()">Simpan</button>
            </div>
        </div>
    </div>
</div>


<?php echo view('tema/footer.php'); ?>

<script>
    $(document).ready(function() {
        // Tangkap klik pada tombol edit
        $('.edit-button').on('click', function() {
            // Ambil id pengguna dari atribut data-id
            var userId = $(this).data('id');

            // Kirim permintaan AJAX untuk mendapatkan data pengguna berdasarkan id
            $.ajax({
                type: 'GET',
                url: '/get-user-by-id/' + userId, // Ganti dengan URL yang sesuai
                success: function(response) {
                    // Isi nilai input dalam form modal dengan data pengguna yang diperoleh
                    fillEditModal(response);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    alert('Terjadi kesalahan saat mengambil data pengguna.');
                }
            });
        });
    });

    // Fungsi untuk mengisi nilai pada form modal
    function fillEditModal(userData) {
        // Parse JSON ke objek JavaScript
        var user = JSON.parse(userData);

        // Isi nilai pada form modal berdasarkan data pengguna
        $('#editNama').val(user.full_nama);
        $('#editUserNama').val(user.user_nama);
        $('#editUserPass').val(user.user_password);
        // Isi nilai untuk input lainnya sesuai kebutuhan

        // Set nilai ID pengguna pada hidden input
        $('#editId').val(user.id);
    }

    function showLoadingProses() {
        let timerInterval
        Swal.fire({
            title: 'Sedang memproses data ....',
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

    function simpan_editAkun() {
        // Ambil data dari form modal
        var formData = $('#editForm').serialize();
        var password = $('#editUserPass').val();

        // Validasi password
        if (password && password.length < 8) {
            toastr.error('Password harus memiliki panjang minimal 8 karakter.');
            return;
        }

        if (password && !/[A-Z]/.test(password)) {
            toastr.error('Password harus mengandung setidaknya satu huruf besar (uppercase letter).');
            return;
        }

        if (password && !/[a-z]/.test(password)) {
            toastr.error('Password harus mengandung setidaknya satu huruf kecil (lowercase letter).');
            return;
        }

        if (password && !/\d/.test(password)) {
            toastr.error('Password harus mengandung setidaknya satu angka (digit).');
            return;
        }

        if (password && !/[^A-Za-z0-9]/.test(password)) {
            toastr.error('Password harus mengandung setidaknya satu karakter khusus (special character).');
            return;
        }

        // Kirim permintaan AJAX untuk menyimpan data update
        $.ajax({
            type: 'POST',
            url: '/update-user', // Ganti dengan URL yang sesuai dengan controller dan method yang baru Anda buat
            data: formData,
            success: function(response) {
                // Handle respon dari server
                if (response.status === 'success') {
                    // Jika berhasil, tampilkan SweetAlert2 berhasil
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Perubahan berhasil disimpan.',
                        showConfirmButton: false,
                        timer: 2000 // Menutup alert setelah 2 detik
                    }).then(function() {
                        // Me-redirect ke halaman logout
                        window.location.href = '/auth/keluar';
                    });
                } else {
                    // Jika gagal, tampilkan pesan kesalahan menggunakan ToastR
                    toastr.error('Gagal menyimpan perubahan.');
                }
            },
            error: function(xhr, status, error) {
                // Handle kesalahan AJAX
                console.error(xhr.responseText);
                alert('Terjadi kesalahan saat menyimpan perubahan.');
            }
        });
    }
</script>