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


                        <table class="table table-hover tabel-cetak table-borderless table-sm font">

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


                            </tbody>
                        </table>
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



            </div>


        </div>
        <div class="card shadow card-danger card-outline">
            <div class="card-body">
                <table class="table table-sm table-borderless">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama File .sql</th>
                            <th>Tanggal Backup</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($backup_db as $backup) : ?>
                            <tr>
                                <th class="text-center" scope="row" style="vertical-align: middle; font-size: 14px;"><?= $i++; ?></th>
                                <td><?= $backup['nama_file']; ?></td>
                                <td><?= $backup['created_at']; ?></td>
                                <td>
                                    <a class="btn btn-success btn-sm" href="<?= base_url('/backup/unduh/' . $backup['nama_file']); ?>" role="button" data-toggle="tooltip" data-placement="top" title="Unduh Backup .sql">
                                        <i class="fas fa-download"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                    </tbody>
                </table>
                <a id="backupBtn" class="btn btn-primary" href="/backup" role="button">Buat Cadangan Database .sql</a>
                <p><strong>Pemeliharaan :</strong> Silahkan untuk rutin melakukan backup database dan menyimpan pada tempat yang aman.
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
        var id = document.getElementById('edit-button-' + id).getAttribute('data-id');
        var full_nama = document.getElementById('editNama').value;
        var user_nama = document.getElementById('editUserNama').value;
        var user_password = document.getElementById('editUserPass').value;
        showLoading();

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

<script>
    // Fungsi yang dijalankan saat halaman diload
    window.addEventListener('load', function() {
        // Sembunyikan tombol Update dan Batal saat halaman diload
        document.getElementById('updateButton').style.display = 'none';
        document.getElementById('batalButton').style.display = 'none';
    });

    document.getElementById('editButton').addEventListener('click', function() {
        event.preventDefault(); // Menghentikan default behavior dari tombol submit
        // Hapus atribut readonly dari elemen input yang diinginkan
        document.getElementById('nama_kampus').removeAttribute('readonly');
        document.getElementById('website').removeAttribute('readonly');
        document.getElementById('alamat').removeAttribute('readonly');

        document.getElementById('nama_direktur').removeAttribute('readonly');
        document.getElementById('ttd_1').removeAttribute('readonly');
        document.getElementById('nik_dir').removeAttribute('readonly');

        document.getElementById('ttd_4').removeAttribute('readonly');
        document.getElementById('nama_ttd_4').removeAttribute('readonly');
        document.getElementById('id_ttd_4').removeAttribute('readonly');

        document.getElementById('ttd_3').removeAttribute('readonly');
        document.getElementById('nama_ttd_3').removeAttribute('readonly');
        document.getElementById('id_ttd_3').removeAttribute('readonly');

        document.getElementById('ttd_2').removeAttribute('readonly');
        document.getElementById('nama_laboran').removeAttribute('readonly');
        document.getElementById('nik_laboran').removeAttribute('readonly');


        // (Tambahkan kode serupa untuk elemen input lainnya)

        // Tampilkan tombol Batal dan Update
        document.getElementById('batalButton').style.display = 'block';
        document.getElementById('updateButton').style.display = 'block';
        // Sembunyikan tombol Edit
        this.style.display = 'none';
    });

    document.getElementById('batalButton').addEventListener('click', function() {
        // Tambahkan atribut readonly ke elemen input yang diinginkan
        document.getElementById('nama_kampus').setAttribute('readonly', true);
        document.getElementById('website').setAttribute('readonly', true);
        document.getElementById('alamat').setAttribute('readonly', true);

        document.getElementById('nama_direktur').setAttribute('readonly', true);
        document.getElementById('ttd_1').setAttribute('readonly', true);
        document.getElementById('nik_dir').setAttribute('readonly', true);

        document.getElementById('ttd_4').setAttribute('readonly', true);
        document.getElementById('nama_ttd_4').setAttribute('readonly', true);
        document.getElementById('id_ttd_4').setAttribute('readonly', true);

        document.getElementById('ttd_3').setAttribute('readonly', true);
        document.getElementById('nama_ttd_3').setAttribute('readonly', true);
        document.getElementById('id_ttd_3').setAttribute('readonly', true);

        document.getElementById('ttd_2').setAttribute('readonly', true);
        document.getElementById('nama_laboran').setAttribute('readonly', true);
        document.getElementById('nik_laboran').setAttribute('readonly', true);


        // (Tambahkan kode serupa untuk elemen input lainnya)

        // Tampilkan tombol Edit
        document.getElementById('editButton').style.display = 'block';
        // Sembunyikan tombol Update dan Batal
        document.getElementById('updateButton').style.display = 'none';
        this.style.display = 'none';
    });

    document.getElementById('updateButton').addEventListener('click', function() {
        // Tambahkan atribut readonly ke elemen input yang diinginkan
        document.getElementById('nama_kampus').setAttribute('readonly', true);
        document.getElementById('website').setAttribute('readonly', true);
        document.getElementById('alamat').setAttribute('readonly', true);

        document.getElementById('nama_direktur').setAttribute('readonly', true);
        document.getElementById('ttd_1').setAttribute('readonly', true);
        document.getElementById('nik_dir').setAttribute('readonly', true);

        document.getElementById('ttd_4').setAttribute('readonly', true);
        document.getElementById('nama_ttd_4').setAttribute('readonly', true);
        document.getElementById('id_ttd_4').setAttribute('readonly', true);

        document.getElementById('ttd_3').setAttribute('readonly', true);
        document.getElementById('nama_ttd_3').setAttribute('readonly', true);
        document.getElementById('id_ttd_3').setAttribute('readonly', true);

        document.getElementById('ttd_2').setAttribute('readonly', true);
        document.getElementById('nama_laboran').setAttribute('readonly', true);
        document.getElementById('nik_laboran').setAttribute('readonly', true);


        // (Tambahkan kode serupa untuk elemen input lainnya)

        // Tampilkan tombol Edit
        document.getElementById('editButton').style.display = 'block';
        // Sembunyikan tombol Update dan Batal
        document.getElementById('updateButton').style.display = 'none';
        document.getElementById('batalButton').style.display = 'none';
    });
</script>

<script>
    document.getElementById('updateButton').addEventListener('click', function() {
        // Ambil data dari formulir
        var nama_kampus = document.getElementById('nama_kampus').value;
        var website = document.getElementById('website').value;
        var alamat = document.getElementById('alamat').value;

        var nama_direktur = document.getElementById('nama_direktur').value;
        var nik_dir = document.getElementById('nik_dir').value;
        var ttd_1 = document.getElementById('ttd_1').value;

        var ttd_2 = document.getElementById('ttd_2').value;
        var nama_laboran = document.getElementById('nama_laboran').value;
        var nik_laboran = document.getElementById('nik_laboran').value;

        var ttd_4 = document.getElementById('ttd_4').value;
        var nama_ttd_4 = document.getElementById('nama_ttd_4').value;
        var id_ttd_4 = document.getElementById('id_ttd_4').value;

        var ttd_3 = document.getElementById('ttd_3').value;
        var nama_ttd_3 = document.getElementById('nama_ttd_3').value;
        var id_ttd_3 = document.getElementById('id_ttd_3').value;




        // Log data yang akan dikirim ke konsol
        console.log('Data yang akan dikirim:', {
            nama_kampus: nama_kampus,
            website: website,
            alamat: alamat,

            nama_direktur: nama_direktur,
            nik_dir: nik_dir,
            ttd_1: ttd_1,

            nama_laboran: nama_laboran,
            ttd_2: ttd_2,
            nik_laboran: nik_laboran,

            ttd_4: ttd_4,
            nama_ttd_4: nama_ttd_4,
            id_ttd_4: id_ttd_4,

            ttd_3: ttd_3,
            nama_ttd_3: nama_ttd_3,
            id_ttd_3: id_ttd_3,



        });

        // Buat objek data yang akan dikirimkan melalui AJAX
        var data = {
            nama_kampus: nama_kampus,
            website: website,
            alamat: alamat,

            nama_direktur: nama_direktur,
            nik_dir: nik_dir,
            ttd_1: ttd_1,

            nama_laboran: nama_laboran,
            ttd_2: ttd_2,
            nik_laboran: nik_laboran,

            ttd_4: ttd_4,
            nama_ttd_4: nama_ttd_4,
            id_ttd_4: id_ttd_4,

            ttd_3: ttd_3,
            nama_ttd_3: nama_ttd_3,
            id_ttd_3: id_ttd_3,
        };
        // Tampilkan loading sebelum mengirimkan data
        showLoading();

        // Kirim data ke controller menggunakan AJAX
        fetch('<?= base_url('/pengaturan/update') ?>', {
                method: 'POST',
                body: JSON.stringify(data),
                headers: {
                    'Content-Type': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                // Sembunyikan loading setelah mendapatkan respons dari server
                hideLoading();

                // Handle respons dari server jika diperlukan
                console.log('Respons dari server:', data);

                // Tampilkan SweetAlert sukses dengan timer 5000 milidetik (5 detik)
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Data berhasil dirubah.',
                    icon: 'success',
                    timer: 3000, // Durasi tampilan dalam milidetik (misalnya, 5000 milidetik = 5 detik)
                    showConfirmButton: false, // Sembunyikan tombol OK (jika tidak diinginkan)
                }).then(() => {
                    // Arahkan pengguna ke halaman baru setelah SweetAlert ditutup
                    window.location.replace("/data/pengaturan");
                });
            })
            .catch(error => {
                // Sembunyikan loading jika terjadi kesalahan
                hideLoading();

                console.error('Error:', error);

                // Tampilkan SweetAlert sukses dengan jeda waktu 2000 milidetik (2 detik)
                setTimeout(function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses',
                        text: 'Data berhasil diperbarui',
                    });
                }, 2000);
            });
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
                    text: 'Nama File: ' + data.nama_file,
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
            title: 'membackup database ....',
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