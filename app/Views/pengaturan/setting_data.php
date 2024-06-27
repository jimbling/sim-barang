<?php echo view('tema/header.php'); ?>

<div class="content-wrapper">
    <div class="container-fluid">
        <div class="flash-data" data-flashdata="<?= (session()->getFlashData('pesanAkun')); ?>"></div><!-- Page Heading -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h5>Data Kampus</h5>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                            <li class="breadcrumb-item active">Data Kampus</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 border-left-primary">
                        <h6 class="m-0 font-weight-bold text-primary">Atur Data Kampus</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <button type="button" class="btn btn-warning btn-icon-split btn-sm float-right" class="btn btn-secondary btn-icon-split btn-sm" id="editButton">
                                    <span class="icon text-white-100">
                                        <i class="fas fa-edit"></i>
                                    </span>
                                    <span class="text">Edit Data</span>
                                </button>
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-success btn-icon-split btn-sm" class="btn btn-secondary btn-icon-split btn-sm" id="updateButton">
                                    <span class="icon text-white-100">
                                        <i class="fas fa-sync-alt"></i>
                                    </span>
                                    <span class="text">Update Data</span>
                                </button>
                            </div>

                            <div class="col">
                                <button type="button" class="btn btn-danger btn-icon-split btn-sm" class="btn btn-secondary btn-icon-split btn-sm" id="batalButton">
                                    <span class="icon text-white-100">
                                        <i class="fas fa-times-circle"></i>
                                    </span>
                                    <span class="text">Batal</span>
                                </button>
                            </div>
                        </div>

                    </div>
                    <div class="container">


                        <table class="table table-hover tabel-cetak table-borderless table-sm">

                            <tbody>
                                <tr>
                                    <td style="text-align: left;">1. Nama Kampus </td>
                                    <td>:</td>
                                    <td><input type="text" class="form-control form-control-sm" id="nama_kampus" name="nama_kampus" value="<?php echo htmlspecialchars($dataCetak['nama_kampus'], ENT_QUOTES, 'UTF-8'); ?>" readonly></td>
                                </tr>
                                <tr>

                                    <td style="text-align: left;">2. Website </td>
                                    <td>:</td>
                                    <td><input type="text" class="form-control form-control-sm" id="website" name="website" value="<?php echo $dataCetak['website']; ?>" readonly></td>
                                </tr>
                                <tr>

                                    <td style="text-align: left;">3. Alamat</td>
                                    <td>:</td>
                                    <td> <input type="text" class="form-control form-control-sm" id="alamat" name="alamat" value="<?php echo $dataCetak['alamat']; ?>" readonly></textarea></td>
                                </tr>
                                <tr>
                                    <td style="text-align: left;">4. No. Telp </td>
                                    <td>:</td>
                                    <td><input type="text" class="form-control form-control-sm" id="no_telp" name="no_telp" value="<?php echo $dataCetak['no_telp']; ?>" readonly></td>
                                </tr>
                                <tr>

                                    <td style="text-align: left;">5. Email </td>
                                    <td>:</td>
                                    <td><input type="email" class="form-control form-control-sm" id="email" name="email" value="<?php echo $dataCetak['email']; ?>" readonly></td>
                                </tr>
                                <tr>

                                    <td style="text-align: left;">6. Nama Bank</td>
                                    <td>:</td>
                                    <td> <input type="text" class="form-control form-control-sm" id="nama_bank" name="nama_bank" value="<?php echo $dataCetak['nama_bank']; ?>" readonly></textarea></td>
                                </tr>
                                <tr>
                                    <td style="text-align: left;">7. No. Rekening </td>
                                    <td>:</td>
                                    <td><input type="text" class="form-control form-control-sm" id="no_rekening" name="no_rekening" value="<?php echo $dataCetak['no_rekening']; ?>" readonly></td>
                                </tr>
                                <tr>
                                    <td style="text-align: left;">8. Atas Nama </td>
                                    <td>:</td>
                                    <td><input type="email" class="form-control form-control-sm" id="atas_nama" name="atas_nama" value="<?php echo $dataCetak['atas_nama']; ?>" readonly></td>
                                </tr>
                                <tr>
                                    <td style="text-align: left;">9. No. HP Admin </td>
                                    <td>:</td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm" id="no_hp" name="no_hp" value="<?php echo $dataCetak['no_hp']; ?>" readonly>
                                        <span class="small float-left" style="color: #EE4266;">Untuk menerima notifikasi WA saat ada Reservasi Baru</span>
                                    </td>

                                </tr>
                                <tr>
                                    <td style="text-align: left;">10. Kode Reservasi </td>
                                    <td>:</td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm" id="nilai_kode_reservasi" name="nilai_kode_reservasi" value="<?php echo $dataCetak['nilai_kode_reservasi']; ?>" readonly>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: left;">11. Kode Pinjam </td>
                                    <td>:</td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm" id="nilai_kode_pinjam" name="nilai_kode_pinjam" value="<?php echo $dataCetak['nilai_kode_pinjam']; ?>" readonly>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: left;">12. Kode Kembali </td>
                                    <td>:</td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm" id="nilai_kode_kembali" name="nilai_kode_kembali" value="<?php echo $dataCetak['nilai_kode_kembali']; ?>" readonly>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: left;">13. Logo Bank </td>
                                    <td>:</td>
                                    <td>
                                        <form method="post" action="/upload/logobank" enctype="multipart/form-data">

                                            <div class="form-group row">
                                                <div class="col-sm-12">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" name="logo_bank" id="customBank" required>
                                                        <label class="custom-file-label" for="selectedFileBank" id="selectedFileBank">Pilih Logo Bank</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="container-fluid mb-3">
                                                <img id="previewBank" src="#" alt="Preview Logo Bank" style="max-width: 100%; max-height: 200px; display: none;">
                                            </div>
                                            <button type="submit" class="btn btn-sm btn-outline-primary btn-block">Simpan Logo Bank</button>
                                        </form>
                                        <img src="../../assets/dist/img/<?php echo $dataCetak['logo_bank']; ?>" class="img-fluid rounded float-right" alt="Tampilan Logo Bank" width="200" height="100">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: left;">14. Favicon <img src="../../assets/dist/img/ilustrasi/<?php echo $dataCetak['favicon']; ?>" class="img-fluid rounded float-right" alt="Tampilan Favicon" width="30" height="30"></td>
                                    <td>:</td>
                                    <td>
                                        <form method="post" action="/upload/favicon" enctype="multipart/form-data">

                                            <div class="form-group row">
                                                <div class="col-sm-12">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" name="favicon" id="customFavicon" required>
                                                        <label class="custom-file-label" for="selectedFileFavicon" id="selectedFileFavicon">Pilih Favicon</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="container-fluid mb-3">
                                                <img id="previewFavicon" src="#" alt="Preview Favicon" style="max-width: 100%; max-height: 200px; display: none;">
                                            </div>
                                            <button type="submit" class="btn btn-sm btn-outline-primary btn-block">Simpan Favicon</button>
                                        </form>
                                    </td>
                                </tr>



                            </tbody>
                        </table>
                    </div>
                </div>



                <div class="col">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 border-left-primary">
                                    <h6 class="m-0 font-weight-bold text-primary">Atur Logo</h6>
                                </div>
                                <div class="card-body">
                                    <form method="post" action="/upload/logo" enctype="multipart/form-data">

                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" name="logo" id="customLogo" required>
                                                    <label class="custom-file-label" for="selectedFileLogo" id="selectedFileLogo">Pilih Logo</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="container-fluid mb-3">
                                            <img id="previewLogo" src="#" alt="Preview Logo" style="max-width: 100%; max-height: 200px; display: none;">
                                        </div>
                                        <button type="submit" class="btn btn-sm btn-outline-primary btn-block">Simpan Logo</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="card shadow mb-4">
                                <div class="card-body">
                                    <div class="container">
                                        <div class="col-sm-12">
                                            <img src="../../assets/dist/img/<?php echo $dataCetak['logo']; ?>" class="img-fluid rounded align-center" alt="Tampilan Logo">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">

                    <div class="card shadow">
                        <div class="card-body bg-success">
                            <dl class="row" style="font-size: 13px;">
                                <dt class="col-sm-3">Atur Data Kampus</dt>
                                <dd class="col-sm-9">Silahkan disesuaikan dengan keadaan Kampus/Instansi masing-masing, data-data tersebut akan menjadi identitas tepat pada sistem dan juga pada laporan.</dd>

                                <dt class="col-sm-3">Setting Tanda Tangan</dt>
                                <dd class="col-sm-9">
                                    Silahkan disesuaikan sesuai keadaan sebenarnya siapa saja yang bertanggung jawab/berkompeten terhadap laporan Peminjaman, Persediaan dan Penggunaan Barang.
                                </dd>
                                <dt class="col-sm-3">Setting Akun</dt>
                                <dd class="col-sm-9">
                                    Harap digunakan dengan hati-hati karena terkait akses login sebagai Administrator. Sebaiknya kata sandi default diubah, namun jangan sampai lupa.
                                </dd>
                            </dl>
                        </div>
                    </div>

                </div>

            </div>



            <div class="col-lg-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 border-left-primary">
                        <h6 class="m-0 font-weight-bold text-primary">Setting Tanda Tangan</h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover tabel-cetak table-borderless table-sm font">

                            <tbody>
                                <tr>

                                    <td style="text-align: left;">1. <?php echo $dataCetak['ttd_1']; ?> </td>
                                    <td>:</td>
                                    <td><input type="text" class="form-control form-control-sm" id="ttd_1" name="ttd_1" value="<?php echo $dataCetak['ttd_1']; ?>" readonly></td>
                                </tr>
                                <tr>

                                    <td style="text-align: left;">2. Nama </td>
                                    <td>:</td>
                                    <td><input type="text" class="form-control form-control-sm" id="nama_direktur" name="nama_direktur" value="<?php echo $dataCetak['nama_direktur']; ?>" readonly></td>
                                </tr>
                                <tr>

                                    <td style="text-align: left;">3. NIK </td>
                                    <td>:</td>
                                    <td><input type="text" class="form-control form-control-sm" id="nik_dir" name="nik_dir" value="<?php echo $dataCetak['nik_dir']; ?>" readonly></td>
                                </tr>
                                <tr>

                                    <td style="text-align: left;">4. <?php echo $dataCetak['ttd_4']; ?> </td>
                                    <td>:</td>
                                    <td><input type="text" class="form-control form-control-sm" id="ttd_4" name="ttd_4" value="<?php echo $dataCetak['ttd_4']; ?>" readonly></td>
                                </tr>
                                <tr>
                                    <td style="text-align: left;">5. Nama </td>
                                    <td>:</td>
                                    <td><input type="text" class="form-control form-control-sm" id="nama_ttd_4" name="nama_ttd_4" value="<?php echo $dataCetak['nama_ttd_4']; ?>" readonly></td>
                                </tr>
                                <tr>

                                    <td style="text-align: left;">6. NIK </td>
                                    <td>:</td>
                                    <td><input type="text" class="form-control form-control-sm" id="id_ttd_4" name="id_ttd_4" value="<?php echo $dataCetak['id_ttd_4']; ?>" readonly></td>
                                </tr>
                                <tr>
                                    <td style="text-align: left;">7. <?php echo $dataCetak['ttd_3']; ?></td>
                                    <td>:</td>
                                    <td><input type="text" class="form-control form-control-sm" id="ttd_3" name="ttd_3" value="<?php echo $dataCetak['ttd_3']; ?>" readonly></td>
                                </tr>
                                <tr>

                                    <td style="text-align: left;">8. Nama </td>
                                    <td>:</td>
                                    <td><input type="text" class="form-control form-control-sm" id="nama_ttd_3" name="nama_ttd_3" value="<?php echo $dataCetak['nama_ttd_3']; ?>" readonly></td>
                                </tr>
                                <tr>

                                    <td style="text-align: left;">9. NIK </td>
                                    <td>:</td>
                                    <td><input type="text" class="form-control form-control-sm" id="id_ttd_3" name="id_ttd_3" value="<?php echo $dataCetak['id_ttd_3']; ?>" readonly></td>
                                </tr>
                                <tr>
                                    <td style="text-align: left;">10. <?php echo $dataCetak['ttd_2']; ?></td>
                                    <td>:</td>
                                    <td><input type="text" class="form-control form-control-sm" id="ttd_2" name="ttd_2" value="<?php echo $dataCetak['ttd_2']; ?>" readonly></td>
                                </tr>
                                <tr>

                                    <td style="text-align: left;">11. Nama </td>
                                    <td>:</td>
                                    <td><input type="text" class="form-control form-control-sm" id="nama_laboran" name="nama_laboran" value="<?php echo $dataCetak['nama_laboran']; ?>" readonly></td>
                                </tr>
                                <tr>

                                    <td style="text-align: left;">12. NIK </td>
                                    <td>:</td>
                                    <td><input type="text" class="form-control form-control-sm" id="nik_laboran" name="nik_laboran" value="<?php echo $dataCetak['nik_laboran']; ?>" readonly></td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>


                <div class="col">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 border-left-primary">
                            <h6 class="m-0 font-weight-bold text-primary">Atur Kop Surat</h6>
                        </div>
                        <div class="card-body">
                            <form method="post" action="/upload/kopsurat" enctype="multipart/form-data">

                                <div class="form-group row">
                                    <label for="foto_siswa" class="col-sm-6 col-form-label">Upload file Kop Surat</label>
                                    <div class="col-sm-12">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="kop_surat" id="customFile" required>
                                            <label class="custom-file-label" for="selectedFileName" id="selectedFileName">Pilih File Foto</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="container-fluid mb-3">
                                    <img id="previewImage" src="#" alt="Preview Image" style="max-width: 100%; max-height: 200px; display: none;">
                                </div>
                                <button type="submit" class="btn btn-outline-primary btn-block">Simpan Kop Surat</button>
                            </form>
                        </div>
                    </div>

                    <div class="card shadow mb-4">
                        <div class="card-header py-3 border-left-primary">
                            <h6 class="m-0 font-weight-bold text-primary">Tampilan Kop Surat</h6>
                        </div>
                        <div class="card-body">
                            <div class="container">
                                <div class="col-sm-12">
                                    <img src="../../assets/dist/img/<?php echo $dataCetak['kop_surat']; ?>" class="img-fluid rounded align-center" alt="Tampilan Kop Surat">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="col">
                    <div class="card text-center mt-1">
                        <div class="card-header bg-primary">
                            Setting Akun
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm table-striped text-gray-900" id="penggunaTabel" width="100%" cellspacing="0">
                                    <thead class="text-gray-900 thead-dark">
                                        <tr>
                                            <th>Nama Pengguna</th>
                                            <th>Username</th>
                                            <th>Level</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php foreach ($data_pengguna as $akun) : ?>
                                            <tr>
                                                <td class="text-left"><?= $akun['full_nama']; ?></td>
                                                <td><?= $akun['user_nama']; ?></td>
                                                <td><?= $akun['level']; ?></td>
                                                <td>
                                                    <a href="javascript:void(0);" class="btn btn-xs btn-primary mx-auto text-white" id="edit-button-<?= $akun['id']; ?>" data-toggle="modal" data-target="#editModal<?= $akun['id']; ?>" data-id="<?= $akun['id']; ?>"><i class="fas fa-edit"></i> Edit</a>

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

</div>

<?php foreach ($data_pengguna as $akun) : ?>
    <div class="modal fade" id="editModal<?= $akun['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel<?= $akun['id']; ?>" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel<?= $akun['id']; ?>">Edit Akun</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editAkun" method="post" action="/data/admin/update">
                        <div class="form-group row">
                            <label for="editNama" class="col-sm-4 col-form-label">Nama</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="editNama" name="fullName" value="<?= $akun['full_nama']; ?>" readonly> <!-- Menggunakan alias fullName -->
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="editUserNama" class="col-sm-4 col-form-label">Username</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="editUserNama" name="username" value="<?= $akun['user_nama']; ?>"> <!-- Menggunakan alias username -->
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="editUserNama" class="col-sm-4 col-form-label">Email</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="editUserEmail" name="userEmail" value="<?= $akun['email']; ?>"> <!-- Menggunakan alias username -->
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="editUserPass" class="col-sm-4 col-form-label">Password</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="editUserPass" name="password"> <!-- Menggunakan alias password -->
                            </div>
                        </div>
                        <input type="hidden" id="akunId" name="id" value="<?= $akun['id']; ?>">
                        <button type="submit" class="btn btn-primary btn-sm" onclick="simpan_editAkun()">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<script>
    var updateUrl = "<?php echo base_url('/pengaturan/update'); ?>";
    const baseUrl = "<?= base_url() ?>/";
</script>

<script src="<?= base_url('assets/dist/js/jquery-3.6.4.min.js') ?>"> </script>
<script src=" <?= base_url('assets/dist/js/frontend-js/settingData.js') ?>"></script>

<?php echo view('tema/footer.php'); ?>

<script>
    function showLoading() {
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
        var id = document.getElementById('akunId').value;
        var fullName = document.getElementById('editNama').value;
        var username = document.getElementById('editUserNama').value;
        var userEmail = document.getElementById('editUserEmail').value;
        var password = document.getElementById('editUserPass').value;
        showLoading();

        var data = {
            id: id,
            fullName: fullName,
            username: username,
            userEmail: userEmail
        };

        // Hanya tambahkan password jika tidak kosong
        if (password.trim() !== "") {
            data.password = password;
        }

        $.ajax({
            type: "POST",
            url: baseUrl + '/data/admin/update',
            data: data,
            success: function(response) {
                hideLoading();

            },

        });

        return false;
    }
</script>

<script>
    $(document).ready(function() {
        // Tampilkan pesan sukses jika ada
        <?php if (session()->getFlashdata('success')) : ?>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '<?= session()->getFlashdata('success') ?>',
                timer: 3000, // Notifikasi akan hilang otomatis setelah 3 detik
                showConfirmButton: false
            });
        <?php endif; ?>

        // Tampilkan pesan error jika ada
        <?php if (session()->getFlashdata('errors')) : ?>
            <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: '<?= $error ?>',
                    timer: 10000, // Notifikasi akan hilang otomatis setelah 5 detik
                    showConfirmButton: false
                });
            <?php endforeach; ?>
        <?php endif; ?>
    });
</script>