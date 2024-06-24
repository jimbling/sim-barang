<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Sistem Informasi Managemen Pengelolaan, Penggunaan Barang Laboratorium Keperawatan.">
    <title><?= $judul; ?></title>

    <link rel="stylesheet" href="../../assets/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../../assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../../assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="../../assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="../../assets/dist/css/adminlte.min.css?v=3.2.0">
    <link rel="stylesheet" href="../../assets/dist/css/style-2.css">
    <link rel="stylesheet" href="../../assets/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="../../assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <link rel="stylesheet" href="../../assets/plugins/summernote/summernote-bs4.min.css">
    <link rel="stylesheet" href="../../assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <link rel="stylesheet" href="../../assets/plugins/toastr/toastr.min.css">
    <link rel="stylesheet" href="../../assets/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
    <link rel="stylesheet" href="../../assets/plugins/bs-stepper/css/bs-stepper.min.css">


</head>
<?php

use App\Services\PengaturanService;

$pengaturanService = new PengaturanService();

$data_pengaturan = $pengaturanService->getNamaKampus();
$nama_kampus = $data_pengaturan['nama_kampus'];
$logo = $data_pengaturan['logo'];

?>

<body class="bg-light">

    <div class="container">
        <div class="py-5 text-center">
            <img class="d-block mx-auto mb-4" src="../../assets/dist/img/<?= $logo; ?>" alt="" width="100" height="100">
            <h2>Form Peminjaman Oleh Pihak Luar</h2>
            <p class="lead">Form dibawah ini adalah formulir peminjaman barang laboratorium keperawatan oleh pihak luar. Silahkan mengisi data peminjaman sesuai kebutuhan, untuk selanjutnya data peminjaman tersebut akan diperiksa oleh Laboran.
            </p>
        </div>

        <div class="row">
            <div class="col-md-12 order-md-1">
                <h4 class="mb-3">Data Peminjam</h4>
                <form class="needs-validation" novalidate action="/pihakluar/simpan" method="post" enctype="multipart/form-data" id="tambahPinjamPihakLuar">
                    <input type="hidden" name="<?= csrf_token() ?>" value="<?= $csrfToken ?>">
                    <div class="row">

                        <div class="col-md-4 mb-3">
                            <label for="kode_pinjam">Kode Pinjam</label>
                            <input type="text" class="form-control" id="kode_pinjam" placeholder="" value="<?= $kode_pinjam ?>" name="kode_pinjam" required readonly>
                            <input type="hidden" name="kode_pinjam" value="<?= $kode_pinjam ?>">
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="nama_peminjam">Nama Peminjam</label>
                            <input type="text" class="form-control" id="nama_peminjam" placeholder="" value="" name="nama_peminjam" required>
                            <div class="invalid-feedback">
                                Nama peminjam harus diisi.
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="no_telp">No. Telp</label>
                            <input type="text" class="form-control" id="no_telp" placeholder="" value="" name="no_telp" required>
                            <div class="invalid-feedback">
                                Alamat harus diisi.
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="email">Email</label>
                            <input type="text" class="form-control" id="email" placeholder="" value="" name="email" required>
                            <div class="invalid-feedback">
                                Alamat harus diisi.
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nama_instansi">Nama Instansi</label>
                            <input type="text" class="form-control" id="nama_instansi" placeholder="" value="" name="nama_instansi" required>
                            <div class="invalid-feedback">
                                Nama peminjam harus diisi.
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="alamat_instansi">Alamat Instansi</label>
                            <textarea class="form-control" id="alamat_instansi" placeholder="" value="" name="alamat_instansi" required></textarea>
                            <div class="invalid-feedback">
                                Alamat harus diisi.
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="tanggal_penerimaan">Tanggal Pinjam</label>

                            <div class="input-group date" id="tanggalPinjam" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" data-target="#tanggalPinjam" name="tanggal_pinjam" required />
                                <div class="input-group-append" data-target="#tanggalPinjam" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                                <div class="invalid-feedback">
                                    Tanggal pinjam harus diisi.
                                </div>
                            </div>

                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="tanggal_penerimaan">Tanggal Kembali</label>

                            <div class="input-group date" id="tanggalKembali" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" data-target="#tanggalKembali" name="tanggal_kembali" required />
                                <div class="input-group-append" data-target="#tanggalKembali" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                                <div class="invalid-feedback">
                                    Pilih minimal satu barang.
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col mt-4">
                        <label for="barang">Pilih Barang:</label>
                        <select name="barang[]" class="duallistbox" multiple="multiple" required>
                            <?php foreach ($data_barang as $barang) : ?>
                                <option value="<?= $barang['id'] ?>"><?= $barang['nama_barang'] ?> - <?= 'Rp. ' . number_format($barang['harga_sewa'], 0, ',', '.') ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <br>
                    <div class="col">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3 border-left-primary">
                                <h6 class="m-0 font-weight-bold text-primary">Upload Surat Permohonan Alat</h6>
                            </div>
                            <div class="card-body">

                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="surat_permohonan_alat" id="customFile" required>
                                            <label class="custom-file-label" for="selectedFileName" id="selectedFileName">Pilih File Surat Permohonan Alat (.pdf) </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="container-fluid mb-3">
                                    <img id="previewImage" src="#" alt="Preview Image" style="max-width: 500px; max-height: 500px; display: none;">
                                </div>

                            </div>
                        </div>


                    </div>




                    <hr class="mb-4">
                    <button class="btn btn-primary btn-lg btn-block" type="submit" onclick="submitForm()">Ajukan Peminjaman Barang</button>
                </form>
            </div>
        </div>

        <footer class="my-5 pt-5 text-muted text-center text-small">
            <strong>Copyright &copy; 2023-<?= $currentYear; ?> <a href="https://www.akperykyjogja.ac.id/home">Akper "YKY" Yogyakarta</a>.</strong> SIM Peminjaman Alat Laboratorium Keperawatan
        </footer>
    </div>




    <script src="../../assets/plugins/jquery/jquery.min.js"></script>
    <script src="../../assets/dist/js/form-validation.js"></script>
    <script src="../../assets/plugins/select2/js/select2.full.min.js"></script>
    <script src="../../assets/plugins/select2/js/select2.min.js"></script>
    <script src="../../assets/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
    <script src="../../assets/plugins/moment/moment.min.js"></script>
    <script src="../../assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <script src="../../assets/dist/sweet/sweetalert2.all.min.js"></script>
    <script src="../../assets/dist/js/frontend-js/pihakLuar.js"></script>

</body>

</html>