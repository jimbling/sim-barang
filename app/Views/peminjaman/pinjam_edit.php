<?php echo view('tema/header.php'); ?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h5 class="m-0">Form Peminjaman Barang</h5>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Form Pinjam</li>
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
                                <form action="<?= base_url('peminjaman/proses') ?>" method="post">
                                    <input type="hidden" name="<?= csrf_token() ?>" value="<?= $csrfToken ?>">
                                    <div class="row">
                                        <div class="col-sm">
                                            <div class="col-sm-4">
                                                <strong> # Kode Pinjam: <?= $data_peminjaman['kode_pinjam'] ?> </strong>
                                                <input type="hidden" name="kode_pinjam">

                                            </div>

                                        </div>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-md-6">
                                            <label for="pinjam_nama_peminjam" class="col-6 col-form-label">Nama Peminjam</label>
                                            <div class="col-12">
                                                <select class="form-control select2bs4 form-control-sm" id="pinjam_nama_peminjam" name="nama_peminjam" required>
                                                    <option value="">Pilih Peminjam</option>
                                                    <option selected><?= $data_peminjaman['nama_peminjam']; ?>
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
                                                <select class="form-control select2bs4 form-control-sm" id="pinjam_nama_ruangan" name="nama_ruangan" required>
                                                    <option value="">Pilih Ruangan</option>
                                                    <option selected><?= $data_peminjaman['nama_ruangan']; ?>
                                                        <?php foreach ($data_ruangan as $ruangan) : ?>
                                                    <option value="<?= $ruangan['nama_ruangan'] ?>"><?= $ruangan['nama_ruangan'] ?></option>
                                                <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="pinjam_nama_dosen" class="col-6 col-form-label">Dosen Pengampu</label>
                                            <div class="col-12">
                                                <select class="form-control select2bs4 form-control-sm" id="pinjam_nama_dosen" name="nama_dosen" required>
                                                    <option value="-">Pilih Dosen</option>
                                                    <option selected><?= $data_peminjaman['nama_dosen']; ?>
                                                        <?php foreach ($data_dosen as $dosen) : ?>
                                                    <option value="<?= $dosen['nama_lengkap'] ?>"><?= $dosen['nama_lengkap'] ?></option>
                                                <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <label for="pinjam_keperluan" class="col-12 col-form-label">Penggunaan untuk</label>
                                            <div class="col-12">
                                                <select class="form-control select2bs4 form-control-sm" id="pinjam_keperluan" name="keperluan" required>
                                                    <option value="">Pilih Penggunaan</option>
                                                    <option selected><?= $data_peminjaman['keperluan']; ?>
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
                                                    <option selected><?= $data_peminjaman['nama_pembelajaran']; ?>
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


                                    <div class="col mt-4">
                                        <!-- Pilihan Barang -->
                                        <label for="barang">Pilih Barang:</label>
                                        <select name="barang[]" class="duallistbox form-control-lg" multiple="multiple" required>

                                        </select>

                                        <div class="form-group row mt-5">
                                            <div class="col">

                                                <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                                                    <div class="btn-group mr-2" role="group" aria-label="First group">
                                                        <a class="btn btn-danger" href="/pinjam/daftar" role="button"><i class='fas fa-reply-all spaced-icon'></i>Batal</a>

                                                    </div>
                                                    <div class="btn-group mr-2" role="group" aria-label="Second group">
                                                        <button type="submit" class="btn btn-primary"><i class='fas fa-paper-plane spaced-icon'></i>Pinjam Barang</button>
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
</div>



<aside class="control-sidebar control-sidebar-dark">

    <div class="p-3">
        <h5>Title</h5>
        <p>Sidebar content</p>
    </div>
</aside>
<?php echo view('tema/footer.php'); ?>