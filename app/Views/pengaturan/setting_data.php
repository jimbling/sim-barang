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
                                            <!-- Form fields for other data -->
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
                                            <!-- Form fields for other data -->
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
                                        <!-- Form fields for other data -->
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
                                <!-- Form fields for other data -->
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
                                                    <!-- Tambah modal untuk edit di sini -->
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
    <!-- Modal untuk edit -->
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
                    <form id="editAKun" method="post" action="/data/akun/update">

                        <div class="form-group row">
                            <label for="editNama" class="col-sm-4 col-form-label">Nama</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="editNama" name="full_nama" value="<?= $akun['full_nama']; ?>">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="editUserNama" class="col-sm-4 col-form-label">Username</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="editUserNama" name="user_nama" value="<?= $akun['user_nama']; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="editUserPass" class="col-sm-4 col-form-label">Password</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="editUserPass" name="user_password">
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
</script>
<script src="../../assets/dist/js/edit.js"></script>

<?php echo view('tema/footer.php'); ?>

<script>
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
        var id = document.getElementById('edit-button-' + id).getAttribute('data-id');
        var full_nama = document.getElementById('editNama').value;
        var user_nama = document.getElementById('editUserNama').value;
        var user_password = document.getElementById('editUserPass').value;
        showLoadingProses();

        // Kirim data ke controller dengan Ajax
        $.ajax({
            type: "POST",
            url: '/data/akun/update',
            data: {
                id: id,
                full_nama: full_nama,
                user_nama: user_nama,
                user_password: user_password
            },
            success: function(response) {
                // Handle response dari controller
                if (response.status === 'success') {
                    hideLoading();
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses',
                        text: response.message,
                    });

                    // Redirect setelah pesan ditampilkan
                    window.location.href = '/data/pengaturan';
                } else {
                    hideLoading();
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: response.message,
                    });
                }
            },
            error: function(xhr, textStatus, errorThrown) {
                // Tangani kesalahan jika ada
                console.error(xhr.responseText);
                hideLoading();
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Terjadi kesalahan saat mengirim permintaan.',
                });
            }
        });

        return false; // Mencegah formulir dikirim secara tradisional
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- KOP SURAT -->

<script>
    // Fungsi untuk menampilkan gambar previ saat gambar dipilih
    function showPreviewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#previewImage').attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }

        // Menampilkan nama file yang dipilih
        var fileName = input.files[0].name;
        $('#selectedFileName').text(fileName);
    }

    // Memanggil fungsi showPreviewImage saat input file berubah
    $('#customFile').change(function() {
        showPreviewImage(this);
    });
</script>
<script>
    const customFileInput = document.querySelector("#customFile");
    const previewImage = document.querySelector("#previewImage");

    customFileInput.addEventListener("change", function() {
        if (this.files.length > 0) {
            previewImage.style.display = "block";
        } else {
            previewImage.style.display = "none";
        }
    });
</script>


<script>
    // Function to show loading
    function showLoading() {
        let timerInterval
        Swal.fire({
            title: 'Memproses upload...',
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

    // Function to hide loading
    function hideLoading() {
        Swal.close();
    }

    document.addEventListener("DOMContentLoaded", function() {
        const fileInput = document.querySelector("input[name='kop_surat']");
        const submitButton = document.querySelector("button[type='submit']");
        const selectedFileName = document.querySelector("#selectedFileName");
        const previewImage = document.querySelector("#previewImage");

        fileInput.addEventListener("change", function() {
            const allowedExtensions = ['jpg', 'jpeg', 'png', 'svg'];
            const fileName = this.files[0].name;
            const fileExtension = fileName.split('.').pop().toLowerCase();

            if (allowedExtensions.includes(fileExtension)) {
                selectedFileName.textContent = fileName;
                previewImage.style.display = "block";
                previewImage.src = URL.createObjectURL(this.files[0]);
                submitButton.disabled = false;
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Jenis File Tidak Diijinkan!",
                    text: "Anda hanya dapat mengimpor file dengan ekstensi .jpg, .jpeg, .png, atau .svg."
                });
                this.value = ''; // Clear the file input
                selectedFileName.textContent = "Pilih File Foto";
                previewImage.style.display = "none";
                submitButton.disabled = true;
            }
        });

        // Prevent default form submission and show loading when file successfully uploaded
        submitButton.addEventListener("click", function(event) {
            event.preventDefault(); // Prevent default form submission
            if (!fileInput.files || !fileInput.files.length) {
                return;
            }
            const fileName = fileInput.files[0].name;
            const allowedExtensions = ['jpg', 'jpeg', 'png', 'svg'];
            const fileExtension = fileName.split('.').pop().toLowerCase();

            if (allowedExtensions.includes(fileExtension)) {
                showLoading(); // Show loading
                // Submit the form after some time (you can adjust the time as needed)
                setTimeout(function() {
                    submitButton.form.submit();
                }, 2000); // Example: submit the form after 2 seconds (2000 milliseconds)
            }
        });
    });
</script>

<!-- END KOP SURAT -->

<!-- UPLOAD LOGO -->
<script>
    // Fungsi untuk menampilkan gambar previ saat gambar dipilih
    function showPreviewLogo(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#previewLogo').attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }

        // Menampilkan nama file yang dipilih
        var fileName = input.files[0].name;
        $('#selectedFileLogo').text(fileName);
    }

    // Memanggil fungsi showPreviewImage saat input file berubah
    $('#customFile').change(function() {
        showPreviewImage(this);
    });
</script>
<script>
    const customFileLogo = document.querySelector("#customFile");
    const previewLogo = document.querySelector("#previewLogo");

    customFileInput.addEventListener("change", function() {
        if (this.files.length > 0) {
            previewImage.style.display = "block";
        } else {
            previewImage.style.display = "none";
        }
    });
</script>


<script>
    // Function to show loading
    function showLoading() {
        let timerInterval
        Swal.fire({
            title: 'Memproses upload...',
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

    // Function to hide loading
    function hideLoading() {
        Swal.close();
    }

    document.addEventListener("DOMContentLoaded", function() {
        const fileInput = document.querySelector("input[name='logo']");
        const submitButton = document.querySelector("button[type='submit']");
        const selectedFileLogo = document.querySelector("#selectedFileLogo");
        const previewImage = document.querySelector("#previewLogo");

        fileInput.addEventListener("change", function() {
            const allowedExtensions = ['jpg', 'jpeg', 'png', 'svg'];
            const fileName = this.files[0].name;
            const fileExtension = fileName.split('.').pop().toLowerCase();

            if (allowedExtensions.includes(fileExtension)) {
                selectedFileLogo.textContent = fileName;
                previewImage.style.display = "block";
                previewImage.src = URL.createObjectURL(this.files[0]);
                submitButton.disabled = false;
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Jenis File Tidak Diijinkan!",
                    text: "Anda hanya dapat mengimpor file dengan ekstensi .jpg, .jpeg, .png, atau .svg."
                });
                this.value = ''; // Clear the file input
                selectedFileLogo.textContent = "Pilih File Foto";
                previewImage.style.display = "none";
                submitButton.disabled = true;
            }
        });

        // Prevent default form submission and show loading when file successfully uploaded
        submitButton.addEventListener("click", function(event) {
            event.preventDefault(); // Prevent default form submission
            if (!fileInput.files || !fileInput.files.length) {
                return;
            }
            const fileName = fileInput.files[0].name;
            const allowedExtensions = ['jpg', 'jpeg', 'png', 'svg'];
            const fileExtension = fileName.split('.').pop().toLowerCase();

            if (allowedExtensions.includes(fileExtension)) {
                showLoading(); // Show loading
                // Submit the form after some time (you can adjust the time as needed)
                setTimeout(function() {
                    submitButton.form.submit();
                }, 2000); // Example: submit the form after 2 seconds (2000 milliseconds)
            }
        });
    });
</script>
<!-- END UPLOAD LOGO -->

<!-- UPLOAD FAVICON -->
<script>
    // Fungsi untuk menampilkan gambar previ saat gambar dipilih
    function showPreviewLogo(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#previewFavicon').attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }

        // Menampilkan nama file yang dipilih
        var fileName = input.files[0].name;
        $('#selectedFileFavicon').text(fileName);
    }

    // Memanggil fungsi showPreviewImage saat input file berubah
    $('#customFile').change(function() {
        showPreviewImage(this);
    });
</script>
<script>
    const customFileFavicon = document.querySelector("#customFile");
    const previewFavicon = document.querySelector("#previewFavicon");

    customFileInput.addEventListener("change", function() {
        if (this.files.length > 0) {
            previewImage.style.display = "block";
        } else {
            previewImage.style.display = "none";
        }
    });
</script>


<script>
    // Function to show loading
    function showLoading() {
        let timerInterval
        Swal.fire({
            title: 'Memproses upload...',
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

    // Function to hide loading
    function hideLoading() {
        Swal.close();
    }

    document.addEventListener("DOMContentLoaded", function() {
        const fileInput = document.querySelector("input[name='favicon']");
        const submitButton = document.querySelector("button[type='submit']");
        const selectedFileFavicon = document.querySelector("#selectedFileFavicon");
        const previewImage = document.querySelector("#previewFavicon");

        fileInput.addEventListener("change", function() {
            const allowedExtensions = ['ico'];
            const fileName = this.files[0].name;
            const fileExtension = fileName.split('.').pop().toLowerCase();

            if (allowedExtensions.includes(fileExtension)) {
                selectedFileFavicon.textContent = fileName;
                previewImage.style.display = "block";
                previewImage.src = URL.createObjectURL(this.files[0]);
                submitButton.disabled = false;
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Jenis File Tidak Diijinkan!",
                    text: "Anda hanya dapat mengimpor file dengan ekstensi .ico"
                });
                this.value = ''; // Clear the file input
                selectedFileFavicon.textContent = "Pilih File Favicon";
                previewImage.style.display = "none";
                submitButton.disabled = true;
            }
        });

        // Prevent default form submission and show loading when file successfully uploaded
        submitButton.addEventListener("click", function(event) {
            event.preventDefault(); // Prevent default form submission
            if (!fileInput.files || !fileInput.files.length) {
                return;
            }
            const fileName = fileInput.files[0].name;
            const allowedExtensions = ['ico'];
            const fileExtension = fileName.split('.').pop().toLowerCase();

            if (allowedExtensions.includes(fileExtension)) {
                showLoading(); // Show loading
                // Submit the form after some time (you can adjust the time as needed)
                setTimeout(function() {
                    submitButton.form.submit();
                }, 2000); // Example: submit the form after 2 seconds (2000 milliseconds)
            }
        });
    });
</script>
<!-- END UPLOAD FAVICON -->

<!-- UPLOAD LOGO BANK -->
<script>
    // Fungsi untuk menampilkan gambar previ saat gambar dipilih
    function showPreviewBank(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#previewBank').attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }

        // Menampilkan nama file yang dipilih
        var fileName = input.files[0].name;
        $('#selectedFileBank').text(fileName);
    }

    // Memanggil fungsi showPreviewImage saat input file berubah
    $('#customFile').change(function() {
        showPreviewImage(this);
    });
</script>
<script>
    const customFileBank = document.querySelector("#customFile");
    const previewBank = document.querySelector("#previewBank");

    customFileInput.addEventListener("change", function() {
        if (this.files.length > 0) {
            previewImage.style.display = "block";
        } else {
            previewImage.style.display = "none";
        }
    });
</script>


<script>
    // Function to show loading
    function showLoading() {
        let timerInterval
        Swal.fire({
            title: 'Memproses upload...',
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

    // Function to hide loading
    function hideLoading() {
        Swal.close();
    }

    document.addEventListener("DOMContentLoaded", function() {
        const fileInput = document.querySelector("input[name='logo_bank']");
        const submitButton = document.querySelector("button[type='submit']");
        const selectedFileBank = document.querySelector("#selectedFileBank");
        const previewImage = document.querySelector("#previewBank");

        fileInput.addEventListener("change", function() {
            const allowedExtensions = ['jpg', 'jpeg', 'png', 'svg'];
            const fileName = this.files[0].name;
            const fileExtension = fileName.split('.').pop().toLowerCase();

            if (allowedExtensions.includes(fileExtension)) {
                selectedFileBank.textContent = fileName;
                previewImage.style.display = "block";
                previewImage.src = URL.createObjectURL(this.files[0]);
                submitButton.disabled = false;
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Jenis File Tidak Diijinkan!",
                    text: "Anda hanya dapat mengimpor file dengan ekstensi .jpg, .jpeg, .png, atau .svg."
                });
                this.value = ''; // Clear the file input
                selectedFileBank.textContent = "Pilih Logo Bank";
                previewImage.style.display = "none";
                submitButton.disabled = true;
            }
        });

        // Prevent default form submission and show loading when file successfully uploaded
        submitButton.addEventListener("click", function(event) {
            event.preventDefault(); // Prevent default form submission
            if (!fileInput.files || !fileInput.files.length) {
                return;
            }
            const fileName = fileInput.files[0].name;
            const allowedExtensions = ['jpg', 'jpeg', 'png', 'svg'];
            const fileExtension = fileName.split('.').pop().toLowerCase();

            if (allowedExtensions.includes(fileExtension)) {
                showLoading(); // Show loading
                // Submit the form after some time (you can adjust the time as needed)
                setTimeout(function() {
                    submitButton.form.submit();
                }, 2000); // Example: submit the form after 2 seconds (2000 milliseconds)
            }
        });
    });
</script>
<!-- END UPLOAD LOGO BANK -->