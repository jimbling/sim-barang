<?php echo view('tema/header.php'); ?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h5 class="m-0">Form Booking Alat Laboratorium Keperawatan</h5>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <div class="col-md-12 col-12">
                            <a href="/reservasi" class="btn btn-danger btn-sm"> <i class='fas fa-undo-alt spaced-icon'></i>Kembali</a>
                            </a>
                        </div>
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
                        <div class="container">

                            <div class="card-body">
                                <form action="<?= base_url('reservasi/simpan') ?>" method="post">
                                    <input type="hidden" name="<?= csrf_token() ?>" value="<?= $csrfToken ?>">
                                    <div class="row">
                                        <div class="col-sm">
                                            <div class="col-sm-4">
                                                <strong> # Kode Reservasi: <?= $kode_reservasi ?> </strong>
                                                <input type="hidden" name="kode_reservasi" value="<?= $kode_reservasi ?>">

                                            </div>

                                        </div>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-md-6">
                                            <label for="pinjam_nama_peminjam" class="col-6 col-form-label">Nama Peminjam</label>
                                            <div class="col-12">
                                                <select class="form-control select2bs4 form-control-sm" id="pinjam_nama_peminjam" name="nama_peminjam">
                                                    <option value="">Pilih Peminjam</option>
                                                    <?php foreach ($data_mahasiswa as $mahasiswa) : ?>
                                                        <option value="<?= $mahasiswa['nim'] ?>-<?= $mahasiswa['nama_lengkap'] ?>"><?= $mahasiswa['nim'] ?>-<?= $mahasiswa['nama_lengkap'] ?></option>
                                                    <?php endforeach; ?>
                                                    <?php foreach ($data_dosen_tendik as $dosenTendik) : ?>
                                                        <option value="<?= $dosenTendik['nik'] ?>-<?= $dosenTendik['nama_lengkap'] ?>"><?= $dosenTendik['nik'] ?>-<?= $dosenTendik['nama_lengkap'] ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="pinjam_nama_ruangan" class="col-6 col-form-label">Nama Ruangan</label>
                                            <div class="col-12">
                                                <select class="form-control select2bs4 form-control-sm" id="pinjam_nama_ruangan" name="nama_ruangan">
                                                    <option value="">Pilih Ruangan</option>
                                                    <?php foreach ($data_ruangan as $ruangan) : ?>
                                                        <option value="<?= $ruangan['nama_ruangan'] ?>"><?= $ruangan['nama_ruangan'] ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">

                                            <label for="pinjam_nama_dosen" class="col-12 col-form-label">
                                                Dosen Pengampu <small class="text-bold text-success">(Optional)</small>
                                            </label>
                                            <div class="col-12">
                                                <select class="form-control select2bs4 form-control-sm" id="pinjam_nama_dosen" name="nama_dosen">
                                                    <option value="-">Pilih Dosen</option>
                                                    <?php foreach ($data_dosen as $dosen) : ?>
                                                        <option value="<?= $dosen['nama_lengkap'] ?>"><?= $dosen['nama_lengkap'] ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <label for="pinjam_keperluan" class="col-12 col-form-label">Penggunaan untuk</label>
                                            <div class="col-12">
                                                <select class="form-control select2bs4 form-control-sm" id="pinjam_keperluan" name="keperluan">
                                                    <option value="">Pilih Penggunaan</option>
                                                    <?php foreach ($data_penggunaan as $penggunaan) : ?>
                                                        <option value="<?= $penggunaan['penggunaan'] ?>"><?= $penggunaan['penggunaan'] ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Tambahkan form select kedua -->
                                        <div class="col-md-4 col-12" id="form-pembelajaran" style="display:none;">
                                            <label for="satuan" class="col-12 col-form-label">Pilih Pembelajaran</label>
                                            <div class="col-12">
                                                <select class="form-control select2bs4 form-control-sm" id="pembelajaran" name="pembelajaran" disabled>
                                                    <option value="">Pilih Pembelajaran</option>
                                                    <?php foreach ($data_pembelajaran as $pembelajaran) : ?>
                                                        <option value="<?= $pembelajaran['nama_pembelajaran'] ?>"><?= $pembelajaran['nama_pembelajaran'] ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>

                                    </div>

                                    <!-- Tambahkan script JavaScript -->
                                    <script src="../../assets/dist/js/jquery-3.6.4.min.js"></script>

                                    <script>
                                        $(document).ready(function() {
                                            const keperluanSelect = $('#pinjam_keperluan');
                                            const formPembelajaran = $('#form-pembelajaran');
                                            const pembelajaranSelect = $('#pembelajaran');

                                            keperluanSelect.change(function() {
                                                const selectedValue = $(this).val();
                                                if (selectedValue === 'Praktek Pembelajaran') {
                                                    formPembelajaran.show();
                                                    pembelajaranSelect.prop('disabled', false); // Aktifkan form pembelajaran
                                                } else {
                                                    formPembelajaran.hide();
                                                    pembelajaranSelect.prop('disabled', true); // Nonaktifkan form pembelajaran
                                                }
                                            });

                                            // Inisialisasi form select kedua
                                            pembelajaranSelect.hide();
                                            pembelajaranSelect.prop('disabled', true); // Nonaktifkan form pembelajaran awal
                                        });
                                    </script>


                                    <div class="row">
                                        <div class="col-md-4">

                                            <label for="tanggal_penggunaa" class="col-12 col-form-label">
                                                Tanggal Penggunaan
                                            </label>
                                            <div class="col-12">
                                                <div class="input-group date" id="reservationdatetime" data-target-input="nearest">
                                                    <input type="text" class="form-control datetimepicker-input" data-target="#reservationdatetime" name="tanggal_penggunaan" />
                                                    <div class="input-group-append" data-target="#reservationdatetime" data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                    </div>
                                                </div>
                                                <small class="text-bold text-success"> AM: 00:00-11:59 | PM: 12:00-23:59</small>
                                            </div>
                                        </div>
                                        <div class="col-md-4">

                                            <label for="tanggal_penggunaa" class="col-12 col-form-label">
                                                Tanggal Pengembalian
                                            </label>
                                            <div class="col-12">
                                                <div class="input-group date" id="reservationkembali" data-target-input="nearest">
                                                    <input type="text" class="form-control datetimepicker-input" data-target="#reservationkembali" name="tanggal_pengembalian" />
                                                    <div class="input-group-append" data-target="#reservationkembali" data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                    </div>
                                                </div>
                                                <small class="text-bold text-success"> AM: 00:00-11:59 | PM: 12:00-23:59</small>
                                            </div>
                                        </div>



                                    </div>


                                    <div class="col mt-4">
                                        <!-- Pilihan Barang -->
                                        <label for="barang">Pilih Barang:</label>
                                        <select name="barang[]" class="duallistbox form-control-lg" multiple="multiple">
                                            <?php foreach ($data_barang as $barang) : ?>
                                                <option value="<?= $barang['id'] ?>"><?= $barang['nama_barang'] ?> - <?= $barang['kode_barang'] ?></option>
                                            <?php endforeach; ?>
                                        </select>

                                        <div class="form-group row mt-5">
                                            <div class="col">

                                                <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                                                    <div class="btn-group mr-2" role="group" aria-label="First group">
                                                        <a class="btn btn-danger" href="/pinjam/daftar" role="button"><i class='fas fa-reply-all spaced-icon'></i>Batal</a>

                                                    </div>
                                                    <div class="btn-group mr-2" role="group" aria-label="Second group">
                                                        <button type="submit" class="btn btn-primary"><i class='fas fa-paper-plane spaced-icon'></i>Booking Barang</button>
                                                    </div>
                                                </div>
                                            </div>
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
</div>




<aside class="control-sidebar control-sidebar-dark">

    <div class="p-3">
        <h5>Title</h5>
        <p>Sidebar content</p>
    </div>
</aside>


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

    $(document).ready(function() {
        // Menangani tombol submit pada formulir
        $("form").submit(function(event) {
            event.preventDefault(); // Mencegah formulir untuk dikirim secara default

            // Validasi pinjam_nama_peminjam
            var namaPeminjam = $("#pinjam_nama_peminjam").val();
            if (namaPeminjam === '') {
                toastr.error('Nama Peminjam harus diisi!');
                return; // Berhenti jika validasi gagal
            }

            // Validasi pinjam_nama_ruangan
            var namaRuangan = $("#pinjam_nama_ruangan").val();
            if (namaRuangan === '') {
                toastr.error('Nama Ruangan harus diisi!');
                return; // Berhenti jika validasi gagal
            }

            // Validasi pinjam_keperluan
            var keperluan = $("#pinjam_keperluan").val();
            if (keperluan === '') {
                toastr.error('Penggunaan/Keperluan harus diisi!');
                return; // Berhenti jika validasi gagal
            }

            // Validasi pinjam_keperluan
            var tanggal_penggunaan = $("#reservationdatetime").val();
            if (keperluan === '') {
                toastr.error('Tanggal Penggunaan harus diisi!');
                return; // Berhenti jika validasi gagal
            }

            // Validasi pinjam_keperluan
            var tanggal_pengembalian = $("#reservationkembali").val();
            if (keperluan === '') {
                toastr.error('Tanggal Pengembalian harus diisi!');
                return; // Berhenti jika validasi gagal
            }

            // Validasi barang[]
            var selectedBarang = $("select[name='barang[]']").val();
            if (selectedBarang === null || selectedBarang.length === 0) {
                toastr.error('Tambahkan minimal satu barang!');
                return; // Berhenti jika validasi gagal
            }

            showLoading(); // Menampilkan SweetAlert saat formulir dikirim

            // Setelah SweetAlert ditampilkan, izinkan formulir dikirim secara default
            // Anda bisa menambahkan proses penyimpanan ke database di sini
            // Contoh AJAX untuk proses penyimpanan
            $.ajax({
                type: "POST",
                url: $(this).attr("action"),
                data: $(this).serialize(),
                success: function(response) {
                    // Proses penyimpanan selesai, sembunyikan SweetAlert
                    hideLoading();

                    // Tampilkan SweetAlert berhasil
                    Swal.fire({
                        icon: 'success',
                        title: 'Booking Alat berhasil diajukan, tunggu diterima Laboran!',
                        showConfirmButton: false,
                        timer: 1500, // Atur waktu tampil SweetAlert (ms)
                        willClose: () => {
                            // Redirect ke halaman 'pinjam/daftar' setelah SweetAlert ditutup
                            window.location.href = "/reservasi";
                        }
                    });
                },
                error: function(error) {
                    hideLoading();
                    // Handle error
                }
            });
        });
    });
</script>


<?php echo view('tema/footer.php'); ?>